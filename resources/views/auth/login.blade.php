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
            background-image: url('pictures/econ.jpg'); /* Background image */
            background-size: cover;
            background-position: center center;
            background-attachment: fixed;
        }

        /* Centering the login form */
        .login-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            padding: 20px;
        }

        /* Login Container */
        .login-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 22px;
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

        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            font-size: 14px;
            text-align: center;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .text-danger {
            color: red;
            font-size: 12px;
        }

        /* Centering logo */
        .logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
        }

        .logo-container img {
            max-width: 50%; /* Default size */
            height: auto;
        }

        /* Tablet Screens */
        @media (max-width: 768px) {
            .logo-container img {
                max-width: 40%;
            }
        }

        /* Mobile Screens */
        @media (max-width: 480px) {
            .logo-container img {
                max-width: 30%;
            }

            .login-container {
                padding: 15px;
                max-width: 90%;
            }

            .login-container h2 {
                font-size: 18px;
            }

            .login-container input,
            .login-container button {
                font-size: 14px;
                padding: 8px;
            }
        }
    </style>
</head>

<body>

    <!-- Include the top navigation -->
    @include('dashboard.topnav')

    <!-- Wrapper for the login form -->
    <div class="login-wrapper">
        <div class="login-container">
            
            <!-- Logo -->
            <div class="logo-container">
                <img src="{{ asset('pictures/logo.jpg') }}" alt="KESA Logo">
            </div>

            <h2>Member Login</h2>

            <!-- Show verification email success message if resent -->
            @if (session('resent'))
                <div class="alert alert-success">
                    A fresh verification link has been sent to your email address.
                </div>
            @endif

            <!-- Display success message if available -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Display errors if any -->
            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="EMAIL">Email</label>
                    <input type="email" name="EMAIL" value="{{ old('EMAIL') }}" required>
                    @error('EMAIL')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password">Password</label>
                    <input type="password" name="password" required>
                    @error('password')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit">Login</button>

                <!-- Forgot Password Link -->
                <p style="text-align: left; margin-top: 12px;">
                    <a href="{{ route('register') }}" style="color: #007bff;">Forgot Password?</a>
                </p>

                <!-- Link to Register -->
                <p style="text-align: left; margin-top: 12px;">
                    Don't have an account? <a href="{{ route('register') }}" style="color: #007bff;">Register</a>
                </p>
            </form>
        </div>
    </div>

</body>

</html>
