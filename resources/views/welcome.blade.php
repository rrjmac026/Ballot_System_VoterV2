<!DOCTYPE html>
<html lang="en" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>BukSU Comelec System</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-gradient-to-br from-[#ede9e4] to-[#f9b40f]/10 dark:from-[#380041] dark:to-[#1f2525] min-h-screen">
        <!-- Navigation -->
        @if (Route::has('login'))
            <nav class="fixed w-full z-20 top-0 start-0 bg-[#ede9e4]/90 dark:bg-[#380041]/90 border-b border-[#f9b40f]/20 backdrop-blur-sm">
                <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                    <a href="/" class="flex items-center space-x-3">
                        <img src="{{ asset('images/tab_icon.png') }}" class="h-12 border-2 border-[#f9b40f] rounded-full p-1" alt="BukSU Logo" />
                        <span class="self-center text-2xl font-bold whitespace-nowrap text-[#380041] dark:text-[#ede9e4]">
                            Buk<span class="text-[#f9b40f]">SU</span> <span class="text-[#1f2525] dark:text-[#f9b40f]">Comelec</span>
                        </span>
                    </a>
                    <div class="flex md:order-2 space-x-3">
                        @auth('voter')
                            <a href="{{ route('dashboard') }}" class="text-[#ede9e4] bg-[#f9b40f] hover:bg-[#380041] font-medium rounded-lg text-sm px-4 py-2 text-center transition-colors duration-200">Dashboard</a>
                        @else
                            <a href="{{ route('google.login') }}" class="text-[#ede9e4] bg-[#f9b40f] hover:bg-[#380041] font-medium rounded-lg text-sm px-4 py-2 text-center transition-colors duration-200">
                                <i class="fab fa-google mr-2"></i>Login with Google
                            </a>
                        @endauth
                    </div>
                </div>
            </nav>
        @endif

        <!-- Hero Section -->
        <div class="relative isolate px-6 pt-20 lg:px-8 min-h-screen flex items-center">
            <div class="mx-auto max-w-6xl py-12 sm:py-20 lg:py-24">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <!-- Text Content -->
                    <div class="bg-[#ede9e4]/50 dark:bg-[#380041]/50 p-8 rounded-2xl backdrop-blur-sm border border-[#f9b40f]/20">
                        <h1 class="text-4xl font-bold tracking-tight text-[#380041] dark:text-[#ede9e4] sm:text-6xl mb-6">
                            Your Voice Matters <span class="text-[#f9b40f]">in BukSU</span>
                        </h1>
                        <p class="text-lg leading-8 text-[#1f2525] dark:text-[#ede9e4]/90 mb-8">
                            Welcome to Bukidnon State University's Commission on Elections - where we ensure fair, transparent, and secure student elections.
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div class="bg-[#ede9e4]/80 dark:bg-[#380041]/80 p-6 rounded-xl border border-[#f9b40f]/20">
                                <div class="flex items-center mb-3">
                                    <i class="fas fa-shield-alt text-[#f9b40f] text-2xl mr-3"></i>
                                    <h3 class="font-bold text-[#380041] dark:text-[#f9b40f]">Secure Voting</h3>
                                </div>
                                <p class="text-[#1f2525] dark:text-[#ede9e4]/90">Advanced encryption and verification systems ensure your vote remains confidential and secure.</p>
                            </div>
                            <div class="bg-[#ede9e4]/80 dark:bg-[#380041]/80 p-6 rounded-xl border border-[#f9b40f]/20">
                                <div class="flex items-center mb-3">
                                    <i class="fas fa-vote-yea text-[#f9b40f] text-2xl mr-3"></i>
                                    <h3 class="font-bold text-[#380041] dark:text-[#f9b40f]">Easy Process</h3>
                                </div>
                                <p class="text-[#1f2525] dark:text-[#ede9e4]/90">Simple and intuitive voting interface designed for all BukSU students.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Image Container -->
                    <div class="relative group">
                        <div class="absolute inset-0 bg-[#f9b40f]/20 rounded-2xl blur-2xl group-hover:bg-[#f9b40f]/30 transition-all duration-300"></div>
                        <img src="{{ asset('images/tab_icon.png') }}" alt="BukSU Comelec" 
                             class="relative w-full rounded-2xl shadow-lg border-2 border-[#f9b40f]/20 group-hover:border-[#f9b40f]/40 transition-all duration-300">
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-[#ede9e4]/90 dark:bg-[#380041]/90 border-t border-[#f9b40f]/20 backdrop-blur-sm">
            <div class="max-w-screen-xl mx-auto py-6 px-4 text-center">
                <p class="text-sm text-[#1f2525] dark:text-[#ede9e4]/90">
                    © {{ date('Y') }} <span class="text-[#f9b40f]">BukSU Comelec.</span> All rights reserved.
                </p>
            </div>
        </footer>
    </body>
</html>
