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
        Schema::table('inmueble', function (Blueprint $table) {
            $table->unsignedBigInteger('id_barrio')->nullable()->after('id_municipio');
            $table->foreign('id_barrio')->references('id')->on('barrio')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inmueble', function (Blueprint $table) {
            $table->dropForeign(['id_barrio']);
            $table->dropColumn('id_barrio');
        });
    }
};
