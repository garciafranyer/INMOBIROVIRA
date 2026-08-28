<?php

namespace App\Services;

use App\Repositories\MunicipioRepository;

class MunicipioService {
    private MunicipioRepository $municipio_repository;

    public function __construct(MunicipioRepository $municipio_repository)
    {
        $this->municipio_repository = $municipio_repository;
    }

    public Function listar(){
        return $this->municipio_repository->listar();

    }

    public function crear(array $datos){
        $this->municipio_repository->crear($datos);

    }

    public function eliminar(int $id){
        $this->municipio_repository->eliminar($id);
    }

    public function buscarporid(int $id){
        return
        $this->municipio_repository->buscarporid($id);
    }


    public function actualizar(int $id, array $datos){
        $this->municipio_repository->actualizar($id, $datos);
    }


}