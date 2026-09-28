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
        Schema::create('detalle_inmueble', function (Blueprint $table) {
            $table->id();
            $table->string('direccion');
            $table->enum('tipo_oferta',['venta','arriendo','venta y arriendo']);
            $table->decimal('precio',10,2);
            $table->decimal('precio_administrador',10,2);
            $table->decimal('area',8,2);
            $table->integer('numero_habitacion')->nullable();
            $table->integer('numero_parqueadero')->nullable();
            $table->integer('numero_piso')->nullable();
            $table->integer('numero_apartamento')->nullable();
            $table->integer('numero_bano')->nullable();
            $table->string('descripcion');
            $table->date('fecha_publicacion');
            $table->enum('estado_publicacion',['disponibe','arrendado','vendido','reservado','inactivo']);
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
        Schema::dropIfExists('detalle_inmueble');
    }
};
