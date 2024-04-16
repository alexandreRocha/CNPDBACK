<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Legislacao>
 */
class LegislacaoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'titulo'=>$this->faker->sentence(), 
            'descricao'=>$this->faker->text(),
            'anexo'=>$this->faker->text(),
            'estado'=>$this->faker->text(),

        ];
    }
}
