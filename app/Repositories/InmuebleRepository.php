<?php

namespace App\Repositories;

use App\Models\Inmueble;
use Illuminate\Support\Facades\DB;

class InmuebleRepository
{
    public function listar()
    {
        return Inmueble::with('municipio', 'tipo_inmueble', 'usuario', 'detalle_inmueble', 'imagenes')->get();
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
        return Inmueble::with('detalle_inmueble', 'imagenes')->findOrFail($id);
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

    public function listarPublicos(array $filtros = [])
    {
        return Inmueble::with('municipio', 'tipo_inmueble', 'detalle_inmueble', 'imagenes')
            ->whereHas('detalle_inmueble', fn ($q) => $q->where('estado_publicacion', 'disponible'))
            ->when(!empty($filtros['buscar']), function ($q) use ($filtros) {
                $termino = '%' . trim($filtros['buscar']) . '%';
                $q->where(function ($sub) use ($termino) {
                    $sub->where('nombre', 'like', $termino)
                        ->orWhereHas('detalle_inmueble', fn ($d) => $d->where('descripcion', 'like', $termino)->orWhere('direccion', 'like', $termino));
                });
            })
            ->when(!empty($filtros['tipo_oferta']), function ($q) use ($filtros) {
                $q->whereHas('detalle_inmueble', fn ($sub) => $sub->where('tipo_oferta', $filtros['tipo_oferta']));
            })
            ->when(!empty($filtros['zona']), function ($q) use ($filtros) {
                $q->where('zona', $filtros['zona']);
            })
            ->when(!empty($filtros['id_municipio']), function ($q) use ($filtros) {
                $q->where('id_municipio', $filtros['id_municipio']);
            })
            ->when(!empty($filtros['id_tipo_inmueble']), function ($q) use ($filtros) {
                $q->where('id_tipo_inmueble', $filtros['id_tipo_inmueble']);
            })
            ->latest()
            ->paginate(9)
            ->withQueryString();
    }

    public function buscarPublico(int $id)
    {
        return Inmueble::with('municipio', 'tipo_inmueble', 'usuario', 'detalle_inmueble', 'imagenes')
            ->whereHas('detalle_inmueble', fn ($q) => $q->where('estado_publicacion', 'disponible'))
            ->findOrFail($id);
    }

    public function listarSimilares(Inmueble $inmueble, int $limite = 3)
    {
        return Inmueble::with('municipio', 'tipo_inmueble', 'detalle_inmueble', 'imagenes')
            ->whereHas('detalle_inmueble', fn ($q) => $q->where('estado_publicacion', 'disponible'))
            ->where('id', '!=', $inmueble->id)
            ->where(function ($q) use ($inmueble) {
                if ($inmueble->id_municipio) {
                    $q->where('id_municipio', $inmueble->id_municipio);
                }
                if ($inmueble->id_tipo_inmueble) {
                    $q->orWhere('id_tipo_inmueble', $inmueble->id_tipo_inmueble);
                }
            })
            ->latest()
            ->take($limite)
            ->get();
    }
}
