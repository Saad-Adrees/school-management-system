<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch total counts for the summary cards
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        
        // Safely check table name for classes
        $totalClasses = Schema::hasTable('school_classes') 
            ? DB::table('school_classes')->count() 
            : (Schema::hasTable('classes') ? DB::table('classes')->count() : 0);

        $user = Auth::user();
        $attendanceStats = null;

        // If logged-in user is a student, calculate attendance stats
        if ($user && $user->role === 'student') {
            $student = Student::where('email', $user->email)->first();

            if ($student) {
                $totalDays   = Attendance::where('student_id', $student->id)->count();
                $presentDays = Attendance::where('student_id', $student->id)->where('status', 'Present')->count();
                $absentDays  = Attendance::where('student_id', $student->id)->where('status', 'Absent')->count();
                $leaveDays   = Attendance::where('student_id', $student->id)->where('status', 'Leave')->count();

                $percentage = $totalDays > 0 ? round(($presentDays / $totalDays) * 100, 1) : 0;

                $attendanceStats = [
                    'total'      => $totalDays,
                    'present'    => $presentDays,
                    'absent'     => $absentDays,
                    'leave'      => $leaveDays,
                    'percentage' => $percentage,
                ];
            }
        }

        return view('dashboard', compact(
            'totalStudents', 
            'totalTeachers', 
            'totalClasses', 
            'attendanceStats'
        ));
    }
}