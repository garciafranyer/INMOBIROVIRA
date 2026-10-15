<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarrioSeeder extends Seeder
{
    public function run(): void
    {
        $barrios = [
            'Málaga' => [
                'Centro', 'El Bosque', 'El Dorado', 'El Cedral', 'Balcones de Sevilla',
                'Asovipar', 'El Guamo', 'El Mirador', 'La Esperanza', 'San Sebastián',
                'Tajamar', 'El Limonal', 'Torres del Paraíso', 'Los Naranjitos',
            ],
            'San Andrés' => [
                'Centro', 'Bochalema', 'La Cruz', 'La Primavera', 'Los Pinos',
                'Las Palmas', 'Los Rosales', 'San Luis', 'Cañaveral',
            ],
            'Capitanejo' => [
                'Centro', 'Peñalisa', 'Peñablanca', 'Montecillo',
            ],
            'Cerrito' => [
                'Centro', 'Servitá', 'Presidente',
            ],
            'Concepción' => [
                'Centro', 'La Laguna', 'El Trapiche', 'Arcipirí', 'Bánega',
            ],
            'Enciso' => [
                'Centro', 'Carrizal', 'Insagá', 'Tierra Blanca',
            ],
            'Guaca' => [
                'Centro', 'Baraya', 'San Isidro', 'Tabacal',
            ],
            'San José de Miranda' => [
                'Centro', 'Tehitá', 'Cacota', 'Supagá',
            ],
            'Molagavita' => [
                'Centro', 'Llanadas',
            ],
            'Carcasí' => [
                'Centro', 'Purgatorio', 'Supagá', 'Bucaramanga',
            ],
            'Macaravita' => [
                'Centro', 'Huertas', 'Llano de la Yegua',
            ],
            'San Miguel' => [
                'Centro', 'Paya', 'Muro', 'Mesitas',
            ],
            'Cepitá' => [
                'Centro', 'Pescaderito', 'San Antonio',
            ],
        ];

        // OPCIONAL: borra los barrios de ejemplo anteriores antes de cargar estos.
        // DB::table('barrio')->delete();

        foreach ($barrios as $municipio => $lista) {
            $id_municipio = DB::table('municipio')->where('nombre', $municipio)->value('id');

            if (! $id_municipio) {
                continue; // si el municipio no existe, lo salta
            }

            foreach ($lista as $nombre) {
                DB::table('barrio')->updateOrInsert(
                    ['nombre' => $nombre, 'id_municipio' => $id_municipio],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }
        }
    }
}