<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventoAuditoriaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tipo_evento' => $this->faker->randomElement(['CREACION','ACTUALIZACION','CAMBIO_ESTADO']),
            'payload'     => [
                'ip'      => $this->faker->ipv4(),
                'user_id' => $this->faker->numberBetween(1,5),
            ],
        ];
    }
}
