 <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="{{ route('user-dashboard') }}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->
     @if(!auth()->user()->hasRole('admin'))
          <!--  Careers -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('careers.index') }}">
          <i class="bi bi-briefcase"></i>
          <span>Career opportunities</span>
        </a>
      </li><!-- End careers Nav -->
       <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('careers.myApplications') }}">
          <i class="bi bi-list-check"></i>
          <span>My Applications</span>
        </a>
      </li><!-- End my applications Nav -->
      @endif

<!-- Admin roles authentication -->
   @if(auth()->user()->hasRole('admin'))
   <!-- statistics -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('dashboard') }}">
          <i class="fas fa-chart-bar"></i>
          <span>Statistics</span>
        </a>
      </li><!-- End Statistics Nav -->

     <!-- Dropdown Menu for Resource Hub -->
    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Resource Hub</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('publications.index') }}">
              <i class="bi bi-circle"></i><span>Publications</span>
            </a>
          </li>
          <li>
            <a href="{{ route('feedback.index') }}">
              <i class="bi bi-circle"></i><span>Feedbacks</span>
            </a>
          </li>
        </ul>
      </li><!-- end of resource hub -->

        <!-- Dropdown Menu for Manage events -->
         <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
              <i class="bi bi-journal-text"></i><span>Manage Events</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
              <li>
                <a href="{{ route('events.index') }}">
                  <i class="bi bi-circle"></i><span>Upcoming Events</span>
                </a>
              </li>
              <li>
                <a href="{{ route('activities.index') }}">
                  <i class="bi bi-circle"></i><span>Past Events</span>
                </a>
              </li>
              <li>
                <a href="{{ route('live-events.index') }}">
                  <i class="bi bi-circle"></i><span>Live Events</span>
                </a>
              </li>
            </ul>
        </li>    <!-- end of manage events hub -->

        <!-- Manage News -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('news.index') }}">
          <i class="bi bi-card-list"></i>
          <span>Manage News</span>
        </a>
      </li><!-- End manage news Nav -->

      <!-- Manage blogs -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('blog.index') }}">
          <i class="bi bi-gem"></i>
          <span>Manage Blogs</span>
        </a>
      </li><!-- End Manage blogs Nav -->
       <!-- Manage Careers -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('admin.careers.index') }}">
          <i class="bi bi-briefcase"></i>
          <span>Manage Careers</span>
        </a>
      </li><!-- End Manage careers Nav -->

      <!-- Manage Testimonials -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('testimonials.index') }}">
          <i class="bi bi-person"></i>
          <span>Manage Testimonials</span>
        </a>
      </li><!-- End manage testimonials Nav -->

   <!-- System Settings dropdown -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>System Settings</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('about.index') }}">
              <i class="bi bi-circle"></i><span>About Us</span>
            </a>
          </li>
          <li>
            <a href="{{ route('contact.index') }}">
              <i class="bi bi-circle"></i><span>Contact</span>
            </a>
          </li>
          <li>
            <a href="{{ route('admin.slides.index') }}">
              <i class="bi bi-circle"></i><span>Manage Slideshows</span>
            </a>
          </li>
            <li>
            <a href="{{ route('collaborators.index') }}">
              <i class="bi bi-circle"></i><span>Add Collaborators</span>
            </a>
          </li>
          <li>
            <a href="{{ route('memberships.index') }}">
              <i class="bi bi-circle"></i><span>Add Memberships</span>
            </a>
          </li>
          <li>
            <a href="{{ route('newsletters.index') }}">
              <i class="bi bi-circle"></i><span>Manage Newsletters</span>
            </a>
          </li>
          <li>
            <a href="{{ route('impacts.index') }}">
              <i class="bi bi-circle"></i><span>Manage Impact stats</span>
            </a>
          </li>
        </ul>
      </li><!-- End Tables Nav -->

         <!-- Manage Users -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('users.index') }}">
          <i class="bi bi-people"></i>
          <span>Manage Users</span>
        </a>
      </li><!-- End manage Users Nav -->

   @endif
  </aside><!-- End Sidebar-->