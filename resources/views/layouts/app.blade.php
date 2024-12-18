<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Set the viewport for responsive design -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>{{ config('app.name', 'KESA') }}</title>
    <!-- Include Simple DataTables and custom styles -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <!-- Include Font Awesome for icons -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Include Bootstrap CSS for responsive grid and utility classes -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="sb-nav-fixed">
    {{-- Include Top Navigation --}}
    @include('dashboard.topnav')

    {{-- Only logged-in users will see the sidebar --}}
    @auth
    <div id="layoutSidenav" class="d-flex">
        <!-- Sidebar is wrapped in a container with Bootstrap flex class for layout responsiveness -->
        @include('dashboard.sidebar')
    @endauth
        <!-- Main content area -->
        <div id="layoutSidenav_content" class="flex-grow-1 overflow-auto" style="top: 80px;">
            @auth
                <!-- Responsive alert messages -->
                @if (session('success'))
                <div class="alert alert-success d-flex align-items-center mx-auto my-2" role="alert" 
                     style="max-width: 90%; width: 600px;">
                    <!-- Use icons with responsive sizing -->
                    <i class="fas fa-check-circle me-2 fs-4 text-success"></i>
                    <div style="font-size: 1rem; color: #155724;">
                        {{ session('success') }}
                    </div>
                </div>
                @endif

                @if (session('danger'))
                <div class="alert alert-danger d-flex align-items-center mx-auto my-2" role="alert" 
                     style="max-width: 90%; width: 600px;">
                    <i class="fas fa-times-circle me-2 fs-4 text-danger"></i>
                    <div style="font-size: 1rem; color: #721c24;">
                        {{ session('danger') }}
                    </div>
                </div>
                @endif
            @endauth

            <!-- Main container for dynamic content -->
            <main>
                <div class="container-fluid px-4">
                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">&copy; KESA 2024</div>
                        <!-- Use responsive font sizes -->
                        <div>
                            <a href="{{ route('app') }}" class="text-decoration-none" style="font-size: 18px;">Privacy Policy</a>
                            &middot;
                            <a href="{{ route('app') }}" class="text-decoration-none" style="font-size: 18px;">Terms & Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    <!-- Scripts -->
    <!-- Include Bootstrap JS for responsiveness and interactivity -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
    <!-- Include Bootstrap CSS for responsive grid -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
