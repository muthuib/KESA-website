@extends('layouts.app')

@section('title', $blog->title)

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
<div class="text-dark py-4 px-0 responsive-header"
     style="margin-top: {{ Auth::check() ? '0' : '120px' }}; margin-bottom: 8px; background-color: rgb(243, 233, 233);">
    <div class="container-fluid px-4">
        <h2 class="mb-0 blog-title w-100">{{ $blog->title }}</h2>
        <p class="text-muted mt-2" style="font-size: 0.9rem;">
            ⏱️ Estimated Read Time: {{ ceil(str_word_count(strip_tags($blog->content)) / 200) }} min read
        </p>
    </div>
</div>

<!-- Blog Content + Sidebar -->
<div class="container-custom {{ Auth::check() ? 'full-width' : '' }}">
    <!-- LEFT COLUMN -->
    <div class="left-column {{ Auth::check() ? 'expand-full' : '' }}">
        @if($blog->image)
        <div class="image-share-wrapper mb-3">
            <img src="{{ asset($blog->image) }}" class="blog-image" alt="Blog Image">
            <div class="share-section">
                <button class="btn btn-primary btn-sm" onclick="toggleShareOptions()">📤 Share</button>
                <button class="btn btn-secondary btn-sm" onclick="copyLink()">🔗 Copy Link</button>
                <div id="share-options" class="share-options mt-2">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank">
                        <i class="fab fa-facebook" style="color: #3b5998;"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($blog->title) }}" target="_blank">
                        <img src="/assets/images/x-logo.png" alt="Twitter X" width="17" height="17">
                    </a>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($blog->title . ' ' . url()->current()) }}" target="_blank">
                        <i class="fab fa-whatsapp" style="color: #25D366;"></i>
                    </a>
                    <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($blog->title) }}" target="_blank">
                        <i class="fab fa-telegram" style="color: #0088cc;"></i>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($blog->title) }}" target="_blank">
                        <i class="fab fa-linkedin" style="color: #0077b5;"></i>
                    </a>
                </div>
            </div>
        </div>
        @endif
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

        <p class="text-muted mb-1">
            <strong>{{ \Carbon\Carbon::parse($blog->date)->format('l, F j, Y') }}</strong>
        </p>
        <p class="text-secondary mb-2" style="font-size: 0.9rem;">
            <i class="bi bi-person"></i> Author: <strong>{{ $blog->author ?? 'Admin' }}</strong> &nbsp; | &nbsp;
            📂 Category: <strong>{{ $blog->category ?? 'Uncategorized' }}</strong>
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

        <!-- Blog Content -->
        <div class="blog-content">
            {!! $blog->content !!}
        </div>

        <!-- Footer Notice -->
        <div class="blog-footer mt-5 pt-4 border-top">
            <p class="small text-muted mb-2">&copy; {{ date('Y') }} All rights reserved. This blog is the property of {{ config('app.name') }}.</p>
            <p class="small text-muted">
                <strong>Disclaimer:</strong> The views and opinions expressed in this blog post are those of the author and do not necessarily reflect the official policy or position of {{ config('app.name') }}. Any content provided is for informational purposes only.
            </p>
        </div>
    </div>

    <!-- RIGHT COLUMN - READ ALSO -->
    @guest
    <div class="right-column">
        <h5 class="read-also-title">📌 Most Popular</h5>
        <ul class="read-also-list">
            @foreach($otherBlogs->take(10) as $item)
            <li class="read-also-item">
                <a href="{{ route('blog.show', $item->id) }}" class="read-also-link">
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
.container-custom {
    display: flex;
    flex-wrap: nowrap;
    margin-top: 0;
    padding: 0;
    gap: 40px;
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
    justify-content: space-between;
    align-items: flex-start;
    gap: 15px;
    flex-wrap: wrap;
}

.blog-image {
    max-width: 30%;
    height: auto;
    flex-grow: 1;
    margin-left: 15px;
}

.share-section {
    align-self: flex-start;
}

.share-options a {
    margin-right: 8px;
    font-size: 1.2rem;
}

.blog-title {
    text-align: left;
    font-size: 28px;
    font-weight: bold;
}

.blog-content {
    line-height: 1.7;
    font-size: 0.95rem;
    color: #333;
    text-align: left;
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

</style>
@endsection
