<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        /* Flexbox to center the login form */
        .login-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        /* Login Container Style */
        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-container div {
            margin-bottom: 15px;
        }

        .login-container label {
            display: block;
            margin-bottom: 5px;
        }

        .login-container input {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .login-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <!-- Include the top navigation from the dashboard folder -->
    @include('dashboard.topnav')

    <!-- Wrapper to center the login form -->
    <div class="login-wrapper">
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

</body>

</html>
