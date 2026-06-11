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
 * Bloque C — RA7: Servicios web (API REST)
 *
 * C1 (1 pto.)  — GET /api/v1/testimonios
 * C2 (1 pto.)  — GET /api/v1/casas/{casa}/testimonios
 * C3 (2 ptos.) — POST /api/v1/testimonios
 * C4 (3 ptos.) — PUT/DELETE/approve con Policy JSON
 */
class BloqueCTest extends TestCase
{
    use RefreshDatabase;
    use CreatesFixtures;

    // ── helpers ───────────────────────────────────────────────────────────────

    private function tokenPara(User $user): string
    {
        return $user->createToken('test')->plainTextToken;
    }

    private function authHeaders(User $user): array
    {
        return ['Authorization' => 'Bearer ' . $this->tokenPara($user)];
    }

    // ── C1: listado público ───────────────────────────────────────────────────

    #[Puntos(0.25, 'RA7', 'C1')]
    public function test_c1_listado_publico_devuelve_200(): void
    {
        $this->getJson('/api/v1/testimonios')->assertStatus(200);
    }

    #[Puntos(0.25, 'RA7', 'C1')]
    public function test_c1_solo_devuelve_aprobados(): void
    {
        $user = $this->crearInquilino();
        $this->crearTestimonio(['user_id' => $user->id, 'fecha_aprobacion' => now(),  'contenido' => 'Aprobado']);
        $this->crearTestimonio(['user_id' => $user->id, 'fecha_aprobacion' => null,   'contenido' => 'Pendiente']);

        $response = $this->getJson('/api/v1/testimonios');
        $data = collect($response->json('data') ?? $response->json());

        $contenidos = $data->pluck('contenido');
        $this->assertContains('Aprobado',  $contenidos->toArray());
        $this->assertNotContains('Pendiente', $contenidos->toArray());
    }

    #[Puntos(0.25, 'RA7', 'C1')]
    public function test_c1_resource_expone_campos_requeridos(): void
    {
        $user = $this->crearInquilino([
            'name'       => 'Usuario Resource',
            'avatar_url' => 'https://example.com/avatar.jpg',
        ]);
        $this->crearTestimonio([
            'user_id'          => $user->id,
            'contenido'        => 'Contenido resource',
            'valoracion'       => 4.5,
            'fecha_aprobacion' => now(),
        ]);

        $response = $this->getJson('/api/v1/testimonios');
        $item = collect($response->json('data') ?? $response->json())->first();

        foreach (['id', 'contenido', 'valoracion', 'fecha_aprobacion'] as $campo) {
            $this->assertArrayHasKey($campo, $item, "El resource debe exponer el campo {$campo}");
        }
        // El resource debe incluir datos del usuario
        $this->assertNotNull(
            data_get($item, 'usuario.name') ?? data_get($item, 'name'),
            'El resource debe incluir el nombre del usuario'
        );
    }

    #[Puntos(0.25, 'RA7', 'C1')]
    public function test_c1_ordenado_por_fecha_aprobacion_desc(): void
    {
        $user     = $this->crearInquilino();
        $primero  = $this->crearTestimonio(['user_id' => $user->id, 'contenido' => 'Más reciente', 'fecha_aprobacion' => now()]);
        $segundo  = $this->crearTestimonio(['user_id' => $user->id, 'contenido' => 'Más antiguo',  'fecha_aprobacion' => now()->subDay()]);

        $response = $this->getJson('/api/v1/testimonios');
        $items    = collect($response->json('data') ?? $response->json());

        $this->assertEquals('Más reciente', $items->first()['contenido']);
    }

    // ── C2: testimonios de una casa ───────────────────────────────────────────

    #[Puntos(0.5, 'RA7', 'C2')]
    public function test_c2_devuelve_testimonios_aprobados_de_la_casa(): void
    {
        $propietario = $this->crearUsuario();
        $casa        = $this->crearCasa(['propietario_id' => $propietario->id]);
        $user        = $this->crearInquilino();

        $this->crearTestimonio(['user_id' => $user->id, 'casa_id' => $casa->id, 'contenido' => 'De esta casa',    'fecha_aprobacion' => now()]);
        $this->crearTestimonio(['user_id' => $user->id, 'casa_id' => $casa->id, 'contenido' => 'Pendiente casa',  'fecha_aprobacion' => null]);

        $response = $this->getJson("/api/v1/casas/{$casa->id}/testimonios");
        $response->assertStatus(200);

        $contenidos = collect($response->json('data') ?? $response->json())->pluck('contenido');
        $this->assertContains('De esta casa',   $contenidos->toArray());
        $this->assertNotContains('Pendiente casa', $contenidos->toArray());
    }

    #[Puntos(0.5, 'RA7', 'C2')]
    public function test_c2_devuelve_404_si_casa_no_existe(): void
    {
        $this->getJson('/api/v1/casas/99999/testimonios')->assertStatus(404);
    }

    // ── C3: creación autenticada ──────────────────────────────────────────────

