<?php

namespace App\Services;

use App\Repositories\Contracts\TipoInmuebleRepositoryInterface;

class TipoInmuebleService{
    private TipoInmuebleRepositoryInterface $tipo_inmueble_repository;

    public function __construct(TipoInmuebleRepositoryInterface $tipo_inmueble_repository)
    {
        $this->tipo_inmueble_repository = $tipo_inmueble_repository;
    }

    public Function listar(){
        return $this->tipo_inmueble_repository->listar();

    }

    public function crear(array $datos){
        $this->tipo_inmueble_repository->crear($datos);

    }

    public function eliminar(int $id){
        $this->tipo_inmueble_repository->eliminar($id);
    }

    public function buscarporid(int $id){
        return
        $this->tipo_inmueble_repository->buscarporid($id);
    }


    public function actualizar(int $id, array $datos){
        $this->tipo_inmueble_repository->actualizar($id, $datos);
    }


}