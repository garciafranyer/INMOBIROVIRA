<?php

namespace Database\Seeders;

use App\Models\barrio;
use App\Models\detalle_inmueble;
use App\Models\imagen;
use App\Models\Inmueble;
use App\Models\municipio;
use App\Models\tipo_inmueble;
use App\Models\usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class InmuebleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Obtener usuarios clave
        $admin = usuario::where('email', config('seguridad.admin.email', 'admin@admin.com'))->first();
        $empresa = usuario::where('email', 'empresa@inmobirovira.com')->first() ?? $admin;

        // 2. Obtener tipos de inmueble
        $tipoCasa = tipo_inmueble::where('nombre', 'like', '%Casa%')->first();
        $tipoApto = tipo_inmueble::where('nombre', 'like', '%Apartamento%')->first();
        $tipoLocal = tipo_inmueble::where('nombre', 'like', '%Local%')->first();
        $tipoFinca = tipo_inmueble::where('nombre', 'like', '%Finca%')->first();
        $tipoLote = tipo_inmueble::where('nombre', 'like', '%Lote%')->first();

        // 3. Obtener municipios de García Rovira
        $munMalaga = municipio::where('nombre', 'like', '%Málaga%')->first();
        $munMiranda = municipio::where('nombre', 'like', '%Miranda%')->first() ?? $munMalaga;
        $munCapitanejo = municipio::where('nombre', 'like', '%Capitanejo%')->first() ?? $munMalaga;
        $munConcepcion = municipio::where('nombre', 'like', '%Concepción%')->first() ?? $munMalaga;

        // 4. Obtener barrios de Málaga
        $barrioCentro = barrio::where('nombre', 'like', '%Centro%')->first();
        $barrioMirador = barrio::where('nombre', 'like', '%Mirador%')->first() ?? $barrioCentro;

        // 5. Imágenes disponibles en disco
        $rutaCarpeta = public_path('storage/inmuebles');
        $imagenesDisponibles = [];
        if (File::exists($rutaCarpeta)) {
            foreach (File::files($rutaCarpeta) as $archivo) {
                if ($archivo->getExtension() !== 'gitignore') {
                    $imagenesDisponibles[] = 'inmuebles/' . $archivo->getFilename();
                }
            }
        }

        // Definición de inmuebles coherentes para García Rovira
        $inmueblesData = [
            [
                'inmueble' => [
                    'nombre' => 'Hermosa Casa Familiar en El Mirador',
                    'zona' => 'urbana',
                    'id_usuario' => $admin?->id,
                    'id_tipo_inmueble' => $tipoCasa?->id,
                    'id_municipio' => $munMalaga?->id,
                    'id_barrio' => $barrioMirador?->id,
                ],
                'detalle' => [
                    'direccion' => 'Calle 14 # 8-32, Málaga',
                    'latitud' => 6.7042,
                    'longitud' => -72.7335,
                    'tipo_oferta' => 'venta',
                    'precio' => 280000000,
                    'precio_administrador' => 0,
                    'area' => 165,
                    'estrato' => 3,
                    'mascotas_permitidas' => true,
                    'antiguedad' => '3 años',
                    'numero_habitacion' => 4,
                    'numero_bano' => 3,
                    'numero_parqueadero' => 1,
                    'numero_piso' => 2,
                    'numero_apartamento' => null,
                    'descripcion' => 'Amplia casa de dos niveles con excelente iluminación natural, sala comedor espaciosa, cocina integral moderna, patio de ropas cubierto y garaje. Ubicada en zona residencial tranquila con vista panorámica de Málaga.',
                    'fecha_publicacion' => now()->subDays(10)->toDateString(),
                    'estado_publicacion' => 'disponible',
                ],
            ],
            [
                'inmueble' => [
                    'nombre' => 'Moderno Apartamento Céntrico con Balcón',
                    'zona' => 'urbana',
                    'id_usuario' => $empresa?->id,
                    'id_tipo_inmueble' => $tipoApto?->id,
                    'id_municipio' => $munMalaga?->id,
                    'id_barrio' => $barrioCentro?->id,
                ],
                'detalle' => [
                    'direccion' => 'Carrera 9 # 12-15, Apto 302',
                    'latitud' => 6.7018,
                    'longitud' => -72.7321,
                    'tipo_oferta' => 'arriendo',
                    'precio' => 850000,
                    'precio_administrador' => 50000,
                    'area' => 78,
                    'estrato' => 3,
                    'mascotas_permitidas' => true,
                    'antiguedad' => '1 año',
                    'numero_habitacion' => 3,
                    'numero_bano' => 2,
                    'numero_parqueadero' => 1,
                    'numero_piso' => 3,
                    'numero_apartamento' => '302',
                    'descripcion' => 'Apartamento en tercer piso con acabados de primera, calentador a gas, balcón exterior hacia calle principal, cerca de la plaza de mercado, colegios y comercio. Ideal para familias o profesionales.',
                    'fecha_publicacion' => now()->subDays(5)->toDateString(),
                    'estado_publicacion' => 'disponible',
                ],
            ],
            [
                'inmueble' => [
                    'nombre' => 'Finca Campestre Productiva con Nacimiento de Agua',
                    'zona' => 'rural',
                    'id_usuario' => $empresa?->id,
                    'id_tipo_inmueble' => $tipoFinca?->id,
                    'id_municipio' => $munMiranda?->id,
                    'id_barrio' => null,
                ],
                'detalle' => [
                    'direccion' => 'Vereda Tequia, San José de Miranda',
                    'latitud' => 6.6610,
                    'longitud' => -72.7280,
                    'tipo_oferta' => 'venta',
                    'precio' => 450000000,
                    'precio_administrador' => 0,
                    'area' => 35000,
                    'estrato' => 2,
                    'mascotas_permitidas' => true,
                    'antiguedad' => '5 años',
                    'numero_habitacion' => 5,
                    'numero_bano' => 2,
                    'numero_parqueadero' => 4,
                    'numero_piso' => null,
                    'numero_apartamento' => null,
                    'descripcion' => 'Finca de 3.5 hectáreas con casa campesina en excelente estado, establo, cultivos de frutales y café, acceso vehicular hasta la puerta y abundante agua propia por gravedad. Clima templado muy agradable.',
                    'fecha_publicacion' => now()->subDays(15)->toDateString(),
                    'estado_publicacion' => 'disponible',
                ],
            ],
            [
                'inmueble' => [
                    'nombre' => 'Local Comercial Esquinero en Zona Bancaria',
                    'zona' => 'urbana',
                    'id_usuario' => $admin?->id,
                    'id_tipo_inmueble' => $tipoLocal?->id,
                    'id_municipio' => $munMalaga?->id,
                    'id_barrio' => $barrioCentro?->id,
                ],
                'detalle' => [
                    'direccion' => 'Carrera 8 con Calle 13 esquina',
                    'latitud' => 6.7027,
                    'longitud' => -72.7308,
                    'tipo_oferta' => 'arriendo',
                    'precio' => 1800000,
                    'precio_administrador' => 0,
                    'area' => 65,
                    'estrato' => 4,
                    'mascotas_permitidas' => false,
                    'antiguedad' => '4 años',
                    'numero_habitacion' => null,
                    'numero_bano' => 1,
                    'numero_parqueadero' => 1,
                    'numero_piso' => 1,
                    'numero_apartamento' => null,
                    'descripcion' => 'Excelente local comercial con vitrina panorámica de cristal, doble cortina metálica, baño privado y pisos en porcelanato de alto tráfico. Ubicado en el corazón financiero y comercial de Málaga.',
                    'fecha_publicacion' => now()->subDays(3)->toDateString(),
                    'estado_publicacion' => 'disponible',
                ],
            ],
            [
                'inmueble' => [
                    'nombre' => 'Lote Urbanizable con Vista al Cañón de Chicamocha',
                    'zona' => 'urbana',
                    'id_usuario' => $empresa?->id,
                    'id_tipo_inmueble' => $tipoLote?->id,
                    'id_municipio' => $munCapitanejo?->id,
                    'id_barrio' => null,
                ],
                'detalle' => [
                    'direccion' => 'Sector Salida a San Mateo, Capitanejo',
                    'latitud' => 6.5312,
                    'longitud' => -72.6950,
                    'tipo_oferta' => 'venta',
                    'precio' => 85000000,
                    'precio_administrador' => 0,
                    'area' => 320,
                    'estrato' => 2,
                    'mascotas_permitidas' => null,
                    'antiguedad' => null,
                    'numero_habitacion' => null,
                    'numero_bano' => null,
                    'numero_parqueadero' => null,
                    'numero_piso' => null,
                    'numero_apartamento' => null,
                    'descripcion' => 'Terreno plano listo para construir vivienda campestre o cabañas turísticas. Cuenta con disponibilidad de acometida de acueducto y energía eléctrica. Clima cálido todo el año.',
                    'fecha_publicacion' => now()->subDays(20)->toDateString(),
                    'estado_publicacion' => 'disponible',
                ],
            ],
            [
                'inmueble' => [
                    'nombre' => 'Casa Colonial Restaurada (Cierre Exitoso)',
                    'zona' => 'urbana',
                    'id_usuario' => $admin?->id,
                    'id_tipo_inmueble' => $tipoCasa?->id,
                    'id_municipio' => $munConcepcion?->id,
                    'id_barrio' => null,
                ],
                'detalle' => [
                    'direccion' => 'Calle Real # 4-18, Concepción',
                    'latitud' => 6.7175,
                    'longitud' => -72.6840,
                    'tipo_oferta' => 'venta',
                    'precio' => 310000000,
                    'precio_administrador' => 0,
                    'area' => 210,
                    'estrato' => 3,
                    'mascotas_permitidas' => true,
                    'antiguedad' => '15 años',
                    'numero_habitacion' => 4,
                    'numero_bano' => 2,
                    'numero_parqueadero' => 1,
                    'numero_piso' => 1,
                    'numero_apartamento' => null,
                    'descripcion' => 'Propiedad colonial con patio central empedrado, corredores en teja española y maderas finas. Caso de venta culminada exitosamente por Inmobirovira.',
                    'fecha_publicacion' => now()->subMonths(1)->toDateString(),
                    'estado_publicacion' => 'vendido', // Muestra éxito en el dashboard!
                ],
            ],
        ];

        $imgIdx = 0;
        foreach ($inmueblesData as $item) {
            $inmueble = Inmueble::create($item['inmueble']);

            $detalle = $item['detalle'];
            $detalle['id_inmueble'] = $inmueble->id;
            detalle_inmueble::create($detalle);

            // Asignar al menos 2 imágenes si hay disponibles
            if (!empty($imagenesDisponibles)) {
                $totalFotos = count($imagenesDisponibles);
                $foto1 = $imagenesDisponibles[$imgIdx % $totalFotos];
                $foto2 = $imagenesDisponibles[($imgIdx + 1) % $totalFotos];

                imagen::create([
                    'id_inmueble' => $inmueble->id,
                    'url_imagen' => $foto1,
                ]);

                imagen::create([
                    'id_inmueble' => $inmueble->id,
                    'url_imagen' => $foto2,
                ]);

                $imgIdx += 2;
            }
        }
    }
}
