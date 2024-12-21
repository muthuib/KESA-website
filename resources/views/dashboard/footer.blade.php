<footer class="bg-dark text-light pt-5 pb-4">
    <div class="container">
        <div class="row">
            <!-- About Us Section -->
            <div class="col-lg-4 col-md-6 mb-4">
                <h5 class="text-uppercase font-weight-bold">About Us</h5>
                <p class="mt-3">
                    {{ $aboutUs ?? 'Default about us content goes here.' }}
                </p>
            </div>

            <!-- Quick Links Section -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="text-uppercase font-weight-bold">Quick Links</h5>
                <ul class="list-unstyled mt-3">
                    @foreach ($quickLinks as $link)
                        <li><a href="{{ $link['url'] }}" class="text-light">{{ $link['label'] }}</a></li>
                    @endforeach
                </ul>
            </div>

            <!-- Contact Info Section -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="text-uppercase font-weight-bold">Contact Us</h5>
                <ul class="list-unstyled mt-3">
                    <li><i class="fas fa-map-marker-alt"></i> {{ $contact['address'] ?? 'No address provided' }}</li>
                    <li><i class="fas fa-phone-alt"></i> {{ $contact['phone'] ?? 'No phone provided' }}</li>
                    <li><i class="fas fa-envelope"></i> {{ $contact['email'] ?? 'No email provided' }}</li>
                </ul>
            </div>

            <!-- Newsletter Section -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="text-uppercase font-weight-bold">Stay Connected</h5>
                <p class="mt-3">Subscribe to our newsletter to receive the latest updates and news.</p>
                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="d-flex">
                    @csrf
                    <input type="email" name="email" class="form-control me-2" placeholder="Your Email" required>
                    <button type="submit" class="btn btn-primary">Subscribe</button>
                </form>
                <div class="mt-4">
                    @foreach ($socialLinks as $platform => $url)
                        <a href="{{ $url }}" class="text-light me-3"><i class="fab fa-{{ $platform }}"></i></a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <p class="mb-0">&copy; {{ date('Y') }} {{ $companyName ?? 'Your Company Name' }}. All rights reserved.</p>
    </div>
</footer>
