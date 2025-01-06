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
        Schema::create('inscripciones', function (Blueprint $table) {
            $table->id();
            $table->integer('temporada');
            $table->integer('num_carrera');
            $table->foreign(['temporada', 'num_carrera'])->references(['temporada', 'num_carrera'])->on('carreras')->onDelete('cascade');
            $table->integer('cod_ciclista'); 
            $table->foreign('cod_ciclista')->references('cod_ciclista')->on('ciclistas')->onDelete('cascade');
            $table->integer('cod_equipo'); 
            $table->foreign('cod_equipo')->references('cod_equipo')->on('equipos')->onDelete('cascade');
            $table->enum('sancion', ['d', 's'])->nullable(); // 'null' no es necesario explícitamente en enum
            $table->integer('pts')->default(0);
            $table->timestamps();
            $table->unique(['temporada', 'num_carrera', 'cod_ciclista']); // Normalizado a cod_ciclista
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscripcions');
    }
};
