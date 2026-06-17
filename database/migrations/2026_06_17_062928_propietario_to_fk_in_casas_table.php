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
        Schema::table('casas', function (Blueprint $table) {
            $table->unsignedBigInteger('propietario_id')->nullable();
            $table->foreign('propietario_id')->references('id')->on('users');
            //$table->foreignId('propietario_id')->constrained('users')->onDelete('cascade')->nullable();
            $table->dropColumn('nombre_casa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('casas', function (Blueprint $table) {
            //
        });
    }
};
