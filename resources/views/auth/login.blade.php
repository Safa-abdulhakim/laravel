<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"
      x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin Panel</title>
    @if(app()->getLocale() === 'ar')
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    @else
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --color-accent: #4F46E5; --color-secondary: #6C63FF;
            --color-bg: #F8FAFC; --color-surface: #FFFFFF; --color-card: #FFFFFF;
            --color-border: #E5E7EB; --color-heading: #111827; --color-body: #374151;
            --color-muted: #6B7280; --color-danger: #EF4444;
        }
        .dark {
            --color-accent: #818CF8; --color-secondary: #8B5CF6;
            --color-bg: #0F172A; --color-surface: #111827; --color-card: #1E293B;
            --color-border: #334155; --color-heading: #F8FAFC; --color-body: #E2E8F0;
            --color-muted: #94A3B8; --color-danger: #F87171;
        }
        body {
            font-family: {{ app()->getLocale() === 'ar' ? "'Tajawal'" : "'Inter'" }}, sans-serif;
            background-color: var(--color-bg);
            color: var(--color-body);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .form-input {
            width: 100%; padding: 0.75rem 1rem; border-radius: 0.75rem; outline: none;
            background: var(--color-bg); border: 1px solid var(--color-border);
            color: var(--color-body); transition: border-color 0.2s;
        }
        .form-input:focus { border-color: var(--color-accent); box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1); }
        .btn-primary {
            background: linear-gradient(135deg, var(--color-accent), var(--color-secondary));
            color: white; padding: 0.75rem 2rem; border-radius: 0.75rem; font-weight: 600;
            width: 100%; transition: all 0.3s; cursor: pointer; border: none;
        }
        .btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }
    </style>
</head>
<body>
    {{-- Background decoration --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full opacity-5"
             style="background: radial-gradient(circle, var(--color-accent), transparent);"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 rounded-full opacity-5"
             style="background: radial-gradient(circle, var(--color-secondary), transparent);"></div>
    </div>

    <div class="relative w-full max-w-md px-4">
        {{-- Card --}}
        <div class="rounded-2xl shadow-2xl p-8" style="background: var(--color-card); border: 1px solid var(--color-border);">
            {{-- Logo --}}
            <div class="text-center mb-8">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4"
                     style="background: linear-gradient(135deg, var(--color-accent), var(--color-secondary));">
                    <i class="fas fa-lock"></i>
                </div>
                <h1 class="text-2xl font-bold" style="color: var(--color-heading);">Admin Login</h1>
                <p class="text-sm mt-1" style="color: var(--color-muted);">Sign in to manage your portfolio</p>
            </div>

            {{-- Session Status --}}
            @if(session('status'))
            <div class="mb-4 p-3 rounded-xl text-sm" style="background: rgba(16, 185, 129, 0.1); color: #10B981;">
                {{ session('status') }}
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="form-input" placeholder="admin@portfolio.com">
                    @error('email')
                    <p class="text-xs mt-1" style="color: var(--color-danger);">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Password</label>
                    <input type="password" name="password" required
                           class="form-input" placeholder="••••••••">
                    @error('password')
                    <p class="text-xs mt-1" style="color: var(--color-danger);">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4">
                        <span class="text-sm" style="color: var(--color-muted);">Remember me</span>
                    </label>
                    @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm font-medium" style="color: var(--color-accent);">
                        Forgot password?
                    </a>
                    @endif
                </div>

                <button type="submit" class="btn-primary">
                    <i class="fas fa-sign-in-alt me-2"></i>Sign In
                </button>
            </form>

            <div class="mt-6 pt-6 text-center" style="border-top: 1px solid var(--color-border);">
                <a href="{{ route('home') }}" class="text-sm font-medium" style="color: var(--color-accent);">
                    <i class="fas fa-arrow-left me-1"></i>Back to Portfolio
                </a>
            </div>
        </div>

        {{-- Dark Mode Toggle --}}
        <div class="mt-4 text-center">
            <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)"
                    class="text-sm px-4 py-2 rounded-xl transition-all"
                    style="border: 1px solid var(--color-border); color: var(--color-muted);">
                <i x-show="!darkMode" class="fas fa-moon me-1"></i>
                <i x-show="darkMode" class="fas fa-sun me-1"></i>
                <span x-text="darkMode ? 'Light Mode' : 'Dark Mode'"></span>
            </button>
        </div>
    </div>
</body>
</html>
