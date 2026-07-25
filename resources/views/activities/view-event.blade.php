@extends('layouts.app')

@section('meta')
    {{-- Open Graph / Twitter / WhatsApp / LinkedIn / Telegram --}}
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $activity->title }}" />
    <meta property="og:description" content="{{ Str::limit(strip_tags($activity->description), 150) }}" />
    <meta property="og:image" content="{{ asset($activity->media) }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="KESA Kenya" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $activity->title }}" />
    <meta name="twitter:description" content="{{ Str::limit(strip_tags($activity->description), 150) }}" />
    <meta name="twitter:image" content="{{ asset($activity->media) }}" />
@endsection

@section('title', $activity->title)

@section('styles')
<style>
    .container-custom {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 0px;
        padding: 0px;
    }

    .left-column {
        flex: 2;
        min-width: 300px;
    }

    .right-column {
        flex: 1;
        min-width: 250px;
        border-left: 1px solid #ccc;
        padding-left: 20px;
    }

    .news-image {
        width: 100%;
        max-width: 500px;
        height: auto;
        display: block;
        margin-bottom: 0.25rem;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .news-date {
        color: #666;
        margin-bottom: 1rem;
        font-size: 0.95rem;
    }

    .news-date i {
        color: #800000;
        width: 20px;
    }

    .news-content {
        line-height: 1.7;
        font-size: 1.1rem;
        text-align: left;
    }

    /* Photo Credit Styles  */
    .photo-credit {
        background: linear-gradient(135deg, rgba(128, 0, 0, 0.08), rgba(128, 0, 0, 0.02));
        border-left: 4px solid #800000;
        padding: 0.40rem 1rem;
        margin: 0 0 0.75rem 0;
        border-radius: 4px;
        font-size: 0.7rem;
        color: #555;
        display: flex;
        align-items: center;
        gap: 10px;
        max-width: 500px;
    }
    
    .photo-credit i {
        color: #800000;
        font-size: 1.1rem;
    }
    
    .photo-credit .credit-label {
        color: #800000;
        font-weight: 500;
    }
    
    .photo-credit .credit-name {
        color: #333;
        font-weight: 600;
        font-style: italic;
    }

    .additional-images-title {
        color: #800000;
        font-weight: 600;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #800000;
    }

    .additional-images-title i {
        color: #800000;
    }

    .additional-image {
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        max-height: 200px;
        width: 100%;
        object-fit: cover;
    }

    .additional-image:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .read-also-title {
        font-size: 1.3rem;
        margin-bottom: 15px;
        font-weight: bold;
        border-bottom: 2px solid #800000;
        padding-bottom: 5px;
        color: #800000;
    }

    .read-also-list {
        list-style: none;
        padding-left: 0;
    }

    .read-also-list li {
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px dashed #ddd;
    }

    .read-also-list a {
        text-decoration: none;
        color: #333;
        font-weight: 500;
    }

    .read-also-list a:hover {
        color: #800000;
    }

    .read-also-date {
        font-size: 0.9rem;
        color: #888;
    }

    .read-also-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px dashed #ddd;
    }

    .read-also-link {
        display: flex;
        text-decoration: none;
        color: inherit;
        gap: 10px;
    }

    .read-also-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 4px;
    }

    .read-also-text {
        flex: 1;
    }

    .read-also-title-small {
        font-weight: 500;
        font-size: 0.95rem;
        color: #333;
    }

    .read-also-title-small:hover {
        color: #800000;
    }

    .read-also-date {
        font-size: 0.85rem;
        color: #888;
    }

    /* Share Section */
    .share-section {
        margin-top: 20px;
        position: relative;
    }

    .share-btn {
        background-color: #800000;
        color: #fff;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        border-radius: 6px;
        transition: background-color 0.3s ease;
    }

    .share-btn:hover {
        background-color: #660000;
    }

    .share-options {
        display: none;
        position: absolute;
        top: 50px;
        left: 0;
        background-color: #f9f9f9;
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 10px;
        z-index: 1000;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        min-width: 180px;
    }

    .share-options a {
        display: inline-block;
        margin-right: 12px;
        color: #333;
        font-size: 20px;
        transition: color 0.2s;
        text-decoration: none;
        padding: 5px 8px;
    }

    .share-options a:hover {
        color: #800000;
        background-color: #f0f0f0;
        border-radius: 4px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .container-custom {
            flex-direction: column;
        }

        .right-column {
            border-left: none;
            border-top: 1px solid #ccc;
            padding-left: 0;
            padding-top: 20px;
        }
    }

    @media (max-width: 768px) {
        .responsive-header {
            margin-top: 10px !important;
        }

        .news-title {
            font-size: 18px !important;
        }
    }

    .logged-in-title {
        margin-left: 280px;
    }

    @media (max-width: 768px) {
        .logged-in-title {
            margin-left: 10px !important;
        }
    }
