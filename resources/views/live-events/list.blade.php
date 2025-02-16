@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 80px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Live Events & Meetings</h2>
    </div>

    <!-- Events List (Hidden when watching live) -->
    <div id="eventsList">
        <div class="row">
            @foreach($events as $event)
                <div class="col-md-4">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title">{{ $event->title }}</h5>
                            <p class="text-muted">
                                <i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($event->date_time)->format('M d, Y - h:i A') }}
                            </p>
                            <p><strong>Platform:</strong> {{ $event->platform }}</p>
                            <button class="btn btn-danger" onclick="showLiveEvent('{{ $event->title }}', '{{ $event->platform }}', '{{ $event->link }}')">
                                <i class="fas fa-play-circle"></i> Watch Live
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($events->isEmpty())
            <p class="text-center text-muted">No live events available at the moment.</p>
        @endif
    </div>

    <!-- Live Video Section (Initially Hidden) -->
    <div id="liveEventSection" class="mt-5" style="display: none;">
        <!-- Back to Events Button Moved to Right -->
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-dark" onclick="closeLiveEvent()">
                <i class="fas fa-backward"></i> Back to Events
            </button>
        </div>

        <h3>Now Watching: <span id="eventTitle"></span></h3>
        <div class="embed-responsive embed-responsive-16by9">
            <iframe id="videoFrame" width="100%" height="450px" frameborder="0" allowfullscreen></iframe>
        </div>

        <!-- YouTube Comment Section -->
        <div id="youtubeCommentSection" class="mt-4" style="display: none;">
            <h4>YouTube Comments</h4>
            <iframe id="youtubeComments" width="100%" height="500px" frameborder="0"></iframe>
        </div>

        <!-- Facebook Comment Section -->
        <div id="facebookCommentSection" class="mt-4" style="display: none;">
            <h4>Facebook Comments</h4>
            <div class="fb-comments" id="facebookComments" data-width="100%" data-numposts="5"></div>
        </div>
    </div>
</div>

<!-- Facebook SDK for Comments -->
<script>
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v12.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    function showLiveEvent(title, platform, link) {
        let liveSection = document.getElementById('liveEventSection');
        let videoFrame = document.getElementById('videoFrame');
        let eventTitle = document.getElementById('eventTitle');
        let youtubeCommentSection = document.getElementById('youtubeCommentSection');
        let facebookCommentSection = document.getElementById('facebookCommentSection');
        let youtubeComments = document.getElementById('youtubeComments');
        let facebookComments = document.getElementById('facebookComments');
        let eventsList = document.getElementById('eventsList');

        // Hide the events list when watching live
        eventsList.style.display = "none";

        // Reset comment sections
        youtubeCommentSection.style.display = "none";
        facebookCommentSection.style.display = "none";

        // Set event title
        eventTitle.innerText = title;

        // Handle YouTube links
        if (link.includes("youtube.com") || link.includes("youtu.be")) {
            let videoId = link.split("v=")[1] || link.split("/").pop();
            videoId = videoId.split("&")[0]; // Remove additional parameters
            videoFrame.src = "https://www.youtube.com/embed/" + videoId;
            youtubeComments.src = "https://www.youtube.com/live_chat?v=" + videoId + "&embed_domain=" + window.location.hostname;
            youtubeCommentSection.style.display = "block";
        }
        // Handle Facebook links
        else if (link.includes("facebook.com")) {
            videoFrame.src = "https://www.facebook.com/plugins/video.php?href=" + encodeURIComponent(link);
            facebookComments.setAttribute("data-href", link);
            facebookCommentSection.style.display = "block";

            // Reload Facebook SDK for comments
            FB.XFBML.parse();
        }
        // Handle other platforms (open in a new tab)
        else {
            alert("This platform cannot be embedded. Opening in a new tab.");
            window.open(link, "_blank");
            return;
        }

        // Show the live event section
        liveSection.style.display = "block";
    }

    function closeLiveEvent() {
        let liveSection = document.getElementById('liveEventSection');
        let eventsList = document.getElementById('eventsList');
        let videoFrame = document.getElementById('videoFrame');

        // Hide live event section and show events list
        liveSection.style.display = "none";
        eventsList.style.display = "block";

        // Stop video playback
        videoFrame.src = "";
    }
</script>

@endsection
