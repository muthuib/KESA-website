@extends('layouts.app')

@section('hide_footer')
@endsection

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">📊 Impact Overview</h2>

    <div class="row g-4">
        <!-- Total People -->
        <div class="col-md-4">
            <div class="card border-0 shadow-lg rounded-4 p-4 text-center h-100 bg-light">
                <div class="mb-3">
                    <i class="fas fa-users fa-2x text-primary"></i>
                </div>
                <h5 class="fw-bold">Total People Reached</h5>
                <h2 class="display-6 fw-bold text-primary" id="totalPeople">0</h2>
            </div>
        </div>

        <!-- Total Events -->
        <div class="col-md-4">
            <div class="card border-0 shadow-lg rounded-4 p-4 text-center h-100 bg-light">
                <div class="mb-3">
                    <i class="fas fa-calendar-check fa-2x text-success"></i>
                </div>
                <h5 class="fw-bold">Events Held</h5>
                <h2 class="display-6 fw-bold text-success" id="totalEvents">0</h2>
            </div>
        </div>

        <!-- Total Trainings -->
        <div class="col-md-4">
            <div class="card border-0 shadow-lg rounded-4 p-4 text-center h-100 bg-light">
                <div class="mb-3">
                    <i class="fas fa-chalkboard-teacher fa-2x text-warning"></i>
                </div>
                <h5 class="fw-bold">Trainings Conducted</h5>
                <h2 class="display-6 fw-bold text-warning" id="totalTrainings">0</h2>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function animateCount(id, endValue, duration = 1500) {
        const element = document.getElementById(id);
        let start = 0;
        const stepTime = Math.abs(Math.floor(duration / endValue));
        const timer = setInterval(() => {
            start++;
            element.textContent = start.toLocaleString();
            if (start >= endValue) clearInterval(timer);
        }, stepTime);
    }

    document.addEventListener('DOMContentLoaded', () => {
        animateCount('totalPeople', {{ $impact->total_people }});
        animateCount('totalEvents', {{ $impact->total_events }});
        animateCount('totalTrainings', {{ $impact->total_trainings }});
    });
</script>
@endsection
