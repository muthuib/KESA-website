<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <div id="app">
        <!-- Include the Top Navigation Bar (Topnav) -->
        @include('dashboard.topnav')

        <!-- Main Content -->
        <div class="main-content">
            <!-- Sidebar (optional, depending on authentication) -->
            @auth
            @include('dashboard.sidebar')
            @endauth

            <!-- Yield Content: Where content from individual views will be injected -->
            <div class="content">
                @yield('content')
            </div>
        </div>
    </div>

</body>

</html>