<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SolicitudFactory extends Factory
{
    public function definition(): array
    {
        $estados = ['borrador','enviada','aprobada','rechazada','archivada'];
        return [
            'nombre'    => $this->faker->name(),
            'documento' => strtoupper($this->faker->bothify('DOC-###??')),
            'email'     => $this->faker->unique()->safeEmail(),
            'telefono'  => $this->faker->numerify('3#########'),
            'direccion' => $this->faker->address(),
            'estado'    => $this->faker->randomElement($estados),
            'meta'      => ['origen' => $this->faker->randomElement(['web','kiosk','backoffice'])],
        ];
    }
}
