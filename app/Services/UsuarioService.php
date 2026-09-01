<?php
namespace App\Services;

use App\Repositories\UsuarioRepository;


class UsuarioService {
    private UsuarioRepository $usuario_repository;

    public function __construct(UsuarioRepository $usuario_repository)
    {
        $this->usuario_repository = $usuario_repository;
    }

    public function listar(){
        return $this-> usuario_repository->listar();
    }

    public function crear(array $datos){
        $this->usuario_repository->crear($datos);
    }

    public function eliminar(int $id){
        $this->usuario_repository->eliminar($id);
    }

    public function buscarporid(int $id)
    {
    return $this->usuario_repository->buscarporid($id);
    }

    public function actualizar(int $id, array $datos){
        $this->usuario_repository->actualizar($id,$datos);
    }
}