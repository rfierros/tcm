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
            $table->integer('clave_id')->unique(); // Define `clave_id` como un campo único. Es el id de las excel
            $table->integer('temporada'); // Temporada del equipo
            $table->string('nombre_equipo'); // Nombre del equipo
            $table->unsignedBigInteger('user_id')->nullable(); // Relación con la tabla `users`

            $table->timestamps(); // created_at y updated_at

            // Definir la relación con la tabla `users`
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });

        // Insertar equipos iniciales con `user_id` correspondiente
        DB::table('equipos')->insert([
            ['temporada' => 4, 'clave_id' => 1 , 'nombre_equipo' => 'Xacobeo-Galicia', 'user_id' => 13],
            ['temporada' => 4, 'clave_id' => 2 , 'nombre_equipo' => 'Ineos', 'user_id' => 8],
            ['temporada' => 4, 'clave_id' => 3 , 'nombre_equipo' => 'Kimetsu No Yaiba', 'user_id' => 16],
            ['temporada' => 4, 'clave_id' => 5 , 'nombre_equipo' => 'Bancolombia', 'user_id' => 21],
            ['temporada' => 4, 'clave_id' => 6 , 'nombre_equipo' => 'Movistar', 'user_id' => 20],
            ['temporada' => 4, 'clave_id' => 8 , 'nombre_equipo' => 'Mercatone Uno', 'user_id' => 17],
            ['temporada' => 4, 'clave_id' => 9 , 'nombre_equipo' => 'Lidl', 'user_id' => 3],
            ['temporada' => 4, 'clave_id' => 10 , 'nombre_equipo' => 'Carambar', 'user_id' => 22],
            ['temporada' => 4, 'clave_id' => 11 , 'nombre_equipo' => 'Trek', 'user_id' => 15],
            ['temporada' => 4, 'clave_id' => 12 , 'nombre_equipo' => 'Repsol', 'user_id' => 12],
            ['temporada' => 4, 'clave_id' => 13 , 'nombre_equipo' => 'Illes Balears', 'user_id' => 11],
            ['temporada' => 4, 'clave_id' => 14 , 'nombre_equipo' => 'Orbea', 'user_id' => 9],
            ['temporada' => 4, 'clave_id' => 15 , 'nombre_equipo' => 'Kaiku', 'user_id' => 14],
            ['temporada' => 4, 'clave_id' => 16 , 'nombre_equipo' => 'Uno-X', 'user_id' => 4],
            ['temporada' => 4, 'clave_id' => 20 , 'nombre_equipo' => 'UAE', 'user_id' => 10],
            ['temporada' => 4, 'clave_id' => 24 , 'nombre_equipo' => 'Roma Cycling Project', 'user_id' => 23],
            ['temporada' => 4, 'clave_id' => 33 , 'nombre_equipo' => 'F1 Paddock', 'user_id' => 1], // user_id 1 corresponde a 'Pawa' para pruebas
            ['temporada' => 4, 'clave_id' => 34 , 'nombre_equipo' => 'Phonak', 'user_id' => 2], // user_id 2 corresponde a 'Jonathan9'
            ['temporada' => 4, 'clave_id' => 35 , 'nombre_equipo' => 'Caja Rural', 'user_id' => 19],
            ['temporada' => 4, 'clave_id' => 42 , 'nombre_equipo' => 'Hummel-Carlsberg', 'user_id' => 5],
            ['temporada' => 4, 'clave_id' => 92 , 'nombre_equipo' => 'Twitch BH', 'user_id' => 7],
            ['temporada' => 4, 'clave_id' => 100 , 'nombre_equipo' => 'Nike', 'user_id' => 18],
            ['temporada' => 4, 'clave_id' => 207 , 'nombre_equipo' => 'DSM', 'user_id' => 6],
            ['temporada' => 4, 'clave_id' => 229 , 'nombre_equipo' => 'Sky', 'user_id' => null],
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
