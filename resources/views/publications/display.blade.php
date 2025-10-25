@extends('layouts.app')

@section('head')
    @if(isset($publication))
        @php
            $imagePath = public_path('publication_cover/' . $publication->cover_image);
            $timestamp = file_exists($imagePath) ? filemtime($imagePath) : time();
            $ogImage = asset($publication->cover_image) . '?v=' . $timestamp;
        @endphp

        <meta property="og:title" content="{{ $publication->title }}" />
        <meta property="og:description" content="{{ strip_tags(Str::limit($publication->description, 160)) }}" />
        <meta property="og:image" content="{{ $ogImage }}" />
        <meta property="og:url" content="{{ url()->current() }}" />
        <meta property="og:type" content="article" />

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $publication->title }}">
        <meta name="twitter:description" content="{{ strip_tags(Str::limit($publication->description, 160)) }}">
        <meta name="twitter:image" content="{{ $ogImage }}">
    @endif
@endsection


@section('styles')
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


<style>
    .animated-line {
        height: 1px;
        background-color: brown;
        width: 0;
        animation: growLine 1s forwards;
        margin: 20px 0;
    }

    .publication-icon { font-size: 40px !important; color: brown !important; }

    @keyframes growLine { from { width: 0; } to { width: 100%; } }

    .publication-title { font-size: 1.2rem; font-weight: bold; }
    .publication-date { font-size: 1rem; color: #555; }

    .social-icon {
    font-size: 20px; /* Increase or decrease this value */
}
/* Highlight animation for the selected publication */
    .highlighted {
        background-color: #fff3cd;
        border: 2px solid brown;
        padding: 10px;
        border-radius: 5px;
        position: relative;
        animation: glowFade 3s ease-in-out;
        box-shadow: 0 0 15px rgba(165, 42, 42, 0.4);
    }

    /* Smooth glow animation */
    @keyframes glowFade {
        0% { box-shadow: 0 0 20px rgba(165, 42, 42, 0.8); }
        50% { box-shadow: 0 0 30px rgba(165, 42, 42, 0.3); }
        100% { box-shadow: 0 0 10px rgba(165, 42, 42, 0); }
    }

    /* Smart floating message styling */
    .highlight-msg {
        position: fixed;
        top: 100px;
        right: 30px;
        background: linear-gradient(90deg, #0e8014ff, #2aa541ff);
        color: #fff;
        padding: 12px 20px;
        border-radius: 50px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        font-weight: 600;
        z-index: 2000;
        opacity: 0;
        transform: translateY(-15px);
        transition: all 0.5s ease-in-out;
    }

    .highlight-msg.show {
        opacity: 1;
        transform: translateY(0);
    }

</style>
@endsection

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4" style="margin-top: 50px;">Publications</h1>
        <p style="font-size: 17px; text-align:center;">
        We are committed to advancing knowledge, innovation, and sound economic thinking and practice among our members. This Hub serves as a vibrant resource center, offering a wide range of insights, right from economic trends, research findings, and industry developments.
    </p>
    <p style="font-size: 17px; margin-left: 18px;">
        Our publications aim to inform, educate and influence policies.
    </p>
    <div class="card shadow-sm">
        <div class="card-body">
            <p style="text-align: center; font-size: 25px; font-weight: bold; color: black;">Latest Publications</p>

            @forelse($publications as $publication)
            <div id="publication-{{ $publication->id }}" class="row align-items-center mb-3 publication-row {{ isset($id) && $id == $publication->id ? 'highlighted' : '' }}">
                <div class="col-12 col-md-1 d-flex justify-content-center align-items-center mb-3 mb-md-0 text-center">
                    @if($publication->cover_image)
                        <div class="publication-img-wrapper rounded shadow-sm"
                            style="width: 80px; height: 100px; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 2px solid #d0e3e9ff;">
                            <img src="{{ asset($publication->cover_image) }}" 
                                alt="Cover Image for {{ $publication->title }}" 
                                class="img-fluid publication-cover" 
                                style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        </div>
                    @else
                        <i class="fas fa-file-alt text-brown publication-icon" style="font-size: 45px;"></i>
                    @endif
                </div>


                <div class="col-md-7">
                    <h5 class="mb-1 publication-title">{{ $publication->title }}</h5>
                    <p class="mb-1 text-muted"><strong>Author(s):</strong> {{ $publication->authors }}</p>
                    <p class="mb-1 text-muted"><strong>Description:</strong> {{ \Illuminate\Support\Str::limit(strip_tags($publication->description), 190) }}</p>
                </div>
                <div class="col-md-2">
                    <p class="mb-0 publication-date">
                        Uploaded on {{ \Carbon\Carbon::parse($publication->created_at)->format('F j, Y') }}
                    </p>
                </div>
                <div class="col-md-2 text-end">
                    <p class="mb-1 text-muted">
                        <strong>File Size:</strong> 
                        @php
                            $sizeInKB = $publication->file_size / 1024;
                            echo $sizeInKB >= 1024 ? number_format($sizeInKB/1024, 2).' MB' : number_format($sizeInKB,2).' KB';
                        @endphp
                    </p>
                    <p class="mb-0 text-muted"><strong>Downloads:</strong> {{ $publication->downloads ?? 0 }}</p>
                    <a href="{{ route('publications.download', $publication->id) }}" class="btn btn-primary btn-sm">Download</a>

                    <!-- Share Dropdown -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-success btn-sm dropdown-toggle mb-1" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-share-alt"></i> Share
                        </button>
                        <ul class="dropdown-menu">
                            
                            <!-- WhatsApp -->
                            <li>
                                <a class="dropdown-item" href="https://wa.me/?text={{ urlencode( $publication->title . ' ' . route('publications.display.show', $publication->slug)) }}" target="_blank">
                                    <i class="fab fa-whatsapp social-icon me-2 text-success"></i> WhatsApp
                                </a>
                            </li>

                            <!-- Twitter -->
                            <li>
                                <a class="dropdown-item" href="https://twitter.com/intent/tweet?url={{ urlencode(route('publications.display.show', $publication->slug)) }}&text={{ urlencode($publication->title) }}" target="_blank">
                                    <img src="/assets/images/x-logo.png" alt="Twitter X" width="17" height="17"> Twitter
                                </a>
                            </li>

                            <!-- Facebook -->
                            <li>
                                <a class="dropdown-item" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('publications.display.show', $publication->slug)) }}" target="_blank">
                                    <i class="fab fa-facebook-f social-icon me-2 text-primary"></i> Facebook
                                </a>
                            </li>

                            <!-- LinkedIn -->
                            <li>
                                <a class="dropdown-item" href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('publications.display.show', $publication->slug)) }}" target="_blank">
                                    <i class="fab fa-linkedin-in social-icon me-2 text-primary"></i> LinkedIn
                                </a>
                            </li>

                            <!-- Email  -->
                            <li>
                                <a class="dropdown-item" 
                                    href="https://mail.google.com/mail/?view=cm&fs=1&to=&su={{ urlencode($publication->title) }}&body={{ urlencode('Check out this publication: ' . route('publications.display.show', $publication->slug)) }}" 
                                    target="_blank">
                                    <i class="fab fa-google me-2 social-icon text-danger"></i> Gmail
                                </a>
                             </li>

                            <!-- Instagram (manual copy link suggestion) -->
                            <li>
                                <a class="dropdown-item copy-link" href="#" data-link="{{ route('publications.display.show', $publication->slug) }}">
                                    <i class="fab fa-instagram social-icon me-2 text-danger"></i> Copy for Instagram
                                </a>
                            </li>

                            <!-- Copy Link -->
                            <li>
                                <a class="dropdown-item copy-link" href="#" data-link="{{ route('publications.display.show', $publication->slug) }}">
                                    <i class="fas fa-link me-2 text-secondary"></i> Copy Link
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
            <div class="animated-line"></div>
            @empty
                <p class="text-center text-muted">No publications available.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- each publication image to automatically set a matching background color using Color Thief -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.2/color-thief.umd.js"></script>

