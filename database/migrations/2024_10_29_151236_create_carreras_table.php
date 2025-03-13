<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('carreras', function (Blueprint $table) {
            $table->id();
            $table->integer('temporada');
            $table->integer('bloque');
            $table->integer('num_carrera');
            $table->string('nombre');
            $table->string('nombre_xml');
            $table->string('slug')->unique()->after('nombre');
            $table->integer('num_etapas');
            $table->enum('categoria', ['WT', 'Conti', 'Pro', 'U24']); // Nueva columna para la categoría
            $table->enum('tipo', ['Vuelta', 'Clásica', 'Monumento', 'Continental', 'GV']); // Valores permitidos para tipo
            $table->integer('dia_inicio');
            $table->timestamps();

            // Índice compuesto para claves foráneas
            $table->unique(['temporada', 'num_carrera']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carreras');
    }
};
