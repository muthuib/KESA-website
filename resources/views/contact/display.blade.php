@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 70px;">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Contact Information</h1>
        @auth
        <a href="{{ route('contact.index') }}" class="btn btn-dark">
            <i class="fas fa-backward"></i> Back
        </a>
        @endauth
    </div>

    <!-- Display all contacts -->
    <div class="row" style="width: 4200px;">
        @foreach($contacts as $contact)
        <div class="col-md-4 mb-4">
            <div class="contact-card p-4 border rounded shadow-sm bg-light">
                <h4 class="font-weight-bold text-primary">{{ $contact->organization_name }}</h4>

                <!-- Contact Details -->
                <div class="mt-3">
                    <p><strong><i class="fas fa-envelope"></i> Email:</strong> 
                        <a href="mailto:{{ $contact->email }}" class="text-decoration-none">{{ $contact->email }}</a>
                    </p>
                    <p><strong><i class="fas fa-phone"></i> Phone:</strong> 
                        <a href="tel:{{ $contact->phone }}" class="text-decoration-none">{{ $contact->phone }}</a>
                    </p>
                    <p><strong><i class="fas fa-map-marker-alt"></i> Address:</strong> 
                        {{ $contact->address ?? 'N/A' }}
                    </p>
                </div>

                <!-- Social Links -->
                @if($contact->socialLinks->isNotEmpty())
                    <div class="mt-3">
                        <h5 class="text-secondary">Social Media Links</h5>
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
                    <p class="text-muted">No social media links available.</p>
                @endif

                <!-- Additional Contacts -->
                @if($contact->additionalContacts->isNotEmpty())
                    <div class="mt-3">
                        <h5 class="text-secondary">Additional Contacts</h5>
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
                    <p class="text-muted">No additional contacts available.</p>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('styles')
<style>
    .contact-card {
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .contact-card h4 {
        color: #007bff;
        font-size: 1.5rem;
        margin-bottom: 15px;
    }

    .contact-card p {
        font-size: 1rem;
        margin-bottom: 10px;
    }

    .contact-card a {
        text-decoration: none;
    }

    .contact-card a:hover {
        text-decoration: underline;
    }

    .contact-card .list-unstyled {
        padding-left: 20px;
    }
</style>
@endsection
