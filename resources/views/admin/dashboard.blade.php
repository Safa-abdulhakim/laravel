@extends('layouts.dashboard')
@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')
@section('content')

{{-- Stats Row --}}
<div class="row g-3 mb-4">
    @php
    $statCards = [
        ['label'=>'Total Users',    'value'=>$stats['total_users'],    'icon'=>'people-fill',     'color'=>'#7c3aed','bg'=>'rgba(124,58,237,0.15)'],
        ['label'=>'Total Prompts',  'value'=>$stats['total_prompts'],  'icon'=>'collection-fill', 'color'=>'#06b6d4','bg'=>'rgba(6,182,212,0.15)'],
        ['label'=>'Public Prompts', 'value'=>$stats['public_prompts'], 'icon'=>'globe',           'color'=>'#10b981','bg'=>'rgba(16,185,129,0.15)'],
        ['label'=>'Categories',     'value'=>$stats['total_categories'],'icon'=>'folder-fill',   'color'=>'#f59e0b','bg'=>'rgba(245,158,11,0.15)'],
        ['label'=>'Tags',           'value'=>$stats['total_tags'],     'icon'=>'tags-fill',       'color'=>'#ec4899','bg'=>'rgba(236,72,153,0.15)'],
        ['label'=>'Total Views',    'value'=>$stats['total_views'],    'icon'=>'eye-fill',        'color'=>'#a78bfa','bg'=>'rgba(167,139,250,0.15)'],
    ];
    @endphp
    @foreach($statCards as $stat)
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-widget">
            <div class="stat-icon mb-3" style="background:{{ $stat['bg'] }}">
                <i class="bi bi-{{ $stat['icon'] }}" style="color:{{ $stat['color'] }}"></i>
            </div>
            <div class="stat-value" style="color:{{ $stat['color'] }}">{{ $stat['value'] }}</div>
            <div class="stat-label">{{ $stat['label'] }}</div>
        </div>
    </div>
    @endforeach
</div>

{{-- Quick Links --}}
<div class="row g-3 mb-4">
    @foreach([
        ['route'=>'admin.prompts.index',    'label'=>'Manage Prompts',    'icon'=>'collection',   'color'=>'#06b6d4'],
        ['route'=>'admin.categories.index', 'label'=>'Manage Categories', 'icon'=>'folder2',      'color'=>'#f59e0b'],
        ['route'=>'admin.tags.index',       'label'=>'Manage Tags',       'icon'=>'tags',         'color'=>'#ec4899'],
        ['route'=>'admin.users.index',      'label'=>'Manage Users',      'icon'=>'people',       'color'=>'#10b981'],
    ] as $link)
    <div class="col-6 col-md-3">
        <a href="{{ route($link['route']) }}" class="text-decoration-none">
            <div class="card-dark p-3 text-center" style="transition:all 0.3s">
                <i class="bi bi-{{ $link['icon'] }} fs-3 mb-2" style="color:{{ $link['color'] }}"></i>
                <p class="text-white small fw-semibold mb-0">{{ $link['label'] }}</p>
            </div>
        </a>
    </div>
    @endforeach
</div>

<div class="row g-4">
    {{-- Recent Prompts Table --}}
    <div class="col-lg-8">
        <div class="card-dark p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold text-white mb-0">Recent Prompts</h5>
                <a href="{{ route('admin.prompts.index') }}" class="btn btn-sm btn-gradient">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-dark-custom mb-0">
                    <thead>
                        <tr>
                            <th>Title</th><th>User</th><th>Platform</th><th>Status</th><th>Views</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentPrompts as $prompt)
                        <tr>
                            <td>
                                <a href="{{ route('prompts.show', $prompt) }}" class="text-decoration-none text-white fw-semibold">
                                    {{ Str::limit($prompt->title, 35) }}
                                </a>
                            </td>
                            <td class="text-muted small">{{ $prompt->user->name }}</td>
                            <td><span class="platform-badge platform-{{ strtolower($prompt->platform) }}">{{ $prompt->platform }}</span></td>
                            <td>
                                <span class="badge {{ $prompt->status === 'public' ? 'badge-public' : 'badge-private' }}">
                                    {{ ucfirst($prompt->status) }}
                                </span>
                            </td>
                            <td class="text-muted small">{{ $prompt->views }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Right Column --}}
    <div class="col-lg-4">
        {{-- Platform Chart --}}
        <div class="card-dark p-4 mb-4">
            <h5 class="fw-bold text-white mb-4">Platform Distribution</h5>
            @if($platformData->count())
                <canvas id="platformChart" height="220"></canvas>
            @else
                <p class="text-muted text-center py-4">No data yet</p>
            @endif
        </div>

        {{-- Recent Users --}}
        <div class="card-dark p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-semibold text-white mb-0">Recent Users</h6>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm" style="font-size:0.75rem;color:#a78bfa;background:rgba(124,58,237,0.1);border:none;border-radius:8px;padding:4px 10px;">View All</a>
            </div>
            @foreach($recentUsers as $user)
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                    style="width:36px;height:36px;background:linear-gradient(135deg,#7c3aed,#4f46e5)">
                    <span class="text-white fw-bold" style="font-size:0.8rem">{{ strtoupper(substr($user->name,0,1)) }}</span>
                </div>
                <div class="flex-grow-1 min-width-0">
                    <p class="text-white small fw-semibold mb-0 text-truncate">{{ $user->name }}</p>
                    <p class="text-muted mb-0" style="font-size:0.7rem">{{ $user->email }}</p>
                </div>
                @if($user->role === 'admin')
                    <span class="badge flex-shrink-0" style="background:rgba(245,158,11,0.15);color:#f59e0b;border:1px solid rgba(245,158,11,0.3);font-size:0.65rem">Admin</span>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script>
@if($platformData->count())
const ctx = document.getElementById('platformChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($platformData->keys()) !!},
        datasets: [{
            label: 'Prompts',
            data: {!! json_encode($platformData->values()) !!},
            backgroundColor: [
                'rgba(16,163,127,0.7)','rgba(212,137,76,0.7)',
                'rgba(66,133,244,0.7)','rgba(124,58,237,0.7)','rgba(148,163,184,0.7)'
            ],
            borderRadius: 8,
            borderSkipped: false
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            x: { ticks: { color:'#94a3b8', font:{size:10} }, grid: { color:'rgba(51,65,85,0.5)' } },
            y: { ticks: { color:'#94a3b8', font:{size:10} }, grid: { color:'rgba(51,65,85,0.5)' } }
        }
    }
});
@endif
</script>
@endpush
@endsection
