<?php

namespace App\Repositories;

use App\Models\imagen;
use Illuminate\Support\Facades\Storage;

class ImagenRepository
{
    public function listar()
    {
        return imagen::with('inmueble')->get();
    }

    public function crear(array $datos)
    {
        return imagen::create($datos);
    }

    public function eliminar(int $id)
    {
        $imagen = imagen::findOrFail($id); # trae el registro

        Storage::disk('public')->delete($imagen->url_imagen); # borra el archivo fisico

        return $imagen->delete(); #borra el registro de la base de datos
    }

    public function buscarporid(int $id)
    {
        return imagen::findOrFail($id);
    }
}