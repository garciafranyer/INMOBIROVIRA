<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE detalle_inmueble MODIFY COLUMN estado_publicacion ENUM('disponible','arrendado','vendido','reservado','inactivo','pendiente') NOT NULL DEFAULT 'disponible'");
        } elseif ($driver === 'sqlite') {
            // En SQLite, Laravel Schema::table soporta change() o recreación de tabla
            Schema::table('detalle_inmueble', function (Blueprint $table) {
                $table->string('estado_publicacion', 30)->default('disponible')->change();
            });
        } else {
            Schema::table('detalle_inmueble', function (Blueprint $table) {
                $table->string('estado_publicacion', 30)->default('disponible')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE detalle_inmueble MODIFY COLUMN estado_publicacion ENUM('disponible','arrendado','vendido','reservado','inactivo') NOT NULL DEFAULT 'disponible'");
        } else {
            Schema::table('detalle_inmueble', function (Blueprint $table) {
                $table->string('estado_publicacion', 30)->default('disponible')->change();
            });
        }
    }
};
