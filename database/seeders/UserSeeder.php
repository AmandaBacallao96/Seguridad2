<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'email' => 'seguridadweb@campusviu.es', // Correo electrónico
            'password' => Hash::make('S3gur1d4d?W3b'), // Contraseña (asegurada)
        ]);
        
    }
}
