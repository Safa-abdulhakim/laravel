<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('admin.dashboard')) — {{ __('common.app_name') }} Admin</title>

    @if(app()->getLocale() === 'ar')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    @if(app()->getLocale() === 'ar')
    <style>body { font-family: 'Segoe UI', Tahoma, 'Arabic Typesetting', Arial, sans-serif; }</style>
    @endif

    <style>
        body { background-color: #f0f2f5; }
        .sidebar {
            width: 260px; min-height: 100vh; background: #1a1d23;
            position: fixed; top: 0; {{ app()->getLocale() === 'ar' ? 'right' : 'left' }}: 0;
            z-index: 1000; display: flex; flex-direction: column;
        }
        .sidebar-brand { padding: 1.5rem 1.25rem; border-bottom: 1px solid rgba(255,255,255,.08); }
        .sidebar-brand h5 { color: #fff; font-weight: 700; margin: 0; font-size: 1.1rem; }
        .sidebar-brand small { color: #6c757d; font-size: .75rem; }
        .sidebar-nav { padding: .75rem 0; flex: 1; }
        .sidebar-heading { color: #6c757d; font-size: .65rem; font-weight: 700; letter-spacing: .08em;
            text-transform: uppercase; padding: .75rem 1.25rem .25rem; }
        .sidebar-link {
            display: flex; align-items: center; gap: .75rem; padding: .65rem 1.25rem;
            color: #adb5bd; text-decoration: none; font-size: .875rem;
            border-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}: 3px solid transparent;
            transition: all .15s;
        }
        .sidebar-link:hover { color: #fff; background: rgba(255,255,255,.06); }
        .sidebar-link.active { color: #fff; background: rgba(13,110,253,.15); border-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}-color: #0d6efd; }
        .sidebar-link i { font-size: 1rem; width: 20px; text-align: center; }
        .sidebar-footer { padding: 1rem 1.25rem; border-top: 1px solid rgba(255,255,255,.08); }
        .main-content { margin-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}: 260px; min-height: 100vh; }
        .topbar { background: #fff; border-bottom: 1px solid #e9ecef; padding: .75rem 1.5rem;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 100; box-shadow: 0 1px 4px rgba(0,0,0,.06); }
        .page-content { padding: 1.5rem; }
        .stat-card { border: none; border-radius: .75rem; overflow: hidden; }
        @media (max-width: 991px) {
            .sidebar { transform: translateX({{ app()->getLocale() === 'ar' ? '100%' : '-100%' }}); transition: transform .3s; }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; margin-right: 0; }
        }
    </style>
    @yield('styles')
</head>
<body>

<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <h5><i class="bi bi-shop-window me-2 text-primary"></i>{{ __('common.app_name') }}</h5>
        <small>{{ __('admin.admin_panel') }}</small>
    </div>
    <nav class="sidebar-nav">
        <div class="sidebar-heading">{{ __('admin.dashboard') }}</div>
        <a class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-speedometer2"></i> {{ __('admin.dashboard') }}
        </a>
        <div class="sidebar-heading mt-2">{{ __('admin.products') }}</div>
        <a class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
            <i class="bi bi-box-seam"></i> {{ __('admin.products') }}
        </a>
        <div class="sidebar-heading mt-2">{{ __('admin.orders') }}</div>
        <a class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
            <i class="bi bi-receipt"></i> {{ __('admin.orders') }}
        </a>
        <div class="sidebar-heading mt-2">{{ __('common.shop') }}</div>
        <a class="sidebar-link" href="{{ route('home') }}" target="_blank">
            <i class="bi bi-shop"></i> {{ __('admin.view_store') }}
        </a>
    </nav>
    <div class="sidebar-footer">
        <div class="d-flex align-items-center gap-2">
            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;">
                <i class="bi bi-person-fill text-white"></i>
            </div>
            <div>
                <div class="text-white small fw-semibold">{{ auth()->user()->name }}</div>
                <div style="color:#6c757d;font-size:.7rem;">{{ __('admin.administrator') }}</div>
            </div>
        </div>
        <!-- Lang switch in sidebar -->
        <div class="d-flex gap-2 mt-2">
            <a href="{{ route('lang.switch', 'en') }}" class="btn btn-sm {{ app()->getLocale() === 'en' ? 'btn-primary' : 'btn-outline-secondary' }} flex-fill">EN</a>
            <a href="{{ route('lang.switch', 'ar') }}" class="btn btn-sm {{ app()->getLocale() === 'ar' ? 'btn-primary' : 'btn-outline-secondary' }} flex-fill">عربي</a>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="mt-2">
            @csrf
            <button class="btn btn-sm btn-outline-danger w-100">
                <i class="bi bi-box-arrow-right me-1"></i>{{ __('common.logout') }}
            </button>
        </form>
    </div>
</div>

<div class="main-content">
    <div class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm btn-outline-secondary d-lg-none" onclick="document.getElementById('sidebar').classList.toggle('show')">
                <i class="bi bi-list"></i>
            </button>
            <div>
                <h6 class="mb-0 fw-bold">@yield('page-title', __('admin.dashboard'))</h6>
                <small class="text-muted">@yield('page-subtitle', '')</small>
            </div>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="badge bg-warning text-dark"><i class="bi bi-shield-lock me-1"></i>{{ __('common.admin') }}</span>
        </div>
    </div>

    @if(session('success') || session('error'))
    <div class="page-content pb-0">
        @if(session('success'))<div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
        @if(session('error'))<div class="alert alert-danger alert-dismissible fade show"><i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
    </div>
    @endif

    <div class="page-content">@yield('content')</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
