@extends('layouts.app')

@section('title', $blog->title)
@section('meta')
    <!-- Open Graph tags -->
    <meta property="og:title" content="{{ $blog->title }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($blog->content), 150) }}">
    <meta property="og:image" content="{{ asset(str_replace('public/', '', $blog->image)) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="article">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $blog->title }}">
    <meta name="twitter:description" content="{{ Str::limit(strip_tags($blog->content), 150) }}">
    <meta name="twitter:image" content="{{ asset(str_replace('public/', '', $blog->image)) }}">
@endsection


@section('content')
@auth
    <div class="d-flex justify-content-between align-items-left mb-3">
        <h2 class="mb-0"></h2>
        <a href="{{ route('blog.index') }}" class="btn btn-dark mt-4">
            <i class="fas fa-backward"></i> Back
        </a>
    </div>
@endauth

<!-- Header -->
<!-- <div class="text-dark py-4 px-0 responsive-header"
     style="margin-top: {{ Auth::check() ? '0' : '120px' }}; margin-bottom: 8px; background-color: white;">
    <div class="container-fluid px-4">
        <h2 class="mb-0 blog-title w-100">{{ $blog->title }}</h2>
        <p class="text-muted mt-2" style="font-size: 0.9rem;">
            ⏱️ Estimated Read Time: {{ ceil(str_word_count(strip_tags($blog->content)) / 200) }} min read
        </p>
    </div>
</div> -->

<!-- Blog Content + Sidebar -->
<div class="row align-items-start">
    <!-- Left Column -->
    <div class="col-md-8 col-12">
        <h2 class="mb-3 blog-title responsive-title">
            {{ $blog->title }}
        </h2>
        <p class="text-muted text-center">
            ⏱️ Estimated Read Time: {{ ceil(str_word_count(strip_tags($blog->content)) / 200) }} min read
        </p>
        <!-- image to display only on small and medium screens -->
         <div class="fullwidth-mobile-content">
            <figure class="image-caption-block d-block d-lg-none m-0">
                <img src="{{ asset($blog->image) }}" 
                    class="blog-image w-100" 
                    alt="Blog Image" 
                    style="height: auto; display: block;">
                <figcaption class="image-caption text-muted text-left p-2" style="font-size: 0.9rem;">
                    {{ $blog->name }}
                </figcaption>
            </figure>   
         </div>        
        <!-- Show only on large screens and above -->
                <div class="fullwidth-mobile-content d-none d-lg-block">
                    <div class="blog-content text-center">
                        <p class="text-muted mb-1">
                            <strong>{{ \Carbon\Carbon::parse($blog->date)->format('l, F j, Y') }}</strong>
                        </p>
                        
                          <p class="text-secondary mb-2" style="font-size: 0.9rem;">
                                <i class="bi bi-person"></i> <strong>Author:</strong>
                                <a href="{{ route('blog.byAuthor', ['author' => $blog->author]) }}">
                                    {{ $blog->author ?? 'Admin' }}
                                </a>
                            </p>
                            
                            <p class="text-secondary mb-2" style="font-size: 0.9rem;">
                                <strong> Category:</strong> {{ $blog->category ?? 'Uncategorized' }}
                            </p>

                        @if($blog->tags)
                        <p class="text-muted mb-3" style="font-size: 0.85rem;">
                            🏷️ Tags:
                            @foreach(explode(',', $blog->tags) as $tag)
                                <a href="{{ route('blog.index', ['tag' => trim($tag)]) }}" class="badge bg-secondary text-decoration-none">
                                    {{ trim($tag) }}
                                </a>
                            @endforeach
                        </p>
                        @endif
                    </div>
                </div>

                <!-- Share Section -->
                <div class="share-section d-none d-lg-block">
                    <div id="share-options" class="share-options mt-3 d-flex flex-wrap gap-2">
                        <!-- Facebook -->
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                        target="_blank" 
                        class="btn share-btn facebook">
                            <i class="fab fa-facebook-f"></i>
                            <span class="share-text"> Share</span>
                        </a>

                        <!-- Twitter / X -->
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($blog->title) }}" 
                        target="_blank" 
                        class="btn share-btn twitter">
                            <img src="/assets/images/x-logo.png" alt="Twitter X" width="13" height="13">
                            <span class="share-text"> Tweet</span>
                        </a>

                        <!-- WhatsApp -->
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($blog->title . ' ' . url()->current()) }}" 
                        target="_blank" 
                        class="btn share-btn whatsapp">
                            <i class="fab fa-whatsapp"></i>
                            <span class="share-text"> WhatsApp</span>
                        </a>

                        <!-- Telegram -->
                        <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($blog->title) }}" 
                        target="_blank" 
                        class="btn share-btn telegram">
                            <i class="fab fa-telegram-plane"></i>
                            <span class="share-text"> Telegram</span>
                        </a>

                        <!-- LinkedIn -->
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($blog->title) }}" 
                        target="_blank" 
                        class="btn share-btn linkedin">
                            <i class="fab fa-linkedin-in"></i>
                            <span class="share-text"> LinkedIn</span>
                        </a>

                        <!-- Copy Link -->
                        <button type="button" onclick="copyLink()" class="btn share-btn copy-link">
                            <i class="fas fa-link"></i>
                            <span class="share-text"> Copy Link</span>
                        </button>
                    </div>
                </div>

    </div>

    <!-- Right Column -->
    <div class="col-md-4 col-12 text-md-end">
        <!-- image to display only on large screens -->
        <figure class="image-caption-block d-none d-lg-block">
            <img src="{{ asset($blog->image) }}" 
                class="blog-image" 
                alt="Blog Image" 
                style="width: 300px; height: 220px; margin-top:150px;">
            <figcaption class="image-caption text-muted" style="font-size: 0.9rem; text-align: left;">
                {{ $blog->name }}
            </figcaption>
        </figure>
    </div>
