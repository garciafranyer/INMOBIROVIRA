<?php

namespace App\Repositories\Contracts;

use App\Models\Inmueble;

interface InmuebleRepositoryInterface
{
    public function listar();

    public function crear(array $datos);

    public function eliminar(int $id);

    public function buscarporid(int $id);

    public function actualizar(int $id, array $datos);

    public function listarPublicos(array $filtros = []);

    public function buscarPublico(int $id);

    public function listarSimilares(Inmueble $inmueble, int $limite = 3);
}
