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
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // Insertar usuarios iniciales basados en los Owners de los equipos
        DB::table('users')->insert([
            ['name' => 'Pawa', 'email' => 'pawa@user.com', 'password' => bcrypt('pawa')],
            ['name' => 'Admin', 'email' => 'admin@user.com', 'password' => bcrypt('admin')],
            ['name' => 'BarbaRoja', 'email' => 'lidl@user.com', 'password' => bcrypt('lidl')],
            ['name' => 'Jonathan9', 'email' => 'user2@user.com', 'password' => bcrypt('password')],
            ['name' => 'Washington', 'email' => 'user3@user.com', 'password' => bcrypt('password')],
            ['name' => 'Weitrom', 'email' => 'dsm@user.com', 'password' => bcrypt('dsm')],
            ['name' => 'SergiOsilla', 'email' => 'user4@user.com', 'password' => bcrypt('password')],
            ['name' => 'Javimongas', 'email' => 'user5@user.com', 'password' => bcrypt('password')],
            ['name' => 'Marc Avtoni', 'email' => 'user7@user.com', 'password' => bcrypt('password')],
            ['name' => 'Hydaspes', 'email' => 'user8@user.com', 'password' => bcrypt('password')],
            ['name' => 'Danel', 'email' => 'user9@user.com', 'password' => bcrypt('password')],
            ['name' => 'JamesFP', 'email' => 'user10@user.com', 'password' => bcrypt('password')],
            ['name' => 'Manolopro', 'email' => 'user11@user.com', 'password' => bcrypt('password')],
            ['name' => 'Junkillo', 'email' => 'kaiku@user.com', 'password' => bcrypt('kaiku')],
            ['name' => 'SrBecedas', 'email' => 'user13@user.com', 'password' => bcrypt('password')],
            ['name' => 'Modialba', 'email' => 'user14@user.com', 'password' => bcrypt('password')],
            ['name' => 'Dangar Ewoks', 'email' => 'user16@user.com', 'password' => bcrypt('password')],
            ['name' => 'Zarcisha', 'email' => 'user17@user.com', 'password' => bcrypt('password')],
            ['name' => 'DANIRIVSD', 'email' => 'user18@user.com', 'password' => bcrypt('password')],
            ['name' => 'MrBlack', 'email' => 'user19@user.com', 'password' => bcrypt('password')],
            ['name' => 'MrPabloIglesias', 'email' => 'user20@user.com', 'password' => bcrypt('password')],
            ['name' => 'Salgado90', 'email' => 'user21@user.com', 'password' => bcrypt('password')],
            ['name' => 'lordgorak', 'email' => 'user22@user.com', 'password' => bcrypt('password')],
            ['name' => 'Chus', 'email' => 'user23@user.com', 'password' => bcrypt('password')],
            ['name' => 'Makey', 'email' => 'user24@user.com', 'password' => bcrypt('password')],
            ['name' => 'Salinos', 'email' => 'salinos72@user.com', 'password' => bcrypt('password')],
            // Usuarios adicionales si se requiere
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
