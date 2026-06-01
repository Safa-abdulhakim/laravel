@extends('layouts.app')
@section('title', __('app.site_name'))
@section('content')

<!-- Hero -->
<section class="py-5" style="background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);min-height:85vh;display:flex;align-items:center;">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 text-white">
                <span class="badge bg-white bg-opacity-25 text-white mb-3 px-3 py-2" style="font-size:.85rem;">{{ __('app.hero_badge') }}</span>
                <h1 class="display-4 fw-bold mb-4 lh-sm">
                    {{ __('app.hero_title') }}<br>
                    <span style="color:#fbbf24;">{{ __('app.hero_title_highlight') }}</span>
                </h1>
                <p class="lead mb-4 opacity-90">{{ __('app.hero_desc') }}</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('career-paths.index') }}" class="btn btn-warning btn-lg fw-semibold px-4">
                        {{ __('app.explore_paths') }} <i class="bi bi-arrow-{{ app()->getLocale()=='ar' ? 'left' : 'right' }} ms-2"></i>
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4">{{ __('app.get_started_free') }}</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-lg px-4">{{ __('app.my_dashboard') }}</a>
                    @endguest
                </div>
                <div class="row g-4 mt-4">
                    <div class="col-3 text-center">
                        <div class="display-6 fw-bold">{{ $stats['total_paths'] }}+</div>
                        <small class="opacity-75">{{ __('app.career_paths_stat') }}</small>
                    </div>
                    <div class="col-3 text-center">
                        <div class="display-6 fw-bold">{{ $stats['total_skills'] }}+</div>
                        <small class="opacity-75">{{ __('app.skills_stat') }}</small>
                    </div>
                    <div class="col-3 text-center">
                        <div class="display-6 fw-bold">{{ $stats['total_users'] }}+</div>
                        <small class="opacity-75">{{ __('app.learners_stat') }}</small>
                    </div>
                    <div class="col-3 text-center">
                        <div class="display-6 fw-bold">{{ $stats['total_resources'] }}+</div>
                        <small class="opacity-75">{{ __('app.resources_stat') }}</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block text-center">
                <div class="bg-white bg-opacity-10 rounded-4 p-4" style="backdrop-filter:blur(10px);">
                    <div class="d-flex align-items-center gap-3 mb-4 p-3 bg-white bg-opacity-15 rounded-3">
                        <div class="bg-warning rounded-3 p-3"><i class="bi bi-code-slash text-dark fs-4"></i></div>
                        <div class="{{ app()->getLocale()=='ar' ? 'text-end' : 'text-start' }}">
                            <div class="text-white fw-semibold">{{ app()->getLocale()=='ar' ? 'مطوّر Laravel' : 'Laravel Developer' }}</div>
                            <div class="progress mt-2" style="width:200px;height:6px;"><div class="progress-bar bg-warning" style="width:65%"></div></div>
                            <small class="text-white opacity-75">65% {{ app()->getLocale()=='ar' ? 'مكتمل' : 'Complete' }}</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3 mb-4 p-3 bg-white bg-opacity-15 rounded-3">
                        <div class="bg-info rounded-3 p-3"><i class="bi bi-layout-text-window text-dark fs-4"></i></div>
                        <div class="{{ app()->getLocale()=='ar' ? 'text-end' : 'text-start' }}">
                            <div class="text-white fw-semibold">{{ app()->getLocale()=='ar' ? 'مطوّر الواجهات' : 'Frontend Developer' }}</div>
                            <div class="progress mt-2" style="width:200px;height:6px;"><div class="progress-bar bg-info" style="width:40%"></div></div>
                            <small class="text-white opacity-75">40% {{ app()->getLocale()=='ar' ? 'مكتمل' : 'Complete' }}</small>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center flex-wrap mt-3">
                        <span class="badge bg-warning text-dark px-3 py-2"><i class="bi bi-trophy me-1"></i>{{ app()->getLocale()=='ar' ? 'بداية رائعة' : 'Getting Started' }}</span>
                        <span class="badge bg-success px-3 py-2"><i class="bi bi-star me-1"></i>{{ app()->getLocale()=='ar' ? 'الخطوة الأولى' : 'First Step' }}</span>
                        <span class="badge bg-info px-3 py-2"><i class="bi bi-award me-1"></i>{{ app()->getLocale()=='ar' ? 'في المنتصف' : 'Halfway' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Paths -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">{{ __('app.popular_paths') }}</h2>
            <p class="text-muted">{{ __('app.popular_paths_desc') }}</p>
        </div>
        <div class="row g-4">
            @forelse($featuredPaths as $path)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 skill-card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start justify-content-between mb-3">
                                <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                                    <i class="{{ $path->icon ?? 'bi-code-slash' }} fs-4 text-primary"></i>
                                </div>
                                <span class="badge bg-{{ $path->difficulty_color }}-subtle text-{{ $path->difficulty_color }} border border-{{ $path->difficulty_color }}-subtle">
                                    {{ __('app.' . strtolower($path->difficulty_level)) }}
                                </span>
                            </div>
                            <h5 class="fw-semibold mb-2">{{ $path->title }}</h5>
                            <p class="text-muted small mb-3">{{ Str::limit($path->description, 100) }}</p>
                            <div class="d-flex gap-3 text-muted small mb-4">
                                <span><i class="bi bi-layers me-1"></i>{{ $path->stages_count }} {{ __('app.stages') }}</span>
                                <span><i class="bi bi-lightning me-1"></i>{{ $path->skills_count }} {{ __('app.skills') }}</span>
                                @if($path->estimated_duration)
                                    <span><i class="bi bi-clock me-1"></i>{{ $path->estimated_duration }}</span>
                                @endif
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <small class="text-muted"><i class="bi bi-people me-1"></i>{{ number_format($path->enrolled_count) }} {{ __('app.enrolled') }}</small>
                                <a href="{{ route('career-paths.show', $path->slug) }}" class="btn btn-primary btn-sm px-3">{{ __('app.view_path') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-map fs-1 text-muted"></i>
                    <p class="text-muted mt-3">{{ __('app.no_paths') }}</p>
                </div>
            @endforelse
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('career-paths.index') }}" class="btn btn-outline-primary btn-lg px-5">{{ __('app.view_all_paths') }}</a>
        </div>
    </div>
</section>

<!-- How it works -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">{{ __('app.how_it_works') }}</h2>
            <p class="text-muted">{{ __('app.how_it_works_desc') }}</p>
        </div>
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-4" style="width:80px;height:80px;">
                    <i class="bi bi-search fs-2 text-primary"></i>
                </div>
                <h5 class="fw-semibold">{{ __('app.step1_title') }}</h5>
                <p class="text-muted">{{ __('app.step1_desc') }}</p>
            </div>
            <div class="col-md-4">
                <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-4" style="width:80px;height:80px;">
                    <i class="bi bi-check2-circle fs-2 text-success"></i>
                </div>
                <h5 class="fw-semibold">{{ __('app.step2_title') }}</h5>
                <p class="text-muted">{{ __('app.step2_desc') }}</p>
            </div>
            <div class="col-md-4">
                <div class="rounded-circle bg-warning bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-4" style="width:80px;height:80px;">
                    <i class="bi bi-trophy fs-2 text-warning"></i>
                </div>
                <h5 class="fw-semibold">{{ __('app.step3_title') }}</h5>
                <p class="text-muted">{{ __('app.step3_desc') }}</p>
            </div>
        </div>
    </div>
</section>

@guest
<section class="py-5" style="background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);">
    <div class="container text-center text-white py-4">
        <h2 class="fw-bold mb-3">{{ __('app.cta_title') }}</h2>
        <p class="lead mb-4 opacity-90">{{ __('app.cta_desc') }}</p>
        <a href="{{ route('register') }}" class="btn btn-warning btn-lg px-5 fw-semibold">
            {{ __('app.start_now') }} <i class="bi bi-arrow-{{ app()->getLocale()=='ar' ? 'left' : 'right' }} ms-2"></i>
        </a>
    </div>
</section>
@endguest

@endsection
