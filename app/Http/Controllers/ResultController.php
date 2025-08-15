<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    public function index()
    {
        if (Auth::user()->isStudent()) {
            return redirect()->route('results.my');
        }
        
        $results = Result::with(['student', 'uploader'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('results.index', compact('results'));
    }

    public function myResults()
    {
        $user = Auth::user();
        
        if (!$user->isStudent()) {
            return redirect()->route('results.index');
        }
        
        $results = Result::where('student_id', $user->id)
            ->orderBy('exam_date', 'desc')
            ->paginate(10);
            
        $averageGPA = Result::where('student_id', $user->id)->avg('gpa') ?? 0;
        $averagePercentage = Result::where('student_id', $user->id)
            ->selectRaw('AVG((marks_obtained / total_marks) * 100) as avg_percentage')
            ->value('avg_percentage') ?? 0;
        
        return view('results.my', compact('results', 'averageGPA', 'averagePercentage'));
    }

    public function create()
    {
        $this->authorize('create', Result::class);
        
        $students = User::where('role', 'student')
            ->orderBy('name')
            ->get();
            
        return view('results.create', compact('students'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Result::class);
        
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'course_code' => 'required|string|max:20',
            'course_name' => 'required|string|max:255',
            'semester' => 'required|string|max:50',
            'exam_type' => 'required|in:midterm,final,assignment,quiz,project',
            'marks_obtained' => 'required|numeric|min:0',
            'total_marks' => 'required|numeric|min:1',
            'exam_date' => 'required|date',
            'remarks' => 'nullable|string|max:500',
        ]);

        // Calculate grade and GPA
        $percentage = ($validated['marks_obtained'] / $validated['total_marks']) * 100;
        $grade = $this->calculateGrade($percentage);
        $gpa = $this->calculateGPA($percentage);

        Result::create([
            'student_id' => $validated['student_id'],
            'course_code' => $validated['course_code'],
            'course_name' => $validated['course_name'],
            'semester' => $validated['semester'],
            'exam_type' => $validated['exam_type'],
            'marks_obtained' => $validated['marks_obtained'],
            'total_marks' => $validated['total_marks'],
            'grade' => $grade,
            'gpa' => $gpa,
            'exam_date' => $validated['exam_date'],
            'remarks' => $validated['remarks'],
            'uploaded_by' => Auth::id(),
        ]);

        return redirect()->route('results.index')
            ->with('success', 'Result uploaded successfully!');
    }

    public function show(Result $result)
    {
        $result->load(['student', 'uploader']);
        
        if (Auth::user()->isStudent() && $result->student_id !== Auth::id()) {
            abort(403);
        }
        
        return view('results.show', compact('result'));
    }

    public function edit(Result $result)
    {
        $this->authorize('update', $result);
        
        $students = User::where('role', 'student')
            ->orderBy('name')
            ->get();
            
        return view('results.edit', compact('result', 'students'));
    }

    public function update(Request $request, Result $result)
    {
        $this->authorize('update', $result);
        
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'course_code' => 'required|string|max:20',
            'course_name' => 'required|string|max:255',
            'semester' => 'required|string|max:50',
            'exam_type' => 'required|in:midterm,final,assignment,quiz,project',
            'marks_obtained' => 'required|numeric|min:0',
            'total_marks' => 'required|numeric|min:1',
            'exam_date' => 'required|date',
            'remarks' => 'nullable|string|max:500',
        ]);

        // Calculate grade and GPA
        $percentage = ($validated['marks_obtained'] / $validated['total_marks']) * 100;
        $grade = $this->calculateGrade($percentage);
        $gpa = $this->calculateGPA($percentage);

        $result->update([
            'student_id' => $validated['student_id'],
            'course_code' => $validated['course_code'],
            'course_name' => $validated['course_name'],
            'semester' => $validated['semester'],
            'exam_type' => $validated['exam_type'],
            'marks_obtained' => $validated['marks_obtained'],
            'total_marks' => $validated['total_marks'],
            'grade' => $grade,
            'gpa' => $gpa,
            'exam_date' => $validated['exam_date'],
            'remarks' => $validated['remarks'],
        ]);

        return redirect()->route('results.index')
            ->with('success', 'Result updated successfully!');
    }

    public function destroy(Result $result)
    {
        $this->authorize('delete', $result);
        
        $result->delete();

        return redirect()->route('results.index')
            ->with('success', 'Result deleted successfully!');
    }

    private function calculateGrade($percentage)
    {
        if ($percentage >= 80) return 'A+';
        if ($percentage >= 75) return 'A';
        if ($percentage >= 70) return 'A-';
        if ($percentage >= 65) return 'B+';
        if ($percentage >= 60) return 'B';
        if ($percentage >= 55) return 'B-';
        if ($percentage >= 50) return 'C+';
        if ($percentage >= 45) return 'C';
        if ($percentage >= 40) return 'D';
        return 'F';
    }

    private function calculateGPA($percentage)
    {
        if ($percentage >= 80) return 4.00;
        if ($percentage >= 75) return 3.75;
        if ($percentage >= 70) return 3.50;
        if ($percentage >= 65) return 3.25;
        if ($percentage >= 60) return 3.00;
        if ($percentage >= 55) return 2.75;
        if ($percentage >= 50) return 2.50;
        if ($percentage >= 45) return 2.25;
        if ($percentage >= 40) return 2.00;
        return 0.00;
    }
}
