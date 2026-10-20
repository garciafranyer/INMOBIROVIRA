<?php

namespace App\Http\Controllers;

use App\Services\InmuebleService;

class InicioController extends Controller
{
    private InmuebleService $inmueble_service;

    public function __construct(InmuebleService $inmueble_service)
    {
        $this->inmueble_service = $inmueble_service;
    }

    public function index()
    {
        $inmuebles = $this->inmueble_service->listarPublicos();

        return view('publico.inicio', compact('inmuebles'));
    }

    public function show(int $id)
    {
        $inmueble = $this->inmueble_service->buscarPublico($id);

        return view('publico.detalle', compact('inmueble'));
    }
}