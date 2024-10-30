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
            $table->string('nombre');
            $table->integer('num_etapas');
            $table->enum('categoria', ['U24', 'WT', 'Conti']); // Nueva columna para la categoría
            $table->enum('tipo', ['Vuelta', 'Clasica', 'Monumento', 'Continental', 'GV']); // Valores permitidos para tipo
            $table->integer('dia_inicio');
            $table->timestamps();
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
