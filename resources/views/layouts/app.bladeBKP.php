<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'KESA') }}</title>
    <style>
        /* General reset and layout settings */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
        }

        /* Fixed Top Navigation Bar */
        .topnav {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 100;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            height: 60px; /* Define height for topnav */
        }

        .topnav .navbar-brand {
            font-size: 1.5rem;
            color: white;
        }

        /* Main Content Area */
        .main-content {
            display: flex;
            margin-left: 120px; /* Offset for sidebar width */
            margin-top: 100px; /* Offset for topnav height */
            flex: 1;
            height: calc(100vh - 60px); /* Full height excluding topnav */
        }

        /* Content Area */
        .content {
            flex: 1;
            padding: 20px;
            overflow-y: auto; /* Allow vertical scrolling if content overflows */
            background-color: #f8f9fa;
            height: calc(100vh - 60px); /* Full height minus topnav */
        }

        /* Alert Styles */
        .alert {
            max-width: 800px;
            margin-top: 20px;
            padding: 15px;
        }

        
    </style>
</head>

<body>

    <div id="app">
        <!-- Top Navigation Bar -->
        <div class="topnav">
            @include('dashboard.topnav') <!-- Include your top navigation bar here -->
        </div>

        <!-- Main Content Area -->
        <div class="main-content">
            <!-- Sidebar -->
            @auth
            <div class="sidebar">
                @include('dashboard.sidebar') <!-- Include your sidebar here -->
            </div>
            @endauth

            <!-- Content -->
            <div class="content">
                @auth
                <!--Start of Alert messages -->
                @if (session('success'))
                <div class="alert alert-success d-flex align-items-center mx-auto" role="alert">
                    <i class="fas fa-check-circle me-2 fs-3 text-success"></i>
                    <div>
                        {{ session('success') }}
                    </div>
                </div>
                @endif

                @if (session('danger'))
                <div class="alert alert-danger d-flex align-items-center mx-auto" role="alert">
                    <i class="fas fa-times-circle me-2 fs-3 text-danger"></i>
                    <div>
                        {{ session('danger') }}
                    </div>
                </div>
                @endif
                @endauth
                <!-- End of alert message -->

                <!-- Main Content (Dynamic Content will be injected here) -->
                @yield('content')
            </div>
        </div>
    </div>

</body>

</html>
