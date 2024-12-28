<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Work>
 */
class WorkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'customer_id' => Customer::factory(),
            'description' => $this->faker->sentence(10),
            'work_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'time_spent' => $this->faker->numberBetween(30, 480), // Time spent in minutes
            'is_completed' => $this->faker->boolean(),
            'cost' => $this->faker->randomFloat(2, 50, 5000),
            'location' => $this->faker->address(),
        ];
    }
}
