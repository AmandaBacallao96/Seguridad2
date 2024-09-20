<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'email' => 'seguridadweb@campusviu.es', // Correo electrónico
            'password' => Hash::make('S3gur1d4d?W3b'), // Contraseña (asegurada)
        ]);
        $this->call(UserSeeder::class); 
    }
}
