<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Vote Confirmation') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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

<!-- thank you modal -->
<div id="small-modal" tabindex="-1" class="fixed inset-0 z-50 flex justify-center items-center w-full p-4 overflow-x-hidden overflow-y-auto bg-black bg-opacity-50">
    <div class="relative w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                    Thank you for Voting!
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="small-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                Democracy thrives when people like you take action! Thank you for making your vote count. Small decisions lead to big changes, and your participation today is a step toward a better tomorrow. Keep standing up for what you believe in!
                </p>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button data-modal-hide="small-modal" data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Oki!</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    // Select all elements that can hide the modal
    const closeButtons = document.querySelectorAll("[data-modal-hide='small-modal']");
    const modal = document.getElementById("small-modal");

    closeButtons.forEach(button => {
        button.addEventListener("click", function () {
                if (modal) {
                    modal.style.display = "none"; // Hide the modal
                }
            });
        });
    });
</script>
