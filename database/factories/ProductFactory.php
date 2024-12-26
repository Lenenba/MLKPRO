<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence, // Description aléatoire
            'category_id' => ProductCategory::factory(), // Crée une catégorie associée
            'user_id' => User::factory(), // Associe un utilisateur
            'image' => $this->faker->imageUrl(640, 480, 'products', true, 'Unsplash'), // Image aléatoire
            'stock' => $this->faker->numberBetween(0, 100), // Stock aléatoire
            'minimum_stock' => $this->faker->numberBetween(1, 10), // Stock minimum aléatoire
        ];
    }
}
