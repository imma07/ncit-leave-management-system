<?php

namespace Database\Factories;

use App\Models\LeaveType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LeaveType>
 */
class LeaveTypeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'          => $this->faker->word() . ' Leave',
            'description'   => $this->faker->sentence(),
            'eligible_days' => $this->faker->numberBetween(5, 30),
        ];
    }
}