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
        Schema::table('atleta_club', function (Blueprint $table) {
            $table->foreign(['id_atleta'], 'atleta_club_ibfk_1')->references(['id'])->on('atletas')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['id_club'], 'atleta_club_ibfk_2')->references(['id'])->on('clubs')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('atleta_club', function (Blueprint $table) {
            $table->dropForeign('atleta_club_ibfk_1');
            $table->dropForeign('atleta_club_ibfk_2');
        });
    }
};
