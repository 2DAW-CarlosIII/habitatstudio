<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Casa;
use App\Models\Testimonio;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Tests\Support\CreatesFixtures;
use Tests\Support\Puntos;
use Tests\TestCase;

/**
 * Bloque A — RA5: Separación lógica de negocio / presentación
 *
 * A1 (1 pto.)  — Migración propietario_id en casas
 * A2 (1 pto.)  — Campos avatar_url y descripcion_perfil en users
 * A3 (1 pto.)  — Migración y modelo Testimonio
 * A4 (1 pto.)  — TestimonioSeeder
 * A5 (2 ptos.) — Vista home dinámica
 * A6 (2 ptos.) — Estrellas (cubierto en Unit/ModeloTest)
 * A7 (2 ptos.) — Testimonios en vista show de casa
 */
class BloqueATest extends TestCase
{
    use RefreshDatabase;
    use CreatesFixtures;

    // ── A1 ────────────────────────────────────────────────────────────────────

    #[Puntos(0.5, 'RA5', 'A1')]
    public function test_casas_tiene_columna_propietario_id(): void
    {
        $this->assertTrue(
            Schema::hasColumn('casas', 'propietario_id'),
            'La tabla casas debe tener la columna propietario_id'
        );
    }

    #[Puntos(0.5, 'RA5', 'A1')]
    public function test_casas_no_tiene_nombre_propietario(): void
    {
        $this->assertFalse(
            Schema::hasColumn('casas', 'nombre_propietario'),
            'La columna nombre_propietario debe haber sido eliminada de casas'
        );
    }

    #[Puntos(0, 'RA5', 'A1')]   // puntos ya contados arriba; este verifica FK
    public function test_propietario_id_es_fk_a_users(): void
    {
        $propietario = $this->crearUsuario();
        $casa = $this->crearCasa(['propietario_id' => $propietario->id]);
        $this->assertEquals($propietario->id, $casa->fresh()->propietario_id);
    }

    #[Puntos(0, 'RA5', 'A1')]
    public function test_relacion_casa_propietario_devuelve_user(): void
    {
        $propietario = $this->crearUsuario();
        $casa = $this->crearCasa(['propietario_id' => $propietario->id]);
        $this->assertInstanceOf(User::class, $casa->propietario);
        $this->assertEquals($propietario->id, $casa->propietario->id);
    }

    #[Puntos(0, 'RA5', 'A1')]
    public function test_relacion_user_casas_devuelve_collection(): void
    {
        $propietario = $this->crearUsuario();
        $this->crearCasa(['propietario_id' => $propietario->id]);
        $this->crearCasa(['propietario_id' => $propietario->id]);
        $this->assertCount(2, $propietario->casas);
    }

    // ── A2 ────────────────────────────────────────────────────────────────────

    #[Puntos(0.5, 'RA5', 'A2')]
    public function test_users_tiene_avatar_url(): void
    {
        $this->assertTrue(
            Schema::hasColumn('users', 'avatar_url'),
            'La tabla users debe tener la columna avatar_url'
        );
    }

    #[Puntos(0.5, 'RA5', 'A2')]
    public function test_users_tiene_descripcion_perfil(): void
    {
        $this->assertTrue(
            Schema::hasColumn('users', 'descripcion_perfil'),
            'La tabla users debe tener la columna descripcion_perfil'
        );
    }

    #[Puntos(0, 'RA5', 'A2')]
    public function test_avatar_url_es_nullable(): void
    {
        $user = $this->crearUsuario(['avatar_url' => null]);
        $this->assertNull($user->fresh()->avatar_url);
    }

    #[Puntos(0, 'RA5', 'A2')]
    public function test_descripcion_perfil_es_nullable(): void
    {
        $user = $this->crearUsuario(['descripcion_perfil' => null]);
        $this->assertNull($user->fresh()->descripcion_perfil);
    }

    // ── A3 ────────────────────────────────────────────────────────────────────

    #[Puntos(0.25, 'RA5', 'A3')]
    public function test_tabla_testimonios_existe(): void
    {
        $this->assertTrue(
            Schema::hasTable('testimonios'),
            'La tabla testimonios debe existir'
        );
    }

    #[Puntos(0.25, 'RA5', 'A3')]
    public function test_testimonios_tiene_columnas_requeridas(): void
    {
        foreach (['user_id', 'casa_id', 'contenido', 'valoracion', 'fecha_aprobacion'] as $col) {
            $this->assertTrue(
                Schema::hasColumn('testimonios', $col),
                "La tabla testimonios debe tener la columna {$col}"
            );
        }
    }

    #[Puntos(0.25, 'RA5', 'A3')]
    public function test_casa_id_es_nullable_en_testimonios(): void
    {
        $user = $this->crearInquilino();
        $t = Testimonio::create([
            'user_id'    => $user->id,
            'casa_id'    => null,
            'contenido'  => 'Sin casa',
            'valoracion' => 5.0,
        ]);
        $this->assertNull($t->casa_id);
    }

    #[Puntos(0.25, 'RA5', 'A3')]
    public function test_relacion_testimonio_usuario(): void
    {
        $user = $this->crearInquilino();
        $t    = $this->crearTestimonio(['user_id' => $user->id]);
        $this->assertEquals($user->id, $t->usuario->id);
    }

