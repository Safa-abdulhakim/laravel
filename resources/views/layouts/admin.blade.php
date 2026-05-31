<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - CareerMap Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <style>
        :root { --primary: #6366f1; }
        body { background-color: #f1f5f9; font-family: 'Segoe UI', system-ui, sans-serif; }
        .sidebar { width: 250px; min-height: 100vh; background: #1e293b; position: fixed; top: 0; left: 0; z-index: 100; }
        .sidebar-brand { padding: 1.2rem 1.5rem; color: white; font-weight: 700; font-size: 1.1rem; border-bottom: 1px solid rgba(255,255,255,.08); display: flex; align-items: center; gap: .5rem; }
        .sidebar .nav-link { color: #94a3b8; padding: .65rem 1.2rem; border-radius: 8px; margin: 2px 8px; display: flex; align-items: center; gap: .6rem; font-size: .9rem; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: rgba(99,102,241,.25); color: #a5b4fc; }
        .sidebar .nav-section { color: #475569; font-size: .72rem; font-weight: 600; text-transform: uppercase; letter-spacing: .08em; padding: 1rem 1.2rem .4rem; }
        .main-content { margin-left: 250px; min-height: 100vh; }
        .top-bar { background: white; border-bottom: 1px solid #e2e8f0; padding: .75rem 1.5rem; display: flex; align-items: center; justify-content: space-between; }
        .card { border: none; box-shadow: 0 1px 3px rgba(0,0,0,.07); border-radius: 12px; }
        .stat-card { padding: 1.5rem; }
        .stat-card .icon { width: 52px; height: 52px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
        .btn-primary { background-color: var(--primary); border-color: var(--primary); }
        .table thead th { background: #f8fafc; font-size: .8rem; font-weight: 600; text-transform: uppercase; letter-spacing: .05em; color: #64748b; border-bottom: 2px solid #e2e8f0; }
        .badge { font-weight: 500; }
        .progress { height: 6px; border-radius: 10px; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-map-fill text-indigo-400" style="color:#818cf8;"></i>
            CareerMap Admin
        </div>
        <nav class="py-2">
            <div class="nav-section">Main</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <div class="nav-section">Content</div>
            <a href="{{ route('admin.career-paths.index') }}" class="nav-link {{ request()->routeIs('admin.career-paths.*') ? 'active' : '' }}">
                <i class="bi bi-map"></i> Career Paths
            </a>
            <a href="{{ route('admin.stages.index') }}" class="nav-link {{ request()->routeIs('admin.stages.*') ? 'active' : '' }}">
                <i class="bi bi-layers"></i> Stages
            </a>
            <a href="{{ route('admin.skills.index') }}" class="nav-link {{ request()->routeIs('admin.skills.*') ? 'active' : '' }}">
                <i class="bi bi-lightning"></i> Skills
            </a>
            <a href="{{ route('admin.resources.index') }}" class="nav-link {{ request()->routeIs('admin.resources.*') ? 'active' : '' }}">
                <i class="bi bi-book"></i> Resources
            </a>
            <div class="nav-section">Management</div>
            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Users
            </a>
            <div class="nav-section">System</div>
            <a href="{{ route('home') }}" class="nav-link">
                <i class="bi bi-globe"></i> View Site
            </a>
            <form method="POST" action="{{ route('logout') }}" class="px-2 mt-2">
                @csrf
                <button class="nav-link border-0 bg-transparent w-100 text-start" style="color:#f87171;">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </nav>
    </div>
    <div class="main-content">
        <div class="top-bar">
            <h6 class="mb-0 fw-semibold text-slate-700">@yield('page-title', 'Dashboard')</h6>
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted small">{{ auth()->user()->name }}</span>
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width:34px;height:34px;font-size:.85rem;background:#6366f1!important;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </div>
        <div class="p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show"><i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    @stack('scripts')
</body>
</html>
