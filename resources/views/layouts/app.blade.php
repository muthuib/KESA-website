<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Set the viewport for responsive design -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>{{ config('app.name', 'KESA') }}</title>
    <!-- Include Simple DataTables and custom styles -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <!-- Include Font Awesome for icons -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Include Bootstrap CSS for responsive grid and utility classes -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="sb-nav-fixed">
    {{-- Include Top Navigation --}}
    @include('dashboard.topnav')

    {{-- Only logged-in users will see the sidebar --}}
    @auth
    <div id="layoutSidenav" class="d-flex">
        <!-- Sidebar is wrapped in a container with Bootstrap flex class for layout responsiveness -->
        @include('dashboard.sidebar')
    @endauth
        <!-- Main content area -->
        <div id="layoutSidenav_content" class="flex-grow-1 overflow-auto" style="top: 80px;">
            @auth
                <!-- Responsive alert messages -->
                @if (session('success'))
                <div class="alert alert-success d-flex align-items-center mx-auto my-2" role="alert" 
                     style="max-width: 90%; width: 600px;">
                    <!-- Use icons with responsive sizing -->
                    <i class="fas fa-check-circle me-2 fs-4 text-success"></i>
                    <div style="font-size: 1rem; color: #155724;">
                        {{ session('success') }}
                    </div>
                </div>
                @endif

                @if (session('danger'))
                <div class="alert alert-danger d-flex align-items-center mx-auto my-2" role="alert" 
                     style="max-width: 90%; width: 600px;">
                    <i class="fas fa-times-circle me-2 fs-4 text-danger"></i>
                    <div style="font-size: 1rem; color: #721c24;">
                        {{ session('danger') }}
                    </div>
                </div>
                @endif
            @endauth

            <!-- Main container for dynamic content -->
            <main>
                <div class="container-fluid px-4">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    <!-- Footer Section -->
<footer class="bg- text-light pt-5 pb-4" style="background-color: brown;">
    <div class="container">
        <div class="row">
            <!-- About Us Section -->
            <div class="col-lg-4 col-md-6 mb-4">
                <h5 class="text-uppercase font-weight-bold">About Us</h5>
                <p class="mt-3">
                KESA is a Premier National Economics Scholars Association that unites Economics, Business, and Statistics Stakeholders and Passionate Associate members from other backgrounds from various universities, colleges, and Technical, Vocational Education, and Training Institutions in Kenya.
                </p>
                        <p class="mt-3">
                Our vision is to nurture a generation of well-informed and influential contributors to the global economic landscape.
                    </p>
                    <p class="mt-3">
                To achieve this, we are guided by our mission of striving to build a conscious society capable of participating and making effective decisions rationally to keep pace with changes and economic challenges, and exploit opportunities through support with a set of career-enhancing programs and services.
                </p>
            </div>

            <!-- Quick Links Section -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="text-uppercase font-weight-bold">Quick Links</h5>
                <ul class="list-unstyled mt-3">
                    <li><a href="/" class="text-light">Home</a></li>
                    <li><a href="/about" class="text-light">About Us</a></li>
                    <li><a href="/services" class="text-light">Services</a></li>
                    <li><a href="/contact" class="text-light">Contact</a></li>
                    <li><a href="/faq" class="text-light">FAQ</a></li>
                </ul>
            </div>

            <!-- Contact Info Section -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="text-uppercase font-weight-bold">Contact Us</h5>
                <ul class="list-unstyled mt-3">
                    <li><i class="fas fa-map-marker-alt"></i> 123 Street Name, City, Kenya</li>
                    <li><i class="fas fa-phone-alt"></i> +254700000000</li>
                    <li><i class="fas fa-envelope"></i> info@example.com</li>
                </ul>
            </div>

            <!-- Newsletter Section -->
            <div class="col-lg-3 col-md-6 mb-4">
                <!-- Newsletter Subscription Section -->
                <h5 class="text-uppercase font-weight-bold">Newsletter</h5>
                    <div class="row justify-content-left">
                        <div class="col-md-6">
                            <div class="card shadow-sm" style="margin-top: 0px; width: 350px;">
                                <div class="card-body">
                                    <h4 class="card-title text-center mb-4" style="font-size: 20px;">Subscribe to Our Newsletter</h4>
                                    
                                    <!-- Display error message if email is already subscribed -->
                                    @if(session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    
                                    <form method="POST" action="{{ route('subscribe') }}">
                                        @csrf
                                        <div class="form-group">
                                            <label for="email" class="form-label">Your Email Address</label>
                                            <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                                        </div>
                                        <div class="form-group text-center mt-4">
                                            <button type="submit" class="btn btn-primary">Subscribe</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Social Media Links -->
                <div class="mt-4">
                    <a href="#" class="text-light me-3"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-light me-3"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-light me-3"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="text-light"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>

        <!-- Footer Bottom -->
        <div class="text-center mt-4">
            <p class="mb-0">&copy; 2024 Kenya Economics Students Association. All rights reserved.</p>
        </div>
        <!-- Use responsive font sizes -->
        <div>
            <a href="{{ route('app') }}" class="text-decoration-none bg-primary" style="font-size: 18px; margin-left: 1200px;color:white;"><u>Privacy Policy</u></a>
            &middot;
            <a href="{{ route('app') }}" class="text-decoration-none bg-primary" style="font-size: 18px;color:white;"><u>Terms & Conditions</u></a>
        </div>
</footer>

    <!-- Scripts -->
    <!-- Include Bootstrap JS for responsiveness and interactivity -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
    <!-- Include Bootstrap CSS for responsive grid -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
