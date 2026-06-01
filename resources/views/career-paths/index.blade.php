@extends('layouts.app')
@section('title', __('app.career_paths'))
@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col">
            <h2 class="fw-bold">{{ __('app.career_paths') }}</h2>
            <p class="text-muted">{{ __('app.popular_paths_desc') }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body p-3">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" class="form-control border-start-0 ps-0" name="search"
                            placeholder="{{ __('app.search_placeholder') }}" value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="level" class="form-select">
                        <option value="">{{ __('app.all_levels') }}</option>
                        <option value="Beginner" {{ request('level')=='Beginner' ? 'selected' : '' }}>{{ __('app.beginner') }}</option>
                        <option value="Intermediate" {{ request('level')=='Intermediate' ? 'selected' : '' }}>{{ __('app.intermediate') }}</option>
                        <option value="Advanced" {{ request('level')=='Advanced' ? 'selected' : '' }}>{{ __('app.advanced') }}</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">{{ __('app.filter') }}</button>
                    <a href="{{ route('career-paths.index') }}" class="btn btn-outline-secondary">{{ __('app.clear') }}</a>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4">
        @forelse($careerPaths as $path)
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
                        <p class="text-muted small mb-3">{{ Str::limit($path->description, 120) }}</p>
                        <div class="d-flex flex-wrap gap-3 text-muted small mb-4">
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
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-search fs-1 text-muted"></i>
                    <h5 class="mt-3 text-muted">{{ __('app.no_results') }}</h5>
                    <p class="text-muted">{{ __('app.no_results_desc') }}</p>
                    <a href="{{ route('career-paths.index') }}" class="btn btn-outline-primary">{{ __('app.clear_filters') }}</a>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">{{ $careerPaths->links() }}</div>
</div>
@endsection
