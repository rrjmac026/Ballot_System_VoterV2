<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Welcome Banner -->
            <div class="p-6 mb-6 bg-gradient-to-r from-[#240A34] to-[#371355] rounded-2xl shadow-lg">
                <div class="flex flex-col items-center sm:flex-row sm:justify-between">
                    <div class="mb-4 sm:mb-0">
                        <h1 class="text-xl font-bold text-white sm:text-2xl">
                            Welcome back, {{ Auth::user()->name }}!
                        </h1>
                        <p class="mt-1 text-sm text-gray-200">
                            Here's your voting status and information
                        </p>
                    </div>
                    <img src="{{ asset('images/logo.jpg') }}" alt="BukSU Logo" 
                        class="w-16 h-16 border-2 border-[#FC9D22] rounded-full shadow-md">
                </div>
            </div>

            <!-- Status Cards Grid -->
            <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">
                <!-- Voter Status Card -->
                <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-[#FC9D22]/10">
                            <svg class="w-8 h-8 text-[#FC9D22]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h2 class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-200">Voter Status</h2>
                            <p class="text-sm font-medium 
                                {{ Auth::user()->status === 'verified' ? 'text-green-600' : 'text-yellow-600' }}">
                                {{ ucfirst(Auth::user()->status) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- College Info Card -->
                <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-[#240A34]/10">
                            <svg class="w-8 h-8 text-[#240A34]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h2 class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-200">College</h2>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-300">
                                {{ Auth::user()->college->name ?? 'Not Assigned' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Course Info Card -->
                <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-[#FC9D22]/10">
                            <svg class="w-8 h-8 text-[#FC9D22]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h2 class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-200">Course & Year</h2>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-300">
                                {{ Auth::user()->course }} - {{ Auth::user()->year_level }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <h3 class="mb-4 text-lg font-semibold text-gray-700 dark:text-gray-200">Quick Actions</h3>
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <a href="{{ route('voter.voting') }}" 
                        class="flex items-center p-4 text-gray-700 bg-gray-100 rounded-lg hover:bg-[#240A34] hover:text-white transition-colors duration-200">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                        Start Voting
                    </a>
                    <!-- Add more quick actions as needed -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

