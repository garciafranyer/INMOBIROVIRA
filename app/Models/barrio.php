<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class barrio extends Model
{
    protected $table = "barrio";

   protected $fillable = ['nombre','id_municipio'];

   public function municipio(){
    return $this->belongsTo(municipio::class,'id_municipio');
   }
}
