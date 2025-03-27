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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>
<style>
        /* Default styles */
        .motto-text { 
            color: brown; 
            font-size: 18px;
        }
        .motto-key { 
            color: rgb(51, 33, 132); 
            font-size: 17px;
        }
        /* Style for Twitter Image */
        .twitter-img {
            width: 22px;
            height: 22px;
            margin-left: 10px;
        }

        /* For small devices */
        @media (max-width: 576px){
            .motto-text, .motto-key {
                font-size: 6px !important;
            }
            /* Reduce logo size */
            .logo-container img {
                width: 70px !important;
                height: 70px !important;
                margin-top: 20px !important;
                
            }

            /* Reduce social media icon size */
            .navbar .fab {
                font-size: 16px !important; /* Reduce icon size */
                margin-left: 10px !important; /* Adjust spacing */
            }

            /* Reduce image-based social media icons */
            /* .navbar img {
                width: 18px !important;
                height: 18px !important;
                margin-left: 10px !important;
            } */
        }
         /* Pop-up styling */
         #customPopup {
            display: none; /* Hidden by default */
            position: fixed;
            top: 10%;
            right: 10%;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }

        /* Popup Content */
        .popup-content {
            text-align: left;
        }

        /* Close Button */
        #closePopup {
            background: none;
            border: none;
            font-size: 34px;
            cursor: pointer;
            position: absolute;
            top: 10px;
            right: 10px;
            color: red;
            font-weight: bold;
        }
        .menu-item {
                margin-bottom: 10px; /* Adds space between items */
            }

        .menu-item a {
            text-decoration: none; /* Removes underline */
            color: black; /* Sets link color */
            font-size: 16px; /* Adjust text size */
            font-weight: bold;
        }

        .menu-item a:hover {
            color: blue; /* Change color on hover */
        }
            /* consultancies dropdown */
            .menu-item {
                display: inline-block;
                margin-right: 15px;
            }

            .dropdown-menu {
                display: none;
                position: absolute;
                background: white; 
                padding: 10px;
                list-style: none;
            }

            .dropdown:hover .dropdown-menu {
                display: block;
            }
            /* small and medium device responsiveness */
            .navbar {
                background-color: brown;
                gap: 15px;
                height: 83px; /* Default for large screens */
            }
            .kenyan-flag {
                position: fixed;
                top: 78px; /* Default for large screens */
                left: 0;
                width: 100%;
                z-index: 1000;
            }

            /* Adjust height for small and medium screens */
            @media (max-width: 991px){ /* Bootstrap lg breakpoint */
                .navbar {
                    height: 60px;
                }
                .kenyan-flag {
                    top: 55px;
                }
                #openPopup {
                    position: fixed;
                    top: 10px; /* Distance from top */
                    right: 10px; /* Distance from right */
                    z-index: 1050; /* Ensure it's above other elements */
                    margin-left: 0; /* Reset margin */
                }

            }
            /* adjusting space between tabs */
            .navbar-nav .nav-item {
                margin-right: 26px; /* Adjust spacing as needed */
            }
            #navbarNav {
                margin-left: 160px; /* Apply left margin by default */
            }

            /* Reduce spacing on small and medium devices */
            @media (max-width: 991px) {  /* Medium and small devices */
                .navbar-nav .nav-item {
                    margin-right: 1px; /* Adjust spacing for better fit */
                }
            }

            /* Ensure all tabs remain visible */
            @media (max-width: 768px) {  /* Small devices */
                .navbar-nav {
                    flex-wrap: wrap; /* Allows tabs to wrap instead of being hidden */
                    justify-content: center; /* Centers the tabs if wrapped */
                }
                .navbar-nav .nav-item {
                    margin-right: 1px; /* Reduce spacing further */
                }
            }

           


 </style>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: brown; gap: 15px;">
         <!-- Logo Container -->
         <div class="logo-container" style="position: absolute; top: 50%; left: 8%; transform: translate(-50%, -50%);">
            <img src="{{ asset('pictures/logo.jpg') }}" 
                alt="KESA Logo" 
                class="img-fluid" 
                style="width: 90px; height: 90px; border-radius: 50%; object-fit: contain; background-color: white; padding: 8px; margin-top: 20px; border: 3px solid white;">
        </div>

        <!-- Social media icons -->
        <!-- <div style="display: flex; gap: 15px; align-items: center;">
                <a href="https://www.facebook.com/kesa.kenya?mibextid=ZbWKwL" target="_blank" class="text-decoration-none">
                    <i class="fab fa-facebook text-white" style="font-size: 24px;"></i>
                </a>
                
                <a href="https://twitter.com/kesa_kenya?t=9VRLpQi_IiXHRdU81n_iLQ&s=09" target="_blank" class="text-decoration-none">
                <img src="/assets/images/x-logo.png" alt="Twitter X" class="twitter-img">

                <a href="https://www.instagram.com/kesa_kenya?igsh=YjcwdXptM254d3Fq" target="_blank" class="text-decoration-none">
                    <i class="fab fa-instagram text-white" style="font-size: 24px;"></i>
                </a>

                <a href="https://www.linkedin.com/company/kenya-economics-students-association/" target="_blank" class="text-decoration-none">
                    <i class="fab fa-linkedin text-white" style="font-size: 24px;"></i>
                </a>
            </div>

      <p class="motto-text" style="color:rgb(9, 220, 248);"><b>Motto:</b> <k class="motto-key" style="color: #ffffff;"><b>Unity of Purpose</b></k></p>  -->
      
        <!-- Toggler Button for Collapsible Navbar -->
        <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
        </button> -->
        <button class="navbar-toggler" id="openPopup">
            <span class="navbar-toggler-ico" style="color: white;">Menu</span>
        </button>
