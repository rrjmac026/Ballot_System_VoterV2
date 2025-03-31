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

        <!-- Logout Button -->
        <button type="button" 
                onclick="showLogoutModal()"
                class="w-full flex items-center gap-3 px-3 py-2 text-sm rounded-lg transition-colors duration-200 
                       text-[#380041] dark:text-[#ede9e4] hover:text-[#f9b40f] dark:hover:text-[#f9b40f]
                       hover:bg-[#380041]/10 dark:hover:bg-[#ede9e4]/10">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            <span x-show="!sidebarCollapsed">Logout</span>
        </button>

        <!-- Bible Quote Section -->
        <div class="mt-8 p-4 border-t border-gray-200 dark:border-gray-700"
             x-show="!sidebarCollapsed"
             x-data="{ 
                quote: '', 
                reference: '',
                async fetchQuote() {
                    try {
                        const response = await fetch('https://labs.bible.org/api/?passage=random&type=json');
                        const data = await response.json();
                        this.quote = data[0].text;
                        this.reference = `${data[0].bookname} ${data[0].chapter}:${data[0].verse}`;
                    } catch (error) {
                        this.quote = 'Choose some wise, understanding and respected men from each of your tribes, and I will set them over you.';
                        this.reference = 'Deuteronomy 1:13';
                    }
                },
                initQuotes() {
                    this.fetchQuote();
                    setInterval(() => this.fetchQuote(), 20000);
                }
             }"
             x-init="initQuotes()"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform -translate-x-4"
             x-transition:enter-end="opacity-100 transform translate-x-0">
            <div class="text-center">
                <i class="fas fa-book-bible text-[#f9b40f] text-xl mb-2"></i>
                <div class="animate-fade-in">
                    <blockquote class="text-xs italic text-[#380041] dark:text-[#ede9e4]" x-text="quote"></blockquote>
                    <cite class="text-xs text-[#f9b40f] mt-2 block" x-text="reference"></cite>
                </div>
                <button @click="fetchQuote()" 
                        class="mt-2 text-xs text-[#380041]/50 dark:text-[#ede9e4]/50 hover:text-[#f9b40f] transition-colors duration-200">
                    <i class="fas fa-sync-alt mr-1"></i> New Quote
                </button>
            </div>
        </div>
    </nav>
</div>

<!-- Logout Confirmation Modal -->
<div id="logoutModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-[#380041]">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-[#380041]/10 dark:bg-[#ede9e4]/10">
                <i class="fas fa-sign-out-alt text-[#380041] dark:text-[#ede9e4] text-xl"></i>
            </div>
            <h3 class="text-lg leading-6 font-medium text-[#380041] dark:text-[#ede9e4] mt-4">Logout Confirmation</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-[#380041]/70 dark:text-[#ede9e4]/70">Are you sure you want to log out?</p>
            </div>
            <div class="flex justify-center mt-4 space-x-4">
                <button onclick="closeLogoutModal()" 
                    class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-[#380041] dark:text-[#ede9e4] 
                           text-base font-medium rounded-md 
                           hover:bg-[#380041]/10 dark:hover:bg-[#ede9e4]/10 
                           hover:text-[#f9b40f] dark:hover:text-[#f9b40f]
                           focus:outline-none focus:ring-2 focus:ring-[#380041] dark:focus:ring-[#ede9e4]">
                    Cancel
                </button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                        class="px-4 py-2 bg-[#380041] dark:bg-[#ede9e4] text-[#ede9e4] dark:text-[#380041] 
                               text-base font-medium rounded-md 
                               hover:bg-[#f9b40f] dark:hover:bg-[#f9b40f]
                               hover:text-[#ede9e4] dark:hover:text-[#380041]
                               focus:outline-none focus:ring-2 focus:ring-[#f9b40f]">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function showLogoutModal() {
        document.getElementById('logoutModal').classList.remove('hidden');
    }

    function closeLogoutModal() {
        document.getElementById('logoutModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('logoutModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeLogoutModal();
        }
    });

    // Close modal on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !document.getElementById('logoutModal').classList.contains('hidden')) {
            closeLogoutModal();
        }
    });
</script>

<style>
@keyframes fadeIn {
    0% { opacity: 0; transform: translateY(-10px); }
    100% { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
    animation: fadeIn 0.5s ease-out;
}
</style>
