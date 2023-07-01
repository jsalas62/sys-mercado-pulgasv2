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
        Schema::create('subastas', function (Blueprint $table) {
            $table->bigIncrements('subasta_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
            ->references('user_id')
            ->on('users')
            ->onDelete('RESTRICT');  
            $table->unsignedBigInteger('producto_id');
            $table->foreign('producto_id')
            ->references('producto_id')
            ->on('productos')
            ->onDelete('RESTRICT');  
            $table->decimal('precio_min',12,2);
            $table->decimal('precio_max',12,2);
            $table->dateTime('tiempo_inicio',0);
            $table->dateTime('tiempo_fin',0);
            $table->char('estado',1)->default(1);
            $table->char('oculto',1)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subastas');
    }
};
