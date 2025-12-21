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
            $table->integer('id_competicion')->index('competition_id');
            $table->integer('id_club')->index('club_id');
            $table->timestamp('fecha_registro')->nullable()->useCurrent();
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
