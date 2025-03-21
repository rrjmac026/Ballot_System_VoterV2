<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center">
                <i class="fas fa-vote-yea mr-2"></i>
                {{ __('Cast Your Vote') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
                <div class="bg-red-100 dark:bg-red-800 border-l-4 border-red-500 text-red-700 dark:text-red-300 p-4 mb-4 rounded-lg shadow-sm">
                    <p class="font-bold"><i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}</p>
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-100 dark:bg-green-800 border-l-4 border-green-500 text-green-700 dark:text-green-300 p-4 mb-4 rounded-lg shadow-sm">
                    <p class="font-bold"><i class="fas fa-check-circle mr-2"></i> {{ session('success') }}</p>
                </div>
            @endif

            @if($hasVoted)
                <div class="bg-yellow-100 dark:bg-yellow-800 border-l-4 border-yellow-500 text-yellow-700 dark:text-yellow-300 p-4 mb-4 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <p class="font-bold">You have already cast your vote.</p>
                    </div>
                </div>
            @else
                <form method="POST" action="{{ route('voter.voting.store') }}" id="votingForm">
                    @csrf
                    <div class="space-y-6">
                        @foreach($positions as $position)
                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                                <div class="p-6">
                                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white flex items-center">
                                        @if($position->name === 'President')
                                            <i class="fas fa-star text-yellow-500 mr-2"></i>
                                        @elseif($position->name === 'Vice President')
                                            <i class="fas fa-award text-blue-500 mr-2"></i>
                                        @else
                                            <i class="fas fa-user-tie text-purple-500 mr-2"></i>
                                        @endif
                                        {{ $position->name }}
                                    </h3>

                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach($position->candidates as $candidate)
                                            <div class="relative">
                                                <input type="radio" 
                                                    name="votes[{{ $position->position_id }}]" 
                                                    value="{{ $candidate->candidate_id }}"
                                                    id="candidate_{{ $candidate->candidate_id }}"
                                                    class="peer hidden"
                                                    required>
                                                <label for="candidate_{{ $candidate->candidate_id }}" 
                                                    class="block p-4 bg-gray-50 dark:bg-gray-700/50 border-2 border-gray-200 dark:border-gray-600 rounded-lg cursor-pointer 
                                                        transition-all duration-200 ease-in-out
                                                        peer-checked:border-purple-500 peer-checked:bg-purple-50 dark:peer-checked:bg-purple-900/30
                                                        hover:bg-gray-100 dark:hover:bg-gray-700">
                                                    <div class="flex flex-col items-center space-y-4">
                                                        <!-- Candidate Photo -->
                                                        <div class="w-32 h-32 rounded-lg overflow-hidden border-2 border-gray-200 dark:border-gray-600">
                                                            <img src="{{ $candidate->photo_url }}" 
                                                                 alt="{{ $candidate->first_name }} {{ $candidate->last_name }}"
                                                                 class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-200"
                                                                 onerror="this.src='{{ asset('images/candidates/default-avatar.png') }}'">
                                                        </div>
                                                        <div class="text-center">
                                                            <span class="font-medium text-gray-900 dark:text-white block">
                                                                {{ $candidate->last_name }}, {{ $candidate->first_name }} {{ $candidate->middle_name }}
                                                            </span>
                                                            <div class="flex flex-col items-center gap-2 mt-2">
                                                                @if($candidate->partylist)
                                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200">
                                                                        {{ $candidate->partylist->name }}
                                                                    </span>
                                                                @endif
                                                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                                                    {{ $candidate->course }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="absolute top-2 right-2 opacity-0 peer-checked:opacity-100 text-purple-600 dark:text-purple-400 transition-opacity duration-200">
                                                        <i class="fas fa-check-circle"></i>
                                                    </div>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="flex justify-end mt-6">
                            <button type="submit" 
                                class="inline-flex items-center px-6 py-3 bg-purple-600 dark:bg-purple-500 text-white font-medium rounded-lg 
                                    hover:bg-purple-700 dark:hover:bg-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500 
                                    focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition-all duration-200 shadow-sm">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Cast Vote
                            </button>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>
