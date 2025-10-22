<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('classrooms', ClassroomController::class);
    Route::resource('classrooms.attendances', AttendanceController::class);
    Route::get('/classrooms/{classroom}/attendance-sheet', [AttendanceController::class, 'classAttendanceSheet'])->name('class.attendances.classAttendanceSheet');
    Route::resource('students', StudentController::class);
    Route::get('/students/{student}/attendance-details', [AttendanceController::class, 'studentAttendance'])->name('students.attendances.studentAttendance');
    Route::resource('attendances', AttendanceController::class);

    // This uses Route Model Binding for the Attendance model and points to the new destroyAttendance method.
    Route::delete('/attendances/{attendance}', [AttendanceController::class, 'destroyAttendance'])
        ->name('attendances.destroy');
    Route::resource('holidays', HolidayController::class);
    Route::resource('leaves', LeaveRequestController::class);

    // POST route for the approval action (leaves.approve)
    Route::post('/leaves/{leaf}/approve', [LeaveRequestController::class, 'approve'])
        ->name('leaves.approve');

    // POST route for the rejection action (leaves.reject)
    Route::post('/leaves/{leaf}/reject', [LeaveRequestController::class, 'reject'])
        ->name('leaves.reject');

});

require __DIR__ . '/auth.php';
