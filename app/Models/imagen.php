<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class imagen extends Model
{
    protected $table = 'imagen';

    protected $fillable = [
        'ruta',
        'url_imagen',
        'id_inmueble',
    ];

    public function inmueble()
    {
        return $this->belongsTo(Inmueble::class, 'id_inmueble');
    }
}