<!-- Pop-Up Menu -->
<div id="customPopup">
    <div class="popup-content">
        <button id="closePopup">&times;</button><br>
        <ul style="text-align:left; width: 150px; list-style: none; padding: 0;">
            @guest
            <div class="menu-item"><a href="{{ route('home') }}">Home</a></div><br>
            @endguest
            <!-- about us dropdown -->
            <div class="menu-item dropdown">
                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">About Us</a> <br>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('about.display') }}">Who we are</a></li>
                        <li><a class="dropdown-item" href="{{ route('team-members.display') }}">Our people</a></li>
                </ul>
            </div>
            <!-- Events dropdown -->
            <div class="menu-item dropdown">
                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">Events</a> <br>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route ('events.showAll') }}">Upcoming Events</a></li>
                        <li><a class="dropdown-item" href="{{ route('activities.display') }}">Past Events</a></li>
                </ul>
            </div>
            <!-- resource HUB Dropdown -->
            <div class="menu-item dropdown">
                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">Resource hub</a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('publications.display') }}">Publications</a></li>
                        <!-- <li><a class="dropdown-item" href="{{ route('app') }}">Research</a></li> -->
                        <li><a class="dropdown-item" href="{{ route('feedback.create') }}">Feedback</a></li>
                </ul>
            </div>
            <div class="menu-item"><a href="{{ route('contact.display') }}">Contact</a></div>
            <div class="menu-item"><a href="{{ route('live-events.list') }}">Live Media</a></div>
            @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}" style="background-color:white; color: black; margin-right: 15px; font-weight: bold; border-radius: 5px; padding: 7px 10px;">
                    Register
                </a>
            </li>
            <li class="nav-item" style="margin-top: 10px;">
                <a class="nav-link" href="{{ route('login') }}" style="background-color:white; color: black; margin-right: 15px; font-weight: bold; border-radius: 5px; padding: 7px 10px;">
                    Login
                </a>
            </li>
             <!-- search icon -->
            <!-- Search Button for Popup Menu -->
                <div class="popup-menu">
                    <div class="ms-auto">
                        <button class="btn btn-outline-light searchToggle" data-target="searchFormContainer2" style="color: black;">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>

                    <!-- Search Form for Popup Menu -->
                    <div id="searchFormContainer2" class="search-form-container position-absolute top-100 end-0 p-3 shadow rounded d-none" style="background-color: brown; margin-right: 0px;">
                        <form class="d-flex" action="{{ route('search') }}" method="GET">
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="query" style="width: 250px;">
                            <button class="btn btn-outline-light" type="submit">Search</button>
                        </form>
                    </div>
                </div>
            @endguest
            @auth
                    <!-- Logout Button -->
               <li class="nav-item">
               <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
               <i class="fas fa-user" style="font-size: 20px; color: blue;"></i> <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                    </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                @endauth
                 </ul>
            </div>
        </div>
                <script>
                            document.getElementById("openPopup").addEventListener("click", function() {
                            document.getElementById("customPopup").style.display = "block";
                        });

                        document.getElementById("closePopup").addEventListener("click", function() {
                            document.getElementById("customPopup").style.display = "none";
                        });

                 </script>
        <!-- Collapsible Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
            @guest
                <li class="nav-item">
                    <a 
                        class="nav-link" 
                        href="{{ route('home') }}" 
                        style="@if(request()->routeIs('home')) color: aqua; font-weight: bold; text-decoration: none; margin-top: 22px; @else color: white; font-weight: bold; text-decoration: none; margin-top: 22px; @endif">
                        Home
                    </a>
                </li>
            @endguest
                <!-- About us Dropdown (Fixed) -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="economicsHubDropdown" style="@if(request()->routeIs('about.display') || request()->routeIs('team-members.display')) 
                                color: aqua; font-weight: bold; text-decoration: none; margin-top:22px; 
                            @else 
                                color: white; font-weight: bold; text-decoration: none; margin-top: 22px; 
                            @endif">About Us</a>
                    <ul class="dropdown-menu" id="economicsHubMenu">
                        <li><a class="dropdown-item" href="{{ route('about.display') }}">Who we are</a></li>
                        <li><a class="dropdown-item" href="{{ route('team-members.display') }}">Our people</a></li>
                    </ul>
                </li>
            <!-- events dropdown -->
            <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="eventsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" 
                    style="@if(request()->routeIs('events.showAll') || request()->routeIs('activities.display')) 
                                color: aqua; font-weight: bold; text-decoration: none; margin-top: 22px; 
                            @else 
                                color: white; font-weight: bold; text-decoration: none; margin-top: 22px; 
                            @endif">
                        Event
                    </a>
                    <ul class="dropdown-menu custom-dropdown" aria-labelledby="eventsDropdown">
                        <li><a class="dropdown-item @if(request()->routeIs('events.showAll')) @endif" href="{{ route('events.showAll') }}">All Events</a></li>
                        <li><a class="dropdown-item @if(request()->routeIs('activities.display'))  @endif" href="{{ route('activities.display') }}">Activities</a></li>
                    </ul>
                </li>
                    <!-- Economics Hub Dropdown (Fixed) -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="economicsHubDropdown" style="@if(request()->routeIs('publications.display') || request()->routeIs('app') || request()->routeIs('feedback.create')) 
                                color: aqua; font-weight: bold; text-decoration: none; margin-top: 22px;
                            @else 
                                color: white; font-weight: bold; text-decoration: none;  margin-top: 22px;
                            @endif">Resource Hub</a>
                    <ul class="dropdown-menu" id="economicsHubMenu">
                        <li><a class="dropdown-item" href="{{ route('publications.display') }}">Publications</a></li>
                        <li><a class="dropdown-item" href="{{ route('activities.display') }}">Past Events</a></li>
                        <!-- <li><a class="dropdown-item" href="{{ route('app') }}">Research</a></li> -->
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

                    <ul class="nav responsive-nav">
                        <!-- Contact Us tab -->
                        <li class="nav-item">
                            <a href="{{ route('contact.display') }}" class="nav-link responsive-text"style="@if(request()->routeIs('contact.display')) color: aqua; font-weight: bold; text-decoration: none; margin-top: 22px; @else color: white; font-weight: bold; text-decoration: none; margin-top: 22px; @endif">
                                Contact Us
                            </a>
                        </li>
                        </ul>
                        <ul class="nav responsive-nav">
                        <!-- Live Media tab -->
                        <li class="nav-item">
                            <a href="{{ route('live-events.list') }}" class="nav-link responsive-text"style="@if(request()->routeIs('live-events.list')) color: aqua; font-weight: bold; text-decoration: none; margin-top: 22px; @else color: white; font-weight: bold; text-decoration: none; margin-top: 22px; @endif">
                                Live Media
                            </a>
                        </li>
                    </ul>

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
                        <a class="nav-link" href="{{ route('register') }}" style="background-color: brown; color: white; margin-right: 15px; font-weight: bold; border-radius: 5px; padding: 7px 10px; margin-top: 22px;">
                            Register
                        </a>
                    </li>

                    <!-- Login Button -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}" style="background-color: brown; color: white; font-weight: bold; border-radius: 5px; padding: 7px 10px; margin-top: 22px;">
                            Login
                        </a>
                    </li>
                    <li class="nav-item">
                    <!-- search icon -->
                    <!-- Search Button for Main Menu -->
                    <div class="container-fluid" style="margin-right: 100px; margin-top: 22px;">
                        <div class="ms-auto">
                            <button class="btn btn-outline-ligh searchToggle" data-target="searchFormContainer1" style="color: white;">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>

                        <!-- Search Form for Main Menu -->
                        <div id="searchFormContainer1" class="search-form-container position-absolute top-100 end-0 p-3 shadow rounded d-none" style="background-color: brown; margin-right: 150px;">
                            <form class="d-flex" action="{{ route('search') }}" method="GET">
                                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="query" style="width: 700px;">
                                <button class="btn btn-outline-light" type="submit">Search</button>
                            </form>
                        </div>
                    </div>
                
                </li>
                <script>
                document.querySelectorAll('.searchToggle').forEach(button => {
                        button.addEventListener('click', function () {
                            let targetId = this.getAttribute('data-target');
                            let targetForm = document.getElementById(targetId);
                            
                            // Hide all search forms first
                            document.querySelectorAll('.search-form-container').forEach(form => {
                                if (form.id !== targetId) {
                                    form.classList.add('d-none');
                                }
                            });

                            // Toggle the target search form
                            targetForm.classList.toggle('d-none');
                        });
                    });

                // Check zoom level
               // show the toggler button when zoomed at 50% on small devices and also when zoomed above 120% on all screens
               function checkZoom() {
                const zoomLevel = Math.round(window.devicePixelRatio * 80); // Get zoom percentage
                const toggler = document.querySelector('.navbar-toggler');
                const navbarCollapse = document.querySelector('.navbar-collapse');
                const navItems = document.querySelector('.navbar-nav');

                if (zoomLevel > 120 || (zoomLevel <= 50 && window.innerWidth <= 768)) {
                    toggler.style.display = 'block'; // Show toggler if zoom > 120% or zoom ≤ 50% on small screens
                    navItems.style.display = 'none'; // Hide navigation tabs
                    navbarCollapse.classList.remove('show'); // Hide expanded menu
                } else {
                    if (window.innerWidth <= 991) {
                        toggler.style.display = 'block'; // Show toggler on smaller screens
                        navItems.style.display = 'none'; // Hide navigation tabs
                    } else {
                        toggler.style.display = 'none'; // Hide toggler on larger screens with normal zoom
                        navItems.style.display = 'flex'; // Show navigation tabs
                        navbarCollapse.classList.add('show'); // Keep menu expanded
                    }
                }
            }

            // Run on load and when resizing
            window.addEventListener('resize', checkZoom);
            window.addEventListener('load', checkZoom);

            </script>

                @endguest

                <!-- Authenticated User Dropdown -->
              @auth
              <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: white;">
                    <i class="fas fa-user" style="font-size: 20px; color: white; margin-top: 22px;"></i> 
                    {{ Auth::user()->FIRST_NAME }} {{ Auth::user()->LAST_NAME }} 
                    (@if(Auth::user()->roles->isEmpty()) 
                        <span style="color: aqua; font-weight: bold;">Waiting for Approval</span> 
                    @else 
                    <span style="color: aqua; font-weight: bold;">{{ Auth::user()->MEMBERSHIP_NUMBER }} </span> 
                    @endif)
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
    <div class="kenyan-flag"  style="position: fixed; left: 0; width: 100%; z-index: 1000;">
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
    /* Economics Hub Dropdown Hover Effect */
    #economicsHubMenu .dropdown-item:hover {
        background-color: maroon; /* Brown background on hover */
        color: white; /* White text on hover */
        border-radius: 5px; /* Optional: Add rounded corners */
        transition: all 0.3s ease;
    }
    /* zooming */
    .navbar-toggler {
            display: none; /* Hide by default */
            position: absolute;
            right: 20px; /* Align to the right */
            top: 10px; /* Adjust vertical positioning */
        }

        @media (max-width: 991px) {
            .navbar-toggler {
                display: block !important; /* Show toggler on smaller screens */
            }
            .navbar-nav {
                display: none !important; /* Hide navigation tabs */
            }
        }

        /* reduce the font size of the navigation tabs when the screen size is reduced */
        .navbar-nav .nav-link {
            font-size: 18px; /* Default size */
            transition: font-size 0.3s ease-in-out;
        }

        /* Reduce font size when screen width decreases */
        @media (max-width: 1200px) {
            .navbar-nav .nav-link {
                font-size: 11px;
            }
            /* Reduce logo size */
            .logo-container img {
                width: 70px !important;
                height: 70px !important;
                margin-top: 20px !important;
                
            }
        }

        @media (max-width: 992px) {
            .navbar-nav .nav-link {
                font-size: 10px;
            }
        }

        @media (max-width: 768px) {
            .navbar-nav .nav-link {
                font-size: 12px;
            }
        }

        @media (max-width: 576px) {
            .navbar-nav .nav-link {
                font-size: 10px;
            }
        }

