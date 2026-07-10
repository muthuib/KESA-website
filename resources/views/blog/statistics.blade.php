@extends('layouts.app')

@section('content')
<div class="container mt-1">
        <!-- Page Heading -->
        <div class="page-heading mb-3">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-graph-up-arrow" aria-hidden="true"></i></span>
                <div>
                    <p class="eyebrow mb-0 small">Analytics</p>
                    <h1 class="h5 mb-0">Blog Statistics</h1>
                    <p class="text-muted small mb-0">
                        Detailed analytics for all blog posts
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
                <a href="{{ route('blog.index') }}" class="btn btn-outline-secondary btn-sm" style="font-size: 0.7rem; padding: 0.2rem 0.6rem;">
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
                <form action="{{ route('blog.statistics') }}" method="GET">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label text-muted small mb-0" style="font-size: 0.7rem;">Search</label>
                            <div class="input-group" style="height: 30px;">
                                <span class="input-group-text bg-light border-0" style="padding: 0.2rem 0.5rem; font-size: 0.7rem;">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}" 
                                       class="form-control bg-light border-0" placeholder="Search blog posts..." 
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
                                <a href="{{ route('blog.statistics') }}" class="btn btn-outline-secondary btn-sm" style="font-size: 0.7rem; padding: 0.2rem 0.5rem; height: 30px;">
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
                        <span class="metric-label" style="font-size: 0.65rem;">
                            @if($period == 'all') Total Views
                            @elseif($period == 'today') Today's Views
                            @elseif($period == 'week') Last 7 Days
                            @elseif($period == 'month') Last 30 Days
                            @else Last Year
                            @endif
                        </span>
                        <span class="metric-icon" style="font-size: 0.8rem; width: 24px; height: 24px;">
                            <i class="bi bi-eye" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="metric-value" style="font-size: 1.2rem; font-weight: 700;">{{ number_format($overallStats['total_views'] ?? 0) }}</div>
                    <div class="metric-meta" style="font-size: 0.6rem;">
                        <span class="text-success">+12.5%</span>
                        <span>from previous</span>
                    </div>
                </article>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <article class="metric-card metric-success" style="padding: 0.6rem 0.8rem;">
                    <div class="metric-top" style="margin-bottom: 0.2rem;">
                        <span class="metric-label" style="font-size: 0.65rem;">Blogs with Views</span>
                        <span class="metric-icon" style="font-size: 0.8rem; width: 24px; height: 24px;">
                            <i class="bi bi-newspaper" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="metric-value" style="font-size: 1.2rem; font-weight: 700;">{{ number_format($overallStats['blogs_with_views'] ?? 0) }}</div>
                    <div class="metric-meta" style="font-size: 0.6rem;">
                        <span class="text-success">+8.2%</span>
                        <span>active blogs</span>
                    </div>
                </article>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <article class="metric-card metric-warning" style="padding: 0.6rem 0.8rem;">
                    <div class="metric-top" style="margin-bottom: 0.2rem;">
                        <span class="metric-label" style="font-size: 0.65rem;">Avg Views per Blog</span>
                        <span class="metric-icon" style="font-size: 0.8rem; width: 24px; height: 24px;">
                            <i class="bi bi-bar-chart" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="metric-value" style="font-size: 1.2rem; font-weight: 700;">{{ number_format($overallStats['average_views'] ?? 0, 1) }}</div>
                    <div class="metric-meta" style="font-size: 0.6rem;">
                        <span class="text-success">+5.1%</span>
                        <span>average</span>
                    </div>
                </article>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <article class="metric-card metric-danger" style="padding: 0.6rem 0.8rem;">
                    <div class="metric-top" style="margin-bottom: 0.2rem;">
                        <span class="metric-label" style="font-size: 0.65rem;">Last 30 Days Views</span>
                        <span class="metric-icon" style="font-size: 0.8rem; width: 24px; height: 24px;">
                            <i class="bi bi-calendar-check" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="metric-value" style="font-size: 1.2rem; font-weight: 700;">{{ number_format($overallStats['views_last_30_days'] ?? 0) }}</div>
                    <div class="metric-meta" style="font-size: 0.6rem;">
                        <span class="text-danger">-2.1%</span>
                        <span>from last month</span>
                    </div>
                </article>
            </div>
        </section>

        <!-- Charts & Categories Row -->
        <section class="row g-2 mb-3">
            <div class="col-12 col-xl-7">
                <div class="panel">
                    <div class="panel-header p-2">
                        <div>
                            <h2 class="section-title mb-0" style="font-size: 0.8rem;">
                                <i class="bi bi-graph-up-arrow" aria-hidden="true"></i>
                                <span>Monthly Trends</span>
                            </h2>
                            <p class="text-muted mb-0" style="font-size: 0.65rem;">Blog view trends over the past months.</p>
                        </div>
                        <span class="badge bg-light text-dark" style="font-size: 0.6rem;">{{ now()->format('Y') }}</span>
                    </div>
                    <div class="panel-body p-2">
                        <div style="height: 200px;">
                            @if(isset($monthlyTrends) && $monthlyTrends->count())
                                <canvas id="monthlyChart"></canvas>
                            @else
                                <div class="text-center py-3">
                                    <i class="bi bi-bar-chart-line text-muted mb-1" style="font-size: 1.5rem;"></i>
                                    <p class="text-muted small mb-0">No data available</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-5">
                <div class="panel h-100">
                    <div class="panel-header p-2">
                        <div>
                            <h2 class="section-title mb-0" style="font-size: 0.8rem;">
                                <i class="bi bi-tags" aria-hidden="true"></i>
                                <span>Top Categories</span>
                            </h2>
                            <p class="text-muted mb-0" style="font-size: 0.65rem;">Most viewed blog categories.</p>
                        </div>
                    </div>
                    <div class="panel-body p-2">
                        @if(isset($topCategories) && $topCategories->count())
                            <div class="activity-list">
                                @foreach($topCategories as $category)
                                    <div class="activity-item" style="padding: 0.3rem 0;">
                                        <span class="activity-dot bg-primary" style="width: 6px; height: 6px;"></span>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <p class="mb-0 fw-semibold" style="font-size: 0.7rem;">{{ $category->category ?? 'Uncategorized' }}</p>
                                                <span class="badge bg-primary-soft text-primary rounded-pill" style="font-size: 0.6rem;">
                                                    {{ number_format($category->total_views) }}
                                                </span>
                                            </div>
                                            <div class="progress" style="height: 3px;">
                                                <div class="progress-bar bg-primary" 
                                                     style="width: {{ ($category->total_views / ($topCategories->max('total_views') ?? 1)) * 100 }}%;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-2">
                                <i class="bi bi-tag text-muted mb-1" style="font-size: 1.2rem;"></i>
                                <p class="text-muted small mb-0">No category data available</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- Authors & Quick Stats Row -->
        <section class="row g-2 mb-3">
            <div class="col-12 col-xl-6">
                <div class="panel">
                    <div class="panel-header p-2">
                        <div>
                            <h2 class="section-title mb-0" style="font-size: 0.8rem;">
                                <i class="bi bi-people" aria-hidden="true"></i>
                                <span>Top Authors</span>
                            </h2>
                            <p class="text-muted mb-0" style="font-size: 0.65rem;">Most active and viewed authors.</p>
                        </div>
                    </div>
                    <div class="panel-body p-2">
                        @if(isset($topAuthors) && $topAuthors->count())
                            <div class="activity-list">
                                @foreach($topAuthors as $author)
                                    <div class="activity-item" style="padding: 0.3rem 0;">
                                        <span class="activity-dot bg-success" style="width: 6px; height: 6px;"></span>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="avatar-img bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                                         style="width: 22px; height: 22px; font-size: 9px; font-weight: 600;">
                                                        {{ substr($author->author ?? 'U', 0, 1) }}
                                                    </div>
                                                    <p class="mb-0 fw-semibold" style="font-size: 0.7rem;">{{ $author->author ?? 'Unknown' }}</p>
                                                </div>
                                                <span class="badge bg-success-soft text-success rounded-pill" style="font-size: 0.6rem;">
                                                    <i class="bi bi-eye me-1"></i> {{ number_format($author->total_views) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-2">
                                <i class="bi bi-person text-muted mb-1" style="font-size: 1.2rem;"></i>
                                <p class="text-muted small mb-0">No author data available</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-6">
                <div class="panel h-100">
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
                                    <div class="text-muted" style="font-size: 0.55rem;">Total Blogs</div>
                                    <div class="fw-bold text-primary" style="font-size: 0.9rem;">{{ number_format($overallStats['total_blogs'] ?? 0) }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-2 bg-light rounded-2 text-center">
                                    <div class="text-muted" style="font-size: 0.55rem;">Unique Visitors</div>
                                    <div class="fw-bold text-success" style="font-size: 0.9rem;">{{ number_format($overallStats['unique_visitors'] ?? 0) }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-2 bg-light rounded-2 text-center">
                                    <div class="text-muted" style="font-size: 0.55rem;">Most Viewed</div>
                                    <div class="fw-bold text-truncate" style="font-size: 0.65rem;">
                                        @if(isset($overallStats['most_viewed']) && $overallStats['most_viewed'])
                                            <a href="{{ route('blog.show', $overallStats['most_viewed']->slug) }}" 
                                               class="text-decoration-none text-dark">
                                                {{ Str::limit($overallStats['most_viewed']->title, 12) }}
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-2 bg-light rounded-2 text-center">
                                    <div class="text-muted" style="font-size: 0.55rem;">Avg Daily Views</div>
                                    <div class="fw-bold text-info" style="font-size: 0.9rem;">
                                        @php
                                            $avgDaily = 0;
                                            if (isset($overallStats['total_views']) && $overallStats['total_views'] > 0) {
                                                $days = 30;
                                                if ($period == 'today') $days = 1;
                                                elseif ($period == 'week') $days = 7;
                                                elseif ($period == 'month') $days = 30;
                                                elseif ($period == 'year') $days = 365;
                                                $avgDaily = round($overallStats['total_views'] / $days, 1);
                                            }
                                        @endphp
                                        {{ number_format($avgDaily, 1) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Blog Stats Table -->
        <section class="panel">
            <div class="panel-header p-2">
                <div>
                    <h2 class="section-title mb-0" style="font-size: 0.8rem;">
                        <i class="bi bi-table" aria-hidden="true"></i>
                        <span>Blog Post Statistics</span>
                    </h2>
                    <p class="text-muted mb-0" style="font-size: 0.65rem;">Detailed view count analytics for all blog posts.</p>
                </div>
                <span class="badge bg-light text-dark" style="font-size: 0.6rem;">
                    <i class="bi bi-list me-1"></i> {{ $blogs->count() }} of {{ $blogs->total() }}
                </span>
            </div>
            <div class="panel-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0" style="font-size: 0.7rem;">
                        <thead>
                            <tr>
                                <th scope="col" style="font-size: 0.65rem;">#</th>
                                <th scope="col" style="font-size: 0.65rem;">Title</th>
                                <th scope="col" style="font-size: 0.65rem;">Author</th>
                                <th scope="col" style="font-size: 0.65rem;">Category</th>
                                <th scope="col" class="text-center" style="font-size: 0.65rem;">Total</th>
                                <th scope="col" class="text-center" style="font-size: 0.65rem;">Unique</th>
                                <th scope="col" class="text-center" style="font-size: 0.65rem;">Daily</th>
                                <th scope="col" class="text-center" style="font-size: 0.65rem;">Weekly</th>
                                <th scope="col" class="text-center" style="font-size: 0.65rem;">Monthly</th>
                                <th scope="col" style="font-size: 0.65rem;">Last Viewed</th>
                                <th scope="col" class="text-center" style="font-size: 0.65rem;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($blogs as $index => $blog)
                                <tr>
                                    <td style="font-size: 0.65rem;">{{ $blogs->firstItem() + $index }}</td>
                                    <td>
                                        <a href="{{ route('blog.show', $blog->slug) }}" 
                                           class="text-decoration-none text-dark hover-primary" style="font-size: 0.7rem;">
                                            {{ Str::limit($blog->title, 25) }}
                                        </a>
                                    </td>
                                    <td style="font-size: 0.65rem;">{{ $blog->author ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-light text-dark" style="font-size: 0.55rem;">{{ $blog->category ?? 'Uncategorized' }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ ($blog->views ?? 0) > 100 ? 'danger' : (($blog->views ?? 0) > 50 ? 'warning' : 'secondary') }}" style="font-size: 0.6rem;">
                                            <i class="bi bi-eye me-1"></i> {{ number_format($blog->views ?? 0) }}
                                        </span>
                                    </td>
                                    <td class="text-center" style="font-size: 0.65rem;">{{ number_format($stats[$blog->id]['unique_views'] ?? 0) }}</td>
                                    <td class="text-center" style="font-size: 0.65rem;">{{ number_format($stats[$blog->id]['daily_views'] ?? 0) }}</td>
                                    <td class="text-center" style="font-size: 0.65rem;">{{ number_format($stats[$blog->id]['weekly_views'] ?? 0) }}</td>
                                    <td class="text-center" style="font-size: 0.65rem;">{{ number_format($stats[$blog->id]['monthly_views'] ?? 0) }}</td>
                                    <td>
                                        @if(isset($stats[$blog->id]['last_viewed']) && $stats[$blog->id]['last_viewed'])
                                            <span class="text-muted" style="font-size: 0.6rem;" 
                                                  title="{{ \Carbon\Carbon::parse($stats[$blog->id]['last_viewed'])->format('Y-m-d H:i:s') }}">
                                                {{ \Carbon\Carbon::parse($stats[$blog->id]['last_viewed'])->diffForHumans() }}
                                            </span>
                                        @else
                                            <span class="text-muted" style="font-size: 0.6rem;">Never</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('blog.show', $blog->slug) }}" 
                                           class="btn btn-light btn-sm" title="View Post" 
                                           style="padding: 0.1rem 0.3rem; font-size: 0.65rem;">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center py-3">
                                        <i class="bi bi-inbox text-muted d-block mb-1" style="font-size: 1.2rem;"></i>
                                        <p class="text-muted small mb-0">No blog posts found for this period</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer d-flex justify-content-center p-2">
                {{ $blogs->appends(['search' => request('search'), 'period' => request('period')])->links('pagination::bootstrap-5') }}
            </div>
        </section>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    @if(isset($monthlyTrends) && $monthlyTrends->count())
        const ctx = document.getElementById('monthlyChart').getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 200);
        gradient.addColorStop(0, 'rgba(78, 115, 223, 0.15)');
        gradient.addColorStop(1, 'rgba(78, 115, 223, 0)');
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($monthlyTrends->map(function($item) {
                    return date('M Y', mktime(0, 0, 0, $item->month, 1, $item->year));
                })) !!},
                datasets: [{
                    label: 'Views',
                    data: {!! json_encode($monthlyTrends->pluck('total_views')) !!},
                    borderColor: '#4e73df',
                    backgroundColor: gradient,
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#4e73df',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 1.5,
                    pointRadius: 3,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255,255,255,0.95)',
                        titleColor: '#1a1a2e',
                        bodyColor: '#1a1a2e',
                        borderColor: 'rgba(78,115,223,0.2)',
                        borderWidth: 1,
                        cornerRadius: 8,
                        padding: 8,
                        titleFont: { size: 11 },
                        bodyFont: { size: 11 },
                        callbacks: {
                            label: function(context) {
                                return 'Views: ' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString();
                            },
                            font: { size: 9 }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: { size: 9 }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
    @endif

    function exportToCSV() {
        const rows = document.querySelectorAll('table tbody tr');
        let csv = 'Title,Author,Category,Total Views,Unique Views,Daily,Weekly,Monthly,Last Viewed\n';
        
        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length > 1) {
                const rowData = [
                    cells[1]?.textContent?.trim() || '',
                    cells[2]?.textContent?.trim() || '',
                    cells[3]?.textContent?.trim() || '',
                    cells[4]?.textContent?.trim() || '',
                    cells[5]?.textContent?.trim() || '',
                    cells[6]?.textContent?.trim() || '',
                    cells[7]?.textContent?.trim() || '',
                    cells[8]?.textContent?.trim() || '',
                    cells[9]?.textContent?.trim() || ''
                ];
                csv += rowData.join(',') + '\n';
            }
        });

        const blob = new Blob(['\uFEFF' + csv], { type: 'text/csv;charset=utf-8' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'blog_statistics_{{ date('Y-m-d') }}.csv';
        a.click();
        window.URL.revokeObjectURL(url);
    }
</script>
@endpush

@push('styles')
<style>
    /* Additional styles for the blog statistics page */
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

    .panel-body .progress {
        background: rgba(78, 115, 223, 0.08);
        border-radius: 50px;
        overflow: hidden;
    }
    
    .panel-body .progress-bar {
        border-radius: 50px;
        transition: width 1s ease;
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

    /* Compact Activity Items */
    .activity-item {
        padding: 0.3rem 0 !important;
    }
    
    .activity-item .activity-dot {
        width: 6px !important;
        height: 6px !important;
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

    /* Avatar */
    .avatar-img {
        width: 22px;
        height: 22px;
        font-size: 9px;
        font-weight: 600;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-transform: uppercase;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
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
    }
</style>
@endpush