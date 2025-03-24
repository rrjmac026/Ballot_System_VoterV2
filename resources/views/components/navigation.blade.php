<div x-data="{ isOpen: false, darkMode: localStorage.getItem('theme') === 'dark', open: false }">
    <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 z-30 fixed top-0 left-0 right-0 h-16">
        <div class="px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
            <div class="flex items-center gap-4">
                <!-- Mobile Sidebar Toggle -->
                <button @click="sidebarCollapsed = !sidebarCollapsed" 
                        class="text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-white transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                         class="h-6 w-6 transform transition-transform duration-200"
                         :class="{'rotate-180': !sidebarCollapsed}"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                
                <!-- Logo -->
                <img src="{{ asset('images/tab_icon.png') }}" class="h-8 mr-3" alt="BukSU Logo" />
                <span class="self-center text-xl font-bold sm:text-2xl whitespace-nowrap dark:text-white">
                    Buk<span class="text-[#FC9D22]">SU</span> Comelec
                </span>
            </div>

            <!-- Profile Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <!-- Profile Button -->
                <button @click="open = !open" class="flex items-center space-x-3 text-gray-600 hover:text-gray-700 focus:outline-none">
                    <div class="flex items-center space-x-1">
                        <span class="text-sm">{{ Auth::user()->name }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </button>

                <!-- Simplified Dropdown Menu -->
                <div x-show="open" 
                     @click.away="open = false"
                     class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 z-50">
                    
                    <!-- Dark Mode Toggle -->
                    <button @click="darkMode = !darkMode;
                            $dispatch('dark-mode-changed', { darkMode });
                            document.documentElement.classList.toggle('dark')"
                        class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg x-show="!darkMode" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <svg x-show="darkMode" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707" />
                        </svg>
                        <span x-text="darkMode ? 'Light Mode' : 'Dark Mode'"></span>
                    </button>

                    <!-- Divider -->
                    <div class="border-t border-gray-100 my-1"></div>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="flex w-full items-center px-4 py-2 text-sm text-red-700 hover:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
</div>
