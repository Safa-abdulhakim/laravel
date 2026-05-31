@extends('layouts.admin')
@section('title', $user->name)
@section('page-title', $user->name)
@section('content')
<div class="mb-4">
    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Back to Users</a>
</div>
<div class="row g-4">
    <div class="col-md-4">
        <div class="card p-4 text-center">
            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width:80px;height:80px;font-size:2rem;background:#6366f1!important;">{{ strtoupper(substr($user->name,0,1)) }}</div>
            <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
            <p class="text-muted small mb-3">{{ $user->email }}</p>
            <span class="badge {{ $user->isAdmin() ? 'bg-danger-subtle text-danger' : 'bg-primary-subtle text-primary' }} mb-3">{{ $user->role }}</span>
            <hr>
            <div class="d-flex justify-content-between small mb-2"><span class="text-muted">Joined</span><span>{{ $user->created_at->format('M d, Y') }}</span></div>
            <div class="d-flex justify-content-between small mb-2"><span class="text-muted">Enrolled Paths</span><span>{{ $enrolledPaths->count() }}</span></div>
            <div class="d-flex justify-content-between small"><span class="text-muted">Achievements</span><span>{{ $user->userAchievements->count() }}</span></div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card mb-4 p-4">
            <h6 class="fw-semibold mb-3">Enrolled Career Paths</h6>
            @forelse($enrolledPaths as $path)
                <div class="d-flex align-items-center gap-2 mb-2 p-2 bg-light rounded">
                    <i class="{{ $path->icon ?? 'bi-code-slash' }} text-primary"></i>
                    <span class="small fw-semibold">{{ $path->title }}</span>
                    <span class="badge bg-{{ $path->difficulty_color }}-subtle text-{{ $path->difficulty_color }} ms-auto">{{ $path->difficulty_level }}</span>
                </div>
            @empty
                <p class="text-muted small">Not enrolled in any paths.</p>
            @endforelse
        </div>
        <div class="card p-4">
            <h6 class="fw-semibold mb-3">Achievements</h6>
            <div class="row g-2">
                @forelse($user->userAchievements as $ua)
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-2 p-2 border rounded">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:38px;height:38px;background:{{ $ua->achievement->badge_color }}22;">
                                <i class="{{ $ua->achievement->badge_icon ?? 'bi-trophy' }}" style="color:{{ $ua->achievement->badge_color }};"></i>
                            </div>
                            <div>
                                <div class="small fw-semibold">{{ $ua->achievement->title }}</div>
                                <div class="text-muted" style="font-size:.72rem;">{{ $ua->careerPath->title }} · {{ $ua->earned_at->format('M d') }}</div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12"><p class="text-muted small">No achievements yet.</p></div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
