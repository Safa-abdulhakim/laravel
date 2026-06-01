@php $isAr = app()->getLocale() === 'ar'; @endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Portfolio') — John Developer</title>
    <meta name="description" content="@yield('meta-description', 'Full Stack Laravel Developer — Portfolio')">

    <!-- Bootstrap 5 (RTL/LTR) -->
    @if($isAr)
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    @else
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @if($isAr)
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    @endif

    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #10b981;
            --dark: #0f172a;
            --text: #334155;
        }
        * { font-family: {{ $isAr ? "'Tajawal'" : "'Inter'" }}, sans-serif; }
        [dir="rtl"] .ms-auto { margin-left: unset !important; margin-right: auto !important; }
        [dir="rtl"] .me-1 { margin-right: unset !important; margin-left: .25rem !important; }
        [dir="rtl"] .me-2 { margin-right: unset !important; margin-left: .5rem !important; }
        [dir="rtl"] .me-3 { margin-right: unset !important; margin-left: 1rem !important; }
        [dir="rtl"] .text-md-end { text-align: left !important; }
        [dir="rtl"] .timeline::before { left: unset; right: 20px; }
        [dir="rtl"] .timeline-item { padding-left: 0; padding-right: 60px; }
        [dir="rtl"] .timeline-dot { left: unset; right: 10px; }
        /* Language toggle */
        .lang-btn {
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.2);
            color: rgba(255,255,255,.8);
            border-radius: 99px;
            padding: .3rem .85rem;
            font-size: .8rem;
            font-weight: 700;
            letter-spacing: .04em;
            cursor: pointer;
            transition: all .2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .35rem;
        }
        .lang-btn:hover { background: var(--primary); border-color: var(--primary); color: #fff; }
        html { scroll-behavior: smooth; }
        body { color: var(--text); }

        /* Navbar */
        .navbar { backdrop-filter: blur(12px); transition: background .3s; }
        .navbar.scrolled { background: rgba(15,23,42,.95) !important; box-shadow: 0 2px 20px rgba(0,0,0,.2); }
        .navbar-brand { font-weight: 800; font-size: 1.3rem; letter-spacing: -.02em; }
        .nav-link { font-weight: 500; font-size: .9rem; transition: color .2s; }

        /* Hero */
        .hero-section {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #0f172a 100%);
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(99,102,241,.2) 0%, transparent 70%);
            top: -100px; right: -100px;
        }
        .hero-section::after {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(16,185,129,.15) 0%, transparent 70%);
            bottom: -50px; left: -50px;
        }
        .hero-content { position: relative; z-index: 2; }
        .hero-badge {
            display: inline-block;
            background: rgba(99,102,241,.15);
            border: 1px solid rgba(99,102,241,.3);
            color: #818cf8;
            padding: .4rem 1rem;
            border-radius: 99px;
            font-size: .85rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
        }
        .hero-title { font-size: clamp(2.5rem, 5vw, 4rem); font-weight: 800; color: #fff; line-height: 1.1; }
        .hero-title .highlight { color: var(--primary); }
        .hero-subtitle { color: rgba(255,255,255,.65); font-size: 1.1rem; line-height: 1.7; }
        .typing-text { color: #818cf8; font-weight: 600; }

        .btn-hero-primary {
            background: var(--primary);
            border: none;
            color: #fff;
            padding: .8rem 2rem;
            border-radius: 99px;
            font-weight: 600;
            transition: all .3s;
        }
        .btn-hero-primary:hover { background: var(--primary-dark); transform: translateY(-2px); box-shadow: 0 8px 24px rgba(99,102,241,.4); color: #fff; }
        .btn-hero-outline {
            background: transparent;
            border: 2px solid rgba(255,255,255,.2);
            color: rgba(255,255,255,.8);
            padding: .8rem 2rem;
            border-radius: 99px;
            font-weight: 600;
            transition: all .3s;
        }
        .btn-hero-outline:hover { border-color: rgba(255,255,255,.6); color: #fff; }

        .hero-stats { border-top: 1px solid rgba(255,255,255,.1); padding-top: 2rem; margin-top: 2rem; }
        .hero-stat-num { font-size: 2rem; font-weight: 800; color: #fff; }
        .hero-stat-label { color: rgba(255,255,255,.5); font-size: .8rem; text-transform: uppercase; letter-spacing: .08em; }

        /* Sections */
        section { padding: 5rem 0; }
        .section-header { margin-bottom: 3.5rem; }
        .section-badge {
            display: inline-block;
            background: #eef2ff;
            color: var(--primary);
            padding: .3rem .9rem;
            border-radius: 99px;
            font-size: .78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            margin-bottom: .75rem;
        }
        .section-title { font-size: 2.2rem; font-weight: 800; color: var(--dark); margin-bottom: .5rem; }
        .section-line { width: 50px; height: 4px; background: var(--primary); border-radius: 99px; }

        /* About */
        #about { background: #f8fafc; }

        /* Project Cards */
        .project-card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            transition: transform .3s, box-shadow .3s;
            height: 100%;
        }
        .project-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,.12); }
        .project-card .card-img-wrapper {
            height: 200px;
            overflow: hidden;
            background: linear-gradient(135deg, #eef2ff, #e0e7ff);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .project-card .card-img-wrapper img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
        .project-card:hover .card-img-wrapper img { transform: scale(1.05); }
        .project-card .status-featured { position: absolute; top: 12px; right: 12px; }
        .tech-badge { background: #eef2ff; color: var(--primary); font-size: .72rem; font-weight: 600; padding: .25rem .6rem; border-radius: 6px; }

        /* Skills */
        #skills { background: var(--dark); }
        #skills .section-badge { background: rgba(99,102,241,.15); color: #818cf8; }
        #skills .section-title { color: #fff; }
        .skill-bar-wrap { margin-bottom: 1.2rem; }
        .skill-bar-wrap .label { color: rgba(255,255,255,.8); font-size: .875rem; font-weight: 500; margin-bottom: .4rem; }
        .skill-bar-wrap .percentage { color: #818cf8; font-weight: 700; }
        .progress-dark { background: rgba(255,255,255,.08); border-radius: 99px; height: 8px; }
        .progress-dark .progress-bar { border-radius: 99px; background: linear-gradient(90deg, var(--primary), #818cf8); transition: width 1.5s ease; }

        .skill-category-badge {
            display: inline-flex; align-items: center; gap: .4rem;
            padding: .4rem 1rem; border-radius: 99px;
            font-size: .82rem; font-weight: 600; cursor: pointer;
            border: 2px solid transparent; transition: all .2s;
        }
        .skill-category-badge.active,
        .skill-category-badge:hover { border-color: var(--primary); color: #818cf8; }

        /* Timeline */
        .timeline { position: relative; }
        .timeline::before {
            content: '';
            position: absolute;
            left: 20px; top: 0; bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, var(--primary), transparent);
        }
        .timeline-item { padding-left: 60px; margin-bottom: 2.5rem; position: relative; }
        .timeline-dot {
            position: absolute;
            left: 10px; top: 4px;
            width: 22px; height: 22px;
            border-radius: 50%;
            background: var(--primary);
            border: 3px solid #fff;
            box-shadow: 0 0 0 3px rgba(99,102,241,.2);
        }
        .timeline-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 12px rgba(0,0,0,.06);
            transition: box-shadow .2s;
        }
        .timeline-card:hover { box-shadow: 0 6px 24px rgba(0,0,0,.1); }

        /* Certificates */
        #certificates { background: #f8fafc; }
        .cert-card {
            border-radius: 16px;
            overflow: hidden;
            border: 2px solid #e2e8f0;
            transition: all .3s;
            height: 100%;
        }
        .cert-card:hover { border-color: var(--primary); box-shadow: 0 8px 24px rgba(99,102,241,.12); transform: translateY(-4px); }
        .cert-icon-wrap {
            height: 120px;
            background: linear-gradient(135deg, #eef2ff, #e0e7ff);
            display: flex; align-items: center; justify-content: center;
        }

        /* Contact */
        .contact-form-wrap {
            background: #fff;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 8px 32px rgba(0,0,0,.08);
        }

        /* Footer */
        footer { background: var(--dark); color: rgba(255,255,255,.5); }
        footer a { color: rgba(255,255,255,.5); transition: color .2s; }
        footer a:hover { color: #fff; }

        /* Animations */
        .fade-up { opacity: 0; transform: translateY(30px); transition: opacity .6s ease, transform .6s ease; }
        .fade-up.visible { opacity: 1; transform: translateY(0); }

        @media (max-width: 768px) {
            .hero-title { font-size: 2.2rem; }
            section { padding: 3rem 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top" style="background:rgba(15,23,42,.8);" id="mainNav">
    <div class="container">
        <a class="navbar-brand text-white" href="{{ route('home') }}">
            <span style="color:var(--primary)">&lt;</span>JohnDev<span style="color:var(--primary)">/&gt;</span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span style="color:#fff;font-size:1.4rem;"><i class="bi bi-list"></i></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto gap-1 align-items-center">
                <li class="nav-item"><a class="nav-link text-white-50" href="{{ route('home') }}#about">{{ __('portfolio.nav_about') }}</a></li>
                <li class="nav-item"><a class="nav-link text-white-50" href="{{ route('home') }}#projects">{{ __('portfolio.nav_projects') }}</a></li>
                <li class="nav-item"><a class="nav-link text-white-50" href="{{ route('home') }}#skills">{{ __('portfolio.nav_skills') }}</a></li>
                <li class="nav-item"><a class="nav-link text-white-50" href="{{ route('home') }}#experience">{{ __('portfolio.nav_experience') }}</a></li>
                <li class="nav-item"><a class="nav-link text-white-50" href="{{ route('home') }}#certificates">{{ __('portfolio.nav_certificates') }}</a></li>
                <li class="nav-item"><a class="nav-link text-white-50" href="{{ route('contact') }}">{{ __('portfolio.nav_contact') }}</a></li>
                <li class="nav-item ms-2">
                    <a href="{{ route('cv.download') }}" class="btn btn-sm btn-primary rounded-pill px-3">
                        <i class="bi bi-download me-1"></i>{{ __('portfolio.nav_cv') }}
                    </a>
                </li>
                {{-- Language Switcher --}}
                <li class="nav-item ms-1">
                    @if($isAr)
                        <a href="{{ route('lang.switch', 'en') }}" class="lang-btn">
                            🇺🇸 EN
                        </a>
                    @else
                        <a href="{{ route('lang.switch', 'ar') }}" class="lang-btn">
                            🇸🇦 عربي
                        </a>
                    @endif
                </li>
            </ul>
        </div>
    </div>
</nav>

@yield('content')

<!-- Footer -->
<footer class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 mb-3 mb-md-0">
                <div class="fw-bold text-white mb-1">
                    <span style="color:var(--primary)">&lt;</span>JohnDev<span style="color:var(--primary)">/&gt;</span>
                </div>
                <small>{{ __('portfolio.footer_role') }}</small>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="d-flex justify-content-md-end gap-3 mb-2">
                    <a href="{{ route('home') }}#about">{{ __('portfolio.footer_about') }}</a>
                    <a href="{{ route('projects') }}">{{ __('portfolio.footer_projects') }}</a>
                    <a href="{{ route('contact') }}">{{ __('portfolio.footer_contact') }}</a>
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="text-primary">{{ __('portfolio.footer_admin') }}</a>
                    @else
                        <a href="{{ route('login') }}">{{ __('portfolio.footer_login') }}</a>
                    @endauth
                </div>
                <small>{{ __('portfolio.footer_copy', ['year' => date('Y')]) }}</small>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Navbar scroll effect
    window.addEventListener('scroll', () => {
        const nav = document.getElementById('mainNav');
        nav?.classList.toggle('scrolled', window.scrollY > 50);
    });

    // Scroll animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) { e.target.classList.add('visible'); }
        });
    }, { threshold: 0.15 });
    document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));

    // Progress bars animation
    const progObserver = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.querySelectorAll('.progress-bar[data-width]').forEach(bar => {
                    bar.style.width = bar.dataset.width + '%';
                });
            }
        });
    }, { threshold: 0.3 });
    document.querySelectorAll('#skills').forEach(el => progObserver.observe(el));
</script>
@stack('scripts')
</body>
</html>
