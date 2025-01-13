<!-- <script>
    let socialLinkIndex = {{ $initialSocialLinksCount }};
    let additionalContactIndex = {{ $initialAdditionalContactsCount }};

    document.getElementById('add-social-link').addEventListener('click', function() {
        const section = document.getElementById('social-links-section');
        const newSocialLink = `
            <div class="social-link-item mb-3">
                <label for="platform_${socialLinkIndex}" class="form-label">Platform</label>
                <input type="text" name="social_links[${socialLinkIndex}][platform]" class="form-control mb-2">
                <label for="url_${socialLinkIndex}" class="form-label">URL</label>
                <input type="url" name="social_links[${socialLinkIndex}][url]" class="form-control">
            </div>
        `;
        section.insertAdjacentHTML('beforeend', newSocialLink);
        socialLinkIndex++;
    });

    document.getElementById('add-additional-contact').addEventListener('click', function() {
        const section = document.getElementById('additional-contacts-section');
        const newAdditionalContact = `
            <div class="additional-contact-item mb-3">
                <label for="type_${additionalContactIndex}" class="form-label">Contact Type</label>
                <input type="text" name="additional_contacts[${additionalContactIndex}][type]" class="form-control mb-2">
                <label for="detail_${additionalContactIndex}" class="form-label">Details</label>
                <textarea name="additional_contacts[${additionalContactIndex}][detail]" class="form-control"></textarea>
            </div>
        `;
        section.insertAdjacentHTML('beforeend', newAdditionalContact);
        additionalContactIndex++;
    });
</script> -->
