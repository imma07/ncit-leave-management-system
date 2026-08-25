<?php

namespace App\Http\Controllers;

use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use App\Http\Requests\StoreLeaveRequestRequest;
use App\Http\Requests\UpdateLeaveRequestRequest;
use App\Services\LeaveEligibilityService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLeaveRequestRequest $request, LeaveEligibilityService $eligibility)
    {
        $data = $request->validated();
        $user = $request->user();

        $error = $eligibility->check($user, $data['leave_type_id'], $data['start_date'], $data['end_date']);

        if ($error) {
            return back()->withErrors(['leave_type_id' => $error]);
        }

        LeaveRequest::create([...$data, 'user_id' => $user->id]);

        return redirect()->route('user-dashboard')->with('success', 'Leave request submitted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LeaveRequest $leaveRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeaveRequest $leaveRequest)
    {
        //
    }

    public function updateStatus(Request $request, LeaveRequest $leaveRequest)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $previousStatus = $leaveRequest->status;
        $newStatus      = $request->status;

        $leaveRequest->update(['status' => $newStatus]);

        if ($newStatus === 'approved' && $previousStatus !== 'approved') {
            $days = Carbon::parse($leaveRequest->start_date)->diffInDays(
                Carbon::parse($leaveRequest->end_date)
            ) + 1;

            LeaveBalance::where('user_id', $leaveRequest->user_id)
                ->where('leave_type_id', $leaveRequest->leave_type_id)
                ->decrement('balance', $days);
        }

        return back()->with('success', 'Leave request status updated to ' . $newStatus . '.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLeaveRequestRequest $request, LeaveRequest $leaveRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LeaveRequest $leaveRequest)
    {
        //
    }
}
