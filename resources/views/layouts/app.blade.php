<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Career Roadmap Builder') - CareerMap</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <style>
        :root { --primary: #6366f1; --primary-dark: #4f46e5; }
        body { background-color: #f8fafc; font-family: 'Segoe UI', system-ui, sans-serif; }
        .navbar-brand { font-weight: 700; font-size: 1.4rem; }
        .btn-primary { background-color: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background-color: var(--primary-dark); border-color: var(--primary-dark); }
        .text-primary { color: var(--primary) !important; }
        .bg-primary { background-color: var(--primary) !important; }
        .progress { height: 8px; border-radius: 10px; }
        .card { border: none; box-shadow: 0 1px 3px rgba(0,0,0,.08); border-radius: 12px; }
        .card:hover { box-shadow: 0 4px 12px rgba(0,0,0,.12); transition: box-shadow .2s; }
        .badge-achievement { display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 20px; font-size: .85rem; }
        .navbar { background: white !important; box-shadow: 0 1px 3px rgba(0,0,0,.06); }
        .skill-card { transition: transform .15s; cursor: pointer; }
        .skill-card:hover { transform: translateY(-2px); }
        .sidebar { min-height: calc(100vh - 56px); background: #1e293b; }
        .sidebar .nav-link { color: #94a3b8; padding: .6rem 1rem; border-radius: 8px; margin: 2px 8px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: rgba(99,102,241,.2); color: #818cf8; }
        .sidebar .nav-link i { width: 20px; }
        .sidebar-brand { padding: 1.2rem; color: white; font-weight: 700; font-size: 1.1rem; border-bottom: 1px solid rgba(255,255,255,.08); }
        footer { background: #1e293b; color: #94a3b8; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand text-primary" href="{{ route('home') }}">
                <i class="bi bi-map-fill me-2"></i>CareerMap
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'fw-semibold text-primary' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('career-paths.*') ? 'fw-semibold text-primary' : '' }}" href="{{ route('career-paths.index') }}">Career Paths</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item ms-2"><a class="btn btn-primary btn-sm px-3" href="{{ route('register') }}">Get Started</a></li>
                    @else
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bi bi-shield-check me-1"></i>Admin</a></li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width:32px;height:32px;font-size:.8rem;">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                                {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
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
                    <h5 class="text-white mb-3"><i class="bi bi-map-fill me-2 text-primary"></i>CareerMap</h5>
                    <p class="mb-0" style="font-size:.9rem;">Build your career with structured roadmaps and track your progress step by step.</p>
                </div>
                <div class="col-md-3">
                    <h6 class="text-white mb-3">Explore</h6>
                    <ul class="list-unstyled" style="font-size:.9rem;">
                        <li><a href="{{ route('career-paths.index') }}" class="text-decoration-none" style="color:#94a3b8;">Career Paths</a></li>
                        <li><a href="{{ route('about') }}" class="text-decoration-none" style="color:#94a3b8;">About</a></li>
                    </ul>
                </div>
            </div>
            <hr style="border-color:rgba(255,255,255,.1);" class="my-4">
            <p class="text-center mb-0" style="font-size:.85rem;">© {{ date('Y') }} CareerMap. Built with Laravel.</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
