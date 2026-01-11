<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('usuarios')->insert([
            'username' => 'admin_fed',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'rol' => 'FEDERACION',
            'desactivado' => false,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('usuarios')->where('username', 'admin_fed')->delete();
    }
};
