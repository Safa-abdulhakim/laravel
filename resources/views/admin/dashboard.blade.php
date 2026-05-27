@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<style>
    .chart-container { position: relative; height: 260px; }
</style>
@endpush

@section('content')
{{-- Stats Row --}}
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-box" style="background:#eef2ff;">
                    <i class="bi bi-grid-3x3-gap-fill" style="color:#6366f1;"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Projects</div>
                    <div class="fs-3 fw-bold">{{ $stats['projects'] }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-box" style="background:#fef3c7;">
                    <i class="bi bi-lightning-charge-fill" style="color:#f59e0b;"></i>
                </div>
                <div>
                    <div class="text-muted small">Skills</div>
                    <div class="fs-3 fw-bold">{{ $stats['skills'] }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-box" style="background:#d1fae5;">
                    <i class="bi bi-award-fill" style="color:#10b981;"></i>
                </div>
                <div>
                    <div class="text-muted small">Certificates</div>
                    <div class="fs-3 fw-bold">{{ $stats['certificates'] }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-box" style="background:#fee2e2;">
                    <i class="bi bi-chat-dots-fill" style="color:#ef4444;"></i>
                </div>
                <div>
                    <div class="text-muted small">Messages
                        @if($stats['new_messages'] > 0)
                            <span class="badge bg-danger ms-1">{{ $stats['new_messages'] }} new</span>
                        @endif
                    </div>
                    <div class="fs-3 fw-bold">{{ $stats['messages'] }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Charts Row --}}
<div class="row g-4 mb-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="mb-0 fw-semibold">Projects by Status</h6>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="projectsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="mb-0 fw-semibold">Skills by Category</h6>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="skillsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Recent Data Row --}}
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-semibold">Recent Projects</h6>
                <a href="{{ route('admin.projects.create') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>Add New
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Title</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentProjects as $project)
                            <tr>
                                <td class="ps-3">
                                    <div class="fw-medium">{{ Str::limit($project->title, 30) }}</div>
                                </td>
                                <td>
                                    <span class="badge badge-status-{{ $project->status }} rounded-pill px-2">
                                        {{ ucfirst($project->status) }}
                                    </span>
                                </td>
                                <td class="text-muted">{{ $project->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.projects.edit', $project) }}"
                                       class="btn btn-sm btn-light"><i class="bi bi-pencil"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">No projects yet</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-semibold">Recent Messages</h6>
                <a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
            </div>
            <div class="card-body p-0">
                @forelse($recentMessages as $msg)
                <a href="{{ route('admin.messages.show', $msg) }}"
                   class="d-flex align-items-start p-3 border-bottom text-decoration-none text-dark hover-bg
                          {{ $msg->status === 'new' ? 'bg-light' : '' }}">
                    <div class="rounded-circle me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:36px;height:36px;background:#e0e7ff;color:#6366f1;font-weight:600;">
                        {{ strtoupper(substr($msg->name, 0, 1)) }}
                    </div>
                    <div class="flex-grow-1 min-width-0">
                        <div class="d-flex justify-content-between">
                            <span class="fw-medium small">{{ $msg->name }}</span>
                            @if($msg->status === 'new')
                                <span class="badge badge-status-new rounded-pill">New</span>
                            @endif
                        </div>
                        <div class="text-muted small text-truncate">{{ Str::limit($msg->message, 50) }}</div>
                    </div>
                </a>
                @empty
                <div class="text-center text-muted py-4">No messages yet</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Projects Chart
    new Chart(document.getElementById('projectsChart'), {
        type: 'doughnut',
        data: {
            labels: ['Featured', 'Active', 'Inactive'],
            datasets: [{
                data: [
                    {{ $projectsByStatus['featured'] }},
                    {{ $projectsByStatus['active'] }},
                    {{ $projectsByStatus['inactive'] }}
                ],
                backgroundColor: ['#6366f1', '#10b981', '#f59e0b'],
                borderWidth: 0,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } },
            cutout: '65%'
        }
    });

    // Skills Chart
    const skillLabels = {!! json_encode(array_keys($skillsByCategory)) !!};
    const skillValues = {!! json_encode(array_values($skillsByCategory)) !!};
    new Chart(document.getElementById('skillsChart'), {
        type: 'bar',
        data: {
            labels: skillLabels.map(l => l.charAt(0).toUpperCase() + l.slice(1)),
            datasets: [{
                label: 'Skills Count',
                data: skillValues,
                backgroundColor: ['#6366f1', '#10b981', '#f59e0b', '#ef4444'],
                borderRadius: 8, borderWidth: 0
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } }, x: { grid: { display: false } } }
        }
    });
</script>
@endpush
