@extends('layouts.dashboard')
@section('title', 'Favorites')
@section('page-title', 'My Favorites')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-white mb-1">My Favorites</h4>
        <p class="text-muted small mb-0">{{ $prompts->total() }} saved prompts</p>
    </div>
    <a href="{{ route('prompts.index') }}" class="btn btn-gradient btn-sm">
        <i class="bi bi-compass me-1"></i>Explore More
    </a>
</div>

@if($prompts->count())
    <div class="row g-4">
        @foreach($prompts as $prompt)
        <div class="col-md-6 col-lg-4">
            <div class="card-dark h-100" style="overflow:hidden">
                <div class="p-4 d-flex flex-column h-100">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="platform-badge platform-{{ strtolower($prompt->platform) }}">{{ $prompt->platform }}</span>
                        <form method="POST" action="{{ route('favorites.toggle', $prompt) }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 border-0" style="color:#ef4444;font-size:1.1rem;" title="Remove from favorites">
                                <i class="bi bi-heart-fill"></i>
                            </button>
                        </form>
                    </div>
                    <h5 class="fw-semibold text-white mb-2">{{ $prompt->title }}</h5>
                    <p class="text-muted small mb-3 flex-grow-1"
                        style="display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;">
                        {{ $prompt->prompt_content }}
                    </p>
                    <div class="mb-3">
                        @foreach($prompt->tags->take(3) as $tag)
                            <span style="background:rgba(124,58,237,0.15);color:#a78bfa;border:1px solid rgba(124,58,237,0.3);font-size:0.75rem;padding:3px 10px;border-radius:20px;margin:2px;display:inline-block;">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-auto pt-2" style="border-top:1px solid #334155">
                        <span class="text-muted small"><i class="bi bi-eye me-1"></i>{{ $prompt->views }}</span>
                        <a href="{{ route('prompts.show', $prompt) }}" class="btn btn-gradient btn-sm">View Prompt</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center mt-5">
        {{ $prompts->links('pagination::bootstrap-5') }}
    </div>
@else
    <div class="card-dark p-5 text-center">
        <i class="bi bi-heart fs-1 mb-3 d-block" style="color:#334155"></i>
        <h5 class="text-muted mb-2">No favorites yet</h5>
        <p class="text-muted small mb-4">Save prompts you love to access them quickly.</p>
        <a href="{{ route('prompts.index') }}" class="btn btn-gradient">
            <i class="bi bi-compass me-2"></i>Explore Prompts
        </a>
    </div>
@endif
@endsection
