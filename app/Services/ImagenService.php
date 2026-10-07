<?php

namespace App\Services;

use App\Repositories\ImagenRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ImagenService
{
    private ImagenRepository $imagen_repository;

    public function __construct(ImagenRepository $imagen_repository)
    {
        $this->imagen_repository = $imagen_repository;
    }

    public function listar()
    {
        return $this->imagen_repository->listar();
    }

    public function subir(int $id_inmueble, array $archivos): void
    {
        $rutas = [];

        try {
            foreach ($archivos as $archivo) {
                // Si la foto llegó rota (por ejemplo, supera el límite de PHP), avisa con un mensaje claro
                if (! $archivo->isValid()) {
                    throw ValidationException::withMessages([
                        'imagenes' => $archivo->getErrorMessage(),
                    ]);
                }

                $ruta = $archivo->store('inmuebles', 'public');
                $rutas[] = $ruta;

                $this->imagen_repository->crear([
                    'ruta'        => $ruta,
                    'url_imagen'  => asset('storage/' . $ruta),
                    'id_inmueble' => $id_inmueble,
                ]);
            }
        } catch (\Throwable $e) {
            Storage::disk('public')->delete($rutas); // no dejar archivos huérfanos
            throw $e;
        }
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