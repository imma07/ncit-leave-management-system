<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
#[Fillable(['user_id', 'leave_type_id', 'start_date', 'end_date', 'reason', 'status'])]
class LeaveRequest extends Model
{
    /** @use HasFactory<\Database\Factories\LeaveRequestFactory> */
    use HasFactory;

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
