@php $isRtl = app()->getLocale() === 'ar'; @endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" {{ $isRtl ? 'dir="rtl"' : '' }}>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('app.site_name'))</title>
    @if($isRtl)
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    @else
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    @endif
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <style>
        :root { --primary: #6366f1; --primary-dark: #4f46e5; }
        body { background-color: #f8fafc; font-family: {{ $isRtl ? "'Cairo', 'Tahoma'" : "'Segoe UI', system-ui" }}, sans-serif; }
        .navbar-brand { font-weight: 700; font-size: 1.4rem; }
        .btn-primary { background-color: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background-color: var(--primary-dark); border-color: var(--primary-dark); }
        .text-primary { color: var(--primary) !important; }
        .bg-primary { background-color: var(--primary) !important; }
        .progress { height: 8px; border-radius: 10px; }
        .card { border: none; box-shadow: 0 1px 3px rgba(0,0,0,.08); border-radius: 12px; }
        .card:hover { box-shadow: 0 4px 12px rgba(0,0,0,.12); transition: box-shadow .2s; }
        .navbar { background: white !important; box-shadow: 0 1px 3px rgba(0,0,0,.06); }
        .skill-card { transition: transform .15s; cursor: pointer; }
        .skill-card:hover { transform: translateY(-2px); }
        footer { background: #1e293b; color: #94a3b8; }
        h1,h2,h3,h4,h5,h6 { font-family: {{ $isRtl ? "'Cairo'" : "'Segoe UI'" }}, sans-serif; }
        .lang-switcher .btn { font-size: .8rem; padding: .3rem .7rem; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand text-primary" href="{{ route('home') }}">
                <i class="bi bi-map-fill me-2"></i>{{ __('app.site_name') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'fw-semibold text-primary' : '' }}" href="{{ route('home') }}">{{ __('app.home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('career-paths.*') ? 'fw-semibold text-primary' : '' }}" href="{{ route('career-paths.index') }}">{{ __('app.career_paths') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">{{ __('app.about') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">{{ __('app.contact') }}</a>
                    </li>
                </ul>
                <ul class="navbar-nav align-items-center gap-2">
                    <!-- Language Switcher -->
                    <li class="nav-item lang-switcher d-flex gap-1">
                        <form method="POST" action="{{ route('lang.switch', 'ar') }}">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ app()->getLocale() == 'ar' ? 'btn-primary' : 'btn-outline-secondary' }}">عربي</button>
                        </form>
                        <form method="POST" action="{{ route('lang.switch', 'en') }}">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ app()->getLocale() == 'en' ? 'btn-primary' : 'btn-outline-secondary' }}">EN</button>
                        </form>
                    </li>
                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">{{ __('app.login') }}</a></li>
                        <li class="nav-item"><a class="btn btn-primary btn-sm px-3" href="{{ route('register') }}">{{ __('app.start_free') }}</a></li>
                    @else
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bi bi-shield-check me-1"></i>{{ __('app.admin_panel') }}</a></li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width:32px;height:32px;font-size:.85rem;background:#6366f1!important;">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                                {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>{{ __('app.my_dashboard') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>{{ __('app.profile') }}</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>{{ __('app.logout') }}</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        </div>
    @endif
    @if(session('error'))
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show"><i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        </div>
    @endif

    @yield('content')

    <footer class="py-5 mt-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <h5 class="text-white mb-3"><i class="bi bi-map-fill me-2" style="color:var(--primary,#6366f1)"></i>{{ __('app.site_name') }}</h5>
                    <p class="mb-0" style="font-size:.9rem;">{{ __('app.footer_desc') }}</p>
                </div>
                <div class="col-md-3">
                    <h6 class="text-white mb-3">{{ __('app.explore') }}</h6>
                    <ul class="list-unstyled" style="font-size:.9rem;">
                        <li><a href="{{ route('career-paths.index') }}" class="text-decoration-none" style="color:#94a3b8;">{{ __('app.career_paths') }}</a></li>
                        <li><a href="{{ route('about') }}" class="text-decoration-none" style="color:#94a3b8;">{{ __('app.about') }}</a></li>
                        <li><a href="{{ route('contact') }}" class="text-decoration-none" style="color:#94a3b8;">{{ __('app.contact') }}</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6 class="text-white mb-3">{{ __('app.account') }}</h6>
                    <ul class="list-unstyled" style="font-size:.9rem;">
                        @guest
                            <li><a href="{{ route('login') }}" class="text-decoration-none" style="color:#94a3b8;">{{ __('app.login') }}</a></li>
                            <li><a href="{{ route('register') }}" class="text-decoration-none" style="color:#94a3b8;">{{ __('app.register') }}</a></li>
                        @else
                            <li><a href="{{ route('dashboard') }}" class="text-decoration-none" style="color:#94a3b8;">{{ __('app.my_dashboard') }}</a></li>
                        @endguest
                    </ul>
                </div>
            </div>
            <hr style="border-color:rgba(255,255,255,.1);" class="my-4">
            <p class="text-center mb-0" style="font-size:.85rem;">{{ __('app.footer_copy', ['year' => date('Y')]) }}</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
