<?php

namespace App\Http\Controllers;

use App\Http\Requests\BarrioStoreRequest;
use App\Http\Requests\BarrioUpdateRequest;
use App\Models\barrio;
use App\Services\BarrioService;
use App\Services\MunicipioService;

class BarrioController extends Controller
{   
    private BarrioService $barrio_service;

    private MunicipioService $municipio_service;
    
    public function __construct(BarrioService $barrio_service, MunicipioService $municipio_service)
    {
        $this->barrio_service = $barrio_service;
        $this->municipio_service = $municipio_service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barrio = $this->barrio_service->listar();

        return view('Barrio.index',compact('barrio'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $municipios = $this->municipio_service->listar();
        return view('Barrio.crear',compact('municipios'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BarrioStoreRequest $request)
    {
            $this-> barrio_service->crear($request->validated());
            return redirect()->route('barrio.index')->with('success', 'Se creo correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(barrio $barrio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $barrio = $this->barrio_service->buscarporid($id);
        $municipios = $this->municipio_service->listar();
        return view('Barrio.editar', compact('barrio','municipios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id, BarrioUpdateRequest $reques)
    {
        $this->barrio_service->actualizar($id,$reques->all());
        return redirect()->route('barrio.index')->with('success','se actualizo corretamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->barrio_service->eliminar($id);
        return redirect()->route('barrio.index')->with('success', 'Se elimino correctamente');
    }
}