<!-- Bootstrap Bundle JS (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Copy link functionality
    document.querySelectorAll('.copy-link').forEach(function(el) {
        el.addEventListener('click', function(e) {
            e.preventDefault();
            const link = this.getAttribute('data-link');
            navigator.clipboard.writeText(link).then(() => alert('Link copied to clipboard!'));
        });
    });

    // Scroll to highlighted publication
  const highlighted = document.querySelector('.highlighted');
if (highlighted) {
    // Detect header height to avoid hiding under navbar
    const header = document.querySelector('header, .navbar, .fixed-top');
    const headerHeight = header ? header.offsetHeight : 0;

    const elementPosition = highlighted.getBoundingClientRect().top + window.pageYOffset;
    const extraPadding = -30; // space below header (adjust as needed)
    const offsetPosition = elementPosition - headerHeight + extraPadding;

    window.scrollTo({
        top: offsetPosition,
        behavior: 'smooth'
    });

    // Get publication title
    const titleElement = highlighted.querySelector('.publication-title');
    const titleText = titleElement ? titleElement.textContent.trim() : 'this publication';

    // Create floating message element
    const msg = document.createElement('div');
    msg.className = 'highlight-msg';
    msg.textContent = `✨ You’re now viewing: "${titleText}"`;
    document.body.appendChild(msg);

    // Show the message
    setTimeout(() => msg.classList.add('show'), 100);

    // Remove it after 10 seconds (fade out)
    setTimeout(() => {
        msg.classList.remove('show');
        setTimeout(() => msg.remove(), 600);
    }, 10000);
}

// --- Color Thief for publication images ---
    const colorThief = new ColorThief();

    document.querySelectorAll('.publication-cover').forEach(img => {
        // Ensure image is loaded
        if (img.complete) {
            setBackground(img);
        } else {
            img.addEventListener('load', () => setBackground(img));
        }
    });

    function setBackground(img) {
        try {
            const color = colorThief.getColor(img); // [r, g, b]
            const wrapper = img.closest('.publication-img-wrapper');
            if (wrapper) {
                wrapper.style.backgroundColor = `rgb(${color[0]}, ${color[1]}, ${color[2]})`;
            }
        } catch (e) {
            console.error('ColorThief error:', e);
        }
    }

});
</script>
@endsection
