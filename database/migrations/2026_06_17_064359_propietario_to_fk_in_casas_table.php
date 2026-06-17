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
            $table->unsignedBigInteger('propietario_id');
            $table->foreign('propietario_id')->references('id')->on('casas')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('casas', function (Blueprint $table) {
            $table->dropColumn('nombre_propietario');
        });
    }
};
