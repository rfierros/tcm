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
            // clave foránea
            $table->foreign(['temporada', 'num_carrera'])->references(['temporada', 'num_carrera'])->on('carreras')->onDelete('cascade'); 
            $table->integer('cod_ciclista'); 
            $table->foreign('cod_ciclista')->references('cod_ciclista')->on('ciclistas')->onDelete('cascade');
            $table->integer('cod_equipo'); 
            $table->foreign('cod_equipo')->references('cod_equipo')->on('equipos')->onDelete('cascade');
            $table->enum('sancion', ['d', 's'])->nullable(); // u -> sancion u24, c -> sancion conti, d -> sancion repetir dias
            $table->decimal('forma', 11, 8)->nullable();
            $table->timestamps();

            // Índices
            $table->index(['cod_ciclista', 'temporada'], 'idx_ins_ciclista_temporada');
            // Clave única para soporte de ON CONFLICT
            $table->unique(['temporada', 'num_carrera', 'cod_ciclista'], 'unique_ins_resultado');
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
