<?php

namespace App\Http\Controllers;

use App\Models\Inmueble;
use App\Models\municipio;
use App\Models\tipo_inmueble;
use App\Services\InmuebleService;
use Illuminate\Http\Request;

class InicioController extends Controller
{
    private InmuebleService $inmueble_service;

    public function __construct(InmuebleService $inmueble_service)
    {
        $this->inmueble_service = $inmueble_service;
    }

    public function index(Request $request)
    {
        $filtros = [
            'buscar' => $request->input('buscar'),
            'tipo_oferta' => $request->input('tipo_oferta'),
            'zona' => $request->input('zona'),
            'id_municipio' => $request->input('id_municipio'),
            'id_tipo_inmueble' => $request->input('id_tipo_inmueble'),
        ];

        $inmuebles = $this->inmueble_service->listarPublicos($filtros);
        $municipios = municipio::orderBy('nombre')->get();
        $tipos_inmueble = tipo_inmueble::orderBy('nombre')->get();

        return view('publico.inicio', compact('inmuebles', 'municipios', 'tipos_inmueble', 'filtros'));
    }

    public function show(int $id, Request $request)
    {
        // Consultamos el inmueble y su estado
        $inmueble = Inmueble::with(['detalle_inmueble'])->find($id);

        if (! $inmueble) {
            return redirect()->back(fallback: route('inicio'))
                ->with('error', 'El inmueble solicitado no existe.');
        }

        $estado = strtolower($inmueble->detalle_inmueble?->estado_publicacion ?? 'disponible');

        // Si el estado no es 'disponible', no mostramos error: solo devolvemos un mensaje explicando el por qué
        if ($estado !== 'disponible') {
            return redirect()->back(fallback: route('inicio'))
                ->with('error', "No se puede visualizar este inmueble en el portal porque actualmente se encuentra en estado '{$estado}'.");
        }

        // Si está disponible, cargamos relaciones y mostramos la vista normal
        $inmueble->load(['municipio', 'tipo_inmueble', 'usuario', 'imagenes', 'barrio']);
        $similares = $this->inmueble_service->listarSimilares($inmueble);

        return view('publico.detalle', compact('inmueble', 'similares'));
    }
}