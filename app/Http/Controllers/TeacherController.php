<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $teachers = Teacher::with('schoolClass')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('employee_id', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%")
                             ->orWhere('subject', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        $classes = SchoolClass::all();
        return view('teachers.create', compact('classes'));
    }

    // ... your store, edit, update, destroy methods below

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id'     => 'required|unique:teachers,employee_id',
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:teachers,email',
            'phone'           => 'nullable|string|max:20',
            'subject'         => 'nullable|string|max:255',
            'school_class_id' => 'nullable|exists:classes,id',
        ]);

        Teacher::create($validated);

        return redirect()->route('teachers.index')->with('success', 'Teacher created successfully.');
    }

    public function edit(Teacher $teacher)
    {
        $classes = SchoolClass::all();
        return view('teachers.edit', compact('teacher', 'classes'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'employee_id'     => 'required|unique:teachers,employee_id,' . $teacher->id,
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:teachers,email,' . $teacher->id,
            'phone'           => 'nullable|string|max:20',
            'subject'         => 'nullable|string|max:255',
            'school_class_id' => 'nullable|exists:classes,id',
        ]);

        $teacher->update($validated);

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully.');
    }
}