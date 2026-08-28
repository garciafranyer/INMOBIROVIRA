<?php

namespace App\Http\Controllers;

use App\Http\Requests\MunicipioStoreRequest;
use App\Http\Requests\MunicipioUpdateRequest;
use App\Models\municipio;
use App\Services\MunicipioService;

class MunicipioController extends Controller
{
    private MunicipioService $municipio_service;
    
    public function __construct(MunicipioService $municipio_service)
    {
        $this->municipio_service = $municipio_service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $municipio = $this->municipio_service->listar();

        return view('municipio.index', compact('municipio'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('municipio.crear');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MunicipioStoreRequest $request)
    {
        $this->municipio_service->crear($request->validated());
        return redirect()->route('municipio.index')->with('success', 'se creo correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(municipio $municipio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id )
    {
        $municipio = $this->municipio_service->buscarporid($id);
        return view('municipio.editar',compact('municipio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id, MunicipioUpdateRequest $request )
    {
        $this->municipio_service->actualizar($id,$request->all());

        return redirect()->route('municipio.index')->with('success', 'Se actualizo corretamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->municipio_service->eliminar($id);
        return redirect()->route('municipio.index')->with('success','Se elimino corrrectamente');
    }
}
