@extends('layouts.app')

@section('title', $story->title)

@section('meta')
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $story->title }}" />
    <meta property="og:description" content="{{ Str::limit(strip_tags($story->body), 150) }}" />
    <meta property="og:image" content="{{ asset($story->cover_image) }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="KESA Kenya" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $story->title }}" />
    <meta name="twitter:description" content="{{ Str::limit(strip_tags($story->body), 150) }}" />
    <meta name="twitter:image" content="{{ asset($story->cover_image) }}" />
@endsection

@auth
    <div class="d-flex justify-content-end mb-3 px-4 mt-2">
        <a href="{{ route('success_stories.index') }}" class="btn btn-dark btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Back to Admin
        </a>
    </div>
@endauth

@section('content')
<div class="story-header text-center py-4 mb-4">
    <div class="container">
        <h1 class="story-title mb-3">{{ $story->title }}</h1>
        <p class="story-meta text-muted mb-0">
            <span><i class="far fa-calendar-alt"></i>
                {{ $story->published_at
                    ? \Carbon\Carbon::parse($story->published_at)->format('F j, Y')
                    : 'Not Published' }}
            </span>
            &nbsp;•&nbsp;
            <span><i class="fas fa-user"></i> {{ $story->author ?? 'Unknown Author' }}</span>
            &nbsp;•&nbsp;
            <span><i class="fas fa-clock"></i>
                {{ ceil(str_word_count(strip_tags($story->body)) / 200) }} min read
            </span>
        </p>
    </div>
</div>

<div class="container-custom">

    {{-- LEFT COLUMN --}}
    <div class="left-column position-relative">

        {{-- Share Button (top-right corner) --}}
        <div class="share-btn-wrapper-top">
            <button class="share-btn-sm" onclick="toggleShareOptions(event)">
                <i class="fas fa-share-alt me-1"></i> Share
            </button>
            <div id="share-options" class="share-options-sm">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank">
                    <i class="fab fa-facebook"></i>
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($story->title) }}" target="_blank">
                    <img src="/assets/images/x-logo.png" alt="X" width="16" height="16">
                </a>
                <a href="https://api.whatsapp.com/send?text={{ urlencode($story->title . ' ' . url()->current()) }}" target="_blank">
                    <i class="fab fa-whatsapp"></i>
                </a>
                <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($story->title) }}" target="_blank">
                    <i class="fab fa-telegram"></i>
                </a>
                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($story->title) }}" target="_blank">
                    <i class="fab fa-linkedin"></i>
                </a>
                <a href="javascript:void(0)" onclick="copyLink()">
                    <i class="fas fa-link"></i>
                </a>
            </div>
        </div>

        {{-- Image --}}
      @if(!empty($story->cover_image) && file_exists(public_path($story->cover_image)))
                <div class="story-image-section mb-4 text-center text-lg-start">
                    <img src="{{ asset($story->cover_image) }}"
                        alt="{{ $story->title }}"
                        class="story-cover-img mb-3">
                </div>
            @endif

        {{-- Share Button (below image for small devices) --}}
        <div class="share-btn-wrapper-mobile">
            <button class="share-btn-sm" onclick="toggleShareOptions(event)">
                <i class="fas fa-share-alt me-1"></i> Share
            </button>
            <div id="share-options-mobile" class="share-options-sm">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank">
                    <i class="fab fa-facebook"></i>
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($story->title) }}" target="_blank">
                    <img src="/assets/images/x-logo.png" alt="X" width="16" height="16">
                </a>
                <a href="https://api.whatsapp.com/send?text={{ urlencode($story->title . ' ' . url()->current()) }}" target="_blank">
                    <i class="fab fa-whatsapp"></i>
                </a>
                <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($story->title) }}" target="_blank">
                    <i class="fab fa-telegram"></i>
                </a>
                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($story->title) }}" target="_blank">
                    <i class="fab fa-linkedin"></i>
                </a>
                <a href="javascript:void(0)" onclick="copyLink()">
                    <i class="fas fa-link"></i>
                </a>
            </div>
        </div>

        {{-- Story Content --}}
        <div class="news-content">
            {!! $story->body !!}
        </div>
    </div>

    {{-- Separator --}}
    <div class="column-separator d-none d-lg-block"></div>

    {{-- RIGHT COLUMN --}}
    <div class="right-column">
        @if($relatedStories->count() > 0)
            <h4 class="read-also-title">Read Also</h4>
            <ul class="read-also-list">
                @foreach($relatedStories->take(10) as $related)
                    <li class="read-also-item">
                        <a href="{{ route('public.success_stories.show', $related->slug) }}" class="read-also-link">
                            @if($related->cover_image)
                                <img src="{{ asset($related->cover_image) }}" alt="{{ $related->title }}" class="read-also-img">
                            @endif
                            <div class="read-also-text">
                                <div class="read-also-title-small">
                                    {{ \Illuminate\Support\Str::limit($related->title, 60) }}
                                </div>
                                <div class="read-also-date">
                                    {{ $related->published_at
                                        ? \Carbon\Carbon::parse($related->published_at)->format('M j, Y')
                                        : '' }}
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>

