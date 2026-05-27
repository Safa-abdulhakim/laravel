<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Portfolio Admin</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
            --accent: #6366f1;
            --accent-light: #818cf8;
        }
        * { font-family: 'Inter', sans-serif; }
        body { background: #f1f5f9; min-height: 100vh; }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            min-height: 100vh;
            position: fixed;
            top: 0; left: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: transform .3s ease;
        }
        .sidebar-brand {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        .sidebar-brand h5 { color: #fff; font-weight: 700; margin: 0; font-size: 1.1rem; }
        .sidebar-brand small { color: var(--accent-light); font-size: .75rem; }

        .sidebar-nav { padding: 1rem 0; flex: 1; overflow-y: auto; }
        .nav-section-title {
            color: rgba(255,255,255,.35);
            font-size: .65rem;
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
            padding: .75rem 1.25rem .3rem;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,.65);
            padding: .6rem 1.25rem;
            border-radius: 0;
            display: flex;
            align-items: center;
            gap: .65rem;
            font-size: .875rem;
            transition: all .2s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background: var(--sidebar-hover);
            border-left: 3px solid var(--accent);
        }
        .sidebar .nav-link i { font-size: 1rem; width: 1.2rem; text-align: center; }
        .sidebar .nav-link .badge { margin-left: auto; }

        /* Topbar */
        .topbar {
            margin-left: var(--sidebar-width);
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: .75rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky; top: 0; z-index: 999;
            box-shadow: 0 1px 4px rgba(0,0,0,.06);
        }
        .topbar .page-title { font-weight: 600; font-size: 1rem; color: #0f172a; margin: 0; }

        /* Main content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 1.75rem;
            min-height: calc(100vh - 61px);
        }

        /* Cards */
        .stat-card {
            border: none;
            border-radius: 12px;
            transition: transform .2s, box-shadow .2s;
        }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,.1); }
        .stat-card .icon-box {
            width: 52px; height: 52px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
        }

        /* Tables */
        .table th { font-size: .75rem; font-weight: 600; text-transform: uppercase; letter-spacing: .04em; color: #64748b; }
        .table td { vertical-align: middle; font-size: .875rem; }

        /* Badges */
        .badge-status-featured { background: #fef3c7; color: #92400e; }
        .badge-status-active { background: #d1fae5; color: #065f46; }
        .badge-status-inactive { background: #fee2e2; color: #991b1b; }
        .badge-status-new { background: #dbeafe; color: #1e40af; }
        .badge-status-read { background: #f1f5f9; color: #475569; }
        .badge-status-replied { background: #d1fae5; color: #065f46; }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .topbar, .main-content { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <h5><i class="bi bi-code-slash me-2" style="color:var(--accent)"></i>Portfolio Admin</h5>
        <small>{{ auth()->user()->name }}</small>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section-title">Main</div>
        <a href="{{ route('admin.dashboard') }}"
           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="nav-section-title">Portfolio</div>
        <a href="{{ route('admin.projects.index') }}"
           class="nav-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
            <i class="bi bi-grid-3x3-gap"></i> Projects
        </a>
        <a href="{{ route('admin.skills.index') }}"
           class="nav-link {{ request()->routeIs('admin.skills.*') ? 'active' : '' }}">
            <i class="bi bi-lightning-charge"></i> Skills
        </a>
        <a href="{{ route('admin.experiences.index') }}"
           class="nav-link {{ request()->routeIs('admin.experiences.*') ? 'active' : '' }}">
            <i class="bi bi-briefcase"></i> Experience
        </a>
        <a href="{{ route('admin.certificates.index') }}"
           class="nav-link {{ request()->routeIs('admin.certificates.*') ? 'active' : '' }}">
            <i class="bi bi-award"></i> Certificates
        </a>
        <a href="{{ route('admin.cv.index') }}"
           class="nav-link {{ request()->routeIs('admin.cv.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-person"></i> CV / Resume
        </a>

        <div class="nav-section-title">Communication</div>
        <a href="{{ route('admin.messages.index') }}"
           class="nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
            <i class="bi bi-chat-dots"></i> Messages
            @php $newCount = \App\Models\Message::where('status','new')->count(); @endphp
            @if($newCount > 0)
                <span class="badge bg-danger rounded-pill">{{ $newCount }}</span>
            @endif
        </a>

        <div class="nav-section-title">Site</div>
        <a href="{{ route('home') }}" target="_blank" class="nav-link">
            <i class="bi bi-globe"></i> View Site
        </a>
        <a href="{{ route('admin.profile.edit') }}"
           class="nav-link {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
            <i class="bi bi-person-gear"></i> Profile
        </a>
    </nav>
    <div class="p-3 border-top border-secondary">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-sm w-100 text-start ps-2"
                    style="color:rgba(255,255,255,.5);background:none;border:none;">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </button>
        </form>
    </div>
</aside>

<!-- Topbar -->
<div class="topbar">
    <div class="d-flex align-items-center gap-3">
        <button class="btn btn-sm d-md-none" id="sidebarToggle"
                style="background:none;border:none;font-size:1.2rem;">
            <i class="bi bi-list"></i>
        </button>
        <h6 class="page-title">@yield('page-title', 'Dashboard')</h6>
    </div>
    <div class="d-flex align-items-center gap-2">
        <span class="text-muted small d-none d-md-block">{{ auth()->user()->name }}</span>
        <div class="rounded-circle bg-indigo d-flex align-items-center justify-content-center"
             style="width:34px;height:34px;background:var(--accent);color:#fff;font-weight:600;font-size:.85rem;">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="main-content">
    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
            <i class="bi bi-exclamation-circle-fill"></i>
            {{ session('error') }}
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Sidebar toggle on mobile
    document.getElementById('sidebarToggle')?.addEventListener('click', () => {
        document.getElementById('sidebar').classList.toggle('show');
    });
</script>
@stack('scripts')
</body>
</html>
