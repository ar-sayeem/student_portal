<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-notifications />
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Assignments</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $data['totalAssignments'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Submitted</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $data['submittedAssignments'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Pending</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $data['pendingAssignments'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Average GPA</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ number_format($data['averageGPA'] ?? 0, 2) }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Content -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Assignments -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Recent Assignments</h3>
                    </div>
                    <div class="p-6">
                        @if($data['recentAssignments']->count() > 0)
                            <div class="space-y-4">
                                @foreach($data['recentAssignments'] as $assignment)
                                    <div class="border-l-4 border-blue-500 pl-4">
                                        <h4 class="font-medium text-gray-900">{{ $assignment->title }}</h4>
                                        <p class="text-sm text-gray-600">{{ $assignment->course_code }} - {{ $assignment->course_name }}</p>
                                        <p class="text-xs text-gray-500">Due: {{ $assignment->due_date->format('M d, Y') }}</p>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-4 flex space-x-4">
                                <a href="{{ route('assignments.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View all assignments →</a>
                                <a href="{{ route('submissions.index') }}" class="text-green-600 hover:text-green-800 text-sm font-medium">My submissions →</a>
                            </div>
                        @else
                            <p class="text-gray-500">No assignments available.</p>
                        @endif
                    </div>
                </div>

                <!-- Recent Results -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Recent Results</h3>
                    </div>
                    <div class="p-6">
                        @if($data['recentResults']->count() > 0)
                            <div class="space-y-4">
                                @foreach($data['recentResults'] as $result)
                                    <div class="border-l-4 border-green-500 pl-4">
                                        <h4 class="font-medium text-gray-900">{{ $result->course_name }}</h4>
                                        <p class="text-sm text-gray-600">{{ $result->exam_type }} - Grade: {{ $result->grade }}</p>
                                        <p class="text-xs text-gray-500">{{ $result->marks_obtained }}/{{ $result->total_marks }} ({{ number_format($result->getPercentage(), 1) }}%)</p>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('results.my') }}" class="text-green-600 hover:text-green-800 text-sm font-medium">View all results →</a>
                            </div>
                        @else
                            <p class="text-gray-500 mb-4">No results available.</p>
                            <a href="{{ route('results.my') }}" class="text-green-600 hover:text-green-800 text-sm font-medium">Check results →</a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="{{ route('profile.edit') }}" 
                           class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-150">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-900">Edit Profile</h4>
                                <p class="text-xs text-gray-500">Update your information</p>
                            </div>
                        </a>

                        <a href="{{ route('submissions.index') }}" 
                           class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-150">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-900">My Submissions</h4>
                                <p class="text-xs text-gray-500">View submitted assignments</p>
                            </div>
                        </a>

                        <a href="{{ route('results.my') }}" 
                           class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-150">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-900">My Results</h4>
                                <p class="text-xs text-gray-500">Check published results</p>
                            </div>
                        </a>

                        <a href="{{ route('messages.contact') }}" 
                           class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-150">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-900">Contact Admin</h4>
                                <p class="text-xs text-gray-500">Send message to admin</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
