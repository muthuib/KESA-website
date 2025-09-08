@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-5 animate-fade-in">
        <h1 class="page-title" style="margin-top: 70px;">Contact Information</h1>
        @auth
        <a href="{{ route('contact.index') }}" class="btn btn-outline-primary shadow-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        @endauth
    </div>

    @if($contacts->isEmpty())
        <div class="alert alert-warning text-center animate-fade-in">
            No contact added.
        </div>
    @else
        <div class="row">
            @foreach($contacts as $contact)
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="contact-card p-4 animate-slide-up">
                    <h4 class="text-primary mb-3">
                        <i class="fas fa-building me-2"></i>{{ $contact->organization_name }}
                    </h4>

                    <p><i class="fas fa-envelope text-danger me-2"></i><strong>Email:</strong> 
                        <a href="mailto:{{ $contact->email }}">{{ $contact->email ?: 'No email available' }}</a>
                    </p>

                    <p><i class="fas fa-phone text-success me-2"></i><strong>Phone:</strong> 
                        <a href="tel:{{ $contact->phone }}">{{ $contact->phone ?: 'No phone available' }}</a>
                    </p>

                    <p><i class="fas fa-map-marker-alt text-info me-2"></i><strong>Address:</strong> 
                        {{ $contact->address ?: 'No address available' }}
                    </p>

                    <!-- Social Links -->
                    <div class="mt-4">
                        <h6 class="text-uppercase text-secondary fw-bold mb-2">Follow Us</h6>
                        <div class="d-flex gap-3">
                            <a href="https://www.facebook.com/kesa.kenya?mibextid=ZbWKwL" class="social-icon facebook" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://twitter.com/kesa_kenya?t=9VRLpQi_IiXHRdU81n_iLQ&s=09" class="text-light me-3"><img src="/assets/images/x-logo.png" alt="Twitter X" width="30" height="30" style="margin-top: 5px;"></i></a>
                            <a href="https://www.linkedin.com/company/kenya-economics-students-association/" class="social-icon linkedin" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                            <a href="https://www.instagram.com/kesa_kenya?igsh=YjcwdXptM254d3Fq" class="social-icon instagram" target="_blank"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>

                    <!-- Additional Contacts -->
                    @if($contact->additionalContacts->isNotEmpty())
                    <div class="mt-4">
                        <h6 class="text-secondary"><i class="fas fa-user-friends me-1"></i> Additional Contacts</h6>
                        <ul class="list-unstyled ms-2">
                            @foreach($contact->additionalContacts as $additionalContact)
                                <li><strong>{{ $additionalContact->type }}:</strong> {{ $additionalContact->detail }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @else
                        <p class="text-muted mt-3"><i class="fas fa-times-circle me-1"></i> No additional contacts available.</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@section('styles')
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    .page-title {
        font-size: 2.2rem;
        font-weight: 700;
        color: #212529;
        animation: fadeIn 1s ease-in-out;
    }

    .contact-card {
        background: #ffffff;
        border-radius: 15px;
        border: 1px solid #e0e0e0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        opacity: 0;
        animation: slideUp 0.7s ease forwards;
    }

    .contact-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 24px rgba(0,0,0,0.1);
    }

    .contact-card a {
        color: #007bff;
        text-decoration: none;
        font-weight: 500;
    }

    .contact-card a:hover {
        text-decoration: underline;
    }

    .social-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        font-size: 1.2rem;
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

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .page-title {
            font-size: 1.8rem;
            text-align: center;
        }
        .contact-card {
            padding: 1.5rem;
        }
    }

    @media (max-width: 576px) {
        .page-title {
            font-size: 1.5rem;
        }
        .social-icon {
            width: 35px;
            height: 35px;
            font-size: 1rem;
        }
    }
</style>
@endsection
