<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>{{ config('app.name', 'KESA') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    {{-- Include Top Navigation --}}
    @include('dashboard.topnav')

    {{-- Only logged-in users will see the sidebar --}}
    @auth
    <div id="layoutSidenav" style="display: flex;">
        <!-- Include Sidebar -->
        @include('dashboard.sidebar')

        <!-- Main Content -->
        <div id="layoutSidenav_content" style="flex-grow: 1; overflow-y: auto; top: 80px">
            @auth
                <!-- Start of Alert messages -->
                @if (session('success'))
                <div class="alert alert-success d-flex align-items-center mx-auto" role="alert" style="width: 600px; top: 10px;">
                    <i class="fas fa-check-circle me-2 fs-3 text-success" style="font-size: 1.5rem;"></i>
                    <div style="font-size: 1rem; color: #155724;">
                        {{ session('success') }}
                    </div>
                </div>
                @endif

                @if (session('danger'))
                <div class="alert alert-danger d-flex align-items-center mx-auto" role="alert" style="width: 600px; top: 10px;">
                    <i class="fas fa-times-circle me-2 fs-3 text-danger" style="font-size: 1.5rem;"></i>
                    <div style="font-size: 1rem; color: #721c24;">
                        {{ session('danger') }}
                    </div>
                </div>
                @endif
            @endauth

                <!-- End of alert message -->
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
                        <div>
                            <a href="{{ route('app') }}" style="font-size: 18px;">Privacy Policy</a>
                            &middot;
                            <a href="{{ route('app') }}" style="font-size: 18px;">Terms & Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    @endauth

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
</body>
