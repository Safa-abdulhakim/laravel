@extends('layouts.app')

@section('title', __('navigation.projects') . ' - ' . config('app.name'))

@section('content')
<div class="pt-20" style="background: var(--color-bg); min-height: 100vh;">
    {{-- Page Header --}}
    <div style="background: linear-gradient(135deg, var(--color-accent), var(--color-secondary));" class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-extrabold text-white mb-4">{{ __('portfolio.projects_title') }}</h1>
            <p class="text-white opacity-90 text-lg">{{ __('portfolio.projects_subtitle') }}</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {{-- Filters --}}
        <div class="card p-6 mb-8">
            <form method="GET" action="{{ route('projects.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="relative">
                    <i class="fas fa-search absolute {{ app()->getLocale() === 'ar' ? 'right-3' : 'left-3' }} top-1/2 -translate-y-1/2 text-sm" style="color: var(--color-muted);"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="w-full {{ app()->getLocale() === 'ar' ? 'pr-10 pl-4' : 'pl-10 pr-4' }} py-3 rounded-xl outline-none"
                           style="background: var(--color-bg); border: 1px solid var(--color-border); color: var(--color-body);"
                           placeholder="{{ __('portfolio.search_placeholder') }}">
                </div>
                <select name="category" class="w-full px-4 py-3 rounded-xl outline-none"
                        style="background: var(--color-bg); border: 1px solid var(--color-border); color: var(--color-body);">
                    <option value="">{{ __('portfolio.all_categories') }}</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
                <div class="flex gap-2">
                    <button type="submit" class="btn-primary flex-1 justify-center py-3">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    @if(request()->hasAny(['search', 'category', 'tech']))
                    <a href="{{ route('projects.index') }}" class="btn-outline px-4 py-3">
                        <i class="fas fa-times"></i>
                    </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Projects Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
            @forelse($projects as $project)
            <div class="card overflow-hidden group fade-in">
                <div class="h-48 overflow-hidden relative">
                    @if($project->cover_image)
                    <img src="{{ Storage::url($project->cover_image) }}" alt="{{ $project->getTranslatedTitle() }}"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    @else
                    <div class="w-full h-full flex items-center justify-center"
                         style="background: linear-gradient(135deg, var(--color-accent), var(--color-secondary));">
                        <i class="fas fa-code text-white text-4xl opacity-50"></i>
                    </div>
                    @endif
                    @if($project->featured)
                    <div class="absolute top-3 {{ app()->getLocale() === 'ar' ? 'right-3' : 'left-3' }}">
                        <span class="px-3 py-1 rounded-full text-xs font-bold text-white"
                              style="background: linear-gradient(135deg, var(--color-accent), var(--color-secondary));">
                            ⭐ {{ __('portfolio.featured_badge') }}
                        </span>
                    </div>
                    @endif
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center"
                         style="background: rgba(0,0,0,0.5);">
                        <a href="{{ route('projects.show', $project->slug) }}"
                           class="btn-primary text-sm">{{ __('portfolio.view_details') }}</a>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-start justify-between gap-2 mb-2">
                        <h3 class="font-bold text-lg" style="color: var(--color-heading);">{{ $project->getTranslatedTitle() }}</h3>
                        <span class="px-2 py-1 rounded-lg text-xs font-medium flex-shrink-0"
                              style="background: var(--color-border); color: var(--color-muted);">{{ $project->category }}</span>
                    </div>
                    <p class="text-sm leading-relaxed mb-4 line-clamp-2" style="color: var(--color-muted);">
                        {{ $project->getTranslatedDescription() }}
                    </p>
                    @if($project->technologies)
                    <div class="flex flex-wrap gap-2 mb-4">
                        @foreach(array_slice($project->technologies, 0, 4) as $tech)
                        <span class="px-2 py-1 rounded-lg text-xs font-medium"
                              style="background: rgba(79, 70, 229, 0.1); color: var(--color-accent);">{{ $tech }}</span>
                        @endforeach
                    </div>
                    @endif
                    <div class="flex items-center gap-2">
                        <a href="{{ route('projects.show', $project->slug) }}" class="btn-primary flex-1 justify-center text-sm py-2">
                            {{ __('portfolio.view_details') }}
                        </a>
                        @if($project->github_link)
                        <a href="{{ $project->github_link }}" target="_blank"
                           class="w-10 h-10 rounded-xl flex items-center justify-center"
                           style="border: 1px solid var(--color-border); color: var(--color-body);">
                            <i class="fab fa-github text-sm"></i>
                        </a>
                        @endif
                        @if($project->demo_link)
                        <a href="{{ $project->demo_link }}" target="_blank"
                           class="w-10 h-10 rounded-xl flex items-center justify-center"
                           style="border: 1px solid var(--color-border); color: var(--color-accent);">
                            <i class="fas fa-external-link-alt text-sm"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-20" style="color: var(--color-muted);">
                <i class="fas fa-search text-6xl mb-4 opacity-20"></i>
                <h3 class="text-xl font-bold mb-2" style="color: var(--color-heading);">{{ __('portfolio.no_results') }}</h3>
                <p>Try adjusting your search or filter criteria.</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        {{ $projects->withQueryString()->links() }}
    </div>
</div>
@endsection
