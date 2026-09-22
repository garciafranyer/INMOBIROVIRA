<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tipo_inmueble extends Model
{
     protected $table = "tipo_inmueble";

   protected $fillable = ['nombre'];

   public function inmueble(){
    return $this->hasMany(inmueble::class);
   }
}
