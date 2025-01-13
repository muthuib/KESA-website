<div class="card mb-4">
    <div class="card-header">Social Media Links</div>
    <div class="card-body" id="social-links-section">
        @foreach ($socialLinks as $index => $socialLink)
        <div class="social-link-item mb-3">
            <label for="platform_{{ $index }}" class="form-label">Platform</label>
            <input type="text" name="social_links[{{ $index }}][platform]" class="form-control mb-2" 
                value="{{ old('social_links.'.$index.'.platform', $socialLink->platform) }}">
            <label for="url_{{ $index }}" class="form-label">URL</label>
            <input type="url" name="social_links[{{ $index }}][url]" class="form-control" 
                value="{{ old('social_links.'.$index.'.url', $socialLink->url) }}">
        </div>
        @endforeach
    </div>
    <!-- <button type="button" id="add-social-link" class="btn btn-secondary">Add Social Link</button> -->
</div>
