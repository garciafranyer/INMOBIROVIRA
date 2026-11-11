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

    /**
     * Prueba que la pantalla de solicitud de recuperación de contraseña cargue correctamente.
     */
    public function test_pantalla_recuperar_password_carga_correctamente(): void
    {
        $response = $this->get(route('password.request'));

        $response->assertStatus(200);
        $response->assertSee('¿Olvidaste tu contraseña?');
        $response->assertSee('Enviar enlace de recuperación');
    }

    /**
     * Prueba que se envíe el enlace de recuperación a un correo registrado.
     */
    public function test_enviar_enlace_recuperacion_con_correo_existente(): void
    {
        $response = $this->post(route('password.email'), [
            'email' => config('seguridad.admin.email', 'admin@admin.com'),
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('status');
    }

    /**
     * Prueba que se rechace la recuperación para un correo inexistente.
     */
    public function test_solicitar_recuperacion_con_correo_inexistente(): void
    {
        $response = $this->post(route('password.email'), [
            'email' => 'correo_inexistente_999@noexiste.com',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
    }

    /**
     * Prueba el flujo de moderación: cuando un rol usuario crea un inmueble,
     * este queda en estado 'pendiente' y no se publica hasta que el admin lo autorice.
     */
    public function test_inmueble_creado_por_rol_usuario_queda_pendiente_y_requiere_autorizacion_del_admin(): void
    {
        $usuario = usuario::where('email', 'usuario@inmobirovira.com')->first();
        $admin = usuario::where('email', config('seguridad.admin.email', 'admin@admin.com'))->first();
        $municipio = \App\Models\municipio::first();
        $tipoInmueble = \App\Models\tipo_inmueble::first();

        // 1. El usuario particular crea el inmueble
        $response = $this->actingAs($usuario)->post(route('empresa.store'), [
            'nombre' => 'Casa Campestre de Moderacion',
            'zona' => 'urbana',
            'id_usuario' => $usuario->id,
            'id_municipio' => $municipio->id,
            'id_tipo_inmueble' => $tipoInmueble->id,
            'detalle' => [
                'direccion' => 'Calle 10 # 5-20',
                'tipo_oferta' => 'venta',
                'precio' => 120000000,
                'precio_administrador' => 0,
                'area' => 110,
                'descripcion' => 'Hermosa casa campestre para prueba de moderacion.',
                'fecha_publicacion' => now()->toDateString(),
                'estado_publicacion' => 'disponible', // Intenta enviarla como disponible
            ],
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        // 2. Verificar que en la base de datos se forzó el estado a 'pendiente'
        $inmueble = \App\Models\Inmueble::where('nombre', 'Casa Campestre de Moderacion')->first();
        $this->assertNotNull($inmueble);
        $this->assertEquals('pendiente', $inmueble->detalle_inmueble->estado_publicacion);

        // 3. El portal público NO debe mostrar el inmueble porque está pendiente
        $responsePublico = $this->get(route('inicio'));
        $responsePublico->assertDontSee('Casa Campestre de Moderacion');

        // 4. El Admin ve la alerta de inmuebles pendientes en el Dashboard
        $responseAdminDashboard = $this->actingAs($admin)->get(route('dashboard.index'));
        $responseAdminDashboard->assertStatus(200);
        $responseAdminDashboard->assertSee('requiere tu autorización');

        // 5. El Admin aprueba el inmueble
        $responseAprobar = $this->actingAs($admin)->patch(route('inmueble.estado', $inmueble->id), [
            'estado_publicacion' => 'disponible',
        ]);
        $responseAprobar->assertStatus(302);

        // 6. Ahora el estado es 'disponible'
        $inmueble->refresh();
        $this->assertEquals('disponible', $inmueble->detalle_inmueble->estado_publicacion);

        // 7. Ahora el portal público SÍ lo muestra
        $responsePublicoAprobado = $this->get(route('inicio'));
        $responsePublicoAprobado->assertSee('Casa Campestre de Moderacion');
    }
}
