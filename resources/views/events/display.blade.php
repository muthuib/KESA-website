@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 100px;">
    <h1 class="text-center my-4">Upcoming Events</h1>

    <div class="row">
        @php
            $hasUpcomingEvents = false;
        @endphp

        @foreach($events as $event)
            @if(\Carbon\Carbon::parse($event->start_date)->isFuture()) <!-- Only show future events -->
                @php
                    $hasUpcomingEvents = true;
                @endphp
                <div class="col-12 mb-4">
                    <div class="card h-100 shadow-sm w-100">
                        <div class="card-body">
                            <h5 class="card-title fw-bold text-md-start text-center event-title">
                                Event Title: {{ $event->name }}
                            </h5>

                            <div class="row align-items-center">
                                <!-- Event Details on the Left -->
                                <div class="col-md-8">
                                    <p class="card-text event-text">
                                        <strong>Location:</strong> {{ $event->location }} <br>
                                        <strong>Venue:</strong> {{ $event->venue }} <br>
                                        <strong>Date:</strong> {{ \Carbon\Carbon::parse($event->start_date)->format('F j, Y') }} <br>
                                        <strong>Start Time:</strong> {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} <br>
                                        <strong>End Time:</strong> {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }} <br>

                                        <strong>Description:</strong>
                                        @if(strlen($event->description) > 600)
                                            <span class="short-description">
                                                {{ Str::limit($event->description, 600) }}
                                            </span>
                                            <span class="full-description d-none">
                                                {{ $event->description }}
                                            </span>
                                            <a href="#" class="toggle-description text-primary">See More</a>
                                        @else
                                            <span>{{ $event->description }}</span>
                                        @endif
                                    </p>
                                </div>

                                <!-- Event Image on the Right -->
                                @if($event->image)
                                    <div class="col-md-4 text-center">
                                        <div class="event-image">
                                            <img src="{{ asset($event->image) }}" alt="{{ $event->name }}" class="img-fluid rounded event-img">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach

        <!-- Display message if no upcoming events are found -->
        @if(!$hasUpcomingEvents)
            <div class="col-12">
                <div class="alert alert-info text-center" role="alert">
                    <h4 class="alert-heading">No Upcoming Events</h4>
                    <p>We currently have no upcoming events scheduled. Please check back later for updates!</p>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    /* Default large screen settings */
    .event-title {
        font-size: 2rem; /* Large size for bigger screens */
    }

    .event-text {
        font-size: 1.125rem; /* Standard readable size */
    }

    .event-img {
        width: 700px;
        height: 350px;
        max-width: 100%;
    }

    /* Medium screens (tablets, 768px and below) */
    @media (max-width: 992px) {
        .event-title {
            font-size: 1.5rem; /* Reduce title font size */
        }

        .event-text {
            font-size: 1rem; /* Reduce text size */
        }

        .event-img {
            width: 100%; /* Adjust image to fit smaller screens */
            height: auto;
        }
    }

    /* Small screens (mobile, 576px and below) */
    @media (max-width: 768px) {
        .event-title {
            font-size: 1.25rem; /* Even smaller for mobile */
        }

        .event-text {
            font-size: 0.95rem; /* Reduce text size for smaller screens */
        }

        .event-img {
            max-width: 90%;
            height: auto;
        }
    }

    /* Extra small screens (very small devices, <576px) */
    @media (max-width: 576px) {
        .event-title {
            font-size: 1rem; /* Smallest title size */
        }

        .event-text {
            font-size: 0.875rem; /* Compact text */
        }

        .event-img {
            max-width: 100%; /* Full width for tiny screens */
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleLinks = document.querySelectorAll('.toggle-description');
        toggleLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const parent = this.closest('.card-text');
                const shortDesc = parent.querySelector('.short-description');
                const fullDesc = parent.querySelector('.full-description');
                if (fullDesc.classList.contains('d-none')) {
                    shortDesc.classList.add('d-none');
                    fullDesc.classList.remove('d-none');
                    this.textContent = 'See Less';
                } else {
                    shortDesc.classList.remove('d-none');
                    fullDesc.classList.add('d-none');
                    this.textContent = 'See More';
                }
            });
        });
    });
</script>
@endsection
