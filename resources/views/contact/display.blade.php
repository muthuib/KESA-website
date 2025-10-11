@extends('layouts.app')

@section('content')

<div class="pagetitle">
    <h1 class="mt-5 d-flex align-items-center gap-3">
        Contact Us
        <a href="https://www.facebook.com/kesa.kenya?mibextid=ZbWKwL" class="social-icon facebook" target="_blank">
            <i class="fab fa-facebook-f"></i>
        </a>
        <a href="https://twitter.com/kesa_kenya?t=9VRLpQi_IiXHRdU81n_iLQ&s=09" class="social-icon twitter" target="_blank">
            <img src="/assets/images/x-logo.png" alt="Twitter X" width="20" height="20">
        </a>
        <a href="https://www.linkedin.com/company/kenya-economics-students-association/" class="social-icon linkedin" target="_blank">
            <i class="fab fa-linkedin-in"></i>
        </a>
        <a href="https://www.instagram.com/kesa_kenya?igsh=YjcwdXptM254d3Fq" class="social-icon instagram" target="_blank">
            <i class="fab fa-instagram"></i>
        </a>
    </h1>
</div><!-- End Page Title -->

<section class="section contact">
    @foreach($contacts as $contact)
    <div class="row gy-4">

        <div class="col-xl-6">
            <div class="row">
                <div class="col-lg-6">
                    <div class="info-box card">
                        <i class="bi bi-geo-alt"></i>
                        <h3>Address</h3>
                        <p>{{ $contact->address ?: 'Nairobi, Kenya' }}</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="info-box card">
                        <i class="bi bi-telephone"></i>
                        <h3>Call Us</h3>
                        <p><a href="tel:{{ $contact->phone }}">{{ $contact->phone ?: 'No phone available' }}</a></p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="info-box card">
                        <i class="bi bi-envelope"></i>
                        <h3>Email Us</h3>
                        <p><a href="mailto:{{ $contact->email }}">{{ $contact->email ?: 'No email available' }}</a></p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="info-box card">
                        <i class="bi bi-clock"></i>
                        <h3>Open Hours</h3>
                        <p>Monday - Friday<br>9:00AM - 05:00PM</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 🗺️ Google Map Section -->
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="ratio ratio-16x9">
                    <iframe
                        src="https://www.google.com/maps?q={{ urlencode($contact->address ?: 'Nairobi, Kenya') }}&output=embed"
                        width="100%"
                        height="400"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>

    </div>
    @endforeach
</section>

<style>
    .social-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 25px;
        height: 25px;
        font-size: 0.8rem;
        border-radius: 50%;
        color: #fff;
        transition: background-color 0.3s, transform 0.3s;
    }
    .social-icon:hover {
        transform: scale(1.1);
    }
    .facebook { background-color: #3b5998; }
    .twitter { background-color: #1da1f2; }
    .linkedin { background-color: #0077b5; }
    .instagram { background: radial-gradient(circle at 30% 30%, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); }

    .info-box.card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .info-box.card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    @media (max-width: 768px) {
        .pagetitle h1 {
            font-size: 1.6rem;
            flex-wrap: wrap;
            justify-content: center;
        }
    }
</style>

@endsection