</div>


<div class="container-custom {{ Auth::check() ? 'full-width' : '' }}">
    <!-- LEFT COLUMN -->
    <div class="left-column {{ Auth::check() ? 'expand-full' : '' }}">

        <!-- @if($blog->image)
        <div class="image-share-wrapper mb-3">
            <img src="{{ asset($blog->image) }}" class="blog-image fullwidth-mobile" alt="Blog Image"> -->

           <!-- Caption only on small and medium screens (sm and md) -->
            <!-- <div class="fullwidth-mobile-content">
              <div class="blog-content">
                @if(!empty($blog->name))
                    <p class="small mb-1 text-secondary d-block d-lg-none">
                        {{ $blog->name }}
                    </p>
                @endif
              </div>
            </div>
         </div>
        @endif -->

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

        <!-- Meta Info -->
         <!-- <div class="card p-3 mb-4 shadow-sm">
                <h4 class="mb-3">📊 View Stats</h4>
                <div class="btn-group mb-3" role="group">
                    <button class="btn btn-outline-primary" onclick="showStat('1')">Today</button>
                    <button class="btn btn-outline-primary" onclick="showStat('7')">Last 7 Days</button>
                    <button class="btn btn-outline-primary" onclick="showStat('30')">Last 30 Days</button>
                    <button class="btn btn-outline-primary" onclick="showStat('365')">Last 365 Days</button>
                </div>

                <div id="viewStatsResult" class="alert alert-info">
                    <strong>{{ $stats['last_1_day'] }}</strong> views today.
                </div>
            </div> -->

            <script>
                const stats = {
                    '1': '{{ $stats["last_1_day"] }}',
                    '7': '{{ $stats["last_7_days"] }}',
                    '30': '{{ $stats["last_30_days"] }}',
                    '365': '{{ $stats["last_365_days"] }}',
                };

                function showStat(range) {
                    const textMap = {
                        '1': 'Today',
                        '7': 'Last 7 Days',
                        '30': 'Last 30 Days',
                        '365': 'Last 365 Days'
                    };
                    document.getElementById('viewStatsResult').innerHTML =
                        `<strong>${stats[range]}</strong> views ${textMap[range].toLowerCase()}.`;
                }
            </script>
               
                    <!-- Show only on small and medium devices -->
                    <div class="fullwidth-mobile-content d-lg-none">
                        <div class="blog-content text-center">
                            <p class="text-muted mb-1">
                                <strong>{{ \Carbon\Carbon::parse($blog->date)->format('l, F j, Y') }}</strong>
                            </p>
                            
                            <p class="text-secondary mb-2" style="font-size: 0.9rem;">
                                <i class="bi bi-person"></i> <strong>Author:</strong>
                                <a href="{{ route('blog.byAuthor', ['author' => $blog->author]) }}">
                                    {{ $blog->author ?? 'Admin' }}
                                </a>
                            </p>

                            <p class="text-secondary mb-2" style="font-size: 0.9rem;">
                                <strong> Category:</strong> {{ $blog->category ?? 'Uncategorized' }}
                            </p>

                            @if($blog->tags)
                            <p class="text-muted mb-3" style="font-size: 0.85rem;">
                                🏷️ Tags:
                                @foreach(explode(',', $blog->tags) as $tag)
                                    <a href="{{ route('blog.index', ['tag' => trim($tag)]) }}" class="badge bg-secondary text-decoration-none">
                                        {{ trim($tag) }}
                                    </a>
                                @endforeach
                            </p>
                            @endif
                        </div>
                    </div>

                    <!-- Share Section (only on small & medium) -->
                    <div class="share-section d-lg-none">
                        <div id="share-options" class="share-options mt-3 d-flex flex-wrap gap-2">
                            <!-- Facebook -->
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                            target="_blank" 
                            class="btn share-btn facebook">
                                <i class="fab fa-facebook-f"></i>
                                <span class="share-text"> Share</span>
                            </a>

                            <!-- Twitter / X -->
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($blog->title) }}" 
                            target="_blank" 
                            class="btn share-btn twitter">
                                <img src="/assets/images/x-logo.png" alt="Twitter X" width="13" height="13">
                                <span class="share-text"> Tweet</span>
                            </a>

                            <!-- WhatsApp -->
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($blog->title . ' ' . url()->current()) }}" 
                            target="_blank" 
                            class="btn share-btn whatsapp">
                                <i class="fab fa-whatsapp"></i>
                                <span class="share-text"> WhatsApp</span>
                            </a>

                            <!-- Telegram -->
                            <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($blog->title) }}" 
                            target="_blank" 
                            class="btn share-btn telegram">
                                <i class="fab fa-telegram-plane"></i>
                                <span class="share-text"> Telegram</span>
                            </a>

                            <!-- LinkedIn -->
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($blog->title) }}" 
                            target="_blank" 
                            class="btn share-btn linkedin">
                                <i class="fab fa-linkedin-in"></i>
                                <span class="share-text"> LinkedIn</span>
                            </a>

                            <!-- Copy Link -->
                            <!-- <button type="button" onclick="copyLink()" class="btn share-btn copy-link" style="font-size: 11px !important; margin-top: 10px !important;">
                                <i class="fas fa-link"></i>
                                <span class="share-text"> Copy Link</span>
                            </button> -->
                        </div>
                    </div>


        <!-- Blog Content -->
        <div class="fullwidth-mobile-content">
            <div class="blog-content">
                {!! $blog->content !!}
            </div>
        </div>
        <!-- Footer Notice -->
         <div class="fullwidth-mobile-content">
            <div class="blog-content">
                <div class="blog-footer mt-5 pt-4 border-top">
                    <p class="small text-muted mb-2">&copy; {{ date('Y') }} All rights reserved. This blog is the property of {{ config('app.name') }}.</p>
                    <p class="small text-muted">
                        <strong>Disclaimer:</strong> The views and opinions expressed in this blog post are those of the author and do not necessarily reflect the official policy or position of {{ config('app.name') }}. Any content provided is for informational purposes only.
                    </p>
                </div>
            </div>
         </div>
    </div>

    <!-- RIGHT COLUMN - READ ALSO -->
    @guest
    <div class="right-column">
        <!-- image -->
        <!-- <div class="image-share-wrapper">
            <figure class="image-caption-block" style="width: 100%;">
                <img src="{{ asset($blog->image) }}" class="blog-image" alt="Blog Image">
                <figcaption class="image-caption">
                    {{ $blog->caption }}
                </figcaption>
            </figure>
        </div> -->
        <h5 class="read-also-title" style="margin-top: 10px;">📌 More Blogs</h5>
        <ul class="read-also-list">
            @foreach($otherBlogs->take(10) as $item)
            <li class="read-also-item">
                <a href="{{ route('blog.show', $item->slug) }}" class="read-also-link">
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
    @endguest
