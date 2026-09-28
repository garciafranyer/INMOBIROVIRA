<?php

namespace App\Services;

use App\Repositories\DetalleInmuebleRepository;

class DetalleInmuebleService{
    private DetalleInmuebleRepository $detalle_inmueble_repository;

    public function __construct(DetalleInmuebleRepository $detalle_inmueble_repository)
    {
        $this->detalle_inmueble_repository = $detalle_inmueble_repository;
    }

    public function listar(){
        return $this->detalle_inmueble_repository->listar();
    }

    public function crear(array $datos){
        $this->detalle_inmueble_repository->crear($datos);
    }

    public function eliminar(int $id){
        $this->detalle_inmueble_repository->eliminar($id);
    }

    public function buscarporid(int $id){
        return $this->detalle_inmueble_repository->buscarporid($id);
    }

    public function actualizar(int $id, array $datos){
        $this->detalle_inmueble_repository->actualizar($id, $datos);
    }

}