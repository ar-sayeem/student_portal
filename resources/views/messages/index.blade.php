<x-app-layout>
    <x-slot name="title">My Messages</x-slot>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Messages') }}
            </h2>
            @if(auth()->user()->isStudent())
                <a href="{{ route('messages.contact') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">
                    Contact Admin
                </a>
            @else
                <a href="{{ route('messages.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">
                    New Message
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-notifications />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($messages->count() > 0)
                        <div class="space-y-4">
                            @foreach($messages as $message)
                                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-2 mb-2">
                                                <h3 class="text-lg font-medium text-gray-900">{{ $message->subject }}</h3>
                                                @if(!$message->is_read && $message->receiver_id === auth()->id())
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        Unread
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            <div class="text-sm text-gray-600 mb-2">
                                                @if($message->sender_id === auth()->id())
                                                    <span class="font-medium">To:</span> 
                                                    {{ $message->receiver ? $message->receiver->name : 'Admin' }}
                                                @else
                                                    <span class="font-medium">From:</span> 
                                                    {{ $message->sender->name }}
                                                @endif
                                                <span class="ml-4">{{ $message->created_at->format('M d, Y H:i') }}</span>
                                            </div>
                                            
                                            <p class="text-gray-700 mb-3">{{ Str::limit($message->message, 150) }}</p>
                                        </div>
                                        
                                        <div class="flex space-x-2 ml-4">
                                            <a href="{{ route('messages.show', $message) }}" 
                                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                View
                                            </a>
                                            @if(auth()->user()->isAdmin() || $message->sender_id === auth()->id())
                                                <form method="POST" action="{{ route('messages.destroy', $message) }}" 
                                                      onsubmit="return confirm('Are you sure you want to delete this message?')" 
                                                      class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $messages->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No messages yet</h3>
                            @if(auth()->user()->isStudent())
                                <p class="text-gray-500 mb-4">You haven't sent or received any messages yet.</p>
                                <a href="{{ route('messages.contact') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Contact Admin
                                </a>
                            @else
                                <p class="text-gray-500 mb-4">No messages in your inbox.</p>
                                <a href="{{ route('messages.create') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Send Message
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
