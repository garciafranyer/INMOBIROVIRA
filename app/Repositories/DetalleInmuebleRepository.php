<?php

namespace App\Repositories;

use App\Models\detalle_inmueble;
use App\Repositories\Contracts\DetalleInmuebleRepositoryInterface;

class DetalleInmuebleRepository implements DetalleInmuebleRepositoryInterface
{

    public function listar(){
        return detalle_inmueble::with('inmueble')->get();
    }


    public function  crear(array $datos){
        detalle_inmueble::create($datos);
    }


    public function eliminar(int $id){
        detalle_inmueble::destroy($id);
    }

    public function buscarporid(int $id){
        $detalle_inmueble = detalle_inmueble::FindOrFail($id);
        return $detalle_inmueble;
    }

    public function actualizar(int $id, array $datos){
        $detalle_inmueble = detalle_inmueble::FindOrFail($id);
        $detalle_inmueble->update($datos);
        return $detalle_inmueble;
    }
}