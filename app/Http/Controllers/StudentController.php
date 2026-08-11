<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\SchoolClass;

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

        $students = $query->with('schoolClass')->latest()->get();

        return view('students.index', compact('students'));
    }

    public function create()
{
    $classes = SchoolClass::all();
    return view('students.create', compact('classes'));
}

    public function store(Request $request)
    {
        $request->validate([
        'roll_number' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'class_id' => 'required|exists:classes,id', // <-- This is the updated line
    ]);

        Student::create($request->all());

        return redirect()->route('students.index')->with('success', 'Student added successfully!');
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

   public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'roll_number' => 'required|string|unique:students,roll_number,' . $student->id,
            'email'       => 'required|email|unique:students,email,' . $student->id,
            'class'       => 'required|string|max:255',
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