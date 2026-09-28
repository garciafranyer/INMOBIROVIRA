<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

class detalle_inmueble extends Model
{
    protected $table = "detalle_inmueble";

    protected $Fillable = [
        'direccion',
        'tipo_oferta',
        'precio',
        'precio_administrador',
        'area',
        'numero_habitacion',
        'numero_parqueadero',
        'numero_piso',
        'numero_apartamento',
        'numero_bano',
        'descripcion',
        'fecha_publicacion',
        'estado_publicacion',
        'id_inmueble',
    ];
    public function inmueble(){
        return $this->belongsTo(inmueble::class,'id_inmueble');
    }
}
