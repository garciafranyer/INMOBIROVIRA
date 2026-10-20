<?php

namespace App\Http\Controllers;

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

    public function show(int $id)
    {
        $inmueble = $this->inmueble_service->buscarPublico($id);
        $similares = $this->inmueble_service->listarSimilares($inmueble);

        return view('publico.detalle', compact('inmueble', 'similares'));
    }
}