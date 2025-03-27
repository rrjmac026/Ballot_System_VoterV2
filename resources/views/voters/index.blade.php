<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight flex items-center">
                <i class="fas fa-university mr-2 text-2xl"></i>
                {{ Auth::user()->college->name ?? 'Student Body Organization' }} SBO Candidates
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
                <div class="flex justify-center">
                    <img src="{{ asset('images/peaceOut.gif') }}" alt="Vote" class="w-1/2 mx-auto mt-6 rounded-lg shadow-lg">
                </div>
            @else
                <div class="mb-8">
                    <div class="flex items-center justify-center">
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <div id="step1-indicator" class="w-8 h-8 rounded-full bg-purple-600 text-white flex items-center justify-center font-semibold">1</div>
                                <span class="ml-2 font-medium text-gray-700 dark:text-gray-300">Global Positions</span>
                            </div>
                            <div class="w-16 h-1 bg-gray-300 dark:bg-gray-600" id="step-connector"></div>
                            <div class="flex items-center">
                                <div id="step2-indicator" class="w-8 h-8 rounded-full bg-gray-300 dark:bg-gray-600 text-gray-600 dark:text-gray-400 flex items-center justify-center font-semibold">2</div>
                                <span class="ml-2 font-medium text-gray-500 dark:text-gray-400">College Positions</span>
                            </div>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('voter.voting.store') }}" id="votingForm">
                    @csrf
                    <input type="hidden" name="transaction_number" id="transaction_number_input" value="">
                    <div id="step1" class="space-y-6">
                        @foreach($globalPositions as $position)
                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                                <div class="p-6">
                                    <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white flex items-center justify-center">
                                        @if($position->name === 'President')
                                            <i class="fas fa-star text-yellow-500 mr-2 text-xl"></i>
                                        @elseif($position->name === 'Vice President')
                                            <i class="fas fa-award text-blue-500 mr-2 text-xl"></i>
                                        @else
                                            <i class="fas fa-user-tie text-purple-500 mr-2 text-xl"></i>
                                        @endif
                                        {{ $position->name }} 
                                    </h3>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-2xl mx-auto">
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
                                                        <div class="w-32 h-40 rounded-lg overflow-hidden border-2 border-gray-200 dark:border-gray-600">
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
                            <button type="button" 
                                onclick="showStep2()"
                                class="inline-flex justify-center items-center px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                Next: College Positions
                                <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </div>

                    <div id="step2" class="space-y-6 hidden">
                        @foreach($collegePositions as $position)
                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                                <div class="p-6">
                                    <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white flex items-center justify-center">
                                        <i class="fas fa-user-tie text-purple-500 mr-2 text-xl"></i>
                                        {{ $position->name }} 
                                        <span class="ml-2 text-xs px-2 py-1 bg-gray-300 dark:bg-gray-700 rounded-full">
                                            College-Based
                                        </span>
                                    </h3>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-2xl mx-auto">
                                        @foreach($position->candidates as $candidate)
                                            @if($candidate->college_id == Auth::user()->college_id)
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
                                                            <div class="w-32 h-40 rounded-lg overflow-hidden border-2 border-gray-200 dark:border-gray-600">
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
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="flex justify-between mt-6">
                            <button type="button"
                                onclick="showStep1()"
                                class="inline-flex justify-center items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Back to Global Positions
                            </button>
                            <button type="button" 
                                onclick="showConfirmationModal()"
                                class="inline-flex justify-center items-center px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                <i class="fas fa-check-circle mr-2"></i>
                                Review and Submit
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Confirmation Modal -->
                <div id="confirmationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full" style="z-index: 100;">
                    <div class="relative top-20 mx-auto p-6 border w-full max-w-2xl shadow-lg rounded-md bg-white dark:bg-gray-800">
                        <div class="mt-3">
                            <div class="flex items-center justify-center w-14 h-14 mx-auto bg-purple-100 dark:bg-purple-900 rounded-full">
                                <i class="fas fa-ballot-check text-purple-600 dark:text-purple-400 text-2xl"></i>
                            </div>
                            <h3 class="text-xl leading-6 font-medium text-gray-900 dark:text-white text-center mt-4">
                                Confirm Your Vote
                            </h3>
                            <div class="mt-6">
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">
                                    Transaction Number: <span class="font-mono font-bold" id="transactionNumber"></span>
                                </p>
                                <div class="border rounded-lg p-6 max-h-[480px] overflow-y-auto">
                                    <div id="selectedCandidates" class="space-y-4">
                                        <!-- Selected candidates will be inserted here -->
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end space-x-4 mt-8">
                                <button onclick="closeConfirmationModal()" class="px-4 py-2 bg-gray-300 text-gray-700 text-base font-medium rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                    Back
                                </button>
                                <button onclick="submitVote()" class="px-4 py-2 bg-purple-600 text-white text-base font-medium rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                    Confirm and Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function showStep1() {
                        document.getElementById('step1').classList.remove('hidden');
                        document.getElementById('step2').classList.add('hidden');
                        document.getElementById('step1-indicator').classList.add('bg-purple-600');
                        document.getElementById('step1-indicator').classList.remove('bg-gray-300');
                        document.getElementById('step2-indicator').classList.add('bg-gray-300');
                        document.getElementById('step2-indicator').classList.remove('bg-purple-600');
                    }

                    function showStep2() {
                        document.getElementById('step1').classList.add('hidden');
                        document.getElementById('step2').classList.remove('hidden');
                        document.getElementById('step2-indicator').classList.add('bg-purple-600');
                        document.getElementById('step2-indicator').classList.remove('bg-gray-300');
                        document.getElementById('step1-indicator').classList.add('bg-gray-300');
                        document.getElementById('step1-indicator').classList.remove('bg-purple-600');
                    }

                    function getSelectedCandidates() {
                        const selectedCandidates = [];
                        const inputs = document.querySelectorAll('input[type="radio"]:checked');
                        
                        inputs.forEach(input => {
                            const label = document.querySelector(`label[for="${input.id}"]`);
                            const position = label.closest('.bg-white').querySelector('h3').textContent.trim();
                            const candidateName = label.querySelector('.font-medium').textContent.trim();
                            const partylist = label.querySelector('.bg-indigo-100')?.textContent.trim() || 'Independent';
                            
                            selectedCandidates.push({ position, candidateName, partylist });
                        });

                        return selectedCandidates;
                    }

                    async function showConfirmationModal() {
                        try {
                            // Get transaction number from server
                            const response = await fetch('{{ route("voter.generate-transaction") }}');
                            if (!response.ok) {
                                throw new Error('Failed to connect to server');
                            }

                            const data = await response.json();
                            if (!data.transaction_number) {
                                throw new Error('Invalid server response');
                            }

                            // Get selected candidates
                            const selectedCandidates = getSelectedCandidates();
                            const modal = document.getElementById('confirmationModal');
                            const candidatesContainer = document.getElementById('selectedCandidates');
                            const transactionInput = document.getElementById('transaction_number_input');

                            // Update transaction number
                            transactionInput.value = data.transaction_number;
                            document.getElementById('transactionNumber').textContent = data.transaction_number;

                            // Clear and update candidates container
                            candidatesContainer.innerHTML = '';
                            if (selectedCandidates.length === 0) {
                                candidatesContainer.innerHTML = `
                                    <div class="p-4 bg-yellow-50 dark:bg-yellow-900/30 rounded-lg">
                                        <p class="text-yellow-600 dark:text-yellow-400 text-center">
                                            <i class="fas fa-info-circle mr-2"></i>
                                            No candidates selected. Your participation will still be recorded.
                                        </p>
                                    </div>
                                `;
                            } else {
                                selectedCandidates.forEach(candidate => {
                                    const candidateElement = document.createElement('div');
                                    candidateElement.classList.add('p-3', 'bg-gray-50', 'dark:bg-gray-700', 'rounded-lg');
                                    candidateElement.innerHTML = `
                                        <h4 class="font-semibold text-gray-900 dark:text-white">${candidate.position}</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-300">${candidate.candidateName}</p>
                                        <span class="text-xs text-indigo-600 dark:text-indigo-400">${candidate.partylist}</span>
                                    `;
                                    candidatesContainer.appendChild(candidateElement);
                                });
                            }

                            // Show modal
                            modal.classList.remove('hidden');
                        } catch (error) {
                            console.error('Modal Error:', error);
                            alert('Failed to prepare confirmation. Please try again.');
                        }
                    }

                    function closeConfirmationModal() {
                        document.getElementById('confirmationModal').classList.add('hidden');
                    }

                    function submitVote() {
                        document.getElementById('votingForm').submit();
                    }
                </script>
            @endif
        </div>
    </div>
</x-app-layout>
