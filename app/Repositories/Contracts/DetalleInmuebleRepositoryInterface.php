<?php

namespace App\Repositories\Contracts;

interface DetalleInmuebleRepositoryInterface
{
    public function listar();

    public function crear(array $datos);

    public function eliminar(int $id);

    public function buscarporid(int $id);

    public function actualizar(int $id, array $datos);
}
