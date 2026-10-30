<?php

namespace App\Http\Controllers;

use App\Http\Requests\InmuebleStoreRequest;
use App\Http\Requests\InmuebleUpdateRequest;
use App\Models\Inmueble;
use App\Services\BarrioService;
use App\Services\InmuebleService;
use App\Services\MunicipioService;
use App\Services\TipoInmuebleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EmpresaInmuebleController extends Controller
{
    public function __construct(
        private InmuebleService $inmuebleService,
        private MunicipioService $municipioService,
        private TipoInmuebleService $tipoInmuebleService,
        private BarrioService $barrioService
    ) {}

    /**
     * Panel principal de la empresa: resumen y listado de sus inmuebles.
     */
    public function index(Request $request): View
    {
        $usuario = $request->user();

        $inmuebles = Inmueble::with(['tipo_inmueble', 'municipio', 'barrio', 'detalle_inmueble', 'imagenes'])
            ->where('id_usuario', $usuario->id)
            ->latest()
            ->paginate(10);

        // Contadores rápidos para la empresa
        $totalInmuebles = Inmueble::where('id_usuario', $usuario->id)->count();
        $disponibles = Inmueble::where('id_usuario', $usuario->id)
            ->whereHas('detalle_inmueble', fn ($q) => $q->where('estado_publicacion', 'disponible'))
            ->count();
        $cerrados = Inmueble::where('id_usuario', $usuario->id)
            ->whereHas('detalle_inmueble', fn ($q) => $q->whereIn('estado_publicacion', ['arrendado', 'vendido']))
            ->count();

        return view('empresa.index', compact(
            'usuario',
            'inmuebles',
            'totalInmuebles',
            'disponibles',
            'cerrados'
        ));
    }

    /**
     * Formulario para que la empresa publique un nuevo inmueble.
     */
    public function create(): View
    {
        $municipios = $this->municipioService->listar();
        $tipo_inmueble = $this->tipoInmuebleService->listar();
        $barrios = $this->barrioService->listar();

        return view('empresa.crear', compact('municipios', 'tipo_inmueble', 'barrios'));
    }

    /**
     * Guarda el inmueble asociándolo automáticamente a la empresa conectada.
     */
    public function store(InmuebleStoreRequest $request): RedirectResponse
    {
        // Seguridad: se asegura de que el inmueble pertenezca al usuario autenticado
        $request->merge([
            'id_usuario' => $request->user()->id,
        ]);

        $this->inmuebleService->crear(
            $request->safe()->except('imagenes'),
            $request->file('imagenes') ?? []
        );

        return redirect()->route('empresa.index')
            ->with('success', '¡Inmueble publicado con éxito!');
    }

    /**
     * Formulario de edición: solo permite editar si el inmueble le pertenece a esta empresa.
     */
    public function edit(int $id, Request $request): View
    {
        $inmueble = Inmueble::with(['detalle_inmueble', 'imagenes'])->findOrFail($id);

        if ($inmueble->id_usuario !== $request->user()->id) {
            abort(403, 'No tienes permiso para modificar este inmueble.');
        }

        $municipios = $this->municipioService->listar();
        $tipo_inmueble = $this->tipoInmuebleService->listar();
        $barrios = $this->barrioService->listar();

        return view('empresa.editar', compact('inmueble', 'municipios', 'tipo_inmueble', 'barrios'));
    }

    /**
     * Actualiza el inmueble verificando la propiedad.
     */
    public function update(int $id, InmuebleUpdateRequest $request): RedirectResponse
    {
        $inmueble = Inmueble::findOrFail($id);

        if ($inmueble->id_usuario !== $request->user()->id) {
            abort(403, 'No tienes permiso para modificar este inmueble.');
        }

        $request->merge([
            'id_usuario' => $request->user()->id,
        ]);

        $this->inmuebleService->actualizar(
            $id,
            $request->safe()->except('imagenes'),
            $request->file('imagenes')
        );

        return redirect()->route('empresa.index')
            ->with('success', 'Inmueble actualizado correctamente.');
    }

    /**
     * Elimina el inmueble verificando la propiedad.
     */
    public function destroy(int $id, Request $request): RedirectResponse
    {
        $inmueble = Inmueble::findOrFail($id);

        if ($inmueble->id_usuario !== $request->user()->id) {
            abort(403, 'No tienes permiso para eliminar este inmueble.');
        }

        $this->inmuebleService->eliminar($id);

        return redirect()->route('empresa.index')
            ->with('success', 'El inmueble ha sido eliminado.');
    }

    /**
     * Cambio rápido de estado (Disponible, Arrendado, Vendido, etc.).
     */
    public function actualizarEstado(int $id, Request $request): RedirectResponse
    {
        $request->validate([
            'estado_publicacion' => ['required', Rule::in(['disponible', 'arrendado', 'vendido', 'reservado', 'inactivo'])],
        ]);

        $inmueble = Inmueble::with('detalle_inmueble')->findOrFail($id);

        if ($inmueble->id_usuario !== $request->user()->id) {
            abort(403, 'No tienes permiso para modificar este inmueble.');
        }

        if ($inmueble->detalle_inmueble) {
            $inmueble->detalle_inmueble->update([
                'estado_publicacion' => $request->estado_publicacion,
            ]);
        }

        return back()->with('success', 'Estado actualizado a ' . ucfirst($request->estado_publicacion));
    }

    /**
     * Actualiza el perfil de la empresa (Nombre, WhatsApp / Teléfono y Dirección).
     */
    public function actualizarPerfil(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'nombre'    => ['required', 'string', 'max:150'],
            'telefono'  => ['nullable', 'string', 'max:30'],
            'direccion' => ['nullable', 'string', 'max:255'],
        ], [
            'nombre.required' => 'El nombre de la empresa es obligatorio.',
            'telefono.max'    => 'El teléfono no puede superar los 30 caracteres.',
        ]);

        $usuario = $request->user();
        $usuario->update([
            'nombre'    => $datos['nombre'],
            'telefono'  => $datos['telefono'] ?? '',
            'direccion' => $datos['direccion'] ?? '',
        ]);

        return redirect()->route('empresa.index')
            ->with('success', '¡Datos de contacto y número de WhatsApp actualizados correctamente!');
    }
}
