<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class municipio extends Model
{
   protected $table = "municipio";

   protected $fillable = ['nombre','codigo_postal'];
}
