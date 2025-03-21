<x-layouts.voter>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Vote Confirmation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                <p class="font-bold">Thank you for voting!</p>
                <p>Your vote has been successfully recorded.</p>
            </div>

            <div class="mt-6">
                <a href="{{ route('voter.dashboard') }}" 
                   class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                    <i class="fas fa-home mr-2"></i>
                    Return to Dashboard
                </a>
            </div>
        </div>
    </div>
</x-layouts.voter>
