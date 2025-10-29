<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuarios>
 */
class UsuariosFactory extends Factory
{

    protected $model = User::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'usuarios' => $this->faker->name(), // Genera un nombre aleatorio
            'email' => $this->faker->unique()->safeEmail(), // Genera un email único y seguro
            'passuser' => Hash::make('password'),
            'nivel' => 'normal',
        ];
    }
}
