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
        @php
            $plainText = strip_tags($activity->description);
            $preview = Str::limit($plainText, 370, '');
            $remaining = strlen($plainText) > 370;
            $uniqueId = 'desc_' . $activity->id;
        @endphp

        <div class="col-12 mb-4">
            <div class="card shadow-sm p-3">
                <div class="row g-3">
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
                    <div class="col-md-9">
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

                        <!-- Inline Truncated Description + Read More -->
                        <div class="description-preview text-muted">
                            @if($remaining)
                                <span class="truncated-text">{{ $preview }}...</span>
                                <button class="btn btn-sm btn-link toggle-description p-0" data-target="{{ $uniqueId }}" data-action="show">Read More</button>
                            @else
                                <span>{!! preg_replace('/(<p><br><\/p>\s*)+$/', '', $activity->description) !!}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Full Description -->
                    @if($remaining)
                        <div class="col-12">
                            <div class="description-wrapper collapsed" id="{{ $uniqueId }}">
                                {!! preg_replace('/(<p><br><\/p>\s*)+$/', '', $activity->description) !!}
                                <button class="btn btn-sm btn-link toggle-description p-0 m-0 align-baseline ms-1" data-target="{{ $uniqueId }}" data-action="hide">Read Less</button>

                                {{-- Additional Images Section --}}
                                @if($activity->media1 || $activity->media2 || $activity->media3)
                                    <div class="card shadow mb-4 mt-3">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="fas fa-images text-info"></i> More Images from the Event</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row text-center">
                                                @foreach (['media1', 'media2', 'media3'] as $img)
                                                    @if ($activity->$img)
                                                        <div class="col-md-4 mb-3">
                                                            <img src="{{ asset($activity->$img) }}" alt="Additional Image" class="img-fluid rounded shadow" style="max-height: 300px;">
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach

        @if($activities->isEmpty())
            <p class="text-center text-muted bg-info p-3 rounded">No past events available at the moment.</p>
        @endif
    </div>
</div>
@endsection

<!-- Toggle Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.toggle-description').forEach(button => {
            button.addEventListener('click', () => {
                const targetId = button.getAttribute('data-target');
                const desc = document.getElementById(targetId);
                const action = button.getAttribute('data-action');
                const card = button.closest('.card');
                const previewContainer = card.querySelector('.description-preview');
                const truncatedText = previewContainer.querySelector('.truncated-text');
                const readMoreButton = previewContainer.querySelector('button[data-action="show"]');

                if (action === 'show') {
                    desc.classList.remove('collapsed');
                    truncatedText.style.display = 'none';
                    readMoreButton.style.display = 'none';
                } else if (action === 'hide') {
                    desc.classList.add('collapsed');
                    truncatedText.style.display = 'inline';
                    readMoreButton.style.display = 'inline';
                    window.scrollTo({
                        top: previewContainer.offsetTop - 100,
                        behavior: 'smooth'
                    });
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
        border-radius: 0.5rem;
    }

    .description-preview {
        font-size: 0.95rem;
    }

    .description-wrapper {
        overflow: hidden;
        max-height: 0;
        opacity: 0;
        transition: max-height 0.4s ease, opacity 0.4s ease;
    }

    .description-wrapper.collapsed {
        max-height: 0;
        opacity: 0;
        padding: 0;
        margin: 0;
    }

    .description-wrapper:not(.collapsed) {
        max-height: none;
        opacity: 1;
    }

    .toggle-description {
        font-size: 0.85rem;
        cursor: pointer;
        font-weight: bold;
        color: #007bff;
        background: none;
        border: none;
    }

    .truncated-text {
        display: inline;
    }

    /* Remove extra margin/padding from last child in long descriptions */
    .description-wrapper > *:last-child {
        margin-bottom: 0 !important;
        padding-bottom: 0 !important;
    }

    /* Hide trailing empty Quill paragraphs */
    .description-wrapper p:empty,
    .description-wrapper p:has(br:only-child) {
        display: none !important;
    }

    @media (max-width: 768px) {
        .media-item {
            max-height: 200px;
        }
    }
</style>
