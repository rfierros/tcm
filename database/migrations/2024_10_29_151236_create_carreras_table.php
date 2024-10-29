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


        // Inserción de los registros iniciales para pruebas
        DB::table('carreras')->insert([
            [
                'nombre' => 'New Zealand Cycle Classic',
                'num_etapas' => 5,
                'dia_inicio' => 8,
                'tipo' => 'Vuelta',
                'categoria' => 'U24',
                'temporada' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Down Under',
                'num_etapas' => 6,
                'dia_inicio' => 9,
                'tipo' => 'Vuelta',
                'categoria' => 'WT',
                'temporada' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Clàssica C. Valenciana',
                'num_etapas' => 1,
                'dia_inicio' => 14,
                'tipo' => 'Clasica',
                'categoria' => 'Conti',
                'temporada' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carreras');
    }
};
