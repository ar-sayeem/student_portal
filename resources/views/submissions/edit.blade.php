<x-app-layout>
    <x-slot name="title">Edit Submission</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Submission: {{ $submission->assignment->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <x-notifications />

            <!-- Assignment Info -->
            <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-md">
                <h3 class="font-medium text-yellow-900 mb-2">⚠️ Editing Submission</h3>
                <p class="text-sm text-yellow-800">
                    You can edit your submission until the assignment due date: 
                    <strong>{{ $submission->assignment->due_date->format('M d, Y H:i') }}</strong>
                </p>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Assignment Info -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-md">
                        <h3 class="font-medium text-gray-900 mb-2">{{ $submission->assignment->title }}</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $submission->assignment->course_code }} - {{ $submission->assignment->course_name }}</p>
                        <p class="text-sm text-gray-600">
                            <strong>Due:</strong> {{ $submission->assignment->due_date->format('M d, Y H:i') }}
                            <strong class="ml-4">Max Marks:</strong> {{ $submission->assignment->max_marks }}
                        </p>
                    </div>

                    <form method="POST" action="{{ route('submissions.update', $submission) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <!-- Submission Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Submission Title *</label>
                            <input type="text" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $submission->title) }}"
                                   required 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submission Content -->
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Your Answer/Solution</label>
                            <textarea id="message" 
                                      name="message" 
                                      rows="8" 
                                      class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Write your answer or solution here...">{{ old('message', $submission->message) }}</textarea>
                            @error('message')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Current File Info -->
                        @if($submission->file_path)
                            <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                                <h4 class="font-medium text-blue-900 mb-2">Current File</h4>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-blue-800">{{ $submission->original_filename }}</span>
                                    <a href="{{ route('submissions.download', $submission) }}" 
                                       class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        Download
                                    </a>
                                </div>
                            </div>
                        @endif

                        <!-- File Upload -->
                        <div>
                            <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $submission->file_path ? 'Replace File (Optional)' : 'Upload File' }}
                            </label>
                            <input type="file" 
                                   id="file" 
                                   name="file" 
                                   accept=".pdf,.doc,.docx,.txt,.zip,.rar"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <p class="mt-1 text-sm text-gray-500">
                                {{ $submission->file_path ? 'Leave empty to keep current file. ' : '' }}
                                Upload PDF, DOC, DOCX, TXT, ZIP, or RAR files (max 20MB)
                            </p>
                            @error('file')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-between pt-4">
                            <div class="flex space-x-4">
                                <a href="{{ route('submissions.show', $submission) }}" 
                                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md">
                                    Cancel
                                </a>
                                <a href="{{ route('submissions.index') }}" 
                                   class="text-gray-600 hover:text-gray-800 font-medium py-2 px-4">
                                    Back to Submissions
                                </a>
                            </div>
                            <button type="submit" 
                                    id="submit-btn"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md disabled:opacity-50 disabled:cursor-not-allowed">
                                <span id="submit-text">Update Submission</span>
                                <span id="submit-loading" class="hidden">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Updating...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const submitBtn = document.getElementById('submit-btn');
            const submitText = document.getElementById('submit-text');
            const submitLoading = document.getElementById('submit-loading');

            form.addEventListener('submit', function() {
                submitBtn.disabled = true;
                submitText.classList.add('hidden');
                submitLoading.classList.remove('hidden');
            });
        });
    </script>
</x-app-layout>
