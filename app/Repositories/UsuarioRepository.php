<?php
namespace App\Repositories;


use App\Models\usuario;

class UsuarioRepository{
    public function listar(){
        $usuario = usuario::all();
        return $usuario;
    }

    public function crear(array $datos){
        usuario::create($datos);
    }

    public function eliminar(int $id){
        usuario::destroy($id);
    }

    public function buscarporid(int $id)
    {
    $usuario = usuario::findOrFail($id);

    return $usuario;
    }

   public function actualizar(int $id, array $datos) {
    
    $usuario = Usuario::findOrFail($id);
    $usuario->update($datos);
    
   
}
}