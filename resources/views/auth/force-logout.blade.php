<!DOCTYPE html>
<html>
<head>
    <title>Logging Out...</title>
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f3f4f6;
            font-family: Arial, sans-serif;
        }
        .logout-box {
            text-align: center;
            padding: 2rem;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .spinner {
            margin: 1rem auto;
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    <script>
        // Prevent back button
        history.pushState(null, null, document.URL);
        window.addEventListener('popstate', function () {
            history.pushState(null, null, document.URL);
        });

        window.onload = function() {
            // Clear all storage
            localStorage.clear();
            sessionStorage.clear();
            
            // Clear cookies
            document.cookie.split(";").forEach(function(c) { 
                document.cookie = c.replace(/^ +/, "").replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/"); 
            });

            // Redirect to Google logout after 2 seconds
            setTimeout(function() {
                window.location.href = '{{ $google_logout_url }}?continue={{ $return_url }}';
            }, 2000);
        };
    </script>
</head>
<body>
    <div class="logout-box">
        <h2>Logging out...</h2>
        <div class="spinner"></div>
        <p>Please wait while we securely log you out.</p>
    </div>
</body>
</html>
