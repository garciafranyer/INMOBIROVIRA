<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MunicipioSeeder extends Seeder
{
    public function run(): void
    {
        $municipios = [
            'Capitanejo'          => '681541',
            'Carcasí'             => '681521',
            'Cepitá'              => '682067',
            'Cerrito'             => '681501',
            'Concepción'          => '681511',
            'Enciso'              => '681567',
            'Guaca'               => '681031',
            'Macaravita'          => '681531',
            'Málaga'              => '682011',
            'Molagavita'          => '682031',
            'San Andrés'          => '682001',
            'San José de Miranda' => '682021',
            'San Miguel'          => '681551',
        ];

        foreach ($municipios as $nombre => $codigoPostal) {
            DB::table('municipio')->updateOrInsert(
                ['nombre' => $nombre],
                [
                    'nombre'        => $nombre,
                    'codigo_postal' => $codigoPostal,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]
            );
        }
    }
}