</div>

<!-- Scripts -->
<script>
    function toggleShareOptions() {
        const options = document.getElementById("share-options");
        options.style.display = (options.style.display === "block") ? "none" : "block";
    }

    function copyLink() {
        const dummy = document.createElement("input");
        document.body.appendChild(dummy);
        dummy.value = window.location.href;
        dummy.select();
        document.execCommand("copy");
        document.body.removeChild(dummy);
        alert("Link copied to clipboard!");
    }

    document.addEventListener('click', function (event) {
        const options = document.getElementById("share-options");
        if (!event.target.closest('.share-section')) {
            options.style.display = "none";
        }
    });
</script>

<!-- Styles -->
<style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');  
.container-custom {
    display: flex;
    flex-wrap: nowrap;
    margin-top: 0;
    padding: 0;
    gap: 40px;
    font-family: 'Poppins', sans-serif;
}

.container-custom.full-width {
    flex-wrap: wrap;
    gap: 0;
}

.left-column {
    flex: 2;
    min-width: 300px;
    padding-right: 20px;
    margin-left: 15px;
}

.left-column.expand-full {
    flex: 1 1 100%;
    max-width: 100%;
    padding-right: 0;
}

.right-column {
    flex: 1;
    min-width: 250px;
    padding-left: 20px;
    border-left: 2px solid #e0e0e0;
}

