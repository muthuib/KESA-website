<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partner Login</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .login-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            padding: 20px;
        }

        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .welcome-back {
            background-color:rgb(255, 0, 247);
            color: white;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .welcome-back h3 {
            margin: 0;
            font-size: 20px;
        }

        .welcome-back p {
            margin: 5px 0 0 0;
            font-size: 14px;
        }

        .login-container h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .login-container div {
            margin-bottom: 15px;
            text-align: left;
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

    <div class="login-wrapper">
        <div class="login-container">
            <!-- Welcome Back Section -->
            <div class="welcome-back">
                <h3>Welcome Back, Partner!</h3>
                <p>We’re glad to see you again. Please log in to access your dashboard and manage your account.</p>
            </div>

            <!-- Show verification email sent success message if resent -->
            @if (session('resent'))
                <div class="alert alert-success" role="alert">
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

            <h2>Partner Login</h2>

            <form method="POST" action="{{ route('partnerlogin') }}">
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
                    <label for="PASSWORD">Password</label>
                    <input type="password" name="PASSWORD" required>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Submit Button -->
                <button type="submit">Login</button>
            </form>
        </div>
    </div>

</body>

</html>
