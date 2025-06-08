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

            // Clave foránea con `carreras`
            $table->foreign(['temporada', 'num_carrera'])
                ->references(['temporada', 'num_carrera'])->on('carreras')
                ->onDelete('cascade');

            // Clave foránea con `ciclistas` (corregida)
            $table->integer('cod_ciclista');
            $table->foreign(['cod_ciclista', 'temporada'])  // 🔹 Se referencia con temporada
                ->references(['cod_ciclista', 'temporada'])->on('ciclistas')
                ->onDelete('cascade');

            // Clave foránea con `equipos` (corregida)
            $table->integer('cod_equipo');
            $table->foreign(['cod_equipo', 'temporada'])  // 🔹 Se referencia con temporada
                ->references(['cod_equipo', 'temporada'])->on('equipos')
                ->onDelete('cascade');

            // Campos adicionales
            $table->enum('sancion', ['u', 'c', 'p', 'd'])->nullable(); 
            $table->enum('rol', ['3', '2', '1', '4'])->nullable(); 
            $table->decimal('forma', 11, 8)->nullable();
            $table->timestamps();

            // Índices
            $table->index(['cod_ciclista', 'temporada'], 'idx_ins_ciclista_temporada');

            // Clave única para evitar duplicados
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
