<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>{{ config('app.name', 'KESA') }}</title>
   
    <link rel="icon" href="{{ asset('public/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ url('favicon.ico') }}" type="image/x-icon">


    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Quill Editor CDN -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <!-- code for quilli editor for news-->
    @yield('styles')

</head>
<body class="sb-nav-fixed">
    {{-- Include Top Navigation --}}
    @include('dashboard.topnav')
    
    {{-- Sidebar Toggle Button for Small Devices --}}
    @auth
    <button id="sidebarToggle" class="btn btn-primary d-lg-none" 
            style="position: fixed; top: 10px; left: 80px; z-index: 1050;">
        <i class="fas fa-bars"></i> Dashboard
    </button>
@endauth
    {{-- Only logged-in users will see the sidebar --}}
    @auth
    <div id="layoutSidenav" style="display: flex;">
        <!-- Include Sidebar -->
        @include('dashboard.sidebar')
    @endauth
        <!-- Main Content -->
        <div id="layoutSidenav_content" style="flex-grow: 1; overflow-y: auto; top: 100px">
            @auth
                <!-- Start of Alert messages -->
                @if (session('success'))
                <div class="alert alert-success d-flex align-items-center mx-auto" role="alert" style="width: 600px; top: 10px;">
                    <i class="fas fa-check-circle me-2 fs-3 text-success" style="font-size: 1.5rem;"></i>
                    <div style="font-size: 1rem; color: #155724;">
                        {{ session('success') }}
                    </div>
                </div>
                @endif

                @if (session('danger'))
                <div class="alert alert-danger d-flex align-items-center mx-auto" role="alert" style="width: 600px; top: 10px;">
                    <i class="fas fa-times-circle me-2 fs-3 text-danger" style="font-size: 1.5rem;"></i>
                    <div style="font-size: 1rem; color: #721c24;">
                        {{ session('danger') }}
                    </div>
                </div>
                @endif
                @if (session('error'))
                <div class="alert alert-danger d-flex align-items-center mx-auto" role="alert" style="width: 600px; top: 10px;">
                    <i class="fas fa-times-circle me-2 fs-3 text-danger" style="font-size: 1.5rem;"></i>
                    <div style="font-size: 1rem; color: #721c24;">
                        {{ session('error') }}
                    </div>
                </div>
                @endif
            @endauth

                <!-- End of alert message -->
        

            <main>
                <div class="container-fluid px-4">
                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
             <!-- display footer if not fetched through ajax -->
             @if(empty($isAjax))
@guest
<footer class="text-light pt-5 pb-4" style="background-color: rgb(88, 57, 57);">
    <div class="container">
        <div class="row text-center text-lg-start justify-content-lg-center">
            
            <!-- Quick Links Section -->
            <div class="col-lg-2 col-md-6 col-sm-12 mb-4">
                <h5 class="text-uppercase font-weight-bold footer-title">Quick Links</h5>
                <ul class="list-unstyled mt-3">
                    <li><a href="/" class="text-light footer-text">Home</a></li>
                    <li><a href="/about" class="text-light footer-text">About Us</a></li>
                    <li><a href="/services" class="text-light footer-text">Services</a></li>
                    <li><a href="/contact" class="text-light footer-text">Contact</a></li>
                    <li><a href="/faq" class="text-light footer-text">FAQ</a></li>
                </ul>
            </div>

            <!-- Contact Info Section -->
            <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                <h5 class="text-uppercase font-weight-bold footer-title">Contact Us</h5>
                <ul class="list-unstyled mt-3">
                    <li class="footer-text"><i class="fas fa-map-marker-alt"></i> Nairobi, Kenya</li>
                    <li class="footer-text"><i class="fas fa-phone-alt"></i> </li>
                    <li class="footer-text"><i class="fas fa-envelope"></i> admin@kesakenya.org</li>
                </ul>
            </div>

            <!-- Newsletter Section -->
            <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                <h5 class="text-uppercase font-weight-bold footer-title">Newsletter</h5>
                <div class="card shadow-sm w-100">
                    <div class="card-body">
                        <h4 class="card-title text-center mb-4 footer-text">Subscribe to Our Newsletter</h4>
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        <form method="POST" action="{{ route('subscribe') }}">
                            @csrf
                            <div class="form-group">
                                <label for="email" class="form-label footer-text">Your Email Address</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required readonly>
                            </div>
                            <div class="form-group text-center mt-4">
                                <button type="submit" class="btn btn-primary">Subscribe</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Social Media Links -->
            <div class="col-lg-4 col-md-12 col-sm-12 text-center">
                <h5 class="text-uppercase font-weight-bold footer-title">Follow Us</h5>
                <div class="mt-3">
                    <a href="https://www.facebook.com/kesa.kenya?mibextid=ZbWKwL" class="text-light me-3"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://twitter.com/kesa_kenya?t=9VRLpQi_IiXHRdU81n_iLQ&s=09" class="text-light me-3"><img src="/assets/images/x-logo.png" alt="Twitter X" width="17" height="17"></i></a>
                    <a href=" https://www.linkedin.com/company/kenya-economics-students-association/" class="text-light me-3"><i class="fab fa-linkedin-in"></i></a>
                    <a href="https://www.instagram.com/kesa_kenya?igsh=YjcwdXptM254d3Fq" class="text-light"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="text-center mt-4 footer-text" style="color: white;">
            <div>&copy; KESA Kenya. All rights reserved. {{ date('Y') }}</div>
            <div class="mt-2">
                <a href="{{ route('app') }}" class="text-decoration-none text-light"><u>Privacy Policy</u></a>
                &middot;
                <a href="{{ route('app') }}" class="text-decoration-none text-light"><u>Terms & Conditions</u></a>
            </div>
        </div>
    </div>
</footer>


            
        </div>
    </div>
    <!-- end of footer -->
    @endguest
   
     <!-- Footer2 to be vissible only to logged in users -->
 @auth
 <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">&copy; KESA {{ date('Y') }}</div>
                        <div>
                            <a href="{{ route('app') }}" style="font-size: 18px;">Privacy Policy</a>
                            &middot;
                            <a href="{{ route('app') }}" style="font-size: 18px;">Terms & Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
            @endauth
    <!-- end of footer -->
    @endif
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- implements pop up for read more in activities/display -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- code for quilli editor for news -->
@yield('scripts')

</body>
