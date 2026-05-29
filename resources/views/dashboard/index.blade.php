@extends('layouts.dashboard')
@section('title', 'My Dashboard')
@section('page-title', 'My Dashboard')
@section('content')

<div class="row g-4 mb-4">
    <div class="col-6 col-md-4 col-lg-2-4">
        <div class="stat-widget">
            <div class="stat-icon mb-3" style="background:rgba(124,58,237,0.15)"><i class="bi bi-collection" style="color:#7c3aed"></i></div>
            <div class="stat-value text-white">{{ $stats['total_prompts'] }}</div>
            <div class="stat-label">Total Prompts</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2-4">
        <div class="stat-widget">
            <div class="stat-icon mb-3" style="background:rgba(16,185,129,0.15)"><i class="bi bi-globe" style="color:#10b981"></i></div>
            <div class="stat-value" style="color:#10b981">{{ $stats['public_prompts'] }}</div>
            <div class="stat-label">Public</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2-4">
        <div class="stat-widget">
            <div class="stat-icon mb-3" style="background:rgba(239,68,68,0.15)"><i class="bi bi-lock" style="color:#ef4444"></i></div>
            <div class="stat-value" style="color:#ef4444">{{ $stats['private_prompts'] }}</div>
            <div class="stat-label">Private</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2-4">
        <div class="stat-widget">
            <div class="stat-icon mb-3" style="background:rgba(239,68,68,0.15)"><i class="bi bi-heart-fill" style="color:#ef4444"></i></div>
            <div class="stat-value" style="color:#ef4444">{{ $stats['favorites'] }}</div>
            <div class="stat-label">Favorites</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2-4">
        <div class="stat-widget">
            <div class="stat-icon mb-3" style="background:rgba(6,182,212,0.15)"><i class="bi bi-eye" style="color:#06b6d4"></i></div>
            <div class="stat-value" style="color:#06b6d4">{{ $stats['total_views'] }}</div>
            <div class="stat-label">Total Views</div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Recent Prompts --}}
    <div class="col-lg-8">
        <div class="card-dark p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold text-white mb-0">Recent Prompts</h5>
                <a href="{{ route('my-prompts.index') }}" class="btn btn-sm btn-gradient">View All</a>
            </div>
            @if($recentPrompts->count())
                <div class="table-responsive">
                    <table class="table table-dark-custom">
                        <thead><tr><th>Title</th><th>Platform</th><th>Status</th><th>Views</th><th>Actions</th></tr></thead>
                        <tbody>
                            @foreach($recentPrompts as $prompt)
                            <tr>
                                <td>
                                    <a href="{{ route('prompts.show', $prompt) }}" class="text-decoration-none text-white fw-semibold">{{ Str::limit($prompt->title, 35) }}</a>
                                </td>
                                <td><span class="platform-badge platform-{{ strtolower($prompt->platform) }}">{{ $prompt->platform }}</span></td>
                                <td><span class="badge {{ $prompt->status === 'public' ? 'badge-public' : 'badge-private' }}">{{ ucfirst($prompt->status) }}</span></td>
                                <td class="text-muted small">{{ $prompt->views }}</td>
                                <td>
                                    <a href="{{ route('my-prompts.edit', $prompt) }}" class="btn btn-sm" style="background:rgba(124,58,237,0.15);color:#a78bfa;border:none;border-radius:8px;"><i class="bi bi-pencil"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="bi bi-collection fs-1 mb-3" style="color:#334155"></i>
                    <p class="text-muted">No prompts yet.</p>
                    <a href="{{ route('my-prompts.create') }}" class="btn btn-gradient btn-sm">Create Your First Prompt</a>
                </div>
            @endif
        </div>
    </div>

    {{-- Platform Chart --}}
    <div class="col-lg-4">
        <div class="card-dark p-4">
            <h5 class="fw-bold text-white mb-4">Prompts by Platform</h5>
            @if($platformData->count() > 0)
                <canvas id="platformChart" height="200"></canvas>
            @else
                <div class="text-center py-4">
                    <i class="bi bi-pie-chart fs-2 mb-2" style="color:#334155"></i>
                    <p class="text-muted small">No data yet</p>
                </div>
            @endif
        </div>

        <div class="card-dark p-4 mt-4">
            <h6 class="fw-semibold text-white mb-3">Quick Actions</h6>
            <div class="d-grid gap-2">
                <a href="{{ route('my-prompts.create') }}" class="btn btn-gradient"><i class="bi bi-plus-circle me-2"></i>New Prompt</a>
                <a href="{{ route('favorites.index') }}" class="btn" style="background:rgba(239,68,68,0.1);color:#f87171;border:1px solid rgba(239,68,68,0.3);border-radius:10px;"><i class="bi bi-heart-fill me-2"></i>View Favorites</a>
                <a href="{{ route('prompts.index') }}" class="btn" style="background:rgba(124,58,237,0.1);color:#a78bfa;border:1px solid rgba(124,58,237,0.3);border-radius:10px;"><i class="bi bi-compass me-2"></i>Explore Prompts</a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
@if($platformData->count() > 0)
const ctx = document.getElementById('platformChart').getContext('2d');
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($platformData->keys()) !!},
        datasets: [{
            data: {!! json_encode($platformData->values()) !!},
            backgroundColor: ['rgba(16,163,127,0.7)','rgba(212,137,76,0.7)','rgba(66,133,244,0.7)','rgba(124,58,237,0.7)','rgba(148,163,184,0.7)'],
            borderColor: '#1e293b', borderWidth: 3
        }]
    },
    options: { responsive: true, plugins: { legend: { labels: { color: '#94a3b8', font: { size: 11 } } } } }
});
@endif
</script>
@endpush
@endsection
