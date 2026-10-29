<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use App\Services\Seguridad\CuentaService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CuentaController extends Controller
{
    public function __construct(private CuentaService $cuentaService)
    {
    }

    public function index(): View
    {
        return view('seguridad.cuentas.index', [
            'usuarios' => $this->cuentaService->listar(),
        ]);
    }

    public function create(): View
    {
        return view('seguridad.cuentas.form', [
            'usuario' => null,
            'roles' => $this->cuentaService->listarRoles(),
            'seleccionados' => old('roles', []),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique(config('auth.providers.users.model'), 'email')],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['string', Rule::exists(config('permission.table_names.roles'), 'name')],
        ]);

        $datosUsuario = [
            'nombre'    => $datos['name'],
            'email'     => $datos['email'],
            'password'  => $datos['password'],
            'telefono'  => $datos['telefono'] ?? '',
            'direccion' => $datos['direccion'] ?? '',
        ];

        $this->cuentaService->crear($datosUsuario, $datos['roles'] ?? []);

        return redirect()->route('seguridad.cuentas.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit(string $cuenta): View
    {
        $usuario = $this->cuentaService->buscar($cuenta);

        return view('seguridad.cuentas.form', [
            'usuario' => $usuario,
            'roles' => $this->cuentaService->listarRoles(),
            'seleccionados' => old('roles', $usuario->rolesConInactivos->pluck('name')->all()),
        ]);
    }

    public function update(Request $request, string $cuenta): RedirectResponse
    {
        $usuario = $this->cuentaService->buscar($cuenta);

        $datos = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique(config('auth.providers.users.model'), 'email')->ignore($usuario->getKey())],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['string', Rule::exists(config('permission.table_names.roles'), 'name')],
        ]);

        $datosUsuario = array_filter([
            'nombre'   => $datos['name'] ?? null,
            'email'    => $datos['email'] ?? null,
            'password' => $datos['password'] ?? null,
        ], fn ($v) => ! is_null($v) && $v !== '');

        try {
            $this->cuentaService->actualizar(
                $usuario,
                $datosUsuario,
                $datos['roles'] ?? [],
                $request->user()
            );
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->route('seguridad.cuentas.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(Request $request, string $cuenta): RedirectResponse
    {
        try {
            $this->cuentaService->eliminar($this->cuentaService->buscar($cuenta), $request->user());
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('seguridad.cuentas.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
