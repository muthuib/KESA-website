<!DOCTYPE html>
<html>
<head>
    <title>Member Verification - KESA</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 30px;
            background: #f7f7f7;
        }
        .card {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 500px;
            margin: auto;
        }
        .logo {
            width: 100px;
            margin-bottom: 20px;
        }
        .verified {
            color: green;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .details {
            text-align: left;
            margin: auto;
            max-width: 350px;
        }
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="card">
        <img src="{{ asset('pictures/logo.jpg') }}" class="logo" alt="KESA Logo">

        <div class="verified">✅ Member is Verified</div>

        <div class="details">
            <p><strong>Name:</strong> {{ $user->FIRST_NAME }}</p>
            <p><strong>Email:</strong> {{ $user->EMAIL }}</p>
            <p><strong>Phone:</strong> {{ $user->PHONE_NUMBER }}</p>
            <p><strong>Membership No:</strong> {{ $user->MEMBERSHIP_NUMBER }}</p>
        </div>

        <div class="footer">
            Visit our website: <a href="https://kesakenya.org" target="_blank">https://kesakenya.org</a>
        </div>
    </div>
</body>
</html>
