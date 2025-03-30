<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      class="h-full"
      :class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Expires" content="0">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- flowbite -->
        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script>
            // Aggressive back prevention
            window.location.hash="no-back-button";
            window.location.hash="Again-No-back-button";
            window.onhashchange=function(){window.location.hash="no-back-button";}

            window.onload = function() {
                // Prevent back/forward
                window.history.pushState(null, null, window.location.href);
                window.onpopstate = function() {
                    window.history.go(1);
                };
            }

            // Force reload on back attempt
            window.onpageshow = function(event) {
                if (event.persisted) {
                    window.location.reload(true);
                }
            };

            // Disable back space key
            document.addEventListener('keydown', function(e) {
                if (e.key === "Backspace" && !e.target.matches("input, textarea")) {
                    e.preventDefault();
                }
            });
        </script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900"
             x-data="{
                sidebarCollapsed: window.innerWidth < 768,
                darkMode: localStorage.getItem('theme') === 'dark'
             }"
             @resize.window="sidebarCollapsed = window.innerWidth < 768"
             x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))">
            <!-- Navigation -->
            <x-navigation />

            <!-- Sidebar -->
            <x-sidebar />

            <!-- Main Content -->
            <div class="transition-all duration-300 mt-16"
                 :class="{'pl-64': !sidebarCollapsed, 'pl-0': sidebarCollapsed}">
                <!-- Page Content -->
                <main class="dark:bg-gray-900">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <script>
            // On page load or when changing themes, best practice for dark mode
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark')
            } else {
                document.documentElement.classList.remove('dark')
            }
        </script>
    </body>
</html>