.image-share-wrapper {
    display: flex;
    justify-content: flex-end; /* Push image to the right */
    align-items: flex-start;
    gap: 15px;
    flex-wrap: wrap;
}

.blog-image {
    width: 100%;
    height: auto;
    max-width: 100%;
    display: block;
    margin: 0 auto 15px auto;
}

@media (min-width: 992px) {
    .blog-image {
        width: 50%;
        margin-left: 0px;
    }
    
}

.share-section {
    margin: 0 auto;
    display: block;
    width: fit-content; /* or specific width */
}

.share-options a {
    margin-right: 8px;
    font-size: 11px;
}

.blog-title {
    text-align: center;
    font-size: 22px;
    font-weight: bold;
    font-family: 'Poppins', sans-serif;
}

.blog-content {
    line-height: 1.7;
    font-size: 0.95rem;
    color: #333;
    text-align: left;
    font-family: 'Poppins', sans-serif;
}

.blog-content a {
    color: #007bff;
    text-decoration: none;
}

.blog-content a:hover {
    text-decoration: underline;
    color: #0056b3;
}

.blog-footer {
    font-size: 0.85rem;
    color: #777;
}

.read-also-title {
    font-size: 1.2rem;
    margin-bottom: 15px;
    font-weight: bold;
    border-bottom: 2px solid #ccc;
    padding-bottom: 5px;
}

.read-also-list {
    list-style: none;
    padding-left: 0;
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

.badge {
    margin-right: 5px;
}

@media (max-width: 768px) {
    .container-custom {
        flex-direction: column;
        margin-left: 0 !important;
        margin-right: 0 !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
        width: 100% !important;
    }

    .right-column {
        border-left: none;
        border-top: 2px solid #e0e0e0;
        padding-left: 0;
        padding-top: 20px;
    }

    .blog-title {
        font-size: 21px;
    }

    .blog-image {
        max-width: 100%;
    }

    .image-share-wrapper {
        flex-direction: column;
        align-items: flex-start;
    }
}

.blog-content {
    font-family: "Georgia", serif;
    font-size: 1rem;
    line-height: 1.7;
    color: #333;
    word-break: break-word;
}

/* ✅ Table styling */
.blog-content table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 1.5rem;
    font-size: 0.95rem;
}

