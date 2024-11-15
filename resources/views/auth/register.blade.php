<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
    body,
    html {
        height: 100%;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f4f4f4;
        font-family: Arial, sans-serif;
    }

    .register-container {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
    }

    .register-container h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .register-container div {
        margin-bottom: 15px;
    }

    .register-container label {
        display: block;
        margin-bottom: 5px;
    }

    .register-container input {
        width: 100%;
        padding: 10px;
        margin: 5px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .register-container button {
        width: 100%;
        padding: 10px;
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
    }

    .register-container button:hover {
        background-color: #218838;
    }
    </style>
</head>

<body>

    <div class="register-container">
        <h2>Register</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div>
                <label for="USERNAME">Username</label>
                <input type="text" name="USERNAME" required>
            </div>
            <div>
                <label for="EMAIL">Email</label>
                <input type="email" name="EMAIL" required>
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" name="password" required>
            </div>
            <div>
                <label for="password_confirmation">Repeat Password</label>
                <input type="password" name="password_confirmation" required>
            </div>
            <button type="submit">Register</button>
        </form>
    </div>

</body>

</html>