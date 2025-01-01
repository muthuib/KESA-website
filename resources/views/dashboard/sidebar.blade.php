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
