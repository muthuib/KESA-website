@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mt-4">
        <!-- Page Title -->
        <div class="col-12">
            <h2 class="text-center text-primary animate__animated animate__fadeIn">Statistics</h2>
            <hr class="animate__animated animate__fadeIn">
        </div>
    </div>

    <!-- Cards Section -->
    <div class="row text-center">
        <div class="col-lg-3 col-md-6 mb-4 animate__animated animate__fadeInUp">
            <div class="card shadow-lg border-light rounded">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="display-4 text-success">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4 animate__animated animate__fadeInUp">
            <div class="card shadow-lg border-light rounded">
                <div class="card-body">
                    <h5 class="card-title">Publications</h5>
                    <p class="display-4 text-info">{{ $totalPublications }}</p>
                </div>
            </div>
        </div>
        <!-- <div class="col-lg-3 col-md-6 mb-4 animate__animated animate__fadeInUp">
            <div class="card shadow-lg border-light rounded">
                <div class="card-body">
                    <h5 class="card-title">Resources</h5>
                    <p class="display-4 text-warning">{{ $totalResources }}</p>
                </div>
            </div>
        </div> -->
        <div class="col-lg-3 col-md-6 mb-4 animate__animated animate__fadeInUp">
            <div class="card shadow-lg border-light rounded">
                <div class="card-body">
                    <h5 class="card-title">Newsletters</h5>
                    <p class="display-4 text-danger">{{ $totalNewsletters }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4 animate__animated animate__fadeInUp">
            <div class="card shadow-lg border-light rounded">
                <div class="card-body">
                    <h5 class="card-title">Collaborators</h5>
                    <p class="display-4 text-primary">{{ $totalCollaborators }}</p>
                </div>
            </div>
        </div>

        <!-- ADD THIS: Total Members -->
        <div class="col-lg-3 col-md-6 mb-4 animate__animated animate__fadeInUp">
            <div class="card shadow-lg border-light rounded">
                <div class="card-body">
                    <h5 class="card-title">Total Members</h5>
                    <p class="display-4 text-secondary">{{ $totalMembers }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row mt-4">
        <div class="col-lg-6 mb-4 animate__animated animate__fadeInUp">
            <div class="card shadow-lg border-light rounded">
                <div class="card-body">
                    <h5 class="card-title text-center">Growth Overview</h5>
                    <canvas id="growthChart" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4 animate__animated animate__fadeInUp">
   <!-- Insights Section (Actionable Growth Statistics) -->
         <div class="row mt-4">
            <div class="card shadow-lg border-light rounded">
                <div class="card-body">
                    <h5 class="card-title text-center">Key Growth Insights</h5>
                    <ul>
                        <li><strong>Increase Member Engagement:</strong> Aim for at least a 10% increase in user activity by introducing gamified challenges or loyalty rewards.</li>
                        <li><strong>Content Strategy:</strong> Boost content engagement by creating 5 new interactive publications each month and promoting them through targeted newsletters.</li>
                        <li><strong>Collaborator Growth:</strong> Focus on expanding partnerships by reaching out to 3 new organizations for collaborations each quarter.</li>
                        <li><strong>Optimize Resource Utilization:</strong> Enhance resource usage by tracking which content is most downloaded and ensuring it's easily accessible and promoted.</li>
                        <li><strong>Improve Visibility:</strong> Target a 15% growth in website traffic by optimizing for SEO and increasing social media presence.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card shadow-lg border-light rounded">
                <div class="card-body">
                    <h5 class="card-title text-center">Actionable Steps to Growth</h5>
                    <ul>
                        <li><strong>Focus on User Retention:</strong> Target inactive members with personalized emails to re-engage them with new features or events.</li>
                        <li><strong>Enhance User Experience:</strong> Gather feedback from users to improve platform features, focusing on ease of navigation and speed.</li>
                        <li><strong>New Member Acquisition:</strong> Invest in online marketing, targeting potential members with a special incentive for signing up (e.g., discounts, exclusive access to content).</li>
                        <li><strong>Collaborator Programs:</strong> Introduce a referral program for existing collaborators to bring in new partners, with mutual benefits.</li>
                        <li><strong>Increase Publication Interactions:</strong> Implement features like 'commenting' or 'liking' publications to encourage interactions from the user base.</li>
                    </ul>
                </div>
            </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Growth Chart (Bar Chart)
    const growthCtx = document.getElementById('growthChart').getContext('2d');
    new Chart(growthCtx, {
        type: 'bar',  // Changed to bar chart
        data: {
            labels: @json($growthLabels),  // Labels: months (Jan, Feb, etc.)
            datasets: [{
                label: 'User Growth Rate (%)',
                data: @json($growthRates['users']),  // User growth rate for each month
                backgroundColor: 'rgba(75, 192, 192, 0.6)',  // Bar color for User Growth Rate
                borderColor: 'rgba(75, 192, 192, 1)',  // Border color for User Growth Rate
                borderWidth: 1,
                fill: false
            }, {
                label: 'Publication Growth Rate (%)',
                data: @json($growthRates['publications']),  // Publication growth rate for each month
                backgroundColor: 'rgba(153, 102, 255, 0.6)',  // Bar color for Publication Growth Rate
                borderColor: 'rgba(153, 102, 255, 1)',  // Border color for Publication Growth Rate
                borderWidth: 1,
                fill: false
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    min: 0,  // Start Y-axis at 0
                    max: 100,  // End Y-axis at 100
                    ticks: {
                        stepSize: 10  // Set step size for Y-axis ticks
                    },
                    title: {
                        display: true,
                        text: 'Growth Rate (%)'  // Label for Y-axis
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Month'  // Label for X-axis
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top'  // Position of the legend
                },
                tooltip: {
                    callbacks: {
                        // Customize tooltip to show percentage growth
                        label: function(tooltipItem) {
                            return tooltipItem.raw + '%';  // Show percentage with '%' symbol
                        }
                    }
                }
            }
        }
    });

</script>
@endsection
