@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">📚 Blog Posts</h5>
        <a href="{{ route('blog.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus me-1"></i> Add Blog
        </a>
    </div>

    <!-- Search Form -->
    <form action="{{ route('blog.index') }}" method="GET" class="mb-3">
        <div class="input-group input-group-sm">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search blog...">
            <button class="btn btn-outline-secondary" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>

    <!-- Blog Posts Table -->
    <div class="table-responsive">
       <table class="table table-bordered table-hover align-middle small custom-blog-table">
            <thead class="table-light text-center">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Image</th>
                    <th>Snippet</th>
                    <th>Views</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($blogs as $index => $item)
                    <tr>
                        <td>{{ ($blogs->currentPage() - 1) * $blogs->perPage() + $index + 1 }}</td>
                        <td class="fw-semibold">{{ $item->title }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->date)->format('M d, Y') }}</td>
                        <td class="text-center">
                            @if ($item->image)
                                <img src="{{ asset($item->image) }}" alt="Image" class="img-thumbnail rounded" style="max-width: 70px;">
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>{{ \Illuminate\Support\Str::limit(strip_tags($item->content), 80, '...') }}</td>
                        <td class="text-center">
                        <!-- Example Button -->
                        <button
                            class="btn btn-primary open-stats-modal"
                            data-bs-toggle="modal"
                            data-bs-target="#statsModal"
                            data-blog-id="{{ $item->id }}"
                            data-blog-title="{{ $item->title }}"
                            data-last_1_day="{{ $stats[$item->id]['last_1_day'] ?? 0 }}"
                            data-last_7_days="{{ $stats[$item->id]['last_7_days'] ?? 0 }}"
                            data-last_30_days="{{ $stats[$item->id]['last_30_days'] ?? 0 }}"
                            data-last_365_days="{{ $stats[$item->id]['last_365_days'] ?? 0 }}"
                        >
                            View Stats
                        </button>
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('blog.show', $item->slug) }}" class="btn btn-info" title="View"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('blog.edit', $item->id) }}" class="btn btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('blog.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this blog post?');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No blog posts found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $blogs->appends(['search' => request('search')])->links() }}
    </div>
</div>

<!-- Stats Modal -->
<div class="modal fade" id="statsModal" tabindex="-1" aria-labelledby="statsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-white rounded-xl shadow-2xl p-6">
            <div class="modal-header border-0 pb-0">
                <h2 class="modal-title text-2xl font-bold text-gray-800 flex items-center" id="statsModalLabel">
                    <span class="mr-2">📊</span> Blog View Stats
                </h2>
                <button type="button" class="btn-close text-gray-500" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="btn-group w-100 mb-4" role="group">
                    <button type="button" class="btn btn-success stat-btn" data-period="last_1_day">1 Day</button>
                    <button type="button" class="btn btn-warning stat-btn" data-period="last_7_days">7 Days</button>
                    <button type="button" class="btn btn-info stat-btn" data-period="last_30_days">30 Days</button>
                    <button type="button" class="btn btn-danger stat-btn" data-period="last_365_days">1 Year</button>
                </div>
                <div id="statDisplay" class="text-center mb-4">
                  
                    <div class="text-center mt-3">
                        <div id="statPeriod" class="text-sm text-gray-600 mb-1">
                            Total Views for Last <span id="periodLabel">7</span> Days
                        </div>
                        <div id="statValue" class="text-4xl font-bold text-gray-800 fw-bold" style="font-size: 24px; color: green;">0</div>
                    </div>
                </div>
                <div class="chart-container p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <canvas id="viewsChart" height="120"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Modal styling */
    .modal-content {
        background: linear-gradient(145deg, #ffffff, #f8f9fa);
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }
    .modal-dialog-centered {
        max-width: 500px;
    }
    .modal-header {
        padding-bottom: 0;
    }
    .btn-close {
        font-size: 1.25rem;
        color: #495057;
        opacity: 0.8;
        transition: color 0.2s ease, transform 0.2s ease;
    }
    .btn-close:hover {
        color: #dc3545;
        opacity: 1;
        transform: scale(1.2);
    }
    .btn-close:focus {
        outline: 2px solid #0d6efd;
        outline-offset: 2px;
    }

    /* Stat buttons */
    .stat-btn {
        font-weight: 600;
        font-size: 14px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .stat-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
    }
    .stat-btn:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.3);
    }
    .stat-btn:active {
        transform: translateY(0);
    }

    /* Chart container */
    .chart-container {
        margin-top: 1.5rem;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    /* Responsive adjustments */
    @media (max-width: 640px) {
        .modal-dialog {
            margin: 0.5rem;
        }
        .modal-content {
            padding: 1rem;
        }
        .stat-btn {
            font-size: 12px;
            padding: 0.5rem;
        }
        #statValue {
            font-size: 2rem;
        }
        #statPeriod {
            font-size: 0.75rem;
        }
        .chart-container {
            padding: 0.75rem;
        }
        .modal-title {
            font-size: 1.5rem;
        }
    }
    /* Blog Table Enhancements */