    #[Puntos(0.5, 'RA7', 'C3')]
    public function test_c3_inquilino_puede_crear_testimonio(): void
    {
        $user = $this->crearInquilino();

        $response = $this->withHeaders($this->authHeaders($user))
                         ->postJson('/api/v1/testimonios', [
                             'contenido'  => 'Testimonio API',
                             'valoracion' => 4.5,
                         ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('testimonios', [
            'user_id'   => $user->id,
            'contenido' => 'Testimonio API',
        ]);
    }

    #[Puntos(0.5, 'RA7', 'C3')]
    public function test_c3_no_inquilino_recibe_403(): void
    {
        $noInquilino = $this->crearUsuario();

        $this->withHeaders($this->authHeaders($noInquilino))
             ->postJson('/api/v1/testimonios', [
                 'contenido'  => 'Testimonio',
                 'valoracion' => 4.0,
             ])
             ->assertStatus(403);
    }

    #[Puntos(0.5, 'RA7', 'C3')]
    public function test_c3_sin_autenticacion_devuelve_401(): void
    {
        $this->postJson('/api/v1/testimonios', [
            'contenido'  => 'Sin auth',
            'valoracion' => 3.0,
        ])->assertStatus(401);
    }

    #[Puntos(0.5, 'RA7', 'C3')]
    public function test_c3_respuesta_es_json_con_estructura_resource(): void
    {
        $user = $this->crearInquilino();

        $response = $this->withHeaders($this->authHeaders($user))
                         ->postJson('/api/v1/testimonios', [
                             'contenido'  => 'Testimonio JSON',
                             'valoracion' => 4.0,
                         ]);

        $response->assertStatus(201);
        $item = $response->json('data') ?? $response->json();
        $this->assertArrayHasKey('id',        $item);
        $this->assertArrayHasKey('contenido', $item);
    }

    // ── C4: CRUD completo con Policy ──────────────────────────────────────────

    #[Puntos(0.5, 'RA7', 'C4')]
    public function test_c4_autor_puede_actualizar_testimonio_pendiente(): void
    {
        $user = $this->crearInquilino();
        $t    = $this->crearTestimonio(['user_id' => $user->id, 'fecha_aprobacion' => null]);

        $this->withHeaders($this->authHeaders($user))
             ->putJson("/api/v1/testimonios/{$t->id}", [
                 'contenido'  => 'Actualizado vía API',
                 'valoracion' => 3.5,
             ])
             ->assertStatus(200);

        $this->assertDatabaseHas('testimonios', ['id' => $t->id, 'contenido' => 'Actualizado vía API']);
    }

    #[Puntos(0.5, 'RA7', 'C4')]
    public function test_c4_no_autor_recibe_403_al_actualizar(): void
    {
        $user1 = $this->crearInquilino();
        $user2 = $this->crearInquilino();
        $t     = $this->crearTestimonio(['user_id' => $user1->id]);

        $this->withHeaders($this->authHeaders($user2))
             ->putJson("/api/v1/testimonios/{$t->id}", [
                 'contenido'  => 'Intento ajeno',
                 'valoracion' => 3.0,
             ])
             ->assertStatus(403);
    }

    #[Puntos(0.5, 'RA7', 'C4')]
    public function test_c4_no_se_puede_actualizar_testimonio_aprobado(): void
    {
        $user = $this->crearInquilino();
        $t    = $this->crearTestimonio(['user_id' => $user->id, 'fecha_aprobacion' => now()]);

        $this->withHeaders($this->authHeaders($user))
             ->putJson("/api/v1/testimonios/{$t->id}", [
                 'contenido'  => 'Edición ilegal',
                 'valoracion' => 5.0,
             ])
             ->assertStatus(403);
    }

    #[Puntos(0.5, 'RA7', 'C4')]
    public function test_c4_autor_puede_eliminar_testimonio(): void
    {
        $user = $this->crearInquilino();
        $t    = $this->crearTestimonio(['user_id' => $user->id]);

        $this->withHeaders($this->authHeaders($user))
             ->deleteJson("/api/v1/testimonios/{$t->id}")
             ->assertStatus(204);

        $this->assertDatabaseMissing('testimonios', ['id' => $t->id]);
    }

    #[Puntos(0.5, 'RA7', 'C4')]
    public function test_c4_propietario_puede_aprobar_via_api(): void
    {
        $propietario = $this->crearUsuario();
        $casa        = $this->crearCasa(['propietario_id' => $propietario->id]);
        $user        = $this->crearInquilino();
        $t           = $this->crearTestimonio(['user_id' => $user->id, 'casa_id' => $casa->id]);

        $this->withHeaders($this->authHeaders($propietario))
             ->putJson("/api/v1/testimonios/{$t->id}/approve")
             ->assertStatus(200);

        $this->assertNotNull($t->fresh()->fecha_aprobacion);
    }

    #[Puntos(0.5, 'RA7', 'C4')]
    public function test_c4_testimonio_general_devuelve_422_al_aprobar_via_api(): void
    {
        $user = $this->crearInquilino();
        $t    = $this->crearTestimonio(['user_id' => $user->id, 'casa_id' => null]);

        $this->withHeaders($this->authHeaders($user))
             ->putJson("/api/v1/testimonios/{$t->id}/approve")
             ->assertStatus(422);
    }
}
