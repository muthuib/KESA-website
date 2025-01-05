<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'KESA') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg- fixed-top" style="background-color: brown; margin-left: 0px; gap: 25px;">
        <!-- Navbar Brand -->
        <a class="navbar-brand ps-3" href="{{ route('app') }}">
           
        </a>
        <!-- Social media icons -->
        <a href="#" target="_blank" class="text-decoration-none">
            <i class="fab fa-facebook text-white" style="font-size: 24px;"></i>
        </a>
        <a href="#" target="_blank" class="text-decoration-none">
            <i class="fab fa-twitter text-white" style="font-size: 24px;"></i>
        </a>
        <a href="#" target="_blank" class="text-decoration-none">
            <i class="fab fa-instagram text-white" style="font-size: 24px;"></i>
        </a>
        <a href="#" target="_blank" class="text-decoration-none">
            <i class="fab fa-linkedin text-white" style="font-size: 24px;"></i>
        </a>

        <!-- Toggler Button for Collapsible Navbar -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsible Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarNav" style="margin-right: 30px;">
            <ul class="navbar-nav ms-auto">
                @guest
                 <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                </li>
                @endguest
                <li class="nav-item">
                    <a href="{{ route('about.index') }}" class="nav-link">About us</a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('app') }}" class="nav-link">News/Updates</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('app') }}" class="nav-link">Events/Debates</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('resources.show') }}" class="nav-link">Resources</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link">Memberships</a>
                </li>
                <!-- Guest Links -->
                @guest
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: blue; color:white; margin-right: 15px; font-weight: bold; border-radius: 5px; padding: 7px 10px;">Register</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown" style="background-color: #00FF7F;">
                            <li><a class="dropdown-item" href="{{ route('register') }}" style="color: blue; font-weight: bold;">Member Registration</a></li>
                            <li><a class="dropdown-item" href="{{ route('registration') }}" style="color: blue; font-weight: bold;">Partner Registration</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: green; color:white; margin-right: 1
                        5px; font-weight: bold; border-radius: 5px; padding: 7px 10px;">Login</a>
                        <ul class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown" style="background-color:rgb(104, 202, 69);">
                            <li><a class="dropdown-item" href="{{  route('login') }}"style="color: blue; font-weight: bold;">Member</a></li>
                            <li><a class="dropdown-item" href="{{  route('partnerlogin') }}"style="color: blue; font-weight: bold;">Partner</a></li>
                        </ul>
                    </li>
                @endguest
                <!-- Authenticated User Dropdown -->
              @auth
              <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: white;">
                        <i class="fas fa-user" style="font-size: 20px; color: white;"></i> {{ Auth::user()->FIRST_NAME }} {{ Auth::user()->LAST_NAME }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown" style="top: 60px;">
                        <li>
                            <a class="dropdown-item" href="{{ route('app') }}">
                                <i class="fas fa-key"></i> Change Password
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
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
    <!-- Kenyan Flag -->
    <div class="kenyan-flag"  style="position: fixed; top: 50px; left: 0; width: 100%; z-index: 1040;">
        <div class="black"></div> <!-- Black stripe -->
        <div class="white"></div> <!-- White separator -->
        <div class="red"></div>   <!-- Red stripe -->
        <div class="white"></div> <!-- White separator -->
        <div class="green"></div> <!-- Green stripe -->
    </div>
    <!-- Add Bootstrap JS for Interactivity -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>
