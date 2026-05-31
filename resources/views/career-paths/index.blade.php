@extends('layouts.app')
@section('title', 'Career Paths')
@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col">
            <h2 class="fw-bold">Career Paths</h2>
            <p class="text-muted">Discover structured roadmaps to achieve your career goals</p>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="card mb-4">
        <div class="card-body p-3">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" class="form-control border-start-0 ps-0" name="search" placeholder="Search career paths..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="level" class="form-select">
                        <option value="">All Levels</option>
                        <option value="Beginner" {{ request('level') == 'Beginner' ? 'selected' : '' }}>Beginner</option>
                        <option value="Intermediate" {{ request('level') == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                        <option value="Advanced" {{ request('level') == 'Advanced' ? 'selected' : '' }}>Advanced</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">Filter</button>
                    <a href="{{ route('career-paths.index') }}" class="btn btn-outline-secondary">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Career Paths Grid -->
    <div class="row g-4">
        @forelse($careerPaths as $path)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 skill-card">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start justify-content-between mb-3">
                            <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                                <i class="{{ $path->icon ?? 'bi-code-slash' }} fs-4 text-primary"></i>
                            </div>
                            <div class="d-flex flex-column gap-1 align-items-end">
                                <span class="badge bg-{{ $path->difficulty_color }}-subtle text-{{ $path->difficulty_color }} border border-{{ $path->difficulty_color }}-subtle small">{{ $path->difficulty_level }}</span>
                            </div>
                        </div>
                        <h5 class="fw-semibold mb-2">{{ $path->title }}</h5>
                        <p class="text-muted small mb-3">{{ Str::limit($path->description, 120) }}</p>
                        <div class="d-flex flex-wrap gap-3 text-muted small mb-4">
                            <span><i class="bi bi-layers me-1"></i>{{ $path->stages_count }} Stages</span>
                            <span><i class="bi bi-lightning me-1"></i>{{ $path->skills_count }} Skills</span>
                            @if($path->estimated_duration)
                                <span><i class="bi bi-clock me-1"></i>{{ $path->estimated_duration }}</span>
                            @endif
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <small class="text-muted"><i class="bi bi-people me-1"></i>{{ number_format($path->enrolled_count) }}</small>
                            <a href="{{ route('career-paths.show', $path->slug) }}" class="btn btn-primary btn-sm px-3">View Path</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-search fs-1 text-muted"></i>
                    <h5 class="mt-3 text-muted">No career paths found</h5>
                    <p class="text-muted">Try adjusting your search or filter criteria.</p>
                    <a href="{{ route('career-paths.index') }}" class="btn btn-outline-primary">Clear Filters</a>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">{{ $careerPaths->links() }}</div>
</div>
@endsection
