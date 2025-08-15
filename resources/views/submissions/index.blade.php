<x-app-layout>
    <x-slot name="title">
        @if(Auth::user()->isStudent())
            My Submissions
        @else
            All Submissions
        @endif
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if(Auth::user()->isStudent())
                {{ __('My Submissions') }}
            @else
                {{ __('All Submissions') }}
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-notifications />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($submissions->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assignment</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                                        @if(!Auth::user()->isStudent())
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                        @endif
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted At</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($submissions as $submission)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $submission->assignment->title }}</div>
                                                <div class="text-sm text-gray-500">Due: {{ $submission->assignment->due_date->format('M d, Y') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $submission->assignment->course_code }}</div>
                                                <div class="text-sm text-gray-500">{{ $submission->assignment->course_name }}</div>
                                            </td>
                                            @if(!Auth::user()->isStudent())
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">{{ $submission->student->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $submission->student->student_id ?? 'N/A' }}</div>
                                                </td>
                                            @endif
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $submission->submitted_at->format('M d, Y g:i A') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($submission->status === 'submitted')
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Pending Review
                                                    </span>
                                                @elseif($submission->status === 'graded')
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                        Graded
                                                    </span>
                                                @elseif($submission->status === 'late')
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                        Late Submission
                                                    </span>
                                                @else
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        {{ ucfirst($submission->status) }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @if($submission->status === 'graded' && $submission->marks !== null)
                                                    <span class="font-medium">{{ $submission->marks }}/{{ $submission->assignment->max_marks }}</span>
                                                    <span class="text-gray-500">({{ number_format(($submission->marks / $submission->assignment->max_marks) * 100, 1) }}%)</span>
                                                @else
                                                    <span class="text-gray-400">Not graded</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('submissions.show', $submission) }}" 
                                                       class="text-blue-600 hover:text-blue-900">View</a>
                                                    
                                                    @if($submission->file_path)
                                                        <a href="{{ route('submissions.download', $submission) }}" 
                                                           class="text-green-600 hover:text-green-900">Download</a>
                                                    @endif

                                                    @if(!Auth::user()->isStudent() && $submission->status !== 'graded')
                                                        <a href="{{ route('submissions.show', $submission) }}" 
                                                           class="text-orange-600 hover:text-orange-900">Grade</a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $submissions->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            @if(Auth::user()->isStudent())
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No submissions yet</h3>
                                <p class="text-gray-500 mb-4">You haven't submitted any assignments yet.</p>
                                <a href="{{ route('assignments.index') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    View Assignments
                                </a>
                            @else
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No submissions found</h3>
                                <p class="text-gray-500 mb-4">No students have submitted assignments yet.</p>
                                <a href="{{ route('assignments.index') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    View Assignments
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
