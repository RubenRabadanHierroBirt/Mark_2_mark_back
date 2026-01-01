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
            $table->integer('id_atleta');
            $table->integer('id_club');
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();

            $table->foreign('id_atleta')->references('id')->on('atletas')->onDelete('cascade');
            $table->foreign('id_club')->references('id')->on('clubs')->onDelete('cascade');
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
