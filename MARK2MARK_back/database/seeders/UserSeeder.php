<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear el administrador por defecto con username 'admin' y password 'admin'
        User::factory()->admin()->create();

        // Crear algunos usuarios adicionales aleatorios
        User::factory(10)->create();
    }
}
