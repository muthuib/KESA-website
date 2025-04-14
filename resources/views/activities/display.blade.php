@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 id="event-heading" class="mb-4 text-center" style="margin-top: 90px; font-weight: bold;">
        Our Past Events and Activities
    </h2>

    <p class="text-center d-none d-lg-block" style="font-size: 18px;">
        KESA has successfully organized and hosted numerous impactful events aimed at fostering education, research, and collaboration among scholars, professionals, and students.
    </p>
    <p class="text-center d-lg-none" style="font-size: 14px;">
        KESA has hosted impactful events fostering education, research, and collaboration.
    </p>

    <div class="row">
        @foreach($activities as $activity)
        <div class="col-12 mb-4">
            <div class="card shadow-sm p-3">
                <div class="row">
                    <!-- Media Column -->
                    <div class="col-md-3">
                        @if(Str::endsWith($activity->media, ['.mp4', '.mov', '.avi', '.mkv', '.flv', '.wmv']))
                            <video class="media-item mb-2" controls>
                                <source src="{{ asset($activity->media) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @elseif(Str::endsWith($activity->media, ['.jpg', '.jpeg', '.png', '.gif', '.webp']))
                            <img src="{{ asset($activity->media) }}" alt="Uploaded Image" class="img-fluid mb-2 media-item">
                        @endif

                        <div>
                            @if(!empty($activity->youtube_link))
                                <a href="{{ $activity->youtube_link }}" class="btn btn-outline-danger btn-sm me-2 mb-2" target="_blank">
                                    <i class="fab fa-youtube"></i> Watch
                                </a>
                            @endif
                            @if(Str::endsWith($activity->media, ['.mp4', '.mov', '.avi', '.mkv', '.flv', '.wmv']))
                                <a href="{{ asset($activity->media) }}" class="btn btn-outline-primary btn-sm mb-2" download>
                                    <i class="fas fa-download"></i> Download
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Info and Description -->
                    <div class="col-md-9 d-flex flex-column">
                        <h6 class="text-secondary fw-bold">{{ $activity->title }}</h6>

                        @if($activity->date)
                            <p class="mb-1"><i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($activity->date)->format('F j, Y') }}</p>
                        @endif

                        @if($activity->start_time && $activity->end_time)
                            <p class="mb-1">
                                <i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($activity->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($activity->end_time)->format('g:i A') }}
                            </p>
                        @endif

                        @if($activity->location)
                            <p class="mb-3"><i class="fas fa-map-marker-alt text-primary"></i> {{ $activity->location }}</p>
                        @endif

                        @php
                            // Clean and prepare the description
                            $description = strip_tags($activity->description ?? '');
                            $desktopLimit = 360;

                            // Truncate and add a hyphen at the end of the last word
                            $truncated = Str::limit($description, $desktopLimit, '');
                            $truncatedWithHyphen = preg_replace('/\w+$/', '$0-', $truncated);

                            $remaining = Str::substr($description, $desktopLimit);
                            $hasMore = strlen($description) > $desktopLimit;
                            $uniqueId = 'desc_' . $activity->id;
                        @endphp

                        <!-- Truncated View -->
                        <div class="description-toggle text-justify">
                            <span id="{{ $uniqueId }}_short" class="d-block">
                                {{ $truncatedWithHyphen }}
                                @if($hasMore)
                                    <button class="btn btn-sm btn-link toggle-description" data-id="{{ $uniqueId }}" id="{{ $uniqueId }}_readmore">Read More</button>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Full Description in Block Format -->
                @if($hasMore)
                    <div class="full-description mt-3" id="{{ $uniqueId }}_full" style="display: none;">
                        <p class="text-justify">{{ $remaining }}</p>
                        <button class="btn btn-sm btn-link toggle-description" data-id="{{ $uniqueId }}">Read Less</button>
                    </div>
                @endif
            </div>
        </div>
        @endforeach

        @if($activities->isEmpty())
            <p class="text-center text-muted bg-info">No Past events available at the moment.</p>
        @endif
    </div>
</div>
@endsection

<!-- Toggle Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.toggle-description').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const id = this.dataset.id;
                const shortEl = document.getElementById(`${id}_short`);
                const fullEl = document.getElementById(`${id}_full`);
                const readMoreBtn = document.getElementById(`${id}_readmore`);

                if (shortEl.style.display === 'none') {
                    fullEl.style.display = 'none';
                    shortEl.style.display = 'block';
                    if (readMoreBtn) readMoreBtn.style.display = 'inline';
                } else {
                    shortEl.style.display = 'none';
                    fullEl.style.display = 'block';
                    if (readMoreBtn) readMoreBtn.style.display = 'none';
                }
            });
        });
    });
</script>

<!-- Styles -->
<style>
    .media-item {
        width: 100%;
        max-height: 180px;
        object-fit: cover;
    }

    .toggle-description {
        font-size: 0.85rem;
        padding-left: 5px;
    }

    .description-toggle {
        line-height: 1.6;
        margin-top: 5px;
    }

    .full-description {
        margin-top: 15px;
        font-size: 1rem;
        text-align: justify;
    }

    @media (max-width: 768px) {
        .media-item {
            max-height: 200px;
        }
    }
</style>
