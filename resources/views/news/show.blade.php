@extends('layouts.app')

@section('meta')
    {{-- Open Graph / Twitter / WhatsApp / LinkedIn / Telegram --}}
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $news->title }}" />
    <meta property="og:description" content="{{ Str::limit(strip_tags($news->content), 150) }}" />
    <meta property="og:image" content="{{ asset($news->image) }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="KESA Kenya" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $news->title }}" />
    <meta name="twitter:description" content="{{ Str::limit(strip_tags($news->content), 150) }}" />
    <meta name="twitter:image" content="{{ asset($news->image) }}" />
@endsection

@section('title', $news->title)
@auth
    <div class="d-flex justify-content-between align-items-left mb-3">
        <h2 class="mb-0"></h2>
        <a href="{{ route('news.index') }}" class="btn btn-dark" style="margin-top: 105px;">
            <i class="fas fa-backward"></i> Back
        </a>
    </div>
@endauth
<!-- Full-width header with secondary background -->
<div class="text-dark py-4 px-0 responsive-header"
     style="margin-top: {{ Auth::check() ? '0' : '100px' }}; margin-bottom: 8px; background-color: rgb(244, 237, 237);">
    <div class="container-fluid px-4">
        <h2 class="mb-0 news-title w-100 {{ Auth::check() ? 'logged-in-title' : '' }}">
            {{ $news->title }}
        </h2>
    </div>
</div>
@section('content')
<div class="container-custom">
    <!-- Left Column -->
    <div class="left-column">
        @if($news->image)
            <img src="{{ asset($news->image) }}" alt="News Image" class="news-image">
        @endif

        <p class="news-date">
            <strong>{{ \Carbon\Carbon::parse($news->date)->format('l, F j, Y') }}</strong>
        </p>

        <div class="news-content">
            {!! $news->content !!}
        </div>
    </div>
<!-- share on social media platforms code -->
 <div class="share-section">
    <button class="share-btn" onclick="toggleShareOptions()">📤 Share</button>
   <div id="share-options" class="share-options">
    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" title="Share on Facebook">
        <i class="fab fa-facebook fa-lg"></i>
    </a>
    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($news->title) }}" target="_blank" title="Share on Twitter">
       <img src="/assets/images/x-logo.png" alt="Twitter X" width="17" height="17">
    </a>
    <a href="https://api.whatsapp.com/send?text={{ urlencode($news->title . ' ' . url()->current()) }}" target="_blank" title="Share on WhatsApp">
        <i class="fab fa-whatsapp fa-lg"></i>
    </a>
    <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($news->title) }}" target="_blank" title="Share on Telegram">
        <i class="fab fa-telegram fa-lg"></i>
    </a>
    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($news->title) }}" target="_blank" title="Share on LinkedIn">
        <i class="fab fa-linkedin fa-lg"></i>
    </a>
</div>

</div>


    <!-- Right Column -->
    <div class="right-column">
        <h4 class="read-also-title">Read Also</h4>
        <ul class="read-also-list">
@foreach($otherNews->take(10) as $item)
    <li class="read-also-item">
        <a href="{{ route('news.show', $item->id) }}" class="read-also-link">
            @if($item->image)
                <img src="{{ asset($item->image) }}" alt="{{ $item->title }}" class="read-also-img">
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
<!-- script to toggle social media platforms to share the news link -->
 <script>
function toggleShareOptions() {
    var options = document.getElementById("share-options");
    options.style.display = (options.style.display === "block") ? "none" : "block";
}

// Optional: Hide if clicked outside
document.addEventListener('click', function(event) {
    var options = document.getElementById("share-options");
    if (!event.target.closest('.share-section')) {
        options.style.display = "none";
    }
});
</script>

<!-- CSS -->
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
    margin-bottom: 1rem;
}

.news-date {
    color: #666;
    margin-bottom: 1rem;
}

.news-content {
    line-height: 1.7;
    font-size: 1.1rem;
    text-align: left;
}

.read-also-title {
    font-size: 1.3rem;
    margin-bottom: 15px;
    font-weight: bold;
    border-bottom: 2px solid #ccc;
    padding-bottom: 5px;
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
    color: #007bff;
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
    color: #007bff;
}

.read-also-date {
    font-size: 0.85rem;
    color: #888;
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
        margin-top: 70px !important;
    }

    .news-title {
        font-size: 18px !important;
    }
}
.logged-in-title {
    margin-left: 280px;
}

/* On small screens, reduce margin to 100px */
@media (max-width: 768px) {
    .logged-in-title {
        margin-left: 10px !important;
    }
}

/* css for social media platforms to share news link */
.share-section {
    margin-top: 20px;
    position: relative;
}

.share-btn {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 8px 16px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 4px;
}

.share-options {
    display: none;
    position: absolute;
    top: 40px;
    left: 0;
    background-color: #f9f9f9;
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 10px;
    z-index: 1000;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.share-options a {
    display: block;
    padding: 6px 10px;
    text-decoration: none;
    color: #333;
    border-bottom: 1px solid #eee;
    font-size: 14px;
}

.share-options a:hover {
    background-color: #f0f0f0;
}
.share-options a {
    display: inline-block;
    margin-right: 12px;
    color: #333;
    font-size: 20px;
    transition: color 0.2s;
}

.share-options a:hover {
    color: #007bff;
}

</style>
@endsection
