<?php

namespace Tests\Unit;

use App\Models\Casa;
use App\Models\Testimonio;
use App\Models\User;
use PHPUnit\Framework\TestCase;
use Tests\Support\Puntos;

/**
 * Tests unitarios puros — no necesitan base de datos.
 * Verifican la lógica interna de los modelos.
 */
class ModeloTest extends TestCase
{
    // ── A6: método estrellas() ────────────────────────────────────────────────

    #[Puntos(0.5, 'RA5', 'A6')]
    public function test_estrellas_cinco_enteras(): void
    {
        $t = new Testimonio(['valoracion' => 5.0]);
        $this->assertSame(
            ['full', 'full', 'full', 'full', 'full'],
            $t->estrellas()
        );
    }

    #[Puntos(0.5, 'RA5', 'A6')]
    public function test_estrellas_con_media(): void
    {
        $t = new Testimonio(['valoracion' => 4.5]);
        $estrellas = $t->estrellas();
        $this->assertCount(5, $estrellas);
        $this->assertSame('full', $estrellas[0]);
        $this->assertSame('full', $estrellas[1]);
        $this->assertSame('full', $estrellas[2]);
        $this->assertSame('full', $estrellas[3]);
        $this->assertSame('half', $estrellas[4]);
    }

    #[Puntos(0.5, 'RA5', 'A6')]
    public function test_estrellas_con_vacias(): void
    {
        $t = new Testimonio(['valoracion' => 3.0]);
        $estrellas = $t->estrellas();
        $this->assertSame(['full', 'full', 'full', 'empty', 'empty'], $estrellas);
    }

    #[Puntos(0.5, 'RA5', 'A6')]
    public function test_estrellas_con_media_y_vacias(): void
    {
        $t = new Testimonio(['valoracion' => 2.5]);
        $estrellas = $t->estrellas();
        $this->assertSame(['full', 'full', 'half', 'empty', 'empty'], $estrellas);
    }

    #[Puntos(0.5, 'RA5', 'A6')]
    public function test_estrellas_cero(): void
    {
        $t = new Testimonio(['valoracion' => 0.0]);
        $this->assertSame(
            ['empty', 'empty', 'empty', 'empty', 'empty'],
            $t->estrellas()
        );
    }

    // ── A1: relación propietario en Casa ──────────────────────────────────────

    #[Puntos(0.25, 'RA5', 'A1')]
    public function test_casa_tiene_relacion_propietario(): void
    {
        $this->assertTrue(
            method_exists(Casa::class, 'propietario'),
            'El modelo Casa debe tener el método propietario()'
        );
    }

    // ── A1: relación casas en User ────────────────────────────────────────────

    #[Puntos(0.25, 'RA5', 'A1')]
    public function test_user_tiene_relacion_casas(): void
    {
        $this->assertTrue(
            method_exists(User::class, 'casas'),
            'El modelo User debe tener el método casas()'
        );
    }

    // ── A3: relaciones de Testimonio ──────────────────────────────────────────

    #[Puntos(0.25, 'RA5', 'A3')]
    public function test_testimonio_tiene_relacion_usuario(): void
    {
        $this->assertTrue(
            method_exists(Testimonio::class, 'usuario'),
            'El modelo Testimonio debe tener el método usuario()'
        );
    }

    #[Puntos(0.25, 'RA5', 'A3')]
    public function test_testimonio_tiene_relacion_casa(): void
    {
        $this->assertTrue(
            method_exists(Testimonio::class, 'casa'),
            'El modelo Testimonio debe tener el método casa()'
        );
    }

    #[Puntos(0.25, 'RA5', 'A3')]
    public function test_user_tiene_relacion_testimonios(): void
    {
        $this->assertTrue(
            method_exists(User::class, 'testimonios'),
            'El modelo User debe tener el método testimonios()'
        );
    }

    #[Puntos(0.25, 'RA5', 'A3')]
    public function test_casa_tiene_relacion_testimonios(): void
    {
        $this->assertTrue(
            method_exists(Casa::class, 'testimonios'),
            'El modelo Casa debe tener el método testimonios()'
        );
    }

    // ── B4/B6: métodos esInquilino y esAdmin ──────────────────────────────────

    #[Puntos(0.5, 'RA6', 'B4')]
    public function test_user_tiene_metodo_esInquilino(): void
    {
        $this->assertTrue(
            method_exists(User::class, 'esInquilino'),
            'El modelo User debe tener el método esInquilino()'
        );
    }

    #[Puntos(0.5, 'RA6', 'B6')]
    public function test_user_tiene_metodo_esAdmin(): void
    {
        $this->assertTrue(
            method_exists(User::class, 'esAdmin'),
            'El modelo User debe tener el método esAdmin()'
        );
    }
}
