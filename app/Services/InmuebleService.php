<?php

namespace App\Services;

use App\Repositories\InmuebleRepository;

class InmuebleService{
    private InmuebleRepository $inmueble_repository;

    public function __construct(InmuebleRepository $inmueble_repository)
    {
        $this->inmueble_repository = $inmueble_repository;
    }

    public function listar(){
        return $this->inmueble_repository->listar();
    }

    public function crear(array $datos){
        $this->inmueble_repository->crear($datos);
    }

    public function eliminar(int $id){
        $this->inmueble_repository->eliminar($id);
    }

    public function buscarporid(int $id){
        return $this->inmueble_repository->buscarporid($id);
    }

    public function actualizar(int $id, array $datos){
        $this->inmueble_repository->actualizar($id, $datos);
    }

}