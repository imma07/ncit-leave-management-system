<?php

namespace Database\Seeders;

use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeaveRequestSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $annual   = LeaveType::where('name', 'Annual Leave')->first();
        $sickNmc  = LeaveType::where('name', 'Sick Leave (NMC)')->first();
        $sickWmc  = LeaveType::where('name', 'Sick Leave (WMC)')->first();
        $frl      = LeaveType::where('name', 'Family responsibility Leave (FRL)')->first();

        LeaveRequest::updateOrCreate(['id' => 1], [
            'user_id'       => 2,
            'leave_type_id' => $annual?->id,
            'start_date'    => now()->addDays(5)->toDateString(),
            'end_date'      => now()->addDays(9)->toDateString(),
            'reason'        => 'Family vacation',
            'status'        => 'pending',
        ]);

        LeaveRequest::updateOrCreate(['id' => 2], [
            'user_id'       => 2,
            'leave_type_id' => $sickNmc?->id,
            'start_date'    => now()->subDays(10)->toDateString(),
            'end_date'      => now()->subDays(8)->toDateString(),
            'reason'        => 'Fever and cold',
            'status'        => 'pending',
        ]);

        LeaveRequest::updateOrCreate(['id' => 3], [
            'user_id'       => 2,
            'leave_type_id' => $frl?->id,
            'start_date'    => now()->subDays(20)->toDateString(),
            'end_date'      => now()->subDays(19)->toDateString(),
            'reason'        => 'Child school event',
            'status'        => 'pending',
        ]);

        // Ismail (user_id = 3)
        LeaveRequest::updateOrCreate(['id' => 4], [
            'user_id'       => 3,
            'leave_type_id' => $sickWmc?->id,
            'start_date'    => now()->addDays(2)->toDateString(),
            'end_date'      => now()->addDays(4)->toDateString(),
            'reason'        => 'Medical procedure',
            'status'        => 'pending',
        ]);

        LeaveRequest::updateOrCreate(['id' => 5], [
            'user_id'       => 3,
            'leave_type_id' => $annual?->id,
            'start_date'    => now()->subDays(30)->toDateString(),
            'end_date'      => now()->subDays(25)->toDateString(),
            'reason'        => 'Annual holiday trip',
            'status'        => 'pending',
        ]);
    }
}
