<?php

namespace App\Repositories\Contracts;

interface ImagenRepositoryInterface
{
    public function listar();

    public function crear(array $datos);

    public function eliminar(int $id);

    public function buscarporid(int $id);
}
