@extends('layouts.app') <!-- Ensure this extends your main layout -->

@section('content')
<div class="container-fluid">
    <div class="row mt-4">
        <!-- Page Title -->
        <div class="col-12">
            <h2 class="text-center">Dashboard</h2>
            <hr>
        </div>
    </div>

    <!-- Cards Section -->
    <div class="row text-center">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="display-4">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Resources</h5>
                    <p class="display-4">{{ $totalResources }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Newsletters</h5>
                    <p class="display-4">{{ $totalNewsletters }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Collaborators</h5>
                    <p class="display-4">{{ $totalCollaborators }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row mt-4">
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-center">Growth Overview</h5>
                    <canvas id="growthChart" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-center">Resource Distribution</h5>
                    <canvas id="resourceChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Growth Chart
    const growthCtx = document.getElementById('growthChart').getContext('2d');
    new Chart(growthCtx, {
        type: 'line',
        data: {
            labels: @json($growthLabels), // Use PHP variables passed from the controller
            datasets: [{
                label: 'Growth',
                data: @json($growthData),
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 2,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            }
        }
    });

    // Resource Distribution Chart
    const resourceCtx = document.getElementById('resourceChart').getContext('2d');
    new Chart(resourceCtx, {
        type: 'pie',
        data: {
            labels: @json($resourceLabels),
            datasets: [{
                data: @json($resourceData),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' }
            }
        }
    });
</script>
@endsection
