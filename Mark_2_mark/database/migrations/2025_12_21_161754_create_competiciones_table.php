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
        Schema::create('competiciones', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 150);
            $table->string('sede', 100)->nullable();
            $table->date('fecha');
            $table->string('organizador', 100)->nullable();
            $table->enum('status', ['Borrador', 'Inscripcion', 'Cerrada', 'Finalizada'])->nullable()->default('Borrador');
            $table->boolean('revisado_federacion')->nullable()->default(false);
            $table->timestamp('creado_el')->nullable()->useCurrent();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->date('fecha_limite')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competiciones');
    }
};
