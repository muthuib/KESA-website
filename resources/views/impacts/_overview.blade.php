<div class="container py-5" style="margin-top: 40px;">
    <h2 class="mb-4 text-center">📊 Impact Overview</h2>

    <div class="row row-cols-3 row-cols-sm-3 row-cols-md-3 g-3 justify-content-start text-center">
        <!-- Total events -->
        <div class="col">
            <div class="card impact-card border-0 shadow-lg rounded-4 p-3 bg-light">
                <div class="mb-2">
                <i class="fas fa-calendar-check impact-icon text-success"></i>
                </div>
                <h5 class="fw-bold impact-title">Events Held</h5>
                <h2 class="impact-count text-primary fw-bold" id="totalPeople">0</h2>
            </div>
        </div>

        <!-- Total people reached-->
        <div class="col">
            <div class="card impact-card border-0 shadow-lg rounded-4 p-3 bg-light">
                <div class="mb-2">
                <i class="fas fa-users impact-icon text-primary"></i>
                </div>
                <h5 class="fw-bold impact-title" style="text-align: center;">People Reached</h5>
                <h2 class="impact-count text-success fw-bold" id="totalEvents">0</h2>
            </div>
        </div>

        <!-- Total leadership and fellows -->
        <div class="col">
            <div class="card impact-card border-0 shadow-lg rounded-4 p-3 bg-light">
                <div class="mb-2">
                    <i class="fas fa-chalkboard-teacher impact-icon text-warning"></i>
                </div>
                <h5 class="fw-bold impact-title">Certified Leadership Fellows</h5>
                <h2 class="impact-count text-warning fw-bold" id="totalTrainings">0</h2>
            </div>
        </div>
    </div>
</div>

<style>
  .impact-card {
    width: 100%; /* Full width */
    max-width: 280px; /* Max width for larger screens */
    padding: 1rem;
    margin: auto;
}

.impact-icon {
    font-size: 2rem;
}

.impact-title {
    font-size: 16px;
}

.impact-count {
    font-size: 26px;
}

/* Medium screens (tablets) */
@media (max-width: 768px) {
    .impact-card {
        max-width: 220px; /* Smaller card width for tablets */
        margin: 0.75rem auto;
        height: 250px; /* Set a fixed height for the cards on medium screens */
    }

    .impact-icon {
        font-size: 1.6rem; /* Smaller icon size */
    }

    .impact-title {
        font-size: 9px; /* Smaller title text */
        text-align: left;
    }

    .impact-count {
        font-size: 20px; /* Smaller count text */
    }
}

/* Small screens (phones) */
@media (max-width: 576px) {
    .impact-card {
        max-width: 180px; /* Smaller card width for phones */
        margin: 0.75rem auto;
        padding: 0.5rem; /* Reduce padding for smaller card height */
        height: 250px; /* Uniform height for the cards on small screens */
    }

    .impact-icon {
        font-size: 1.4rem; /* Smaller icon size */
    }

    .impact-title {
        font-size: 7px; /* Smaller title text */
        text-align: left;
    }

    .impact-count {
        font-size: 18px; /* Smaller count text */
    }
}

</style>
