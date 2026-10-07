<?php

namespace App\Services;

use App\Repositories\InmuebleRepository;
use Illuminate\Support\Facades\DB;

class InmuebleService
{
    private InmuebleRepository $inmueble_repository;

    private ImagenService $imagen_service;

    public function __construct(InmuebleRepository $inmueble_repository, ImagenService $imagen_service)
    {
        $this->inmueble_repository = $inmueble_repository;
        $this->imagen_service = $imagen_service;
    }

    public function listar()
    {
        return $this->inmueble_repository->listar();
    }

    public function crear(array $datos, array $imagenes = [])
    {
        return DB::transaction(function () use ($datos, $imagenes) {
            $inmueble = $this->inmueble_repository->crear($datos);
            $this->imagen_service->subir($inmueble->id, $imagenes);

            return $inmueble;
        });
    }

    public function eliminar(int $id)
    {
        $inmueble = $this->inmueble_repository->buscarporid($id);

        // Borra cada foto (archivo y fila) antes de borrar el inmueble
        foreach ($inmueble->imagenes as $imagen) {
            $this->imagen_service->eliminar($imagen->id);
        }

        $this->inmueble_repository->eliminar($id);
    }

    public function buscarporid(int $id)
    {
        return $this->inmueble_repository->buscarporid($id);
    }

    public function actualizar(int $id, array $datos, array $imagenes = [])
    {
        DB::transaction(function () use ($id, $datos, $imagenes) {
            $this->inmueble_repository->actualizar($id, $datos);
            $this->imagen_service->subir($id, $imagenes);
        });
    }
}