<div class="card mb-4">
    <div class="card-header">Contact Details</div>
    <div class="card-body">
        <div class="mb-3">
            <label for="organization_name" class="form-label">Organization Name</label>
            <input type="text" name="organization_name" id="organization_name" class="form-control" 
                value="{{ old('organization_name', $contact->organization_name ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" 
                value="{{ old('email', $contact->email ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control" 
                value="{{ old('phone', $contact->phone ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea name="address" id="address" class="form-control">{{ old('address', $contact->address ?? '') }}</textarea>
        </div>
    </div>
</div>
