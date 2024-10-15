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
        Schema::create('calendario_competiciones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('calendario_id')->constrained('calendario')->onDelete('cascade');
            $table->foreignId('competicion_id')->constrained('competiciones')->onDelete('cascade');
            $table->integer('temporada'); // Temporada para la relación entre día y competición.

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendario_competiciones');
    }
};
