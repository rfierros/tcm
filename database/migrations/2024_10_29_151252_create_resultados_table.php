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
            $table->id();
            $table->integer('temporada'); // Temporada a la que pertenece este resultado
            $table->foreignId('carrera_id')->constrained()->onDelete('cascade');
            $table->integer('etapa'); // Etapa específica
            $table->foreignId('ciclista_id')->constrained()->onDelete('cascade');
            $table->foreignId('equipo_id')->constrained()->onDelete('cascade');
            $table->integer('posicion')->nullable(); // Posición del ciclista en esta etapa
            $table->integer('pos_gral')->nullable(); // Posición del ciclista en la general
            $table->integer('gral_reg')->nullable(); // Posición del ciclista en la general de la regularidad
            $table->integer('gral_mon')->nullable(); // Posición del ciclista en la general de la montaña
            $table->integer('gral_jov')->nullable(); // Posición del ciclista en la general de los jovenes
            $table->time('tiempo')->nullable(); // Tiempo en formato HH:MM:SS
            $table->timestamps();

        // Índices para optimizar laa consultaa
        $table->index(['ciclista_id', 'temporada']);
        $table->index(['temporada', 'carrera_id', 'etapa']);            
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
