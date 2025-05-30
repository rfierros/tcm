<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('calendarios', function (Blueprint $table) {
            $table->id();
            $table->integer('bloque'); // Bloque de carreras al que pertenece o 'Semana' de retransmisión en Twitch, que es la que marca el límite para tener lista la convocatoria (Sabado a las 22.30) 
            $table->integer('temporada'); // Temporada a la que pertenece
            $table->foreignId('carrera_id')->constrained()->onDelete('cascade');
            $table->integer('dia'); // Día específico de competición en esa temporada
            $table->integer('etapa')->nullable(); // Número de la etapa
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
