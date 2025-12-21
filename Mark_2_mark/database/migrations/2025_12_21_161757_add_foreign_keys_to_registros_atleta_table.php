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
        Schema::table('registros_atleta', function (Blueprint $table) {
            $table->foreign(['id_competicion'], 'registros_atleta_ibfk_1')->references(['id'])->on('competiciones')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['id_atleta'], 'registros_atleta_ibfk_2')->references(['id'])->on('atletas')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['id_club'], 'registros_atleta_ibfk_3')->references(['id'])->on('clubs')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registros_atleta', function (Blueprint $table) {
            $table->dropForeign('registros_atleta_ibfk_1');
            $table->dropForeign('registros_atleta_ibfk_2');
            $table->dropForeign('registros_atleta_ibfk_3');
        });
    }
};
