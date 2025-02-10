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
      <p style="color:rgb(9, 220, 248);"><b>Motto:</b> <k style="color: #ffffff;"><b>Unity of Purpose</b></k></p> 
      

        <!-- Toggler Button for Collapsible Navbar -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsible Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarNav" style="margin-right: 30px;">
            <ul class="navbar-nav ms-auto">
            @guest
                <li class="nav-item">
                    <a 
                        class="nav-link" 
                        href="{{ route('home') }}" 
                        style="@if(request()->routeIs('home')) color: aqua; font-weight: bold; text-decoration: none; @else color: white; font-weight: bold; text-decoration: none; @endif">
                        Home
                    </a>
                </li>
            @endguest
                
                 <!-- About Us Dropdown -->
            <li class="nav-item dropdown" style="position: relative;">
                <!-- Main Tab -->
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" 
                    style="@if(request()->routeIs('about.vision') || request()->routeIs('about.mission') || request()->routeIs('about.objectives')) 
                            color: aqua; font-weight: bold; text-decoration: none; 
                        @else 
                            color: white; font-weight: bold; text-decoration: none; 
                        @endif">
                    About Us
                </a>

                <!-- Dropdown Menu -->
                <ul class="dropdown-menu" id="dropdown-menu" 
                    style="background-color:white; position: absolute; top: 100%; left: 0; padding: 10px; border-radius: 5px; display: none;">              
                    <li>
                        <a class="dropdown-item" href="{{ route('about.vision') }}" style="color: black; font-weight: bold;">Vision</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('about.mission') }}" style="color: black; font-weight: bold;">Mission</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('about.objectives') }}" style="color: black; font-weight: bold;">Objectives</a>
                    </li>
                </ul>
            </li>
         <!-- End of About us dropdown -->
                <a href="{{ route('events.showAll') }}" class="nav-link" style="@if(request()->routeIs('events.showAll')) color: aqua; font-weight: bold; text-decoration: none; @else color: white; font-weight: bold; text-decoration: none; @endif">Events</a>
                    <!-- Economics Hub Dropdown (Fixed) -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="economicsHubDropdown" style="@if(request()->routeIs('resources.show') || request()->routeIs('app') || request()->routeIs('feedback.create')) 
                                color: aqua; font-weight: bold; text-decoration: none; 
                            @else 
                                color: white; font-weight: bold; text-decoration: none; 
                            @endif">Economics Hub</a>
                    <ul class="dropdown-menu" id="economicsHubMenu">
                        <li><a class="dropdown-item" href="{{ route('resources.show') }}">Resources</a></li>
                        <li><a class="dropdown-item" href="{{ route('app') }}">Research</a></li>
                        <li><a class="dropdown-item" href="{{ route('feedback.create') }}">Feedback</a></li>
                    </ul>
                </li>
                <script>
                // Economics Hub Dropdown (Fix)
                const economicsHubDropdown = document.getElementById('economicsHubDropdown');
                const economicsHubMenu = document.getElementById('economicsHubMenu');
                const economicsHubParent = economicsHubDropdown.parentElement;

                economicsHubParent.addEventListener('mouseenter', () => {
                    economicsHubMenu.style.display = 'block';
                });

                economicsHubMenu.addEventListener('mouseenter', () => {
                    economicsHubMenu.style.display = 'block';
                });

                economicsHubParent.addEventListener('mouseleave', () => {
                    economicsHubMenu.style.display = 'none';
                });

                economicsHubMenu.addEventListener('mouseleave', () => {
                    economicsHubMenu.style.display = 'none';
                });

                economicsHubDropdown.addEventListener('mouseenter', () => {
                    economicsHubMenu.style.display = 'block';
                });
            </script>
              
                <script>
                        // Select the Economics Hub tab and dropdown menu
                        const navbarDropdown = document.getElementById('navbarDropdown');
                        const dropdownMenu = document.getElementById('dropdown-menu');
                        const parentLi = navbarDropdown.parentElement;

                        // Show dropdown when cursor enters the parent tab or the dropdown
                        parentLi.addEventListener('mouseenter', () => {
                            dropdownMenu.style.display = 'block';
                        });

                        // Ensure dropdown stays visible when hovering over the dropdown menu
                        dropdownMenu.addEventListener('mouseenter', () => {
                            dropdownMenu.style.display = 'block'; // Ensure it stays visible while hovering over the dropdown
                        });

                        // Hide dropdown when cursor leaves the parent tab and dropdown
                        parentLi.addEventListener('mouseleave', () => {
                            dropdownMenu.style.display = 'none';
                        });

                        // Hide dropdown when cursor leaves the dropdown
                        dropdownMenu.addEventListener('mouseleave', () => {
                            dropdownMenu.style.display = 'none'; // Hide it when the cursor leaves the dropdown
                        });

                        // Show the dropdown again when moving the cursor back to the Economics Hub tab
                        navbarDropdown.addEventListener('mouseenter', () => {
                            dropdownMenu.style.display = 'block';
                        });
                </script>

                <!-- Contact us tab -->
                <li class="nav-item">
                    <a href="{{ route('contact.display') }}" class="nav-link" style="@if(request()->routeIs('contact.display')) color: aqua; font-weight: bold; text-decoration: none; @else color: white; font-weight: bold; text-decoration: none; @endif">Contact Us</a>
                </li>
                <!-- Guest Links -->
                <!-- @guest
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
                @endguest -->
                @guest
                    <!-- Register Button -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}" style="background-color: blue; color: white; margin-right: 15px; font-weight: bold; border-radius: 5px; padding: 7px 10px;">
                            Register
                        </a>
                    </li>

                    <!-- Login Button -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}" style="background-color: green; color: white; margin-right: 15px; font-weight: bold; border-radius: 5px; padding: 7px 10px;">
                            Login
                        </a>
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
    <div class="kenyan-flag"  style="position: fixed; top: 50px; left: 0; width: 100%; z-index: 1000;">
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
<style>
/* Custom Hover Effect for Dropdown Items */
#dropdown-menu .dropdown-item {
    padding: 10px 20px;  /* Adjust padding to make items look bigger */
    font-size: 16px;  /* Change font size */
    font-family: 'Arial', sans-serif;  /* Change font family */
    color: #333;  /* Default text color */
    transition: all 0.3s ease;  /* Smooth transition for hover effect */
}

/* Hover Effect */
#dropdown-menu .dropdown-item:hover {
    background-color:rgb(222, 124, 124);  /* Blue background on hover */
    color: white;  /* White text color on hover */
    border-radius: 5px;  /* Optional: Add rounded corners */
}

/* Optionally, you can also add a focus state for keyboard accessibility */
#dropdown-menu .dropdown-item:focus {
    background-color: #0056b3;  /* Darker blue for focused item */
    color: white;  /* White text on focus */
}



</style>