/* CONTACT US AND LIVE MEDIA TAB RESPONSIVENESS */
/* Keep tabs in a single row */
.responsive-nav {
    display: flex;
    flex-direction: row;  /* Ensures items are in a row */
    justify-content: center; /* Centers tabs */
    align-items: center;
    gap: 20px; /* Adds space between tabs */
    flex-wrap: nowrap; /* Prevents stacking in a column */
}

/* Default tab styling */
.responsive-text {
    font-size: 18px;
    font-weight: bold;
    text-decoration: none;
    white-space: nowrap; /* Prevents text from wrapping */
}

/* Responsive Adjustments */
@media (max-width: 992px) {
    .responsive-text {
        font-size: 16px;
    }
    .responsive-nav {
        gap: 15px;
    }
}

@media (max-width: 768px) {
    .responsive-text {
        font-size: 14px;
    }
    .responsive-nav {
        gap: 10px;
    }
}

@media (max-width: 576px) {
    .responsive-text {
        font-size: 12px;
    }
    .responsive-nav {
        gap: 5px; /* Reduce spacing further */
    }
}
/* Change hover color for events dropdown */
.custom-dropdown .dropdown-item:hover {
    background-color: maroon !important; /* Change to your desired hover color */
    color: white !important;
}

/* Change active color */
/* .custom-dropdown .dropdown-item.active, 
.custom-dropdown .dropdown-item:active {
    background-color: aqua !important; 
    color: white !important;
} */


</style>