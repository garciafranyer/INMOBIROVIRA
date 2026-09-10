<?php
namespace App\Services;

use App\Repositories\BarrioRepository;

class BarrioService{
    private BarrioRepository $barrio_repository;

    public function __construct(BarrioRepository $barrio_repository)
    {
        $this->barrio_repository = $barrio_repository;
    }

    public function listar(){
        return $this->barrio_repository->listar();
    }

    public function crear(array $datos){
        $this->barrio_repository->crear($datos);
    }

    public function eliminar(int $id){
        $this->barrio_repository->eliminar($id);
    }

    public function buscarporid(int $id){
        return $this->barrio_repository->buscarporid($id);
    }

    public function actualizar(int $id, array $datos){
        $this->barrio_repository->actualizar($id, $datos);
    }
}