<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', sidebarOpen: window.innerWidth >= 1024 }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('dashboard.title')) - Admin</title>
    @if(app()->getLocale() === 'ar')
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    @else
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --color-primary: #1E3A5F; --color-secondary: #6C63FF; --color-accent: #4F46E5;
            --color-bg: #F8FAFC; --color-surface: #FFFFFF; --color-card: #FFFFFF;
            --color-border: #E5E7EB; --color-heading: #111827; --color-body: #374151;
            --color-muted: #6B7280; --color-success: #10B981; --color-warning: #F59E0B;
            --color-danger: #EF4444;
        }
        .dark {
            --color-primary: #60A5FA; --color-secondary: #8B5CF6; --color-accent: #818CF8;
            --color-bg: #0F172A; --color-surface: #111827; --color-card: #1E293B;
            --color-border: #334155; --color-heading: #F8FAFC; --color-body: #E2E8F0;
            --color-muted: #94A3B8; --color-success: #34D399; --color-warning: #FBBF24;
            --color-danger: #F87171;
        }
        body {
            font-family: {{ app()->getLocale() === 'ar' ? "'Tajawal'" : "'Inter'" }}, sans-serif;
            background-color: var(--color-bg);
            color: var(--color-body);
        }
        .sidebar { background: var(--color-surface); border-color: var(--color-border); transition: all 0.3s; }
        .nav-item { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: 0.75rem; font-weight: 500; transition: all 0.2s; color: var(--color-muted); }
        .nav-item:hover { background: rgba(79, 70, 229, 0.08); color: var(--color-accent); }
        .nav-item.active { background: rgba(79, 70, 229, 0.12); color: var(--color-accent); }
        .admin-card { background: var(--color-card); border: 1px solid var(--color-border); border-radius: 1rem; }
        .btn-primary { background: linear-gradient(135deg, var(--color-accent), var(--color-secondary)); color: white; padding: 0.6rem 1.25rem; border-radius: 0.6rem; font-weight: 600; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.5rem; }
        .btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-danger { background: var(--color-danger); color: white; padding: 0.6rem 1.25rem; border-radius: 0.6rem; font-weight: 600; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.5rem; }
        .btn-danger:hover { opacity: 0.9; }
        .btn-secondary { background: var(--color-border); color: var(--color-body); padding: 0.6rem 1.25rem; border-radius: 0.6rem; font-weight: 600; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.5rem; }
        .form-input { width: 100%; padding: 0.6rem 1rem; border-radius: 0.6rem; outline: none; background: var(--color-bg); border: 1px solid var(--color-border); color: var(--color-body); }
        .form-input:focus { border-color: var(--color-accent); }
        .gradient-text { background: linear-gradient(135deg, var(--color-accent), var(--color-secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        table { width: 100%; border-collapse: collapse; }
        thead th { padding: 0.875rem 1rem; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }}; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-muted); background: var(--color-bg); border-bottom: 1px solid var(--color-border); }
        tbody td { padding: 1rem; border-bottom: 1px solid var(--color-border); vertical-align: middle; }
        tbody tr:hover { background: rgba(0,0,0,0.02); }
        .dark tbody tr:hover { background: rgba(255,255,255,0.02); }
    </style>
