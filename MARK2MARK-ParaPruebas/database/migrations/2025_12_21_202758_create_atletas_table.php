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
        Schema::create('atletas', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_usuario')->nullable();
            $table->integer('club_actual_id')->nullable();
            $table->string('nombre', 100);
            $table->string('email', 100)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->enum('status', ['Activo', 'Pendiente', 'Suspendido'])->default('Pendiente');
            $table->string('sexo', 1)->default('M');
            $table->string('categoria', 50)->nullable();

            $table->foreign('id_usuario')->references('id')->on('usuarios')->onDelete('set null');
            $table->foreign('club_actual_id')->references('id')->on('clubs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atletas');
    }
};
