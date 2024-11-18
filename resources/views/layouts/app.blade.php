<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'KESA') }}</title>
</head>

<body>
    <div id="app">
        <!-- Include the Top Navigation Bar (Topnav) -->
        @include('dashboard.topnav')

        <!-- Main Content Area (Including Sidebar and Dashboard) -->
        <div class="main-content">
            <!-- Sidebar (optional, depending on authentication) -->
            @auth
            <div class="sidebar">
                @include('dashboard.sidebar')
            </div>
            @endauth

            <div class="content">
                <!-- Dashboard Content (You can define the dashboard content here) -->
                @yield('content')
                <!-- This will yield dynamic content from other views -->
            </div>
        </div>
    </div>
</body>

</html>