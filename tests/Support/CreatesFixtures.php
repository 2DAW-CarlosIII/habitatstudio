<?php

namespace Tests\Support;

use App\Models\Booking;
use App\Models\Casa;
use App\Models\Testimonio;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Helpers de creación de fixtures reutilizables en todos los Feature tests.
 */
trait CreatesFixtures
{
    protected function crearAdmin(): User
    {
        return User::factory()->create([
            'email'    => config('app.admin_email', 'admin@habitatstudio.test'),
            'password' => Hash::make(config('app.admin_password', 'password')),
        ]);
    }

    protected function crearUsuario(array $attrs = []): User
    {
        return User::factory()->create($attrs);
    }

    protected function crearCasa(array $attrs = []): Casa
    {
        return Casa::create(array_merge([
            'nombre_casa'         => 'Casa de prueba',
            'tipo'                => 'Mixto',
            'precio'              => 200.00,
            'ubicacion'           => 'Cartagena',
            'direccion_completa'  => 'Calle Test, 1',
            'instalaciones'       => 'WiFi',
            'descripcion'         => 'Descripción de prueba',
            'imagen_url'          => 'https://example.com/img.jpg',
            'telefono_propietario' => '600000000',
            'valoracion'          => 4.5,
        ], $attrs));
    }

    protected function crearInquilino(array $attrs = []): User
    {
        $user = $this->crearUsuario($attrs);
        $casa = $this->crearCasa(['propietario_id' => $this->crearUsuario()->id]);

        Booking::create([
            'casa_id'      => $casa->id,
            'inquilino_id' => $user->id,
            'num_movil'    => '600111222',
            'fecha_inicio' => now()->toDateString(),
            'duracion'     => 3,
            'precio_total' => 600.00,
            'estado'       => 'Pagado',
        ]);

        return $user->fresh();
    }

    protected function crearTestimonio(array $attrs = []): Testimonio
    {
        $defaults = [
            'user_id'          => $this->crearInquilino()->id,
            'casa_id'          => null,
            'contenido'        => 'Testimonio de prueba.',
            'valoracion'       => 4.5,
            'fecha_aprobacion' => null,
        ];

        return Testimonio::create(array_merge($defaults, $attrs));
    }
}
