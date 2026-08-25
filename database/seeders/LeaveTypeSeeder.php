<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        LeaveType::updateOrCreate([
            'name' => 'Annual Leave',
            'description' => 'Annual Leave',
            'eligible_days' => 30
        ]);
        LeaveType::updateOrCreate([
            'name' => 'Sick Leave (NMC)',
            'description' => 'Sick Leave without MC',
            'eligible_days' => 15
        ]);
        LeaveType::updateOrCreate([
            'name' => 'Sick Leave (WMC)',
            'description' => 'Sick Leave with MC',
            'eligible_days' => 15
        ]);
        LeaveType::updateOrCreate([
            'name' => 'Family responsibility Leave (FRL)',
            'description' => 'Family responsibility Leave',
            'eligible_days' => 10
        ]);

    }
}
