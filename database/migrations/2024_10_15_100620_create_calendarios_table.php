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
        Schema::create('calendarios', function (Blueprint $table) {
            $table->id();

            $table->integer('dia'); // Día de la competición (1 a 147).
            $table->integer('temporada'); // Temporada de la competición.
            $table->unique(['dia', 'temporada']); // Llave única para evitar duplicados del mismo día en la misma temporada.

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendarios');
    }
};
