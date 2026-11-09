<?php

namespace Tests\Feature;

use App\Models\barrio;
use App\Models\Inmueble;
use App\Models\municipio;
use App\Models\tipo_inmueble;
use App\Models\usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class InmuebleCrudTest extends TestCase
{
    use RefreshDatabase;

    protected usuario $admin;
    protected municipio $municipio;
    protected tipo_inmueble $tipo;
    protected barrio $barrio;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();

        $this->admin = usuario::where('email', config('seguridad.admin.email', 'admin@admin.com'))->first();
        $this->municipio = municipio::first();
        $this->tipo = tipo_inmueble::first();
        $this->barrio = barrio::first();
    }

    /**
     * Prueba que un usuario autenticado pueda registrar un nuevo inmueble con sus detalles.
     */
    public function test_crear_inmueble_con_detalles_exitosamente(): void
    {
        Storage::fake('public');

        $datos = [
            'nombre' => 'Casa de Prueba Automatizada PHPUnit',
            'zona' => 'urbana',
            'id_usuario' => $this->admin->id,
            'id_tipo_inmueble' => $this->tipo->id,
            'id_municipio' => $this->municipio->id,
            'id_barrio' => $this->barrio->id,
            'detalle' => [
                'direccion' => 'Calle 10 # 5-20, Málaga',
                'latitud' => 6.7025,
                'longitud' => -72.7310,
                'tipo_oferta' => 'venta',
                'precio' => 195000000,
                'precio_administrador' => 0,
                'area' => 120,
                'estrato' => 3,
                'mascotas_permitidas' => 1,
                'antiguedad' => '2 años',
                'numero_habitacion' => 3,
                'numero_parqueadero' => 1,
                'numero_piso' => 2,
                'numero_apartamento' => null,
                'numero_bano' => 2,
                'descripcion' => 'Descripción de prueba para verificar persistencia en base de datos.',
                'fecha_publicacion' => now()->toDateString(),
                'estado_publicacion' => 'disponible',
            ],
            'imagenes' => [
                UploadedFile::fake()->image('fachada_test.jpg'),
            ],
        ];

        $response = $this->actingAs($this->admin)->post(route('inmueble.store'), $datos);

        $response->assertStatus(302);
        $response->assertRedirect(route('inmueble.index'));

        $this->assertDatabaseHas('inmueble', [
            'nombre' => 'Casa de Prueba Automatizada PHPUnit',
            'id_municipio' => $this->municipio->id,
        ]);

        $this->assertDatabaseHas('detalle_inmueble', [
            'direccion' => 'Calle 10 # 5-20, Málaga',
            'precio' => 195000000,
        ]);
    }

    /**
     * Prueba que el cambio de estado de publicación (ej: a Vendido o Arrendado) persista correctamente.
     */
    public function test_actualizar_estado_de_publicacion_de_inmueble(): void
    {
        $inmueble = Inmueble::with('detalle_inmueble')->first();

        $this->assertNotNull($inmueble);

        $response = $this->actingAs($this->admin)->patch(route('inmueble.estado', $inmueble->id), [
            'estado_publicacion' => 'vendido',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('detalle_inmueble', [
            'id_inmueble' => $inmueble->id,
            'estado_publicacion' => 'vendido',
        ]);
    }
}
