@extends('layouts.app')

@section('title', \App\Models\Setting::get('full_name', 'Portfolio') . ' - Full Stack Developer')

@section('content')

{{-- Hero Section --}}
<section id="hero" class="min-h-screen flex items-center justify-center relative overflow-hidden pt-16">
    {{-- Animated Background --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 rounded-full opacity-10 animate-float"
             style="background: radial-gradient(circle, var(--color-accent), transparent);"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 rounded-full opacity-10 animate-float"
             style="background: radial-gradient(circle, var(--color-secondary), transparent); animation-delay: 1.5s;"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full opacity-5"
             style="background: radial-gradient(circle, var(--color-primary), transparent);"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            {{-- Text Content --}}
            <div class="{{ app()->getLocale() === 'ar' ? 'text-right order-2 lg:order-2' : 'text-left order-2 lg:order-1' }}">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium mb-6"
                     style="background: rgba(79, 70, 229, 0.1); color: var(--color-accent); border: 1px solid rgba(79, 70, 229, 0.2);">
                    <span class="w-2 h-2 rounded-full animate-pulse" style="background: var(--color-success);"></span>
                    Available for Work
                </div>

                <h1 class="text-4xl lg:text-6xl font-extrabold leading-tight mb-4" style="color: var(--color-heading);">
                    {{ __('portfolio.hero_greeting') }}
                    <span class="block gradient-text mt-1">
                        {{ \App\Models\Setting::get(app()->getLocale() === 'ar' ? 'full_name_ar' : 'full_name', 'Ahmed Al-Rashidi') }}
                    </span>
                </h1>

                <div class="text-xl lg:text-2xl font-semibold mb-4" style="color: var(--color-accent);">
                    {{ \App\Models\Setting::get(app()->getLocale() === 'ar' ? 'job_title_ar' : 'job_title', 'Full Stack Laravel Developer') }}
                </div>

                <p class="text-lg mb-8 leading-relaxed" style="color: var(--color-muted);">
                    {{ \App\Models\Setting::get(app()->getLocale() === 'ar' ? 'bio_ar' : 'bio', __('portfolio.hero_description')) }}
                </p>

                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('projects.index') }}" class="btn-primary">
                        <i class="fas fa-rocket"></i>
                        {{ __('portfolio.view_projects') }}
                    </a>
                    <a href="{{ route('cv.download') }}" class="btn-outline">
                        <i class="fas fa-download"></i>
                        {{ __('portfolio.download_cv') }}
                    </a>
                    <a href="#contact" class="flex items-center gap-2 font-semibold transition-colors"
                       style="color: var(--color-muted);">
                        <i class="fas fa-paper-plane"></i>
                        {{ __('portfolio.contact_me') }}
                    </a>
                </div>

                {{-- Social Links --}}
                <div class="flex gap-3 mt-8">
                    @if(\App\Models\Setting::get('github_url'))
                    <a href="{{ \App\Models\Setting::get('github_url') }}" target="_blank"
                       class="w-11 h-11 rounded-xl flex items-center justify-center transition-all hover:-translate-y-1 hover:shadow-lg"
                       style="background: var(--color-card); border: 1px solid var(--color-border); color: var(--color-body);">
                        <i class="fab fa-github"></i>
                    </a>
                    @endif
                    @if(\App\Models\Setting::get('linkedin_url'))
                    <a href="{{ \App\Models\Setting::get('linkedin_url') }}" target="_blank"
                       class="w-11 h-11 rounded-xl flex items-center justify-center transition-all hover:-translate-y-1 hover:shadow-lg"
                       style="background: var(--color-card); border: 1px solid var(--color-border); color: #0077B5;">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    @endif
                </div>
            </div>

            {{-- Avatar --}}
            <div class="{{ app()->getLocale() === 'ar' ? 'flex justify-center order-1 lg:order-1' : 'flex justify-center order-1 lg:order-2' }}">
                <div class="relative">
                    <div class="w-72 h-72 lg:w-80 lg:h-80 rounded-3xl overflow-hidden shadow-2xl"
                         style="border: 4px solid var(--color-border);">
                        @if(\App\Models\Setting::get('avatar'))
                        <img src="{{ Storage::url(\App\Models\Setting::get('avatar')) }}"
                             alt="{{ \App\Models\Setting::get('full_name') }}"
                             class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-white text-8xl font-bold"
                             style="background: linear-gradient(135deg, var(--color-accent), var(--color-secondary));">
                            {{ strtoupper(substr(\App\Models\Setting::get('full_name', 'A'), 0, 1)) }}
                        </div>
                        @endif
                    </div>
                    {{-- Experience Badge --}}
                    <div class="absolute -bottom-4 -right-4 glass rounded-2xl px-4 py-3 shadow-xl">
                        <div class="text-2xl font-extrabold gradient-text">{{ $stats['experience_years'] }}+</div>
                        <div class="text-xs font-medium" style="color: var(--color-muted);">{{ __('portfolio.stats_experience') }}</div>
                    </div>
                    {{-- Projects Badge --}}
                    <div class="absolute -top-4 -left-4 glass rounded-2xl px-4 py-3 shadow-xl">
                        <div class="text-2xl font-extrabold gradient-text">{{ $stats['projects'] }}+</div>
                        <div class="text-xs font-medium" style="color: var(--color-muted);">{{ __('portfolio.stats_projects') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Scroll Indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 animate-bounce">
        <span class="text-xs font-medium" style="color: var(--color-muted);">Scroll</span>
        <i class="fas fa-chevron-down text-sm" style="color: var(--color-muted);"></i>
    </div>
</section>

{{-- Stats Section --}}
<div style="background: var(--color-surface); border-top: 1px solid var(--color-border); border-bottom: 1px solid var(--color-border);" class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center fade-in">
                <div class="text-4xl font-extrabold gradient-text" data-target="{{ $stats['projects'] }}">0</div>
                <div class="text-sm font-medium mt-1" style="color: var(--color-muted);">{{ __('portfolio.stats_projects') }}</div>
            </div>
            <div class="text-center fade-in">
                <div class="text-4xl font-extrabold gradient-text" data-target="{{ $stats['skills'] }}">0</div>
                <div class="text-sm font-medium mt-1" style="color: var(--color-muted);">{{ __('portfolio.stats_technologies') }}</div>
            </div>
            <div class="text-center fade-in">
                <div class="text-4xl font-extrabold gradient-text" data-target="{{ $stats['certificates'] }}">0</div>
                <div class="text-sm font-medium mt-1" style="color: var(--color-muted);">{{ __('portfolio.stats_certificates') }}</div>
            </div>
            <div class="text-center fade-in">
                <div class="text-4xl font-extrabold gradient-text" data-target="{{ $stats['experience_years'] ?: 5 }}">0</div>
                <div class="text-sm font-medium mt-1" style="color: var(--color-muted);">{{ __('portfolio.stats_experience') }}</div>
            </div>
        </div>
    </div>
</div>

{{-- About Section --}}
<section id="about" style="background: var(--color-bg);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="fade-in text-center mb-16">
            <h2 class="section-title">{{ __('portfolio.about_title') }}</h2>
            <p class="section-subtitle">{{ __('portfolio.about_description') }}</p>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="fade-in {{ app()->getLocale() === 'ar' ? 'text-right' : '' }}">
                <h3 class="text-2xl font-bold mb-4" style="color: var(--color-heading);">
                    {{ \App\Models\Setting::get(app()->getLocale() === 'ar' ? 'full_name_ar' : 'full_name', 'Ahmed') }}
                </h3>
                <p class="leading-relaxed text-lg mb-6" style="color: var(--color-body);">
                    {{ \App\Models\Setting::get(app()->getLocale() === 'ar' ? 'bio_ar' : 'bio', '') }}
                </p>
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="p-4 rounded-xl" style="background: var(--color-card); border: 1px solid var(--color-border);">
                        <div class="text-2xl font-bold gradient-text">{{ $stats['projects'] }}+</div>
                        <div class="text-sm" style="color: var(--color-muted);">{{ __('portfolio.stats_projects') }}</div>
                    </div>
                    <div class="p-4 rounded-xl" style="background: var(--color-card); border: 1px solid var(--color-border);">
                        <div class="text-2xl font-bold gradient-text">{{ $stats['experience_years'] ?: 5 }}+</div>
                        <div class="text-sm" style="color: var(--color-muted);">{{ __('portfolio.stats_experience') }}</div>
                    </div>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="#contact" class="btn-primary">
                        <i class="fas fa-envelope"></i>
                        {{ __('portfolio.contact_me') }}
                    </a>
                    <a href="{{ route('cv.download') }}" class="btn-outline">
                        <i class="fas fa-download"></i>
                        {{ __('portfolio.download_cv') }}
                    </a>
                </div>
            </div>
            <div class="fade-in">
                <div class="space-y-4">
                    <div class="p-5 rounded-xl" style="background: var(--color-card); border: 1px solid var(--color-border);">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                                 style="background: rgba(79, 70, 229, 0.1);">
                                <i class="fas fa-heart" style="color: var(--color-accent);"></i>
                            </div>
                            <h4 class="font-bold" style="color: var(--color-heading);">{{ __('portfolio.interests') }}</h4>
                        </div>
                        <p style="color: var(--color-body);">{{ \App\Models\Setting::get(app()->getLocale() === 'ar' ? 'interests_ar' : 'interests', 'Open Source, UI/UX Design, Cloud Computing') }}</p>
                    </div>
                    <div class="p-5 rounded-xl" style="background: var(--color-card); border: 1px solid var(--color-border);">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                                 style="background: rgba(16, 185, 129, 0.1);">
                                <i class="fas fa-map-marker-alt" style="color: var(--color-success);"></i>
                            </div>
                            <h4 class="font-bold" style="color: var(--color-heading);">Location</h4>
                        </div>
                        <p style="color: var(--color-body);">{{ \App\Models\Setting::get(app()->getLocale() === 'ar' ? 'location_ar' : 'location', 'Riyadh, Saudi Arabia') }}</p>
                    </div>
                    <div class="p-5 rounded-xl" style="background: var(--color-card); border: 1px solid var(--color-border);">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                                 style="background: rgba(245, 158, 11, 0.1);">
                                <i class="fas fa-envelope" style="color: var(--color-warning);"></i>
                            </div>
                            <h4 class="font-bold" style="color: var(--color-heading);">Email</h4>
                        </div>
                        <p style="color: var(--color-body);">{{ \App\Models\Setting::get('email', 'contact@portfolio.com') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Skills Section --}}
<section id="skills" style="background: var(--color-surface);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="fade-in text-center mb-16">
            <h2 class="section-title">{{ __('portfolio.skills_title') }}</h2>
            <p class="section-subtitle">{{ __('portfolio.skills_subtitle') }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($skillsByCategory as $category => $skills)
            <div class="fade-in card p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                         style="background: linear-gradient(135deg, var(--color-accent), var(--color-secondary));">
                        @if($category === 'backend')
                            <i class="fas fa-server text-white text-sm"></i>
                        @elseif($category === 'frontend')
                            <i class="fas fa-laptop-code text-white text-sm"></i>
                        @else
                            <i class="fas fa-tools text-white text-sm"></i>
                        @endif
                    </div>
                    <h3 class="font-bold text-lg capitalize" style="color: var(--color-heading);">{{ $category }}</h3>
                </div>
                <div class="space-y-4">
                    @foreach($skills as $skill)
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                @if($skill->icon)
                                <i class="{{ $skill->icon }} text-sm" style="color: {{ $skill->color ?? 'var(--color-accent)' }};"></i>
                                @endif
                                <span class="text-sm font-medium" style="color: var(--color-body);">{{ $skill->getTranslatedName() }}</span>
                            </div>
                            <span class="text-xs font-bold" style="color: var(--color-accent);">{{ $skill->percentage }}%</span>
                        </div>
                        <div class="skill-bar">
                            <div class="skill-bar-fill" style="width: 0%;"
                                 data-width="{{ $skill->percentage }}%"
                                 x-data="{}"
                                 x-intersect="$el.style.width = $el.dataset.width"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Projects Section --}}
<section id="projects" style="background: var(--color-bg);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="fade-in text-center mb-16">
            <h2 class="section-title">{{ __('portfolio.projects_title') }}</h2>
            <p class="section-subtitle">{{ __('portfolio.projects_subtitle') }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @forelse($featuredProjects as $project)
            <div class="fade-in card overflow-hidden group">
                {{-- Project Image --}}
                <div class="h-48 overflow-hidden relative">
                    @if($project->cover_image)
                    <img src="{{ Storage::url($project->cover_image) }}"
                         alt="{{ $project->getTranslatedTitle() }}"
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
                </div>

                {{-- Project Info --}}
                <div class="p-6">
                    <h3 class="font-bold text-lg mb-2 transition-colors group-hover:text-accent"
                        style="color: var(--color-heading);">{{ $project->getTranslatedTitle() }}</h3>
                    <p class="text-sm leading-relaxed mb-4 line-clamp-2" style="color: var(--color-muted);">
                        {{ $project->getTranslatedDescription() }}
                    </p>

                    {{-- Technologies --}}
                    @if($project->technologies)
                    <div class="flex flex-wrap gap-2 mb-4">
                        @foreach(array_slice($project->technologies, 0, 4) as $tech)
                        <span class="px-2 py-1 rounded-lg text-xs font-medium"
                              style="background: rgba(79, 70, 229, 0.1); color: var(--color-accent);">{{ $tech }}</span>
                        @endforeach
                        @if(count($project->technologies) > 4)
                        <span class="px-2 py-1 rounded-lg text-xs font-medium"
                              style="background: var(--color-border); color: var(--color-muted);">+{{ count($project->technologies) - 4 }}</span>
                        @endif
                    </div>
                    @endif

                    {{-- Links --}}
                    <div class="flex items-center gap-3">
                        <a href="{{ route('projects.show', $project->slug) }}"
                           class="flex-1 text-center btn-primary text-sm py-2">
                            {{ __('portfolio.view_details') }}
                        </a>
                        @if($project->github_link)
                        <a href="{{ $project->github_link }}" target="_blank"
                           class="w-10 h-10 rounded-xl flex items-center justify-center transition-all hover:-translate-y-1"
                           style="border: 1px solid var(--color-border); color: var(--color-body);">
                            <i class="fab fa-github text-sm"></i>
                        </a>
                        @endif
                        @if($project->demo_link)
                        <a href="{{ $project->demo_link }}" target="_blank"
                           class="w-10 h-10 rounded-xl flex items-center justify-center transition-all hover:-translate-y-1"
                           style="border: 1px solid var(--color-border); color: var(--color-accent);">
                            <i class="fas fa-external-link-alt text-sm"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-12" style="color: var(--color-muted);">
                <i class="fas fa-folder-open text-4xl mb-4 opacity-30"></i>
                <p>{{ __('messages.no_projects') }}</p>
            </div>
            @endforelse
        </div>

        <div class="text-center fade-in">
            <a href="{{ route('projects.index') }}" class="btn-outline">
                <i class="fas fa-th-large"></i>
                {{ __('navigation.all_projects') }}
            </a>
        </div>
    </div>
</section>

{{-- Experience Section --}}
<section id="experience" style="background: var(--color-surface);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="fade-in text-center mb-16">
            <h2 class="section-title">{{ __('portfolio.experience_title') }}</h2>
            <p class="section-subtitle">{{ __('portfolio.experience_subtitle') }}</p>
        </div>

        <div class="max-w-3xl mx-auto">
            <div class="relative {{ app()->getLocale() === 'ar' ? 'border-r-2 pr-8' : 'border-l-2 pl-8' }}"
                 style="border-color: var(--color-border);">
                @forelse($experiences as $experience)
                <div class="relative mb-10 fade-in timeline-item">
                    <div class="card p-6">
                        <div class="flex flex-wrap items-start justify-between gap-4 mb-3">
                            <div>
                                <h3 class="font-bold text-lg" style="color: var(--color-heading);">
                                    {{ $experience->getTranslatedPosition() }}
                                </h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <i class="fas fa-building text-xs" style="color: var(--color-accent);"></i>
                                    <span class="font-medium" style="color: var(--color-accent);">
                                        {{ $experience->getTranslatedCompany() }}
                                    </span>
                                </div>
                            </div>
                            <div class="{{ app()->getLocale() === 'ar' ? 'text-right' : 'text-right' }}">
                                <div class="text-sm font-medium" style="color: var(--color-muted);">
                                    {{ $experience->start_date->format('M Y') }} —
                                    {{ $experience->is_current ? __('portfolio.present') : $experience->end_date->format('M Y') }}
                                </div>
                                @if($experience->is_current)
                                <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-xs font-bold"
                                      style="background: rgba(16, 185, 129, 0.1); color: var(--color-success);">
                                    Current
                                </span>
                                @else
                                <div class="text-xs mt-1" style="color: var(--color-muted);">{{ $experience->getDuration() }}</div>
                                @endif
                            </div>
                        </div>
                        @if($experience->location)
                        <div class="flex items-center gap-1 text-sm mb-3" style="color: var(--color-muted);">
                            <i class="fas fa-map-marker-alt text-xs"></i>
                            {{ $experience->location }}
                        </div>
                        @endif
                        @if($experience->description)
                        <p class="text-sm leading-relaxed" style="color: var(--color-body);">
                            {{ app()->getLocale() === 'ar' && $experience->description_ar ? $experience->description_ar : $experience->description }}
                        </p>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center py-12" style="color: var(--color-muted);">
                    <p>{{ __('messages.no_experiences') }}</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

{{-- Certificates Section --}}
<section id="certificates" style="background: var(--color-bg);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="fade-in text-center mb-16">
            <h2 class="section-title">{{ __('portfolio.certificates_title') }}</h2>
            <p class="section-subtitle">{{ __('portfolio.certificates_subtitle') }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
             x-data="{ lightbox: false, current: null }">
            @forelse($certificates as $certificate)
            <div class="fade-in card p-6 cursor-pointer"
                 @click="lightbox = true; current = '{{ $certificate->image ? Storage::url($certificate->image) : '' }}'">
                <div class="flex items-start gap-4">
                    @if($certificate->image)
                    <img src="{{ Storage::url($certificate->image) }}"
                         alt="{{ $certificate->getTranslatedTitle() }}"
                         class="w-16 h-16 rounded-xl object-cover flex-shrink-0">
                    @else
                    <div class="w-16 h-16 rounded-xl flex items-center justify-center flex-shrink-0"
                         style="background: linear-gradient(135deg, var(--color-accent), var(--color-secondary));">
                        <i class="fas fa-certificate text-white text-2xl"></i>
                    </div>
                    @endif
                    <div class="{{ app()->getLocale() === 'ar' ? 'text-right' : '' }}">
                        <h3 class="font-bold mb-1" style="color: var(--color-heading);">
                            {{ $certificate->getTranslatedTitle() }}
                        </h3>
                        <p class="text-sm font-medium mb-1" style="color: var(--color-accent);">
                            {{ $certificate->getTranslatedIssuer() }}
                        </p>
                        <p class="text-xs" style="color: var(--color-muted);">
                            {{ $certificate->issue_date->format('M Y') }}
                        </p>
                        @if($certificate->credential_url)
                        <a href="{{ $certificate->credential_url }}" target="_blank"
                           class="inline-flex items-center gap-1 text-xs mt-2 font-medium"
                           style="color: var(--color-accent);"
                           @click.stop>
                            <i class="fas fa-external-link-alt"></i> Verify
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-12" style="color: var(--color-muted);">
                <i class="fas fa-certificate text-4xl mb-4 opacity-30"></i>
                <p>{{ __('messages.no_certificates') }}</p>
            </div>
            @endforelse

            {{-- Lightbox --}}
            <div x-show="lightbox && current" x-transition
                 class="fixed inset-0 z-50 flex items-center justify-center p-4"
                 style="background: rgba(0,0,0,0.8);"
                 @click="lightbox = false">
                <div class="max-w-2xl w-full" @click.stop>
                    <img :src="current" alt="Certificate" class="w-full rounded-2xl shadow-2xl">
                    <button @click="lightbox = false"
                            class="mt-4 px-6 py-2 rounded-xl text-white w-full"
                            style="background: var(--color-card);">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Testimonials Section --}}
@if($testimonials->count() > 0)
<section id="testimonials" style="background: var(--color-surface);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="fade-in text-center mb-16">
            <h2 class="section-title">{{ __('portfolio.testimonials_title') }}</h2>
            <p class="section-subtitle">{{ __('portfolio.testimonials_subtitle') }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($testimonials as $testimonial)
            <div class="fade-in card p-6">
                <div class="flex gap-1 mb-4">
                    @for($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star text-sm {{ $i <= $testimonial->rating ? '' : 'opacity-30' }}"
                       style="color: var(--color-warning);"></i>
                    @endfor
                </div>
                <p class="leading-relaxed mb-6 text-lg italic" style="color: var(--color-body);">
                    "{{ $testimonial->getTranslatedContent() }}"
                </p>
                <div class="flex items-center gap-3">
                    @if($testimonial->avatar)
                    <img src="{{ Storage::url($testimonial->avatar) }}"
                         alt="{{ $testimonial->name }}"
                         class="w-12 h-12 rounded-full object-cover">
                    @else
                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold"
                         style="background: linear-gradient(135deg, var(--color-accent), var(--color-secondary));">
                        {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                    </div>
                    @endif
                    <div>
                        <div class="font-bold" style="color: var(--color-heading);">
                            {{ app()->getLocale() === 'ar' && $testimonial->name_ar ? $testimonial->name_ar : $testimonial->name }}
                        </div>
                        <div class="text-sm" style="color: var(--color-muted);">
                            {{ app()->getLocale() === 'ar' && $testimonial->position_ar ? $testimonial->position_ar : $testimonial->position }}
                            @if($testimonial->company) · {{ $testimonial->company }} @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Contact Section --}}
<section id="contact" style="background: var(--color-bg);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="fade-in text-center mb-16">
            <h2 class="section-title">{{ __('portfolio.contact_title') }}</h2>
            <p class="section-subtitle">{{ __('portfolio.contact_subtitle') }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            {{-- Contact Info --}}
            <div class="fade-in space-y-6">
                <div class="card p-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center"
                             style="background: rgba(79, 70, 229, 0.1);">
                            <i class="fas fa-envelope" style="color: var(--color-accent);"></i>
                        </div>
                        <div>
                            <div class="text-sm font-medium" style="color: var(--color-muted);">Email</div>
                            <div class="font-semibold" style="color: var(--color-heading);">
                                {{ \App\Models\Setting::get('email', 'contact@portfolio.com') }}
                            </div>
                        </div>
                    </div>
                </div>
                @if(\App\Models\Setting::get('phone'))
                <div class="card p-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center"
                             style="background: rgba(16, 185, 129, 0.1);">
                            <i class="fas fa-phone" style="color: var(--color-success);"></i>
                        </div>
                        <div>
                            <div class="text-sm font-medium" style="color: var(--color-muted);">Phone</div>
                            <div class="font-semibold" style="color: var(--color-heading);">
                                {{ \App\Models\Setting::get('phone') }}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="card p-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center"
                             style="background: rgba(245, 158, 11, 0.1);">
                            <i class="fas fa-map-marker-alt" style="color: var(--color-warning);"></i>
                        </div>
                        <div>
                            <div class="text-sm font-medium" style="color: var(--color-muted);">Location</div>
                            <div class="font-semibold" style="color: var(--color-heading);">
                                {{ \App\Models\Setting::get(app()->getLocale() === 'ar' ? 'location_ar' : 'location', 'Riyadh, Saudi Arabia') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex gap-4">
                    @if(\App\Models\Setting::get('github_url'))
                    <a href="{{ \App\Models\Setting::get('github_url') }}" target="_blank"
                       class="card flex-1 p-4 flex items-center justify-center gap-2 font-medium transition-all hover:-translate-y-1"
                       style="color: var(--color-body);">
                        <i class="fab fa-github"></i> GitHub
                    </a>
                    @endif
                    @if(\App\Models\Setting::get('linkedin_url'))
                    <a href="{{ \App\Models\Setting::get('linkedin_url') }}" target="_blank"
                       class="card flex-1 p-4 flex items-center justify-center gap-2 font-medium transition-all hover:-translate-y-1"
                       style="color: #0077B5;">
                        <i class="fab fa-linkedin-in"></i> LinkedIn
                    </a>
                    @endif
                </div>
            </div>

            {{-- Contact Form --}}
            <div class="fade-in">
                <div class="card p-8">
                    @if($errors->any())
                    <div class="mb-6 p-4 rounded-xl" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2);">
                        <ul class="text-sm space-y-1" style="color: var(--color-danger);">
                            @foreach($errors->all() as $error)
                            <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" x-data="{ submitting: false }"
                          @submit="submitting = true">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">
                                    {{ __('portfolio.contact_name') }} *
                                </label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                       class="w-full px-4 py-3 rounded-xl outline-none transition-all"
                                       style="background: var(--color-bg); border: 1px solid var(--color-border); color: var(--color-body);"
                                       placeholder="{{ __('portfolio.contact_name') }}">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">
                                    {{ __('portfolio.contact_email') }} *
                                </label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                       class="w-full px-4 py-3 rounded-xl outline-none transition-all"
                                       style="background: var(--color-bg); border: 1px solid var(--color-border); color: var(--color-body);"
                                       placeholder="{{ __('portfolio.contact_email') }}">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">
                                {{ __('portfolio.contact_subject') }}
                            </label>
                            <input type="text" name="subject" value="{{ old('subject') }}"
                                   class="w-full px-4 py-3 rounded-xl outline-none transition-all"
                                   style="background: var(--color-bg); border: 1px solid var(--color-border); color: var(--color-body);"
                                   placeholder="{{ __('portfolio.contact_subject') }}">
                        </div>
                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">
                                {{ __('portfolio.contact_message') }} *
                            </label>
                            <textarea name="message" rows="5" required
                                      class="w-full px-4 py-3 rounded-xl outline-none transition-all resize-none"
                                      style="background: var(--color-bg); border: 1px solid var(--color-border); color: var(--color-body);"
                                      placeholder="{{ __('portfolio.contact_message') }}">{{ old('message') }}</textarea>
                        </div>
                        <button type="submit" :disabled="submitting"
                                class="btn-primary w-full justify-center"
                                :class="{ 'opacity-70 cursor-not-allowed': submitting }">
                            <i class="fas fa-paper-plane" x-show="!submitting"></i>
                            <i class="fas fa-circle-notch fa-spin" x-show="submitting"></i>
                            <span x-text="submitting ? '{{ __('portfolio.contact_sending') }}' : '{{ __('portfolio.contact_send') }}'"></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
