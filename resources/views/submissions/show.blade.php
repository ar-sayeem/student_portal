<x-app-layout>
    <x-slot name="title">Submission Details</x-slot>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Submission Details') }}
            </h2>
            <a href="{{ route('submissions.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-md">
                Back to Submissions
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <x-notifications />

            <!-- Assignment Info -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <h3 class="text-lg font-medium text-blue-900 mb-2">Assignment: {{ $submission->assignment->title }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-blue-800">
                    <div><strong>Course:</strong> {{ $submission->assignment->course_code }} - {{ $submission->assignment->course_name }}</div>
                    <div><strong>Due Date:</strong> {{ $submission->assignment->due_date->format('M d, Y H:i') }}</div>
                    <div><strong>Max Marks:</strong> {{ $submission->assignment->max_marks }}</div>
                    <div><strong>Status:</strong> 
                        @if($submission->assignment->due_date < now())
                            <span class="text-red-600">Overdue</span>
                        @else
                            <span class="text-green-600">Active</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Submission Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-medium text-gray-900">
                            @if(Auth::user()->isStudent())
                                My Submission
                            @else
                                Student Submission - {{ $submission->student->name }}
                            @endif
                        </h3>
                        <div class="flex space-x-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                @if($submission->status === 'submitted') bg-yellow-100 text-yellow-800
                                @elseif($submission->status === 'graded') bg-green-100 text-green-800
                                @elseif($submission->status === 'late') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                @if($submission->status === 'submitted') Pending Review
                                @elseif($submission->status === 'graded') Graded
                                @elseif($submission->status === 'late') Late Submission
                                @else {{ ucfirst($submission->status) }} @endif
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h4 class="font-medium text-gray-900 mb-2">Submission Info</h4>
                            <div class="space-y-2 text-sm text-gray-600">
                                <div><strong>Title:</strong> {{ $submission->title }}</div>
                                @if(!Auth::user()->isStudent())
                                    <div><strong>Student:</strong> {{ $submission->student->name }}</div>
                                    <div><strong>Student ID:</strong> {{ $submission->student->student_id ?? 'N/A' }}</div>
                                @endif
                                <div><strong>Submitted At:</strong> {{ $submission->submitted_at->format('M d, Y H:i A') }}</div>
                                @if($submission->original_filename)
                                    <div><strong>File:</strong> {{ $submission->original_filename }}</div>
                                @endif
                            </div>
                        </div>

                        @if($submission->status === 'graded')
                            <div>
                                <h4 class="font-medium text-gray-900 mb-2">Grading</h4>
                                <div class="space-y-2 text-sm text-gray-600">
                                    <div><strong>Marks:</strong> {{ $submission->marks ?? 'Not graded' }}/{{ $submission->assignment->max_marks }}</div>
                                    @if($submission->marks)
                                        <div><strong>Percentage:</strong> {{ number_format(($submission->marks / $submission->assignment->max_marks) * 100, 1) }}%</div>
                                    @endif
                                    <div><strong>Graded At:</strong> {{ $submission->graded_at ? $submission->graded_at->format('M d, Y H:i A') : 'Not graded' }}</div>
                                    @if($submission->grader && !Auth::user()->isStudent())
                                        <div><strong>Graded By:</strong> {{ $submission->grader->name }}</div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    @if($submission->message)
                        <div class="mb-6">
                            <h4 class="font-medium text-gray-900 mb-2">
                                @if(Auth::user()->isStudent())
                                    My Answer/Solution
                                @else
                                    Student's Answer/Solution
                                @endif
                            </h4>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-700 whitespace-pre-wrap">{{ $submission->message }}</p>
                            </div>
                        </div>
                    @endif

                    @if($submission->feedback)
                        <div class="mb-6">
                            <h4 class="font-medium text-gray-900 mb-2">Teacher's Feedback</h4>
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <p class="text-gray-700 whitespace-pre-wrap">{{ $submission->feedback }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Teacher Grading Section -->
                    @if(!Auth::user()->isStudent() && $submission->status !== 'graded')
                        <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h4 class="font-medium text-blue-900 mb-4">📝 Grade This Submission</h4>
                            <form method="POST" action="{{ route('submissions.grade', $submission) }}" class="space-y-4">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="marks" class="block text-sm font-medium text-gray-700 mb-1">
                                            Marks (out of {{ $submission->assignment->max_marks }}) *
                                        </label>
                                        <input type="number" 
                                               id="marks" 
                                               name="marks" 
                                               min="0" 
                                               max="{{ $submission->assignment->max_marks }}" 
                                               value="{{ old('marks') }}"
                                               required 
                                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        @error('marks')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="feedback" class="block text-sm font-medium text-gray-700 mb-1">Feedback (Optional)</label>
                                    <textarea id="feedback" 
                                              name="feedback" 
                                              rows="4" 
                                              class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                              placeholder="Provide feedback to the student...">{{ old('feedback') }}</textarea>
                                    @error('feedback')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-md">
                                        Submit Grade
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex space-x-4 pt-4 border-t border-gray-200">
                        @if($submission->file_path)
                            <a href="{{ route('submissions.download', $submission) }}" 
                               class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md">
                                @if(Auth::user()->isStudent())
                                    Download My File
                                @else
                                    Download Student File
                                @endif
                            </a>
                        @endif

                        @if(Auth::user()->isStudent() && $submission->status !== 'graded' && $submission->assignment->due_date > now())
                            <a href="{{ route('submissions.edit', $submission) }}" 
                               class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">
                                Edit Submission
                            </a>
                        @endif

                        @if($submission->assignment->file_path)
                            <a href="{{ route('assignments.download', $submission->assignment) }}" 
                               class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-md">
                                Download Assignment File
                            </a>
                        @endif

                        @if(!Auth::user()->isStudent() && $submission->status === 'graded')
                            <span class="bg-gray-100 text-gray-600 font-medium py-2 px-4 rounded-md">
                                ✅ Already Graded
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Assignment Description -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h4 class="font-medium text-gray-900 mb-3">Assignment Description</h4>
                    <div class="prose max-w-none">
                        <p class="text-gray-700 whitespace-pre-wrap">{{ $submission->assignment->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
