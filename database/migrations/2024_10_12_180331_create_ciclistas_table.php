<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ciclistas', function (Blueprint $table) {
            $table->id(); // ID autoincremental para el ciclista
            $table->integer('cod_ciclista')->unique(); // Identificador único del ciclista (de la Excel)
            $table->integer('temporada'); // Temporada del ciclista

            // Clave foránea hacia equipos, usando el campo `cod_equipo`
            $table->integer('cod_equipo')->nullable(); // Relaciona con `cod_equipo` en la tabla `equipos`
            $table->foreign('cod_equipo')->references('cod_equipo')->on('equipos')->onDelete('set null');

            $table->string('apellido'); // Apellido del ciclista
            $table->string('nombre'); // Nombre del ciclista
            $table->string('nom_ape'); // Nombre completo que aparece en los resultados
            $table->string('nom_abrev'); // Nombre abreviado

            $table->string('pais'); // País del ciclista
            $table->integer('pos_ini')->nullable(); // Posición inicial
            $table->integer('pos_fin')->nullable(); // Posición final
            $table->integer('victorias')->nullable(); // Victorias
            $table->decimal('pts', 14, 8)->nullable(); // Puntos

            $table->enum('especialidad', ['escalador', 'combatividad', 'sprinter', 'flandes', 'ardenas', 'croner']); // Especialidad
            $table->integer('edad')->nullable(); // Edad
            $table->decimal('lla', 5, 3)->nullable(); // Valoración LLA
            $table->decimal('mon', 5, 3)->nullable(); // Valoración MON
            $table->decimal('col', 5, 3)->nullable(); // Valoración COL
            $table->decimal('cri', 5, 3)->nullable(); // Valoración CRI
            $table->decimal('pro', 5, 3)->nullable(); // Valoración PRO
            $table->decimal('pav', 5, 3)->nullable(); // Valoración PAV
            $table->decimal('spr', 5, 3)->nullable(); // Valoración SPR
            $table->decimal('acc', 5, 3)->nullable(); // Valoración ACC
            $table->decimal('des', 5, 3)->nullable(); // Valoración DES
            $table->decimal('com', 5, 3)->nullable(); // Valoración COM
            $table->decimal('ene', 5, 3)->nullable(); // Valoración ENE
            $table->decimal('res', 5, 3)->nullable(); // Valoración RES
            $table->decimal('rec', 5, 3)->nullable(); // Valoración REC
            $table->decimal('media', 10, 8)->nullable(); // Media general del ciclista

            // Filtros
            $table->boolean('conti')->default(false); // Campo conti
            $table->boolean('u24')->default(false); // Campo u24

            $table->timestamps(); // Campos created_at y updated_at
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ciclistas');
    }
};
