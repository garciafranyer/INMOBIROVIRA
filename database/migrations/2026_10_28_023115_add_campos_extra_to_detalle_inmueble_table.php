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
        Schema::table('detalle_inmueble', function (Blueprint $table) {
            $table->unsignedTinyInteger('estrato')->nullable()->after('area');
            $table->boolean('mascotas_permitidas')->nullable()->after('estrato');
            $table->string('antiguedad', 50)->nullable()->after('mascotas_permitidas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detalle_inmueble', function (Blueprint $table) {
            $table->dropColumn(['estrato', 'mascotas_permitidas', 'antiguedad']);
        });
    }
};
