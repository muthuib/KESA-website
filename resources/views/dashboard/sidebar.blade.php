<div id="layoutSidenav_nav" class="sb-sidenav-container" style="background-color: rgb(18, 56, 81); width: 250px; margin-top: 100px;">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <!-- Sidebar heading -->
            <div class="sb-sidenav-menu-heading" style="background-color: white; color: darkgreen; padding: 5px 10px; margin-bottom: 5px;">
                <u>KESA MAIN MENU</u>
            </div>

            <!-- Dashboard Link -->
            <a class="nav-link" href="{{ route('user-dashboard') }}" style="font-size: 18px; padding: 6px 8px; margin: 2px 0; display: flex; align-items: center;">
                <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                Dashboard
            </a>

            <!-- Admin roles authentication -->
            @if(auth()->user()->hasRole('admin'))

            <!-- Statistics Link -->
            <a class="nav-link" href="{{ route('dashboard') }}" style="font-size: 18px; padding: 6px 8px; margin: 2px 0; display: flex; align-items: center;">
                <div class="sb-nav-link-icon"><i class="fas fa-chart-bar"></i></div>
                Statistics
            </a>

            <!-- Dropdown Menu for Resource Hub -->
            <div class="nav-link dropdown" style="margin: 2px 0;">
                <a class="nav-link dropdown-toggle" href="#" id="systemSettingsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" 
                   style="font-size: 18px; padding: 6px 8px; display: flex; align-items: center;">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Resource Hub
                </a>
                <ul class="dropdown-menu" aria-labelledby="systemSettingsDropdown" style="padding: 5px;">
                    <li>
                        <a class="nav-link" href="{{ route('publications.index') }}" style="font-size: 18px; color: black; padding: 5px 8px; margin-bottom: 1px;">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            Publications
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ route('activities.index') }}" style="font-size: 18px; color: black; padding: 5px 8px; margin-bottom: 1px;">
                            <div class="sb-nav-link-icon"><i class="fas fa-calendar-alt"></i></div>
                           Past events
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ route('feedback.index') }}" style="font-size: 18px; color: black; padding: 5px 8px; margin-bottom: 1px;">
                            <div class="sb-nav-link-icon"><i class="fas fa-comments"></i></div>
                            Feedbacks
                        </a>
                    </li>
                </ul>
            </div>

          <!-- Manage Events Dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="manageEventsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 18px; padding: 6px 8px; margin: 2px 0; display: flex; align-items: center;">
                <div class="sb-nav-link-icon"><i class="fas fa-calendar-alt"></i></div>
                Manage Events
            </a>
            <ul class="dropdown-menu" aria-labelledby="manageEventsDropdown">
                <li>
                    <a class="dropdown-item" href="{{ route('events.index') }}">
                        <i class="fas fa-calendar-check"></i> Upcoming Events
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('live-events.index') }}">
                        <i class="fas fa-broadcast-tower"></i> Live Events
                    </a>
                </li>
            </ul>
        </li>
            <!-- Manage Users -->
            <a class="nav-link" href="{{ route('users.index') }}" style="font-size: 18px; padding: 6px 8px; margin: 2px 0; display: flex; align-items: center;">
                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                Manage Users
            </a>

            <!-- Dropdown Menu for System Settings -->
            <div class="nav-link dropdown" style="margin: 2px 0;">
                <a class="nav-link dropdown-toggle" href="#" id="systemSettingsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" 
                   style="font-size: 18px; padding: 6px 8px; display: flex; align-items: center;">
                    <div class="sb-nav-link-icon"><i class="fas fa-cogs"></i></div>
                    System Settings
                </a>
                <ul class="dropdown-menu" aria-labelledby="systemSettingsDropdown" style="padding: 5px;">
                    <li><a class="dropdown-item" href="{{ route('about.index') }}" style="padding: 5px 10px;"><i class="fas fa-info-circle"></i> About Us</a></li>
                    <li><a class="dropdown-item" href="{{ route('contact.index') }}" style="padding: 5px 10px;"><i class="fas fa-phone"></i> Contact Us</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.slides.index') }}" style="padding: 5px 10px;"><i class="fas fa-images"></i> Manage Slideshows</a></li>
                    <li><a class="dropdown-item" href="{{ route('collaborators.index') }}" style="padding: 5px 10px;"><i class="fas fa-handshake"></i> Add Collaborators</a></li>
                    <li><a class="dropdown-item" href="{{ route('memberships.index') }}" style="padding: 5px 10px;"><i class="fas fa-handshake"></i> Add Memberships</a></li>
                    <li><a class="dropdown-item" href="{{ route('send.newsletter') }}" style="padding: 5px 10px;"><i class="fas fa-paper-plane"></i> Send Newsletters</a></li>
                    <li><a class="dropdown-item" href="{{ route('newsletters.index') }}" style="padding: 5px 10px;"><i class="fas fa-newspaper"></i> View Newsletters</a></li>
                </ul>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
      #layoutSidenav_nav {
        margin-top: 100px;
        width: 250px;
    }
    @media (max-width: 992px) { /* Adjust for small & medium screens */
    #layoutSidenav_nav {
        margin-top: 78px !important;
        width: 220px !important;
    }
}

</style>