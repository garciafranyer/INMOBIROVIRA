<?php 

namespace App\Repositories;

use App\Models\Inmueble;
use App\Models\usuario;

class InmuebleRepository{

public function listar(){
    return Inmueble::with('municipio','tipo_inmueble','usuario')->get();
}

public function crear(array $datos){
    Inmueble::create($datos);
}

public function eliminar(int $id){
    Inmueble::destroy($id);
}

public function buscarporid(int $id){
    $inmueble =  Inmueble::findOrFail($id);
    return $inmueble;
}

public function actualizar(int $id, array $datos){
    $inmueble = Inmueble::findOrFail($id);
    $inmueble->update($datos);
    return $inmueble;
}

}