<?php

namespace App\Http\Controllers;

use App\Models\Mark;
use App\Models\Student;
use Illuminate\Http\Request;

class MarkController extends Controller
{
    public function index(Request $request)
    {
        $query = Mark::with('student');

        // Search feature similar to your Teacher Directory
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('student', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('subject', 'like', "%{$search}%");
        }

        $marks = $query->latest()->paginate(10);
        return view('marks.index', compact('marks'));
    }

    public function create()
    {
        $students = Student::all(); // Used to populate the dropdown
        return view('marks.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject' => 'required|string|max:255',
            'marks_obtained' => 'required|numeric|min:0',
            'total_marks' => 'required|numeric|min:1',
            'grade' => 'nullable|string|max:5',
        ]);

        Mark::create($validated);
        return redirect()->route('marks.index')->with('success', 'Marks added successfully.');
    }

    public function edit(Mark $mark)
    {
        $students = Student::all();
        return view('marks.edit', compact('mark', 'students'));
    }

    public function update(Request $request, Mark $mark)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject' => 'required|string|max:255',
            'marks_obtained' => 'required|numeric|min:0',
            'total_marks' => 'required|numeric|min:1',
            'grade' => 'nullable|string|max:5',
        ]);

        $mark->update($validated);
        return redirect()->route('marks.index')->with('success', 'Marks updated successfully.');
    }

    public function destroy(Mark $mark)
    {
        $mark->delete();
        return redirect()->route('marks.index')->with('success', 'Marks deleted successfully.');
    }

    // Portal for summarizing all marks per student
    public function reportCards()
    {
        $students = Student::with('marks')->get();
        return view('marks.report', compact('students'));
    }
}