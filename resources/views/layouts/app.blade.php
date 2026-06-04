<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="@yield('description', 'Professional Portfolio')">

    <!-- Fonts -->
    @if(app()->getLocale() === 'ar')
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    @else
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @endif

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --color-primary: #1E3A5F;
            --color-secondary: #6C63FF;
            --color-accent: #4F46E5;
            --color-bg: #F8FAFC;
            --color-surface: #FFFFFF;
            --color-card: #FFFFFF;
            --color-border: #E5E7EB;
            --color-heading: #111827;
            --color-body: #374151;
            --color-muted: #6B7280;
            --color-success: #10B981;
            --color-warning: #F59E0B;
            --color-danger: #EF4444;
        }
        .dark {
            --color-primary: #60A5FA;
            --color-secondary: #8B5CF6;
            --color-accent: #818CF8;
            --color-bg: #0F172A;
            --color-surface: #111827;
            --color-card: #1E293B;
            --color-border: #334155;
            --color-heading: #F8FAFC;
            --color-body: #E2E8F0;
            --color-muted: #94A3B8;
            --color-success: #34D399;
            --color-warning: #FBBF24;
            --color-danger: #F87171;
        }
        body {
            font-family: {{ app()->getLocale() === 'ar' ? "'Tajawal'" : "'Inter'" }}, sans-serif;
            background-color: var(--color-bg);
            color: var(--color-body);
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .text-heading { color: var(--color-heading); }
        .text-body { color: var(--color-body); }
        .text-muted { color: var(--color-muted); }
        .bg-surface { background-color: var(--color-surface); }
        .bg-card { background-color: var(--color-card); }
        .border-custom { border-color: var(--color-border); }
        .text-primary { color: var(--color-primary); }
        .text-secondary { color: var(--color-secondary); }
        .text-accent { color: var(--color-accent); }
        .bg-primary { background-color: var(--color-primary); }
        .bg-secondary { background-color: var(--color-secondary); }
        .bg-accent { background-color: var(--color-accent); }
        .btn-primary {
            background: linear-gradient(135deg, var(--color-accent), var(--color-secondary));
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(79, 70, 229, 0.4); }
        .btn-outline {
            border: 2px solid var(--color-accent);
            color: var(--color-accent);
            padding: 0.75rem 2rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-outline:hover { background-color: var(--color-accent); color: white; transform: translateY(-2px); }
        .card {
            background-color: var(--color-card);
            border: 1px solid var(--color-border);
            border-radius: 1rem;
            transition: all 0.3s ease;
        }
        .card:hover { box-shadow: 0 20px 40px rgba(0,0,0,0.1); transform: translateY(-4px); }
        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--color-heading);
            text-align: center;
            margin-bottom: 1rem;
        }
        .section-subtitle {
            font-size: 1.125rem;
            color: var(--color-muted);
            text-align: center;
            margin-bottom: 3rem;
        }
        .gradient-text {
            background: linear-gradient(135deg, var(--color-accent), var(--color-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .glass {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }
        .dark .glass {
            background: rgba(0,0,0,0.2);
            border-color: rgba(255,255,255,0.1);
        }
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .skill-bar {
            height: 8px;
            border-radius: 4px;
            background-color: var(--color-border);
            overflow: hidden;
        }
        .skill-bar-fill {
            height: 100%;
            border-radius: 4px;
            background: linear-gradient(90deg, var(--color-accent), var(--color-secondary));
            transition: width 1.5s ease-in-out;
        }
        section { padding: 5rem 0; }
        .navbar-blur {
            background: rgba(248, 250, 252, 0.9);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--color-border);
        }
        .dark .navbar-blur {
            background: rgba(15, 23, 42, 0.9);
        }
        @media (prefers-reduced-motion: no-preference) {
            .fade-in {
                opacity: 0;
                transform: translateY(20px);
                transition: opacity 0.6s ease, transform 0.6s ease;
            }
            .fade-in.visible {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: {{ app()->getLocale() === 'ar' ? 'auto' : '-2.5rem' }};
            right: {{ app()->getLocale() === 'ar' ? '-2.5rem' : 'auto' }};
            top: 1.5rem;
            width: 1rem;
            height: 1rem;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--color-accent), var(--color-secondary));
            box-shadow: 0 0 0 4px var(--color-bg);
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen" style="background-color: var(--color-bg);">

    {{-- Navbar --}}
    @include('components.navbar')

    {{-- Flash Messages --}}
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
         class="fixed top-20 right-4 z-50 px-6 py-4 rounded-xl shadow-lg text-white font-medium"
         style="background: var(--color-success);">
        <div class="flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    </div>
    @endif

    @if(session('error'))
    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
         class="fixed top-20 right-4 z-50 px-6 py-4 rounded-xl shadow-lg text-white font-medium"
         style="background: var(--color-danger);">
        <div class="flex items-center gap-2">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    </div>
    @endif

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('components.footer')

    <script>
        // Intersection Observer for fade-in animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));

        // Counter animation
        function animateCounter(el) {
            const target = parseInt(el.getAttribute('data-target'));
            const duration = 2000;
            const step = target / (duration / 16);
            let current = 0;
            const timer = setInterval(() => {
                current += step;
                if (current >= target) {
                    el.textContent = target;
                    clearInterval(timer);
                } else {
                    el.textContent = Math.floor(current);
                }
            }, 16);
        }

        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        });
        document.querySelectorAll('[data-target]').forEach(el => counterObserver.observe(el));
    </script>
    @stack('scripts')
</body>
</html>
