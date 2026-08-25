<?php

namespace Database\Factories;

use App\Models\LeaveRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LeaveRequest>
 */
class LeaveRequestFactory extends Factory
{
    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('+1 day', '+10 days');
        $end   = $this->faker->dateTimeBetween($start, '+20 days');

        return [
            'user_id'       => \App\Models\User::factory(),
            'leave_type_id' => \App\Models\LeaveType::factory(),
            'start_date'    => $start->format('Y-m-d'),
            'end_date'      => $end->format('Y-m-d'),
            'reason'        => $this->faker->sentence(),
            'status'        => 'pending',
        ];
    }
}