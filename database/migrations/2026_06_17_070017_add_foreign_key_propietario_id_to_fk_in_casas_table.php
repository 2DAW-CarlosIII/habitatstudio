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
            $table->foreign('propietario_id')->references('id')->on('users')->onDelete('cascade');
            $table->dropColumn('nombre_propietario');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('casas', function (Blueprint $table) {
            $table->dropForeign(['propietario_id']);
            $table->dropColumn('propietario_id');


        });
    }
};
