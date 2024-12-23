<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Company Registration Form</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;
        }

        .card {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            padding: 30px;
            max-width: 500px;
            width: 100%;
        }

        .card h2 {
            text-align: center;
            color: #4caf50;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .alert {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            border: 1px solid #f5c6cb;
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }

        .form-row .form-group {
            flex: 1;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        input:focus,
        select:focus {
            border-color: #4caf50;
            outline: none;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.3);
        }

        button[type="submit"] {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        .note {
            text-align: center;
            font-size: 12px;
            color: #888;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <!-- Include the top navigation bar from the dashboard folder -->
     <div> @include('dashboard.topnav')</div>
    <div class="card" style="margin-top: 120px;">
        <h2>Register Your Company</h2>

        <!-- Display validation errors -->
        @if($errors->any())
            <div class="alert" style="color: white; background-color: #ff4500;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('registration') }}" method="POST">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label for="COMPANY_NAME">Company Name:</label>
                    <input type="text" id="COMPANY_NAME" name="COMPANY_NAME" value="{{ old('COMPANY_NAME') }}" placeholder="Enter company name" required />
                </div>
                <div class="form-group">
                    <label for="REGISTRATION_NUMBER">Registration Number:</label>
                    <input type="text" id="REGISTRATION_NUMBER" name="REGISTRATION_NUMBER" value="{{ old('REGISTRATION_NUMBER') }}" placeholder="Enter registration number" required />
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="EMAIL">Email Address:</label>
                    <input type="email" id="EMAIL" name="EMAIL" value="{{ old('EMAIL') }}" placeholder="Enter email address" required />
                </div>
                <div class="form-group">
                    <label for="PHONE_NUMBER">Contact Number:</label>
                    <input type="text" id="PHONE_NUMBER" name="PHONE_NUMBER" value="{{ old('PHONE_NUMBER') }}" maxlength="10" placeholder="Enter contact number" required />
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="PHYSICAL_ADDRESS">Physical Address:</label>
                    <input type="text" id="PHYSICAL_ADDRESS" name="PHYSICAL_ADDRESS" value="{{ old('PHYSICAL_ADDRESS') }}" placeholder="Enter physical address" required />
                </div>
                <div class="form-group">
                    <label for="COMPANY_TYPE">Company Type:</label>
                    <select id="COMPANY_TYPE" name="COMPANY_TYPE" required>
                        <option value="" disabled {{ old('COMPANY_TYPE') ? '' : 'selected' }}>Select company type</option>
                        <option value="IT" {{ old('COMPANY_TYPE') == 'IT' ? 'selected' : '' }}>IT</option>
                        <option value="Sales" {{ old('COMPANY_TYPE') == 'Sales' ? 'selected' : '' }}>Sales</option>
                        <option value="Media" {{ old('COMPANY_TYPE') == 'Media' ? 'selected' : '' }}>Media</option>
                    </select>
                </div>
            </div>

            <label for="REASON">Why Choose Us?</label>
            <input type="text" id="REASON" name="REASON" value="{{ old('REASON') }}" placeholder="What makes us your choice?" required />

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Create a password" required />

            <label for="password_confirmation">Re-type Password:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm password" required />

            <button type="submit">Submit</button>
        </form>

        <p class="note">By registering, you agree to our <a href="#">Terms and Conditions</a>.</p>
    </div>
</body>

</html>
