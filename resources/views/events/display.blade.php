@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="fw-bold text-center mb-5" data-aos="fade-down" style="font-size: 30px;">
    🌟 Upcoming <span style="color: #20c997;">Events</span>
</h1>


    <div class="row g-4">
        @php $hasUpcomingEvents = false; @endphp

        @foreach($events as $event)
            @if(\Carbon\Carbon::parse($event->start_date)->isToday() || \Carbon\Carbon::parse($event->start_date)->isFuture())
                @php 
                    $hasUpcomingEvents = true; 
                    $eventDate = \Carbon\Carbon::parse($event->start_date);
                    $isToday = $eventDate->isToday();
                    $daysLeft = now()->diffInDays($eventDate, false);
                @endphp

                <div class="col-lg-6 col-md-6 col-12" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="event-card border-0 shadow-lg rounded-4 overflow-hidden position-relative h-100 d-flex flex-column">
                        <!-- Ribbon -->
                        <div class="event-ribbon {{ $isToday ? 'today' : 'upcoming' }}">
                            {{ $isToday ? 'Happening Today 🎉' : "In $daysLeft day".($daysLeft != 1 ? 's' : '') }}
                        </div>

                        <!-- Image & Meta Section -->
                        <div class="d-flex flex-md-row flex-column align-items-stretch">
                            @if($event->image)
                                <div class="col-md-5 p-0">
                                    <div class="event-img-wrapper">
                                        <img src="{{ asset($event->image) }}" alt="{{ $event->name }}" class="event-img">
                                    </div>
                                </div>
                            @endif

                            <div class="col-md-7 p-4 d-flex flex-column justify-content-between">
                                <div>
                                    <h4 class="fw-bold event-name mb-2">{{ $event->name }}</h4>

                                    <div class="event-meta mb-3">
                                        <p class="mb-1"><i class="bi bi-geo-alt text-danger me-1"></i> <strong>{{ $event->venue }}</strong></p>
                                        <p class="mb-1"><i class="bi bi-calendar-event text-success me-1"></i> {{ $eventDate->format('F j, Y') }}</p>
                                        <p class="mb-1"><i class="bi bi-clock text-warning me-1"></i> {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}</p>
                                    </div>

                                    <!-- Countdown -->
                                    <div class="countdown my-3" data-date="{{ $eventDate }}">
                                        <div class="d-flex justify-content-around align-items-center text-center"
                                            style="background: linear-gradient(90deg, #6a11cb, #2575fc);
                                                   color: #fff; border-radius: 1rem; padding: 10px 20px;
                                                   box-shadow: 0 6px 20px rgba(0,0,0,0.1);">
                                            <div><span class="fw-bold days fs-5">0</span><small class="d-block">Days</small></div>
                                            <div><span class="fw-bold hours fs-5">0</span><small class="d-block">Hrs</small></div>
                                            <div><span class="fw-bold minutes fs-5">0</span><small class="d-block">Mins</small></div>
                                            <div><span class="fw-bold seconds fs-5">0</span><small class="d-block">Secs</small></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description & Buttons -->
                        <div class="p-4 border-top bg-light-subtle d-flex flex-column justify-content-between">
                            <p class="text-muted event-description mb-3">
                                @if(strlen($event->description) > 220)
                                    <span class="short-description">{{ Str::limit($event->description, 220) }}</span>
                                    <span class="full-description d-none">{{ $event->description }}</span>
                                    <a href="#" class="toggle-description text-decoration-none fw-semibold text-primary">See More</a>
                                @else
                                    {{ $event->description }}
                                @endif
                            </p>

                            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                                <a href="{{ $event->link }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-4">
                                    <i class="bi bi-link-45deg"></i> Register here
                                </a>
                                <a href="https://calendar.google.com/calendar/render?action=TEMPLATE&text={{ urlencode($event->name) }}&dates={{ \Carbon\Carbon::parse($event->start_date)->format('Ymd') }}T{{ \Carbon\Carbon::parse($event->start_time)->format('His') }}/{{ \Carbon\Carbon::parse($event->end_time)->format('His') }}&details={{ urlencode($event->description) }}&location={{ urlencode($event->venue) }}" 
                                target="_blank" class="btn btn-sm btn-success rounded-pill px-4">
                                    <i class="bi bi-calendar-plus"></i> Add to Calendar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach

        @if(!$hasUpcomingEvents)
            <div class="col-12 mt-5">
                <div class="alert alert-light shadow-sm p-5 rounded-4 text-center">
                    <h4 class="fw-bold text-muted mb-3">No Upcoming Events</h4>
                    <p class="text-secondary mb-0">Stay tuned — we have exciting events coming soon!</p>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');

