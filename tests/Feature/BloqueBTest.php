<?php

namespace Tests\Feature;

use App\Models\Casa;
use App\Models\Testimonio;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\CreatesFixtures;
use Tests\Support\Puntos;
use Tests\TestCase;

/**
 * Bloque B — RA6: Acceso a almacenes de datos
 *
 * B1 (1 pto.)  — Controlador y rutas
 * B2 (1 pto.)  — Listado, create y store
 * B3 (2 ptos.) — Edición y eliminación
 * B4 (2 ptos.) — Restricción a inquilinos
 * B5 (2 ptos.) — Aprobación por propietario
 * B6 (2 ptos.) — Revisión por administrador
 */
class BloqueBTest extends TestCase
{
    use RefreshDatabase;
    use CreatesFixtures;

    // ── B1: rutas ─────────────────────────────────────────────────────────────

    #[Puntos(0.25, 'RA6', 'B1')]
    public function test_ruta_index_testimonios_existe(): void
    {
        $this->actingAs($this->crearInquilino())
             ->get('/testimonios')
             ->assertStatus(200);
    }

    #[Puntos(0.25, 'RA6', 'B1')]
    public function test_ruta_create_testimonios_existe(): void
    {
        $this->actingAs($this->crearInquilino())
             ->get('/testimonios/create')
             ->assertStatus(200);
    }

    #[Puntos(0.25, 'RA6', 'B1')]
    public function test_ruta_edit_testimonios_existe(): void
    {
        $user = $this->crearInquilino();
        $t    = $this->crearTestimonio(['user_id' => $user->id]);

        $this->actingAs($user)
             ->get("/testimonios/{$t->id}/edit")
             ->assertStatus(200);
    }

    #[Puntos(0.25, 'RA6', 'B1')]
    public function test_rutas_requieren_autenticacion(): void
    {
        $t = $this->crearTestimonio();

        $this->get('/testimonios')->assertRedirect('/login');
        $this->get('/testimonios/create')->assertRedirect('/login');
        $this->get("/testimonios/{$t->id}/edit")->assertRedirect('/login');
    }

    // ── B2a: index ────────────────────────────────────────────────────────────

    #[Puntos(0.25, 'RA6', 'B2')]
    public function test_index_muestra_solo_testimonios_del_usuario_autenticado(): void
    {
        $user1 = $this->crearInquilino();
        $user2 = $this->crearInquilino();

        $t1 = $this->crearTestimonio(['user_id' => $user1->id, 'contenido' => 'Testimonio de user1']);
        $t2 = $this->crearTestimonio(['user_id' => $user2->id, 'contenido' => 'Testimonio de user2']);

        $this->actingAs($user1)
             ->get('/testimonios')
             ->assertSee('Testimonio de user1')
             ->assertDontSee('Testimonio de user2');
    }

    #[Puntos(0.25, 'RA6', 'B2')]
    public function test_index_muestra_estado_aprobado_y_pendiente(): void
    {
        $user = $this->crearInquilino();
        $this->crearTestimonio(['user_id' => $user->id, 'fecha_aprobacion' => now()]);
        $this->crearTestimonio(['user_id' => $user->id, 'fecha_aprobacion' => null]);

        $response = $this->actingAs($user)->get('/testimonios');
        $response->assertSeeInOrder(['Aprobado', 'Pendiente'], false);
    }

    // ── B2b: store ────────────────────────────────────────────────────────────

    #[Puntos(0.25, 'RA6', 'B2')]
    public function test_store_crea_testimonio_para_usuario_autenticado(): void
    {
        $user = $this->crearInquilino();

        $this->actingAs($user)->post('/testimonios', [
            'contenido'  => 'Mi testimonio de prueba',
            'valoracion' => 4.5,
        ])->assertRedirect();

        $this->assertDatabaseHas('testimonios', [
            'user_id'   => $user->id,
            'contenido' => 'Mi testimonio de prueba',
        ]);
    }

    #[Puntos(0.25, 'RA6', 'B2')]
    public function test_store_ignora_user_id_enviado_en_peticion(): void
    {
        $user    = $this->crearInquilino();
        $otro    = $this->crearUsuario();

        $this->actingAs($user)->post('/testimonios', [
            'user_id'    => $otro->id,     // intento de suplantación
            'contenido'  => 'Testimonio',
            'valoracion' => 4.0,
        ]);

        $this->assertDatabaseMissing('testimonios', ['user_id' => $otro->id]);
        $this->assertDatabaseHas('testimonios',    ['user_id' => $user->id]);
    }

    #[Puntos(0, 'RA6', 'B2')]
    public function test_store_fecha_aprobacion_es_null(): void
    {
        $user = $this->crearInquilino();
        $this->actingAs($user)->post('/testimonios', [
            'contenido'  => 'Testimonio',
            'valoracion' => 3.0,
        ]);

        $t = Testimonio::where('user_id', $user->id)->latest()->first();
        $this->assertNull($t->fecha_aprobacion);
    }

