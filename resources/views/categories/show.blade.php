@extends('layouts.main')
@section('title', $category->name)
@section('content')

<div class="py-5">
    <div class="container">
        <div class="mb-5">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="background:transparent">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-muted text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}" class="text-muted text-decoration-none">Categories</a></li>
                    <li class="breadcrumb-item active text-light">{{ $category->name }}</li>
                </ol>
            </nav>
            <h1 class="fw-bold text-white mb-2">{{ $category->name }}</h1>
            @if($category->description)
                <p class="text-muted">{{ $category->description }}</p>
            @endif
            <p class="text-muted small">{{ $prompts->total() }} prompts in this category</p>
        </div>

        @if($prompts->count() > 0)
            <div class="row g-4">
                @foreach($prompts as $prompt)
                <div class="col-md-6 col-lg-4">
                    <div class="prompt-card h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="platform-badge platform-{{ strtolower($prompt->platform) }}">{{ $prompt->platform }}</span>
                                <span class="text-muted small"><i class="bi bi-eye me-1"></i>{{ $prompt->views }}</span>
                            </div>
                            <h5 class="fw-semibold text-white mb-2">{{ $prompt->title }}</h5>
                            <p class="text-muted small mb-3 flex-grow-1" style="display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;">{{ $prompt->prompt_content }}</p>
                            <div class="mb-3">
                                @foreach($prompt->tags->take(3) as $tag)
                                    <span class="tag-pill">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                            <a href="{{ route('prompts.show', $prompt) }}" class="btn btn-gradient btn-sm">View Prompt</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-center mt-5">
                {{ $prompts->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-folder-x fs-1 mb-3" style="color:#334155"></i>
                <h4 class="text-muted">No prompts in this category yet</h4>
            </div>
        @endif
    </div>
</div>
@endsection
