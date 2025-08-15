<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    public function index()
    {
        if (Auth::user()->isStudent()) {
            $submissions = Submission::where('student_id', Auth::id())
                ->with('assignment')
                ->orderBy('submitted_at', 'desc')
                ->paginate(10);
        } else {
            $submissions = Submission::with(['student', 'assignment'])
                ->orderBy('submitted_at', 'desc')
                ->paginate(20);
        }
        
        return view('submissions.index', compact('submissions'));
    }

    public function show(Submission $submission)
    {
        $this->authorize('view', $submission);
        
        $submission->load(['assignment', 'student', 'grader']);
        return view('submissions.show', compact('submission'));
    }

    public function create(Assignment $assignment)
    {
        // Check if user is student
        if (!Auth::user()->isStudent()) {
            abort(403);
        }
        
        // Check if assignment is still active and not overdue
        if (!$assignment->is_active) {
            return redirect()->route('assignments.show', $assignment)
                ->with('error', 'This assignment is no longer accepting submissions.');
        }
        
        // Check if student has already submitted
        $existingSubmission = $assignment->getSubmissionByStudent(Auth::id());
        if ($existingSubmission) {
            return redirect()->route('assignments.show', $assignment)
                ->with('error', 'You have already submitted this assignment.');
        }
        
        return view('submissions.create', compact('assignment'));
    }

    public function store(Request $request, Assignment $assignment)
    {
        // Validate user is student
        if (!Auth::user()->isStudent()) {
            abort(403);
        }
        
        // Check if already submitted
        $existingSubmission = $assignment->getSubmissionByStudent(Auth::id());
        if ($existingSubmission) {
            return redirect()->route('assignments.show', $assignment)
                ->with('error', 'You have already submitted this assignment.');
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'nullable|string|max:1000',
            'file' => 'required|file|mimes:pdf,doc,docx,zip,rar|max:20480', // 20MB max
        ]);

        $file = $request->file('file');
        $filePath = $file->store('submissions', 'public');
        $originalFilename = $file->getClientOriginalName();
        
        $status = $assignment->isOverdue() ? 'late' : 'submitted';

        Submission::create([
            'assignment_id' => $assignment->id,
            'student_id' => Auth::id(),
            'title' => $validated['title'],
            'message' => $validated['message'],
            'file_path' => $filePath,
            'original_filename' => $originalFilename,
            'submitted_at' => now(),
            'status' => $status,
        ]);

        $statusMessage = $status === 'late' 
            ? 'Assignment submitted successfully! (Note: Submission was late)' 
            : 'Assignment submitted successfully! You can view your submission status in "My Submissions".';

        return redirect()->route('submissions.index')
            ->with('success', $statusMessage);
    }

    public function grade(Request $request, Submission $submission)
    {
        $this->authorize('grade', $submission);
        
        $validated = $request->validate([
            'marks' => 'required|integer|min:0|max:' . $submission->assignment->max_marks,
            'feedback' => 'nullable|string|max:1000',
        ]);

        $submission->update([
            'marks' => $validated['marks'],
            'feedback' => $validated['feedback'],
            'status' => 'graded',
            'graded_at' => now(),
            'graded_by' => Auth::id(),
        ]);

        return redirect()->back()
            ->with('success', 'Submission graded successfully!');
    }

    public function edit(Submission $submission)
    {
        $this->authorize('update', $submission);
        
        $submission->load('assignment');
        return view('submissions.edit', compact('submission'));
    }

    public function update(Request $request, Submission $submission)
    {
        $this->authorize('update', $submission);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'nullable|string|max:1000',
            'file' => 'nullable|file|mimes:pdf,doc,docx,txt,zip,rar|max:20480', // 20MB max
        ]);

        $updateData = [
            'title' => $validated['title'],
            'message' => $validated['message'],
        ];

        // Handle file upload if provided
        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($submission->file_path && Storage::disk('public')->exists($submission->file_path)) {
                Storage::disk('public')->delete($submission->file_path);
            }
            
            $file = $request->file('file');
            $filePath = $file->store('submissions', 'public');
            $originalFilename = $file->getClientOriginalName();
            
            $updateData['file_path'] = $filePath;
            $updateData['original_filename'] = $originalFilename;
        }

        $submission->update($updateData);

        return redirect()->route('submissions.show', $submission)
            ->with('success', 'Submission updated successfully!');
    }

    public function downloadFile(Submission $submission)
    {
        $this->authorize('view', $submission);
        
        if (!Storage::disk('public')->exists($submission->file_path)) {
            abort(404);
        }

        $filename = $submission->original_filename ?: basename($submission->file_path);
        return Storage::disk('public')->download($submission->file_path, $filename);
    }

    public function bulkGrade(Request $request)
    {
        $this->authorize('bulkGrade', Submission::class);
        
        $validated = $request->validate([
            'submissions' => 'required|array',
            'submissions.*.id' => 'required|exists:submissions,id',
            'submissions.*.marks' => 'required|integer|min:0',
            'submissions.*.feedback' => 'nullable|string|max:1000',
        ]);

        foreach ($validated['submissions'] as $submissionData) {
            $submission = Submission::find($submissionData['id']);
            $submission->update([
                'marks' => $submissionData['marks'],
                'feedback' => $submissionData['feedback'] ?? null,
                'status' => 'graded',
                'graded_at' => now(),
                'graded_by' => Auth::id(),
            ]);
        }

        return redirect()->back()
            ->with('success', 'Submissions graded successfully!');
    }
}
