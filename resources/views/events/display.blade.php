@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 70px;">
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
                    <div class="card h-100 shadow-sm" style="width: 100%; margin-left: 0px;">
                        <div class="card-body">
                            <h5 class="card-title" style="font-size: 35px;"><strong>Event Title:</strong> {{ $event->name }}</h5>

                            <div class="row">
                                <!-- Event Details on the Left -->
                                <div class="col-md-8">
                                    <p class="card-text">
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
                                    <div class="col-md-4">
                                        <div class="event-image">
                                            <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}" class="img-fluid rounded" style="max-height: 1250px; width: 700px; height: 350px;">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- <div class="card-footer text-center">
                            <a href="{{ route('tickets.buy', ['event' => $event->id]) }}" class="btn btn-primary">Book Ticket</a>
                        </div> -->
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
