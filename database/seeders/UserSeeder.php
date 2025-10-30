<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
     public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin General',
            'email' => 'admin@correo.com',
            'password' => bcrypt('12345678'),
            'role' => 'admin',
        ]);

        $psicoUser = User::create([
            'name' => 'Dr. Ana López',
            'email' => 'psicologa@correo.com',
            'password' => bcrypt('12345678'),
            'role' => 'psicologo',
        ]);
    }
}
