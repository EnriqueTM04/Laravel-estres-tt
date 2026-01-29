<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin General',
            'email' => 'admin@correo.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Dr. Ana López',
            'email' => 'psicologa@correo.com',
            'password' => Hash::make('12345678'),
            'role' => 'psicologo',
        ]);

        // Pacientes
        User::insert([
            [
                'name' => 'Juan Pérez',
                'email' => 'juan@correo.com',
                'password' => Hash::make('12345678'),
                'role' => 'paciente',
            ],
            [
                'name' => 'María González',
                'email' => 'maria@correo.com',
                'password' => Hash::make('12345678'),
                'role' => 'paciente',
            ],
            [
                'name' => 'Carlos Ramírez',
                'email' => 'carlos@correo.com',
                'password' => Hash::make('12345678'),
                'role' => 'paciente',
            ],
        ]);
    }
}
