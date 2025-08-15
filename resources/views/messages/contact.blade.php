<x-app-layout>
    <x-slot name="title">Contact Admin</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contact Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <x-notifications />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Send a Message to Admin</h3>
                        <p class="text-sm text-gray-600">
                            Use this form to contact the administration regarding any questions, concerns, or requests you may have.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('messages.store') }}" class="space-y-6">
                        @csrf

                        <!-- Hidden field to indicate this is for admin -->
                        <input type="hidden" name="receiver_id" value="">

                        <div>
                            <x-input-label for="subject" :value="__('Subject')" />
                            <x-text-input id="subject" name="subject" type="text" class="mt-1 block w-full" 
                                          :value="old('subject')" required autofocus 
                                          placeholder="Enter the subject of your message" />
                            <x-input-error class="mt-2" :messages="$errors->get('subject')" />
                        </div>

                        <div>
                            <x-input-label for="message" :value="__('Message')" />
                            <textarea id="message" name="message" rows="6" 
                                      class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                                      required placeholder="Write your message here...">{{ old('message') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('message')" />
                            <p class="mt-1 text-sm text-gray-500">Maximum 2000 characters</p>
                        </div>

                        <div class="flex items-center space-x-4">
                            <x-primary-button>
                                {{ __('Send Message') }}
                            </x-primary-button>

                            <a href="{{ route('messages.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                View My Messages
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Contact Info -->
            <div class="mt-8 bg-blue-50 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h4 class="text-md font-medium text-blue-900 mb-4">Alternative Contact Methods</h4>
                    <div class="space-y-2 text-sm text-blue-800">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span>admin@diu.edu.bd</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span>+880-2-9138234</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>Daffodil International University, Dhaka</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
