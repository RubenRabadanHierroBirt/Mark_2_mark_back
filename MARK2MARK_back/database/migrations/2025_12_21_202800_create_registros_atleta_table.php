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
        Schema::create('registros_atleta', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_competicion');
            $table->integer('id_atleta');
            $table->integer('id_club');
            $table->string('tipo_evento', 50)->nullable();
            $table->integer('dorsal')->nullable();
            $table->date('fecha_inscripcion')->nullable();

            $table->foreign('id_competicion')->references('id')->on('competiciones')->onDelete('cascade');
            $table->foreign('id_atleta')->references('id')->on('atletas')->onDelete('cascade');
            $table->foreign('id_club')->references('id')->on('clubs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros_atleta');
    }
};
