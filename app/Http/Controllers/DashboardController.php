<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch total counts from the database
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $totalClasses = DB::table('classes')->count();

        // Pass the counts to the dashboard view
        return view('dashboard', compact('totalStudents', 'totalTeachers', 'totalClasses'));
    }
}