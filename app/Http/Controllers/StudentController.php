<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('roll_number', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Paginate results (10 items per page) & preserve search queries
        $students = $query->with('schoolClass')->latest()->paginate(10)->withQueryString();

        return view('students.index', compact('students'));
    }

    public function create()
{
    $classes = SchoolClass::orderBy('id', 'asc')->get();

    return view('students.create', compact('classes'));
}

    public function store(Request $request)
    {
        $request->validate([
            'roll_number' => 'required|string|max:255|unique:students,roll_number',
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|max:255|unique:students,email',
            'class_id'    => 'required|exists:classes,id',
        ]);

        Student::create($request->all());

        return redirect()->route('students.index')->with('success', 'Student added successfully!');
    }

    public function edit(Student $student)
    {
        $classes = SchoolClass::all();
        return view('students.edit', compact('student', 'classes'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'roll_number' => 'required|string|max:255|unique:students,roll_number,' . $student->id,
            'email'       => 'required|email|max:255|unique:students,email,' . $student->id,
            'class_id'    => 'required|exists:classes,id',
        ]);

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}