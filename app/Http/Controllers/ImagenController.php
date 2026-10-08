<?php

namespace App\Http\Controllers;

use App\Services\ImagenService;

class ImagenController extends Controller
{
    private ImagenService $imagen_service;

    public function __construct(ImagenService $imagen_service)
    {
        $this->imagen_service = $imagen_service;
    }

    public function index()
    {
        $imagen = $this->imagen_service->listar();

        return view('imagen.index', compact('imagen'));
    }

    public function destroy(int $id)
    {
        $this->imagen_service->eliminar($id);
        return back();
    }
}