<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoInmuebleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            'Casa',
            'Apartamento',
            'Local Comercial',
            'Finca / Terreno Campestre',
            'Lote / Terreno',
        ];

        foreach ($tipos as $nombre) {
            DB::table('tipo_inmueble')->updateOrInsert(
                ['nombre' => $nombre],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
