<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Link to your CSS file -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .register-wrapper {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding-top: 50px;
            min-height: 100%;
        }

        .register-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
        }

        .register-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            position: relative; /* Required for the asterisk positioning */
        }

        .form-group input[required]::before, 
        .form-group select[required]::before, 
        .form-group textarea[required]::before {
            content: ' *'; /* Asterisk character */
            color: red; /* Asterisk color set to red */
            font-size: 14px; /* Font size */
            font-weight: bold; /* Bold font weight */
            position: absolute; /* Position asterisk to the left */
            left: 5px; /* Position it correctly */
            top: 50%; /* Center asterisk vertically */
            transform: translateY(-50%); /* Center asterisk vertically */
        }

        .form-row {
            display: flex;
            gap: 15px;
        }

        .form-row .form-group {
            flex: 1;
        }

        button[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #218838;
        }

        .success {
            color: #155724;
            background-color: #d4edda;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            border: 1px solid #c3e6cb;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <!-- Include the top navigation bar -->
    @include('dashboard.topnav')

    <div class="register-wrapper">
        <div class="register-container">
            @if (session('success'))
                <div class="success">
                    {{ session('success') }}
                </div>
            @endif

            <h2 style="color:rgb(61, 15, 81);">KESA Member Registration</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Username -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="USERNAME">Username *</label>
                        <input type="text" id="USERNAME" name="USERNAME" value="{{ old('USERNAME') }}" required>
                        @error('USERNAME')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Email -->
                    <div class="form-group">
                        <label for="EMAIL">Email *</label>
                        <input type="email" id="EMAIL" name="EMAIL" value="{{ old('EMAIL') }}" required>
                        @error('EMAIL')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="FIRST_NAME">First Name *</label>
                        <input id="FIRST_NAME" type="text" name="FIRST_NAME" value="{{ old('FIRST_NAME') }}" required>
                        @error('FIRST_NAME')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!--  Last Name,  Category and course in a Row -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="LAST_NAME">Last Name *</label>
                        <input id="LAST_NAME" type="text" name="LAST_NAME" value="{{ old('LAST_NAME') }}" required>
                        @error('LAST_NAME')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="CATEGORY">Category *</label>
                        <select id="CATEGORY" name="CATEGORY" required>
                            <option value="">-- Select Category --</option>
                            <option value="graduate" {{ old('CATEGORY') == 'graduate' ? 'selected' : '' }}>Graduate</option>
                            <option value="ongoing student" {{ old('CATEGORY') == 'ongoing student' ? 'selected' : '' }}>Ongoing Student</option>
                        </select>
                        @error('CATEGORY')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="COURSE">Course *</label>
                        <input id="COURSE" type="text" name="COURSE" value="{{ old('COURSE') }}" required>
                        @error('COURSE')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!--  University and reason  in a Row -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="UNIVERSITY">University *</label>
                        <input id="UNIVERSITY" type="text" name="UNIVERSITY" value="{{ old('UNIVERSITY') }}" required>
                        @error('UNIVERSITY')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                    <label for="REASON">Reason *</label>
                    <textarea id="REASON" name="REASON" rows="1" required>{{ old('REASON') }}</textarea>
                    @error('REASON')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                </div>

                <!-- Password -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="password">Password *</label>
                        <input type="password" id="password" name="password" required>
                        @error('password')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password *</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit">Register</button>
                <!-- Terms and Conditions -->
                <p style="text-align: left; margin-top: 20px; font-size: 14px;">
                    By registering, you agree to our <a href="{{ route('register') }}" style="color: #007bff;">terms and conditions</a>.
                </p>
                        <!-- Link to login -->
                <p style="text-align: left; margin-bottom: 20px;">
                    Having an account? <a href="{{ route('login') }}" style="color: #007bff;">Please login</a>
                </p>
            </form>
        </div>
    </div>
</body>

</html>
