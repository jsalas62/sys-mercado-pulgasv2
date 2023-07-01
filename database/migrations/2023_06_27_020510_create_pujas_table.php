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
        Schema::create('pujas', function (Blueprint $table) {
            // $table->id();
            $table->bigIncrements('puja_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
            ->references('user_id')
            ->on('users')
            ->onDelete('RESTRICT');  
            $table->unsignedBigInteger('subasta_id');
            $table->foreign('subasta_id')
            ->references('subasta_id')
            ->on('subastas')
            ->onDelete('RESTRICT');
            $table->decimal('puja',12,2);
            $table->char('estado',1)->default(1);  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pujas');
    }
};
