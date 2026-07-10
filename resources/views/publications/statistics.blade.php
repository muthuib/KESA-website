@extends('layouts.app')

@section('content')
<main class="dashboard-content">
    <div class="container-fluid px-3 px-lg-4 py-3">
        <!-- Page Heading -->
        <div class="page-heading mb-3">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-file-earmark-pdf" aria-hidden="true"></i></span>
                <div>
                    <p class="eyebrow mb-0 small">Analytics</p>
                    <h1 class="h5 mb-0">Publication Statistics</h1>
                    <p class="text-muted small mb-0">
                        Detailed analytics for all publications
                        @if($period == 'today')
                            <span class="badge bg-info ms-1" style="font-size: 0.65rem;">Today</span>
                        @elseif($period == 'week')
                            <span class="badge bg-info ms-1" style="font-size: 0.65rem;">Last 7 Days</span>
                        @elseif($period == 'month')
                            <span class="badge bg-info ms-1" style="font-size: 0.65rem;">Last 30 Days</span>
                        @elseif($period == 'year')
                            <span class="badge bg-info ms-1" style="font-size: 0.65rem;">Last Year</span>
                        @else
                            <span class="badge bg-secondary ms-1" style="font-size: 0.65rem;">All Time</span>
                        @endif
                    </p>
                </div>
            </div>
            <div class="heading-actions">
                <a href="{{ route('publications.index') }}" class="btn btn-outline-secondary btn-sm" style="font-size: 0.7rem; padding: 0.2rem 0.6rem;">
                    <i class="bi bi-arrow-left" aria-hidden="true"></i> Back
                </a>
                <button class="btn btn-secondary btn-sm" type="button" onclick="window.print()" style="font-size: 0.7rem; padding: 0.2rem 0.6rem;">
                    <i class="bi bi-printer" aria-hidden="true"></i> Print
                </button>
                <button class="btn btn-primary btn-sm" type="button" onclick="exportToCSV()" style="font-size: 0.7rem; padding: 0.2rem 0.6rem;">
                    <i class="bi bi-download" aria-hidden="true"></i> Export
                </button>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="panel mb-3">
            <div class="panel-body p-2">
                <form action="{{ route('publications.statistics') }}" method="GET">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label text-muted small mb-0" style="font-size: 0.7rem;">Search</label>
                            <div class="input-group" style="height: 30px;">
                                <span class="input-group-text bg-light border-0" style="padding: 0.2rem 0.5rem; font-size: 0.7rem;">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}" 
                                       class="form-control bg-light border-0" placeholder="Search publications..." 
                                       style="font-size: 0.75rem; padding: 0.2rem 0.5rem; height: 30px;">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-muted small mb-0" style="font-size: 0.7rem;">Period</label>
                            <select name="period" class="form-select bg-light border-0" onchange="this.form.submit()" 
                                    style="font-size: 0.75rem; padding: 0.2rem 0.5rem; height: 30px;">
                                <option value="all" {{ $period == 'all' ? 'selected' : '' }}>🌐 All Time</option>
                                <option value="today" {{ $period == 'today' ? 'selected' : '' }}>📅 Today</option>
                                <option value="week" {{ $period == 'week' ? 'selected' : '' }}>📅 Last 7 Days</option>
                                <option value="month" {{ $period == 'month' ? 'selected' : '' }}>📅 Last 30 Days</option>
                                <option value="year" {{ $period == 'year' ? 'selected' : '' }}>📅 Last 365 Days</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-muted small mb-0" style="font-size: 0.7rem;">&nbsp;</label>
                            <div class="d-flex gap-1">
                                <button type="submit" class="btn btn-primary btn-sm flex-fill" style="font-size: 0.7rem; padding: 0.2rem 0.5rem; height: 30px;">
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
        </div>

        <!-- Metrics Cards -->
        <section class="row g-2 mb-3" aria-label="Dashboard metrics">
            <div class="col-12 col-sm-6 col-xl-3">
                <article class="metric-card metric-primary" style="padding: 0.6rem 0.8rem;">
                    <div class="metric-top" style="margin-bottom: 0.2rem;">
                        <span class="metric-label" style="font-size: 0.65rem;">Total Downloads</span>
                        <span class="metric-icon" style="font-size: 0.8rem; width: 24px; height: 24px;">
                            <i class="bi bi-download" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="metric-value" style="font-size: 1.2rem; font-weight: 700;">{{ number_format($overallStats['total_downloads'] ?? 0) }}</div>
                    <div class="metric-meta" style="font-size: 0.6rem;">
                        <span class="text-success">+15.3%</span>
                        <span>from previous period</span>
                    </div>
                </article>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <article class="metric-card metric-success" style="padding: 0.6rem 0.8rem;">
                    <div class="metric-top" style="margin-bottom: 0.2rem;">
                        <span class="metric-label" style="font-size: 0.65rem;">Total Publications</span>
                        <span class="metric-icon" style="font-size: 0.8rem; width: 24px; height: 24px;">
                            <i class="bi bi-file-earmark-pdf" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="metric-value" style="font-size: 1.2rem; font-weight: 700;">{{ number_format($overallStats['total_publications'] ?? 0) }}</div>
                    <div class="metric-meta" style="font-size: 0.6rem;">
                        <span class="text-success">+8.2%</span>
                        <span>total publications</span>
                    </div>
                </article>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <article class="metric-card metric-warning" style="padding: 0.6rem 0.8rem;">
                    <div class="metric-top" style="margin-bottom: 0.2rem;">
                        <span class="metric-label" style="font-size: 0.65rem;">Avg Downloads per Pub</span>
                        <span class="metric-icon" style="font-size: 0.8rem; width: 24px; height: 24px;">
                            <i class="bi bi-bar-chart" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="metric-value" style="font-size: 1.2rem; font-weight: 700;">{{ number_format($overallStats['average_downloads'] ?? 0, 1) }}</div>
                    <div class="metric-meta" style="font-size: 0.6rem;">
                        <span class="text-success">+5.1%</span>
                        <span>average performance</span>
                    </div>
                </article>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <article class="metric-card metric-danger" style="padding: 0.6rem 0.8rem;">
                    <div class="metric-top" style="margin-bottom: 0.2rem;">
                        <span class="metric-label" style="font-size: 0.65rem;">Active Publications</span>
                        <span class="metric-icon" style="font-size: 0.8rem; width: 24px; height: 24px;">
                            <i class="bi bi-check-circle" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="metric-value" style="font-size: 1.2rem; font-weight: 700;">{{ number_format($overallStats['publications_with_downloads'] ?? 0) }}</div>
                    <div class="metric-meta" style="font-size: 0.6rem;">
                        <span class="text-success">+12.5%</span>
                        <span>with downloads</span>
                    </div>
                </article>
            </div>
        </section>

        <!-- Most & Least Downloaded Row -->
        <section class="row g-2 mb-3">
            <div class="col-12 col-xl-6">
                <div class="panel">
                    <div class="panel-header p-2">
                        <div>
                            <h2 class="section-title mb-0" style="font-size: 0.8rem;">
                                <i class="bi bi-trophy" aria-hidden="true"></i>
                                <span>Most Downloaded</span>
                            </h2>
                            <p class="text-muted mb-0" style="font-size: 0.65rem;">Top publication by downloads.</p>
                        </div>
                    </div>
                    <div class="panel-body p-2">
                        @if(isset($overallStats['most_downloaded']) && $overallStats['most_downloaded'])
                            <div class="d-flex align-items-center gap-3 p-2 bg-primary-soft rounded-2">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 40px; height: 40px; font-size: 1.2rem;">
                                    <i class="bi bi-file-earmark-pdf"></i>
                                </div>
                                <div>
                                    <p class="fw-semibold mb-0" style="font-size: 0.8rem;">
                                        <a href="{{ route('publications.show', $overallStats['most_downloaded']->id) }}" 
                                           class="text-decoration-none text-dark hover-primary">
                                            {{ Str::limit($overallStats['most_downloaded']->title, 40) }}
                                        </a>
                                    </p>
                                    <p class="text-muted small mb-0" style="font-size: 0.65rem;">
                                        <i class="bi bi-person me-1"></i> {{ $overallStats['most_downloaded']->authors ?? 'Unknown' }}
                                    </p>
                                </div>
                                <div class="ms-auto">
                                    <span class="badge bg-primary rounded-pill" style="font-size: 0.7rem;">
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
                    <div class="panel-header p-2">
                        <div>
                            <h2 class="section-title mb-0" style="font-size: 0.8rem;">
                                <i class="bi bi-arrow-up" aria-hidden="true"></i>
                                <span>Least Downloaded</span>
                            </h2>
                            <p class="text-muted mb-0" style="font-size: 0.65rem;">Publication needing more attention.</p>
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
                                    <p class="text-muted small mb-0" style="font-size: 0.65rem;">
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
        </section>

        <!-- Recent Publications Row -->
        <section class="row g-2 mb-3">
            <div class="col-12 col-xl-12">
                <div class="panel">
                    <div class="panel-header p-2">
                        <div>
                            <h2 class="section-title mb-0" style="font-size: 0.8rem;">
                                <i class="bi bi-clock-history" aria-hidden="true"></i>
                                <span>Recent Publications</span>
                            </h2>
                            <p class="text-muted mb-0" style="font-size: 0.65rem;">Latest publications added to the library.</p>
                        </div>
                    </div>
                    <div class="panel-body p-2">
                        @if(isset($overallStats['recent_publications']) && $overallStats['recent_publications']->count())
                            <div class="row g-2">
                                @foreach($overallStats['recent_publications'] as $recent)
                                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                                        <div class="p-2 bg-light rounded-2">
                                            <div class="d-flex align-items-start gap-2">
                                                <div class="bg-primary-soft text-primary rounded-circle d-flex align-items-center justify-content-center" 
                                                     style="width: 28px; height: 28px; font-size: 0.8rem; flex-shrink: 0;">
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
                            </div>
                        @else
                            <div class="text-center py-2">
                                <i class="bi bi-inbox text-muted mb-1" style="font-size: 1.2rem;"></i>
                                <p class="text-muted small mb-0">No recent publications found</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- Quick Stats & Authors Row -->
        <section class="row g-2 mb-3">
            <div class="col-12 col-xl-6">
                <div class="panel">
                    <div class="panel-header p-2">
                        <div>
                            <h2 class="section-title mb-0" style="font-size: 0.8rem;">
                                <i class="bi bi-speedometer2" aria-hidden="true"></i>
                                <span>Quick Stats</span>
                            </h2>
                            <p class="text-muted mb-0" style="font-size: 0.65rem;">At-a-glance performance metrics.</p>
                        </div>
                    </div>
                    <div class="panel-body p-2">
                        <div class="row g-1">
                            <div class="col-6">
                                <div class="p-2 bg-light rounded-2 text-center">
                                    <div class="text-muted" style="font-size: 0.55rem;">Total Size</div>
                                    <div class="fw-bold text-primary" style="font-size: 0.9rem;">
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
                            <div class="col-6">
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
                            <div class="col-6">
                                <div class="p-2 bg-light rounded-2 text-center">
                                    <div class="text-muted" style="font-size: 0.55rem;">Most Downloaded</div>
                                    <div class="fw-bold text-truncate" style="font-size: 0.65rem;">
                                        @if(isset($overallStats['most_downloaded']) && $overallStats['most_downloaded'])
                                            <a href="{{ route('publications.show', $overallStats['most_downloaded']->id) }}" 
                                               class="text-decoration-none text-dark">
                                                {{ Str::limit($overallStats['most_downloaded']->title, 12) }}
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
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
                </div>
            </div>

            <div class="col-12 col-xl-6">
                <div class="panel">
                    <div class="panel-header p-2">
                        <div>
                            <h2 class="section-title mb-0" style="font-size: 0.8rem;">
                                <i class="bi bi-file-earmark-text" aria-hidden="true"></i>
                                <span>File Types Distribution</span>
                            </h2>
                            <p class="text-muted mb-0" style="font-size: 0.65rem;">Publication file type breakdown.</p>
                        </div>
                    </div>
                    <div class="panel-body p-2">
                        @php
                            $fileTypes = \App\Models\Publication::select('file_path')
                                ->get()
                                ->map(function($pub) {
                                    return pathinfo($pub->file_path, PATHINFO_EXTENSION);
                                })
                                ->countBy();
                        @endphp
                        @if($fileTypes->count())
                            <div class="row g-1">
                                @foreach($fileTypes as $ext => $count)
                                    <div class="col-4">
                                        <div class="p-2 bg-light rounded-2 text-center">
                                            <div class="text-muted" style="font-size: 0.55rem;">.{{ $ext }}</div>
                                            <div class="fw-bold" style="font-size: 0.85rem;">{{ number_format($count) }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-2">
                                <p class="text-muted small mb-0">No file type data available</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- Publications Stats Table -->
        <section class="panel">
            <div class="panel-header p-2">
                <div>
                    <h2 class="section-title mb-0" style="font-size: 0.8rem;">
                        <i class="bi bi-table" aria-hidden="true"></i>
                        <span>Publication Statistics</span>
                    </h2>
                    <p class="text-muted mb-0" style="font-size: 0.65rem;">Detailed download analytics for all publications.</p>
                </div>
                <span class="badge bg-light text-dark" style="font-size: 0.6rem;">
                    <i class="bi bi-list me-1"></i> {{ $publications->count() }} of {{ $publications->total() }}
                </span>
            </div>
            <div class="panel-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0" style="font-size: 0.7rem;">
                        <thead>
                            <tr>
                                <th scope="col" style="font-size: 0.65rem;">#</th>
                                <th scope="col" style="font-size: 0.65rem;">Title</th>
                                <th scope="col" style="font-size: 0.65rem;">Authors</th>
                                <th scope="col" class="text-center" style="font-size: 0.65rem;">Downloads</th>
                                <th scope="col" style="font-size: 0.65rem;">Size</th>
                                <th scope="col" style="font-size: 0.65rem;">Type</th>
                                <th scope="col" style="font-size: 0.65rem;">Added</th>
                                <th scope="col" class="text-center" style="font-size: 0.65rem;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($publications as $index => $pub)
                                <tr>
                                    <td style="font-size: 0.65rem;">{{ $publications->firstItem() + $index }}</td>
                                    <td>
                                        <a href="{{ route('publications.show', $pub->id) }}" 
                                           class="text-decoration-none text-dark hover-primary" style="font-size: 0.7rem;">
                                            {{ Str::limit($pub->title, 30) }}
                                        </a>
                                    </td>
                                    <td style="font-size: 0.65rem;">{{ Str::limit($pub->authors ?? '-', 20) }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ ($pub->downloads ?? 0) > 50 ? 'danger' : (($pub->downloads ?? 0) > 20 ? 'warning' : 'secondary') }}" style="font-size: 0.6rem;">
                                            <i class="bi bi-download me-1"></i> {{ number_format($pub->downloads ?? 0) }}
                                        </span>
                                    </td>
                                    <td style="font-size: 0.65rem;">
                                        @if($pub->file_size)
                                            {{ number_format($pub->file_size / 1024, 1) }} KB
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark" style="font-size: 0.55rem;">
                                            {{ strtoupper(pathinfo($pub->file_path, PATHINFO_EXTENSION)) }}
                                        </span>
                                    </td>
                                    <td style="font-size: 0.6rem;">
                                        {{ $pub->created_at->diffForHumans() }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('publications.show', $pub->id) }}" 
                                           class="btn btn-light btn-sm" title="View Publication" 
                                           style="padding: 0.1rem 0.3rem; font-size: 0.65rem;">
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
            </div>
            <div class="panel-footer d-flex justify-content-center p-2">
                {{ $publications->appends(['search' => request('search'), 'period' => request('period')])->links('pagination::bootstrap-5') }}
            </div>
        </section>
    </div>
