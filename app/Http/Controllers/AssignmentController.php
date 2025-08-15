<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AssignmentController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        if (Auth::user()->isStudent()) {
            $assignments = Assignment::where('is_active', true)
                ->orderBy('due_date', 'asc')
                ->paginate(10);
        } else {
            $assignments = Assignment::with('creator')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }
        
        return view('assignments.index', compact('assignments'));
    }

    public function show(Assignment $assignment)
    {
        $assignment->load('creator', 'submissions.student');
        
        $submission = null;
        if (Auth::user()->isStudent()) {
            $submission = $assignment->submissions()->where('student_id', Auth::id())->first();
        }
        
        return view('assignments.show', compact('assignment', 'submission'));
    }

    public function create()
    {
        $this->authorize('create', Assignment::class);
        return view('assignments.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Assignment::class);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'course_code' => 'required|string|max:20',
            'course_name' => 'required|string|max:255',
            'due_date' => 'required|date|after:today',
            'max_marks' => 'required|integer|min:1|max:200',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $filePath = null;
        $originalFilename = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalFilename = $file->getClientOriginalName();
            $filePath = $file->store('assignments', 'public');
        }

        Assignment::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'course_code' => $validated['course_code'],
            'course_name' => $validated['course_name'],
            'due_date' => $validated['due_date'],
            'max_marks' => $validated['max_marks'],
            'file_path' => $filePath,
            'original_filename' => $originalFilename,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('assignments.index')
            ->with('success', 'Assignment created successfully!');
    }

    public function edit(Assignment $assignment)
    {
        $this->authorize('update', $assignment);
        return view('assignments.edit', compact('assignment'));
    }

    public function update(Request $request, Assignment $assignment)
    {
        $this->authorize('update', $assignment);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'course_code' => 'required|string|max:20',
            'course_name' => 'required|string|max:255',
            'due_date' => 'required|date',
            'max_marks' => 'required|integer|min:1|max:200',
            'is_active' => 'boolean',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($assignment->file_path) {
                Storage::disk('public')->delete($assignment->file_path);
            }
            $file = $request->file('file');
            $validated['file_path'] = $file->store('assignments', 'public');
            $validated['original_filename'] = $file->getClientOriginalName();
        }

        $assignment->update($validated);

        return redirect()->route('assignments.index')
            ->with('success', 'Assignment updated successfully!');
    }

    public function destroy(Assignment $assignment)
    {
        $this->authorize('delete', $assignment);
        
        // Delete assignment file if exists
        if ($assignment->file_path) {
            Storage::disk('public')->delete($assignment->file_path);
        }
        
        // Delete all submission files for this assignment
        foreach ($assignment->submissions as $submission) {
            if ($submission->file_path) {
                Storage::disk('public')->delete($submission->file_path);
            }
        }
        
        // Delete the assignment (this will cascade delete submissions due to foreign key constraint)
        $assignment->delete();

        return redirect()->route('assignments.index')
            ->with('success', 'Assignment and all related submissions deleted successfully!');
    }

    public function downloadFile(Assignment $assignment)
    {
        if (!$assignment->file_path || !Storage::disk('public')->exists($assignment->file_path)) {
            abort(404);
        }

        $filename = $assignment->original_filename ?: basename($assignment->file_path);
        return Storage::disk('public')->download($assignment->file_path, $filename);
    }
}
