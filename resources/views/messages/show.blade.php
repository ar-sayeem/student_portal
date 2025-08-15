<x-app-layout>
    <x-slot name="title">Message Details</x-slot>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Message Details') }}
            </h2>
            <a href="{{ route('messages.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-md">
                Back to Messages
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <x-notifications />

            <!-- Main Message -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="border-b border-gray-200 pb-4 mb-4">
                        <h3 class="text-xl font-medium text-gray-900 mb-2">{{ $message->subject }}</h3>
                        <div class="text-sm text-gray-600">
                            <span class="font-medium">From:</span> {{ $message->sender->name }} ({{ $message->sender->email }})
                            <span class="ml-6 font-medium">To:</span> {{ $message->receiver ? $message->receiver->name : 'Admin' }}
                            <span class="ml-6 font-medium">Date:</span> {{ $message->created_at->format('M d, Y H:i A') }}
                        </div>
                    </div>
                    
                    <div class="prose max-w-none">
                        <p class="text-gray-700 whitespace-pre-wrap">{{ $message->message }}</p>
                    </div>
                </div>
            </div>

            <!-- Replies -->
            @if($message->replies->count() > 0)
                <div class="space-y-4 mb-6">
                    <h4 class="text-lg font-medium text-gray-900">Replies</h4>
                    @foreach($message->replies as $reply)
                        <div class="bg-gray-50 overflow-hidden shadow-sm sm:rounded-lg ml-8">
                            <div class="p-4">
                                <div class="text-sm text-gray-600 mb-2">
                                    <span class="font-medium">{{ $reply->sender->name }}</span>
                                    <span class="ml-4">{{ $reply->created_at->format('M d, Y H:i A') }}</span>
                                </div>
                                <p class="text-gray-700 whitespace-pre-wrap">{{ $reply->message }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Reply Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Reply to this message</h4>
                    
                    <form method="POST" action="{{ route('messages.reply', $message) }}">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Your Reply</label>
                            <textarea id="message" 
                                      name="message" 
                                      rows="5" 
                                      required
                                      class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Type your reply here...">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex justify-between">
                            <a href="{{ route('messages.index') }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md">
                                Send Reply
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
