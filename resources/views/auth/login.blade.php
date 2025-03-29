<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BUKSU COMELEC: Student Voting System</title>
    <link rel="icon" href="{{ asset('images/tab_Icon.png') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
        // Force clear all storage on login page
        localStorage.clear();
        sessionStorage.clear();
        document.cookie.split(';').forEach(function(c) {
            document.cookie = c.trim().split('=')[0] + '=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/;';
        });
    </script>
</head>

<body class="bg-cover bg-center w-full min-h-screen flex justify-center items-center p-4" style="background-image: url('{{ asset('images/background.jpg') }}')">
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="fixed top-5 right-5 p-4 rounded-lg shadow-lg w-[calc(100%-2rem)] sm:w-[400px] flex items-center gap-3 bg-red-100 border border-red-200 text-red-700 z-50 animate-slide-in" role="alert">
                <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z" clip-rule="evenodd" />
                </svg>
                <div class="flex-1">
                    <p class="text-xs sm:text-sm leading-relaxed">{{ $error }}</p>
                </div>
                <button type="button" class="p-1 hover:opacity-100 opacity-70 transition-opacity" onclick="this.parentElement.remove()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
        @endforeach
    @endif

    @if(session('status'))
        <div class="fixed top-5 right-5 p-4 rounded-lg shadow-lg w-[calc(100%-2rem)] sm:w-[400px] flex items-center gap-3 bg-green-100 border border-green-200 text-green-700 z-50 animate-slide-in" role="alert">
            <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
            </svg>
            <div class="flex-1">
                <p class="text-xs sm:text-sm leading-relaxed">{{ session('status') }}</p>
            </div>
            <button type="button" class="p-1 hover:opacity-100 opacity-70 transition-opacity" onclick="this.parentElement.remove()">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
    @endif

    <div class="bg-white/95 rounded-2xl shadow-lg p-4 sm:p-8 w-full sm:w-[400px] mx-4 text-center">
        <div class="flex flex-col sm:flex-row items-center justify-center mb-3 gap-2 sm:gap-0">
            <img src="{{ asset('images/logo.jpg') }}" alt="BUKSU Logo" class="w-[50px] h-[50px] sm:w-[60px] sm:h-[60px] rounded-full border-2 border-[#240A34]">
            <h2 class="text-xl sm:text-2xl font-bold text-[#240A34] sm:ml-3">Buk<span class="text-[#FC9D22]">SU</span> COMELEC</h2>
        </div>

        <p class="text-gray-600 mb-4 text-sm sm:text-base">Login using your Google account</p>

        <a href="{{ route('google.login') }}" class="flex items-center justify-center bg-white border border-gray-300 px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg cursor-pointer transition-all duration-300 hover:bg-gray-100 text-sm sm:text-base font-bold w-full">
            <img src="{{ asset('images/google-logo.png') }}" alt="Google Logo" class="w-5 sm:w-6 mr-2 sm:mr-3">
            Login with Google
        </a>
    </div>
</body>
</html>
