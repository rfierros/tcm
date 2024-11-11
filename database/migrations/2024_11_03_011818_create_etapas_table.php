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
            $table->id();
            $table->foreignId('carrera_id')->constrained('carreras')->onDelete('cascade'); // Relación con 'carreras'
            $table->foreignId('slug'); // Relación con 'carreras'
            $table->integer('temporada'); // Año o temporada
            $table->integer('num_etapa'); // etapa
            $table->integer('dia'); // Día específico de la etapa
            $table->enum('perfil', ['llano', 'montaña', 'media-montaña', 'cre', 'cri'])->nullable(); // Perfil de la etapa
            $table->string('imagen')->nullable(); // Ruta o URL de la imagen de la etapa
            $table->timestamps();
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
