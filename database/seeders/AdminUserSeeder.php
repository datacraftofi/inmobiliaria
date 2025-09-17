<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ajusta email y password según prefieras
        $email = 'admin@inmosantillana.com';
        $password = 'Admin#2025!';

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => 'Administrador',
                'email_verified_at' => now(),
                'password' => Hash::make($password),
                'remember_token' => Str::random(10),
                'is_admin' => true,
            ]
        );

        // En caso de que ya existiera y quieras asegurarte de que sea admin
        if (!$user->is_admin) {
            $user->is_admin = true;
            $user->save();
        }
    }
}
