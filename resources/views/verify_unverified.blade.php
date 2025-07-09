<!DOCTYPE html>
<html>
<head>
    <title>Member Verification - KESA</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fefefe;
            text-align: center;
            padding: 30px;
        }

        .card {
            background: #fff;
            border-radius: 10px;
            padding: 40px 30px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
            max-width: 500px;
            margin: auto;
        }

        .logo {
            width: 100px;
            margin-bottom: 20px;
        }

        .unverified {
            color: #d9534f;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .message {
            color: #333;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="card">
        <img src="{{ asset('pictures/logo.jpg') }}" class="logo" alt="KESA Logo">

        <div class="unverified">❌ Member Not Verified</div>

        <div class="message">
            The membership number <strong>{{ $membershipNumber }}</strong> does not match any member in our system.<br><br>
            Please ensure the code is correct or contact the KESA administration for assistance.
            <p>admin email: admin@kesakenya.org</p>
        </div>

        <div class="footer">
            Visit our website: <a href="https://kesakenya.org" target="_blank">https://kesakenya.org</a>
        </div>
    </div>
</body>
</html>
