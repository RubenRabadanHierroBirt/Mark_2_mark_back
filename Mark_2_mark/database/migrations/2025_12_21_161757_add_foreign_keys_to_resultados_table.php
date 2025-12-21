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
        Schema::table('resultados', function (Blueprint $table) {
            $table->foreign(['id_competicion'], 'resultados_ibfk_1')->references(['id'])->on('competiciones')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['id_registro_atletico'], 'resultados_ibfk_2')->references(['id'])->on('atletas')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resultados', function (Blueprint $table) {
            $table->dropForeign('resultados_ibfk_1');
            $table->dropForeign('resultados_ibfk_2');
        });
    }
};
