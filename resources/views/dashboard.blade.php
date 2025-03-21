<x-layouts.voter>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Voter Dashboard') }}
        </h2>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="flex items-center gap-4">
                <i class="fas fa-vote-yea text-purple-600 dark:text-purple-400 text-2xl"></i>
                <h3 class="text-lg font-semibold">Welcome to the BukSU Voting System</h3>
            </div>
            <p class="mt-4 text-gray-600 dark:text-gray-400">
                Your voice matters in shaping the future of our university.
            </p>
        </div>
    </div>
</x-layouts.voter>