<div class="text-center mt-5">
    <a href="{{ route('public.success_stories.index') }}" class="btn btn-outline-dark rounded-pill px-4">
        <i class="fas fa-arrow-left me-1"></i> Back to Stories
    </a>
</div>

{{-- Scripts --}}
<script>
function toggleShareOptions(e) {
    e.stopPropagation();
    const menu = e.currentTarget.nextElementSibling;
    const isOpen = menu.style.display === 'flex';
    closeAllShareMenus();
    if (!isOpen) menu.style.display = 'flex';
}

function closeAllShareMenus() {
    document.querySelectorAll('.share-options-sm').forEach(m => m.style.display = 'none');
}

document.addEventListener('click', closeAllShareMenus);

function copyLink() {
    navigator.clipboard.writeText(window.location.href)
        .then(() => alert('Link copied!'))
        .catch(() => {
            const input = document.createElement('input');
            input.value = window.location.href;
            document.body.appendChild(input);
            input.select();
            document.execCommand('copy');
            document.body.removeChild(input);
            alert('Link copied!');
        });
}
</script>

{{-- Styles --}}
<style>
.story-header {
    background: linear-gradient(135deg, #f8f9fc, #eef2f7);
    border-bottom: 1px solid #e0e0e0;
}
.story-title {
    font-size: 2.3rem;
    font-weight: 700;
    line-height: 1.3;
    color: #1a1a1a;
}
.story-meta { font-size: 0.95rem; }

.container-custom {
    display: flex;
    flex-wrap: wrap;
    gap: 25px;
    margin: 0 auto;
    max-width: 1300px;
    padding: 0 20px;
    position: relative;
}

/* Columns */
.left-column { flex: 2; min-width: 300px; position: relative; }
.right-column { flex: 1; min-width: 250px; }

/* Vertical Separator */
.column-separator {
    width: 1px;
    background: #ddd;
    height: auto;
}

/* Share Buttons */
.share-btn-wrapper-top {
    position: absolute;
    top: 0;
    right: 0;
    z-index: 10;
}
.share-btn-wrapper-mobile {
    display: none;
    margin: 10px 0 20px;
    text-align: center;
}
.share-btn-sm {
    background: #007bff;
    color: white;
    border: none;
    padding: 8px 16px;
    font-size: 14px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
    box-shadow: 0 2px 6px rgba(0,123,255,.3);
}
.share-btn-sm:hover { background: #0056b3; }

.share-options-sm {
    display: none;
    flex-wrap: wrap;
    gap: 10px;
    position: absolute;
    top: 40px;
    right: 0;
    background: white;
    padding: 12px;
    border-radius: 8px;
    box-shadow: 0 4px 16px rgba(0,0,0,.15);
    z-index: 1000;
    min-width: 180px;
}
.share-options-sm a {
    color: #073621ff;
    font-size: 18px;
    transition: color .2s;
}
.share-options-sm a:hover { color: #007bff; }

/* Image & Content */
.story-cover-img {
    width: 100%;
    max-width: 420px;
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(0,0,0,.1);
    transition: transform .3s ease;
}
.story-cover-img:hover { transform: scale(1.02); }
.news-content {
    line-height: 1.8;
    font-size: 1.08rem;
    color: #333;
}

/* Related Stories */
.read-also-title {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 15px;
    border-bottom: 2px solid #007bff;
    padding-bottom: 5px;
    color: #007bff;
}
.read-also-item {
    display: flex;
    gap: 10px;
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 1px dashed #eee;
}
.read-also-img {
    width: 60px; height: 60px; object-fit: cover;
    border-radius: 6px;
}
.read-also-title-small { font-weight: 500; font-size: 0.95rem; color: #222; }
.read-also-title-small:hover { color: #007bff; }
.read-also-date { font-size: 0.82rem; color: #777; }

@media (max-width: 992px) {
    .column-separator { display: none; }
    .right-column { border-top: 1px solid #ddd; padding-top: 20px; margin-top: 20px; }
}
@media (max-width: 768px) {
    .story-title { font-size: 1.7rem; }
    .story-cover-img { max-width: 100%; }
    .share-btn-wrapper-top { display: none; } /* hide top button */
    .share-btn-wrapper-mobile { display: block; } /* show below image */
}
</style>
@endsection
