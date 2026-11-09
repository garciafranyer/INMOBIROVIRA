<?php

namespace Tests\Feature;

use App\Models\usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeguridadAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * Prueba que los usuarios invitados sean redirigidos al login al intentar acceder a rutas privadas.
     */
    public function test_usuario_no_autenticado_es_redirigido_al_login(): void
    {
        $response = $this->get('/admin');

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    /**
     * Prueba que el formulario de login cargue correctamente.
     */
    public function test_formulario_de_login_carga_correctamente(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertSee('Iniciar sesión');
        $response->assertSee('Ingresar al Panel');
    }

    /**
     * Prueba el inicio de sesión exitoso con las credenciales de administrador.
     */
    public function test_login_con_credenciales_validas(): void
    {
        $response = $this->post(route('login.store'), [
            'email' => config('seguridad.admin.email', 'admin@admin.com'),
            'password' => config('seguridad.admin.password', '12345678'),
        ]);

        $response->assertStatus(302);
        $this->assertAuthenticated();
    }

    /**
     * Prueba que credenciales inválidas sean rechazadas y no autentiquen.
     */
    public function test_login_con_credenciales_invalidas_es_rechazado(): void
    {
        $response = $this->post(route('login.store'), [
            'email' => 'usuario_falso@inmobirovira.com',
            'password' => 'password_erroneo_123',
        ]);

        $response->assertStatus(302);
        $this->assertGuest();
    }
}
