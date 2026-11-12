<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioStoreRequest;
use App\Http\Requests\UsuarioUpdateRequest;
use App\Models\Inmueble;
use App\Models\usuario;
use App\Repositories\UsuarioRepository;
use App\Services\UsuarioService;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{      private UsuarioService $usuario_service;
        public function __construct(UsuarioService $usuario_service)
        {
            $this->usuario_service = $usuario_service;
        }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuario = $this->usuario_service->listar();

        return view('Usuario.index', compact('usuario'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Usuario.crear');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UsuarioStoreRequest $request)
    {
        $this->usuario_service->crear($request->validated());
        return redirect()->route('usuario.index')->with('success', 'se creo correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(usuario $usuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
    $usuario = $this->usuario_service->buscarporid($id);

    return view('Usuario.editar', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id, UsuarioUpdateRequest $request)
    {
        $this->usuario_service->actualizar($id,$request->all());

        return redirect()->route('usuario.index')->with('success','se actualizo correctamente');

            
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            if (auth()->id() === $id) {
                return redirect()->route('usuario.index')->with(
                    'error',
                    'No puedes eliminar tu propia cuenta de usuario en sesión activa.'
                );
            }

            $usuario = $this->usuario_service->buscarporid($id);

            // Verificar si tiene inmuebles asociados
            $totalInmuebles = Inmueble::where('id_usuario', $id)->count();

            if ($totalInmuebles > 0) {
                return redirect()->route('usuario.index')->with(
                    'error',
                    "No se puede eliminar el usuario '{$usuario->nombre}' porque tiene {$totalInmuebles} inmueble(s) registrado(s). Debes reasignar o eliminar sus inmuebles primero."
                );
            }

            $this->usuario_service->eliminar($id);

            return redirect()->route('usuario.index')->with('success', "El usuario '{$usuario->nombre}' se eliminó correctamente.");
        } catch (\Throwable $e) {
            return redirect()->route('usuario.index')->with(
                'error',
                'No se pudo eliminar el usuario porque está vinculado a otros registros en el sistema.'
            );
        }
    }
}
