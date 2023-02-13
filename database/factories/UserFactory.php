<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     

    public function definition()
    {
        return [
            'name' => fake()->name(),
            'username' => fake()->username(),
            'email' => fake()->unique()->safeEmail(),
            'password' => fake()->password(bcrypt()), // password
        ];
    }

}
