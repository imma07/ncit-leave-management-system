<?php

namespace App\Services;

use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use App\Models\User;
use Carbon\Carbon;

class LeaveEligibilityService
{
    public function check(User $user, int $leaveTypeId, string $startDate, string $endDate): ?string
    {
        $start = Carbon::parse($startDate)->startOfDay();
        $end   = Carbon::parse($endDate)->startOfDay();

        if ($this->hasOverlap($user->id, $start, $end)) {
            return 'You already have a leave request that overlaps with the selected dates.';
        }

        $daysRequested = $start->diffInDays($end) + 1;

        if (! $this->hasSufficientBalance($user->id, $leaveTypeId, $daysRequested)) {
            return 'Insufficient leave balance for the selected leave type.';
        }

        return null;
    }

    private function hasOverlap(int $userId, Carbon $start, Carbon $end): bool
    {
        return LeaveRequest::where('user_id', $userId)
            ->whereNotIn('status', ['rejected'])
            ->where('start_date', '<=', $end)
            ->where('end_date', '>=', $start)
            ->exists();
    }

    private function hasSufficientBalance(int $userId, int $leaveTypeId, int $daysRequested): bool
    {
        $balance = LeaveBalance::where('user_id', $userId)
            ->where('leave_type_id', $leaveTypeId)
            ->first();

        return $balance && $balance->balance >= $daysRequested;
    }
}
