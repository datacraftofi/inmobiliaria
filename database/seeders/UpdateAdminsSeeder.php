<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UpdateAdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1) Marcar como admin al usuario existente DS3gura
        $existingEmail = 'datacraftofi@gmail.com';
        $existing = User::where('email', $existingEmail)->first();
        if ($existing) {
            if (!$existing->is_admin) {
                $existing->is_admin = true;
                $existing->save();
            }
        } else {
            // Si no existiera (por si cambió el dato), lo creamos como admin
            User::create([
                'name' => 'DS3gura',
                'email' => $existingEmail,
                'email_verified_at' => now(),
                'password' => Hash::make(Str::random(16)), // clave aleatoria
                'is_admin' => true,
                'remember_token' => Str::random(10),
            ]);
        }

        // 2) Crear (o asegurar) un segundo admin
        $secondAdminEmail = 'admin@inmosantillana.com'; // cámbialo si quieres
        $secondAdminPassword = 'Admin#2025!';            // cámbiala luego en producción

        $second = User::firstOrCreate(
            ['email' => $secondAdminEmail],
            [
                'name' => 'Administrador',
                'email_verified_at' => now(),
                'password' => Hash::make($secondAdminPassword),
                'is_admin' => true,
                'remember_token' => Str::random(10),
            ]
        );

        if (!$second->is_admin) {
            $second->is_admin = true;
            $second->save();
        }
    }
}