</head>
<body>
<div class="flex h-screen overflow-hidden">
    {{-- Sidebar --}}
    <aside class="sidebar border-e flex flex-col w-64 flex-shrink-0 overflow-y-auto z-40"
           :class="{ '-translate-x-full lg:translate-x-0': !sidebarOpen, 'translate-x-0': sidebarOpen }"
           style="position: fixed; top: 0; {{ app()->getLocale() === 'ar' ? 'right: 0;' : 'left: 0;' }} height: 100%; z-index: 40;">
        {{-- Logo --}}
        <div class="px-4 py-5 border-b" style="border-color: var(--color-border);">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-white"
                     style="background: linear-gradient(135deg, var(--color-accent), var(--color-secondary));">
                    A
                </div>
                <div>
                    <div class="font-bold text-sm" style="color: var(--color-heading);">Admin Panel</div>
                    <div class="text-xs" style="color: var(--color-muted);">Portfolio CMS</div>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-3 py-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home w-4"></i> {{ __('dashboard.overview') }}
            </a>
            <div class="pt-3 pb-1 px-2 text-xs font-semibold uppercase tracking-wider" style="color: var(--color-muted);">Content</div>
            <a href="{{ route('admin.projects.index') }}" class="nav-item {{ request()->routeIs('admin.projects*') ? 'active' : '' }}">
                <i class="fas fa-code w-4"></i> {{ __('dashboard.manage_projects') }}
            </a>
            <a href="{{ route('admin.skills.index') }}" class="nav-item {{ request()->routeIs('admin.skills*') ? 'active' : '' }}">
                <i class="fas fa-star w-4"></i> {{ __('dashboard.manage_skills') }}
            </a>
            <a href="{{ route('admin.experiences.index') }}" class="nav-item {{ request()->routeIs('admin.experiences*') ? 'active' : '' }}">
                <i class="fas fa-briefcase w-4"></i> {{ __('dashboard.manage_experiences') }}
            </a>
            <a href="{{ route('admin.certificates.index') }}" class="nav-item {{ request()->routeIs('admin.certificates*') ? 'active' : '' }}">
                <i class="fas fa-certificate w-4"></i> {{ __('dashboard.manage_certificates') }}
            </a>
            <a href="{{ route('admin.testimonials.index') }}" class="nav-item {{ request()->routeIs('admin.testimonials*') ? 'active' : '' }}">
                <i class="fas fa-quote-right w-4"></i> {{ __('dashboard.manage_testimonials') }}
            </a>
            <div class="pt-3 pb-1 px-2 text-xs font-semibold uppercase tracking-wider" style="color: var(--color-muted);">System</div>
            <a href="{{ route('admin.messages.index') }}" class="nav-item {{ request()->routeIs('admin.messages*') ? 'active' : '' }}">
                <i class="fas fa-envelope w-4"></i>
                {{ __('dashboard.manage_messages') }}
                @php $unread = \App\Models\Message::where('is_read', false)->count(); @endphp
                @if($unread > 0)
                <span class="ms-auto px-2 py-0.5 rounded-full text-xs font-bold text-white" style="background: var(--color-danger);">{{ $unread }}</span>
                @endif
            </a>
            <a href="{{ route('admin.cv.index') }}" class="nav-item {{ request()->routeIs('admin.cv*') ? 'active' : '' }}">
                <i class="fas fa-file-pdf w-4"></i> {{ __('dashboard.manage_cv') }}
            </a>
            <a href="{{ route('admin.settings.index') }}" class="nav-item {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                <i class="fas fa-cog w-4"></i> {{ __('dashboard.manage_settings') }}
            </a>
        </nav>

        {{-- Footer --}}
        <div class="p-4 border-t" style="border-color: var(--color-border);">
            <a href="{{ route('home') }}" class="nav-item mb-2">
                <i class="fas fa-globe w-4"></i> {{ __('dashboard.view_site') }}
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-item w-full" style="color: var(--color-danger);">
                    <i class="fas fa-sign-out-alt w-4"></i> {{ __('navigation.logout') }}
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col overflow-hidden {{ app()->getLocale() === 'ar' ? 'lg:mr-64' : 'lg:ml-64' }}">
        {{-- Top Bar --}}
        <header class="h-14 flex items-center justify-between px-4 border-b flex-shrink-0"
                style="background: var(--color-surface); border-color: var(--color-border);">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = !sidebarOpen"
                        class="lg:hidden w-9 h-9 rounded-lg flex items-center justify-center"
                        style="border: 1px solid var(--color-border); color: var(--color-body);">
                    <i class="fas fa-bars text-sm"></i>
                </button>
                <h1 class="font-bold text-lg" style="color: var(--color-heading);">@yield('page-title', __('dashboard.title'))</h1>
            </div>
            <div class="flex items-center gap-3">
                {{-- Language --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center gap-1.5 text-sm px-3 py-1.5 rounded-lg"
                            style="border: 1px solid var(--color-border); color: var(--color-muted);">
                        <i class="fas fa-globe text-xs"></i>
                        {{ app()->getLocale() === 'ar' ? 'عربي' : 'EN' }}
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition
                         class="absolute top-full mt-1 right-0 rounded-xl shadow-xl py-1 min-w-[120px] z-50"
                         style="background: var(--color-card); border: 1px solid var(--color-border);">
                        <a href="{{ route('language.switch', 'en') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm" style="color: var(--color-body);">🇺🇸 English</a>
                        <a href="{{ route('language.switch', 'ar') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm" style="color: var(--color-body);">🇸🇦 العربية</a>
                    </div>
                </div>
                {{-- Dark Mode --}}
                <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)"
                        class="w-9 h-9 rounded-lg flex items-center justify-center"
                        style="border: 1px solid var(--color-border); color: var(--color-muted);">
                    <i x-show="!darkMode" class="fas fa-moon text-sm"></i>
                    <i x-show="darkMode" class="fas fa-sun text-sm" style="color: var(--color-warning);"></i>
                </button>
                {{-- User --}}
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-sm font-bold"
                         style="background: linear-gradient(135deg, var(--color-accent), var(--color-secondary));">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <span class="hidden md:block text-sm font-medium" style="color: var(--color-heading);">{{ auth()->user()->name }}</span>
                </div>
            </div>
        </header>

        {{-- Flash Messages --}}
        @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)"
             class="mx-4 mt-4 px-4 py-3 rounded-xl text-white text-sm font-medium flex items-center gap-2"
             style="background: var(--color-success);">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)"
             class="mx-4 mt-4 px-4 py-3 rounded-xl text-white text-sm font-medium flex items-center gap-2"
             style="background: var(--color-danger);">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
        @endif

        {{-- Page Content --}}
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>
    </div>
</div>

{{-- Overlay for mobile sidebar --}}
<div x-show="sidebarOpen" @click="sidebarOpen = false"
     class="lg:hidden fixed inset-0 z-30" style="background: rgba(0,0,0,0.5);"
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"></div>

@stack('scripts')
</body>
</html>
