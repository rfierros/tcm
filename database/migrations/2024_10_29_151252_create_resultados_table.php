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
            $table->foreign(['temporada', 'num_carrera'])->references(['temporada', 'num_carrera'])->on('carreras')->onDelete('cascade');
            $table->integer('etapa'); // Número de etapa
            $table->foreign(['temporada', 'num_carrera', 'etapa'])->references(['temporada', 'num_carrera', 'num_etapa'])->on('etapas')->onDelete('cascade');
            $table->foreignId('ciclista_id')->constrained()->onDelete('cascade');
            $table->foreignId('equipo_id')->constrained()->onDelete('cascade');
            $table->integer('posicion')->nullable(); // Posición del ciclista en esta etapa
            $table->integer('pos_gral')->nullable(); // Posición del ciclista en la general
            $table->integer('gral_reg')->nullable(); // Posición en la clasificación por puntos
            $table->integer('gral_mon')->nullable(); // Posición en la clasificación de montaña
            $table->integer('gral_jov')->nullable(); // Posición en la clasificación de jóvenes
            $table->time('tiempo')->nullable(); // Tiempo en formato HH:MM:SS
            $table->decimal('pts', 8, 4)->nullable(); 
            $table->timestamps();

            // Índices
            $table->index(['ciclista_id', 'temporada']);
            $table->index(['temporada', 'num_carrera', 'etapa']);
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