</style>
@endsection

@section('content')
<!-- Full-width header with secondary background -->
<div class="text-dark py-4 px-0 responsive-header"
     style="margin-top: {{ Auth::check() ? '0' : '10px' }}; margin-bottom: 2px; background-color: rgb(244, 237, 237);">
    <div class="container-fluid px-0">
        <h2 class="mb-0 news-title w-100 {{ Auth::check() ? 'logged-in-title' : '' }}" style="padding-left: 20px;">
            {{ $activity->title }}
        </h2>
    </div>
</div>

<div class="container-custom" style="padding: 0 20px;">
    <!-- Left Column -->
    <div class="left-column">
        @if($activity->media)
            @if(Str::endsWith($activity->media, ['.mp4', '.mov', '.avi', '.mkv', '.flv', '.wmv']))
                <video class="news-image" controls>
                    <source src="{{ asset($activity->media) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            @else
                <img src="{{ asset($activity->media) }}" alt="Event Image" class="news-image">
            @endif
        @endif
        
        <!-- Photo Credit - Directly below image with minimal spacing -->
        @if($activity->photo_credit)
            <div class="photo-credit">
                <i class="fas fa-camera"></i>
                <span class="credit-label">Photo Credit:</span>
                <span class="credit-name">{{ $activity->photo_credit }}</span>
            </div>
        @endif
        
        <p class="news-date">
            <strong><i class="fas fa-calendar-day"></i> {{ \Carbon\Carbon::parse($activity->date)->format('l, F j, Y') }}</strong>
            @if($activity->start_time && $activity->end_time)
                <br>
                <i class="fas fa-clock"></i>
                {{ \Carbon\Carbon::parse($activity->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($activity->end_time)->format('g:i A') }}
            @endif
            @if($activity->location)
                <br>
                <i class="fas fa-map-marker-alt"></i>
                {{ $activity->location }}
            @endif
        </p>

        <div class="news-content">
            {!! $activity->description !!}
        </div>

        <!-- Additional Images -->
        @if($activity->media1 || $activity->media2 || $activity->media3)
            <div class="mt-4">
                <h5 class="additional-images-title">
                    <i class="fas fa-images"></i> More Event Photos
                </h5>
                <div class="row g-3">
                    @foreach (['media1', 'media2', 'media3'] as $img)
                        @if ($activity->$img)
                            <div class="col-md-4">
                                <img src="{{ asset($activity->$img) }}" alt="Additional Image" class="additional-image">
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
        
        <!-- Share on social media platforms -->
        <div class="share-section">
            <button class="share-btn" onclick="toggleShareOptions()">
                <i class="fas fa-share-alt"></i> Share
            </button>
            <div id="share-options" class="share-options">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" title="Share on Facebook">
                    <i class="fab fa-facebook fa-lg"></i>
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($activity->title) }}" target="_blank" title="Share on Twitter">
                    <img src="/assets/images/x-logo.png" alt="Twitter X" width="17" height="17">
                </a>
                <a href="https://api.whatsapp.com/send?text={{ urlencode($activity->title . ' ' . url()->current()) }}" target="_blank" title="Share on WhatsApp">
                    <i class="fab fa-whatsapp fa-lg"></i>
                </a>
                <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($activity->title) }}" target="_blank" title="Share on Telegram">
                    <i class="fab fa-telegram fa-lg"></i>
                </a>
                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($activity->title) }}" target="_blank" title="Share on LinkedIn">
                    <i class="fab fa-linkedin fa-lg"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="right-column">
        <h4 class="read-also-title">Read Also</h4>
        <ul class="read-also-list">
            @foreach($otherActivities->take(10) as $item)
                <li class="read-also-item">
                    <a href="{{ route('events.view', $item->id) }}" class="read-also-link">
                        @if($item->media)
                            <img src="{{ asset($item->media) }}" alt="{{ $item->title }}" class="read-also-img">
                        @endif
                        <div class="read-also-text">
                            <div class="read-also-title-small">{{ \Illuminate\Support\Str::limit($item->title, 60) }}</div>
                            <div class="read-also-date">{{ \Carbon\Carbon::parse($item->date)->format('M j, Y') }}</div>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>

<!-- Script to toggle social media platforms -->
<script>
    function toggleShareOptions() {
        var options = document.getElementById("share-options");
        options.style.display = (options.style.display === "block") ? "none" : "block";
    }

    // Hide if clicked outside
    document.addEventListener('click', function(event) {
        var options = document.getElementById("share-options");
        if (!event.target.closest('.share-section')) {
            options.style.display = "none";
        }
    });
</script>
@endsection