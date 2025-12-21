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
            $table->integer('id_competicion')->index('competition_id');
            $table->integer('id_atleta')->index('athlete_id');
            $table->integer('id_club')->index('club_id');
            $table->string('tipo_evento', 50)->nullable();
            $table->integer('dorsal')->nullable();
            $table->date('fecha_inscripcion')->nullable();
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
