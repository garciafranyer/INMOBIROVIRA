<?php

namespace App\Repositories;

use App\Models\Inmueble;
use Illuminate\Support\Facades\DB;

class InmuebleRepository
{
    public function listar()
    {
        return Inmueble::with('municipio', 'tipo_inmueble', 'usuario', 'detalle_inmueble')->get();
    }

    public function crear(array $datos)
    {
        return DB::transaction(function () use ($datos) {
            $detalle = $datos['detalle'];
            unset($datos['detalle']);

            $inmueble = Inmueble::create($datos);
            $inmueble->detalle_inmueble()->create($detalle);

            return $inmueble;
        });
    }

    public function eliminar(int $id)
    {
        DB::transaction(function () use ($id) {
            $inmueble = Inmueble::findOrFail($id);
            $inmueble->detalle_inmueble()->delete();
            $inmueble->delete();
        });
    }

    public function buscarporid(int $id)
    {
        return Inmueble::with('detalle_inmueble')->findOrFail($id);
    }

    public function actualizar(int $id, array $datos)
    {
        return DB::transaction(function () use ($id, $datos) {
            $detalle = $datos['detalle'] ?? null;
            unset($datos['detalle']);

            $inmueble = Inmueble::findOrFail($id);
            $inmueble->update($datos);

            if ($detalle) {
                $inmueble->detalle_inmueble()->updateOrCreate(
                    ['id_inmueble' => $inmueble->id],
                    $detalle
                );
            }

            return $inmueble;
        });
    }
}