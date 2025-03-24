<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Vote Confirmation') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 sm:p-4" role="alert">
                <p class="font-bold text-base sm:text-lg">Thank you for voting!</p>
                <p class="text-sm sm:text-base">Your vote has been successfully recorded.</p>
            </div>

            <div class="flex justify-center mt-4 sm:mt-6">
                <img src="{{ asset('images/peaceOut.gif') }}" alt="Vote" 
                     class="w-full sm:w-2/3 md:w-1/2 lg:w-2/5 max-w-md object-contain rounded-lg shadow-lg">
            </div>

            <div class="mt-4 sm:mt-6 flex justify-center">
                <a href="{{ route('dashboard') }}" 
                   class="inline-flex items-center px-3 py-2 sm:px-4 sm:py-2 text-sm sm:text-base bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition duration-150">
                    <i class="fas fa-home mr-2"></i>
                    Return to Dashboard
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
