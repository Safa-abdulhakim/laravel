@extends('layouts.app')
@section('title', __('app.my_dashboard'))
@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col">
            <h3 class="fw-bold">{{ __('app.welcome_back') }}، {{ auth()->user()->name }}! 👋</h3>
            <p class="text-muted">{{ __('app.progress_overview') }}</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('career-paths.index') }}" class="btn btn-primary"><i class="bi bi-plus me-2"></i>{{ __('app.explore_paths') }}</a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card p-4 text-center">
                <div class="display-6 fw-bold text-primary">{{ $pathsWithProgress->count() }}</div>
                <div class="text-muted small mt-1">{{ __('app.active_paths') }}</div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card p-4 text-center">
                <div class="display-6 fw-bold text-success">{{ $totalCompleted }}</div>
                <div class="text-muted small mt-1">{{ __('app.completed_skills') }}</div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card p-4 text-center">
                <div class="display-6 fw-bold text-warning">{{ $totalInProgress }}</div>
                <div class="text-muted small mt-1">{{ __('app.in_progress') }}</div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card p-4 text-center">
                <div class="display-6 fw-bold" style="color:#6366f1;">{{ $overallProgress }}%</div>
                <div class="text-muted small mt-1">{{ __('app.overall_progress') }}</div>
                <div class="progress mt-2"><div class="progress-bar" style="width:{{ $overallProgress }}%;background:#6366f1;"></div></div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="fw-semibold mb-4">{{ __('app.my_career_paths') }}</h5>
                    @forelse($pathsWithProgress as $path)
                        <div class="d-flex align-items-center gap-3 mb-4 p-3 bg-light rounded-3">
                            <div class="bg-primary bg-opacity-10 rounded-3 p-3 flex-shrink-0">
                                <i class="{{ $path->icon ?? 'bi-code-slash' }} fs-5 text-primary"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <a href="{{ route('career-paths.show', $path->slug) }}" class="text-decoration-none fw-semibold text-dark">{{ $path->title }}</a>
                                    <span class="badge bg-primary-subtle text-primary">{{ $path->progress['percentage'] }}%</span>
                                </div>
                                <div class="progress mb-1"><div class="progress-bar bg-primary" style="width:{{ $path->progress['percentage'] }}%"></div></div>
                                <small class="text-muted">
                                    {{ $path->progress['completed'] }} / {{ $path->progress['total'] }} {{ __('app.skills') }}
                                    — {{ $path->progress['remaining'] }} {{ __('app.skills_left') }}
                                </small>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="bi bi-map fs-1 text-muted"></i>
                            <p class="text-muted mt-3 mb-3">{{ __('app.no_paths_yet') }}</p>
                            <a href="{{ route('career-paths.index') }}" class="btn btn-primary">{{ __('app.explore_paths') }}</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-semibold mb-4">{{ __('app.achievements') }}</h5>
                    @forelse($recentAchievements as $ua)
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:42px;height:42px;background:{{ $ua->achievement->badge_color }}22;">
                                <i class="{{ $ua->achievement->badge_icon ?? 'bi-trophy' }}" style="color:{{ $ua->achievement->badge_color }};font-size:1.2rem;"></i>
                            </div>
                            <div>
                                <div class="fw-semibold small">{{ $ua->achievement->title }}</div>
                                <div class="text-muted" style="font-size:.78rem;">{{ $ua->careerPath->title }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-3">
                            <i class="bi bi-trophy fs-2 text-muted"></i>
                            <p class="text-muted small mt-2 mb-0">{{ __('app.no_achievements') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="card">
                <div class="card-body p-4">
                    <h5 class="fw-semibold mb-4">{{ __('app.recently_completed') }}</h5>
                    @forelse($completedSkills as $progress)
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <i class="bi bi-check-circle-fill text-success flex-shrink-0"></i>
                            <div>
                                <div class="small fw-semibold">{{ $progress->skill->title }}</div>
                                <div class="text-muted" style="font-size:.75rem;">{{ $progress->completed_at?->diffForHumans() }}</div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted small">{{ __('app.no_completed_skills') }}</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
