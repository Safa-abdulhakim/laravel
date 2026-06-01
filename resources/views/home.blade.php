@extends('layouts.main')
@section('title', __('nav_home'))
@section('content')

{{-- Hero Section --}}
<section class="hero-section">
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="mb-3">
                    <span class="badge" style="background:rgba(124,58,237,0.2);color:#a78bfa;border:1px solid rgba(124,58,237,0.3);font-size:0.85rem;padding:8px 16px;border-radius:20px;">
                        <i class="bi bi-stars me-1"></i> {{ __('hero_badge') }}
                    </span>
                </div>
                <h1 class="hero-title mb-4">{{ __('hero_title_line1') }}<br>{{ __('hero_title_line2') }}<br>{{ __('hero_title_line3') }}</h1>
                <p class="hero-subtitle mb-5">{{ __('hero_subtitle') }}</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('prompts.index') }}" class="btn btn-gradient btn-lg">
                        <i class="bi bi-collection me-2"></i>{{ __('hero_browse') }}
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-outline-gradient btn-lg">
                            <i class="bi bi-plus-circle me-2"></i>{{ __('hero_free') }}
                        </a>
                    @else
                        <a href="{{ route('my-prompts.create') }}" class="btn btn-outline-gradient btn-lg">
                            <i class="bi bi-plus-circle me-2"></i>{{ __('hero_add') }}
                        </a>
                    @endguest
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block">
                <div class="position-relative">
                    <div class="card-dark p-4 mb-3" style="transform:rotate(-2deg)">
                        <div class="d-flex align-items-center mb-3">
                            <span class="platform-badge platform-chatgpt me-2">ChatGPT</span>
                            <span class="platform-badge platform-claude">Claude</span>
                        </div>
                        <p class="mb-0 small" style="color:#94a3b8">Write a compelling blog post about [TOPIC] with SEO optimization, engaging headings, and a strong call-to-action...</p>
                    </div>
                    <div class="card-dark p-4" style="transform:rotate(1deg);margin-left:20px">
                        <div class="d-flex align-items-center mb-3">
                            <span class="platform-badge platform-midjourney">Midjourney</span>
                        </div>
                        <p class="mb-0 small" style="color:#94a3b8">A breathtaking fantasy landscape, crystal mountains, floating islands, magical aurora...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Stats --}}
<section class="py-5" style="background:rgba(124,58,237,0.05);border-top:1px solid #1e293b;border-bottom:1px solid #1e293b;">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['prompts'] }}+</div>
                    <p class="text-muted small mb-0">{{ __('stats_public_prompts') }}</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['categories'] }}</div>
                    <p class="text-muted small mb-0">{{ __('stats_categories') }}</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['tags'] }}</div>
                    <p class="text-muted small mb-0">{{ __('stats_tags') }}</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-number">5</div>
                    <p class="text-muted small mb-0">{{ __('stats_platforms') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Featured Prompts --}}
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-white mb-1">{{ __('featured_prompts') }}</h2>
                <p class="text-muted mb-0">{{ __('featured_subtitle') }}</p>
            </div>
            <a href="{{ route('prompts.index') }}" class="btn btn-outline-gradient">{{ __('view_all') }} <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
        <div class="row g-4">
            @foreach($featuredPrompts as $prompt)
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
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            @if($prompt->category)
                                <span class="small" style="color:#7c3aed"><i class="bi bi-folder me-1"></i>{{ $prompt->category->name }}</span>
                            @else
                                <span></span>
                            @endif
                            <a href="{{ route('prompts.show', $prompt) }}" class="btn btn-gradient btn-sm">{{ __('view') }} <i class="bi bi-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Categories --}}
<section class="py-5" style="background:rgba(15,23,42,0.5)">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-white mb-2">{{ __('browse_by_category') }}</h2>
            <p class="text-muted">{{ __('browse_category_subtitle') }}</p>
        </div>
        <div class="row g-3">
            @php
            $icons = ['Writing'=>'pencil-square','Coding'=>'code-slash','Marketing'=>'megaphone','Design'=>'palette','Education'=>'book'];
            $colors = ['Writing'=>'#10b981','Coding'=>'#4285f4','Marketing'=>'#f59e0b','Design'=>'#ec4899','Education'=>'#06b6d4'];
            @endphp
            @foreach($categories as $category)
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('categories.show', $category->slug) }}" class="text-decoration-none">
                    <div class="card-dark p-3 text-center">
                        @php $icon = $icons[$category->name] ?? 'lightning'; $color = $colors[$category->name] ?? '#7c3aed'; @endphp
                        <i class="bi bi-{{ $icon }} fs-2 mb-2" style="color:{{ $color }}"></i>
                        <h6 class="fw-semibold text-white mb-1">{{ $category->name }}</h6>
                        <p class="text-muted small mb-0">{{ __('prompts_in_category', ['count' => $category->prompts_count]) }}</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
@guest
<section class="py-5">
    <div class="container">
        <div class="card-dark p-5 text-center" style="background:linear-gradient(135deg,rgba(124,58,237,0.15),rgba(6,182,212,0.1));border-color:rgba(124,58,237,0.3)">
            <i class="bi bi-stars fs-1 mb-3" style="color:#a78bfa"></i>
            <h2 class="fw-bold text-white mb-3">{{ __('cta_title') }}</h2>
            <p class="text-muted mb-4">{{ __('cta_subtitle') }}</p>
            <a href="{{ route('register') }}" class="btn btn-gradient btn-lg px-5">{{ __('cta_button') }}</a>
        </div>
    </div>
</section>
@endguest

@endsection
