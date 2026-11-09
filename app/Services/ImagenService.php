<?php

namespace App\Services;

use App\Repositories\Contracts\ImagenRepositoryInterface;

class ImagenService
{
    private ImagenRepositoryInterface $imagen_repository;

    public function __construct(ImagenRepositoryInterface $imagen_repository)
    {
        $this->imagen_repository = $imagen_repository;
    }

    public function listar()
    {
        return $this->imagen_repository->listar();
    }

    public function crear(array $datos)
    {
        return $this->imagen_repository->crear($datos);
    }

    public function eliminar(int $id)
    {
        return $this->imagen_repository->eliminar($id);
    }

    public function buscarporid(int $id)
    {
        return $this->imagen_repository->buscarporid($id);
    }
}