    #[Puntos(0, 'RA6', 'B2')]
    public function test_store_valida_contenido_requerido(): void
    {
        $user = $this->crearInquilino();
        $this->actingAs($user)->post('/testimonios', [
            'contenido'  => '',
            'valoracion' => 4.0,
        ])->assertSessionHasErrors('contenido');
    }

    #[Puntos(0, 'RA6', 'B2')]
    public function test_store_valida_valoracion_entre_0_y_5(): void
    {
        $user = $this->crearInquilino();
        $this->actingAs($user)->post('/testimonios', [
            'contenido'  => 'Testimonio',
            'valoracion' => 6.0,
        ])->assertSessionHasErrors('valoracion');
    }

    #[Puntos(0, 'RA6', 'B2')]
    public function test_store_valida_casa_id_existe_si_se_envia(): void
    {
        $user = $this->crearInquilino();
        $this->actingAs($user)->post('/testimonios', [
            'contenido'  => 'Testimonio',
            'valoracion' => 4.0,
            'casa_id'    => 99999,
        ])->assertSessionHasErrors('casa_id');
    }

    // ── B3: edición ───────────────────────────────────────────────────────────

    #[Puntos(0.5, 'RA6', 'B3')]
    public function test_update_permite_editar_testimonio_pendiente_propio(): void
    {
        $user = $this->crearInquilino();
        $t    = $this->crearTestimonio(['user_id' => $user->id, 'fecha_aprobacion' => null]);

        $this->actingAs($user)->put("/testimonios/{$t->id}", [
            'contenido'  => 'Contenido actualizado',
            'valoracion' => 3.5,
        ])->assertRedirect();

        $this->assertDatabaseHas('testimonios', [
            'id'        => $t->id,
            'contenido' => 'Contenido actualizado',
        ]);
    }

    #[Puntos(0.5, 'RA6', 'B3')]
    public function test_update_rechaza_edicion_de_testimonio_aprobado(): void
    {
        $user = $this->crearInquilino();
        $t    = $this->crearTestimonio(['user_id' => $user->id, 'fecha_aprobacion' => now()]);

        $this->actingAs($user)->put("/testimonios/{$t->id}", [
            'contenido'  => 'Intento de editar aprobado',
            'valoracion' => 5.0,
        ])->assertStatus(403);

        $this->assertDatabaseMissing('testimonios', ['contenido' => 'Intento de editar aprobado']);
    }

    #[Puntos(0.5, 'RA6', 'B3')]
    public function test_update_devuelve_403_si_no_es_el_autor(): void
    {
        $user1 = $this->crearInquilino();
        $user2 = $this->crearInquilino();
        $t     = $this->crearTestimonio(['user_id' => $user1->id]);

        $this->actingAs($user2)->put("/testimonios/{$t->id}", [
            'contenido'  => 'Edición ajena',
            'valoracion' => 3.0,
        ])->assertStatus(403);
    }

    #[Puntos(0.5, 'RA6', 'B3')]
    public function test_destroy_elimina_testimonio_propio(): void
    {
        $user = $this->crearInquilino();
        $t    = $this->crearTestimonio(['user_id' => $user->id]);

        $this->actingAs($user)->delete("/testimonios/{$t->id}")
             ->assertRedirect();

        $this->assertDatabaseMissing('testimonios', ['id' => $t->id]);
    }

    #[Puntos(0, 'RA6', 'B3')]
    public function test_destroy_devuelve_403_si_no_es_el_autor(): void
    {
        $user1 = $this->crearInquilino();
        $user2 = $this->crearInquilino();
        $t     = $this->crearTestimonio(['user_id' => $user1->id]);

        $this->actingAs($user2)->delete("/testimonios/{$t->id}")
             ->assertStatus(403);

        $this->assertDatabaseHas('testimonios', ['id' => $t->id]);
    }

    // ── B4: restricción a inquilinos ──────────────────────────────────────────

    #[Puntos(0.5, 'RA6', 'B4')]
    public function test_no_inquilino_no_puede_crear_testimonio(): void
    {
        $noInquilino = $this->crearUsuario(); // sin booking

        $this->actingAs($noInquilino)->post('/testimonios', [
            'contenido'  => 'Intento',
            'valoracion' => 4.0,
        ])->assertStatus(403);
    }

    #[Puntos(0.5, 'RA6', 'B4')]
    public function test_inquilino_puede_crear_testimonio(): void
    {
        $inquilino = $this->crearInquilino();

        $this->actingAs($inquilino)->post('/testimonios', [
            'contenido'  => 'Testimonio válido',
            'valoracion' => 4.0,
        ])->assertRedirect();

        $this->assertDatabaseHas('testimonios', ['user_id' => $inquilino->id]);
    }

    #[Puntos(0.5, 'RA6', 'B4')]
    public function test_no_inquilino_no_puede_editar_testimonio(): void
    {
        $inquilino = $this->crearInquilino();
        $noInquilino = $this->crearUsuario();
        // Creamos el testimonio directamente sin pasar por la validación de inquilino
        $t = Testimonio::create([
            'user_id'    => $inquilino->id,
            'contenido'  => 'Test',
            'valoracion' => 4.0,
        ]);

        $this->actingAs($noInquilino)->put("/testimonios/{$t->id}", [
            'contenido'  => 'Edición',
            'valoracion' => 3.0,
        ])->assertStatus(403);
    }

