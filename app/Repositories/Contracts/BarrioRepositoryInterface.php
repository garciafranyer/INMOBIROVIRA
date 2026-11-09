<?php

namespace App\Repositories\Contracts;

interface BarrioRepositoryInterface
{
    public function listar();

    public function crear(array $datos);

    public function eliminar(int $id);

    public function buscarporid(int $id);

    public function actualizar(int $id, array $datos);

    public function listarPaginado();
}
