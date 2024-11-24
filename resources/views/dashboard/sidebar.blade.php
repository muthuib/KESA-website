<!-- sidebar.blade.php -->
<div id="layoutSidenav_nav" style="top: 60px;">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="{{ route('app') }}" style="font-size: 18px;">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <a class="nav-link" href="{{ route('resources.index') }}" style="font-size: 18px;">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Manage Resources
                </a>
                <!-- Manage slides tab -->
                <a class="nav-link" href="{{ route('admin.slides.index') }}" style="font-size: 18px;">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Manage slideshows
                </a>
                <!-- end of slides tab -->
                <div class="sb-sidenav-menu-heading">Interface</div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts" style="font-size: 18px;">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Layouts
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('app') }}" style="font-size: 18px;">Static Navigation</a>
                        <a class="nav-link" href="{{ route('app') }}" style="font-size: 18px;">Light Sidenav</a>
                    </nav>
                </div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages" style="font-size: 18px;">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Pages
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('app') }}" style="font-size: 18px;">Login</a>
                        <a class="nav-link" href="{{ route('app') }}" style="font-size: 18px;">Register</a>
                        <a class="nav-link" href="{{ route('app') }}" style="font-size: 18px;">Forgot Password</a>
                    </nav>
                </div>
                <div class="sb-sidenav-menu-heading">Addons</div>
                <a class="nav-link" href="{{ route('app') }}" style="font-size: 18px;">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Charts
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            Start Bootstrap
        </div>
    </nav>
</div>
