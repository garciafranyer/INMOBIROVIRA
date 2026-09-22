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
        Schema::create('inmueble', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->enum('zona',['rural','urbana']);
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_tipo_inmueble');
            $table->unsignedBigInteger('id_municipio');
            $table->foreign('id_usuario')->references('id')->on('usuario');
            $table->foreign('id_tipo_inmueble')->references('id')->on('tipo_inmueble');
            $table->foreign('id_municipio')->references('id')->on('municipio');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inmueble');
    }
};
