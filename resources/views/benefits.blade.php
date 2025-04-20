@extends('layouts.app') <!-- Assuming you're using a master layout -->

@section('content')
<div class="container my-5">
    <h2 class="text-center mb-4" style="margin-top: 110px;">Membership Benefits</h2>
    
    <div class="row">
        <!-- Benefit 1 -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">1. Professional & Career Development</h5>
                    <p class="card-text">KESA helps you build strong skills that support your career. Through debates, summits, and workshops, you learn how to express ideas, work with others, and present yourself better both as a student and as a young professional.</p>
                </div>
            </div>
        </div>

        <!-- Benefit 2 -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">2. Research Trainings & Publications Opportunities</h5>
                    <p class="card-text">We offer research training sessions and provide a platform for our members to publish blogs and research resources on current issues, economic topics, or personal ideas on our website. During events, we run writing challenges such as Tech Wrangle and Collaborative Writing, giving you opportunities to practise, compete, and develop your skills through exclusive training.</p>
                </div>
            </div>
        </div>

        <!-- Benefit 3 -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">3. Exclusive Networking Platform</h5>
                    <p class="card-text">As a member, you gain access to a network of students, industry leaders, corporate professionals, and policy experts from a wide range of sectors. These connections can open doors to internships, job tips, career advice, and long-term professional support.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Benefit 4 -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">4. Leadership Growth Opportunities</h5>
                    <p class="card-text">You can lead projects, join committees, or serve in the executive council. We also offer mentorship and training that helps you grow your confidence and leadership skills.</p>
                </div>
            </div>
        </div>

        <!-- Benefit 5 -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">5. Priority Access to High-Impact Events</h5>
                    <p class="card-text">You receive early invitations with free entry or subsidised fees to KESA and partner events. These include learning forums, panel discussions, and stakeholder meetings. Where applicable, we also provide certificates to strengthen your professional profile.</p>
                </div>
            </div>
        </div>

        <!-- Benefit 6 -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">6. KESA e-Library & Academic Exchange</h5>
                    <p class="card-text">You get access to our growing collection of learning materials. Also, being part of a national network lets you discuss topics with students from other institutions, not just your own.</p>
                </div>
            </div>
        </div>
                <!-- Benefit 7 -->
                <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">7. Corporate Visits</h5>
                    <p class="card-text">We organise visits to partner offices. You meet professionals, observe their work, and learn how economics is applied in real-world settings. These experiences bridge the gap between theory and practice, offering exposure to professional environments.</p>
                </div>
            </div>
        </div>
                <!-- Benefit 8 -->
                <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">8. Skill-Based Webinars</h5>
                    <p class="card-text">We run online training on topics that matter through our Power Talk programme, from data handling and policy work to job preparation and communication. These are led by people who understand the field.</p>
                </div>
            </div>
        </div>
                <!-- Benefit 9 -->
                <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">9. CSR for Social Impact</h5>
                    <p class="card-text">Through our outreach work and community projects, you get to volunteer and give back to society while developing key skills such as teamwork, leadership, empathy, and community engagement, equipping you to actively contribute to addressing societal challenges.</p>
                </div>
            </div>
        </div>
                <!-- Benefit 10 -->
                <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">10. Membership Privilege</h5>
                    <p class="card-text">As a KESA member, you gain full access to our Resource Hub, including exclusive publications. Membership also increases your chances of securing partner-supported opportunities like internships, attachments, and job referrals. Additionally, you have voting rights on key matters such as constitutional amendments. Upon request, we also provide official recommendation letters.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
