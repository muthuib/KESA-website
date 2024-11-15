<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel App</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <!-- Top Navigation -->
    @include('dashboard.topnav')

    <div class="content">
        <!-- Show Login Form if session variable 'showLogin' is set -->
        @if(session('showLogin'))
        <div id="loginFormContainer" style="display: block; margin-top: 20px;">
            <div class="login-container">
                <h2>Login</h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div>
                        <label for="EMAIL">Email</label>
                        <input type="email" name="EMAIL" required>
                    </div>
                    <div>
                        <label for="password">Password</label>
                        <input type="password" name="password" required>
                    </div>
                    <button type="submit">Login</button>
                </form>
            </div>
        </div>
        @endif

        <!-- Main Content Here -->
        <div class="main-content">
            <!-- Your main content goes here -->
        </div>
    </div>

</body>

</html>