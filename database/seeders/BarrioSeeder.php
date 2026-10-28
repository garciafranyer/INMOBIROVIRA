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
                // Barrios Urbanos
                'Centro', 'El Bosque', 'El Dorado', 'El Cedral', 'Balcones de Sevilla',
                'Asovipar', 'El Guamo', 'El Mirador', 'La Esperanza', 'San Sebastián',
                'Tajamar', 'El Limonal', 'Torres del Paraíso', 'Los Naranjitos',
                'Camilo Torres', 'Versalles', 'Santander', 'La Granja',
                // Zonas Rurales / Veredas
                'Vda. Calichal', 'Vda. Buenavista', 'Vda. Peña Colorada', 'Vda. Hatico',
                'Vda. Barichara', 'Vda. Pescaderito', 'Vda. La Vega', 'Vda. Loma Redonda',
            ],
            'Capitanejo' => [
                // Barrios Urbanos
                'Centro', 'La Loma', 'Las Ferias', 'Villa del Río', 'Santander',
                // Zonas Rurales / Veredas
                'Vda. Montecillo', 'Vda. Peñablanca', 'Vda. Platanal', 'Vda. San Pedro',
                'Vda. Las Juntas', 'Vda. Sevillana', 'Vda. La Pampa', 'Vda. Tapias',
            ],
            'San Andrés' => [
                // Barrios Urbanos
                'Centro', 'Bochalema', 'La Cruz', 'La Primavera', 'Los Pinos',
                'Las Palmas', 'Los Rosales', 'San Luis', 'Cañaveral',
                // Zonas Rurales / Veredas
                'Vda. El Alisal', 'Vda. San Antonio', 'Vda. Listará', 'Vda. Caracolí',
                'Vda. Santa Cruz', 'Vda. El Hato', 'Vda. Llano Grande',
            ],
            'Cerrito' => [
                // Casco Urbano y Corregimientos
                'Centro', 'San Antonio', 'Cruz Alta', 'Corregimiento Servitá', 'Corregimiento Presidente',
                // Zonas Rurales / Veredas
                'Vda. Angosturas', 'Vda. Mortiño', 'Vda. Carrizal', 'Vda. Chupadero', 'Vda. El Hatico',
            ],
            'Concepción' => [
                // Barrios Urbanos
                'Centro', 'San José', 'El Carmen',
                // Zonas Rurales / Veredas
                'Vda. Bánega', 'Vda. Arcipirí', 'Vda. El Trapiche', 'Vda. La Laguna',
                'Vda. Taquiza', 'Vda. San Antonio', 'Vda. Canutillo',
            ],
            'Enciso' => [
                // Barrios Urbanos
                'Centro', 'La Playa', 'El Carmen',
                // Zonas Rurales / Veredas
                'Vda. Carrizal', 'Vda. Insagá', 'Vda. Tierra Blanca', 'Vda. Cochagá',
                'Vda. Cabeceras', 'Vda. Portachuelo',
            ],
            'Guaca' => [
                // Barrios Urbanos
                'Centro', 'Pueblo Nuevo', 'San Isidro',
                // Zonas Rurales / Veredas
                'Vda. Baraya', 'Vda. Tabacal', 'Vda. Llano Grande', 'Vda. Cruz de Mayo', 'Vda. Mata de Ruda',
            ],
            'San José de Miranda' => [
                // Barrios Urbanos
                'Centro', 'San Antonio', 'El Progreso',
                // Zonas Rurales / Veredas
                'Vda. Tehitá', 'Vda. Supagá', 'Vda. Cacota', 'Vda. Llano Grande', 'Vda. Hatico Seco',
            ],
            'Molagavita' => [
                // Barrios Urbanos
                'Centro', 'El Calvario',
                // Zonas Rurales / Veredas
                'Vda. Llanadas', 'Vda. Vega del Trigo', 'Vda. Chitagoto', 'Vda. Potrero Grande',
            ],
            'Carcasí' => [
                // Barrios Urbanos
                'Centro', 'La Cabaña',
                // Zonas Rurales / Veredas
                'Vda. Purgatorio', 'Vda. Supagá', 'Vda. Buenavista', 'Vda. Canutal', 'Vda. El Tobal',
            ],
            'Macaravita' => [
                // Barrios Urbanos
                'Centro', 'San Roque',
                // Zonas Rurales / Veredas
                'Vda. Huertas', 'Vda. Llano de la Yegua', 'Vda. Pajarito', 'Vda. Buenavista',
            ],
            'San Miguel' => [
                // Barrios Urbanos
                'Centro', 'El Carmen',
                // Zonas Rurales / Veredas
                'Vda. Paya', 'Vda. Muro', 'Vda. Mesitas', 'Vda. Angostura',
            ],
            'Cepitá' => [
                // Barrios Urbanos
                'Centro', 'La Vega',
                // Zonas Rurales / Veredas
                'Vda. Pescaderito', 'Vda. San Antonio', 'Vda. El Salado', 'Vda. Pericos',
            ],
        ];

        // Limpia los barrios viejos antes de cargar la lista oficial
        DB::table('barrio')->delete();

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