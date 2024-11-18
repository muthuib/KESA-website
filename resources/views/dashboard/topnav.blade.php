<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'KESA') }}</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Add Bootstrap CSS for better layout management -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    <nav class="sb-topnav navbar navbar-expand-lg navbar-dark bg-secondary">
        <!-- Navbar Brand -->
        <a class="navbar-brand ps-3" href="{{ route('app') }}">KESA WEBSITE</a>

        <!-- Sidebar Toggle (only for logged-in users) -->
        @auth
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
            <i class="fas fa-bars"></i>
        </button>
        @endauth

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto d-flex align-items-center">
                <!-- Main Navbar Items -->
                <li class="nav-item mx-2">
                    <a href="{{ route('app') }}" class="nav-link" style="font-size: 18px;">Home</a>
                </li>
                <li class="nav-item mx-2">
                    <a href="{{ route('home') }}" class="nav-link" style="font-size: 18px;">About</a>
                </li>
                <li class="nav-item mx-2">
                    <a href="{{ route('home') }}" class="nav-link" style="font-size: 18px;">News/Updates</a>
                </li>
                <li class="nav-item mx-2">
                    <a href="{{ route('home') }}" class="nav-link" style="font-size: 18px;">Events/Debates</a>
                </li>
                <li class="nav-item mx-2">
                    <a href="{{ route('home') }}" class="nav-link" style="font-size: 18px;">Memberships</a>
                </li>
                <li class="nav-item mx-2">
                    <a href="{{ route('home') }}" class="nav-link" style="font-size: 18px;">Contact</a>
                </li>

                <!-- User Authentication (Login/Register) -->
                @guest
                <li class="nav-item mx-2">
                    <a class="btn btn-info" href="{{ route('register') }}" style="font-size: 18px;">Register</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="btn btn-light" href="{{ route('login') }}" style="font-size: 18px;">Login</a>
                </li>
                @endguest

                <!-- User Profile Dropdown (only for logged-in users) -->
                @auth
                <li class="nav-item dropdown mx-2">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user fa-fw"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
                @endauth
            </ul>
        </div>
    </nav>

    <!-- Add Bootstrap JS for the dropdown and other interactive components -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    </script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>