.blog-content th,
.blog-content td {
    border: 1px solid #ddd;
    padding: 10px;
    vertical-align: top;
    text-align: left;
}

.blog-content th {
    background-color: #f7f7f7;
    font-weight: bold;
}

/* ✅ Lists */
.blog-content ul, .blog-content ol {
    margin-left: 2rem;
    padding-left: 1rem;
}

.blog-content li {
    margin-bottom: 5px;
}

/* ✅ Headings from CKEditor */
.blog-content h1,
.blog-content h2,
.blog-content h3,
.blog-content h4,
.blog-content h5 {
    margin-top: 1.5rem;
    font-weight: bold;
    color: #222;
}

/* ✅ Blockquotes */
.blog-content blockquote {
    margin: 1rem 0;
    padding-left: 1rem;
    border-left: 4px solid #ccc;
    color: #555;
    font-style: italic;
}

/* ✅ Code blocks */
.blog-content pre {
    background-color: #f9f9f9;
    border: 1px solid #eee;
    padding: 10px;
    overflow-x: auto;
    font-family: Consolas, Monaco, monospace;
}

/* ✅ Images & videos */
.blog-content img {
    max-width: 100%;
    height: auto;
    margin: 1rem 0;
    display: block;
}

.blog-content iframe {
    max-width: 100%;
    height: auto;
    margin: 1rem 0;
    border: none;
}

/* Optional fix for Word non-breaking spaces & smart quotes */
.blog-content {
    white-space: normal;
}
/* RESPONSIVE TITTLE */
.responsive-title {
    margin-top: 90px; /* default for small & medium */
}

@media (min-width: 992px) {
    .responsive-title {
        margin-top: 120px; /* for large and above */
    }
}

@media (max-width: 991.98px) {
    .fullwidth-mobile {
        width: 100vw !important;
        max-width: 100vw !important;
        margin-left: calc(-1 * (100vw - 100%) / 2) !important;
        margin-right: 0 !important;
        padding: 0 !important;
        display: block;
    }
}
@media (max-width: 991.98px) {
    .fullwidth-mobile-content {
        width: 100vw !important;
        max-width: 100vw !important;
        margin-left: calc(-1 * (100vw - 100%) / 2) !important;
        margin-right: 0 !important;
        padding: 0 10px;
        display: block;
    }
}

/* SHARE BUTTONS */
.share-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    color: white;
    transition: all 0.2s ease;
    text-decoration: none;
}

.share-btn:hover {
    opacity: 0.85;
    transform: translateY(-2px);
}


/* Specific Platform Colors */
.facebook { background-color: #3b5998 !important; color: white !important; margin-top: 10px !important;}
.twitter { background-color: #000000 !important; color: white !important; margin-top: 10px !important;}
.whatsapp { background-color: #25D366 !important; color: white !important; margin-top: 10px !important;}
.telegram { background-color: #0088cc !important;color: white !important; margin-top: 10px !important;}
.linkedin { background-color: #0077b5 !important; color: white !important; margin-top: 10px !important; }
.copy-link { background-color: #6c757d !important;color: white !important; font-size: 11px !important; margin-top: 10px !important; }

/* Icon Sizes */
.share-btn i, 
.share-btn img {
    font-size: 16px;
}

/* Medium & Small Screens: icons only */
@media (max-width: 991px) {
    .share-text {
        display: none;
    }
    .share-options {
        flex-wrap: nowrap;
        overflow-x: auto;
    }
    .share-btn {
        flex: 1 0 auto;
        padding: 8px;
        border-radius: 50%;
        width: 40px;
        height: auto;
    }
    .share-btn i, 
    .share-btn img {
        margin: 0;
    }
}

</style>
@endsection
