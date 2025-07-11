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
            background-color: #ffffff;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 600px;
            margin-top: auto;
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
        .logo-containers {
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
        }

        .logo-containers img {
            max-width: 30%; /* Default size */
            height: auto;
        }

        /* Tablet Screens */
        @media (max-width: 768px) {
            .logo-containers img {
                max-width: 20%;
            }
        }

        /* Mobile Screens */
        @media (max-width: 480px) {
            .logo-containers img {
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
        /* modern design css */
       /* Entire split layout */
.split-container {
    display: flex;
    min-height: 100vh;
}

/* Left Image Section */
.left-image {
    flex: 1;
    background: url('{{ asset('pictures/10.jpg') }}') no-repeat center center;
    background-size: cover;
}

/* Right Form Section */
.right-login {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #f4f4f4;
    padding: 40px 20px;
}


/* Hide left image on small and medium screens */
@media (max-width: 991.98px) {
    .left-image {
        display: none;
    }

    .split-container {
        flex-direction: column;
    }

    .right-login {
        flex: none;
        padding: 20px;
    }

    .login-container {
        max-width: 100%;
        margin-top: 100px;
    }
}

    </style>
     <!-- Google Fonts -->
     <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <!--  CSS -->
    <style>
        * {
            font-family: 'Poppins';
        }
    </style>
        @yield('styles')
</head>

<body>

    <!-- Include the top navigation -->
    @include('dashboard.topnav')

    <!-- Wrapper for the login form -->
<div class="split-container">
    <div class="left-image"></div>

    <div class="right-login">
        <div class="login-container">
            
            <!-- Logo -->
            <div class="logo-containers">
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
                    <a href="{{ route('password.request') }}" style="color: #007bff;">Forgot Password?</a>

                </p>

                <!-- Link to Register -->
                <p style="text-align: left; margin-top: 12px;">
                    Don't have an account? <a href="{{ route('memberships.types') }}" style="color: #007bff;">Register</a>
                </p>
            </form>
      </div>
    </div>
</div>

</body>

</html>
