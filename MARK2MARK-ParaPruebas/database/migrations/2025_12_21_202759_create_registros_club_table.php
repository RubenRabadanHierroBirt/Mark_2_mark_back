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
        Schema::create('registros_club', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_competicion');
            $table->integer('id_club');
            $table->timestamp('fecha_registro')->useCurrent();

            $table->foreign('id_competicion')->references('id')->on('competiciones')->onDelete('cascade');
            $table->foreign('id_club')->references('id')->on('clubs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros_club');
    }
};
