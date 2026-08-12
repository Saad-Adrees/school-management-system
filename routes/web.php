<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AdminUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// Assuming you have an 'admin' middleware set up. If not, just use 'auth' for now.
Route::middleware(['auth'])->group(function () {
    
    // Route to view the users list
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    
    // Route to submit the role change
    Route::put('/admin/users/{user}/role', [AdminUserController::class, 'updateRole'])->name('admin.users.updateRole');
    
});

Route::middleware(['auth'])->group(function () {
    // Shared routes (All logged-in users: Admin, Teacher, Student)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin ONLY Routes
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('teachers', TeacherController::class);
    });

    // Admin and Teacher Routes
    Route::middleware(['role:admin,teacher'])->group(function () {
        Route::resource('students', StudentController::class);
        Route::resource('marks', MarkController::class);
        Route::resource('attendances', AttendanceController::class);
    });

    // Admin, Teacher, and Student Routes
    Route::middleware(['role:admin,teacher,student'])->group(function () {
        Route::get('/report-cards', [MarkController::class, 'reportCards'])->name('marks.report');
    });
});

require __DIR__.'/auth.php';