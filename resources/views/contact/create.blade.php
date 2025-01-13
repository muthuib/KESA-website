@extends('layouts.app')

@section('content')
<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Card Header with Back Button -->
    <div class="card shadow-lg mb-4" style="width: 1000px;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Create Contact and Related Details</h3>
            <a href="{{ route('contact.index') }}" class="btn btn-dark">
                <i class="fas fa-backward"></i> Back
            </a>
        </div>

        <!-- Card Body -->
        <div class="card-body">
            <form action="{{ route('contact.store') }}" method="POST">
                @csrf

                <!-- Contact Details -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white">Contact Details</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="organization_name" class="form-label">Organization Name</label>
                            <input type="text" name="organization_name" id="organization_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea name="address" id="address" class="form-control"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Social Links -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-success text-white">Social Media Links</div>
                    <div class="card-body" id="social-links-section">
                        @for($i = 0; $i < 5; $i++)
                            <div class="social-link-item mb-3">
                                <label for="platform_{{ $i }}" class="form-label">Platform</label>
                                <input type="text" name="social_links[{{ $i }}][platform]" id="platform_{{ $i }}" class="form-control mb-2" placeholder="e.g., Facebook">
                                <label for="url_{{ $i }}" class="form-label">URL</label>
                                <input type="url" name="social_links[{{ $i }}][url]" id="url_{{ $i }}" class="form-control" placeholder="e.g., https://facebook.com/example">
                            </div>
                        @endfor
                    </div>
                    <!-- <button type="button" id="add-social-link" class="btn btn-outline-success">
                        <i class="fas fa-plus"></i> Add Social Link
                    </button> -->
                </div>

                <!-- Additional Contacts -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-info text-white">Additional Contacts</div>
                    <div class="card-body" id="additional-contacts-section">
                        @for($i = 0; $i < 5; $i++)
                            <div class="additional-contact-item mb-3">
                                <label for="type_{{ $i }}" class="form-label">Contact Type</label>
                                <input type="text" name="additional_contacts[{{ $i }}][type]" id="type_{{ $i }}" class="form-control mb-2" placeholder="e.g., Support Desk">
                                <label for="detail_{{ $i }}" class="form-label">Details</label>
                                <textarea name="additional_contacts[{{ $i }}][detail]" id="detail_{{ $i }}" class="form-control" placeholder="e.g., Phone: +123456789"></textarea>
                            </div>
                        @endfor
                    </div>
                    <!-- <button type="button" id="add-additional-contact" class="btn btn-outline-info">
                        <i class="fas fa-plus"></i> Add Additional Contact
                    </button> -->
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Contact
                    </button>
                    <a href="{{ route('contact.index') }}" class="btn btn-danger">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let socialLinkIndex = 2; // Start index for additional social links
    let additionalContactIndex = 2; // Start index for additional contacts

    // Add Social Link dynamically
    document.getElementById('add-social-link').addEventListener('click', function() {
        const section = document.getElementById('social-links-section');
        const newSocialLink = `
            <div class="social-link-item mb-3">
                <label for="platform_${socialLinkIndex}" class="form-label">Platform</label>
                <input type="text" name="social_links[${socialLinkIndex}][platform]" id="platform_${socialLinkIndex}" class="form-control mb-2" placeholder="e.g., Twitter">
                <label for="url_${socialLinkIndex}" class="form-label">URL</label>
                <input type="url" name="social_links[${socialLinkIndex}][url]" id="url_${socialLinkIndex}" class="form-control" placeholder="e.g., https://twitter.com/example">
            </div>
        `;
        section.insertAdjacentHTML('beforeend', newSocialLink);
        socialLinkIndex++;
    });

    // Add Additional Contact dynamically
    document.getElementById('add-additional-contact').addEventListener('click', function() {
        const section = document.getElementById('additional-contacts-section');
        const newAdditionalContact = `
            <div class="additional-contact-item mb-3">
                <label for="type_${additionalContactIndex}" class="form-label">Contact Type</label>
                <input type="text" name="additional_contacts[${additionalContactIndex}][type]" id="type_${additionalContactIndex}" class="form-control mb-2" placeholder="e.g., Branch Office">
                <label for="detail_${additionalContactIndex}" class="form-label">Details</label>
                <textarea name="additional_contacts[${additionalContactIndex}][detail]" id="detail_${additionalContactIndex}" class="form-control" placeholder="e.g., Address: 123 Main St"></textarea>
            </div>
        `;
        section.insertAdjacentHTML('beforeend', newAdditionalContact);
        additionalContactIndex++;
    });
</script>
@endsection
