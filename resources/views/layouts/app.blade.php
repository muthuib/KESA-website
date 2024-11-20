<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'KESA') }}</title>
    <style>
      
        /* Main Content Area */
        .main-content {
            display: flex;
            flex: 1; /* Ensures the content area expands to fill the remaining height */
        }


        /* Content Area */
        .content {
            flex: 1; /* Ensures content takes the remaining space */
            padding: 20px;
            overflow-y: auto; /* Allows scrolling if content is too large */
        }
    </style>
</head>

<body>
    <div id="app">
        <!-- Top Navigation Bar -->
        <div class="topnav">
            @include('dashboard.topnav')
        </div>

        <!-- Main Content Area -->
        <div class="main-content">
            <!-- Sidebar -->
            @auth
            <div class="sidebar">
                @include('dashboard.sidebar')
            </div>
            @endauth

            <!-- Content -->
            <div class="content">
                @yield('content')
            </div>
        </div>
    </div>
</body>

</html>
