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
            $table->integer('temporada'); 
            $table->integer('num_carrera'); 
            $table->integer('etapa');

            // Claves foráneas
            $table->foreign(['temporada', 'num_carrera'])
                ->references(['temporada', 'num_carrera'])->on('carreras')->onDelete('cascade');

            $table->foreign(['temporada', 'num_carrera', 'etapa'])
                ->references(['temporada', 'num_carrera', 'num_etapa'])->on('etapas')->onDelete('cascade');

            // Clave foránea para el ciclista
            $table->integer('cod_ciclista')->unsigned();
            $table->foreign(['cod_ciclista', 'temporada'])
                ->references(['cod_ciclista', 'temporada'])->on('ciclistas')->onDelete('cascade');

            // Clave foránea para el equipo (corregida)
            $table->integer('cod_equipo')->unsigned()->nullable();
            $table->foreign(['cod_equipo', 'temporada'])->references(['cod_equipo', 'temporada'])
                ->on('equipos')
                ->onDelete('cascade');

            // Otros campos
            $table->integer('posicion')->nullable(); 
            $table->integer('pos_gral')->nullable();
            $table->integer('gral_reg')->nullable(); 
            $table->integer('gral_mon')->nullable();
            $table->integer('gral_jov')->nullable(); 
            $table->time('tiempo')->nullable(); 
            $table->decimal('pts', 8, 4)->nullable(); 
            $table->timestamps();

            // Índices
            $table->index(['cod_ciclista', 'temporada'], 'idx_res_ciclista_temporada');
            $table->index(['temporada', 'num_carrera', 'etapa'], 'idx_res_carrera_etapa');

            // Clave única compuesta para evitar duplicados
            $table->unique(['temporada', 'num_carrera', 'etapa', 'cod_ciclista'], 'unique_res_resultado');
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
