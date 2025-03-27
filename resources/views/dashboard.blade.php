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
                    @if(!$castedVotes->count())
                        <a href="{{ route('voter.voting') }}"  
                            class="flex items-center p-4 text-gray-700 bg-gray-100 rounded-lg hover:bg-[#240A34] hover:text-white transition-colors duration-200">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                            Start Voting
                        </a>
                    @else
                        <button onclick="toggleVotingDetails()" 
                            class="flex items-center p-4 text-gray-700 bg-gray-100 rounded-lg hover:bg-[#240A34] hover:text-white transition-colors duration-200">
                            <i class="fas fa-list-alt mr-2"></i>
                            View Voting Details
                        </button>
                    @endif
                </div>
            </div>

            <!-- Voting Details Modal -->
            @if($castedVotes->count())
            <div id="votingDetailsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full" style="z-index: 100;">
                <div class="relative top-20 mx-auto p-6 border w-full max-w-2xl shadow-lg rounded-md bg-white dark:bg-gray-800">
                    <div class="mb-4">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Your Voting Details</h3>
                            <button onclick="toggleVotingDetails()" class="text-gray-500 hover:text-gray-700">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Transaction Number: <span class="font-mono font-bold">{{ $transactionNumber }}</span>
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Voted on: {{ $votedAt ? $votedAt->format('F j, Y g:i A') : 'N/A' }}
                        </p>
                    </div>
                    
                    <div class="space-y-4 mt-4">
                        @foreach($castedVotes as $vote)
                            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $vote->candidate->photo_url }}" 
                                            class="w-16 h-16 rounded-lg object-cover"
                                            alt="{{ $vote->candidate->first_name }}">
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $vote->position->name }}
                                        </p>
                                        <p class="text-base font-semibold text-gray-800 dark:text-gray-200">
                                            {{ $vote->candidate->last_name }}, {{ $vote->candidate->first_name }}
                                        </p>
                                        @if($vote->candidate->partylist)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                                {{ $vote->candidate->partylist->name }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Add this new div for buttons -->
                    <div class="flex justify-end space-x-4 mt-6">
                        <button onclick="toggleVotingDetails()" 
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-colors duration-200">
                            <i class="fas fa-times mr-2"></i>
                            Close
                        </button>
                        <!-- <a href="{{ route('dashboard') }}" 
                            class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 transition-colors duration-200">
                            <i class="fas fa-home mr-2"></i>
                            Back to Dashboard
                        </a> -->
                    </div>
                </div>
            </div>

            <script>
                function toggleVotingDetails() {
                    const modal = document.getElementById('votingDetailsModal');
                    modal.classList.toggle('hidden');
                }
            </script>
            @endif
        </div>
    </div>
</x-app-layout>

