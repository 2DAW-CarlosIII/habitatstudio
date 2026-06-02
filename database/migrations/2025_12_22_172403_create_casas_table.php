<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ...existing code...
return new class extends Migration
{
    public function up()
    {
        Schema::create('casas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_casa');
            $table->enum('tipo', ['Masculino', 'Femenino', 'Mixto']); // Tipo de alojamiento
            $table->decimal('precio', 15, 2); // Precio
            $table->string('ubicacion');
            $table->text('direccion_completa');
            $table->text('instalaciones');
            $table->text('descripcion');
            $table->string('imagen_url');
            $table->string('nombre_propietario');
            $table->string('telefono_propietario');

            // --- CAMPO IMPORTANTE (para que la función de valoración funcione) ---
            $table->double('valoracion')->default(4.5);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('casas');
    }
};
