<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inmueble extends Model
{
    protected $table = "inmueble";

    protected $fillable = ['nombre','zona','id_usuario','id_tipo_inmueble','id_municipio'];

    public function usuario(){
        return $this->belongsTo(usuario::class,'id_usuario');
    }

    public function tipo_inmueble(){
        return $this->belongsTo(tipo_inmueble::class, 'id_tipo_inmueble');
    }

    public function municipio(){
        return $this->belongsTo(municipio::class, 'id_municipio');
    }

    
}
