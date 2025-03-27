@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 id="event-heading" class="mb-4 text-center" style="margin-top: 90px; font-weight: bold;">
        Our Past Events and Activities
    </h2>

    <p class="text-center d-none d-lg-block" style="font-size: 18px;">
        KESA has successfully organized and hosted numerous impactful events aimed at fostering education, research, and collaboration among scholars, professionals, and students.
    </p>
    <p class="text-center d-lg-none" style="font-size: 16px;">
        KESA has hosted impactful events fostering education, research, and collaboration.
    </p>

    <div class="row">
        @foreach($activities as $activity)
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <p class="text-center" style="font-size: 20px; font-weight: bold; color: brown;">
                    {{ $activity->title }}
                </p>
                <div class="card shadow mb-4" style="height: 500px">
                    <div class="card-body text-center">
                        @if(Str::endsWith($activity->media, ['.mp4', '.mov', '.avi', '.mkv', '.flv', '.wmv']))
                            <!-- Display Video -->
                            <video width="100%" height="auto" controls>
                                <source src="{{ asset($activity->media) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            <div class="mt-3">
                                <a href="{{ asset($activity->media) }}" class="btn btn-outline-primary" download>
                                    <i class="fas fa-download"></i> Download Video
                                </a>
                            </div>
                        @elseif(Str::endsWith($activity->media, ['.jpg', '.jpeg', '.png', '.gif', '.webp']))
                            <!-- Display Image -->
                            <img src="{{ asset($activity->media) }}" alt="Uploaded Image" class="img-fluid" style="max-width: 100%; height: auto;">
                        @endif
                        <!-- Truncated Description with Read More next to it -->
                        @php
                            $truncatedDescription = Str::limit($activity->description, 100);
                            $isTruncated = strlen($activity->description) > 100;
                        @endphp

                        <!-- Display the truncated description -->
                        <p class="short-text" style="text-align: left; display: inline;">
                            {{ $truncatedDescription }}.
                        </p>

                        <!-- Show "Read More" only if the description is actually truncated -->
                        @if($isTruncated)
                            <button class="btn btn-sm btn-link read-more" data-toggle="modal" data-target="#descriptionModal"
                                data-title="{{ $activity->title }}" 
                                data-description="{{ $activity->description }}" 
                                style="margin-top: 0px; display: inline; padding: 0; border: none; background: none; color: #007bff; text-decoration: none;">
                                Read More
                            </button>
                        @endif
                        <!-- Display YouTube Link Below Media -->
                        @if(!empty($activity->youtube_link))
                            <div class="mt-2">
                                <a href="{{ $activity->youtube_link }}" class="btn btn-outline-danger" target="_blank">
                                    <i class="fab fa-youtube"></i> Watch on YouTube
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($activities->isEmpty())
        <p class="text-center text-muted bg-info">No Past events available at the moment.</p>
    @endif
</div>

<!-- Modal Structure -->
<div class="modal fade" id="descriptionModal" tabindex="-1" aria-labelledby="descriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="descriptionModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalDescription"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

<!-- Script to Handle Modal Content -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#descriptionModal').on('show.bs.modal', function(event) {
            let button = $(event.relatedTarget); 
            let title = button.data('title');
            let description = button.data('description');

            let modal = $(this);
            modal.find('.modal-title').text(title);
            modal.find('#modalDescription').text(description);
        });
    });
</script>

<!-- Custom Styling -->
<style>
    .read-more {
        color: #007bff;
        cursor: pointer;
        text-decoration: none;
        border: none;
        background: none;
    }

    .read-more:hover {
        text-decoration: underline;
    }
</style>
