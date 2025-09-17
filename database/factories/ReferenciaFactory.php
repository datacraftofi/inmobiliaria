<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReferenciaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre'   => $this->faker->name(),
            'relacion' => $this->faker->randomElement(['Padre','Madre','Hermano','Amigo','Jefe']),
            'telefono' => $this->faker->numerify('3#########'),
            'email'    => $this->faker->safeEmail(),
        ];
    }
}
