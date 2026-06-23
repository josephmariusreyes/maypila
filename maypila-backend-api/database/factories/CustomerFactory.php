<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\QueueSession;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'mobile_number' => '09' . fake()->numerify('#########'),
            'customer_status' => 'PENDING',
            'que_number' => fake()->numberBetween(1, 999),
        ];
    }
}