@extends('layouts.portfolio')
@section('title', __('portfolio.projects_page_title'))

@section('content')
<div style="padding-top:76px;background:linear-gradient(135deg,#0f172a,#1e1b4b);">
    <div class="container py-5 text-center">
        <span class="section-badge" style="background:rgba(99,102,241,.15);color:#818cf8;">{{ __('portfolio.my_work') }}</span>
        <h1 class="section-title mt-2" style="color:#fff;">{{ __('portfolio.projects_page_title') }}</h1>
        <p class="text-white-50">{{ __('portfolio.projects_page_sub') }}</p>
    </div>
</div>

<section>
    <div class="container">
        <div class="row g-4">
            @forelse($projects as $project)
            <div class="col-md-6 col-xl-4 fade-up">
                <div class="card project-card shadow-sm">
                    <div class="card-img-wrapper">
                        @if($project->image)
                            <img src="{{ asset('storage/'.$project->image) }}" alt="{{ $project->title }}">
                        @else
                            <i class="bi bi-code-square" style="font-size:4rem;color:#6366f1;opacity:.3;"></i>
                        @endif
                        @if($project->status === 'featured')
                            <span class="badge bg-warning text-dark status-featured">
                                <i class="bi bi-star-fill me-1"></i>Featured
                            </span>
                        @endif
                    </div>
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-2">{{ $project->title }}</h5>
                        <p class="text-muted small mb-3" style="line-height:1.6;">{{ Str::limit($project->description, 120) }}</p>
                        @if($project->technologies)
                        <div class="d-flex flex-wrap gap-1 mb-3">
                            @foreach($project->technologies as $tech)
                                <span class="tech-badge">{{ $tech }}</span>
                            @endforeach
                        </div>
                        @endif
                        <div class="d-flex gap-2">
                            @if($project->github_link)
                                <a href="{{ $project->github_link }}" target="_blank"
                                   class="btn btn-sm btn-outline-dark rounded-pill">
                                    <i class="bi bi-github me-1"></i>{{ __('portfolio.projects_code') }}
                                </a>
                            @endif
                            @if($project->live_demo)
                                <a href="{{ $project->live_demo }}" target="_blank"
                                   class="btn btn-sm btn-primary rounded-pill">
                                    <i class="bi bi-box-arrow-up-right me-1"></i>{{ __('portfolio.projects_demo') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted">
                <i class="bi bi-folder-x fs-1 d-block mb-3"></i>
                {{ __('portfolio.projects_none') }}
            </div>
            @endforelse
        </div>
        @if($projects->hasPages())
        <div class="mt-5 d-flex justify-content-center">
            {{ $projects->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</section>
@endsection
