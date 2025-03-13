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
            $table->id();
            $table->integer('cod_ciclista'); // Eliminamos `unique()` para incluir la temporada en la clave
            $table->integer('temporada'); // Mantener temporada

            $table->integer('cod_equipo')->nullable();
            // $table->foreign('cod_equipo')->references('cod_equipo')->on('equipos')->onDelete('set null');
            $table->foreign(['cod_equipo', 'temporada'])
                    ->references(['cod_equipo', 'temporada'])
                    ->on('equipos')
                    ->onDelete('set null');

            $table->string('apellido');
            $table->string('nombre');
            $table->string('nom_ape');
            $table->string('nom_abrev');
            $table->string('pais');

            $table->integer('pos_ini')->nullable();
            $table->integer('pos_fin')->nullable();
            $table->integer('victorias')->nullable();
            $table->decimal('pts', 14, 8)->nullable();

            $table->enum('especialidad', ['escalador', 'combatividad', 'sprinter', 'flandes', 'ardenas', 'croner']);
            $table->integer('edad')->nullable();

            $table->decimal('lla', 5, 3)->nullable();
            $table->decimal('mon', 5, 3)->nullable();
            $table->decimal('col', 5, 3)->nullable();
            $table->decimal('cri', 5, 3)->nullable();
            $table->decimal('pro', 5, 3)->nullable();
            $table->decimal('pav', 5, 3)->nullable();
            $table->decimal('spr', 5, 3)->nullable();
            $table->decimal('acc', 5, 3)->nullable();
            $table->decimal('des', 5, 3)->nullable();
            $table->decimal('com', 5, 3)->nullable();
            $table->decimal('ene', 5, 3)->nullable();
            $table->decimal('res', 5, 3)->nullable();
            $table->decimal('rec', 5, 3)->nullable();
            $table->decimal('media', 10, 8)->nullable();

            $table->enum('draft', ['libre', 'u24'])->nullable();
            $table->integer('pos_draft')->nullable();
            $table->boolean('es_u24')->default(false);
            $table->boolean('es_conti')->default(false);
            $table->boolean('es_pro')->default(false);

            $table->timestamps();

            // Nueva clave única compuesta
            $table->unique(['cod_ciclista', 'temporada'], 'unique_ciclista_temporada');
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
