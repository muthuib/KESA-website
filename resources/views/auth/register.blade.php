<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Link to your CSS file -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
    /* Reset and base styles */
    body,
    html {
        height: 100%;
        margin: 0;
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        /* Light gray background */
    }

    /* Flexbox to center the register form vertically and horizontally */
    .register-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    /* Styles for the registration form container */
    .register-container {
        background-color: #fff;
        /* White background for the form */
        padding: 20px;
        border-radius: 8px;
        /* Rounded corners */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* Subtle shadow for a raised effect */
        width: 100%;
        max-width: 400px;
        /* Limit form width on larger screens */
    }

    /* Center align the heading */
    .register-container h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    /* Add space between input groups */
    .register-container div {
        margin-bottom: 15px;
    }

    /* Style for labels above inputs */
    .register-container label {
        display: block;
        margin-bottom: 5px;
    }

    /* Style for input fields */
    .register-container input {
        width: 100%;
        /* Full width input fields */
        padding: 10px;
        margin: 5px 0;
        border: 1px solid #ccc;
        /* Light gray border */
        border-radius: 4px;
        /* Rounded corners */
        box-sizing: border-box;
        /* Include padding and border in width */
    }

    /* Style for the submit button */
    .register-container button {
        width: 100%;
        /* Full width button */
        padding: 10px;
        background-color: #28a745;
        /* Green background */
        color: white;
        /* White text */
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
    }

    /* Hover effect for the submit button */
    .register-container button:hover {
        background-color: #218838;
        /* Darker green on hover */
    }

    /* Style for error message */
    .error {
        color: red;
        /* Red text color for error messages */
        font-size: 14px;
        /* Adjust font size as needed */
        margin-top: 5px;
        /* Space between the input field and error message */
    }

    /* Style for success message */
    .success {
        color: #155724;
        /* Dark green text */
        background-color: #d4edda;
        /* Light green background */
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 15px;
        font-size: 14px;
        border: 1px solid #c3e6cb;
        /* Subtle green border */
    }
    </style>
</head>

<body>
    <!-- Include the top navigation bar from the dashboard folder -->
    @include('dashboard.topnav')
    <!-- Wrapper to center the registration form -->
    <div class="register-wrapper">
        <div class="register-container">
            <!-- Display success message if exists -->
            @if (session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
            @endif
            <!-- Form title -->
            <h2>Register</h2>
            <!-- Registration form -->
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <!-- Username Field -->
                <div>
                    <label for="USERNAME">Username</label>
                    <input type="text" id="USERNAME" name="USERNAME" value="{{ old('USERNAME') }}">
                    <!-- Display error message for username -->
                    @error('USERNAME')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Email Field -->
                <div>
                    <label for="EMAIL">Email</label>
                    <input type="email" id="EMAIL" name="EMAIL" value="{{ old('EMAIL') }}">
                    <!-- Display error message for email -->
                    @error('EMAIL')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Password Field -->
                <div>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password">
                    <!-- Display error message for password -->
                    @error('password')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Password Confirmation Field -->
                <div>
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation">
                </div>
                <!-- Submit Button -->
                <button type="submit">Register</button>
            </form>
        </div>
    </div>
</body>

</html>