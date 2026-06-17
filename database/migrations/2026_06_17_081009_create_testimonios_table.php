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
        Schema::create('Testimonio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('casa_id')->nullable();
            $table->text('contenido');
            $table->decimal('valoracion', 3, 1);
            $table->timestamp('fecha_aprobacion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Testimonio');
    }
};
