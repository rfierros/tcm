<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Asegúrate de importar la clase DB

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->id(); // ID autoincremental para el equipo
            $table->integer('cod_equipo')->unique(); // Identificador único del equipo (de la Excel)
            $table->integer('temporada'); // Temporada del equipo
            $table->string('nombre_equipo'); // Nombre del equipo
            $table->string('nombre_en_bd'); // Nombre del equipo
            $table->unsignedBigInteger('user_id')->nullable(); // Relación con la tabla `users`
            $table->enum('categoria', ['WT', 'Conti']); //Hay 2 categorias de equipos con sus respectivas obligaciones

            $table->timestamps(); // Campos created_at y updated_at

            // Relación con la tabla `users`
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });

        // Insertar equipos iniciales con `user_id` correspondiente
        DB::table('equipos')->insert([
            ['temporada' => 4, 'cod_equipo' =>   1 , 'categoria' => 'WT',    'nombre_en_bd' => "Xacobeo Galicia"          , 'nombre_equipo' => 'Xacobeo-Galicia', 'user_id' => 13],
            ['temporada' => 4, 'cod_equipo' =>   2 , 'categoria' => 'WT',    'nombre_en_bd' => "INEOS Grenadiers"         , 'nombre_equipo' => 'Ineos', 'user_id' => 8],
            ['temporada' => 4, 'cod_equipo' =>   3 , 'categoria' => 'Conti', 'nombre_en_bd' => "Kimetsu no Yaiba"         , 'nombre_equipo' => 'Kimetsu No Yaiba', 'user_id' => 16],
            ['temporada' => 4, 'cod_equipo' =>   5 , 'categoria' => 'Conti', 'nombre_en_bd' => "Bancolombia"              , 'nombre_equipo' => 'Bancolombia', 'user_id' => 21],
            ['temporada' => 4, 'cod_equipo' =>   6 , 'categoria' => 'Conti', 'nombre_en_bd' => "Movistar"                 , 'nombre_equipo' => 'Movistar', 'user_id' => 20],
            ['temporada' => 4, 'cod_equipo' =>   8 , 'categoria' => 'Conti', 'nombre_en_bd' => "Mercatone Uno"            , 'nombre_equipo' => 'Mercatone Uno', 'user_id' => 17],
            ['temporada' => 4, 'cod_equipo' =>   9 , 'categoria' => 'WT',    'nombre_en_bd' => "Lidl"                     , 'nombre_equipo' => 'Lidl', 'user_id' => 3],
            ['temporada' => 4, 'cod_equipo' =>  10 , 'categoria' => 'Conti', 'nombre_en_bd' => "Carambar"                 , 'nombre_equipo' => 'Carambar', 'user_id' => 22],
            ['temporada' => 4, 'cod_equipo' =>  11 , 'categoria' => 'WT',    'nombre_en_bd' => "Trek - Segafredo"         , 'nombre_equipo' => 'Trek', 'user_id' => 15],
            ['temporada' => 4, 'cod_equipo' =>  12 , 'categoria' => 'WT',    'nombre_en_bd' => "Repsol"                   , 'nombre_equipo' => 'Repsol', 'user_id' => 12],
            ['temporada' => 4, 'cod_equipo' =>  13 , 'categoria' => 'WT',    'nombre_en_bd' => "Illes Balears"            , 'nombre_equipo' => 'Illes Balears', 'user_id' => 11],
            ['temporada' => 4, 'cod_equipo' =>  14 , 'categoria' => 'WT',    'nombre_en_bd' => "Orbea"                    , 'nombre_equipo' => 'Orbea', 'user_id' => 9],
            ['temporada' => 4, 'cod_equipo' =>  15 , 'categoria' => 'WT',    'nombre_en_bd' => "Kaiku"                    , 'nombre_equipo' => 'Kaiku', 'user_id' => 14],
            ['temporada' => 4, 'cod_equipo' =>  16 , 'categoria' => 'WT',    'nombre_en_bd' => "Uno-X"                    , 'nombre_equipo' => 'Uno-X', 'user_id' => 4],
            ['temporada' => 4, 'cod_equipo' =>  20 , 'categoria' => 'WT',    'nombre_en_bd' => "UAE Team Emirates"        , 'nombre_equipo' => 'UAE', 'user_id' => 10],
            ['temporada' => 4, 'cod_equipo' =>  24 , 'categoria' => 'Conti', 'nombre_en_bd' => "Roma Cycling Project"     , 'nombre_equipo' => 'Roma Cycling Project', 'user_id' => 23],
            ['temporada' => 4, 'cod_equipo' =>  33 , 'categoria' => 'WT',    'nombre_en_bd' => "F1 Paddock"               , 'nombre_equipo' => 'F1 Paddock', 'user_id' => 1], // user_id 1 corresponde a 'Pawa' para pruebas
            ['temporada' => 4, 'cod_equipo' =>  34 , 'categoria' => 'WT',    'nombre_en_bd' => "Phonak"                   , 'nombre_equipo' => 'Phonak', 'user_id' => 2], // user_id 2 corresponde a 'Jonathan9'
            ['temporada' => 4, 'cod_equipo' =>  35 , 'categoria' => 'Conti', 'nombre_en_bd' => "Caja Rural - Seguros RGA" , 'nombre_equipo' => 'Caja Rural', 'user_id' => 19],
            ['temporada' => 4, 'cod_equipo' =>  42 , 'categoria' => 'WT',    'nombre_en_bd' => "Hummel"                   , 'nombre_equipo' => 'Hummel-Carlsberg', 'user_id' => 5],
            ['temporada' => 4, 'cod_equipo' =>  92 , 'categoria' => 'WT',    'nombre_en_bd' => "Twitch- BH"               , 'nombre_equipo' => 'Twitch BH', 'user_id' => 7],
            ['temporada' => 4, 'cod_equipo' => 100 , 'categoria' => 'Conti', 'nombre_en_bd' => "Nike"                     , 'nombre_equipo' => 'Nike', 'user_id' => 18],
            ['temporada' => 4, 'cod_equipo' => 207 , 'categoria' => 'WT',    'nombre_en_bd' => "DSM"                      , 'nombre_equipo' => 'DSM', 'user_id' => 6],
            ['temporada' => 4, 'cod_equipo' => 229 , 'categoria' => 'WT',    'nombre_en_bd' => "Sky"                      , 'nombre_equipo' => 'Sky', 'user_id' => null],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};
