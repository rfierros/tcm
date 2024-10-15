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
        Schema::create('competicions', function (Blueprint $table) {
            $table->id();

            $table->string('nombre'); // Nombre de la competición.
            $table->string('tipo'); // Tipo de la competición (vuelta, clásica, mundial, etc.).
            $table->integer('duracion'); // Duración de la competición en días.
            $table->integer('temporada'); // Temporada de la competición.

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competicions');
    }
};
