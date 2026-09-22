<?php

namespace App\Http\Controllers;

use App\Http\Requests\InmuebleStoreRequest;
use App\Http\Requests\InmuebleUpdateRequest;
use App\Models\Inmueble;
use App\Services\InmuebleService;
use App\Services\MunicipioService;
use App\Services\TipoInmuebleService;
use App\Services\UsuarioService;
use Illuminate\Http\Request;

class InmuebleController extends Controller
{   
    private InmuebleService $inmueble_service;

    private MunicipioService $municipio_service;

    private UsuarioService $usuario_service;

    private TipoInmuebleService $tipo_inmueble_service;

    public function __construct(InmuebleService $inmueble_service, MunicipioService $municipio_service, UsuarioService $usuario_service, TipoInmuebleService $tipo_inmueble_service)
    {
        $this->inmueble_service = $inmueble_service;
        $this->municipio_service = $municipio_service;
        $this->usuario_service = $usuario_service;
        $this->tipo_inmueble_service = $tipo_inmueble_service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $inmueble = $this->inmueble_service->listar();

        return view('inmueble.index', compact('inmueble'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $usuario = $this->usuario_service->listar();
        $municipios = $this->municipio_service->listar();
        $tipo_inmueble = $this->tipo_inmueble_service->listar();
        return view('inmueble.crear',compact('usuario','municipios','tipo_inmueble'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InmuebleStoreRequest $request)
    {
        $this->inmueble_service->crear($request->validated());
        return redirect()->route('inmueble.index')->with('success', 'se creo correctamente');
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
        $tipo_inmueble = $this->tipo_inmueble_service->listar();
        $usuario = $this->usuario_service->listar();
        $municipios = $this->municipio_service->listar();
        $inmueble = $this->inmueble_service->buscarporid($id);
        return view('inmueble.editar',compact('inmueble','municipios','usuario','tipo_inmueble'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id, InmuebleUpdateRequest $request )
    {
        $this->inmueble_service->actualizar($id,$request->all());

        return redirect()->route('inmueble.index')->with('success', 'Se actualizo corretamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->inmueble_service->eliminar($id);
        return redirect()->route('inmueble.index')->with('success','Se elimino corrrectamente');
    }
}
