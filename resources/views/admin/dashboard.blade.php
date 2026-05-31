@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')
@section('content')

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card d-flex flex-row align-items-center gap-3">
            <div class="icon bg-primary bg-opacity-15"><i class="bi bi-people-fill fs-4 text-primary"></i></div>
            <div>
                <div class="fs-2 fw-bold">{{ number_format($stats['users']) }}</div>
                <div class="text-muted small">Total Users</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card d-flex flex-row align-items-center gap-3">
            <div class="icon bg-success bg-opacity-15"><i class="bi bi-map-fill fs-4 text-success"></i></div>
            <div>
                <div class="fs-2 fw-bold">{{ number_format($stats['career_paths']) }}</div>
                <div class="text-muted small">Career Paths</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card d-flex flex-row align-items-center gap-3">
            <div class="icon bg-warning bg-opacity-15"><i class="bi bi-lightning-fill fs-4 text-warning"></i></div>
            <div>
                <div class="fs-2 fw-bold">{{ number_format($stats['skills']) }}</div>
                <div class="text-muted small">Total Skills</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card d-flex flex-row align-items-center gap-3">
            <div class="icon bg-info bg-opacity-15"><i class="bi bi-book-fill fs-4 text-info"></i></div>
            <div>
                <div class="fs-2 fw-bold">{{ number_format($stats['resources']) }}</div>
                <div class="text-muted small">Resources</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Top Career Paths -->
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="fw-semibold mb-0">Top Career Paths</h6>
                    <a href="{{ route('admin.career-paths.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead><tr><th>Path</th><th>Level</th><th>Stages</th><th>Enrolled</th></tr></thead>
                        <tbody>
                            @foreach($topPaths as $path)
                                <tr>
                                    <td>
                                        <div class="fw-semibold small">{{ $path->title }}</div>
                                        <small class="text-muted">{{ $path->stages_count }} stages · {{ $path->skills_count }} skills</small>
                                    </td>
                                    <td><span class="badge bg-{{ $path->difficulty_color }}-subtle text-{{ $path->difficulty_color }}">{{ $path->difficulty_level }}</span></td>
                                    <td>{{ $path->stages_count }}</td>
                                    <td><span class="fw-semibold">{{ number_format($path->enrolled_count) }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="col-lg-5">
        <div class="card mb-4">
            <div class="card-body p-4">
                <h6 class="fw-semibold mb-3">Skill Progress Distribution</h6>
                <canvas id="progressChart" height="160"></canvas>
            </div>
        </div>
        <div class="card">
            <div class="card-body p-4">
                <h6 class="fw-semibold mb-3">Paths by Difficulty</h6>
                <canvas id="difficultyChart" height="160"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Users -->
<div class="card">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h6 class="fw-semibold mb-0">Recent Users</h6>
            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead><tr><th>User</th><th>Role</th><th>Joined</th></tr></thead>
                <tbody>
                    @foreach($recentUsers as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width:36px;height:36px;font-size:.85rem;background:#6366f1!important;">{{ strtoupper(substr($user->name,0,1)) }}</div>
                                    <div>
                                        <div class="fw-semibold small">{{ $user->name }}</div>
                                        <div class="text-muted" style="font-size:.78rem;">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge {{ $user->isAdmin() ? 'bg-danger-subtle text-danger' : 'bg-primary-subtle text-primary' }}">{{ $user->role }}</span></td>
                            <td class="text-muted small">{{ $user->created_at->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
const colors = { primary: '#6366f1', success: '#22c55e', warning: '#f59e0b', danger: '#ef4444', info: '#06b6d4' };
new Chart(document.getElementById('progressChart'), {
    type: 'doughnut',
    data: {
        labels: ['Completed', 'In Progress', 'Not Started'],
        datasets: [{ data: [{{ $skillProgressStats['completed'] }}, {{ $skillProgressStats['in_progress'] }}, {{ $skillProgressStats['not_started'] }}], backgroundColor: [colors.success, colors.warning, '#e2e8f0'] }]
    },
    options: { plugins: { legend: { position: 'bottom' } }, cutout: '65%' }
});
new Chart(document.getElementById('difficultyChart'), {
    type: 'bar',
    data: {
        labels: ['Beginner', 'Intermediate', 'Advanced'],
        datasets: [{ data: [{{ $pathDifficultyStats['Beginner'] }}, {{ $pathDifficultyStats['Intermediate'] }}, {{ $pathDifficultyStats['Advanced'] }}], backgroundColor: [colors.success, colors.warning, colors.danger], borderRadius: 6 }]
    },
    options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
});
</script>
@endpush
@endsection
