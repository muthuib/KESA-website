<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <!-- START OF SIDEBAR NAVIGATION TABS -->
                         <!-- dashbord navigation -->
                        <a href="{{ route('app') }}" class="nav-link" style="font-size: 18px;">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>Dashboard
                        </a>
                        <!-- end of dashboard navigation -->

                        <!-- resource navigation -->
                        <a href="{{ route('create') }}" class="nav-link" style="font-size: 18px;">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>Resources
                        </a>
                        <!-- end of resource navigation -->

                        <div class="sb-sidenav-menu-heading">Interface</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Layouts
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a href="{{ route('app') }}" class="nav-link" style="font-size: 18px;">Static
                                    Navigation</a>
                                <a href="{{ route('app') }}" class="nav-link" style="font-size: 18px;">Light Sidenav</a>
                            </nav>
                        </div>

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages"
                            aria-expanded="false" aria-controls="collapsePages">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            Pages
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePages" aria-labelledby="headingTwo"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    data-bs-target="#pagesCollapseAuth" aria-expanded="false"
                                    aria-controls="pagesCollapseAuth">
                                    Authentication
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a href="{{ route('app') }}" class="nav-link" style="font-size: 18px;">Login</a>
                                        <a href="{{ route('app') }}" class="nav-link"
                                            style="font-size: 18px;">Register</a>
                                        <a href="{{ route('app') }}" class="nav-link" style="font-size: 18px;">Forgot
                                            Password</a>
                                    </nav>
                                </div>
                            </nav>
                        </div>
                        <div class="sb-sidenav-menu-heading">Addons</div>
                        <a href="{{ route('app') }}" class="nav-link" style="font-size: 18px;">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Charts
                        </a>
                        <a href="{{ route('app') }}" class="nav-link" style="font-size: 18px;">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Tables
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <!-- Alert  welcome message when successfully logged in -->
                @if (session('success'))
                <div class="alert alert-success mx-auto"
                    style="max-width: 800px; margin-top: 20px; text-align: center;">
                    {{ session('success') }}
                </div>
                @endif
                <!-- end of welcome alert code -->
        </div>
    </div>
</body>

</html>