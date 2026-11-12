<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoInmuebleStoreRequest;
use App\Http\Requests\TipoInmuebleUpdateRequest;
use App\Models\Inmueble;
use App\Services\TipoInmuebleService;


class TipoInmuebleController extends Controller
{
    private TipoInmuebleService $tipo_inmueble_service;
    
    public function __construct(TipoInmuebleService $tipo_inmueble_service)
    {
        $this->tipo_inmueble_service = $tipo_inmueble_service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipo_inmueble = $this->tipo_inmueble_service->listar();

        return view('tipo_inmueble.index', compact('tipo_inmueble'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tipo_inmueble.crear');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TipoInmuebleStoreRequest $request)
    {
        $this->tipo_inmueble_service->crear($request->validated());
        return redirect()->route('tipo_inmueble.index')->with('success', 'se creo correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id )
    {
        $tipo_inmueble = $this->tipo_inmueble_service->buscarporid($id);
        return view('tipo_inmueble.editar',compact('tipo_inmueble'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id, TipoInmuebleUpdateRequest $request )
    {
        $this->tipo_inmueble_service->actualizar($id,$request->all());

        return redirect()->route('tipo_inmueble.index')->with('success', 'Se actualizo corretamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $tipo = $this->tipo_inmueble_service->buscarporid($id);

            // Verificar si tiene inmuebles asociados
            $totalInmuebles = Inmueble::where('id_tipo_inmueble', $id)->count();

            if ($totalInmuebles > 0) {
                return redirect()->route('tipo_inmueble.index')->with(
                    'error',
                    "No se puede eliminar el tipo '{$tipo->nombre}' porque tiene {$totalInmuebles} inmueble(s) asociado(s). Primero debes reasignar o eliminar los inmuebles de esta categoría."
                );
            }

            $this->tipo_inmueble_service->eliminar($id);

            return redirect()->route('tipo_inmueble.index')->with('success', "El tipo de inmueble '{$tipo->nombre}' se eliminó correctamente.");
        } catch (\Throwable $e) {
            return redirect()->route('tipo_inmueble.index')->with(
                'error',
                'No se pudo eliminar el tipo de inmueble porque está en uso en el sistema.'
            );
        }
    }
}

