<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('imagen', function (Blueprint $table) {
            $table->id();
            $table->string('ruta');
            $table->string('url_imagen');
            $table->unsignedBigInteger('id_inmueble');
            $table->foreign('id_inmueble')->references('id')->on('inmueble');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagen');
    }
};