.custom-blog-table th,
.custom-blog-table td {
    vertical-align: middle !important;
    padding: 0.45rem 0.65rem;
    font-size: 13px;
}

.custom-blog-table th {
    text-align: center;
    background-color: #f8f9fa;
    font-weight: 600;
    color: #343a40;
    white-space: nowrap;
}

.custom-blog-table td img {
    max-height: 60px;
    object-fit: cover;
    border-radius: 6px;
}

.custom-blog-table .btn {
    font-size: 12px;
    padding: 0.25rem 0.4rem;
}

.custom-blog-table .btn i {
    font-size: 13px;
}

.custom-blog-table td:nth-child(2) {
    font-weight: 600;
    color: #212529;
}

.custom-blog-table td:nth-child(5) {
    font-size: 12px;
    color: #495057;
    max-width: 220px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

</style>
@endsection
<script>
document.addEventListener('DOMContentLoaded', function () {
    let currentStats = null;
    let chartInstance = null;

    const periodLabels = {
        'last_1_day': 'Last 1 Day',
        'last_7_days': 'Last 7 Days',
        'last_30_days': 'Last 30 Days',
        'last_365_days': 'Last 1 Year'
    };

    function updateStatDisplay(period) {
        const statValue = document.getElementById('statValue');
        const statPeriod = document.getElementById('statPeriod');
        const value = Number(currentStats?.[period] || 0);
        statValue.textContent = value;
        statPeriod.textContent = `Total Views for ${periodLabels[period] || 'Unknown Period'}`;
    }

    function updateChart(stats) {
        const ctx = document.getElementById('viewsChart');
        if (!ctx) return;
        const context = ctx.getContext('2d');
        const data = [
            Number(stats['last_1_day'] || 0),
            Number(stats['last_7_days'] || 0),
            Number(stats['last_30_days'] || 0),
            Number(stats['last_365_days'] || 0)
        ];

        if (chartInstance) chartInstance.destroy();

        chartInstance = new Chart(context, {
            type: 'bar',
            data: {
                labels: ['1 Day', '7 Days', '30 Days', '365 Days'],
                datasets: [{
                    label: 'Views',
                    data: data,
                    backgroundColor: ['#28a745', '#ffc107', '#17a2b8', '#dc3545'],
                    borderColor: ['#1e7e34', '#e0a800', '#138496', '#c82333'],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#e9ecef' },
                        ticks: { color: '#495057' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#495057' }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: '#495057',
                            font: { size: 14 }
                        }
                    }
                }
            }
        });
    }

    document.querySelectorAll('.open-stats-modal').forEach(btn => {
        btn.addEventListener('click', function () {
            currentStats = {
                last_1_day: this.getAttribute('data-last_1_day'),
                last_7_days: this.getAttribute('data-last_7_days'),
                last_30_days: this.getAttribute('data-last_30_days'),
                last_365_days: this.getAttribute('data-last_365_days'),
            };
            updateStatDisplay('last_7_days');
            updateChart(currentStats);
        });
    });

    document.querySelectorAll('.stat-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const period = this.getAttribute('data-period');
            updateStatDisplay(period);
        });
    });

    const statsModal = document.getElementById('statsModal');
    statsModal.addEventListener('hidden.bs.modal', function () {
        currentStats = null;
        if (chartInstance) {
            chartInstance.destroy();
            chartInstance = null;
        }
        document.getElementById('statValue').textContent = '0';
        document.getElementById('statPeriod').textContent = 'Total Views for Last 7 Days';
    });
});
</script>
