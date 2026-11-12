<?php

namespace App\Http\Controllers;

use App\Http\Requests\MunicipioStoreRequest;
use App\Http\Requests\MunicipioUpdateRequest;
use App\Models\barrio;
use App\Models\Inmueble;
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
        try {
            $municipio = $this->municipio_service->buscarporid($id);

            // Verificar si tiene inmuebles asociados
            $totalInmuebles = Inmueble::where('id_municipio', $id)->count();

            // Verificar si tiene barrios o veredas asociadas
            $totalBarrios = barrio::where('id_municipio', $id)->count();

            if ($totalInmuebles > 0 || $totalBarrios > 0) {
                $detalles = [];
                if ($totalInmuebles > 0) {
                    $detalles[] = "$totalInmuebles inmueble(s)";
                }
                if ($totalBarrios > 0) {
                    $detalles[] = "$totalBarrios barrio(s)/vereda(s)";
                }
                $textoDetalles = implode(' y ', $detalles);

                return redirect()->route('municipio.index')->with(
                    'error',
                    "No se puede eliminar el municipio '{$municipio->nombre}' porque tiene {$textoDetalles} asociado(s). Primero debes reasignar o eliminar esos registros."
                );
            }

            $this->municipio_service->eliminar($id);

            return redirect()->route('municipio.index')->with('success', "El municipio '{$municipio->nombre}' se eliminó correctamente.");
        } catch (\Throwable $e) {
            return redirect()->route('municipio.index')->with(
                'error',
                'No se pudo eliminar el municipio porque está vinculado a otros registros en el sistema.'
            );
        }
    }
}
