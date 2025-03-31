<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>System Maintenance - BukSU COMELEC</title>
    <link rel="icon" href="{{ asset('images/tab_Icon.png') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-[#240A34] via-[#371355] to-[#240A34] min-h-screen">
    <!-- Logout Button -->
    @auth
        <div class="absolute top-4 right-4 z-50">
            <form method="POST" action="{{ route('logout') }}" class="inline-block">
                @csrf
                <button type="submit"
                    class="group px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-lg backdrop-blur-sm
                        transition-all duration-200 flex items-center space-x-2 border border-white/10">
                    <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    @endauth

    <div class="flex flex-col items-center justify-center min-h-screen p-4 text-center">
        <!-- Logo Section -->
        <div class="mb-8 flex items-center justify-center space-x-4">
            <img src="{{ asset('images/logo.jpg') }}" alt="BukSU Logo"
                class="w-16 h-16 sm:w-20 sm:h-20 rounded-full border-2 border-[#FC9D22] shadow-lg animate-pulse">
            <h1 class="text-2xl sm:text-3xl font-bold text-white">
                Buk<span class="text-[#FC9D22]">SU</span> COMELEC
            </h1>
        </div>

        <!-- Main Content -->
        <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 sm:p-8 max-w-2xl mx-auto shadow-xl">
            <div class="flex flex-col items-center space-y-6">
                <!-- Maintenance Icon -->
                <div class="rounded-full bg-[#FC9D22]/20 p-4">
                    <svg class="w-12 h-12 sm:w-16 sm:h-16 text-[#FC9D22]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>

                <!-- Message -->
                <div class="space-y-4">
                    <h2 class="text-xl sm:text-2xl font-bold text-white">
                        System Under Maintenance
                    </h2>
                    <p class="text-gray-300 text-sm sm:text-base">
                    {{ $message }}
                    </p>
                </div>

                <!-- Status -->
                <div class="flex items-center space-x-2 text-[#FC9D22]">
                    <div class="animate-spin rounded-full h-4 w-4 border-2 border-[#FC9D22] border-t-transparent"></div>
                    <span class="text-sm">Maintenance in progress...</span>
                </div>

                <!-- Expected Time -->
                <!-- <div class="text-gray-300 text-sm border-t border-white/10 pt-6">
                    <p>Expected completion time:</p>
                    <p class="font-semibold text-white">{{ now()->addHours(2)->format('F j, Y - h:i A') }}</p>
                </div> -->

                <!-- Contact Info -->
                <div class="bg-white/5 rounded-lg p-4 w-full mt-6">
                    <p class="text-gray-300 text-sm">
                        If you need immediate assistance, please contact:
                    </p>
                    <a href="mailto:buksucomelec@buksu.edu.ph"
                        class="text-[#FC9D22] hover:text-[#FC9D22]/80 transition-colors duration-200 text-sm mt-1 inline-block">
                        buksucomelec@buksu.edu.ph
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-gray-400 text-xs">
            © {{ date('Y') }} BukSU COMELEC. All rights reserved.
        </div>
    </div>
</body>
</html>
