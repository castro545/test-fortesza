<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class UserFactory extends Factory
{
    /**
     * El método definition() se encarga de devolver una matriz de valores predeterminados
     * para los atributos del modelo. Dentro de este método, se utiliza la librería Faker 
     * para generar datos falsos para cada atributo
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'username' => fake()->username(),
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt(fake()->password), // password
        ];
    }

}
