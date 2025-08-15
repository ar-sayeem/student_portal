<x-app-layout>
    <x-slot name="title">Edit Assignment</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Assignment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('assignments.update', $assignment) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Assignment Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Assignment Title *</label>
                            <input type="text" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $assignment->title) }}"
                                   required 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="e.g., Web Development Project">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Course Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="course_code" class="block text-sm font-medium text-gray-700 mb-2">Course Code *</label>
                                <input type="text" 
                                       id="course_code" 
                                       name="course_code" 
                                       value="{{ old('course_code', $assignment->course_code) }}"
                                       required 
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="e.g., CSE101">
                                @error('course_code')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="course_name" class="block text-sm font-medium text-gray-700 mb-2">Course Name *</label>
                                <input type="text" 
                                       id="course_name" 
                                       name="course_name" 
                                       value="{{ old('course_name', $assignment->course_name) }}"
                                       required 
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="e.g., Introduction to Programming">
                                @error('course_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Assignment Description *</label>
                            <textarea id="description" 
                                      name="description" 
                                      required 
                                      rows="4" 
                                      class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Describe the assignment requirements, objectives, and instructions...">{{ old('description', $assignment->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Due Date and Marks -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">Due Date *</label>
                                <input type="datetime-local" 
                                       id="due_date" 
                                       name="due_date" 
                                       value="{{ old('due_date', $assignment->due_date ? $assignment->due_date->format('Y-m-d\TH:i') : '') }}"
                                       required 
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('due_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="max_marks" class="block text-sm font-medium text-gray-700 mb-2">Maximum Marks *</label>
                                <input type="number" 
                                       id="max_marks" 
                                       name="max_marks" 
                                       value="{{ old('max_marks', $assignment->max_marks) }}"
                                       required 
                                       min="1" 
                                       max="200"
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('max_marks')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Assignment Status -->
                        <div>
                            <label for="is_active" class="block text-sm font-medium text-gray-700 mb-2">Assignment Status</label>
                            <select id="is_active" 
                                    name="is_active" 
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="1" {{ old('is_active', $assignment->is_active) ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ !old('is_active', $assignment->is_active) ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('is_active')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Current File Display -->
                        @if($assignment->file_path)
                            <div class="bg-gray-50 p-4 rounded-md">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Current File:</h4>
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-sm text-gray-700">{{ $assignment->original_filename ?: 'Assignment File' }}</span>
                                    <a href="{{ route('assignments.download', $assignment) }}" 
                                       class="text-blue-600 hover:text-blue-800 text-sm">Download</a>
                                </div>
                            </div>
                        @endif

                        <!-- File Upload -->
                        <div>
                            <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $assignment->file_path ? 'Replace Assignment File (Optional)' : 'Assignment File (Optional)' }}
                            </label>
                            <input type="file" 
                                   id="file" 
                                   name="file" 
                                   accept=".pdf,.doc,.docx"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <p class="mt-1 text-sm text-gray-500">Upload PDF, DOC, or DOCX files (max 10MB)</p>
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
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md">
                                Update Assignment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
