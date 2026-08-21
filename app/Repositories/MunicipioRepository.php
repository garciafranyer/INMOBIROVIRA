<?php

namespace App\Repositories;

use App\Models\municipio;

class MunicipioRepository{
    public function listar(){
        $municipio = municipio::all();
        return $municipio;
    }


}