<?php

namespace App\Repositories;

use App\Models\barrio;

class BarrioRepository{
    public function listar(){
        return barrio::with('municipio')->get();
    }

    public function crear(array $datos){
        barrio::create($datos);

    }

    public function eliminar(int $id){
        barrio::destroy($id);
    }

    public function buscarporid(int $id){
        $barrio = barrio::findorfail($id);
        return $barrio;
    }

    public function actualizar(int $id, array $datos){
        $barrio = barrio::findOrFail($id);
        $barrio->update($datos);
        return $barrio;
    }

}