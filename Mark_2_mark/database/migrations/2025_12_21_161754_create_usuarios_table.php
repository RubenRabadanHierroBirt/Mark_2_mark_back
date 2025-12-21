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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('username', 50)->unique('username');
            $table->string('password');
            $table->string('email', 100)->nullable();
            $table->enum('rol', ['FEDERACION', 'CLUB', 'ATLETA']);
            $table->timestamp('creado_el')->nullable()->useCurrent();
            $table->boolean('desactivado')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
