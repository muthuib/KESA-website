<div id="layoutSidenav_nav" class="sb-sidenav-container" style="top: 60px; background-color:rgb(18, 56, 81); width: 250px;">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <!-- Sidebar heading -->
            <div class="sb-sidenav-menu-heading" style="background-color: white; color: darkgreen;"><u>KESA MAIN MENU</u></div>
             <!-- Dashboard Link -->
             <a class="nav-link" href="{{ route('user-dashboard') }}" style="font-size: 18px;">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
               Dashboard
            </a>
            <!-- Admin roles authentication -->
            @if(auth()->user()->hasRole('admin'))
             <!-- Statistics Link -->
             <a class="nav-link" href="{{ route('dashboard') }}" style="font-size: 18px;">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
               Statistics
            </a>
                <a class="nav-link" href="{{ route('resources.index') }}" style="font-size: 18px;">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Manage Resources
                </a>
                <a class="nav-link" href="{{ route('tickets.index') }}" style="font-size: 18px;">
                    <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list text-light"></i></div>
                    Manage Tickets
                </a>

                <a class="nav-link" href="{{ route('users.index') }}" style="font-size: 18px;">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-circle text-light"></i></div>
                    Manage Users
                </a>


                 <!-- Dropdown Menu for System Settings -->
                 <div class="nav-link dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="systemSettingsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 18px;">
                        <div class="sb-nav-link-icon"><i class="fas fa-cogs"></i></div>
                        System Settings
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="systemSettingsDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('about.index') }}">
                                <i class="fas fa-info-circle"></i> Add About Us
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.slides.index') }}">
                                <i class="fas fa-images"></i> Manage Slideshows
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('collaborators.index') }}">
                                <i class="fas fa-images"></i>  Add Collaborators
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('send.newsletter') }}">
                                <i class="fas fa-images"></i>   Sent Newsletters
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('newsletters.index') }}">
                                <i class="fas fa-images"></i>  View Newsletters
                            </a>
                        </li>
                    </ul>
                </div>
            @endif
            <!-- End of admin roles -->
        </div>
    </div>
</div>