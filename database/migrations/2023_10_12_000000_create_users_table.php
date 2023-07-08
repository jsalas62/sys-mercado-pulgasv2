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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('usuario_id');
            $table->string('nombres',60);
            $table->string('apellidos',60);
            $table->string('usuario',40)->unique();
            $table->string('email',80)->unique();
            $table->string('contrasenia');
            $table->string('telefono',20);
            $table->string('direccion');
            $table->text('foto')->nullable();
            $table->string('estado',1);
            $table->string('oculto',1);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
