<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SoporteFactory extends Factory
{
    public function definition(): array
    {
        $hashSource = Str::random(32);
        return [
            'nombre_original' => $this->faker->randomElement(['cedula.pdf','recibo.pdf','contrato.pdf']),
            'ruta'            => 'solicitudes/seed/'.Str::uuid().'/'.$this->faker->filePath(), // solo metadatos
            'disk'            => 'public',
            'mime_type'       => 'application/pdf',
            'size'            => $this->faker->numberBetween(50_000, 2_000_000),
            'hash'            => hash('sha256', $hashSource),
            'tipo'            => $this->faker->randomElement(['cedula','recibo','contrato']),
        ];
    }
}
