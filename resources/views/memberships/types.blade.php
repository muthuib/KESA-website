@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-3" style="margin-top: 90px;">Membership Categories</h2>
    <p id="intro-paragraph" class="text-left mb-5 px-3 text-muted" style="font-size: 17px;">
        KESA is a membership-based association that brings together Economics and Business students, young graduates, practising economists, policymakers, and other interested stakeholders from academia, civil society, and the corporate.
    </p>

    <!-- Membership Cards -->
    <div id="membership-cards" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 justify-content-center">
        @php
            $memberships = [
                [
                    'id' => 'student',
                    'title' => 'Student Member',
                    'description' => 'Open to university and TVET students pursuing Economics and Business.',
                    'registration_fee' => 'KES. 300',
                    'subscription_fee' => 'KES. 500',
                    'color' => 'bg-primary text-white',
                    'full_description' => 'This grade is open to students enrolled in universities and TVET institutions who  are pursuing programs related to Economics and Business.'
                ],
                [
                    'id' => 'associate',
                    'title' => 'Associate Member',
                    'description' => 'For graduates in the private/public sector with strong professional practice.',
                    'registration_fee' => 'KES. 500',
                    'subscription_fee' => 'KES. 1000',
                    'color' => 'bg-success text-white',
                    'full_description' => 'This grade of Associate Member is open to individuals who have completed an undergraduate programme and are actively engaged in either the private or public sector, having demonstrated a sound understanding of their professional practice'
                ],
                [
                    'id' => 'full',
                    'title' => 'Full Member',
                    'description' => 'For individuals in executive positions contributing to economic practice.',
                    'registration_fee' => 'KES. 1000',
                    'subscription_fee' => 'KES. 2000',
                    'color' => 'bg-warning text-dark',
                    'full_description' => 'This grade is awarded to individuals holding Executive Management positions in the private or public sector, who have made significant contributions to the advancement of Economic practice, as demonstrated by their qualifications, professional experience, and the scale of the organisation they lead.'
                ],
                 [
                    'id' => 'fellow',
                    'title' => 'Fellows/Honorary Member',
                    'description' => 'Conferred on individuals with outstanding contributions to economics. By invitation only.',
                    'registration_fee' => 'KES. 0',
                    'subscription_fee' => 'KES. 5000',
                    'color' => 'bg-danger text-white',
                    'full_description' => 'This grade of Fellow is the highest level of membership within KESA. It is conferred upon individuals whose work and personal contributions have significantly advanced the promotion of excellence and integrity in the field of Economics and beyond. The grade is awarded by invitation only, subject to the  approval of both the Board of Management and the Founding Board.
'
                ],
                [
                    'id' => 'organization',
                    'title' => 'Organization/Association',
                    'description' => 'For member institutions’ associations or collaborators via MoU.',
                    'registration_fee' => 'KES. 1000',
                    'subscription_fee' => 'KES. 1000',
                    'color' => 'bg-info text-white',
                    'full_description' => 'This grade is designated for associations or organisations within KESA member institutions that are affiliated with KESA. Associations or organisations outside this scope may pursue joint collaboration through a Memorandum of Understanding.'
                ]
            ];
        @endphp

        @foreach($memberships as $membership)
        <div class="col membership-card animate__animated animate__fadeInUp" id="card-{{ $membership['id'] }}">
            <div class="card h-100 shadow-lg {{ $membership['color'] }} card-hover">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="card-title mb-3"><i class="fas fa-users me-2"></i>{{ $membership['title'] }}</h5>
                        <p class="card-text">{{ $membership['description'] }}</p>
                    </div>
                    <button class="btn btn-light mt-4 w-100 fw-bold" onclick="showDetails('{{ $membership['id'] }}')">
                        → LEARN MORE
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Membership Details -->
    <div id="membership-detail-container" class="mt-5 animate__animated animate__fadeIn" style="display: none;">
        <div class="card shadow-lg p-4 border-0">
            <h4 id="detail-title" class="mb-3 text-primary fw-bold text-center" style="font-size: 20px;"></h4>
            <p id="detail-description" class="text-muted d-none"></p>
            <!-- Full Description -->
            <div id="detail-full-description" class="mb-4 text-muted">
                <!-- Additional description will be added dynamically here -->
            </div>

            <h6 class="mt-4 mb-2 text-dark">Membership Fees</h6>
            <div class="table-responsive">
                <table class="table table-bordered w-100 w-md-50">
                    <tbody>
                        <tr>
                            <th>Registration Fee</th>
                            <td id="detail-registration-fee"></td>
                        </tr>
                        <tr>
                            <th>Annual Subscription</th>
                            <td id="detail-subscription-fee"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <a href="{{ route('register') }}" class="btn btn-success mt-4 w-100 w-md-auto">→ APPLY NOW</a>
            <!-- Added 'Back to Memberships' Button -->
            <button class="btn btn-info mt-3 w-100 w-md-auto" onclick="backToCards()">← BACK TO MEMBERSHIPS</button>
        </div>
    </div>
</div>

<!-- Animations & Effects -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<style>
    .card-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-hover:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }

    .btn-light:hover {
        background-color: #e0e0e0;
        color: #000;
    }

    .table th {
        width: 50%;
    }
</style>

<script>
    const membershipData = @json($memberships);

    function showDetails(id) {
        // Hide membership cards and intro paragraph
        document.getElementById('membership-cards').style.display = 'none';
        document.getElementById('intro-paragraph').style.display = 'none'; // Hide intro paragraph

        const data = membershipData.find(m => m.id === id);

        if (data) {
            document.getElementById('detail-title').innerText = data.title;
            document.getElementById('detail-description').innerText = data.description;
            document.getElementById('detail-registration-fee').innerText = data.registration_fee;
            document.getElementById('detail-subscription-fee').innerText = data.subscription_fee;

            // Set the full description dynamically
            document.getElementById('detail-full-description').innerText = data.full_description;

            document.getElementById('membership-detail-container').style.display = 'block';
        }
    }

    function backToCards() {
        // Show membership cards and intro paragraph again
        document.getElementById('membership-detail-container').style.display = 'none';
        document.getElementById('membership-cards').style.display = 'flex';
        document.getElementById('intro-paragraph').style.display = 'block'; // Show intro paragraph
    }
</script>

@endsection
