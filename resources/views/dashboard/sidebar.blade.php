<div id="layoutSidenav_nav" class="sb-sidenav-container" style="top: 74px; background-color: rgb(18, 56, 81); width: 250px;">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <!-- Sidebar heading -->
            <div class="sb-sidenav-menu-heading" style="background-color: white; color: darkgreen;">
                <u>KESA MAIN MENU</u>
            </div>

            <!-- Dashboard Link -->
            <a class="nav-link" href="{{ route('user-dashboard') }}" style="font-size: 18px;">
                <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                Dashboard
            </a>

            <!-- Admin roles authentication -->
            @if(auth()->user()->hasRole('admin'))

            <!-- Statistics Link -->
            <a class="nav-link" href="{{ route('dashboard') }}" style="font-size: 18px;">
                <div class="sb-nav-link-icon"><i class="fas fa-chart-bar"></i></div>
                Statistics
            </a>

            <!-- Manage Resources -->
            <a class="nav-link" href="{{ route('resources.index') }}" style="font-size: 18px;">
                <div class="sb-nav-link-icon"><i class="fas fa-database"></i></div>
                Manage Resources
            </a>
            <!-- Manage Feedback -->
            <a class="nav-link" href="{{ route('feedback.index') }}" style="font-size: 18px;">
                <div class="sb-nav-link-icon"><i class="fas fa-comments"></i></div>
                Feedbacks
            </a>


            <!-- Manage Tickets -->
            <a class="nav-link" href="{{ route('tickets.index') }}" style="font-size: 18px;">
                <div class="sb-nav-link-icon"><i class="fas fa-ticket-alt"></i></div>
                Manage Tickets
            </a>

            <!-- Manage Events -->
            <a class="nav-link" href="{{ route('events.index') }}" style="font-size: 18px;">
                <div class="sb-nav-link-icon"><i class="fas fa-calendar-alt"></i></div>
                Manage Events
            </a>

            <!-- Manage Users -->
            <a class="nav-link" href="{{ route('users.index') }}" style="font-size: 18px;">
                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
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
                        <a class="dropdown-item" href="{{ route('contact.index') }}">
                            <i class="fas fa-phone"></i> Contact Us
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.slides.index') }}">
                            <i class="fas fa-images"></i> Manage Slideshows
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('collaborators.index') }}">
                            <i class="fas fa-handshake"></i> Add Collaborators
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('send.newsletter') }}">
                            <i class="fas fa-paper-plane"></i> Send Newsletters
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('newsletters.index') }}">
                            <i class="fas fa-newspaper"></i> View Newsletters
                        </a>
                    </li>
                </ul>
            </div>
            @endif
            <!-- End of admin roles -->
        </div>
    </div>
</div>
