<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with('student');

        // Search by Date
        if ($request->filled('date')) {
            $query->whereDate('attendance_date', $request->date);
        }

        // Search by Student Name
        if ($request->filled('search')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $attendances = $query->latest('attendance_date')->paginate(10);
        
        return view('attendances.index', compact('attendances'));
    }

    public function create()
    {
        $students = Student::orderBy('name')->get();
        return view('attendances.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'attendance_date' => 'required|date',
            'status' => 'required|in:Present,Absent,Leave',
        ]);

        // Check if attendance already exists for this student on this date
        $exists = Attendance::where('student_id', $request->student_id)
            ->whereDate('attendance_date', $request->attendance_date)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Attendance for this student on this date is already recorded.');
        }

        Attendance::create($request->all());

        return redirect()->route('attendances.index')->with('success', 'Attendance marked successfully.');
    }

    public function edit(Attendance $attendance)
    {
        $students = Student::orderBy('name')->get();
        return view('attendances.edit', compact('attendance', 'students'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'attendance_date' => 'required|date',
            'status' => 'required|in:Present,Absent,Leave',
        ]);

        $attendance->update($request->all());

        return redirect()->route('attendances.index')->with('success', 'Attendance updated successfully.');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->route('attendances.index')->with('success', 'Attendance record deleted.');
    }
}