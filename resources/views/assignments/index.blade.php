<x-app-layout>
    <x-slot name="title">Assignments</x-slot>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Assignments') }}
            </h2>
            @if(auth()->user()->isAdmin() || auth()->user()->isTeacher())
                <a href="{{ route('assignments.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">
                    Create New Assignment
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-notifications />
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($assignments->count() > 0)
                        <div class="space-y-6">
                            @foreach($assignments as $assignment)
                                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                                <a href="{{ route('assignments.show', $assignment) }}" 
                                                   class="hover:text-blue-600 transition-colors">
                                                    {{ $assignment->title }}
                                                </a>
                                            </h3>
                                            <div class="text-sm text-gray-600 mb-3">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-2">
                                                    {{ $assignment->course_code }}
                                                </span>
                                                {{ $assignment->course_name }}
                                            </div>
                                            <p class="text-gray-700 mb-4">{{ Str::limit($assignment->description, 150) }}</p>
                                            
                                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                                <span>📅 Due: {{ $assignment->due_date->format('M d, Y H:i') }}</span>
                                                <span>📊 Max Marks: {{ $assignment->max_marks }}</span>
                                                @if(auth()->user()->isAdmin() || auth()->user()->isTeacher())
                                                    <span>👤 Created by: {{ $assignment->creator->name }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="ml-4 flex flex-col space-y-2">
                                            @if(!$assignment->is_active)
                                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-gray-100 text-black border border-gray-600">
                                                    ⏸️ Inactive
                                                </span>
                                            @elseif($assignment->due_date->isPast())
                                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-red-100 text-red-800 border border-red-200">
                                                    🚫 Overdue
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-green-100 text-green-900 border border-green-300">
                                                    ✅ Active
                                                </span>
                                            @endif
                                            
                                            @can('update', $assignment)
                                                <div class="flex flex-col space-y-2">
                                                    <a href="{{ route('assignments.edit', $assignment) }}" 
                                                       class="inline-flex items-center justify-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors">
                                                        ✏️ Edit
                                                    </a>
                                                    <form method="POST" action="{{ route('assignments.destroy', $assignment) }}" 
                                                          onsubmit="return confirm('⚠️ Are you sure you want to delete this assignment?\n\nThis will permanently delete:\n• The assignment and all its details\n• All student submissions\n• All related files\n\nThis action cannot be undone!')"
                                                          class="inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="w-full inline-flex items-center justify-center px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md transition-colors">
                                                            🗑️ Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <a href="{{ route('assignments.show', $assignment) }}" 
                                                   class="inline-flex items-center justify-center px-3 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-md transition-colors">
                                                    👁️ View
                                                </a>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $assignments->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-gray-500 text-lg mb-4">📚</div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No assignments found</h3>
                            <p class="text-gray-500 mb-4">
                                @if(auth()->user()->isStudent())
                                    No assignments have been posted yet. Check back later!
                                @else
                                    Get started by creating your first assignment.
                                @endif
                            </p>
                            @if(auth()->user()->isAdmin() || auth()->user()->isTeacher())
                                <a href="{{ route('assignments.create') }}" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">
                                    Create Assignment
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
