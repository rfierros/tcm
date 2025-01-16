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
        Schema::create('resultados', function (Blueprint $table) {
            $table->id(); // ID autoincremental para relaciones internas
            $table->integer('temporada'); // Temporada a la que pertenece este resultado
            $table->integer('num_carrera'); // Relaciona con num_carrera en la tabla carreras
            $table->integer('etapa'); // Número de etapa

            // Claves foráneas compuestas
            $table->foreign(['temporada', 'num_carrera'])->references(['temporada', 'num_carrera'])->on('carreras')->onDelete('cascade');
            $table->foreign(['temporada', 'num_carrera', 'etapa'])->references(['temporada', 'num_carrera', 'num_etapa'])->on('etapas')->onDelete('cascade');

            // Clave foránea para el ciclista
            $table->integer('cod_ciclista')->unsigned(); // Relaciona con `cod_ciclista` en la tabla ciclistas
            $table->foreign('cod_ciclista')->references('cod_ciclista')->on('ciclistas')->onDelete('cascade');

            // Clave foránea para el equipo
            $table->integer('cod_equipo')->unsigned()->nullable(); // Relaciona con `cod_equipo` en la tabla equipos
            $table->foreign('cod_equipo')->references('cod_equipo')->on('equipos')->onDelete('cascade');

            // Otros campos
            $table->integer('posicion')->nullable(); // Posición del ciclista en esta etapa
            $table->integer('pos_gral')->nullable(); // Posición del ciclista en la general
            $table->integer('gral_reg')->nullable(); // Posición en la clasificación por puntos
            $table->integer('gral_mon')->nullable(); // Posición en la clasificación de montaña
            $table->integer('gral_jov')->nullable(); // Posición en la clasificación de jóvenes
            $table->time('tiempo')->nullable(); // Tiempo en formato HH:MM:SS
            $table->decimal('pts', 8, 4)->nullable(); // Puntos
            $table->timestamps();

            // Índices
            $table->index(['cod_ciclista', 'temporada'], 'idx_ciclista_temporada');
            $table->index(['temporada', 'num_carrera', 'etapa'], 'idx_carrera_etapa');
            // Clave única para soporte de ON CONFLICT
            $table->unique(['temporada', 'num_carrera', 'etapa', 'cod_ciclista'], 'unique_resultado');

        });

    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resultados');
    }
};
