@extends('layouts.app')

@section('styles')
<style>
    /* Additional styles for the publication statistics page */
    .bg-primary-soft {
        background: rgba(128, 0, 0, 0.08);
    }
    .bg-success-soft {
        background: rgba(28, 200, 138, 0.1);
    }
    .bg-info-soft {
        background: rgba(54, 185, 204, 0.1);
    }
    .bg-warning-soft {
        background: rgba(246, 194, 62, 0.1);
    }
    .bg-danger-soft {
        background: rgba(220, 53, 69, 0.1);
    }
    
    .text-primary-soft {
        color: rgba(128, 0, 0, 0.6);
    }
    .text-success-soft {
        color: rgba(28, 200, 138, 0.6);
    }
    .text-info-soft {
        color: rgba(54, 185, 204, 0.6);
    }
    .text-warning-soft {
        color: rgba(246, 194, 62, 0.6);
    }

    .hover-primary {
        transition: color 0.2s ease;
    }
    .hover-primary:hover {
        color: #800000 !important;
    }

    /* Compact Metric Cards */
    .metric-card {
        padding: 0.6rem 0.8rem !important;
        border-radius: 8px !important;
        background: #fff;
        border: 1px solid #e9ecef;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }
    
    .metric-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    
    .metric-card .metric-top {
        margin-bottom: 0.2rem !important;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .metric-card .metric-label {
        font-size: 0.65rem !important;
        color: #6c757d;
        font-weight: 500;
    }
    
    .metric-card .metric-value {
        font-size: 1.2rem !important;
        font-weight: 700 !important;
        line-height: 1.3 !important;
        color: #2c3e50;
    }
    
    .metric-card .metric-meta {
        font-size: 0.6rem !important;
    }
    
    .metric-card .metric-icon {
        width: 24px !important;
        height: 24px !important;
        font-size: 0.8rem !important;
        background: rgba(128, 0, 0, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #800000;
    }
    
    .metric-card.metric-primary .metric-icon {
        background: rgba(128, 0, 0, 0.1);
        color: #800000;
    }
    
    .metric-card.metric-success .metric-icon {
        background: rgba(28, 200, 138, 0.1);
        color: #1cc88a;
    }
    
    .metric-card.metric-warning .metric-icon {
        background: rgba(246, 194, 62, 0.1);
        color: #f6c23e;
    }
    
    .metric-card.metric-danger .metric-icon {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }

    /* Compact Panel */
    .panel {
        background: #fff;
        border-radius: 8px;
        border: 1px solid #e9ecef;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    
    .panel-header {
        padding: 0.5rem 0.75rem !important;
        background: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .panel-body {
        padding: 0.5rem 0.75rem !important;
    }
    
    .panel-footer {
        padding: 0.5rem 0.75rem !important;
        background: #f8f9fa;
        border-top: 1px solid #e9ecef;
    }

    /* Table compact */
    .table td, .table th {
        padding: 0.35rem 0.5rem !important;
        vertical-align: middle;
    }
    
    .table thead th {
        background: #f8f9fa;
        color: #2c3e50;
        font-weight: 600;
        border-bottom: 2px solid #800000;
    }
    
    .table tbody tr:hover {
        background: rgba(128, 0, 0, 0.03);
    }

    /* Section Title */
    .section-title {
        font-size: 0.8rem !important;
        font-weight: 600;
        color: #2c3e50;
    }
    
    .section-title i {
        color: #800000;
    }

    /* Page Heading */
    .page-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
        padding: 0.5rem 0;
        border-bottom: 2px solid #800000;
        margin-bottom: 1rem;
    }
    
    .page-heading-copy {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .page-icon {
        width: 32px;
        height: 32px;
        background: rgba(128, 0, 0, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #800000;
        font-size: 1rem;
    }
    
    .heading-actions {
        display: flex;
        gap: 0.3rem;
        flex-wrap: wrap;
    }
    
    .heading-actions .btn {
        font-size: 0.7rem !important;
        padding: 0.2rem 0.6rem !important;
        border-radius: 4px;
    }
    
    .heading-actions .btn-primary {
        background: #800000;
        border-color: #800000;
    }
    
    .heading-actions .btn-primary:hover {
        background: #660000;
        border-color: #660000;
    }

    /* Form Controls */
    .form-control, .form-select {
        font-size: 0.75rem !important;
        padding: 0.2rem 0.5rem !important;
        height: 30px !important;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #800000;
        box-shadow: 0 0 0 0.2rem rgba(128, 0, 0, 0.15);
    }
    
    .input-group-text {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        padding: 0.2rem 0.5rem;
        font-size: 0.7rem;
    }

    /* Badge Colors */
    .badge.bg-primary {
        background: #800000 !important;
    }
    
    .badge.bg-secondary {
        background: #6c757d !important;
    }
    
    .badge.bg-success {
        background: #1cc88a !important;
    }
    
    .badge.bg-warning {
        background: #f6c23e !important;
        color: #2c3e50;
    }
    
    .badge.bg-danger {
        background: #dc3545 !important;
    }
    
    .badge.bg-info {
        background: #36b9cc !important;
    }

    /* Print */
    @media print {
        .btn, .heading-actions .btn {
            display: none !important;
        }
        .panel {
            break-inside: avoid;
            box-shadow: none !important;
            border: 1px solid #dee2e6 !important;
        }
        .metric-card {
            break-inside: avoid;
            border: 1px solid #dee2e6 !important;
        }
        .metric-card .metric-icon {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        .badge {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-heading {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .heading-actions {
            width: 100%;
        }
        
        .heading-actions .btn {
            flex: 1;
        }
        
        .metric-card .metric-value {
            font-size: 1rem !important;
        }
    }
</style>
@endsection

@section('content')
<div class="container" style="margin-top: 30px;">
    <div class="row justify-content-left">
        <div class="col-md-12">
            <!-- Card Container -->
            <div class="card shadow-md" style="width: 100%;">
                <!-- Card Header with Back Button -->
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0" style="color:black; font-weight:bold;">
                        <i class="bi bi-file-earmark-pdf" style="color: #800000;"></i> Publication Statistics
                    </h4>
                    <div class="d-flex gap-1">
                        <a href="{{ route('publications.index') }}" class="btn btn-dark btn-sm">
                            <i class="fas fa-backward"></i> Back
                        </a>
                        <button class="btn btn-secondary btn-sm" type="button" onclick="window.print()">
                            <i class="bi bi-printer"></i> Print
                        </button>
                        <button class="btn btn-primary btn-sm" type="button" onclick="exportToCSV()" style="background: #800000; border-color: #800000;">
                            <i class="bi bi-download"></i> Export
                        </button>
                    </div>
                </div>
                
                <div class="card-body">
                    <p class="text-muted small mb-3">
                        Detailed analytics for all publications
                        @if($period == 'today')
                            <span class="badge bg-info ms-1" style="font-size: 0.6rem;">Today</span>
                        @elseif($period == 'week')
                            <span class="badge bg-info ms-1" style="font-size: 0.6rem;">Last 7 Days</span>
                        @elseif($period == 'month')
                            <span class="badge bg-info ms-1" style="font-size: 0.6rem;">Last 30 Days</span>
                        @elseif($period == 'year')
                            <span class="badge bg-info ms-1" style="font-size: 0.6rem;">Last Year</span>
                        @else
                            <span class="badge bg-secondary ms-1" style="font-size: 0.6rem;">All Time</span>
                        @endif
                    </p>

                    <!-- Filter Section -->
                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="fas fa-filter"></i>
                            Filter Publications
                        </div>
                        <form action="{{ route('publications.statistics') }}" method="GET">
                            <div class="row g-2 align-items-end">
                                <div class="col-12 col-sm-6 col-md-4">
                                    <label class="form-label text-muted small mb-0" style="font-size: 0.65rem;">Search</label>
                                    <div class="input-group" style="height: 30px;">
                                        <span class="input-group-text bg-light border-0" style="padding: 0.2rem 0.5rem; font-size: 0.7rem;">
                                            <i class="bi bi-search"></i>
                                        </span>
                                        <input type="text" name="search" value="{{ request('search') }}" 
                                               class="form-control bg-light border-0" placeholder="Search publications..." 
                                               style="font-size: 0.7rem; padding: 0.2rem 0.5rem; height: 30px;">
                                    </div>
                                </div>
                                <div class="col-6 col-sm-3 col-md-3">
                                    <label class="form-label text-muted small mb-0" style="font-size: 0.65rem;">Period</label>
                                    <select name="period" class="form-select bg-light border-0" onchange="this.form.submit()" 
                                            style="font-size: 0.7rem; padding: 0.2rem 0.5rem; height: 30px;">
                                        <option value="all" {{ $period == 'all' ? 'selected' : '' }}>🌐 All Time</option>
                                        <option value="today" {{ $period == 'today' ? 'selected' : '' }}>📅 Today</option>
                                        <option value="week" {{ $period == 'week' ? 'selected' : '' }}>📅 Last 7 Days</option>
                                        <option value="month" {{ $period == 'month' ? 'selected' : '' }}>📅 Last 30 Days</option>
                                        <option value="year" {{ $period == 'year' ? 'selected' : '' }}>📅 Last 365 Days</option>
                                    </select>
                                </div>
                                <div class="col-6 col-sm-3 col-md-3">
                                    <label class="form-label text-muted small mb-0" style="font-size: 0.65rem;">&nbsp;</label>
                                    <div class="d-flex gap-1">
                                        <button type="submit" class="btn btn-primary btn-sm flex-fill" style="font-size: 0.7rem; padding: 0.2rem 0.5rem; height: 30px; background: #800000; border-color: #800000;">
                                            <i class="bi bi-funnel me-1"></i> Apply
                                        </button>
                                        <a href="{{ route('publications.statistics') }}" class="btn btn-outline-secondary btn-sm" style="font-size: 0.7rem; padding: 0.2rem 0.5rem; height: 30px;">
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Metrics Cards -->
                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="fas fa-chart-bar"></i>
                            Key Metrics
                        </div>
                        <div class="row g-2">
                            <div class="col-12 col-sm-6 col-xl-3">
                                <article class="metric-card metric-primary">
                                    <div class="metric-top">
                                        <span class="metric-label">Total Downloads</span>
                                        <span class="metric-icon"><i class="bi bi-download" aria-hidden="true"></i></span>
                                    </div>
                                    <div class="metric-value">{{ number_format($overallStats['total_downloads'] ?? 0) }}</div>
                                    <div class="metric-meta">
                                        <span class="text-success">+15.3%</span>
                                        <span>from previous period</span>
                                    </div>
                                </article>
                            </div>

                            <div class="col-12 col-sm-6 col-xl-3">
                                <article class="metric-card metric-success">
                                    <div class="metric-top">
                                        <span class="metric-label">Total Publications</span>
                                        <span class="metric-icon"><i class="bi bi-file-earmark-pdf" aria-hidden="true"></i></span>
                                    </div>
                                    <div class="metric-value">{{ number_format($overallStats['total_publications'] ?? 0) }}</div>
                                    <div class="metric-meta">
                                        <span class="text-success">+8.2%</span>
                                        <span>total publications</span>
                                    </div>
                                </article>
                            </div>

                            <div class="col-12 col-sm-6 col-xl-3">
                                <article class="metric-card metric-warning">
                                    <div class="metric-top">
                                        <span class="metric-label">Avg Downloads per Pub</span>
                                        <span class="metric-icon"><i class="bi bi-bar-chart" aria-hidden="true"></i></span>
                                    </div>
                                    <div class="metric-value">{{ number_format($overallStats['average_downloads'] ?? 0, 1) }}</div>
                                    <div class="metric-meta">
                                        <span class="text-success">+5.1%</span>
                                        <span>average performance</span>
                                    </div>
                                </article>
                            </div>

                            <div class="col-12 col-sm-6 col-xl-3">
                                <article class="metric-card metric-danger">
                                    <div class="metric-top">
                                        <span class="metric-label">Active Publications</span>
                                        <span class="metric-icon"><i class="bi bi-check-circle" aria-hidden="true"></i></span>
                                    </div>
                                    <div class="metric-value">{{ number_format($overallStats['publications_with_downloads'] ?? 0) }}</div>
                                    <div class="metric-meta">
                                        <span class="text-success">+12.5%</span>
                                        <span>with downloads</span>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </div>

                    <!-- Most & Least Downloaded -->
                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="fas fa-trophy"></i>
                            Most & Least Downloaded
                        </div>
                        <div class="row g-2">
                            <div class="col-12 col-xl-6">
                                <div class="panel">
                                    <div class="panel-header">
                                        <div>
                                            <h2 class="section-title mb-0">
                                                <i class="bi bi-trophy" aria-hidden="true"></i>
                                                <span>Most Downloaded</span>
                                            </h2>
                                            <p class="text-muted mb-0" style="font-size: 0.6rem;">Top publication by downloads.</p>
                                        </div>
                                    </div>
                                    <div class="panel-body p-2">
                                        @if(isset($overallStats['most_downloaded']) && $overallStats['most_downloaded'])
                                            <div class="d-flex align-items-center gap-3 p-2 bg-success-soft rounded-2">
                                                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px; font-size: 1.2rem; background: #1cc88a !important;">
                                                    <i class="bi bi-file-earmark-pdf"></i>
                                                </div>
                                                <div>
                                                    <p class="fw-semibold mb-0" style="font-size: 0.8rem;">
                                                        <a href="{{ route('publications.show', $overallStats['most_downloaded']->id) }}" 
                                                           class="text-decoration-none text-dark hover-primary">
                                                            {{ Str::limit($overallStats['most_downloaded']->title, 40) }}
                                                        </a>
                                                    </p>
                                                    <p class="text-muted small mb-0" style="font-size: 0.6rem;">
                                                        <i class="bi bi-person me-1"></i> {{ $overallStats['most_downloaded']->authors ?? 'Unknown' }}
                                                    </p>
                                                </div>
                                                <div class="ms-auto">
                                                    <span class="badge bg-success rounded-pill" style="font-size: 0.7rem; background: #1cc88a !important;">
                                                        <i class="bi bi-download me-1"></i> {{ number_format($overallStats['most_downloaded']->downloads) }}
                                                    </span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="text-center py-2">
                                                <i class="bi bi-inbox text-muted mb-1" style="font-size: 1.2rem;"></i>
                                                <p class="text-muted small mb-0">No publications found</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-xl-6">
                                <div class="panel">
                                    <div class="panel-header">
                                        <div>
                                            <h2 class="section-title mb-0">
                                                <i class="bi bi-arrow-up" aria-hidden="true"></i>
                                                <span>Least Downloaded</span>
                                            </h2>
                                            <p class="text-muted mb-0" style="font-size: 0.6rem;">Publication needing more attention.</p>
                                        </div>
                                    </div>
                                    <div class="panel-body p-2">
                                        @if(isset($overallStats['least_downloaded']) && $overallStats['least_downloaded'])
                                            <div class="d-flex align-items-center gap-3 p-2 bg-warning-soft rounded-2">
                                                <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px; font-size: 1.2rem;">
                                                    <i class="bi bi-file-earmark-pdf"></i>
                                                </div>
                                                <div>
                                                    <p class="fw-semibold mb-0" style="font-size: 0.8rem;">
                                                        <a href="{{ route('publications.show', $overallStats['least_downloaded']->id) }}" 
                                                           class="text-decoration-none text-dark hover-primary">
                                                            {{ Str::limit($overallStats['least_downloaded']->title, 40) }}
                                                        </a>
                                                    </p>
                                                    <p class="text-muted small mb-0" style="font-size: 0.6rem;">
                                                        <i class="bi bi-person me-1"></i> {{ $overallStats['least_downloaded']->authors ?? 'Unknown' }}
                                                    </p>
                                                </div>
                                                <div class="ms-auto">
                                                    <span class="badge bg-secondary rounded-pill" style="font-size: 0.7rem;">
                                                        <i class="bi bi-download me-1"></i> {{ number_format($overallStats['least_downloaded']->downloads) }}
                                                    </span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="text-center py-2">
                                                <i class="bi bi-inbox text-muted mb-1" style="font-size: 1.2rem;"></i>
                                                <p class="text-muted small mb-0">No publications found</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Publications -->
                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="fas fa-clock"></i>
                            Recent Publications
                        </div>
                        <div class="row g-2">
                            @if(isset($overallStats['recent_publications']) && $overallStats['recent_publications']->count())
                                @foreach($overallStats['recent_publications'] as $recent)
                                    <div class="col-12 col-sm-6 col-lg-4 col-xl-2">
                                        <div class="p-2 bg-light rounded-2">
                                            <div class="d-flex align-items-start gap-2">
                                                <div class="bg-primary-soft text-primary rounded-circle d-flex align-items-center justify-content-center" 
                                                     style="width: 28px; height: 28px; font-size: 0.8rem; flex-shrink: 0; background: rgba(128, 0, 0, 0.1) !important; color: #800000 !important;">
                                                    <i class="bi bi-file-earmark-pdf"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <p class="fw-semibold mb-0" style="font-size: 0.7rem; line-height: 1.2;">
                                                        <a href="{{ route('publications.show', $recent->id) }}" 
                                                           class="text-decoration-none text-dark hover-primary">
                                                            {{ Str::limit($recent->title, 20) }}
                                                        </a>
                                                    </p>
                                                    <p class="text-muted small mb-0" style="font-size: 0.6rem;">
                                                        <i class="bi bi-download me-1"></i> {{ number_format($recent->downloads) }}
                                                        <span class="mx-1">•</span>
                                                        <i class="bi bi-person me-1"></i> {{ Str::limit($recent->authors ?? 'Unknown', 12) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-12">
                                    <div class="text-center py-2">
                                        <i class="bi bi-inbox text-muted mb-1" style="font-size: 1.2rem;"></i>
                                        <p class="text-muted small mb-0">No recent publications found</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="fas fa-speedometer"></i>
                            Quick Stats
                        </div>
                        <div class="row g-1">
                            <div class="col-6 col-md-3">
                                <div class="p-2 bg-light rounded-2 text-center">
                                    <div class="text-muted" style="font-size: 0.55rem;">Total Size</div>
                                    <div class="fw-bold text-primary" style="font-size: 0.9rem; color: #800000 !important;">
                                        @php
                                            $totalSize = 0;
                                            if (isset($overallStats['total_publications'])) {
                                                $totalSize = \App\Models\Publication::sum('file_size');
                                            }
                                        @endphp
                                        {{ number_format($totalSize / 1024 / 1024, 1) }} MB
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="p-2 bg-light rounded-2 text-center">
                                    <div class="text-muted" style="font-size: 0.55rem;">Download Rate</div>
                                    <div class="fw-bold text-success" style="font-size: 0.9rem;">
                                        @php
                                            $downloadRate = 0;
                                            if (isset($overallStats['total_publications']) && $overallStats['total_publications'] > 0) {
                                                $downloadRate = round(($overallStats['publications_with_downloads'] / $overallStats['total_publications']) * 100, 1);
                                            }
                                        @endphp
                                        {{ number_format($downloadRate, 1) }}%
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="p-2 bg-light rounded-2 text-center">
                                    <div class="text-muted" style="font-size: 0.55rem;">Most Downloaded</div>
                                    <div class="fw-bold text-truncate" style="font-size: 0.65rem;">
                                        @if(isset($overallStats['most_downloaded']) && $overallStats['most_downloaded'])
                                            <a href="{{ route('publications.show', $overallStats['most_downloaded']->id) }}" 
                                               class="text-decoration-none text-dark hover-primary">
                                                {{ Str::limit($overallStats['most_downloaded']->title, 12) }}
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="p-2 bg-light rounded-2 text-center">
                                    <div class="text-muted" style="font-size: 0.55rem;">New This Month</div>
                                    <div class="fw-bold text-info" style="font-size: 0.9rem;">
                                        @php
                                            $newThisMonth = \App\Models\Publication::whereMonth('created_at', now()->month)
                                                ->whereYear('created_at', now()->year)
                                                ->count();
                                        @endphp
                                        {{ number_format($newThisMonth) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					<!-- Publications Stats Table -->
					<div class="form-section">
					    <div class="form-section-title">
					        <i class="fas fa-table"></i>
					        Publication Statistics Table
					    </div>
					    <div class="table-responsive">
					        <table class="table align-middle mb-0" style="font-size: 0.7rem;">
					            <thead>
					                <tr>
					                    <th scope="col" style="font-size: 0.6rem;">#</th>
					                    <th scope="col" style="font-size: 0.6rem;">Title</th>
					                    <th scope="col" style="font-size: 0.6rem;">Authors</th>
					                    <th scope="col" class="text-center" style="font-size: 0.6rem;">Downloads</th>
					                    <th scope="col" style="font-size: 0.6rem;">Size</th>
					                    <th scope="col" style="font-size: 0.6rem;">Type</th>
					                    <th scope="col" style="font-size: 0.6rem;">Added</th>
					                    <th scope="col" class="text-center" style="font-size: 0.6rem;">Action</th>
					                </tr>
					            </thead>
					            <tbody>
					                @forelse($publications as $index => $pub)
					                    <tr>
					                        <td style="font-size: 0.6rem;">{{ $publications->firstItem() + $index }}</td>
					                        <td>
					                            <a href="{{ route('publications.show', $pub->id) }}" 
					                               class="text-decoration-none text-dark hover-primary" style="font-size: 0.65rem;">
					                                {{ Str::limit($pub->title, 30) }}
					                            </a>
					                        </td>
					                        <td style="font-size: 0.6rem;">{{ Str::limit($pub->authors ?? '-', 20) }}</td>
					                        <td class="text-center">
					                            @php
					                                $downloads = $pub->downloads ?? 0;
					                                $badgeClass = 'success';
					                                if ($downloads > 50) {
					                                    $badgeClass = 'success';
					                                } elseif ($downloads > 20) {
					                                    $badgeClass = 'info';
					                                } elseif ($downloads > 5) {
					                                    $badgeClass = 'warning';
					                                } else {
					                                    $badgeClass = 'secondary';
					                                }
					                            @endphp
					                            <span class="badge bg-{{ $badgeClass }}" style="font-size: 0.55rem; min-width: 40px;">
					                                <i class="bi bi-download me-1"></i> {{ number_format($downloads) }}
					                            </span>
					                        </td>
					                        <td style="font-size: 0.6rem;">
					                            @if($pub->file_size)
					                                {{ number_format($pub->file_size / 1024, 1) }} KB
					                            @else
					                                -
					                            @endif
					                        </td>
					                        <td>
					                            <span class="badge bg-light text-dark" style="font-size: 0.5rem;">
					                                {{ strtoupper(pathinfo($pub->file_path, PATHINFO_EXTENSION)) }}
					                            </span>
					                        </td>
					                        <td style="font-size: 0.55rem;">
					                            {{ $pub->created_at->diffForHumans() }}
					                        </td>
					                        <td class="text-center">
					                            <a href="{{ route('publications.show', $pub->id) }}" 
					                               class="btn btn-dark btn-sm" title="View Publication" 
					                               style="padding: 0.1rem 0.3rem; font-size: 0.6rem; background: #800000; border-color: #800000;">
					                                <i class="bi bi-eye"></i>
					                            </a>
					                        </td>
					                    </tr>
					                @empty
					                    <tr>
					                        <td colspan="8" class="text-center py-3">
					                            <i class="bi bi-inbox text-muted d-block mb-1" style="font-size: 1.2rem;"></i>
					                            <p class="text-muted small mb-0">No publications found for this period</p>
					                        </td>
					                    </tr>
					                @endforelse
					            </tbody>
					        </table>
					    </div>
					    <div class="mt-3 d-flex justify-content-center">
					        {{ $publications->appends(['search' => request('search'), 'period' => request('period')])->links('pagination::bootstrap-5') }}
					    </div>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function exportToCSV() {
        const rows = document.querySelectorAll('table tbody tr');
        let csv = 'Title,Authors,Downloads,Size,Type,Added\n';
        
        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length > 1) {
                const rowData = [
                    cells[1]?.textContent?.trim() || '',
                    cells[2]?.textContent?.trim() || '',
                    cells[3]?.textContent?.trim() || '',
                    cells[4]?.textContent?.trim() || '',
                    cells[5]?.textContent?.trim() || '',
                    cells[6]?.textContent?.trim() || ''
                ];
                csv += rowData.join(',') + '\n';
            }
        });

        const blob = new Blob(['\uFEFF' + csv], { type: 'text/csv;charset=utf-8' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'publication_statistics_{{ date('Y-m-d') }}.csv';
        a.click();
        window.URL.revokeObjectURL(url);
    }
</script>
@endpush