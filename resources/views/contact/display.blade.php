@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title animate-fade-in" style="margin-top: 80px;">Contact Information</h1>
        @auth
        <a href="{{ route('contact.index') }}" class="btn btn-dark animate-fade-in">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        @endauth
    </div>

    <!-- Check if there are contacts -->
    @if($contacts->isEmpty())
        <div class="alert alert-warning text-center animate-fade-in">No contact added.</div>
    @else
        <div class="row">
            @foreach($contacts as $contact)
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4" style="width: 1500px;">
                <div class="contact-card p-4 border rounded shadow-sm animate-slide-up">
                    
                    <!-- Organization Name -->
                    <h4 class="font-weight-bold text-primary mb-3">
                        <i class="fas fa-building"></i> {{ $contact->organization_name }}
                    </h4>

                    <!-- Contact Details -->
                    <p><strong><i class="fas fa-envelope"></i> Email:</strong> 
                        <a href="mailto:{{ $contact->email }}" class="text-decoration-none">{{ $contact->email ?: 'No email available' }}</a>
                    </p>
                    
                    <p><strong><i class="fas fa-phone"></i> Phone:</strong> 
                        <a href="tel:{{ $contact->phone }}" class="text-decoration-none">{{ $contact->phone ?: 'No phone available' }}</a>
                    </p>

                    <p><strong><i class="fas fa-map-marker-alt"></i> Address:</strong> 
                        {{ $contact->address ?: 'No address available' }}
                    </p>

                    <!-- Social Links -->
                    @if($contact->socialLinks->isNotEmpty())
                        <div class="mt-3">
                            <h6 class="text-secondary"><i class="fas fa-globe"></i> Social Media</h6>
                            <ul class="list-unstyled">
                                @foreach($contact->socialLinks as $socialLink)
                                    <li>
                                        <strong>{{ $socialLink->platform }}:</strong>
                                        <a href="{{ $socialLink->url }}" target="_blank" class="text-primary">{{ $socialLink->url }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <p class="text-muted"><i class="fas fa-times-circle"></i> No social media links available.</p>
                    @endif

                    <!-- Additional Contacts -->
                    @if($contact->additionalContacts->isNotEmpty())
                        <div class="mt-3">
                            <h6 class="text-secondary"><i class="fas fa-user-friends"></i> Additional Contacts</h6>
                            <ul class="list-unstyled">
                                @foreach($contact->additionalContacts as $additionalContact)
                                    <li>
                                        <strong>{{ $additionalContact->type }}:</strong> 
                                        {{ $additionalContact->detail }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <p class="text-muted"><i class="fas fa-times-circle"></i> No additional contacts available.</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@section('styles')
<style>
    .page-title {
        font-size: 2rem;
        font-weight: bold;
        animation: fadeIn 1s ease-in-out;
    }

    /* Contact Card Styling */
    .contact-card {
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        opacity: 0;
        animation: slideUp 0.7s ease-out forwards;
    }

    .contact-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .contact-card h4 {
        font-size: 1.6rem;
        color: #007bff;
    }

    .contact-card p {
        font-size: 1.1rem;
        margin-bottom: 10px;
    }

    .contact-card a {
        text-decoration: none;
        color: #007bff;
        font-weight: 500;
    }

    .contact-card a:hover {
        text-decoration: underline;
    }

    .contact-card .list-unstyled {
        padding-left: 20px;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .page-title {
            font-size: 1.75rem;
        }

        .contact-card h4 {
            font-size: 1.4rem;
        }

        .contact-card p {
            font-size: 1rem;
        }
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 1.5rem;
            text-align: center;
        }

        .contact-card {
            padding: 20px;
        }

        .contact-card h4 {
            font-size: 1.3rem;
        }

        .contact-card p {
            font-size: 0.95rem;
        }
    }

    @media (max-width: 576px) {
        .page-title {
            font-size: 1.4rem;
        }

        .contact-card {
            padding: 15px;
        }

        .contact-card h4 {
            font-size: 1.2rem;
        }

        .contact-card p {
            font-size: 0.9rem;
        }
    }
</style>
@endsection
