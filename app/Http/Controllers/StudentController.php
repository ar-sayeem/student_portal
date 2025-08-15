<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Result;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index()
    {
        $students = User::where('role', 'student')
            ->withCount(['submissions', 'results'])
            ->orderBy('name')
            ->paginate(20);
            
        return view('students.index', compact('students'));
    }

    public function show(User $student)
    {
        if (!$student->isStudent()) {
            abort(404);
        }
        
        $student->load(['submissions.assignment', 'results']);
        
        $stats = [
            'totalSubmissions' => $student->submissions->count(),
            'gradedSubmissions' => $student->submissions->where('status', 'graded')->count(),
            'totalResults' => $student->results->count(),
            'averageGPA' => $student->results->avg('gpa'),
            'averageMarks' => $student->results->avg('marks_obtained'),
        ];
        
        return view('students.show', compact('student', 'stats'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'student_id' => 'required|string|max:50|unique:users,student_id',
            'department' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'session' => 'required|string|max:50',
            'semester' => 'required|integer|min:1|max:12',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'student',
            'student_id' => $validated['student_id'],
            'department' => $validated['department'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'session' => $validated['session'],
            'semester' => $validated['semester'],
        ]);

        return redirect()->route('students.index')
            ->with('success', 'Student created successfully!');
    }

    public function edit(User $student)
    {
        if (!$student->isStudent()) {
            abort(404);
        }
        
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, User $student)
    {
        if (!$student->isStudent()) {
            abort(404);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $student->id,
            'student_id' => 'required|string|max:50|unique:users,student_id,' . $student->id,
            'department' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'session' => 'required|string|max:50',
            'semester' => 'required|integer|min:1|max:12',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'student_id' => $validated['student_id'],
            'department' => $validated['department'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'session' => $validated['session'],
            'semester' => $validated['semester'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $student->update($updateData);

        return redirect()->route('students.index')
            ->with('success', 'Student updated successfully!');
    }

    public function destroy(User $student)
    {
        if (!$student->isStudent()) {
            abort(404);
        }
        
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully!');
    }

    public function results(User $student)
    {
        if (!$student->isStudent()) {
            abort(404);
        }
        
        $results = Result::where('student_id', $student->id)
            ->orderBy('exam_date', 'desc')
            ->paginate(10);
            
        return view('students.results', compact('student', 'results'));
    }

    public function submissions(User $student)
    {
        if (!$student->isStudent()) {
            abort(404);
        }
        
        $submissions = Submission::where('student_id', $student->id)
            ->with('assignment')
            ->orderBy('submitted_at', 'desc')
            ->paginate(10);
            
        return view('students.submissions', compact('student', 'submissions'));
    }
}
