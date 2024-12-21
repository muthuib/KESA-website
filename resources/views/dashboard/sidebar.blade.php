<!-- sidebar.blade.php -->
<div id="layoutSidenav_nav" class="sb-sidenav-container" style="top: 60px; background-color: maroon; width: 250px;">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <!-- Sidebar heading -->
                <div class="sb-sidenav-menu-heading" style="background-color: white; color:darkgreen;"><u>KESA MAIN MENU</u></div>
                <a class="nav-link" href="{{ route('dashboard') }}" style="font-size: 18px;">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <!-- admin roles authentication -->
                @if(auth()->user()->hasRole('admin'))
                <a class="nav-link" href="{{ route('resources.index') }}" style="font-size: 18px;">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Manage Resources
                </a>
               
                <a class="nav-link" href="{{ route('admin.slides.index') }}" style="font-size: 18px;">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Manage slideshows
                </a>
                <a class="nav-link" href="{{ route('send.newsletter') }}" style="font-size: 18px;">
                    <div class="sb-nav-link-icon"><i class="fas fa-envelope"></i></div>
                    Sent Newsletter
                </a>
                <a class="nav-link" href="{{ route('newsletters.index') }}" style="font-size: 18px;">
                    <div class="sb-nav-link-icon"><i class="fas fa-envelope"></i></div>
                    View newsletters
                </a>
                <a class="nav-link" href="{{ route('users.index') }}" style="font-size: 18px;">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-circle text-info"></i></div>
                    Manage Users
                </a>
                <!-- Add Collaborators Link -->
                <a class="nav-link" href="{{ route('collaborators.index') }}" style="font-size: 18px;">
                    <div class="sb-nav-link-icon"><i class="fas fa-users text-info"></i></div>
                    Add Collaborators
                </a>
                 <!-- Add About Us Link -->
                 <a class="nav-link" href="{{ route('about.index') }}" style="font-size: 18px;">
                    <div class="sb-nav-link-icon"><i class="fas fa-info-circle text-info"></i></div>
                    Add About Us
                </a>
                @endif
                <!-- end of admin roles -->  
            </div>
        </div>
</div>

<!-- Add the following styles for responsiveness -->
<style>
    /* Ensure the sidebar is hidden on smaller screens and can toggle */
    #layoutSidenav_nav {
        transition: transform 0.3s ease-in-out;
        position: fixed; /* Fix position for smooth transitions */
        height: 100%;
        left: 0;
        top: 60px;
        width: 250px; /* Fixed width for the sidebar */
        background: #343a40;
        z-index: 1040; /* Ensure it's above other content */
        transform: translateX(-100%); /* Hidden by default on smaller screens */
    }

    #layoutSidenav_nav.active {
        transform: translateX(0); /* Show sidebar when active */
    }

    /* Sidebar toggle button for smaller screens */
    .sidebar-toggle {
        position: fixed;
        top: 70px; /* Adjusted for the navigation bar height */
        left: 15px;
        z-index: 1050;
        background: #343a40;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 10px;
        cursor: pointer;
    }

    /* Adjust content when sidebar is toggled */
    #layoutSidenav_content {
        transition: margin-left 0.3s ease-in-out;
        margin-left: 0;
    }

    #layoutSidenav_nav.active ~ #layoutSidenav_content {
        margin-left: 250px;
    }

    /* Full sidebar on larger screens */
    @media (min-width: 768px) {
        #layoutSidenav_nav {
            transform: translateX(0);
            position: relative;
        }
        .sidebar-toggle {
            display: none; /* Hide toggle button on larger screens */
        }
        #layoutSidenav_content {
            margin-left: 250px;
        }
    }
</style>

<!-- Add a toggle button -->
<button class="sidebar-toggle" onclick="toggleSidebar()">☰ Menu</button>

<!-- JavaScript for toggling sidebar -->
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('layoutSidenav_nav');
        sidebar.classList.toggle('active');
    }
</script>
