<?php

namespace App\Services;

use App\Repositories\InmuebleRepository;

class InmuebleService{
    private InmuebleRepository $inmueble_repository;

    private ImagenService $imagen_service;

    public function __construct(InmuebleRepository $inmueble_repository, ImagenService $imagen_service)
    {
        $this->inmueble_repository = $inmueble_repository;
        $this->imagen_service = $imagen_service;
    }

    public function listar(){
        return $this->inmueble_repository->listar();
    }

    public function crear(array $datosInmueble, array $imagenes){

        $inmueble = $this->inmueble_repository->crear($datosInmueble);

        foreach ($imagenes as $imagen){

            $ruta = $imagen->store('inmuebles', 'public');

            $this->imagen_service->crear([
                'id_inmueble' => $inmueble->id,
                'url_imagen' => $ruta,
            ]);

        }

    }

    public function eliminar(int $id){
        $inmueble = $this->inmueble_repository->buscarporid($id);

        foreach ($inmueble->imagenes as $imagen) {
            $this->imagen_service->eliminar($imagen->id);
        }

        $this->inmueble_repository->eliminar($id);
    }

    public function buscarporid(int $id){
        return $this->inmueble_repository->buscarporid($id);
    }

    public function actualizar(int $id, array $datosInmueble, ?array $imagenes = null){
        $this->inmueble_repository->actualizar($id, $datosInmueble);

        if ($imagenes) {
            foreach ($imagenes as $imagen) {
                $ruta = $imagen->store('inmuebles', 'public');
                $this->imagen_service->crear([
                    'id_inmueble' => $id,
                    'url_imagen' => $ruta,
                ]);
            }
        }
    }

}