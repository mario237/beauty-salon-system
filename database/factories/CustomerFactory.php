<?php

namespace Database\Factories;

use App\Enums\CustomerSource;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'phone_number' => $this->faker->phoneNumber(),
            'source' => $this->faker->randomElement(CustomerSource::values()),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'added_by' => 1,
        ];
    }
}
