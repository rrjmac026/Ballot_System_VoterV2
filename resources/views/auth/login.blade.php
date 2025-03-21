<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BUKSU COMELEC: Student Voting System</title>
    <link rel="icon" href="{{ asset('images/tab_Icon.png') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-image: url("{{ asset('images/background.jpg') }}");
            background-size: cover;
            background-position: center;
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .login-container img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }

        .login-container h2 {
            font-size: 22px;
            font-weight: bold;
            color: #240A34;
        }

        .login-container span {
            color: #FC9D22;
        }

        .login-container input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
        }

        .login-container button {
            background-color: #240A34;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            width: 100%;
        }

        .login-container button:hover {
            transform: scale(1.05);
        }

        .google-login {
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .google-login img {
            width: 20px;
            margin-right: 8px;
        }

        .google-login:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="flex justify-center items-center mb-4">
            <img src="{{ asset('images/logo.jpg') }}">
            <h2 class="ml-2">Buk<span>SU</span> COMELEC</h2>
        </div>

        <!-- Session Status -->
        @if(session('status'))
            <p class="text-green-500 text-sm mb-3">{{ session('status') }}</p>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <p class="text-sm text-[#002D74] mb-1 text-left">Student ID</p>
            <input type="text" name="student_number" placeholder="Enter your Student Number" 
                value="{{ old('student_number') }}" required autofocus>
            @error('student_number') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

            <p class="text-sm text-[#002D74] mt-3 mb-1 text-left">Passkey</p>
            <input type="password" name="passkey" placeholder="Enter your Passkey" required>
            @error('passkey') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

            <!-- Remember Me -->
            <div class="flex justify-start mt-3">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#240A34]" name="remember">
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>
            
            <button type="submit" class="mt-4">Login</button>
        </form>

        <!-- Google Login Button -->
        <a href="{{ route('google.login', 'voter') }}" class="google-login mt-4">
            <img src="{{ asset('images/google-logo.png') }}">
            Login with Google
        </a>
    </div>

    <!-- Show session messages -->
    @if(session('status'))
        <script>
            alert("{{ session('status') }}");
        </script>
    @endif
</body>
</html>
