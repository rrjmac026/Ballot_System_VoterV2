<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-[#240A34]">College Positions</h2>
                        <span class="text-sm text-gray-500">Step 1 of 2</span>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('voter.voting.college.store') }}">
                        @csrf
                        @foreach($positions as $position)
                            <div class="mb-8">
                                <h3 class="text-xl font-medium text-[#240A34] mb-4">{{ $position->name }}</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach($position->candidates as $candidate)
                                        <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                            <div class="flex items-start space-x-4">
                                                <div class="flex-shrink-0">
                                                    @if($candidate->photo)
                                                        <img src="{{ asset('storage/candidates/' . $candidate->photo) }}" 
                                                             alt="{{ $candidate->first_name }} {{ $candidate->last_name }}" 
                                                             class="w-20 h-20 rounded-full object-cover">
                                                    @else
                                                        <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center">
                                                            <span class="text-gray-500">No Photo</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-1">
                                                    <div class="flex items-center justify-between">
                                                        <h4 class="text-lg font-medium text-[#240A34]">
                                                            {{ $candidate->last_name }}, {{ $candidate->first_name }}
                                                        </h4>
                                                        <input type="radio" 
                                                               name="votes[{{ $position->position_id }}]" 
                                                               value="{{ $candidate->candidate_id }}"
                                                               class="form-radio h-4 w-4 text-[#FC9D22]">
                                                    </div>
                                                    <p class="text-sm text-gray-600">
                                                        {{ $candidate->partylist->name ?? 'Independent' }}
                                                    </p>
                                                    <p class="text-sm text-gray-500 mt-2">
                                                        {{ $candidate->platform ?? 'No platform provided.' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                        <div class="mt-6 flex justify-end">
                            <button type="submit" 
                                    class="bg-[#240A34] text-white px-6 py-2 rounded-md hover:bg-[#3B1255] transition-colors">
                                Continue to Global Positions →
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
