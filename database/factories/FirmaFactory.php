<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FirmaFactory extends Factory
{
    public function definition(): array
    {
        $hashSource = Str::random(32);
        return [
            'ruta'       => 'solicitudes/seed/'.Str::uuid().'/firma.png',
            'hash'       => hash('sha256', $hashSource),
            'firmante'   => $this->faker->name(),
            'firmado_at' => $this->faker->dateTimeBetween('-30 days','now'),
        ];
    }
}
