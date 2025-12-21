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
        Schema::create('clubs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_usuario')->nullable()->index('user_id');
            $table->string('code', 20)->unique('code');
            $table->string('name', 100);
            $table->string('direccion', 100)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('responsable', 100)->nullable();
            $table->enum('estado', ['Activo', 'Pendiente', 'Suspendido'])->nullable()->default('Pendiente');
            $table->integer('codigo_postal')->nullable();
            $table->string('localidad')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clubs');
    }
};
