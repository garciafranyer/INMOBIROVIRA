<?php

namespace Tests\Feature;

use App\Models\Inmueble;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicoInmuebleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * Prueba que la página pública principal responda con código HTTP 200.
     */
    public function test_pagina_inicio_responde_con_exito(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Inmobirovira');
    }

    /**
     * Prueba que el catálogo muestre los inmuebles disponibles sembrados.
     */
    public function test_catalogo_muestra_inmuebles_disponibles(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $inmueble = Inmueble::whereHas('detalle_inmueble', fn ($q) => $q->where('estado_publicacion', 'disponible'))->first();

        if ($inmueble) {
            $response->assertSee($inmueble->nombre);
        }
    }

    /**
     * Prueba que la vista de detalle de un inmueble cargue sus datos y ubicación.
     */
    public function test_detalle_de_inmueble_muestra_informacion_completa(): void
    {
        $inmueble = Inmueble::with('detalle_inmueble')->first();

        $this->assertNotNull($inmueble, 'Debe existir al menos un inmueble en la base de datos');

        $response = $this->get(route('propiedad.show', $inmueble->id));

        $response->assertStatus(200);
        $response->assertSee($inmueble->nombre);
        $response->assertSee($inmueble->detalle_inmueble->direccion);
    }
}
