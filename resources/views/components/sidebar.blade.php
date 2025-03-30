<div id="sidebar"
     class="fixed left-0 top-0 h-screen transition-transform duration-300 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700"
     :class="{ 'w-64': !sidebarCollapsed, 'w-16': sidebarCollapsed, '-translate-x-full': sidebarCollapsed }">

    <!-- Logo/Brand -->
    <div class="flex items-center justify-center py-4"
         :class="{'px-2': sidebarCollapsed}">
        <img src="{{ asset('images/logo.png') }}"
             alt="Logo"
             class="transition-all duration-300"
             :class="{'h-12 w-auto': !sidebarCollapsed, 'h-8 w-8': sidebarCollapsed}">
    </div>

    <!-- Navigation Links -->
    <nav class="space-y-2 p-4">
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-3 py-2 text-sm rounded-lg transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span x-show="!sidebarCollapsed">Dashboard</span>
        </a>

        <a href="{{ route('voter.voting') }}"
           class="flex items-center gap-3 px-3 py-2 text-sm rounded-lg transition-colors duration-200 {{ request()->routeIs('voter.voting*') ? 'bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <span x-show="!sidebarCollapsed">Vote Now</span>
        </a>

        <!-- Modal toggle -->
        <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class="flex items-center gap-3 px-3 py-2 text-sm rounded-lg transition-colors duration-200 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 w-full" type="button">
            <svg class="h-5 w-5" viewBox="-2.4 -2.4 28.80 28.80" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" stroke="currentColor"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="1.44"></g><g id="SVGRepo_iconCarrier"> <path d="M16 1C17.6569 1 19 2.34315 19 4C19 4.55228 18.5523 5 18 5C17.4477 5 17 4.55228 17 4C17 3.44772 16.5523 3 16 3H4C3.44772 3 3 3.44772 3 4V20C3 20.5523 3.44772 21 4 21H16C16.5523 21 17 20.5523 17 20V19C17 18.4477 17.4477 18 18 18C18.5523 18 19 18.4477 19 19V20C19 21.6569 17.6569 23 16 23H4C2.34315 23 1 21.6569 1 20V4C1 2.34315 2.34315 1 4 1H16Z" fill="currentColor"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M20.7991 8.20087C20.4993 7.90104 20.0132 7.90104 19.7133 8.20087L11.9166 15.9977C11.7692 16.145 11.6715 16.3348 11.6373 16.5404L11.4728 17.5272L12.4596 17.3627C12.6652 17.3285 12.855 17.2308 13.0023 17.0835L20.7991 9.28666C21.099 8.98682 21.099 8.5007 20.7991 8.20087ZM18.2991 6.78666C19.38 5.70578 21.1325 5.70577 22.2134 6.78665C23.2942 7.86754 23.2942 9.61999 22.2134 10.7009L14.4166 18.4977C13.9744 18.9398 13.4052 19.2327 12.7884 19.3355L11.8016 19.5C10.448 19.7256 9.2744 18.5521 9.50001 17.1984L9.66448 16.2116C9.76728 15.5948 10.0602 15.0256 10.5023 14.5834L18.2991 6.78666Z" fill="currentColor"></path> <path d="M5 7C5 6.44772 5.44772 6 6 6H14C14.5523 6 15 6.44772 15 7C15 7.55228 14.5523 8 14 8H6C5.44772 8 5 7.55228 5 7Z" fill="currentColor"></path> <path d="M5 11C5 10.4477 5.44772 10 6 10H10C10.5523 10 11 10.4477 11 11C11 11.5523 10.5523 12 10 12H6C5.44772 12 5 11.5523 5 11Z" fill="currentColor"></path> <path d="M5 15C5 14.4477 5.44772 14 6 14H7C7.55228 14 8 14.4477 8 15C8 15.5523 7.55228 16 7 16H6C5.44772 16 5 15.5523 5 15Z" fill="currentColor"></path> </g></svg>
        <span x-show="!sidebarCollapsed">Share Your Feedback</span>
        </button>

        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2 text-sm rounded-lg transition-colors duration-200 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span x-show="!sidebarCollapsed">Logout</span>
            </button>
        </form>
    </nav>
</div>

<!-- modal for feedback-->
<div id="authentication-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Share us your Feedback and Reviews!
                </h3>
                <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <form class="space-y-4" action="#">

                    <!-- ratings -->
                    <div class="flex w-full justify-center items-center">
                        <input type="hidden" name="rating" id="ratingInput" value="0">

                        <div class="flex gap-x-2">
                            <!-- Star Buttons -->
                            <button type="button" class="star w-10 h-10 text-gray-300 transition-colors duration-200 hover:text-yellow-400 focus:text-yellow-400 focus:outline-none" data-value="1" aria-label="Rate 1 star">
                                <svg class="w-10 h-10 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.673 1.533 8.021-7.469-3.969-7.469 3.969 1.533-8.021-6.064-5.673 8.332-1.151z"/>
                                </svg>
                            </button>
                            <button type="button" class="star w-10 h-10 text-gray-300 transition-colors duration-200 hover:text-yellow-400 focus:text-yellow-400 focus:outline-none" data-value="2" aria-label="Rate 2 stars">
                                <svg class="w-10 h-10 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.673 1.533 8.021-7.469-3.969-7.469 3.969 1.533-8.021-6.064-5.673 8.332-1.151z"/>
                                </svg>
                            </button>
                            <button type="button" class="star w-10 h-10 text-gray-300 transition-colors duration-200 hover:text-yellow-400 focus:text-yellow-400 focus:outline-none" data-value="3" aria-label="Rate 3 stars">
                                <svg class="w-10 h-10 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.673 1.533 8.021-7.469-3.969-7.469 3.969 1.533-8.021-6.064-5.673 8.332-1.151z"/>
                                </svg>
                            </button>
                            <button type="button" class="star w-10 h-10 text-gray-300 transition-colors duration-200 hover:text-yellow-400 focus:text-yellow-400 focus:outline-none" data-value="4" aria-label="Rate 4 stars">
                                <svg class="w-10 h-10 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.673 1.533 8.021-7.469-3.969-7.469 3.969 1.533-8.021-6.064-5.673 8.332-1.151z"/>
                                </svg>
                            </button>
                            <button type="button" class="star w-10 h-10 text-gray-300 transition-colors duration-200 hover:text-yellow-400 focus:text-yellow-400 focus:outline-none" data-value="5" aria-label="Rate 5 stars">
                            <svg class="w-10 h-10 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.673 1.533 8.021-7.469-3.969-7.469 3.969 1.533-8.021-6.064-5.673 8.332-1.151z"/>
                                </svg>
                            </button>
                        </div>
                    </div>


                    <!-- feedback messages here -->
                    <div>
                        <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your message</label>
                        <textarea id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>
                    </div>


                    <!-- buttons -->
                    <div class="flex justify-end space-x-2">
                        <button type="submit" class="w-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>

                        <button type="submit" class="w-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Later</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const stars = document.querySelectorAll(".star");
        const ratingInput = document.getElementById("ratingInput");

        stars.forEach(star => {
            star.addEventListener("click", function () {
                let rating = this.getAttribute("data-value");
                ratingInput.value = rating;

                // Reset all stars to default gray
                stars.forEach(s => s.classList.remove("text-yellow-300"));
                stars.forEach(s => s.classList.add("text-gray-300"));

                // Highlight selected stars
                for (let i = 0; i < rating; i++) {
                    stars[i].classList.remove("text-gray-300");
                    stars[i].classList.add("text-yellow-300");
                }
            });
        });
    });
</script>
