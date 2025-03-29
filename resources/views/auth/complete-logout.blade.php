<!DOCTYPE html>
<html>
<head>
    <title>Logging Out</title>
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <style>
        body { font-family: Arial; text-align: center; padding-top: 50px; }
        .loader { width: 50px; height: 50px; border: 5px solid #f3f3f3; 
                 border-top: 5px solid #3498db; border-radius: 50%; 
                 animation: spin 1s linear infinite; margin: 20px auto; }
        @keyframes spin { 0% { transform: rotate(0deg); } 
                         100% { transform: rotate(360deg); } }
    </style>
    <script>
        function preventBack() { 
            window.history.forward(); 
        }
        
        window.onload = function() {
            setTimeout(function() {
                preventBack();
                window.onunload = function() {};
                
                // Clear everything
                localStorage.clear();
                sessionStorage.clear();
                
                // Clear all cookies
                document.cookie.split(';').forEach(function(c) {
                    document.cookie = c.trim().split('=')[0] + '=;expires=' + new Date(0).toUTCString() + ';path=/';
                });
                
                // Force Google logout then redirect to login
                window.location.href = 'https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=' + 
                    encodeURIComponent('{{ url("/login") }}');
            }, 1000);
        }
        
        // Aggressive back button prevention
        window.onpageshow = function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        };
        
        history.pushState(null, null, document.URL);
        window.addEventListener('popstate', function () {
            history.pushState(null, null, document.URL);
        });
    </script>
</head>
<body>
    <h2>Logging you out securely...</h2>
    <div class="loader"></div>
    <p>Please do not close this window</p>
</body>
</html>
