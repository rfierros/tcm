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

            $table->integer('clave_id')->unique(); // Define `clave_id` como un campo único. Es el id de las excel
            $table->string('nombre');                      // Nombre del ciclista
            $table->string('apellido');                    // Apellido del ciclista
            $table->string('pais');                        // País del ciclista
            $table->integer('pos_ini')->nullable();         // Posición inicial (entero hasta 3 posiciones)
            $table->integer('pos_fin')->nullable();         // Posición final (entero hasta 3 posiciones)
            $table->integer('victorias')->nullable();      // Victorias (entero hasta 3 posiciones)
            $table->decimal('pts', 5, 8)->nullable();      // Puntos (decimal con 8 decimales)
            //$table->string('Especialidad')->nullable();    // Especialidad del ciclista
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

            // Clave foránea a la tabla de equipos, usando la opción 'set null'
            $table->unsignedBigInteger('equipo_id')->nullable(); // ID del equipo al que pertenece
            $table->foreign('equipo_id')->references('id')->on('equipos')->onDelete('set null');


            $table->timestamps();                         // Marcas de tiempo para created_at y updated_at


        });

        DB::table('ciclistas')->insert([
            [
                'clave_id' => 1,
                'nombre' => 'Carlos',
                'apellido' => 'González',
                'pais' => 'España',
                'pos_ini' => 5,
                'pos_fin' => 1,
                'victorias' => 2,
                'pts' => 75.12345678,
                'especialidad' => 'escalador',
                'edad' => 28,
                'lla' => 78.5,
                'mon' => 79.8,
                'col' => 80.2,
                'cri' => 66.1,
                'pro' => 73.9,
                'pav' => 63.3,
                'spr' => 55.2,
                'acc' => 71.1,
                'des' => 79.9,
                'com' => 72.2,
                'ene' => 80.0,
                'res' => 81.3,
                'rec' => 82.4,
                'media' => 75.60,
                'equipo_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'clave_id' => 2,
                'nombre' => 'Marco',
                'apellido' => 'Rossi',
                'pais' => 'Italia',
                'pos_ini' => 10,
                'pos_fin' => 3,
                'victorias' => 1,
                'pts' => 68.23456789,
                'especialidad' => 'croner',
                'edad' => 30,
                'lla' => 72.5,
                'mon' => 65.8,
                'col' => 70.2,
                'cri' => 63.1,
                'pro' => 72.9,
                'pav' => 64.3,
                'spr' => 67.2,
                'acc' => 69.1,
                'des' => 74.9,
                'com' => 78.2,
                'ene' => 76.0,
                'res' => 75.3,
                'rec' => 77.4,
                'media' => 72.60,
                'equipo_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'clave_id' => 4,
                'nombre' => 'Pedro',
                'apellido' => 'Martin',
                'pais' => 'Portugal',
                'pos_ini' => 1,
                'pos_fin' => 3,
                'victorias' => 1,
                'pts' => 68.23456789,
                'especialidad' => 'ardenas',
                'edad' => 40,
                'lla' => 72.5,
                'mon' => 65.8,
                'col' => 70.2,
                'cri' => 63.1,
                'pro' => 72.9,
                'pav' => 64.3,
                'spr' => 67.2,
                'acc' => 69.1,
                'des' => 74.9,
                'com' => 78.2,
                'ene' => 76.0,
                'res' => 75.3,
                'rec' => 77.4,
                'media' => 72.60,
                'equipo_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'clave_id' => 3,
                'nombre' => 'Luca',
                'apellido' => 'Bianchi',
                'pais' => 'Italia',
                'pos_ini' => 7,
                'pos_fin' => 2,
                'victorias' => 4,
                'pts' => 70.12345678,
                'especialidad' => 'flandes',
                'edad' => 26,
                'lla' => 76.4,
                'mon' => 78.3,
                'col' => 82.1,
                'cri' => 68.1,
                'pro' => 69.7,
                'pav' => 60.3,
                'spr' => 62.4,
                'acc' => 77.0,
                'des' => 75.5,
                'com' => 79.6,
                'ene' => 77.9,
                'res' => 80.2,
                'rec' => 81.1,
                'media' => 75.50,
                'equipo_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Registros restantes...
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ciclistas');
    }
};
