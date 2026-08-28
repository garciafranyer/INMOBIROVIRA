<?php

namespace App\Repositories;

use App\Models\municipio;

class MunicipioRepository{
    public function listar(){
        $municipio = municipio::all();
        return $municipio;
    }

    public function crear(array $datos){
        municipio::create($datos);
    }

    public function eliminar(int $id){
        municipio::destroy($id);
    }

    public function buscarporid(int $id){
        $municipio = municipio::findorfail($id);
        return $municipio;
    }

    public function actualizar(int $id, array $datos){
        $municipio = municipio::findorfail($id);
        $municipio->update($datos);
    }


}