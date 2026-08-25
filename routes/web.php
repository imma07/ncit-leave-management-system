<?php

use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\ProfileController;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'users'        => User::where('role', 'user')->get(['id', 'name', 'email', 'department', 'designation']),
        'leaveRequests' => LeaveRequest::with('leaveType:id,name', 'user:id,name')
                            ->latest()
                            ->get(['id', 'user_id', 'leave_type_id', 'start_date', 'end_date', 'status']),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/user-dashboard', function () {
    return Inertia::render('UserDashboard', [
        'leaveTypes' => LeaveType::all(['id', 'name']),
        'leaveRequests' => LeaveRequest::with('leaveType:id,name')
                ->where('user_id', auth()->id())
                ->latest()
                ->get(['id', 'leave_type_id', 'start_date', 'end_date', 'status']),
    ]);
})->middleware(['auth', 'verified'])->name('user-dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/leave-requests', [LeaveRequestController::class, 'store'])->name('leave-requests.store');
    Route::patch('/leave-requests/{leaveRequest}/status', [LeaveRequestController::class, 'updateStatus'])->middleware('admin')->name('leave-requests.update-status');


});

require __DIR__.'/auth.php';
