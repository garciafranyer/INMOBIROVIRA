<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetalleInmuebleStoreRequest;
use App\Http\Requests\DetalleInmuebleUpdateRequest;
use App\Models\detalle_inmueble;
use App\Services\DetalleInmuebleService;
use App\Services\InmuebleService;
use Illuminate\Http\Request;

class DetalleInmuebleController extends Controller
{   
    private DetalleInmuebleService $detalle_inmueble_service;

    private InmuebleService $inmueble_service;


    public function __construct(DetalleInmuebleService $detalle_inmueble_service,InmuebleService $inmueble_service)
    {
        $this->detalle_inmueble_service = $detalle_inmueble_service;
        $this->inmueble_service = $inmueble_service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $detalle_inmueble = $this->detalle_inmueble_service->listar();
         

        return view('detalle_inmueble.index', compact('detalle_inmueble'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $inmueble = $this->inmueble_service->listar();
        return view('detalle_inmueble.crear',compact('inmueble'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DetalleInmuebleStoreRequest $request)
    {
        $this->detalle_inmueble_service->crear($request->validated());
        return redirect()->route('detalle_inmueble.index')->with('success', 'se creo correctamente');
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
    public function edit(int $id)
    {
        $inmueble = $this->inmueble_service->listar();
        $detalle_inmueble = $this->detalle_inmueble_service->buscarporid($id);
        return view('detalle_inmueble.editar',compact('inmueble','detalle_inmueble'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id, DetalleInmuebleUpdateRequest $request )
    {
        $this->detalle_inmueble_service->actualizar($id,$request->all());

        return redirect()->route('detalle_inmueble.index')->with('success', 'Se actualizo corretamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->detalle_inmueble_service->eliminar($id);
        return redirect()->route('detalle_inmueble.index')->with('success','Se elimino corrrectamente');
    }
}
