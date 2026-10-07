<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImagenStoreRequest;
use App\Services\ImagenService;
use App\Services\InmuebleService;

class ImagenController extends Controller
{
    private ImagenService $imagen_service;
    private InmuebleService $inmueble_service;

    public function __construct(ImagenService $imagen_service, InmuebleService $inmueble_service)
    {
        $this->imagen_service = $imagen_service;
        $this->inmueble_service = $inmueble_service;
    }

    public function index()
    {
        $imagen = $this->imagen_service->listar();

        return view('imagen.index', compact('imagen'));
    }

    public function create()
    {
        $inmueble = $this->inmueble_service->listar();

        return view('imagen.crear', compact('inmueble'));
    }

    public function store(ImagenStoreRequest $request)
    {
        $this->imagen_service->subir(
            (int) $request->validated('id_inmueble'),
            $request->file('imagenes', [])
        );

        return redirect()->route('imagen.index')->with('success', 'se creo correctamente');
    }

    public function destroy(int $id)
    {
        $this->imagen_service->eliminar($id);

        return back()->with('success', 'se elimino correctamente');
    }
}