<?php

namespace Tests\Feature;

use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeaveRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_submit_a_leave_request(): void
    {
        $user      = User::factory()->create(['role' => 'user']);
        $leaveType = LeaveType::factory()->create(['eligible_days' => 10]);
        LeaveBalance::factory()->create(['user_id' => $user->id, 'leave_type_id' => $leaveType->id, 'balance' => 10]);

        $this->actingAs($user)
            ->post(route('leave-requests.store'), [
                'leave_type_id' => $leaveType->id,
                'start_date'    => now()->addDay()->toDateString(),
                'end_date'      => now()->addDays(3)->toDateString(),
                'reason'        => 'Family trip',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('leave_requests', ['user_id' => $user->id, 'status' => 'pending']);
    }

    public function test_guest_cannot_submit_a_leave_request(): void
    {
        $this->post(route('leave-requests.store'), [])->assertRedirect(route('login'));
    }

    public function test_admin_can_update_leave_request_status(): void
    {
        $admin   = User::factory()->create(['role' => 'admin']);
        $request = LeaveRequest::factory()->create(['status' => 'pending']);

        $this->actingAs($admin)
            ->patch(route('leave-requests.update-status', $request), ['status' => 'approved'])
            ->assertRedirect();

        $this->assertDatabaseHas('leave_requests', ['id' => $request->id, 'status' => 'approved']);
    }

    public function test_guest_cannot_update_leave_request_status(): void
    {
        $request = LeaveRequest::factory()->create();

        $this->patch(route('leave-requests.update-status', $request), ['status' => 'approved'])
            ->assertRedirect(route('login'));
    }
}