    #[Puntos(0.5, 'RA6', 'B4')]
    public function test_no_inquilino_no_puede_eliminar_testimonio(): void
    {
        $inquilino = $this->crearInquilino();
        $noInquilino = $this->crearUsuario();
        $t = Testimonio::create([
            'user_id'    => $inquilino->id,
            'contenido'  => 'Test',
            'valoracion' => 4.0,
        ]);

        $this->actingAs($noInquilino)->delete("/testimonios/{$t->id}")
             ->assertStatus(403);
    }

    // ── B5: aprobación por propietario ────────────────────────────────────────

    #[Puntos(0.5, 'RA6', 'B5')]
    public function test_propietario_puede_aprobar_testimonio_de_su_casa(): void
    {
        $propietario = $this->crearUsuario();
        $casa        = $this->crearCasa(['propietario_id' => $propietario->id]);
        $user        = $this->crearInquilino();
        $t           = $this->crearTestimonio(['user_id' => $user->id, 'casa_id' => $casa->id]);

        $this->actingAs($propietario)
             ->put("/testimonios/{$t->id}/approve")
             ->assertRedirect();

        $this->assertNotNull($t->fresh()->fecha_aprobacion);
    }

    #[Puntos(0.5, 'RA6', 'B5')]
    public function test_no_propietario_no_puede_aprobar(): void
    {
        $propietario = $this->crearUsuario();
        $otro        = $this->crearUsuario();
        $casa        = $this->crearCasa(['propietario_id' => $propietario->id]);
        $user        = $this->crearInquilino();
        $t           = $this->crearTestimonio(['user_id' => $user->id, 'casa_id' => $casa->id]);

        $this->actingAs($otro)
             ->put("/testimonios/{$t->id}/approve")
             ->assertStatus(403);

        $this->assertNull($t->fresh()->fecha_aprobacion);
    }

    #[Puntos(0.5, 'RA6', 'B5')]
    public function test_testimonio_general_devuelve_422_al_aprobar(): void
    {
        $user = $this->crearInquilino();
        $t    = $this->crearTestimonio(['user_id' => $user->id, 'casa_id' => null]);

        // Necesitamos un usuario que pudiera ser propietario, pero la validación
        // debe fallar antes por casa_id == null
        $this->actingAs($user)
             ->put("/testimonios/{$t->id}/approve")
             ->assertStatus(422);
    }

    #[Puntos(0.5, 'RA6', 'B5')]
    public function test_aprobacion_actualiza_fecha_aprobacion_con_now(): void
    {
        $propietario = $this->crearUsuario();
        $casa        = $this->crearCasa(['propietario_id' => $propietario->id]);
        $user        = $this->crearInquilino();
        $t           = $this->crearTestimonio(['user_id' => $user->id, 'casa_id' => $casa->id]);

        $antes = now()->subMinute(); // margen de 5 segundos para evitar falsos negativos
        $this->actingAs($propietario)->put("/testimonios/{$t->id}/approve");
        $despues = now()->addMinute();

        $fechaAprobacion = $t->fresh()->fecha_aprobacion;
        $this->assertNotNull($fechaAprobacion);
        $this->assertTrue($fechaAprobacion->between($antes, $despues));
    }

    // ── B6: revisión por administrador ────────────────────────────────────────

    #[Puntos(0.5, 'RA6', 'B6')]
    public function test_admin_puede_acceder_a_revisar_testimonio(): void
    {
        $admin = $this->crearAdmin();
        $t     = $this->crearTestimonio();

        $this->actingAs($admin)
             ->get("/testimonios/{$t->id}/revisar")
             ->assertStatus(200);
    }

    #[Puntos(0.5, 'RA6', 'B6')]
    public function test_no_admin_no_puede_revisar_testimonio(): void
    {
        $user = $this->crearInquilino();
        $t    = $this->crearTestimonio(['user_id' => $user->id]);

        $this->actingAs($user)
             ->get("/testimonios/{$t->id}/revisar")
             ->assertStatus(403);
    }

    #[Puntos(0.5, 'RA6', 'B6')]
    public function test_admin_puede_aprobar_desde_revisar(): void
    {
        $admin = $this->crearAdmin();
        $t     = $this->crearTestimonio();

        $this->actingAs($admin)
             ->post("/testimonios/{$t->id}/revisar", ['accion' => 'aprobar'])
             ->assertRedirect();

        $this->assertNotNull($t->fresh()->fecha_aprobacion);
    }

    #[Puntos(0.5, 'RA6', 'B6')]
    public function test_admin_puede_rechazar_y_elimina_testimonio(): void
    {
        $admin = $this->crearAdmin();
        $t     = $this->crearTestimonio();

        $this->actingAs($admin)
             ->post("/testimonios/{$t->id}/revisar", ['accion' => 'rechazar'])
             ->assertRedirect();

        $this->assertDatabaseMissing('testimonios', ['id' => $t->id]);
    }
}
