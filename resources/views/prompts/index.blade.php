@extends('layouts.main')
@section('title', __('browse_prompts'))
@section('content')

<div class="py-5">
    <div class="container">
        {{-- Header --}}
        <div class="mb-5">
            <h1 class="fw-bold text-white mb-2">{{ __('browse_prompts') }}</h1>
            <p class="text-muted">{{ __('discover_prompts', ['count' => $prompts->total()]) }}</p>
        </div>

        {{-- Search & Filters --}}
        <div class="card-dark p-4 mb-5">
            <form method="GET" action="{{ route('prompts.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label class="form-label text-muted small">{{ __('search') }}</label>
                        <div class="input-group">
                            <span class="input-group-text" style="background:#2d3f55;border-color:#334155;color:#94a3b8"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control search-bar" style="border-left:0" placeholder="{{ __('search_placeholder') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label text-muted small">{{ __('category_label') }}</label>
                        <select name="category" class="form-select form-select-dark">
                            <option value="">{{ __('all_categories') }}</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label text-muted small">{{ __('platform_label') }}</label>
                        <select name="platform" class="form-select form-select-dark">
                            <option value="">{{ __('all_platforms') }}</option>
                            @foreach($platforms as $p)
                                <option value="{{ $p }}" {{ request('platform') == $p ? 'selected' : '' }}>{{ $p }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label text-muted small">{{ __('tags_label') }}</label>
                        <select name="tag" class="form-select form-select-dark">
                            <option value="">{{ __('all_tags') }}</option>
                            @foreach($tags as $tag)
                                <option value="{{ $tag->slug }}" {{ request('tag') == $tag->slug ? 'selected' : '' }}>{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-gradient w-100"><i class="bi bi-funnel"></i></button>
                    </div>
                </div>
                @if(request()->hasAny(['search','category','platform','tag']))
                    <div class="mt-3">
                        <a href="{{ route('prompts.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-x me-1"></i>{{ __('clear_filters') }}</a>
                    </div>
                @endif
            </form>
        </div>

        {{-- Results --}}
        @if($prompts->count() > 0)
            <div class="row g-4">
                @foreach($prompts as $prompt)
                <div class="col-md-6 col-lg-4">
                    <div class="prompt-card h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="platform-badge platform-{{ strtolower($prompt->platform) }}">{{ $prompt->platform }}</span>
                                <div class="d-flex align-items-center gap-2">
                                    @auth
                                        <form method="POST" action="{{ route('favorites.toggle', $prompt) }}">
                                            @csrf
                                            @php $fav = auth()->user()->favorites()->where('prompt_id',$prompt->id)->exists(); @endphp
                                            <button type="submit" class="btn btn-link p-0 border-0" style="color:{{ $fav ? '#ef4444' : '#475569' }};font-size:1.1rem;">
                                                <i class="bi bi-heart{{ $fav ? '-fill' : '' }}"></i>
                                            </button>
                                        </form>
                                    @endauth
                                    <span class="text-muted small"><i class="bi bi-eye me-1"></i>{{ $prompt->views }}</span>
                                </div>
                            </div>
                            <h5 class="fw-semibold text-white mb-2">{{ $prompt->title }}</h5>
                            <p class="text-muted small mb-3 flex-grow-1" style="display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;">{{ $prompt->prompt_content }}</p>
                            <div class="mb-3">
                                @foreach($prompt->tags->take(3) as $tag)
                                    <a href="{{ route('prompts.index', ['tag' => $tag->slug]) }}" class="tag-pill">{{ $tag->name }}</a>
                                @endforeach
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                @if($prompt->category)
                                    <a href="{{ route('categories.show', $prompt->category->slug) }}" class="text-decoration-none small" style="color:#7c3aed">
                                        <i class="bi bi-folder me-1"></i>{{ $prompt->category->name }}
                                    </a>
                                @else
                                    <span></span>
                                @endif
                                <a href="{{ route('prompts.show', $prompt) }}" class="btn btn-gradient btn-sm">{{ __('view') }}</a>
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
            <div class="text-center py-5">
                <i class="bi bi-search fs-1 mb-3" style="color:#334155"></i>
                <h4 class="text-muted">{{ __('no_prompts') }}</h4>
                <p class="text-muted small">{{ __('no_prompts_hint') }}</p>
                <a href="{{ route('prompts.index') }}" class="btn btn-gradient mt-2">{{ __('clear_filters') }}</a>
            </div>
        @endif
    </div>
</div>
@endsection
