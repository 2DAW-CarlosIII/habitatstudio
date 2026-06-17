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
            $table->unsignedBigInteger('casa_id')->nullable();
            $table->foreign('casa_id')->references('id')->on('users');
            //$table->foreignId('casa_id')->constrained('casas')->onDelete('cascade')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->nullable()->default(null);
            $table->text('contenido');
            $table->decimal('valoracion', 5, 0);
            $table->timestamp('fecha_aprobacion')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonios');
    }
};
