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
        $users = User::where('role', 'psicologo')->get();

        foreach ($users as $index => $user) {
            Psicologo::firstOrCreate(
                ['user_id' => $user->id],
                ['cedula_profesional' => 'PSI-' . str_pad((string) ($index + 1), 6, '0', STR_PAD_LEFT)]
            );
        }
    }
}
