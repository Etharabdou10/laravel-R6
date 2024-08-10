<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'=>fake()->randomElement(['dress', 'glasses', 't-shirt ']),
             'shortDescription'=> fake()->text(),
             'price'=>fake()->randomFloat(2),
             'image'=>basename(fake()->image(public_path('assets/images/products'))),
        ];
    }
}