    #[Puntos(0, 'RA5', 'A3')]
    public function test_relacion_testimonio_casa(): void
    {
        $propietario = $this->crearUsuario();
        $casa = $this->crearCasa(['propietario_id' => $propietario->id]);
        $user = $this->crearInquilino();
        $t    = $this->crearTestimonio(['user_id' => $user->id, 'casa_id' => $casa->id]);
        $this->assertEquals($casa->id, $t->casa->id);
    }

    // ── A4 ────────────────────────────────────────────────────────────────────

    #[Puntos(0.5, 'RA5', 'A4')]
    public function test_seeder_inserta_al_menos_5_testimonios(): void
    {
        Artisan::call('db:seed');
        $this->assertGreaterThanOrEqual(5, Testimonio::count());
    }

    #[Puntos(0.25, 'RA5', 'A4')]
    public function test_seeder_tiene_al_menos_2_aprobados(): void
    {
        Artisan::call('db:seed');
        $this->assertGreaterThanOrEqual(
            2,
            Testimonio::whereNotNull('fecha_aprobacion')->count()
        );
    }

    #[Puntos(0.25, 'RA5', 'A4')]
    public function test_seeder_tiene_al_menos_1_sin_casa(): void
    {
        Artisan::call('db:seed');
        $this->assertGreaterThanOrEqual(
            1,
            Testimonio::whereNull('casa_id')->count()
        );
    }

    #[Puntos(0, 'RA5', 'A4')]
    public function test_seeder_tiene_valoracion_con_decimal(): void
    {
        Artisan::call('db:seed');
        $conDecimal = Testimonio::all()->filter(
            fn($t) => fmod((float) $t->valoracion, 1.0) !== 0.0
        );
        $this->assertGreaterThanOrEqual(1, $conDecimal->count());
    }

    #[Puntos(0, 'RA5', 'A4')]
    public function test_seeder_user_ids_son_inquilinos(): void
    {
        Artisan::call('db:seed');
        $userIds = Testimonio::pluck('user_id')->unique();
        foreach ($userIds as $uid) {
            $esInquilino = Booking::where('inquilino_id', $uid)->exists();
            $this->assertTrue($esInquilino, "El user_id {$uid} no es inquilino");
        }
    }

    // ── A5 ────────────────────────────────────────────────────────────────────

    #[Puntos(1.0, 'RA5', 'A5')]
    public function test_home_solo_muestra_testimonios_aprobados(): void
    {
        $user    = $this->crearInquilino();
        $aprobado = $this->crearTestimonio([
            'user_id'          => $user->id,
            'contenido'        => 'Testimonio aprobado visible',
            'fecha_aprobacion' => now(),
        ]);
        $pendiente = $this->crearTestimonio([
            'user_id'          => $user->id,
            'contenido'        => 'Testimonio pendiente oculto',
            'fecha_aprobacion' => null,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Testimonio aprobado visible');
        $response->assertDontSee('Testimonio pendiente oculto');
    }

    #[Puntos(0.5, 'RA5', 'A5')]
    public function test_home_muestra_nombre_del_usuario(): void
    {
        $user = $this->crearInquilino(['name' => 'María Testimonial']);
        $this->crearTestimonio([
            'user_id'          => $user->id,
            'fecha_aprobacion' => now(),
        ]);

        $this->get('/')->assertSee('María Testimonial');
    }

    #[Puntos(0.5, 'RA5', 'A5')]
    public function test_home_muestra_contenido_del_testimonio(): void
    {
        $user = $this->crearInquilino();
        $this->crearTestimonio([
            'user_id'          => $user->id,
            'contenido'        => 'Contenido único de prueba XYZ987',
            'fecha_aprobacion' => now(),
        ]);

        $this->get('/')->assertSee('Contenido único de prueba XYZ987');
    }

    // ── A7 ────────────────────────────────────────────────────────────────────

    #[Puntos(1.0, 'RA5', 'A7')]
    public function test_show_casa_muestra_testimonios_aprobados_de_esa_casa(): void
    {
        $propietario = $this->crearUsuario();
        $casa        = $this->crearCasa(['propietario_id' => $propietario->id]);
        $user        = $this->crearInquilino();

        $visible = $this->crearTestimonio([
            'user_id'          => $user->id,
            'casa_id'          => $casa->id,
            'contenido'        => 'Testimonio visible de la casa',
            'fecha_aprobacion' => now(),
        ]);
        $oculto = $this->crearTestimonio([
            'user_id'          => $user->id,
            'casa_id'          => $casa->id,
            'contenido'        => 'Testimonio pendiente de la casa',
            'fecha_aprobacion' => null,
        ]);

        $response = $this->get("/casa/{$casa->id}");
        $response->assertStatus(200);
        $response->assertSee('Testimonio visible de la casa');
        $response->assertDontSee('Testimonio pendiente de la casa');
    }

    #[Puntos(1.0, 'RA5', 'A7')]
    public function test_show_casa_no_muestra_testimonios_de_otras_casas(): void
    {
        $propietario = $this->crearUsuario();
        $casa1       = $this->crearCasa(['propietario_id' => $propietario->id]);
        $casa2       = $this->crearCasa(['propietario_id' => $propietario->id]);
        $user        = $this->crearInquilino();

        $this->crearTestimonio([
            'user_id'          => $user->id,
            'casa_id'          => $casa2->id,
            'contenido'        => 'Testimonio de otra casa',
            'fecha_aprobacion' => now(),
        ]);

        $this->get("/casa/{$casa1->id}")
             ->assertDontSee('Testimonio de otra casa');
    }
}
