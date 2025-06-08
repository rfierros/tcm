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
        Schema::create('favoritos_etapa', function (Blueprint $table) {
            // Claves compuestas que identifican la etapa
            $table->integer('temporada');
            $table->integer('num_carrera');
            $table->integer('num_etapa');

            // Columnas para los 11 favoritos (almacenan cod_ciclista)
            $table->unsignedBigInteger('fav1')->nullable();
            $table->unsignedBigInteger('fav2')->nullable();
            $table->unsignedBigInteger('fav3')->nullable();
            $table->unsignedBigInteger('fav4')->nullable();
            $table->unsignedBigInteger('fav5')->nullable();
            $table->unsignedBigInteger('fav6')->nullable();
            $table->unsignedBigInteger('fav7')->nullable();
            $table->unsignedBigInteger('fav8')->nullable();
            $table->unsignedBigInteger('fav9')->nullable();
            $table->unsignedBigInteger('fav10')->nullable();
            $table->unsignedBigInteger('fav11')->nullable();

            // Timestamps si se desean
            $table->timestamps();

            // Definir key primaria compuesta para identificar única la etapa
            $table->primary(['temporada', 'num_carrera', 'num_etapa'], 'pk_favoritos_etapa');

            // (Opcional) Si quieres forzar integridad referencial de cada favorito
            // hacia la tabla `ciclistas` que tiene unique(cod_ciclista, temporada).
            // Aquí asumimos que `ciclistas.cod_ciclista` es la PK de ciclistas.
            $table->foreign(['fav1','temporada'])
                ->references(['cod_ciclista','temporada'])
                ->on('ciclistas')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign(['fav2','temporada'])
                ->references(['cod_ciclista','temporada'])
                ->on('ciclistas')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign(['fav3','temporada'])
                ->references(['cod_ciclista','temporada'])
                ->on('ciclistas')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign(['fav4','temporada'])
                ->references(['cod_ciclista','temporada'])
                ->on('ciclistas')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign(['fav5','temporada'])
                ->references(['cod_ciclista','temporada'])
                ->on('ciclistas')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign(['fav6','temporada'])
                ->references(['cod_ciclista','temporada'])
                ->on('ciclistas')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign(['fav7','temporada'])
                ->references(['cod_ciclista','temporada'])
                ->on('ciclistas')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign(['fav8','temporada'])
                ->references(['cod_ciclista','temporada'])
                ->on('ciclistas')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign(['fav9','temporada'])
                ->references(['cod_ciclista','temporada'])
                ->on('ciclistas')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign(['fav10','temporada'])
                ->references(['cod_ciclista','temporada'])
                ->on('ciclistas')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign(['fav11','temporada'])
                ->references(['cod_ciclista','temporada'])
                ->on('ciclistas')
                ->onUpdate('cascade')
                ->onDelete('restrict');

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('favoritos_etapa', function (Blueprint $table) {
            // Primero eliminamos las claves foráneas
            $table->dropForeign(['fav1']);
            $table->dropForeign(['fav2']);
            $table->dropForeign(['fav3']);
            $table->dropForeign(['fav4']);
            $table->dropForeign(['fav5']);
            $table->dropForeign(['fav6']);
            $table->dropForeign(['fav7']);
            $table->dropForeign(['fav8']);
            $table->dropForeign(['fav9']);
            $table->dropForeign(['fav10']);
            $table->dropForeign(['fav11']);
        });

        Schema::dropIfExists('favoritos_etapa');
    }
};