<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController; // 1. Add this import at the top
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
Route::resource('marks', MarkController::class);
Route::get('/report-cards', [MarkController::class, 'reportCards'])->name('marks.report');
    Route::resource('students', StudentController::class);
    Route::resource('teachers', TeacherController::class); // 2. Add this line here
    // Add this inside your auth middleware group
Route::resource('attendances', AttendanceController::class);
// Update your existing dashboard route to point to the controller
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

require __DIR__.'/auth.php';