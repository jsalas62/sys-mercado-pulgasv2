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
        Schema::create('cierre__subastas', function (Blueprint $table) {
            $table->bigIncrements('cierre_subasta_id');
            $table->unsignedBigInteger('puja_id');
            $table->foreign('puja_id')
            ->references('puja_id')
            ->on('pujas')
            ->onDelete('RESTRICT');
            $table->unsignedBigInteger('modo_id');
            $table->foreign('modo_id')
            ->references('modo_id')
            ->on('modos')
            ->onDelete('RESTRICT');
            $table->string('modalidad_pago',60);
            $table->text('imagen_comprobante');
            $table->integer('comision');
            $table->char('estado_pago',1);
            $table->char('estado_entrega',1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cierre__subastas');
    }
};
