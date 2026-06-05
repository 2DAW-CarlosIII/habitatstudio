<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('casa_id')->constrained('casas')->onDelete('cascade');
            $table->string('nombre_inquilino');
            $table->string('num_movil');
            $table->date('fecha_inicio');
            $table->integer('duracion'); // En meses
            $table->decimal('precio_total', 15, 2);
            $table->enum('estado', ['Pendiente', 'Pagado'])->default('Pendiente');
            $table->string('comprobante_pago')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};
