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
        Schema::create('categorias', function (Blueprint $table) {
            // $table->id();
            // $table->timestamps();
            $table->bigIncrements('categoria_id');
            $table->string('categoria',60);
            $table->text('descripcion')->nullable();
            $table->text('url');
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
        Schema::dropIfExists('categorias');
    }
};
