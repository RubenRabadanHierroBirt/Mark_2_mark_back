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
        Schema::create('novedades', function (Blueprint $table) {
            $table->integer('id', true); // AUTO_INCREMENT y PRIMARY KEY
            $table->dateTime('fecha'); // Columna fecha
            $table->text('contenido'); // Columna contenido para textos largos
            $table->enum('tipo', ['info', 'alerta', 'resultado', 'competicion']); // Tipos definidos en tu SQL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('novedades');
    }
};
