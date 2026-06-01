@extends('layouts.portfolio')
@section('title', __('portfolio.nav_about'))

@section('content')

{{-- ======== HERO SECTION ======== --}}
<section class="hero-section d-flex align-items-center" id="hero">
    <div class="container hero-content py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <div class="hero-badge">
                    <i class="bi bi-circle-fill me-2" style="font-size:.5rem;color:#10b981;"></i>
                    {{ __('portfolio.hero_available') }}
                </div>
                <h1 class="hero-title">
                    {{ __('portfolio.hero_greeting') }} <span class="highlight">John</span><br>
                    <span class="typing-text" id="typingText">Full Stack Developer</span>
                </h1>
                <p class="hero-subtitle mt-3 mb-4">
                    {!! __('portfolio.hero_subtitle') !!}
                </p>
                <div class="d-flex flex-wrap gap-3 mb-4">
                    <a href="{{ route('projects') }}" class="btn-hero-primary">
                        <i class="bi bi-grid-3x3-gap me-2"></i>{{ __('portfolio.hero_view_work') }}
                    </a>
                    <a href="{{ route('contact') }}" class="btn-hero-outline">
                        <i class="bi bi-envelope me-2"></i>{{ __('portfolio.hero_get_touch') }}
                    </a>
                </div>
                <div class="hero-stats d-flex flex-wrap gap-5">
                    <div>
                        <div class="hero-stat-num">{{ $featuredProjects->count() }}+</div>
                        <div class="hero-stat-label">{{ __('portfolio.hero_projects') }}</div>
                    </div>
                    <div>
                        <div class="hero-stat-num">{{ $skills->count() }}+</div>
                        <div class="hero-stat-label">{{ __('portfolio.hero_skills') }}</div>
                    </div>
                    <div>
                        <div class="hero-stat-num">{{ $experiences->count() }}+</div>
                        <div class="hero-stat-label">{{ __('portfolio.hero_experiences') }}</div>
                    </div>
                    <div>
                        <div class="hero-stat-num">{{ $certificates->count() }}+</div>
                        <div class="hero-stat-label">{{ __('portfolio.hero_certificates') }}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 text-center">
                <div class="position-relative d-inline-block">
                    <div class="rounded-circle overflow-hidden mx-auto"
                         style="width:280px;height:280px;border:4px solid rgba(99,102,241,.4);background:linear-gradient(135deg,#1e1b4b,#312e81);">
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                            <i class="bi bi-person-fill" style="font-size:8rem;color:rgba(99,102,241,.5);"></i>
                        </div>
                    </div>
                    <div class="position-absolute bottom-0 end-0 p-2 rounded-pill text-white shadow"
                         style="background:var(--primary);font-size:.78rem;font-weight:600;">
                        <i class="bi bi-code-slash me-1"></i>Laravel Dev
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ======== ABOUT SECTION ======== --}}
<section id="about">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5 fade-up">
                <div class="rounded-3 overflow-hidden shadow-lg"
                     style="background:linear-gradient(135deg,#eef2ff,#e0e7ff);min-height:360px;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-person-workspace" style="font-size:8rem;color:#6366f1;opacity:.4;"></i>
                </div>
            </div>
            <div class="col-lg-7 fade-up">
                <div class="section-header">
                    <span class="section-badge">{{ __('portfolio.about_badge') }}</span>
                    <h2 class="section-title">{{ __('portfolio.about_title') }}</h2>
                    <div class="section-line"></div>
                </div>
                <p class="text-muted mb-3" style="font-size:1.05rem;line-height:1.8;">
                    {{ __('portfolio.about_p1') }}
                </p>
                <p class="text-muted mb-4" style="line-height:1.8;">
                    {{ __('portfolio.about_p2') }}
                </p>
                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <div class="p-3 rounded-3" style="background:#f8fafc;border-{{ app()->getLocale()=='ar'?'right':'left' }}:3px solid #6366f1;">
                            <i class="bi bi-geo-alt text-primary me-2"></i>
                            <span class="small fw-medium">{{ __('portfolio.about_location') }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded-3" style="background:#f8fafc;border-{{ app()->getLocale()=='ar'?'right':'left' }}:3px solid #10b981;">
                            <i class="bi bi-envelope text-success me-2"></i>
                            <span class="small fw-medium">{{ __('portfolio.about_email') }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded-3" style="background:#f8fafc;border-{{ app()->getLocale()=='ar'?'right':'left' }}:3px solid #f59e0b;">
                            <i class="bi bi-briefcase text-warning me-2"></i>
                            <span class="small fw-medium">{{ __('portfolio.about_exp') }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded-3" style="background:#f8fafc;border-{{ app()->getLocale()=='ar'?'right':'left' }}:3px solid #ef4444;">
                            <i class="bi bi-mortarboard text-danger me-2"></i>
                            <span class="small fw-medium">{{ __('portfolio.about_edu') }}</span>
                        </div>
                    </div>
                </div>
                @if($activeCv)
                <a href="{{ route('cv.download') }}" class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-download me-2"></i>{{ __('portfolio.about_download_cv') }}
                </a>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- ======== PROJECTS SECTION ======== --}}
<section id="projects">
    <div class="container">
        <div class="text-center section-header fade-up">
            <span class="section-badge">{{ __('portfolio.projects_badge') }}</span>
            <h2 class="section-title">{{ __('portfolio.projects_title') }}</h2>
            <div class="section-line mx-auto"></div>
            <p class="text-muted mt-3">{{ __('portfolio.projects_sub') }}</p>
        </div>
        <div class="row g-4">
            @forelse($featuredProjects as $project)
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
                        <p class="text-muted small mb-3" style="line-height:1.6;">{{ Str::limit($project->description, 100) }}</p>
                        @if($project->technologies)
                            <div class="d-flex flex-wrap gap-1 mb-3">
                                @foreach(array_slice($project->technologies, 0, 4) as $tech)
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
            <div class="col-12 text-center py-5 text-muted">{{ __('portfolio.projects_none') }}</div>
            @endforelse
        </div>
        <div class="text-center mt-5 fade-up">
            <a href="{{ route('projects') }}" class="btn btn-outline-primary rounded-pill px-5 py-2">
                {{ __('portfolio.projects_view_all') }} <i class="bi bi-arrow-{{ app()->getLocale()=='ar'?'left':'right' }} ms-2"></i>
            </a>
        </div>
    </div>
</section>

{{-- ======== SKILLS SECTION ======== --}}
<section id="skills">
    <div class="container">
        <div class="text-center section-header fade-up">
            <span class="section-badge">{{ __('portfolio.skills_badge') }}</span>
            <h2 class="section-title">{{ __('portfolio.skills_title') }}</h2>
            <div class="section-line mx-auto" style="background:#818cf8;"></div>
        </div>
        <div class="d-flex justify-content-center flex-wrap gap-2 mb-5">
            <button class="skill-category-badge active text-white-50" onclick="filterSkills('all', this)">
                <i class="bi bi-grid"></i> {{ __('portfolio.skills_all') }}
            </button>
            <button class="skill-category-badge text-white-50" onclick="filterSkills('frontend', this)">
                <i class="bi bi-layout-text-window"></i> {{ __('portfolio.skills_frontend') }}
            </button>
            <button class="skill-category-badge text-white-50" onclick="filterSkills('backend', this)">
                <i class="bi bi-server"></i> {{ __('portfolio.skills_backend') }}
            </button>
            <button class="skill-category-badge text-white-50" onclick="filterSkills('tools', this)">
                <i class="bi bi-tools"></i> {{ __('portfolio.skills_tools') }}
            </button>
        </div>
        <div class="row g-4" id="skillsGrid">
            @foreach($skillsByCategory as $category => $catSkills)
            <div class="col-lg-4 skill-group" data-category="{{ $category }}">
                <div class="p-4 rounded-3" style="background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.07);">
                    <h6 class="text-white fw-semibold mb-4 d-flex align-items-center gap-2">
                        @if($category === 'frontend') <i class="bi bi-layout-text-window text-primary"></i>
                        @elseif($category === 'backend') <i class="bi bi-server text-success"></i>
                        @elseif($category === 'tools') <i class="bi bi-tools text-warning"></i>
                        @else <i class="bi bi-star text-info"></i>
                        @endif
                        {{ __('portfolio.skills_'.$category, [], null) ?: ucfirst($category) }}
                    </h6>
                    @foreach($catSkills as $skill)
                    <div class="skill-bar-wrap">
                        <div class="d-flex justify-content-between label">
                            <span>{{ $skill->name }}</span>
                            <span class="percentage">{{ $skill->percentage }}%</span>
                        </div>
                        <div class="progress-dark">
                            <div class="progress-bar" role="progressbar"
                                 style="width:0%" data-width="{{ $skill->percentage }}">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ======== EXPERIENCE SECTION ======== --}}
