<?php

namespace Database\Seeders;

use App\Models\Psicologo;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PsicologoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('role', 'psicologo')->first();

        Psicologo::create([
            'user_id' => $user->id,
            'cedula_profesional' => 'PSI-123456',
        ]);
    }
}
