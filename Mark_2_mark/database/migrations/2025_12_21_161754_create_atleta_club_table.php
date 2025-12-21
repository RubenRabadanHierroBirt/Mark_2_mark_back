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
        Schema::create('atleta_club', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_atleta')->index('athlete_id');
            $table->integer('id_club')->index('club_id');
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atleta_club');
    }
};
