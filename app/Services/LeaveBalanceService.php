<?php

namespace App\Services;

use App\Models\LeaveBalance;
use App\Models\LeaveType;
use App\Models\User;

class LeaveBalanceService
{
    public function allocateForNewUser(User $user): void
    {
        $leaveTypes = LeaveType::all();

        foreach ($leaveTypes as $leaveType) {
            LeaveBalance::create([
                'user_id'       => $user->id,
                'leave_type_id' => $leaveType->id,
                'balance'       => $leaveType->eligible_days,
            ]);
        }
    }
}