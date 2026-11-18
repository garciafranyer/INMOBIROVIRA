<?php

namespace App\Http\Controllers;

use App\Services\UsuarioService;

/**
 * Listado de usuarios de solo consulta.
 * La creación, edición y eliminación de cuentas se gestiona desde
 * Seguridad > Cuentas de usuario (Seguridad\CuentaController).
 */
class UsuarioController extends Controller
{
    public function __construct(private UsuarioService $usuario_service)
    {
    }

    public function index()
    {
        $usuario = $this->usuario_service->listar();

        return view('Usuario.index', compact('usuario'));
    }
}
