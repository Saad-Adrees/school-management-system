<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatbotController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    // Shared routes (All authenticated users)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin ONLY Routes
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('teachers', TeacherController::class);
        
        // User Management & Manual Password Override
        Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
        Route::put('/admin/users/{user}/role', [AdminUserController::class, 'updateRole'])->name('admin.users.updateRole');
        Route::put('/admin/users/{user}/update-password', [AdminUserController::class, 'updatePassword'])->name('admin.users.password.update');
    });

    // Admin & Teacher Routes
    Route::middleware(['role:admin,teacher'])->group(function () {
        Route::resource('students', StudentController::class);
        Route::resource('marks', MarkController::class);
        Route::resource('attendances', AttendanceController::class);
    });
    // Chatbot endpoint (protected by authentication)
Route::post('/chatbot/ask', [ChatbotController::class, 'ask'])->name('chatbot.ask')->middleware('auth');

    // Admin, Teacher, & Student Routes
    Route::middleware(['role:admin,teacher,student'])->group(function () {
        Route::get('/report-cards', [MarkController::class, 'reportCards'])->name('marks.report');
    });

});

require __DIR__.'/auth.php';