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
            background-image: url('pictures/econ.jpg'); /* Add the background image URL */
            background-size: cover;
            background-position: center center;
            background-attachment: fixed;
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
            background-color: rgba(255, 255, 255, 0.8); /* Add background overlay to login form */
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
    </style>
</head>

<body>

    <!-- Include the top navigation from the dashboard folder -->
    @include('dashboard.topnav')

    <!-- Wrapper to center the login form -->
    <div class="login-wrapper">
        <div class="login-container">
            <!-- Show verification email sent success message if resent -->
            @if (session('resent'))
            <div class="alert alert-success" role="alert">
                A fresh verification link has been sent to your email address.
            </div>
            @endif

                <!-- Logo -->
        <div class="col-12 col-md-3 d-flex justify-content-start">
                <img src="{{ asset('pictures/logo.jpg') }}" alt="KESA Logo" 
                    style="width: 240px; margin-top: 0px; margin-left: 125px;" class="img-fluid">
            </div>
            <h2> Member Login</h2>

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
                <p style="text-align: left; margin-bottom: 20px; margin-top: 12px;">
                    <a href="{{ route('register') }}" style="color: #007bff;">Forgot Password?</a>
                </p>
                     <!-- Link to register -->
                <p style="text-align: left; margin-bottom: 20px; margin-top: 12px;">
                    Dont have an account? <a href="{{ route('register') }}" style="color: #007bff;">Please Register</a>
                </p>
            </form>
        </div>
    </div>

</body>

</html>
