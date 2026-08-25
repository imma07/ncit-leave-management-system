<?php

namespace Database\Factories;

use App\Models\LeaveBalance;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LeaveBalance>
 */
class LeaveBalanceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'       => \App\Models\User::factory(),
            'leave_type_id' => \App\Models\LeaveType::factory(),
            'balance'       => $this->faker->numberBetween(5, 20),
        ];
    }
}