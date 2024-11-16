<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        /* Reset CSS for the body */
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            height: 100%;
        }

        /* Top Navigation Bar */
        .topnav {
            width: 100%;
            background-color: #333;
            color: white;
            padding: 10px;
            position: fixed; /* Fix the topnav at the top */
            top: 0;
            left: 0;
            z-index: 1000;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 60px;  /* Adjust top to place below the top nav */
            left: 0;
            width: 200px;
            height: 100%;
            background-color: #4CAF50;  /* Change this to your desired color */
            padding-top: 20px;
            margin-top: 20px;  /* Added margin-top */
            z-index: 999;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            padding: 10px;
            text-align: left;
        }

        .sidebar ul li a {
            color: white;  /* Text color */
            text-decoration: none;
            display: block;
            padding: 10px;
            transition: background-color 0.3s ease;
        }

        .sidebar ul li a:hover {
            background-color: #333;  /* Darken on hover */
        }

        /* Content Area Styling */
        .main-content {
            margin-left: 220px;
            padding: 20px;
            padding-top: 60px;
        }

        .content {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div id="app">
        <!-- Include the Top Navigation Bar (Topnav) -->
        @include('dashboard.topnav')

        <!-- Main Content Area -->
        <div class="main-content">
            <!-- Sidebar -->
            @auth
            <div class="sidebar">
                <ul>
                    <li><a href="{{ route('home') }}">Dashboard</a></li>
                    <li><a href="{{ route('profile') }}">Profile</a></li>
                    <li><a href="{{ route('settings') }}">Settings</a></li>
                    <!-- Add other sidebar links -->
                </ul>
            </div>
            @endauth

            <!-- Yield Content: Where content from individual views will be injected -->
            <div class="content">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
