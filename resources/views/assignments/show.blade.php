<x-app-layout>
    <x-slot name="title">{{ $assignment->title }}</x-slot>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $assignment->title }}
            </h2>
            <a href="{{ route('assignments.index') }}" 
               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md">
                Back to Assignments
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Assignment Info -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    {{ $assignment->course_code }}
                                </span>
                                <h3 class="text-lg font-medium text-gray-900 mt-2">{{ $assignment->course_name }}</h3>
                            </div>
                            <div class="text-right">
                                @if(!$assignment->is_active)
                                    <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold bg-gray-500 text-white border border-gray-600">
                                        ⏸️ Inactive
                                    </span>
                                @elseif($assignment->due_date->isPast())
                                    <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold bg-red-100 text-red-800 border border-red-200">
                                        🚫 Overdue
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold bg-green-200 text-green-900 border border-green-300">
                                        ✅ Active
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                            <div>📅 <strong>Due Date:</strong> {{ $assignment->due_date->format('M d, Y H:i') }}</div>
                            <div>📊 <strong>Max Marks:</strong> {{ $assignment->max_marks }}</div>
                            <div>👤 <strong>Created by:</strong> {{ $assignment->creator->name }}</div>
                        </div>
                    </div>

                    <!-- Assignment Description -->
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-3">
                            <h4 class="text-lg font-medium text-gray-900">Assignment Description</h4>
                            @can('update', $assignment)
                                <div class="flex space-x-3">
                                    <a href="{{ route('assignments.edit', $assignment) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm transition-colors">
                                        ✏️ Edit Assignment
                                    </a>
                                    <form method="POST" action="{{ route('assignments.destroy', $assignment) }}" 
                                          onsubmit="return confirm('⚠️ Are you sure you want to delete this assignment?\n\nThis will permanently delete:\n• The assignment and all its details\n• All student submissions ({{ $assignment->submissions->count() }} submissions)\n• All related files\n\nThis action cannot be undone!')"
                                          class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg text-sm transition-colors">
                                            🗑️ Delete Assignment
                                        </button>
                                    </form>
                                </div>
                            @endcan
                        </div>
                        <div class="bg-gray-50 rounded-md p-4">
                            <p class="text-gray-700 whitespace-pre-line">{{ $assignment->description }}</p>
                        </div>
                    </div>

                    <!-- Assignment File -->
                    @if($assignment->file_path)
                        <div class="mb-6">
                            <h4 class="text-lg font-medium text-gray-900 mb-3">Assignment File</h4>
                            <a href="{{ route('assignments.download', $assignment) }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md">
                                📁 Download Assignment File
                            </a>
                        </div>
                    @endif

                    <!-- Student Submission Section -->
                    @if(auth()->user()->isStudent())
                        <div class="border-t pt-6">
                            <h4 class="text-lg font-medium text-gray-900 mb-3">Your Submission</h4>
                            @if(isset($submission) && $submission)
                                <div class="bg-green-50 border border-green-200 rounded-md p-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Submitted
                                            </span>
                                        </div>
                                        <div class="ml-3 flex-1">
                                            <p class="text-sm text-green-800">
                                                <strong>Submitted on:</strong> {{ $submission->submitted_at->format('M d, Y H:i') }}
                                            </p>
                                            @if($submission->grade)
                                                <p class="text-sm text-green-800">
                                                    <strong>Grade:</strong> {{ $submission->grade }}/{{ $assignment->max_marks }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @else
                                @if(!$assignment->due_date->isPast())
                                    <a href="{{ route('submissions.create', $assignment) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md">
                                        📤 Submit Assignment
                                    </a>
                                @else
                                    <div class="bg-red-50 border border-red-200 rounded-md p-4">
                                        <p class="text-sm text-red-800">This assignment is overdue. Submission is no longer allowed.</p>
                                    </div>
                                @endif
                            @endif
                        </div>
                    @endif

                    <!-- Teacher/Admin Submission Management -->
                    @if(auth()->user()->isAdmin() || auth()->user()->isTeacher())
                        <div class="border-t pt-6">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-lg font-medium text-gray-900">Student Submissions</h4>
                                <span class="text-sm text-gray-500">{{ $assignment->submissions->count() }} submissions</span>
                            </div>
                            
                            @if($assignment->submissions->count() > 0)
                                <div class="space-y-3">
                                    @foreach($assignment->submissions as $submission)
                                        <div class="flex items-center justify-between p-3 border border-gray-200 rounded-md">
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $submission->student->name }}</p>
                                                <p class="text-sm text-gray-500">Submitted: {{ $submission->submitted_at->format('M d, Y H:i') }}</p>
                                            </div>
                                            <div class="flex items-center space-x-3">
                                                @if($submission->grade)
                                                    <span class="text-sm font-medium text-green-600">{{ $submission->grade }}/{{ $assignment->max_marks }}</span>
                                                @else
                                                    <span class="text-sm text-yellow-600">Pending Grade</span>
                                                @endif
                                                <a href="{{ route('submissions.show', $submission) }}" 
                                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                    View
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">No submissions yet.</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
