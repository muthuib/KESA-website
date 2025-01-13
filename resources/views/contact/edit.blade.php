@extends('layouts.app')

@section('content')
<div class="container"  style="width: 1000px; margin-left: 0px;">
    <!-- Page Header with Back Button -->
    <div class="card shadow-lg mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Edit Contact</h3>
            <a href="{{ route('contact.index') }}" class="btn btn-dark">
                <i class="fas fa-backward"></i> Back
            </a>
        </div>
    </div>

    <!-- Card Body -->
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('contact.update', $contact->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Contact Details -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">Contact Details</div>
                    <div class="card-body">
                        @include('contact.partials.contact-details', ['contact' => $contact])
                    </div>
                </div>

                <!-- Social Media Links -->
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">Social Media Links</div>
                    <div class="card-body" id="social-links-section">
                        @include('contact.partials.social-links', ['socialLinks' => $contact->socialLinks])
                    </div>
                    <!-- <button type="button" id="add-social-link" class="btn btn-outline-success mt-3">
                        <i class="fas fa-plus"></i> Add Social Link
                    </button> -->
                </div>

                <!-- Additional Contacts -->
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">Additional Contacts</div>
                    <div class="card-body" id="additional-contacts-section">
                        @include('contact.partials.additional-contacts', ['additionalContacts' => $contact->additionalContacts])
                    </div>
                    <!-- <button type="button" id="add-additional-contact" class="btn btn-outline-info mt-3">
                        <i class="fas fa-plus"></i> Add Additional Contact
                    </button> -->
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Contact
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

<!-- @section('scripts')
@include('contact.partials.scripts', [
    'initialSocialLinksCount' => $contact->socialLinks->count(),
    'initialAdditionalContactsCount' => $contact->additionalContacts->count(),
])
<script>
    let socialLinkIndex = {{ $contact->socialLinks->count() }};
    let additionalContactIndex = {{ $contact->additionalContacts->count() }};

    // Add Social Link dynamically
    document.getElementById('add-social-link')?.addEventListener('click', function() {
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
    document.getElementById('add-additional-contact')?.addEventListener('click', function() {
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
@endsection -->
