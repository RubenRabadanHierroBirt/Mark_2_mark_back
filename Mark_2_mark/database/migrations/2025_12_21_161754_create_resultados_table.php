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
        Schema::create('resultados', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_competicion')->index('competition_id');
            $table->integer('id_registro_atletico')->index('athlete_id');
            $table->string('tipo_evento', 50);
            $table->string('categoria', 20)->nullable();
            $table->string('marca', 20)->nullable();
            $table->integer('posicion')->nullable();
            $table->decimal('wind_speed', 3, 1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resultados');
    }
};
