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
        $imagen = imagen::findOrFail($id);
        $ruta = $imagen->ruta;

        $imagen->delete();                        // primero la fila
        Storage::disk('public')->delete($ruta);   // después el archivo

        return true;
    }

    public function buscarporid(int $id)
    {
        return imagen::findOrFail($id);
    }
}