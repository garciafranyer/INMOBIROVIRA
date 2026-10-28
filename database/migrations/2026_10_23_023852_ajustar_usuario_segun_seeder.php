<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cada paso solo se aplica si es necesario, así la migración no falla
        // en bases de datos donde la tabla usuario ya fue creada con estas columnas.
        if (Schema::hasColumn('usuario', 'gmail') && ! Schema::hasColumn('usuario', 'email')) {
            Schema::table('usuario', function (Blueprint $table) {
                $table->renameColumn('gmail', 'email');
            });
        }

        Schema::table('usuario', function (Blueprint $table) {
            if (! Schema::hasColumn('usuario', 'password')) {
                $table->string('password')->nullable();
            }

            if (! Schema::hasColumn('usuario', 'remember_token')) {
                $table->rememberToken();
            }
        });

        $columnasAEliminar = array_values(array_filter(
            ['tipo_usuario', 'nombre_empresa'],
            fn ($columna) => Schema::hasColumn('usuario', $columna)
        ));

        if ($columnasAEliminar) {
            Schema::table('usuario', function (Blueprint $table) use ($columnasAEliminar) {
                $table->dropColumn($columnasAEliminar);
            });
        }
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
