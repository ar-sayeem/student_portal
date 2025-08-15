<x-app-layout>
    <x-slot name="title">Submit Assignment</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Submit Assignment: {{ $assignment->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Assignment Info -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-md">
                        <h3 class="font-medium text-gray-900 mb-2">{{ $assignment->title }}</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $assignment->course_code }} - {{ $assignment->course_name }}</p>
                        <p class="text-sm text-gray-600">
                            <strong>Due:</strong> {{ $assignment->due_date->format('M d, Y H:i') }}
                            <strong class="ml-4">Max Marks:</strong> {{ $assignment->max_marks }}
                        </p>
                    </div>

                    <form method="POST" action="{{ route('submissions.store', $assignment) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Submission Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Submission Title *</label>
                            <input type="text" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $assignment->title . ' - ' . auth()->user()->name) }}"
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
                                      placeholder="Write your answer or solution here (optional if uploading file)...">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- File Upload -->
                        <div>
                            <label for="file" class="block text-sm font-medium text-gray-700 mb-2">Upload File *</label>
                            <input type="file" 
                                   id="file" 
                                   name="file" 
                                   accept=".pdf,.doc,.docx,.txt,.zip,.rar"
                                   required
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <p class="mt-1 text-sm text-gray-500">Upload PDF, DOC, DOCX, TXT, ZIP, or RAR files (max 20MB)</p>
                            @error('file')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-between pt-4">
                            <a href="{{ route('assignments.show', $assignment) }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md">
                                Cancel
                            </a>
                            <button type="submit" 
                                    id="submit-btn"
                                    class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-md disabled:opacity-50 disabled:cursor-not-allowed">
                                <span id="submit-text">Submit Assignment</span>
                                <span id="submit-loading" class="hidden">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Submitting...
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
