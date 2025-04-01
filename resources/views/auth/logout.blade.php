<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <script>
        function completeLogout() {
            // Clear browser storage
            localStorage.clear();
            sessionStorage.clear();
            
            // Logout from Google
            fetch('{{ $googleLogoutUrl }}', { mode: 'no-cors' })
                .finally(() => {
                    // Redirect to login page
                    window.location.href = '{{ $returnTo }}';
                });
        }

        // Prevent back button
        window.history.forward();
        window.onload = completeLogout;
    </script>
</head>
<body>
    <div style="text-align: center; margin-top: 50px;">
        Logging out...
    </div>
</body>
</html>