<section id="experience">
    <div class="container">
        <div class="text-center section-header fade-up">
            <span class="section-badge">{{ __('portfolio.exp_badge') }}</span>
            <h2 class="section-title">{{ __('portfolio.exp_title') }}</h2>
            <div class="section-line mx-auto"></div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="timeline">
                    @forelse($experiences as $exp)
                    <div class="timeline-item fade-up">
                        <div class="timeline-dot"></div>
                        <div class="timeline-card">
                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-2">
                                <div>
                                    <h5 class="fw-bold mb-0">{{ $exp->position }}</h5>
                                    <div class="text-primary fw-medium">{{ $exp->company }}</div>
                                </div>
                                @if($exp->is_current)
                                    <span class="badge rounded-pill px-3" style="background:#d1fae5;color:#065f46;">
                                        <i class="bi bi-circle-fill me-1" style="font-size:.5rem;"></i>{{ __('portfolio.exp_current') }}
                                    </span>
                                @endif
                            </div>
                            <div class="d-flex flex-wrap gap-3 text-muted small mb-3">
                                <span><i class="bi bi-calendar3 me-1"></i>
                                    {{ $exp->start_date->format('M Y') }} —
                                    {{ $exp->is_current ? __('portfolio.exp_present') : $exp->end_date->format('M Y') }}
                                </span>
                                @if($exp->location)
                                    <span><i class="bi bi-geo-alt me-1"></i>{{ $exp->location }}</span>
                                @endif
                            </div>
                            @if($exp->description)
                                <p class="text-muted mb-0" style="line-height:1.7;">{{ $exp->description }}</p>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-5">{{ __('portfolio.exp_none') }}</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ======== CERTIFICATES SECTION ======== --}}
