<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('usuario', function (Blueprint $table) {
            $table->renameColumn('gmail', 'email');
        });

        Schema::table('usuario', function (Blueprint $table) {
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->dropColumn(['tipo_usuario', 'nombre_empresa']);
        });
    }

    public function down(): void
    {
        Schema::table('usuario', function (Blueprint $table) {
            $table->string('tipo_usuario')->nullable();
            $table->string('nombre_empresa')->nullable();
            $table->dropColumn(['password', 'remember_token']);
        });

        Schema::table('usuario', function (Blueprint $table) {
            $table->renameColumn('email', 'gmail');
        });
    }
};