@extends('layouts.main')
@section('title', $prompt->title)
@section('content')

<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                {{-- Breadcrumb --}}
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb" style="background:transparent">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-muted text-decoration-none">{{ __('breadcrumb_home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('prompts.index') }}" class="text-muted text-decoration-none">{{ __('breadcrumb_prompts') }}</a></li>
                        <li class="breadcrumb-item active text-light">{{ Str::limit($prompt->title, 40) }}</li>
                    </ol>
                </nav>

                {{-- Main Card --}}
                <div class="card-dark p-4 mb-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-start mb-4">
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <span class="platform-badge platform-{{ strtolower($prompt->platform) }} fs-6">{{ $prompt->platform }}</span>
                            @if($prompt->category)
                                <a href="{{ route('categories.show', $prompt->category->slug) }}" class="text-decoration-none" style="color:#7c3aed;font-size:0.85rem;">
                                    <i class="bi bi-folder me-1"></i>{{ $prompt->category->name }}
                                </a>
                            @endif
                        </div>
                        <div class="d-flex gap-2 align-items-center">
                            <span class="text-muted small"><i class="bi bi-eye me-1"></i>{{ $prompt->views }} {{ __('views') }}</span>
                            @auth
                                <form method="POST" action="{{ route('favorites.toggle', $prompt) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm" style="background:{{ $isFavorited ? 'rgba(239,68,68,0.15)' : 'rgba(71,85,105,0.3)' }};color:{{ $isFavorited ? '#ef4444' : '#94a3b8' }};border:1px solid {{ $isFavorited ? 'rgba(239,68,68,0.3)' : '#334155' }};border-radius:8px;">
                                        <i class="bi bi-heart{{ $isFavorited ? '-fill' : '' }} me-1"></i>{{ $isFavorited ? __('saved_label') : __('save_label') }}
                                    </button>
                                </form>
                            @endauth
                        </div>
                    </div>

                    <h1 class="fw-bold text-white mb-4" style="font-size:1.8rem">{{ $prompt->title }}</h1>

                    {{-- Prompt Content Box --}}
                    <div class="position-relative mb-4">
                        <div class="p-4" style="background:#0f172a;border:1px solid #334155;border-radius:12px;font-family:monospace;font-size:0.95rem;color:#e2e8f0;white-space:pre-wrap;line-height:1.7;max-height:400px;overflow-y:auto;">{{ $prompt->prompt_content }}</div>
                        <button
                            class="btn btn-sm btn-outline-secondary copy-btn position-absolute"
                            style="top:12px;right:12px;border-color:#334155;color:#94a3b8;"
                            onclick="copyPrompt({{ json_encode($prompt->prompt_content) }}, this)">
                            <i class="bi bi-clipboard me-1"></i>{{ __('copy') }}
                        </button>
                    </div>

                    {{-- Tags --}}
                    @if($prompt->tags->count())
                        <div class="mb-4">
                            <p class="text-muted small mb-2"><i class="bi bi-tags me-1"></i>{{ __('tags_label') }}</p>
                            @foreach($prompt->tags as $tag)
                                <a href="{{ route('prompts.index', ['tag' => $tag->slug]) }}" class="tag-pill">{{ $tag->name }}</a>
                            @endforeach
                        </div>
                    @endif

                    {{-- Meta --}}
                    <div class="d-flex flex-wrap gap-4 pt-3 border-top" style="border-color:#334155!important">
                        <div class="text-muted small"><i class="bi bi-person me-1"></i>{{ $prompt->user->name }}</div>
                        <div class="text-muted small"><i class="bi bi-calendar me-1"></i>{{ $prompt->created_at->format('M d, Y') }}</div>
                        <div class="text-muted small"><i class="bi bi-eye me-1"></i>{{ $prompt->views }} {{ __('views') }}</div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                {{-- Quick Actions --}}
                <div class="card-dark p-4 mb-4">
                    <h6 class="fw-semibold text-white mb-3">{{ __('quick_actions') }}</h6>
                    <button class="btn btn-gradient w-100 mb-2 copy-btn" onclick="copyPrompt({{ json_encode($prompt->prompt_content) }}, this)">
                        <i class="bi bi-clipboard me-2"></i>{{ __('copy_full_prompt') }}
                    </button>
                    @auth
                        <form method="POST" action="{{ route('favorites.toggle', $prompt) }}">
                            @csrf
                            <button type="submit" class="btn w-100" style="background:{{ $isFavorited ? 'rgba(239,68,68,0.15)' : 'rgba(71,85,105,0.2)' }};color:{{ $isFavorited ? '#ef4444' : '#e2e8f0' }};border:1px solid {{ $isFavorited ? 'rgba(239,68,68,0.3)' : '#334155' }};border-radius:10px;">
                                <i class="bi bi-heart{{ $isFavorited ? '-fill' : '' }} me-2"></i>{{ $isFavorited ? __('no_favorites') : __('nav_favorites') }}
                            </button>
                        </form>
                    @endauth
                </div>

                {{-- Prompt Details --}}
                <div class="card-dark p-4 mb-4">
                    <h6 class="fw-semibold text-white mb-3">{{ __('details_label') }}</h6>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">{{ __('platform_label') }}</span>
                        <span class="platform-badge platform-{{ strtolower($prompt->platform) }}">{{ $prompt->platform }}</span>
                    </div>
                    @if($prompt->category)
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">{{ __('category_label') }}</span>
                            <span class="text-light small">{{ $prompt->category->name }}</span>
                        </div>
                    @endif
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">{{ __('views') }}</span>
                        <span class="text-light small">{{ $prompt->views }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted small">{{ __('added_label') }}</span>
                        <span class="text-light small">{{ $prompt->created_at->diffForHumans() }}</span>
                    </div>
                </div>

                {{-- Related --}}
                @if($related->count())
                    <div class="card-dark p-4">
                        <h6 class="fw-semibold text-white mb-3">{{ __('related_prompts') }}</h6>
                        @foreach($related as $r)
                            <a href="{{ route('prompts.show', $r) }}" class="text-decoration-none">
                                <div class="d-flex align-items-start gap-2 mb-3 pb-3" style="border-bottom:1px solid #1e293b">
                                    <span class="platform-badge platform-{{ strtolower($r->platform) }} mt-1">{{ $r->platform }}</span>
                                    <div>
                                        <p class="text-white small mb-0 fw-semibold">{{ Str::limit($r->title, 40) }}</p>
                                        <p class="text-muted" style="font-size:0.75rem">{{ $r->views }} {{ __('views') }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