</main>
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

@push('styles')
<style>
    /* Additional styles for the publication statistics page */
    .bg-primary-soft {
        background: rgba(78, 115, 223, 0.1);
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
        color: rgba(78, 115, 223, 0.6);
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
        color: #4e73df !important;
    }

    /* Compact Metric Cards */
    .metric-card {
        padding: 0.6rem 0.8rem !important;
        border-radius: 8px !important;
    }
    
    .metric-card .metric-top {
        margin-bottom: 0.2rem !important;
    }
    
    .metric-card .metric-label {
        font-size: 0.65rem !important;
    }
    
    .metric-card .metric-value {
        font-size: 1.2rem !important;
        font-weight: 700 !important;
        line-height: 1.3 !important;
    }
    
    .metric-card .metric-meta {
        font-size: 0.6rem !important;
    }
    
    .metric-card .metric-icon {
        width: 24px !important;
        height: 24px !important;
        font-size: 0.8rem !important;
    }

    /* Compact Panel */
    .panel-header {
        padding: 0.5rem 0.75rem !important;
    }
    
    .panel-body {
        padding: 0.5rem 0.75rem !important;
    }
    
    .panel-footer {
        padding: 0.5rem 0.75rem !important;
    }

    /* Table compact */
    .table td, .table th {
        padding: 0.35rem 0.5rem !important;
        vertical-align: middle;
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
</style>
@endpush