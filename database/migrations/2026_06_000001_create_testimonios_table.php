<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('testimonios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('casa_id')->nullable()->constrained('casas')->cascadeOnDelete();
            $table->text('contenido');
            $table->decimal('valoracion',3,1);
            $table->date('fecha_aprobacion')->nullable()->default(null);
            $table->timestamps();
        });
    }
/* user_id FK →  users Obligatorio
casa_id FK →  casas Nullable (null = testimonio sobre
la plataforma)
contenido text Obligatorio
valoracion decimal(3,1) Entre 0.0 y 5.0
fecha_aprobacion timestamp Nullable (null = pendiente de
aprobación */
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonios');
    }
};