<section id="certificates">
    <div class="container">
        <div class="text-center section-header fade-up">
            <span class="section-badge">{{ __('portfolio.cert_badge') }}</span>
            <h2 class="section-title">{{ __('portfolio.cert_title') }}</h2>
            <div class="section-line mx-auto"></div>
        </div>
        <div class="row g-4">
            @forelse($certificates as $cert)
            <div class="col-md-6 col-lg-4 fade-up">
                <div class="cert-card card">
                    @if($cert->image)
                        <img src="{{ asset('storage/'.$cert->image) }}" class="card-img-top"
                             style="height:140px;object-fit:cover;">
                    @else
                        <div class="cert-icon-wrap">
                            <i class="bi bi-patch-check-fill" style="font-size:3.5rem;color:#6366f1;"></i>
                        </div>
                    @endif
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-1">{{ $cert->title }}</h6>
                        <div class="text-primary small fw-medium mb-1">{{ $cert->issuer }}</div>
                        <div class="text-muted small mb-3">
                            <i class="bi bi-calendar3 me-1"></i>{{ $cert->issue_date->format('M Y') }}
                        </div>
                        @if($cert->credential_url)
                            <a href="{{ $cert->credential_url }}" target="_blank"
                               class="btn btn-sm btn-outline-primary rounded-pill">
                                <i class="bi bi-patch-check me-1"></i>{{ __('portfolio.cert_verify') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center text-muted py-5">{{ __('portfolio.cert_none') }}</div>
            @endforelse
        </div>
    </div>
</section>

{{-- ======== CONTACT TEASER ======== --}}
<section style="background:linear-gradient(135deg,#0f172a,#1e1b4b);padding:5rem 0;">
    <div class="container text-center">
        <div class="fade-up">
            <span class="section-badge" style="background:rgba(99,102,241,.15);color:#818cf8;">{{ __('portfolio.cta_badge') }}</span>
            <h2 class="section-title mt-2" style="color:#fff;">{{ __('portfolio.cta_title') }}</h2>
            <p class="text-white-50 mb-4" style="max-width:500px;margin:0 auto 2rem;">
                {{ __('portfolio.cta_sub') }}
            </p>
            <a href="{{ route('contact') }}" class="btn-hero-primary">
                <i class="bi bi-send me-2"></i>{{ __('portfolio.cta_btn') }}
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Typing effect
    const texts = ['Full Stack Developer', 'Laravel Expert', 'Vue.js Developer', 'Problem Solver'];
    let textIndex = 0, charIndex = 0, isDeleting = false;
    function type() {
        const el = document.getElementById('typingText');
        if (!el) return;
        const current = texts[textIndex];
        el.textContent = isDeleting ? current.substring(0, charIndex--) : current.substring(0, charIndex++);
        if (!isDeleting && charIndex === current.length + 1) {
            setTimeout(() => isDeleting = true, 1500);
        } else if (isDeleting && charIndex === 0) {
            isDeleting = false;
            textIndex = (textIndex + 1) % texts.length;
        }
        setTimeout(type, isDeleting ? 60 : 100);
    }
    type();

    // Skills filter
    function filterSkills(cat, btn) {
        document.querySelectorAll('.skill-category-badge').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        document.querySelectorAll('.skill-group').forEach(g => {
            g.style.display = (cat === 'all' || g.dataset.category === cat) ? '' : 'none';
        });
    }

    // Animate progress bars when in view
    const skillSection = document.getElementById('skills');
    if (skillSection) {
        const obs = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    document.querySelectorAll('.progress-bar[data-width]').forEach(bar => {
                        setTimeout(() => bar.style.width = bar.dataset.width + '%', 300);
                    });
                    obs.disconnect();
                }
            });
        }, { threshold: 0.2 });
        obs.observe(skillSection);
    }
</script>
@endpush
