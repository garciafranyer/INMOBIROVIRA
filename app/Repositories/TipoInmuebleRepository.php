<?php

namespace App\Repositories;

use App\Models\tipo_inmueble;

class TipoInmuebleRepository{
   public function listar(){
        $tipo_inmueble = tipo_inmueble::all();
        return $tipo_inmueble;
    }

    public function crear(array $datos){
        tipo_inmueble::create($datos);
    }

    public function eliminar(int $id){
        tipo_inmueble::destroy($id);
    }

    public function buscarporid(int $id){
        $tipo_inmueble = tipo_inmueble::findorfail($id);
        return $tipo_inmueble;
    }

    public function actualizar(int $id, array $datos){
        $tipo_inmueble = tipo_inmueble::findorfail($id);
        $tipo_inmueble->update($datos);
    }
}