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
        Schema::create('productos', function (Blueprint $table) {
            // $table->id();
            $table->bigIncrements('producto_id');
            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id')
            ->references('categoria_id')
            ->on('categorias')
            ->onDelete('RESTRICT');  
            $table->string('producto',60);
            $table->text('descripcion_producto')->nullable();
            $table->text('imagen'); 
            $table->text('url');
            $table->char('estado',1)->default(1);
            $table->char('oculto',1)->default(0);
            $table->string('usuario_registra',50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
