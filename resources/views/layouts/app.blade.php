<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - @yield('title', __('app.dashboard'))</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @if(app()->getLocale() === 'ar')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
    @endif
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 260px;
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --sidebar-bg: #1e1b4b;
            --sidebar-text: #c7d2fe;
            --sidebar-active: #4f46e5;
        }
        * {
            font-family: {{ app()->getLocale() === 'ar' ? "'Cairo'" : "'Inter'" }}, sans-serif;
        }
        body { background: #f1f5f9; }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0;
            {{ app()->getLocale() === 'ar' ? 'right: 0;' : 'left: 0;' }}
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
            box-shadow: {{ app()->getLocale() === 'ar' ? '-4px' : '4px' }} 0 20px rgba(0,0,0,0.15);
        }
        .sidebar-brand { padding: 1.25rem 1rem; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-brand h5 { color: #fff; font-weight: 800; margin: 0; font-size: 1rem; }
        .sidebar-brand small { color: var(--sidebar-text); font-size: 0.72rem; }
        .sidebar-nav { flex: 1; padding: 0.75rem 0; overflow-y: auto; }
        .sidebar-section-title {
            color: #818cf8;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 0.75rem 1rem 0.25rem;
        }
        .sidebar-nav .nav-link {
            color: var(--sidebar-text);
            padding: 0.55rem 1rem;
            display: flex; align-items: center; gap: 0.65rem;
            font-size: 0.875rem; font-weight: 500;
            transition: all 0.2s;
            margin: 0.1rem 0.5rem; border-radius: 0.5rem;
        }
        .sidebar-nav .nav-link:hover { background: rgba(99,102,241,0.2); color: #fff; }
        .sidebar-nav .nav-link.active { background: var(--sidebar-active); color: #fff; }
        .sidebar-nav .nav-link i { font-size: 1.05rem; width: 1.2rem; text-align: center; }
        .sidebar-footer { padding: 0.85rem; border-top: 1px solid rgba(255,255,255,0.1); }

        /* Main */
        .main-content {
            {{ app()->getLocale() === 'ar' ? 'margin-right' : 'margin-left' }}: var(--sidebar-width);
            min-height: 100vh; display: flex; flex-direction: column;
        }
        .topbar {
            background: #fff; padding: 0.7rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 100;
            box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        }
        .page-content { padding: 1.5rem; flex: 1; }

        /* Cards */
        .stat-card { border: none; border-radius: 1rem; box-shadow: 0 1px 4px rgba(0,0,0,0.08); }
        .stat-card .icon-box {
            width: 3rem; height: 3rem; border-radius: 0.75rem;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; flex-shrink: 0;
        }
        .table-card { border: none; border-radius: 1rem; box-shadow: 0 1px 4px rgba(0,0,0,0.08); overflow: hidden; }
        .card-header { background: #fff; border-bottom: 1px solid #f1f5f9; }

        /* Table */
        .table thead th {
            background: #f8fafc; font-size: 0.78rem; font-weight: 600;
            color: #64748b; border-bottom: 2px solid #e2e8f0;
            padding: 0.75rem 1rem; white-space: nowrap;
        }
        .table tbody td { padding: 0.7rem 1rem; vertical-align: middle; }
        .table-hover tbody tr:hover { background: #f8fafc; }

        /* Badges */
        .badge-stock-in  { background: #dcfce7; color: #166534; font-size: 0.75rem; }
        .badge-stock-out { background: #fee2e2; color: #991b1b; font-size: 0.75rem; }
        .badge-adjustment{ background: #fef9c3; color: #854d0e; font-size: 0.75rem; }

        /* Buttons & Forms */
        .btn-primary { background-color: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background-color: var(--primary-dark); border-color: var(--primary-dark); }
        .form-control:focus, .form-select:focus { border-color: var(--primary); box-shadow: 0 0 0 0.2rem rgba(79,70,229,0.15); }

        /* Language toggle button */
        .lang-btn {
            border: 2px solid #4f46e5; color: #4f46e5; background: transparent;
            border-radius: 2rem; padding: 0.2rem 0.85rem;
            font-size: 0.78rem; font-weight: 700; transition: all 0.2s;
            text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;
        }
        .lang-btn:hover { background: #4f46e5; color: #fff; }

        /* Alerts */
        .alert { border: none; border-radius: 0.75rem; }
        .alert-success { background: #dcfce7; color: #166534; }
        .alert-danger  { background: #fee2e2; color: #991b1b; }
        .alert-warning { background: #fef9c3; color: #854d0e; }

        /* Responsive */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: {{ app()->getLocale() === 'ar' ? 'translateX(100%)' : 'translateX(-100%)' }};
            }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-right: 0 !important; margin-left: 0 !important; }
        }
        .pagination { direction: {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}; }
    </style>
    @stack('styles')
</head>
<body>

{{-- Sidebar --}}
<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="d-flex align-items-center gap-2">
            <div style="width:38px;height:38px;background:var(--sidebar-active);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi bi-boxes text-white" style="font-size:1.1rem;"></i>
            </div>
            <div>
                <h5>{{ app()->getLocale() === 'ar' ? 'مخزن برو' : 'InventoryPro' }}</h5>
                <small>{{ app()->getLocale() === 'ar' ? 'نظام المبيعات والمخزون' : 'Smart Sales & Inventory' }}</small>
            </div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="sidebar-section-title">{{ app()->getLocale() === 'ar' ? 'الرئيسية' : 'Main' }}</div>
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> {{ __('app.dashboard') }}
        </a>

        <div class="sidebar-section-title">{{ app()->getLocale() === 'ar' ? 'المخزون' : 'Inventory' }}</div>
        <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i> {{ __('app.products') }}
        </a>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
            <i class="bi bi-tag"></i> {{ __('app.categories') }}
        </a>
        @endif
        <a href="{{ route('inventory.index') }}" class="nav-link {{ request()->routeIs('inventory.*') ? 'active' : '' }}">
            <i class="bi bi-clipboard-data"></i> {{ __('app.stock_logs') }}
        </a>

        <div class="sidebar-section-title">{{ app()->getLocale() === 'ar' ? 'المبيعات' : 'Sales' }}</div>
        <a href="{{ route('sales.create') }}" class="nav-link {{ request()->routeIs('sales.create') ? 'active' : '' }}">
            <i class="bi bi-plus-circle"></i> {{ __('app.new_sale') }}
        </a>
        <a href="{{ route('sales.index') }}" class="nav-link {{ request()->routeIs('sales.index') || request()->routeIs('sales.show') ? 'active' : '' }}">
            <i class="bi bi-receipt"></i> {{ __('app.sales_history') }}
        </a>

        <div class="sidebar-section-title">{{ app()->getLocale() === 'ar' ? 'العملاء' : 'Customers' }}</div>
        <a href="{{ route('customers.index') }}" class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> {{ __('app.customers') }}
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="d-flex align-items-center gap-2 mb-2">
            <div style="width:34px;height:34px;background:rgba(99,102,241,0.35);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi bi-person text-white" style="font-size:0.95rem;"></i>
            </div>
            <div>
                <div style="color:#fff;font-size:0.82rem;font-weight:600;">{{ auth()->user()->name }}</div>
                <span class="badge" style="background:rgba(99,102,241,0.4);color:#c7d2fe;font-size:0.65rem;padding:2px 6px;">
                    {{ auth()->user()->isAdmin() ? __('app.admin') : __('app.staff') }}
                </span>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-sm w-100" style="background:rgba(255,255,255,0.1);color:var(--sidebar-text);font-size:0.82rem;">
                <i class="bi bi-box-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} me-1"></i> {{ __('app.logout') }}
            </button>
        </form>
    </div>
</div>

{{-- Main Content --}}
<div class="main-content">
    <div class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-light btn-sm d-lg-none" id="sidebarToggle">
                <i class="bi bi-list fs-5"></i>
            </button>
            <h6 class="mb-0 fw-bold">@yield('title', __('app.dashboard'))</h6>
        </div>
        <div class="d-flex align-items-center gap-2">
            {{-- Low Stock Alert --}}
            @php $lowStockCount = \App\Models\Product::whereRaw('quantity <= low_stock_threshold')->where('quantity', '>', 0)->count(); @endphp
            @if($lowStockCount > 0)
            <a href="{{ route('products.index') }}" class="btn btn-sm btn-warning position-relative" title="{{ __('app.low_stock_count', ['count' => $lowStockCount]) }}">
                <i class="bi bi-exclamation-triangle"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.6rem;">
                    {{ $lowStockCount }}
                </span>
            </a>
            @endif

            {{-- Language Toggle --}}
            @if(app()->getLocale() === 'ar')
            <a href="{{ route('lang.switch', 'en') }}" class="lang-btn">
                <i class="bi bi-translate"></i> English
            </a>
            @else
            <a href="{{ route('lang.switch', 'ar') }}" class="lang-btn">
                <i class="bi bi-translate"></i> العربية
            </a>
            @endif

            <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-light">
                <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
            </a>
        </div>
    </div>

    <div class="page-content">
        {{-- Flash Messages --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3">
            <i class="bi bi-x-circle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-3">
            <i class="bi bi-exclamation-circle-fill me-2"></i>
            <strong>{{ __('app.fix_errors') }}</strong>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('sidebarToggle')?.addEventListener('click', () => {
        document.getElementById('sidebar').classList.toggle('show');
    });
</script>
@stack('scripts')
</body>
</html>
