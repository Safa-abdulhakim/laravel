@extends('layouts.app')

@section('title', $project->getTranslatedTitle() . ' - ' . config('app.name'))

@section('content')
<div class="pt-20" style="background: var(--color-bg); min-height: 100vh;">
    {{-- Banner --}}
    <div class="relative h-64 md:h-96 overflow-hidden">
        @if($project->cover_image)
        <img src="{{ Storage::url($project->cover_image) }}" alt="{{ $project->getTranslatedTitle() }}"
             class="w-full h-full object-cover">
        @else
        <div class="w-full h-full" style="background: linear-gradient(135deg, var(--color-accent), var(--color-secondary));"></div>
        @endif
        <div class="absolute inset-0" style="background: rgba(0,0,0,0.5);"></div>
        <div class="absolute inset-0 flex items-end">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pb-8">
                <a href="{{ route('projects.index') }}"
                   class="inline-flex items-center gap-2 text-white opacity-80 hover:opacity-100 mb-4 text-sm transition-opacity">
                    <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}"></i>
                    {{ __('portfolio.back_to_projects') }}
                </a>
                <div class="flex flex-wrap items-center gap-3 mb-2">
                    <span class="px-3 py-1 rounded-full text-xs font-bold text-white"
                          style="background: rgba(255,255,255,0.2); backdrop-filter: blur(10px);">
                        {{ ucfirst($project->category) }}
                    </span>
                    @if($project->featured)
                    <span class="px-3 py-1 rounded-full text-xs font-bold text-white"
                          style="background: linear-gradient(135deg, var(--color-accent), var(--color-secondary));">
                        ⭐ {{ __('portfolio.featured_badge') }}
                    </span>
                    @endif
                </div>
                <h1 class="text-3xl md:text-5xl font-extrabold text-white">{{ $project->getTranslatedTitle() }}</h1>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-8">
                @if($project->getTranslatedOverview())
                <div class="card p-8">
                    <h2 class="text-xl font-bold mb-4" style="color: var(--color-heading);">
                        <i class="fas fa-info-circle me-2" style="color: var(--color-accent);"></i>
                        {{ __('portfolio.overview') }}
                    </h2>
                    <p class="leading-relaxed" style="color: var(--color-body);">{{ $project->getTranslatedOverview() }}</p>
                </div>
                @else
                <div class="card p-8">
                    <h2 class="text-xl font-bold mb-4" style="color: var(--color-heading);">Overview</h2>
                    <p class="leading-relaxed" style="color: var(--color-body);">{{ $project->getTranslatedDescription() }}</p>
                </div>
                @endif

                @if($project->features)
                <div class="card p-8">
                    <h2 class="text-xl font-bold mb-4" style="color: var(--color-heading);">
                        <i class="fas fa-list-check me-2" style="color: var(--color-success);"></i>
                        {{ __('portfolio.features') }}
                    </h2>
                    <p class="leading-relaxed whitespace-pre-line" style="color: var(--color-body);">
                        {{ app()->getLocale() === 'ar' && $project->features_ar ? $project->features_ar : $project->features }}
                    </p>
                </div>
                @endif

                @if($project->challenges)
                <div class="card p-8">
                    <h2 class="text-xl font-bold mb-4" style="color: var(--color-heading);">
                        <i class="fas fa-puzzle-piece me-2" style="color: var(--color-warning);"></i>
                        {{ __('portfolio.challenges') }}
                    </h2>
                    <p class="leading-relaxed whitespace-pre-line" style="color: var(--color-body);">
                        {{ app()->getLocale() === 'ar' && $project->challenges_ar ? $project->challenges_ar : $project->challenges }}
                    </p>
                </div>
                @endif

                {{-- Gallery --}}
                @if($project->images->count() > 0)
                <div class="card p-8" x-data="{ lightbox: false, currentImg: '', currentIdx: 0 }">
                    <h2 class="text-xl font-bold mb-6" style="color: var(--color-heading);">
                        <i class="fas fa-images me-2" style="color: var(--color-secondary);"></i>
                        {{ __('portfolio.gallery') }}
                    </h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($project->images as $index => $image)
                        <div class="aspect-video overflow-hidden rounded-xl cursor-pointer group"
                             @click="lightbox = true; currentImg = '{{ Storage::url($image->image_path) }}'; currentIdx = {{ $index }}">
                            <img src="{{ Storage::url($image->image_path) }}" alt="Screenshot {{ $index + 1 }}"
                                 class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                        </div>
                        @endforeach
                    </div>
                    {{-- Lightbox --}}
                    <div x-show="lightbox" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4"
                         style="background: rgba(0,0,0,0.9);" @click="lightbox = false">
                        <div class="max-w-4xl w-full" @click.stop>
                            <img :src="currentImg" class="w-full rounded-2xl shadow-2xl">
                            <button @click="lightbox = false" class="mt-4 px-8 py-3 rounded-xl text-white w-full font-medium"
                                    style="background: var(--color-card);">Close</button>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                {{-- Action Buttons --}}
                <div class="card p-6 space-y-3">
                    @if($project->demo_link)
                    <a href="{{ $project->demo_link }}" target="_blank" class="btn-primary w-full justify-center">
                        <i class="fas fa-external-link-alt"></i>
                        {{ __('portfolio.live_demo') }}
                    </a>
                    @endif
                    @if($project->github_link)
                    <a href="{{ $project->github_link }}" target="_blank" class="btn-outline w-full justify-center">
                        <i class="fab fa-github"></i>
                        {{ __('portfolio.source_code') }}
                    </a>
                    @endif
                </div>

                {{-- Technologies --}}
                @if($project->technologies)
                <div class="card p-6">
                    <h3 class="font-bold mb-4" style="color: var(--color-heading);">
                        <i class="fas fa-code me-2" style="color: var(--color-accent);"></i>
                        {{ __('portfolio.technologies') }}
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($project->technologies as $tech)
                        <span class="px-3 py-1.5 rounded-xl text-sm font-medium"
                              style="background: rgba(79, 70, 229, 0.1); color: var(--color-accent);">{{ $tech }}</span>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Project Info --}}
                <div class="card p-6">
                    <h3 class="font-bold mb-4" style="color: var(--color-heading);">Project Info</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span style="color: var(--color-muted);">Category</span>
                            <span class="font-medium capitalize" style="color: var(--color-body);">{{ $project->category }}</span>
                        </div>
                        @if($project->images->count() > 0)
                        <div class="flex justify-between text-sm">
                            <span style="color: var(--color-muted);">Screenshots</span>
                            <span class="font-medium" style="color: var(--color-body);">{{ $project->images->count() }}</span>
                        </div>
                        @endif
                        @if($project->technologies)
                        <div class="flex justify-between text-sm">
                            <span style="color: var(--color-muted);">Technologies</span>
                            <span class="font-medium" style="color: var(--color-body);">{{ count($project->technologies) }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Related Projects --}}
        @if($related->count() > 0)
        <div class="mt-16">
            <h2 class="text-2xl font-bold mb-8" style="color: var(--color-heading);">{{ __('portfolio.related_projects') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($related as $rp)
                <a href="{{ route('projects.show', $rp->slug) }}" class="card overflow-hidden group">
                    <div class="h-40 overflow-hidden">
                        @if($rp->cover_image)
                        <img src="{{ Storage::url($rp->cover_image) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        @else
                        <div class="w-full h-full" style="background: linear-gradient(135deg, var(--color-accent), var(--color-secondary));"></div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold" style="color: var(--color-heading);">{{ $rp->getTranslatedTitle() }}</h3>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
