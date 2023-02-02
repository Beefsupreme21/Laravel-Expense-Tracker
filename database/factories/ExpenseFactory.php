<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class ExpenseFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => 1,
            'amount' => fake()->randomFloat(2, 0.01, 10000.00),
            'date' => fake()->dateTimeBetween('-1 years', 'now'),
            'description' => fake()->company(),
            'category' => fake()->randomElement([
                'Rent', 
                'Utilities', 
                'Food', 
                'Entertainment',
                'Misc', 
            ]),
            'type' => fake()->randomElement([
                'income', 
                'expense', 
            ]),
        ];
    }
}
