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
            $table->integer('cod_equipo'); // Identificador único del equipo (de la Excel)
            $table->integer('temporada'); // Temporada del equipo
            $table->string('nombre_equipo'); // Nombre del equipo
            $table->string('nombre_en_bd'); // Nombre del equipo
            $table->string('siglas'); // 3 letras que representan el nombre del equipo
            $table->unsignedBigInteger('user_id')->nullable(); // Relación con la tabla `users`
            $table->enum('categoria', ['WT', 'Conti']); //Hay 2 categorias de equipos con sus respectivas obligaciones

            $table->timestamps(); // Campos created_at y updated_at

            // Relación con la tabla `users`
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            // Clave única combinada para evitar duplicados de `cod_equipo` en distintas temporadas
            $table->unique(['cod_equipo', 'temporada'], 'unique_equipo_temporada');            
        });

        // Insertar equipos iniciales con `user_id` correspondiente
        DB::table('equipos')->insert([
            // ['temporada' => 4, 'cod_equipo' =>   1 , 'categoria' => 'WT',    'siglas' => 'XAC', 'nombre_en_bd' => "Xacobeo Galicia"          , 'nombre_equipo' => 'Xacobeo-Galicia', 'user_id' => 15],
            // ['temporada' => 4, 'cod_equipo' =>   2 , 'categoria' => 'WT',    'siglas' => '111', 'nombre_en_bd' => "INEOS Grenadiers"         , 'nombre_equipo' => 'Ineos', 'user_id' => 10],
            // ['temporada' => 4, 'cod_equipo' =>   3 , 'categoria' => 'Conti', 'siglas' => 'KNY', 'nombre_en_bd' => "Kimetsu no Yaiba"         , 'nombre_equipo' => 'Kimetsu No Yaiba', 'user_id' => 17],
            // ['temporada' => 4, 'cod_equipo' =>   5 , 'categoria' => 'Conti', 'siglas' => 'BAN', 'nombre_en_bd' => "Bancolombia"              , 'nombre_equipo' => 'Bancolombia', 'user_id' => 22],
            // ['temporada' => 4, 'cod_equipo' =>   6 , 'categoria' => 'Conti', 'siglas' => '111', 'nombre_en_bd' => "Movistar"                 , 'nombre_equipo' => 'Movistar', 'user_id' => 21],
            // ['temporada' => 4, 'cod_equipo' =>   8 , 'categoria' => 'Conti', 'siglas' => '111', 'nombre_en_bd' => "Mercatone Uno"            , 'nombre_equipo' => 'Mercatone Uno', 'user_id' => 18],
            // ['temporada' => 4, 'cod_equipo' =>   9 , 'categoria' => 'WT',    'siglas' => 'LDL', 'nombre_en_bd' => "Lidl"                     , 'nombre_equipo' => 'Lidl', 'user_id' => 3],
            // ['temporada' => 4, 'cod_equipo' =>  10 , 'categoria' => 'Conti', 'siglas' => '111', 'nombre_en_bd' => "Carambar"                 , 'nombre_equipo' => 'Carambar', 'user_id' => 23],
            // ['temporada' => 4, 'cod_equipo' =>  11 , 'categoria' => 'WT',    'siglas' => '111', 'nombre_en_bd' => "Trek - Segafredo"         , 'nombre_equipo' => 'Trek', 'user_id' => 5],
            // ['temporada' => 4, 'cod_equipo' =>  12 , 'categoria' => 'WT',    'siglas' => 'REP', 'nombre_en_bd' => "Repsol"                   , 'nombre_equipo' => 'Repsol', 'user_id' => 16],
            // ['temporada' => 4, 'cod_equipo' =>  13 , 'categoria' => 'WT',    'siglas' => '111', 'nombre_en_bd' => "Illes Balears"            , 'nombre_equipo' => 'Illes Balears', 'user_id' => 13],
            // ['temporada' => 4, 'cod_equipo' =>  14 , 'categoria' => 'WT',    'siglas' => '111', 'nombre_en_bd' => "Orbea"                    , 'nombre_equipo' => 'Orbea', 'user_id' => 11],
            // ['temporada' => 4, 'cod_equipo' =>  15 , 'categoria' => 'WT',    'siglas' => 'KAI', 'nombre_en_bd' => "Kaiku"                    , 'nombre_equipo' => 'Kaiku', 'user_id' => 14],
            // ['temporada' => 4, 'cod_equipo' =>  16 , 'categoria' => 'WT',    'siglas' => '111', 'nombre_en_bd' => "Uno-X"                    , 'nombre_equipo' => 'Uno-X', 'user_id' => 7],
            // ['temporada' => 4, 'cod_equipo' =>  20 , 'categoria' => 'WT',    'siglas' => 'UAE', 'nombre_en_bd' => "UAE Team Emirates"        , 'nombre_equipo' => 'UAE', 'user_id' => 12],
            // ['temporada' => 4, 'cod_equipo' =>  24 , 'categoria' => 'Conti', 'siglas' => '111', 'nombre_en_bd' => "Roma Cycling Project"     , 'nombre_equipo' => 'Roma Cycling Project', 'user_id' => 24],
            // ['temporada' => 4, 'cod_equipo' =>  33 , 'categoria' => 'WT',    'siglas' => 'FPK', 'nombre_en_bd' => "F1 Paddock"               , 'nombre_equipo' => 'F1 Paddock', 'user_id' => 1], // user_id 1 corresponde a 'Pawa' para pruebas
            // ['temporada' => 4, 'cod_equipo' =>  34 , 'categoria' => 'WT',    'siglas' => '111', 'nombre_en_bd' => "Phonak"                   , 'nombre_equipo' => 'Phonak', 'user_id' => 25], // user_id 2 corresponde a 'Jonathan9'
            // ['temporada' => 4, 'cod_equipo' =>  35 , 'categoria' => 'Conti', 'siglas' => '111', 'nombre_en_bd' => "Caja Rural - Seguros RGA" , 'nombre_equipo' => 'Caja Rural', 'user_id' => 20],
            // ['temporada' => 4, 'cod_equipo' =>  42 , 'categoria' => 'WT',    'siglas' => '111', 'nombre_en_bd' => "Hummel"                   , 'nombre_equipo' => 'Hummel-Carlsberg', 'user_id' => 8],
            // ['temporada' => 4, 'cod_equipo' =>  92 , 'categoria' => 'WT',    'siglas' => '111', 'nombre_en_bd' => "Twitch- BH"               , 'nombre_equipo' => 'Twitch BH', 'user_id' => 9],
            // ['temporada' => 4, 'cod_equipo' => 100 , 'categoria' => 'Conti', 'siglas' => '111', 'nombre_en_bd' => "Nike"                     , 'nombre_equipo' => 'Nike', 'user_id' => 19],
            // ['temporada' => 4, 'cod_equipo' => 207 , 'categoria' => 'WT',    'siglas' => 'DSM', 'nombre_en_bd' => "DSM"                      , 'nombre_equipo' => 'DSM', 'user_id' => 6],
            // ['temporada' => 4, 'cod_equipo' => 229 , 'categoria' => 'WT',    'siglas' => '111', 'nombre_en_bd' => "Sky"                      , 'nombre_equipo' => 'Sky', 'user_id' => 4],
  
            ['temporada' => 5, 'cod_equipo' =>   1 , 'categoria' => 'WT',    'siglas' => 'XAC', 'nombre_en_bd' => "Becedas P.T"              , 'nombre_equipo' => 'Becedas P.T', 'user_id' => 15],//ok
            ['temporada' => 5, 'cod_equipo' =>   2 , 'categoria' => 'WT',    'siglas' => '111', 'nombre_en_bd' => "INEOS Grenadiers"         , 'nombre_equipo' => 'Ineos', 'user_id' => 10],// OK
            ['temporada' => 5, 'cod_equipo' =>   3 , 'categoria' => 'Conti', 'siglas' => 'KNY', 'nombre_en_bd' => "Kimetsu no Yaiba"         , 'nombre_equipo' => 'Kimetsu no Yaiba', 'user_id' => 17],//ok
            ['temporada' => 5, 'cod_equipo' =>   5 , 'categoria' => 'Conti', 'siglas' => 'BAN', 'nombre_en_bd' => "Aurum"                    , 'nombre_equipo' => 'Aurum', 'user_id' => 22],//ok
            ['temporada' => 5, 'cod_equipo' =>   6 , 'categoria' => 'Conti', 'siglas' => '111', 'nombre_en_bd' => "Movistar"                 , 'nombre_equipo' => 'Movistar', 'user_id' => 21],// OK
            ['temporada' => 5, 'cod_equipo' =>   8 , 'categoria' => 'WT',    'siglas' => '111', 'nombre_en_bd' => "Mercatone Uno"            , 'nombre_equipo' => 'Mercatone Uno', 'user_id' => 18],
            ['temporada' => 5, 'cod_equipo' =>   9 , 'categoria' => 'WT',    'siglas' => 'LDL', 'nombre_en_bd' => "RCA"                      , 'nombre_equipo' => 'RCA', 'user_id' => 3],// OK
            ['temporada' => 5, 'cod_equipo' =>  10 , 'categoria' => 'Conti', 'siglas' => '111', 'nombre_en_bd' => "Euskaltel"        , 'nombre_equipo' => 'Euskaltel-Euskadi', 'user_id' => 23],//ok
            ['temporada' => 5, 'cod_equipo' =>  11 , 'categoria' => 'WT',    'siglas' => '111', 'nombre_en_bd' => "Trek - Segafredo"         , 'nombre_equipo' => 'Trek', 'user_id' => 5], // OK
            ['temporada' => 5, 'cod_equipo' =>  12 , 'categoria' => 'WT',    'siglas' => 'REP', 'nombre_en_bd' => "Cebollas"                 , 'nombre_equipo' => 'Cebollas', 'user_id' => 16], // ok
            ['temporada' => 5, 'cod_equipo' =>  13 , 'categoria' => 'WT',    'siglas' => '111', 'nombre_en_bd' => "Illes Balears"            , 'nombre_equipo' => 'Illes Balears', 'user_id' => 13],// OK
            ['temporada' => 5, 'cod_equipo' =>  14 , 'categoria' => 'WT',    'siglas' => '111', 'nombre_en_bd' => "Orbea"                    , 'nombre_equipo' => 'Orbea', 'user_id' => 11], // ok
            ['temporada' => 5, 'cod_equipo' =>  15 , 'categoria' => 'WT',    'siglas' => 'KAI', 'nombre_en_bd' => "Kaiku"                    , 'nombre_equipo' => 'Kaiku', 'user_id' => 14],// OK
            ['temporada' => 5, 'cod_equipo' =>  16 , 'categoria' => 'WT',    'siglas' => '111', 'nombre_en_bd' => "Uno-X"                    , 'nombre_equipo' => 'Uno-X', 'user_id' => 7],// OK
            ['temporada' => 5, 'cod_equipo' =>  20 , 'categoria' => 'WT',    'siglas' => 'UAE', 'nombre_en_bd' => "UAE Team Emirates"        , 'nombre_equipo' => 'UAE', 'user_id' => 12],// OK
            ['temporada' => 5, 'cod_equipo' =>  24 , 'categoria' => 'Conti', 'siglas' => '111', 'nombre_en_bd' => "Roma"                     , 'nombre_equipo' => 'Roma', 'user_id' => 24],//ok
            ['temporada' => 5, 'cod_equipo' =>  33 , 'categoria' => 'Conti', 'siglas' => 'FPK', 'nombre_en_bd' => "F1 Paddock"               , 'nombre_equipo' => 'F1 Paddock', 'user_id' => 1], // OK 
            ['temporada' => 5, 'cod_equipo' =>  34 , 'categoria' => 'WT',    'siglas' => '111', 'nombre_en_bd' => "Phonak"                   , 'nombre_equipo' => 'Phonak', 'user_id' => 25], // OK
            ['temporada' => 5, 'cod_equipo' =>  35 , 'categoria' => 'WT',    'siglas' => '111', 'nombre_en_bd' => "Caja Rural - Seguros RGA" , 'nombre_equipo' => 'Caja Rural', 'user_id' => 20],//ok
            ['temporada' => 5, 'cod_equipo' =>  42 , 'categoria' => 'WT',    'siglas' => '111', 'nombre_en_bd' => "Hummel"                   , 'nombre_equipo' => 'Hummel', 'user_id' => 8],
            ['temporada' => 5, 'cod_equipo' =>  92 , 'categoria' => 'WT',    'siglas' => '111', 'nombre_en_bd' => "Twitch- BH"               , 'nombre_equipo' => 'Twitch BH', 'user_id' => 9], // OK
            ['temporada' => 5, 'cod_equipo' => 100 , 'categoria' => 'WT',    'siglas' => '111', 'nombre_en_bd' => "Nike"                     , 'nombre_equipo' => 'Nike', 'user_id' => 19],// OK
            ['temporada' => 5, 'cod_equipo' => 207 , 'categoria' => 'WT',    'siglas' => 'DSM', 'nombre_en_bd' => "DSM"                      , 'nombre_equipo' => 'DSM', 'user_id' => 6],// OK
            ['temporada' => 5, 'cod_equipo' => 229 , 'categoria' => 'WT',    'siglas' => '111', 'nombre_en_bd' => "Gatorade"                 , 'nombre_equipo' => 'Gatorade', 'user_id' => 4], // OK
 
            ['temporada' => 5, 'cod_equipo' => 2424, 'categoria' => 'WT',    'siglas' => '', 'nombre_en_bd' => "U24"                      , 'nombre_equipo' => 'Draft T5 U24', 'user_id' => null],
            ['temporada' => 5, 'cod_equipo' => 9999, 'categoria' => 'WT',    'siglas' => '', 'nombre_en_bd' => "Libre"                    , 'nombre_equipo' => 'Draft T5 Libre', 'user_id' => null],
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
