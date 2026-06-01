<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('nav_dashboard')) - {{ __('site_name') }}</title>
    @if(app()->getLocale() === 'ar')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @endif
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --primary:#7c3aed;--primary-dark:#4f46e5;--secondary:#06b6d4;--dark:#0f172a;--darker:#020617;--card-bg:#1e293b;--border:#334155;--sidebar-width:260px; }
        * { font-family:'Inter',sans-serif; }
        html[lang="ar"] * { font-family: 'Cairo', sans-serif; }
        body { background:var(--dark);color:#e2e8f0;margin:0; }

        .sidebar { position:fixed;top:0;left:0;height:100vh;width:var(--sidebar-width);background:var(--darker);border-right:1px solid var(--border);z-index:1000;overflow-y:auto;transition:transform 0.3s; }
        .sidebar-header { padding:24px 20px;border-bottom:1px solid var(--border); }
        .sidebar-brand { font-weight:800;font-size:1.1rem;background:linear-gradient(135deg,#7c3aed,#06b6d4);-webkit-background-clip:text;-webkit-text-fill-color:transparent; }
        .sidebar-nav { padding:16px 12px; }
        .sidebar-section { font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#475569;padding:8px 8px 4px;margin-top:8px; }
        .sidebar-link { display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:10px;color:#94a3b8;text-decoration:none;font-size:0.9rem;font-weight:500;transition:all 0.2s;margin-bottom:2px; }
        .sidebar-link:hover { background:rgba(124,58,237,0.1);color:#a78bfa; }
        .sidebar-link.active { background:rgba(124,58,237,0.15);color:#7c3aed;border-left:3px solid #7c3aed; }
        .sidebar-link i { font-size:1.1rem;width:20px;text-align:center; }

        .topbar { position:fixed;top:0;left:var(--sidebar-width);right:0;height:64px;background:rgba(2,6,23,0.9);backdrop-filter:blur(10px);border-bottom:1px solid var(--border);z-index:999;display:flex;align-items:center;padding:0 24px;justify-content:space-between; }
        .main-content { margin-left:var(--sidebar-width);padding-top:64px;min-height:100vh; }
        .content-area { padding:32px 24px; }

        .card-dark { background:var(--card-bg);border:1px solid var(--border);border-radius:16px; }
        .stat-widget { background:var(--card-bg);border:1px solid var(--border);border-radius:16px;padding:24px; }
        .stat-icon { width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.4rem; }
        .stat-value { font-size:2rem;font-weight:800;line-height:1; }
        .stat-label { font-size:0.8rem;color:#94a3b8;margin-top:4px; }

        .btn-gradient { background:linear-gradient(135deg,#7c3aed,#4f46e5);border:none;color:white;font-weight:600;border-radius:10px;transition:all 0.3s; }
        .btn-gradient:hover { transform:translateY(-1px);box-shadow:0 8px 20px rgba(124,58,237,0.4);color:white; }

        .table-dark-custom { background:transparent; }
        .table-dark-custom thead th { background:rgba(124,58,237,0.1);color:#a78bfa;border-color:var(--border);font-size:0.8rem;text-transform:uppercase;letter-spacing:0.5px; }
        .table-dark-custom tbody td { border-color:var(--border);color:#e2e8f0;vertical-align:middle; }
        .table-dark-custom tbody tr:hover { background:rgba(124,58,237,0.05); }

        .platform-badge { font-size:0.7rem;font-weight:700;padding:4px 10px;border-radius:20px;text-transform:uppercase;letter-spacing:0.5px; }
        .platform-chatgpt { background:rgba(16,163,127,0.15);color:#10a37f;border:1px solid rgba(16,163,127,0.3); }
        .platform-claude { background:rgba(212,137,76,0.15);color:#d4894c;border:1px solid rgba(212,137,76,0.3); }
        .platform-gemini { background:rgba(66,133,244,0.15);color:#4285f4;border:1px solid rgba(66,133,244,0.3); }
        .platform-midjourney { background:rgba(124,58,237,0.15);color:#a78bfa;border:1px solid rgba(124,58,237,0.3); }
        .platform-other { background:rgba(148,163,184,0.15);color:#94a3b8;border:1px solid rgba(148,163,184,0.3); }

        .badge-public { background:rgba(16,185,129,0.15);color:#10b981;border:1px solid rgba(16,185,129,0.3); }
        .badge-private { background:rgba(239,68,68,0.15);color:#f87171;border:1px solid rgba(239,68,68,0.3); }

        .form-control-dark, .form-select-dark { background:#0f172a;border:2px solid var(--border);color:#e2e8f0;border-radius:10px;padding:10px 14px; }
        .form-control-dark:focus, .form-select-dark:focus { border-color:#7c3aed;box-shadow:0 0 0 4px rgba(124,58,237,0.1);background:#0f172a;color:#e2e8f0; }
        .form-control-dark::placeholder { color:#475569; }
        .form-label { color:#94a3b8;font-size:0.85rem;font-weight:500;margin-bottom:6px; }

        .alert-success { background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.3);color:#10b981;border-radius:10px; }
        .alert-danger { background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);color:#f87171;border-radius:10px; }

        .pagination .page-link { background:var(--card-bg);border-color:var(--border);color:#94a3b8; }
        .pagination .page-link:hover { background:rgba(124,58,237,0.2);border-color:#7c3aed;color:#a78bfa; }
        .pagination .active .page-link { background:#7c3aed;border-color:#7c3aed; }

        html[dir="rtl"] .sidebar { left: auto; right: 0; border-right: none; border-left: 1px solid var(--border); }
        html[dir="rtl"] .topbar { left: 0; right: var(--sidebar-width); }
        html[dir="rtl"] .main-content { margin-left: 0; margin-right: var(--sidebar-width); }
        html[dir="rtl"] .sidebar-link { border-left: none; }
        html[dir="rtl"] .sidebar-link.active { border-left: none; border-right: 3px solid #7c3aed; }
        html[dir="rtl"] .me-1, html[dir="rtl"] .me-2, html[dir="rtl"] .me-3 { margin-right: 0 !important; }
        html[dir="rtl"] .ms-auto { margin-left: 0 !important; margin-right: auto !important; }
        html[dir="rtl"] .ms-2 { margin-left: 0 !important; margin-right: 0.5rem !important; }
        html[dir="rtl"] .text-end { text-align: left !important; }
        html[dir="rtl"] .text-start { text-align: right !important; }
        @media(max-width:768px){
            .sidebar{transform:translateX(-100%)}
            .main-content{margin-left:0}
            .topbar{left:0}
            html[dir="rtl"] .sidebar{transform:translateX(100%)}
            html[dir="rtl"] .main-content{margin-right:0}
            html[dir="rtl"] .topbar{right:0}
        }
    </style>
    @stack('styles')
</head>
<body>
    {{-- Sidebar --}}
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('home') }}" class="sidebar-brand text-decoration-none">
                <i class="bi bi-lightning-charge-fill me-2" style="color:#7c3aed;-webkit-text-fill-color:#7c3aed"></i>
                {{ __('site_name') }}
            </a>
            @if(auth()->user()->isAdmin())
                <div class="mt-2">
                    <span class="badge" style="background:rgba(245,158,11,0.15);color:#f59e0b;border:1px solid rgba(245,158,11,0.3);font-size:0.7rem">
                        <i class="bi bi-shield-check me-1"></i>{{ __('administrator_label') }}
                    </span>
                </div>
            @endif
        </div>
        <nav class="sidebar-nav">
            {{-- User Section --}}
            <p class="sidebar-section">{{ __('sidebar_user') }}</p>
            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i> {{ __('nav_dashboard') }}
            </a>
            <a href="{{ route('my-prompts.index') }}" class="sidebar-link {{ request()->routeIs('my-prompts.*') ? 'active' : '' }}">
                <i class="bi bi-collection"></i> {{ __('nav_my_prompts') }}
            </a>
            <a href="{{ route('my-prompts.create') }}" class="sidebar-link {{ request()->routeIs('my-prompts.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle"></i> {{ __('nav_new_prompt') }}
            </a>
            <a href="{{ route('favorites.index') }}" class="sidebar-link {{ request()->routeIs('favorites.*') ? 'active' : '' }}">
                <i class="bi bi-heart"></i> {{ __('nav_favorites') }}
            </a>

            {{-- Browse --}}
            <p class="sidebar-section">{{ __('sidebar_browse') }}</p>
            <a href="{{ route('prompts.index') }}" class="sidebar-link">
                <i class="bi bi-compass"></i> {{ __('nav_explore_prompts') }}
            </a>
            <a href="{{ route('categories.index') }}" class="sidebar-link">
                <i class="bi bi-folder2"></i> {{ __('nav_categories') }}
            </a>

            @if(auth()->user()->isAdmin())
            {{-- Admin Section --}}
            <p class="sidebar-section">{{ __('sidebar_admin_panel') }}</p>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> {{ __('admin_dashboard_title') }}
            </a>
            <a href="{{ route('admin.prompts.index') }}" class="sidebar-link {{ request()->routeIs('admin.prompts.*') ? 'active' : '' }}">
                <i class="bi bi-collection-fill"></i> {{ __('all_prompts_title') }}
            </a>
            <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="bi bi-folder-fill"></i> {{ __('nav_categories') }}
            </a>
            <a href="{{ route('admin.tags.index') }}" class="sidebar-link {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}">
                <i class="bi bi-tags-fill"></i> {{ __('total_tags_stat') }}
            </a>
            <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> {{ __('users_page_title') }}
            </a>
            @endif

            {{-- Account --}}
            <p class="sidebar-section">{{ __('sidebar_account') }}</p>
            <a href="{{ route('profile.edit') }}" class="sidebar-link">
                <i class="bi bi-person-gear"></i> {{ __('nav_profile_settings') }}
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-link border-0 w-100 text-start" style="background:transparent">
                    <i class="bi bi-box-arrow-right" style="color:#ef4444"></i> <span style="color:#94a3b8">{{ __('nav_logout') }}</span>
                </button>
            </form>
        </nav>
    </aside>

    {{-- Topbar --}}
    <header class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-link d-md-none p-0" onclick="document.getElementById('sidebar').classList.toggle('show')">
                <i class="bi bi-list fs-4 text-light"></i>
            </button>
            <h6 class="mb-0 fw-semibold text-light">@yield('page-title', __('nav_dashboard'))</h6>
        </div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('my-prompts.create') }}" class="btn btn-gradient btn-sm d-none d-md-block">
                <i class="bi bi-plus me-1"></i>{{ __('nav_new_prompt') }}
            </a>
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:linear-gradient(135deg,#7c3aed,#4f46e5)">
                    <span class="text-white fw-bold" style="font-size:0.85rem">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</span>
                </div>
                <span class="d-none d-md-block text-light small">{{ auth()->user()->name }}</span>
            </div>
            @if(app()->getLocale() === 'ar')
                <a href="{{ route('language.switch', 'en') }}" class="btn btn-sm d-none d-md-flex align-items-center gap-1"
                    style="background:rgba(148,163,184,0.1);color:#94a3b8;border:1px solid #334155;border-radius:8px;font-size:0.8rem">
                    🇬🇧 EN
                </a>
            @else
                <a href="{{ route('language.switch', 'ar') }}" class="btn btn-sm d-none d-md-flex align-items-center gap-1"
                    style="background:rgba(148,163,184,0.1);color:#94a3b8;border:1px solid #334155;border-radius:8px;font-size:0.8rem">
                    🇸🇦 AR
                </a>
            @endif
        </div>
    </header>

    {{-- Main Content --}}
    <main class="main-content">
        <div class="content-area">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4">
                    <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    @stack('scripts')
</body>
</html>
