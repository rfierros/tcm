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
        Schema::create('etapas', function (Blueprint $table) {
            $table->id(); // Identificador único de la etapa
            $table->integer('temporada'); // Año o temporada
            $table->integer('num_carrera'); // Número de carrera
            $table->foreign(['temporada', 'num_carrera'])->references(['temporada', 'num_carrera'])->on('carreras')->onDelete('cascade');
            $table->integer('num_etapa'); // Número de la etapa dentro de la carrera
            $table->string('slug')->nullable(); // Slug opcional
            $table->string('nombre')->nullable(); // Nombre de la etapa
            $table->integer('km')->nullable(); // Kilometraje de la etapa
            $table->integer('dia'); // Día específico de la etapa dentro de la temporada
            $table->enum('perfil', ['llano', 'montaña', 'media-montaña'])->nullable(); // Perfil de la etapa
            $table->enum('tipo', ['normal', 'cre', 'cri'])->nullable(); // Tipo de etapa
            $table->enum('paves', [0, 1, 2, 3, 4])->nullable(); // Tipo de paves. 0-Nada 1-verde 2-amarilloclaro 3-amarillofuerte 4-rojo
            $table->string('imagen')->nullable(); // Ruta o URL de la imagen
            $table->timestamps();

            // Índices
            $table->unique(['temporada', 'num_carrera', 'num_etapa']); // Cada etapa es única dentro de su carrera y temporada
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etapas');
    }
};
