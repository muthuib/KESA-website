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
                <div class="card shadow mb-4">
                    <div class="card-body text-center">
                        <video width="100%" height="auto" controls>
                            <source src="{{ asset($activity->video) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <p class="d-none d-lg-block">{{ $activity->description }}</p>
                        <p class="d-lg-none" style="font-size: 14px;">
                            {{ Str::limit($activity->description, 100) }}
                        </p>
                        <div class="mt-3">
                            <a href="{{ asset($activity->video) }}" class="btn btn-outline-primary" download>
                                <i class="fas fa-download"></i> Download Video
                            </a>
                        </div>

                        <!-- Display YouTube Link Below Download Button -->
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

<!-- Read More / Read Less Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.read-more').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                let parent = this.parentElement;
                parent.querySelector('.short-text').classList.add('d-none');
                parent.querySelector('.full-text').classList.remove('d-none');
                this.classList.add('d-none');
                parent.querySelector('.read-less').classList.remove('d-none');
            });
        });

        document.querySelectorAll('.read-less').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                let parent = this.parentElement;
                parent.querySelector('.full-text').classList.add('d-none');
                parent.querySelector('.short-text').classList.remove('d-none');
                this.classList.add('d-none');
                parent.querySelector('.read-more').classList.remove('d-none');
            });
        });
    });
</script>

@endsection

<style>
    @media (max-width: 768px) { /* Tablets and smaller */
        #event-heading {
            font-size: 32px;
        }
    }

    @media (max-width: 576px) { /* Phones */
        #event-heading {
            font-size: 24px;
        }
    }
</style>
