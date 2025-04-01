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
    <script>
            // Configure Toastr
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            // Wait for document ready
            $(document).ready(function() {
                @if(Session::has('success'))
                    toastr.success("{{ Session::get('success') }}");
                @endif

                @if(Session::has('error'))
                    toastr.error("{{ Session::get('error') }}");
                @endif

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        toastr.error("{{ $error }}");
                    @endforeach
                @endif
            });
        </script>
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- How to Vote Guide Modal -->
            <div id="howToVoteModal" class="fixed inset-0 bg-[#1f2525]/50 backdrop-blur-sm z-50 overflow-y-auto hidden"> <!-- Added hidden class here -->
                <div class="relative top-10 mx-auto p-6 border w-full max-w-2xl shadow-lg rounded-2xl bg-[#ede9e4] dark:bg-[#380041]">
                    <!-- Add absolute positioned close button -->
                    <button onclick="closeGuideModal()" 
                            class="absolute top-3 right-3 text-[#1f2525] dark:text-[#ede9e4] hover:text-[#f9b40f] transition-colors duration-200">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                    
                    <div class="mt-3">
                        <div class="flex items-center justify-between">
                            <h3 class="text-2xl font-bold text-[#380041] dark:text-[#ede9e4]">
                                <i class="fas fa-info-circle text-[#f9b40f] mr-2"></i>
                                How to Vote
                            </h3>
                            <button onclick="closeGuideModal()" class="text-[#1f2525] dark:text-[#ede9e4] hover:text-[#f9b40f]">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                        
                        <div class="mt-6 space-y-6">
                            <div class="space-y-4">
                                <div class="flex items-start space-x-4">
                                    <div class="w-8 h-8 rounded-full bg-[#f9b40f] text-[#ede9e4] flex items-center justify-center flex-shrink-0">1</div>
                                    <div>
                                        <h4 class="text-lg font-semibold text-[#380041] dark:text-[#f9b40f]">Select Your Candidates</h4>
                                        <p class="text-[#1f2525] dark:text-[#ede9e4]/90">Click on the candidate card to select your choice for each position. You can only select one candidate per position.</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start space-x-4">
                                    <div class="w-8 h-8 rounded-full bg-[#f9b40f] text-[#ede9e4] flex items-center justify-center flex-shrink-0">2</div>
                                    <div>
                                        <h4 class="text-lg font-semibold text-[#380041] dark:text-[#f9b40f]">Review Your Choices</h4>
                                        <p class="text-[#1f2525] dark:text-[#ede9e4]/90">Double-check your selections before submitting. Use the 'Reselect' button if you need to change your vote.</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start space-x-4">
                                    <div class="w-8 h-8 rounded-full bg-[#f9b40f] text-[#ede9e4] flex items-center justify-center flex-shrink-0">3</div>
                                    <div>
                                        <h4 class="text-lg font-semibold text-[#380041] dark:text-[#f9b40f]">Submit Your Vote</h4>
                                        <p class="text-[#1f2525] dark:text-[#ede9e4]/90">Once you're satisfied with your choices, click 'Submit' to cast your vote. Remember, you can only vote once!</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-8 p-4 bg-[#1f2525]/5 dark:bg-[#ede9e4]/5 rounded-lg">
                                <p class="text-sm text-[#380041] dark:text-[#ede9e4]">
                                    <i class="fas fa-exclamation-triangle text-[#f9b40f] mr-2"></i>
                                    Important: Your vote is confidential and cannot be changed once submitted.
                                </p>
                            </div>
                            
                            <div class="flex justify-end">
                                <button onclick="closeGuideModal()" 
                                    class="px-6 py-2 bg-[#f9b40f] text-[#ede9e4] rounded-lg hover:bg-[#380041] transition-colors duration-200">
                                    Got it!
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                                            @if($position->name === 'President')
                                                <i class="fas fa-star text-yellow-500 mr-2 text-xl"></i>
                                            @elseif($position->name === 'Vice President')
                                                <i class="fas fa-award text-blue-500 mr-2 text-xl"></i>
                                            @else
                                                <i class="fas fa-user-tie text-purple-500 mr-2 text-xl"></i>
                                            @endif
                                            {{ $position->name }}
                                        </h3>
                                        
                                        <!-- Add Reset Button -->
                                        <button type="button" 
                                                onclick="clearSelection('{{ $position->position_id }}')"
                                                class="text-sm px-3 py-1 rounded-md bg-gray-200 text-gray-700 hover:bg-purple-500 hover:text-white transition-colors duration-200 flex items-center">
                                            <i class="fas fa-redo-alt mr-1"></i> Reselect
                                        </button>
                                    </div>

                                    @if($position->name === 'Senator')
                                        <!-- Add senator count display -->
                                        <div id="senatorCount" class="text-center mb-4 p-2 bg-[#380041]/10 rounded-lg">
                                            <span class="font-bold text-[#380041] dark:text-[#ede9e4]">
                                                Selected Senators: <span id="selectedCount">0</span>/12
                                            </span>
                                        </div>
                                    @endif

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-2xl mx-auto">
                                        @foreach($position->candidates as $candidate)
                                            @if($position->name === 'Senator')
                                                <div class="relative">
                                                    <input type="checkbox" 
                                                        name="votes[{{ $position->position_id }}][]" 
                                                        value="{{ $candidate->candidate_id }}"
                                                        id="candidate_{{ $candidate->candidate_id }}"
                                                        class="peer hidden senator-checkbox"
                                                        onchange="handleSenatorSelection(this)">
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
                                            @else
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
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                                            <i class="fas fa-user-tie text-purple-500 mr-2 text-xl"></i>
                                            {{ $position->name }}
                                            <span class="ml-2 text-xs px-2 py-1 bg-gray-300 dark:bg-gray-700 rounded-full">
                                                College-Based
                                            </span>
                                        </h3>
                                        
                                        <!-- Add Reset Button -->
                                        <button type="button" 
                                                onclick="clearSelection('{{ $position->position_id }}')"
                                                class="text-sm px-3 py-1 rounded-md bg-gray-200 text-gray-700 hover:bg-purple-500 hover:text-white transition-colors duration-200 flex items-center">
                                            <i class="fas fa-redo-alt mr-1"></i> Reselect
                                        </button>
                                    </div>

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

                    // Update getSelectedCandidates function to handle arrays
                    function getSelectedCandidates() {
                        const selectedCandidates = [];
                        
                        // Handle senators separately
                        const senatorCheckboxes = document.querySelectorAll('.senator-checkbox:checked');
                        if (senatorCheckboxes.length > 0) {
                            const senatorNames = Array.from(senatorCheckboxes).map(checkbox => {
                                const label = document.querySelector(`label[for="${checkbox.id}"]`);
                                return label.querySelector('.font-medium').textContent.trim();
                            });
                            selectedCandidates.push({
                                position: 'Senator',
                                candidateName: `Selected ${senatorNames.length} senators`,
                                candidates: senatorNames
                            });
                        }

                        // Handle other positions
                        document.querySelectorAll('input[type="radio"]:checked').forEach(input => {
                            const label = document.querySelector(`label[for="${input.id}"]`);
                            const position = label.closest('.bg-white').querySelector('h3').textContent.trim();
                            const candidateName = label.querySelector('.font-medium').textContent.trim();
                            const partylist = label.querySelector('.bg-indigo-100')?.textContent.trim() || 'Independent';
                            
                            selectedCandidates.push({ position, candidateName, partylist });
                        });

                        return selectedCandidates;
                    }

                    // Update the confirmation modal display
                    async function showConfirmationModal() {
                        if (!validateSenatorSelection()) {
                            return;
                        }

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
                                    
                                    if (candidate.position === 'Senator') {
                                        candidateElement.innerHTML = `
                                            <h4 class="font-semibold text-gray-900 dark:text-white">Senators (${candidate.candidates.length})</h4>
                                            <div class="mt-2 space-y-1">
                                                ${candidate.candidates.map(name => 
                                                    `<p class="text-sm text-gray-600 dark:text-gray-300">• ${name}</p>`
                                                ).join('')}
                                            </div>
                                        `;
                                    } else {
                                        candidateElement.innerHTML = `
                                            <h4 class="font-semibold text-gray-900 dark:text-white">${candidate.position}</h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-300">${candidate.candidateName}</p>
                                            <span class="text-xs text-indigo-600 dark:text-indigo-400">${candidate.partylist}</span>
                                        `;
                                    }
                                    
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
                        // Set voted status in all storage methods
                        localStorage.setItem('hasVoted', 'true');
                        document.cookie = "has_voted=true; path=/; max-age=2592000"; // 30 days
                        
                        // Remove guide shown flag as it's no longer needed
                        localStorage.removeItem('guideShown');
                        
                        document.getElementById('votingForm').submit();
                    }

                    function clearSelection(positionId) {
                        // Prevent the default button behavior
                        event.preventDefault();
                        
                        // Find the position container
                        const positionContainer = event.target.closest('.bg-white');
                        if (!positionContainer) return;
                        
                        // Find all inputs within this position container
                        const inputs = positionContainer.querySelectorAll('input[type="radio"], input[type="checkbox"]');
                        
                        // Uncheck all inputs
                        inputs.forEach(input => {
                            input.checked = false;
                            input.disabled = false;
                            const label = input.closest('label');
                            if (label) {
                                label.classList.remove('opacity-50');
                            }
                        });

                        // Reset senator count if this is the senator position
                        if (positionContainer.querySelector('h3').textContent.includes('Senator')) {
                            const countDisplay = document.getElementById('selectedCount');
                            if (countDisplay) {
                                countDisplay.textContent = '0';
                            }
                            
                            // Re-enable all senator checkboxes
                            const senatorCheckboxes = positionContainer.querySelectorAll('.senator-checkbox');
                            senatorCheckboxes.forEach(cb => {
                                cb.disabled = false;
                                const label = cb.closest('label');
                                if (label) {
                                    label.classList.remove('opacity-50');
                                }
                            });
                        }

                        // Show feedback message
                        const message = document.createElement('div');
                        message.className = 'fixed bottom-4 right-4 bg-purple-600 text-white px-4 py-2 rounded-md shadow-lg z-50 animate-fade-in-out';
                        message.innerHTML = '<i class="fas fa-check-circle mr-2"></i>Selection cleared';
                        document.body.appendChild(message);

                        // Remove feedback message after animation
                        setTimeout(() => {
                            message.remove();
                        }, 2000);
                    }

                    function handleSenatorSelection(checkbox) {
                        const selectedSenators = document.querySelectorAll('.senator-checkbox:checked').length;
                        
                        if (selectedSenators > 12) {
                            checkbox.checked = false;
                            alert('You can only select up to 12 senators');
                            return;
                        }

                        document.getElementById('selectedCount').textContent = selectedSenators;

                        // Disable remaining checkboxes if 12 are selected
                        const senatorCheckboxes = document.querySelectorAll('.senator-checkbox:not(:checked)');
                        senatorCheckboxes.forEach(cb => {
                            cb.disabled = selectedSenators >= 12;
                            cb.closest('label').classList.toggle('opacity-50', selectedSenators >= 12);
                        });
                    }

                    function validateSenatorSelection() {
                        const selectedSenators = document.querySelectorAll('.senator-checkbox:checked').length;
                        if (selectedSenators > 12) {
                            alert('You can select a maximum of 12 senators');
                            return false;
                        }
                        return true;
                    }

                    // Update the guide modal show logic
                    document.addEventListener('DOMContentLoaded', function() {
                        // Only show guide on first visit and if not voted
                        if (!{{ $hasVoted ? 'true' : 'false' }} && !sessionStorage.getItem('hasSeenGuide')) {
                            document.getElementById('howToVoteModal').classList.remove('hidden');
                            sessionStorage.setItem('hasSeenGuide', 'true');
                        }
                    });

                    function closeGuideModal() {
                        const modal = document.getElementById('howToVoteModal');
                        modal.classList.add('animate-fade-out');
                        setTimeout(() => {
                            modal.classList.add('hidden');
                        }, 300);
                    }
                </script>

                <style>
                    @keyframes fade-in-out {
                        0% { opacity: 0; transform: translateY(20px); }
                        10% { opacity: 1; transform: translateY(0); }
                        90% { opacity: 1; transform: translateY(0); }
                        100% { opacity: 0; transform: translateY(-20px); }
                    }

                    .animate-fade-in-out {
                        animation: fade-in-out 2s ease-in-out;
                    }

                    @keyframes fade-out {
                        from { opacity: 1; }
                        to { opacity: 0; }
                    }
                    .animate-fade-out {
                        animation: fade-out 0.3s ease-out;
                    }
                </style>
            @endif
        </div>
    </div>
</x-app-layout>
