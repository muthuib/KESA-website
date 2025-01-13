<div class="card mb-4">
    <div class="card-header">Additional Contacts</div>
    <div class="card-body" id="additional-contacts-section">
        @foreach ($additionalContacts as $index => $additionalContact)
        <div class="additional-contact-item mb-3">
            <label for="type_{{ $index }}" class="form-label">Contact Type</label>
            <input type="text" name="additional_contacts[{{ $index }}][type]" class="form-control mb-2" 
                value="{{ old('additional_contacts.'.$index.'.type', $additionalContact->type) }}">
            <label for="detail_{{ $index }}" class="form-label">Details</label>
            <textarea name="additional_contacts[{{ $index }}][detail]" class="form-control">{{ old('additional_contacts.'.$index.'.detail', $additionalContact->detail) }}</textarea>
        </div>
        @endforeach
    </div>
    <!-- <button type="button" id="add-additional-contact" class="btn btn-secondary">Add Additional Contact</button> -->
</div>