body {
    font-family: 'Poppins', sans-serif;
    background-color: #f8fbff;
}

/* SECTION TITLE */
.section-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: #101233;
    position: relative;
    display: inline-block;
}
.section-title span {
    background: linear-gradient(90deg, #ff6a00, #ee0979);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.section-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 120px;
    height: 5px;
    border-radius: 5px;
    background: linear-gradient(90deg, #007bff, #00c6ff);
    box-shadow: 0 3px 10px rgba(0, 123, 255, 0.3);
}
@media (max-width: 768px) {
    .section-title { font-size: 1.9rem; text-align: center; }
}

/* EVENT CARD */
.event-card {
    background: #fff;
    transition: all 0.4s ease;
    display: flex;
    flex-direction: column;
}
.event-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 28px rgba(0,0,0,0.12);
}

/* IMAGE */
.event-img-wrapper {
    width: 100%;
    height: 100%;
    min-height: 230px;
    overflow: hidden;
}
.event-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}
.event-card:hover .event-img { transform: scale(1.05); }

/* RIBBON */
.event-ribbon {
    position: absolute;
    top: 15px;
    left: 15px;
    background: linear-gradient(90deg, #0c582a, #19aa34);
    color: white;
    font-weight: 600;
    padding: 6px 16px;
    border-radius: 25px;
    font-size: 0.85rem;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    z-index: 2;
}
.event-ribbon.today { background: linear-gradient(90deg, #f39c12, #e67e22); }

/* COUNTDOWN */
.countdown div span {
    display: block;
    font-size: 1.3rem;
}

/* RESPONSIVE */
@media (max-width: 767px) {
    .event-img-wrapper { min-height: 180px; }
    .countdown div span { font-size: 1rem; }
}
</style>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({ duration: 800, once: true });

document.querySelectorAll('.toggle-description').forEach(link => {
    link.addEventListener('click', e => {
        e.preventDefault();
        const parent = link.closest('.event-description');
        parent.querySelector('.short-description').classList.toggle('d-none');
        parent.querySelector('.full-description').classList.toggle('d-none');
        link.textContent = link.textContent === 'See More' ? 'See Less' : 'See More';
    });
});

function updateCountdowns() {
    document.querySelectorAll('.countdown').forEach(cd => {
        const eventDate = new Date(cd.dataset.date);
        const now = new Date();
        const diff = eventDate - now;
        if (diff <= 0) return cd.innerHTML = "<span class='text-danger fw-bold'>Event Started!</span>";
        const days = Math.floor(diff / (1000*60*60*24));
        const hours = Math.floor((diff / (1000*60*60)) % 24);
        const minutes = Math.floor((diff / (1000*60)) % 60);
        const seconds = Math.floor((diff / 1000) % 60);
        cd.querySelector('.days').textContent = days;
        cd.querySelector('.hours').textContent = hours;
        cd.querySelector('.minutes').textContent = minutes;
        cd.querySelector('.seconds').textContent = seconds;
    });
}
setInterval(updateCountdowns, 1000);
updateCountdowns();
</script>
@endsection
