<div class="container impact-overview-container">
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
.impact-overview-container {
    padding-top: 20px;
    padding-bottom: 20px;
    margin-top: 60; /* No margin top */
}

/* Impact card styling */
.impact-card {
    width: 100%;
    max-width: 280px;
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

/* Medium screens */
@media (max-width: 768px) {
    .impact-overview-container {
    padding-top: 20px;
    padding-bottom: 20px;
    margin-top: 0; /* No margin top */
}
    .impact-card {
        max-width: 220px;
        margin: 0.75rem auto;
        height: 250px;
    }

    .impact-icon {
        font-size: 1.6rem;
    }

    .impact-title {
        font-size: 9px;
        text-align: left;
    }

    .impact-count {
        font-size: 20px;
    }
}

/* Small screens */
@media (max-width: 576px) {
    .impact-overview-container {
    padding-top: 20px;
    padding-bottom: 20px;
    margin-top: 0; /* No margin top */
}
    .impact-card {
        max-width: 180px;
        margin: 0.75rem auto;
        padding: 0.5rem;
        height: 250px;
    }

    .impact-icon {
        font-size: 1.4rem;
    }

    .impact-title {
        font-size: 7px;
        text-align: left;
    }

    .impact-count {
        font-size: 18px;
    }
}
</style>
