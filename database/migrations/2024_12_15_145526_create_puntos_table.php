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
        Schema::create('puntos', function (Blueprint $table) {
            $table->id();

            $table->integer('temporada');
            $table->integer('posicion');
            $table->enum('categoria', ['U24', 'WT', 'Conti', 'Pro']); // Nueva columna para la categoría
            $table->enum('tipo', ['Vuelta', 'Clásica', 'Monumento', 'Continental', 'GV']); // Valores permitidos para tipo
            $table->enum('clasificacion', ['general', 'etapa', 'gene-reg', 'gene-mon', 'gene-jov' , 'gene-equi', 'provi-gene', 'provi-reg', 'provi-mon', 'provi-jov']); // Nueva columna para la categoría
            $table->decimal('pts', 7, 4)->nullable(); 
            
            $table->timestamps();

            $table->unique(['temporada', 'posicion', 'categoria', 'tipo', 'clasificacion'], 'unique_puntos');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('puntos');
    }
};
