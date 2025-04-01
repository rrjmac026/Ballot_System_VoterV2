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
<div id="small-modal" tabindex="-1" class="fixed inset-0 z-50 flex justify-end items-center w-full p-4 overflow-x-hidden overflow-y-auto bg-[#1f2525]/50 backdrop-blur-sm">
    <div class="relative w-full max-w-xl mr-4 animate-slide-left mr-[350px]">
        <!-- Modal content -->
        <div class="relative bg-[#ede9e4] rounded-xl shadow-2xl dark:bg-[#380041] transform transition-all">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-6 border-b border-[#1f2525]/10 dark:border-[#ede9e4]/10">
                <div class="flex items-center space-x-3">
                    <div class="bg-[#f9b40f] rounded-full p-2">
                        <i class="fas fa-check-circle text-[#ede9e4] text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-[#380041] dark:text-[#ede9e4]">
                        Thank you for Voting!
                    </h3>
                </div>
                <button type="button" 
                        class="text-[#380041]/60 dark:text-[#ede9e4]/60 hover:text-[#f9b40f] rounded-lg p-1.5 transition-colors duration-200"
                        data-modal-hide="small-modal">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Modal body -->
            <div class="p-6 space-y-6">
                <div class="bg-[#380041]/5 dark:bg-[#ede9e4]/5 rounded-lg p-4">
                    <p class="text-lg leading-relaxed text-[#1f2525] dark:text-[#ede9e4]/90 text-center">
                        Democracy thrives when people like you take action! Thank you for making your vote count. 
                        <span class="block mt-2 font-medium text-[#380041] dark:text-[#f9b40f]">
                            Your participation today is a step toward a better tomorrow.
                        </span>
                    </p>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="flex items-center justify-end p-6 border-t border-[#1f2525]/10 dark:border-[#ede9e4]/10">
                <button data-modal-hide="small-modal"
                        data-modal-target="authentication-modal" data-modal-toggle="authentication-modal"
                        type="button" 
                        class="px-6 py-2.5 text-sm font-medium bg-[#f9b40f] text-[#ede9e4] rounded-lg hover:bg-[#380041] transform hover:scale-105 transition-all duration-200 flex items-center space-x-2">
                    <span>Continue</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes slide-left {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.animate-slide-left {
    animation: slide-left 0.3s ease-out;
}
</style>

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