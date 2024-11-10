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

            $table->integer('temporada'); // Temporada del equipo
            $table->integer('clave_id')->unique(); // Define `clave_id` como un campo único. Es el id de las excel
            $table->string('apellido');                      // Nombre del ciclista
            $table->string('nombre');                    // Apellido del ciclista
            $table->string('nom_ape');                    // combinacion a mostrar
            $table->string('pais');                        // País del ciclista
            $table->integer('pos_ini')->nullable();         // Posición inicial (entero hasta 3 posiciones)
            $table->integer('pos_fin')->nullable();         // Posición final (entero hasta 3 posiciones)
            $table->integer('victorias')->nullable();      // Victorias (entero hasta 3 posiciones)
            $table->decimal('pts', 5, 8)->nullable();      // Puntos (decimal con 8 decimales)
            $table->enum('especialidad', ['escalador', 'combatividad', 'sprinter', 'flandes', 'ardenas', 'croner']); // Enum para limitar valores
            $table->integer('edad')->nullable();           // Edad del ciclista (entero de 2 posiciones)
            $table->decimal('lla', 5, 3)->nullable();      // Valoración LLA (decimal con 3 decimales)
            $table->decimal('mon', 5, 3)->nullable();      // Valoración MON (decimal con 3 decimales)
            $table->decimal('col', 5, 3)->nullable();      // Valoración COL (decimal con 3 decimales)
            $table->decimal('cri', 5, 3)->nullable();      // Valoración CRI (decimal con 3 decimales)
            $table->decimal('pro', 5, 3)->nullable();      // Valoración PRO (decimal con 3 decimales)
            $table->decimal('pav', 5, 3)->nullable();      // Valoración PAV (decimal con 3 decimales)
            $table->decimal('spr', 5, 3)->nullable();      // Valoración SPR (decimal con 3 decimales)
            $table->decimal('acc', 5, 3)->nullable();      // Valoración ACC (decimal con 3 decimales)
            $table->decimal('des', 5, 3)->nullable();      // Valoración DES (decimal con 3 decimales)
            $table->decimal('com', 5, 3)->nullable();      // Valoración COM (decimal con 3 decimales)
            $table->decimal('ene', 5, 3)->nullable();      // Valoración ENE (decimal con 3 decimales)
            $table->decimal('res', 5, 3)->nullable();      // Valoración RES (decimal con 3 decimales)
            $table->decimal('rec', 5, 3)->nullable();      // Valoración REC (decimal con 3 decimales)
            $table->decimal('media', 5, 8)->nullable();    // Media general del ciclista
            // switches para filtrar facilmente los ciclistas
            $table->boolean('conti')->default(false); // Campo conti
            $table->boolean('u24')->default(false);    // Campo u24
            // Clave foránea a la tabla de equipos, usando la opción 'set null'
            $table->unsignedBigInteger('equipo_id')->nullable(); // ID del equipo al que pertenece
            $table->foreign('equipo_id')->references('id')->on('equipos')->onDelete('set null');


            $table->timestamps();                         // Marcas de tiempo para created_at y updated_at


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
