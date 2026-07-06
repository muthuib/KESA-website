@if($memberships->isNotEmpty())
    <div class="members-section">
        <div class="container">
            <!-- Section Header -->
            <div class="section-header text-center mb-5">
                <span class="section-badge">Our Community</span>
                <h2 class="section-title">Our <span class="highlight">Members</span></h2>
                <div class="section-divider"></div>
                <p class="section-subtitle">Meet the organizations and institutions that make up our vibrant community</p>
            </div>

            <!-- Members Grid -->
            <div class="row g-4">
                @foreach ($memberships as $membership)
                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <div class="member-card" onclick="openMemberModal({{ $membership->ID }})">
                            <!-- Card Glow Effect -->
                            <div class="card-glow"></div>
                            
                            <div class="member-card-inner">
                                <!-- Logo Container with Hover Effect -->
                                <div class="logo-wrapper">
                                    <div class="logo-circle">
                                        <img src="{{ file_exists(public_path($membership->LOGO_PATH)) 
                                                    ? asset($membership->LOGO_PATH) 
                                                    : asset('images/default-logo.png') }}"
                                            alt="{{ $membership->NAME }}"
                                            class="member-logo">
                                    </div>
                                </div>

                                <!-- Member Name -->
                                <h5 class="member-name">
                                    {{ $membership->NAME ?? 'Unknown Member' }}
                                </h5>

                                <!-- View Details Button -->
                                <div class="member-hover-actions">
                                    <span class="view-details-btn">
                                        <i class="fas fa-arrow-right"></i> View Details
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="pagination-wrapper mt-5">
                {{ $memberships->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@else
    <div class="container mt-5">
        <div class="empty-state text-center py-5">
            <i class="fas fa-users fa-4x text-muted mb-3"></i>
            <h3 class="text-muted">No Members Available</h3>
            <p class="text-muted">Check back later for updates on our community members.</p>
        </div>
    </div>
@endif

<!-- Member Details Modal -->
<div class="modal fade" id="memberModal" tabindex="-1" aria-labelledby="memberModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="memberModalLabel">Member Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="memberModalBody">
                <!-- Loading Spinner -->
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Styles -->
<style>
    /* ========== MEMBERS SECTION ========== */
    .members-section {
        padding: 60px 0;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        position: relative;
        overflow: hidden;
    }

    /* Decorative Background Elements */
    .members-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -30%;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(0,123,255,0.03) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .members-section::after {
        content: '';
        position: absolute;
        bottom: -40%;
        left: -20%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(128,0,0,0.03) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    /* ========== SECTION HEADER ========== */
    .section-header {
        position: relative;
        z-index: 1;
    }

    .section-badge {
        display: inline-block;
        background: linear-gradient(135deg, #800000, #a00000);
        color: #fff;
        padding: 6px 20px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-bottom: 15px;
    }

    .section-title {
        font-size: 2.8rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 10px;
    }

    .section-title .highlight {
        background: linear-gradient(135deg, #800000, #cc0000);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .section-divider {
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, #800000, #cc0000);
        margin: 15px auto;
        border-radius: 2px;
        position: relative;
    }

    .section-divider::before {
        content: '';
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 12px;
        height: 12px;
        background: #800000;
        border-radius: 50%;
        border: 2px solid #fff;
    }

    .section-subtitle {
        color: #6c757d;
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto;
    }

    /* ========== MEMBER CARD ========== */
    .member-card {
        position: relative;
        cursor: pointer;
        border-radius: 16px;
        background: #ffffff;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.04);
    }

    .member-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(128, 0, 0, 0.12);
        border-color: rgba(128, 0, 0, 0.1);
    }

    /* Card Glow Effect */
    .card-glow {
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle at center, rgba(128, 0, 0, 0.03) 0%, transparent 60%);
        opacity: 0;
        transition: opacity 0.6s ease;
        pointer-events: none;
    }

    .member-card:hover .card-glow {
        opacity: 1;
    }

    .member-card-inner {
        padding: 30px 20px 25px;
        text-align: center;
        position: relative;
        z-index: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        height: 100%;
    }

    /* ========== LOGO ========== */
    .logo-wrapper {
        margin-bottom: 18px;
        position: relative;
    }

    .logo-circle {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.4s ease;
        border: 2px solid #e9ecef;
        position: relative;
        overflow: hidden;
    }

    .member-card:hover .logo-circle {
        border-color: #800000;
        box-shadow: 0 8px 25px rgba(128, 0, 0, 0.15);
        transform: scale(1.05);
    }

    /* Logo Pulsing Animation on Hover */
    .member-card:hover .logo-circle::after {
        content: '';
        position: absolute;
        inset: -4px;
        border-radius: 50%;
        border: 2px solid rgba(128, 0, 0, 0.2);
        animation: pulse-ring 1.5s ease-out infinite;
    }

    @keyframes pulse-ring {
        0% {
            transform: scale(1);
            opacity: 1;
        }
        100% {
            transform: scale(1.3);
            opacity: 0;
        }
    }

    .member-logo {
        width: 60px;
        height: 60px;
        object-fit: contain;
        transition: all 0.4s ease;
        filter: grayscale(20%);
    }

    .member-card:hover .member-logo {
        filter: grayscale(0%);
        transform: scale(1.05);
    }

    /* ========== MEMBER NAME ========== */
    .member-name {
        font-size: 1rem;
        font-weight: 600;
        color: #1a1a1a;
        margin: 0 0 5px 0;
        line-height: 1.3;
        transition: color 0.3s ease;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 2.6rem;
    }

    .member-card:hover .member-name {
        color: #800000;
    }

    /* ========== HOVER ACTIONS ========== */
    .member-hover-actions {
        margin-top: auto;
        padding-top: 15px;
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.4s ease;
    }

    .member-card:hover .member-hover-actions {
        opacity: 1;
        transform: translateY(0);
    }

    .view-details-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        font-weight: 500;
        color: #800000;
        background: rgba(128, 0, 0, 0.06);
        padding: 8px 18px;
        border-radius: 50px;
        transition: all 0.3s ease;
    }

    .view-details-btn i {
        transition: transform 0.3s ease;
    }

    .member-card:hover .view-details-btn i {
        transform: translateX(4px);
    }

    .view-details-btn:hover {
        background: #800000;
        color: #fff;
    }

    /* ========== PAGINATION ========== */
    .pagination-wrapper {
        position: relative;
        z-index: 1;
    }

    .pagination-wrapper nav {
        display: flex;
        justify-content: center;
    }

    .pagination-wrapper .pagination {
        gap: 6px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .pagination-wrapper .page-item {
        margin: 2px;
    }

    .pagination-wrapper .page-link {
        border: none;
        border-radius: 8px !important;
        padding: 8px 16px;
        color: #495057;
        background: #f8f9fa;
        font-weight: 500;
        transition: all 0.3s ease;
        min-width: 40px;
        text-align: center;
    }

    .pagination-wrapper .page-link:hover {
        background: #800000;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(128, 0, 0, 0.2);
    }

    .pagination-wrapper .page-item.active .page-link {
        background: linear-gradient(135deg, #800000, #a00000);
        color: #fff;
        box-shadow: 0 4px 15px rgba(128, 0, 0, 0.3);
    }

    .pagination-wrapper .page-item.disabled .page-link {
        background: #e9ecef;
        color: #adb5bd;
        cursor: not-allowed;
        transform: none;
    }

    .pagination-wrapper .page-link svg {
        width: 16px !important;
        height: 16px !important;
    }

    /* ========== EMPTY STATE ========== */
    .empty-state {
        background: #f8f9fa;
        border-radius: 16px;
        padding: 60px 20px;
    }

    .empty-state i {
        color: #dee2e6;
    }

    /* ========== MODAL STYLING ========== */
    .modal-content {
        border: none;
        border-radius: 20px;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
        overflow: hidden;
    }

    .modal-header {
        border-bottom: 2px solid #f0f0f0;
        padding: 20px 30px;
        background: #fafafa;
    }

    .modal-header .modal-title {
        font-weight: 700;
        color: #1a1a1a;
        font-size: 1.3rem;
    }

    .modal-body {
        padding: 30px;
        max-height: 70vh;
        overflow-y: auto;
    }

    .modal-footer {
        border-top: 2px solid #f0f0f0;
        padding: 15px 30px;
        background: #fafafa;
    }

    .modal-footer .btn-secondary {
        border-radius: 50px;
        padding: 8px 25px;
        background: #6c757d;
        border: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .modal-footer .btn-secondary:hover {
        background: #5a6268;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 992px) {
        .section-title {
            font-size: 2.2rem;
        }
        
        .logo-circle {
            width: 85px;
            height: 85px;
        }
        
        .member-logo {
            width: 50px;
            height: 50px;
        }
    }

    @media (max-width: 768px) {
        .members-section {
            padding: 40px 0;
        }

        .section-title {
            font-size: 1.8rem;
        }

        .section-subtitle {
            font-size: 0.95rem;
            padding: 0 15px;
        }

        .member-card-inner {
            padding: 20px 15px;
        }

        .logo-circle {
            width: 70px;
            height: 70px;
        }

        .member-logo {
            width: 42px;
            height: 42px;
        }

        .member-name {
            font-size: 0.85rem;
            min-height: 2.2rem;
        }

        .member-hover-actions {
            opacity: 1;
            transform: translateY(0);
        }

        .view-details-btn {
            font-size: 0.75rem;
            padding: 6px 14px;
        }

        .pagination-wrapper .page-link {
            padding: 6px 12px;
            font-size: 13px;
            min-width: 34px;
        }
    }

    @media (max-width: 576px) {
        .section-title {
            font-size: 1.5rem;
        }

        .section-badge {
            font-size: 10px;
            padding: 4px 14px;
        }

        .section-divider {
            width: 40px;
        }

        .logo-circle {
            width: 60px;
            height: 60px;
        }

        .member-logo {
            width: 36px;
            height: 36px;
        }

        .member-name {
            font-size: 0.8rem;
            min-height: 2rem;
        }

        .member-card-inner {
            padding: 15px 10px;
        }

        .member-card {
            border-radius: 12px;
        }

        .modal-body {
            padding: 20px;
        }
    }
</style>

<!-- JavaScript for Modal -->
<script>
    function openMemberModal(memberId) {
        const modalBody = document.getElementById('memberModalBody');
        modalBody.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;

        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('memberModal'));
        modal.show();

        // Fetch member details
        fetch(`/memberships/${memberId}`)
            .then(response => response.json())
            .then(data => {
                modalBody.innerHTML = `
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center mb-4 mb-md-0">
                            <div class="modal-logo-wrapper">
                                <img src="${data.logo_path || '/images/default-logo.png'}" 
                                     alt="${data.name}" 
                                     class="modal-member-logo">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h4 class="modal-member-name">${data.name}</h4>
                            ${data.description ? `
                                <div class="modal-member-description">
                                    <i class="fas fa-info-circle text-primary me-2"></i>
                                    ${data.description}
                                </div>
                            ` : ''}
                            ${data.website ? `
                                <div class="modal-member-website">
                                    <i class="fas fa-globe text-primary me-2"></i>
                                    <a href="${data.website}" target="_blank">
                                        ${data.website}
                                    </a>
                                </div>
                            ` : ''}
                            ${data.email ? `
                                <div class="modal-member-email">
                                    <i class="fas fa-envelope text-primary me-2"></i>
                                    <a href="mailto:${data.email}">
                                        ${data.email}
                                    </a>
                                </div>
                            ` : ''}
                            ${data.phone ? `
                                <div class="modal-member-phone">
                                    <i class="fas fa-phone text-primary me-2"></i>
                                    ${data.phone}
                                </div>
                            ` : ''}
                        </div>
                    </div>
                `;
            })
            .catch(error => {
                modalBody.innerHTML = `
                    <div class="alert alert-danger text-center">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        Error loading member details. Please try again.
                    </div>
                `;
                console.error('Error:', error);
            });
    }
</script>

<!-- Additional Modal Styles -->
<style>
    .modal-logo-wrapper {
        display: inline-block;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 16px;
        border: 2px solid #e9ecef;
    }

    .modal-member-logo {
        max-width: 120px;
        max-height: 120px;
        object-fit: contain;
    }

    .modal-member-name {
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 15px;
        font-size: 1.4rem;
    }

    .modal-member-description,
    .modal-member-website,
    .modal-member-email,
    .modal-member-phone {
        padding: 8px 0;
        font-size: 0.95rem;
        display: flex;
        align-items: flex-start;
    }

    .modal-member-description i,
    .modal-member-website i,
    .modal-member-email i,
    .modal-member-phone i {
        margin-top: 4px;
        min-width: 20px;
    }

    /* Website link - BLUE color */
    .modal-member-website a {
        color: #007bff !important;
        word-break: break-all;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .modal-member-website a:hover {
        color: #0056b3 !important;
        text-decoration: underline !important;
    }

    /* Email link - keep maroon to match design */
    .modal-member-email a {
        color: #800000;
        word-break: break-all;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .modal-member-email a:hover {
        text-decoration: underline !important;
        color: #a00000;
    }

    @media (max-width: 768px) {
        .modal-member-logo {
            max-width: 80px;
            max-height: 80px;
        }
        
        .modal-member-name {
            font-size: 1.1rem;
        }
        
        .modal-member-description,
        .modal-member-website,
        .modal-member-email,
        .modal-member-phone {
            font-size: 0.85rem;
        }
    }
</style>