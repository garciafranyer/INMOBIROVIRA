<?php

namespace app\Repositories;

use app\Models\detalle_inmueble;

class DetalleInmuebleRepository{

    public function listar(){
        return detalle_inmueble::with('id_inmueble')->get();
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