@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Ticket</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px auto;
            max-width: 600px;
            background-color: #ffffff;
            margin-left: 10px;
        }

        .card-header {
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
/* 
        button[type="submit"]:hover {
            background-color: #0056b3;
        } */

        a {
            display: inline-block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }

        /* a:hover {
            text-decoration: underline;
        } */

        .error-messages {
            color: red;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cancel-btn {
            background-color:rgb(241, 8, 8);
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .cancel-btn:hover {
            background-color:rgb(225, 16, 16);
        }
    </style>
</head>
<body>

<div class="card">
    <div class="card-header" style="font-weight: bold;">Create Ticket</div>

    @if ($errors->any())
        <div class="error-messages">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tickets.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Ticket Name:</label>
            <input type="text" name="name" id="name" required value="{{ old('name') }}">
        </div>

        <div class="form-group">
            <label for="price">Ticket Price (KES):</label>
            <input type="number" name="price" id="price" step="0.01" required value="{{ old('price') }}">
        </div>

        <div class="form-group button-group">
            <button type="submit">Create Ticket</button>
            <a href="{{ route('tickets.index') }}" class="cancel-btn">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>

</body>
</html>
@endsection
