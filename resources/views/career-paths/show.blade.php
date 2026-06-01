@extends('layouts.app')
@section('title', $careerPath->title)
@section('content')
@push('styles')
<style>
.stage-card { border-{{ app()->getLocale()=='ar' ? 'right' : 'left' }}: 4px solid #6366f1; }
.skill-item { transition: all .15s; }
.skill-item:hover { background: #f8fafc !important; }
.completed-skill { opacity: .75; }
</style>
@endpush

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-lg-8">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('career-paths.index') }}">{{ __('app.career_paths') }}</a></li>
                    <li class="breadcrumb-item active">{{ $careerPath->title }}</li>
                </ol>
            </nav>
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="bg-primary bg-opacity-10 rounded-3 p-3"><i class="{{ $careerPath->icon ?? 'bi-code-slash' }} fs-3 text-primary"></i></div>
                <div>
                    <h2 class="fw-bold mb-1">{{ $careerPath->title }}</h2>
                    <div class="d-flex gap-2 flex-wrap">
                        <span class="badge bg-{{ $careerPath->difficulty_color }}-subtle text-{{ $careerPath->difficulty_color }} border">{{ __('app.' . strtolower($careerPath->difficulty_level)) }}</span>
                        @if($careerPath->estimated_duration)
                            <span class="badge bg-light text-muted border"><i class="bi bi-clock me-1"></i>{{ $careerPath->estimated_duration }}</span>
                        @endif
                        <span class="badge bg-light text-muted border"><i class="bi bi-people me-1"></i>{{ number_format($careerPath->enrolled_count) }} {{ __('app.enrolled') }}</span>
                    </div>
                </div>
            </div>
            <p class="text-muted">{{ $careerPath->description }}</p>
        </div>

        <div class="col-lg-4">
            @auth
                @if($progress)
                    <div class="card p-4 text-center">
                        <div class="display-5 fw-bold text-primary mb-1">{{ $progress['percentage'] }}%</div>
                        <p class="text-muted small mb-3">{{ __('app.your_progress') }}</p>
                        <div class="progress mb-3"><div class="progress-bar bg-primary" style="width:{{ $progress['percentage'] }}%"></div></div>
                        <div class="row text-center g-2">
                            <div class="col-4"><div class="fw-semibold text-success">{{ $progress['completed'] }}</div><small class="text-muted">{{ __('app.done') }}</small></div>
                            <div class="col-4"><div class="fw-semibold text-warning">{{ $progress['in_progress'] }}</div><small class="text-muted">{{ __('app.in_progress') }}</small></div>
                            <div class="col-4"><div class="fw-semibold text-muted">{{ $progress['remaining'] }}</div><small class="text-muted">{{ __('app.skills_left') }}</small></div>
                        </div>
                    </div>
                @else
                    <div class="card p-4 text-center">
                        <i class="bi bi-map fs-1 text-muted mb-3"></i>
                        <h6 class="fw-semibold mb-2">{{ __('app.track_progress') }}</h6>
                        <p class="text-muted small mb-3">{{ __('app.login_to_track') }}</p>
                        <form method="POST" action="{{ route('career-paths.enroll', $careerPath) }}">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100"><i class="bi bi-play-circle me-2"></i>{{ __('app.enroll_now') }}</button>
                        </form>
                    </div>
                @endif
            @else
                <div class="card p-4 text-center">
                    <i class="bi bi-lock fs-1 text-muted mb-3"></i>
                    <h6>{{ __('app.track_progress') }}</h6>
                    <p class="text-muted small mb-3">{{ __('app.login_to_track') }}</p>
                    <a href="{{ route('login') }}" class="btn btn-primary w-100 mb-2">{{ __('app.login') }}</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-primary w-100">{{ __('app.register') }}</a>
                </div>
            @endauth
        </div>
    </div>

    <!-- Overview Stats -->
    <div class="row g-3 mb-4">
        <div class="col-sm-4">
            <div class="card p-3 text-center bg-primary bg-opacity-5 border-0">
                <div class="fs-4 fw-bold text-primary">{{ $careerPath->stages->count() }}</div>
                <small class="text-muted">{{ __('app.learning_stages') }}</small>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card p-3 text-center bg-success bg-opacity-5 border-0">
                <div class="fs-4 fw-bold text-success">{{ $careerPath->stages->sum(fn($s)=>$s->skills->count()) }}</div>
                <small class="text-muted">{{ __('app.total_skills') }}</small>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card p-3 text-center bg-warning bg-opacity-5 border-0">
                <div class="fs-4 fw-bold text-warning">{{ $careerPath->stages->sum(fn($s)=>$s->skills->sum('estimated_hours')) }}h</div>
                <small class="text-muted">{{ __('app.estimated_hours') }}</small>
            </div>
        </div>
    </div>

    <!-- Stages -->
    @foreach($careerPath->stages as $stage)
        @php $sp = $stagesProgress[$stage->id] ?? ['percentage'=>0,'completed'=>0,'total'=>0]; @endphp
        <div class="card mb-4 stage-card">
            <div class="card-body p-4">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="badge bg-primary rounded-pill">{{ __('app.stage') }} {{ $stage->order }}</span>
                            <h5 class="fw-semibold mb-0">{{ $stage->title }}</h5>
                        </div>
                        @if($stage->description)<p class="text-muted small mb-0">{{ $stage->description }}</p>@endif
                    </div>
                    @auth
                        <div class="text-end flex-shrink-0 ms-3">
                            <div class="fw-semibold small text-primary">{{ $sp['percentage'] }}%</div>
                            <small class="text-muted">{{ $sp['completed'] }}/{{ $sp['total'] }}</small>
                        </div>
                    @endauth
                </div>
                @auth<div class="progress mb-3"><div class="progress-bar bg-primary" style="width:{{ $sp['percentage'] }}%"></div></div>@endauth

                <div class="row g-3">
                    @foreach($stage->skills as $skill)
                        @php $status = $skillStatuses[$skill->id] ?? 'not_started'; @endphp
                        <div class="col-md-6">
                            <div class="skill-item p-3 rounded-3 border
                                {{ $status=='completed' ? 'bg-success bg-opacity-5 border-success-subtle completed-skill' :
                                   ($status=='in_progress' ? 'bg-warning bg-opacity-5 border-warning-subtle' : 'bg-white') }}">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="flex-shrink-0 mt-1">
                                        @if($status=='completed') <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                        @elseif($status=='in_progress') <i class="bi bi-play-circle-fill text-warning fs-5"></i>
                                        @else <i class="bi bi-circle text-muted fs-5"></i>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold small">{{ $skill->title }}</div>
                                        @if($skill->description)
                                            <p class="text-muted mb-1" style="font-size:.78rem;">{{ Str::limit($skill->description,80) }}</p>
                                        @endif
                                        <div class="d-flex gap-2 flex-wrap">
                                            <span class="badge bg-{{ $skill->difficulty_color }}-subtle text-{{ $skill->difficulty_color }} border" style="font-size:.7rem;">{{ __('app.'.strtolower($skill->difficulty)) }}</span>
                                            @if($skill->estimated_hours)
                                                <span class="badge bg-light text-muted" style="font-size:.7rem;"><i class="bi bi-clock me-1"></i>{{ $skill->estimated_hours }}h</span>
                                            @endif
                                            @if($skill->learningResources->count())
                                                <span class="badge bg-info-subtle text-info" style="font-size:.7rem;"><i class="bi bi-book me-1"></i>{{ $skill->learningResources->count() }} {{ __('app.resources') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    @auth
                                        <div class="flex-shrink-0">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" style="font-size:.75rem;">
                                                    {{ match($status) { 'completed' => __('app.done'), 'in_progress' => __('app.in_progress_label'), default => __('app.start_label') } }}
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                    <li>
                                                        <form method="POST" action="{{ route('progress.update',[$careerPath,$skill]) }}">
                                                            @csrf <input type="hidden" name="status" value="not_started">
                                                            <button class="dropdown-item small {{ $status=='not_started'?'active':'' }}"><i class="bi bi-circle me-2"></i>{{ __('app.not_started') }}</button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form method="POST" action="{{ route('progress.update',[$careerPath,$skill]) }}">
                                                            @csrf <input type="hidden" name="status" value="in_progress">
                                                            <button class="dropdown-item small {{ $status=='in_progress'?'active':'' }}"><i class="bi bi-play-circle me-2"></i>{{ __('app.in_progress_label') }}</button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form method="POST" action="{{ route('progress.update',[$careerPath,$skill]) }}">
                                                            @csrf <input type="hidden" name="status" value="completed">
                                                            <button class="dropdown-item small text-success {{ $status=='completed'?'active':'' }}"><i class="bi bi-check-circle me-2"></i>{{ __('app.completed') }}</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    @endauth
                                </div>
                                @if($skill->learningResources->isNotEmpty())
                                    <div class="mt-2 pt-2 border-top">
                                        <small class="text-muted fw-semibold">{{ __('app.resources') }}:</small>
                                        <div class="d-flex gap-1 flex-wrap mt-1">
                                            @foreach($skill->learningResources->take(3) as $res)
                                                <a href="{{ $res->url }}" target="_blank" class="badge bg-{{ $res->type_color }}-subtle text-{{ $res->type_color }} text-decoration-none" style="font-size:.7rem;">
                                                    <i class="{{ $res->type_icon }} me-1"></i>{{ $res->title }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
