<nav class="navbar-blur fixed top-0 left-0 right-0 z-50 transition-all duration-300"
     x-data="{ mobileOpen: false, scrolled: false }"
     @scroll.window="scrolled = window.scrollY > 20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-white text-lg"
                     style="background: linear-gradient(135deg, var(--color-accent), var(--color-secondary));">
                    {{ strtoupper(substr(\App\Models\Setting::get('full_name', 'P'), 0, 1)) }}
                </div>
                <span class="font-bold text-lg" style="color: var(--color-heading);">
                    {{ \App\Models\Setting::get('full_name', 'Portfolio') }}
                </span>
            </a>

            {{-- Desktop Navigation --}}
            <div class="hidden md:flex items-center gap-6">
                <a href="{{ route('home') }}#hero" class="nav-link font-medium transition-colors duration-200 hover:text-accent"
                   style="color: var(--color-body);">{{ __('navigation.home') }}</a>
                <a href="{{ route('home') }}#about" class="nav-link font-medium transition-colors duration-200 hover:text-accent"
                   style="color: var(--color-body);">{{ __('navigation.about') }}</a>
                <a href="{{ route('home') }}#skills" class="nav-link font-medium transition-colors duration-200 hover:text-accent"
                   style="color: var(--color-body);">{{ __('navigation.skills') }}</a>
                <a href="{{ route('home') }}#projects" class="nav-link font-medium transition-colors duration-200 hover:text-accent"
                   style="color: var(--color-body);">{{ __('navigation.projects') }}</a>
                <a href="{{ route('home') }}#experience" class="nav-link font-medium transition-colors duration-200 hover:text-accent"
                   style="color: var(--color-body);">{{ __('navigation.experience') }}</a>
                <a href="{{ route('home') }}#certificates" class="nav-link font-medium transition-colors duration-200 hover:text-accent"
                   style="color: var(--color-body);">{{ __('navigation.certificates') }}</a>
                <a href="{{ route('home') }}#contact" class="nav-link font-medium transition-colors duration-200 hover:text-accent"
                   style="color: var(--color-body);">{{ __('navigation.contact') }}</a>
            </div>

            {{-- Right Side Controls --}}
            <div class="flex items-center gap-3">
                {{-- Language Switcher --}}
                <div x-data="{ langOpen: false }" class="relative">
                    <button @click="langOpen = !langOpen"
                            class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-medium transition-all"
                            style="color: var(--color-muted); border: 1px solid var(--color-border);">
                        <i class="fas fa-globe text-xs"></i>
                        {{ app()->getLocale() === 'ar' ? 'عربي' : 'EN' }}
                        <i class="fas fa-chevron-down text-xs transition-transform" :class="{ 'rotate-180': langOpen }"></i>
                    </button>
                    <div x-show="langOpen" @click.away="langOpen = false" x-transition
                         class="absolute top-full mt-1 rounded-xl shadow-xl py-1 min-w-[120px] z-50"
                         style="background: var(--color-card); border: 1px solid var(--color-border);"
                         @if(app()->getLocale() === 'ar') style="right: 0;" @else style="right: 0;" @endif>
                        <a href="{{ route('language.switch', 'en') }}"
                           class="flex items-center gap-2 px-4 py-2.5 text-sm transition-colors hover:bg-opacity-10"
                           style="color: {{ app()->getLocale() === 'en' ? 'var(--color-accent)' : 'var(--color-body)' }};">
                            <span>🇺🇸</span> English
                            @if(app()->getLocale() === 'en') <i class="fas fa-check ms-auto text-xs"></i> @endif
                        </a>
                        <a href="{{ route('language.switch', 'ar') }}"
                           class="flex items-center gap-2 px-4 py-2.5 text-sm transition-colors"
                           style="color: {{ app()->getLocale() === 'ar' ? 'var(--color-accent)' : 'var(--color-body)' }};">
                            <span>🇸🇦</span> العربية
                            @if(app()->getLocale() === 'ar') <i class="fas fa-check ms-auto text-xs"></i> @endif
                        </a>
                    </div>
                </div>

                {{-- Dark Mode Toggle --}}
                <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)"
                        class="w-9 h-9 rounded-lg flex items-center justify-center transition-all"
                        style="border: 1px solid var(--color-border); color: var(--color-muted);">
                    <i x-show="!darkMode" class="fas fa-moon text-sm"></i>
                    <i x-show="darkMode" class="fas fa-sun text-sm" style="color: var(--color-warning);"></i>
                </button>

                {{-- Admin Link --}}
                @auth
                <a href="{{ route('admin.dashboard') }}"
                   class="hidden md:flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-medium transition-all btn-primary">
                    <i class="fas fa-tachometer-alt text-xs"></i>
                    {{ __('navigation.dashboard') }}
                </a>
                @endauth

                {{-- Mobile Menu Button --}}
                <button @click="mobileOpen = !mobileOpen"
                        class="md:hidden w-9 h-9 rounded-lg flex items-center justify-center"
                        style="border: 1px solid var(--color-border); color: var(--color-body);">
                    <i class="fas" :class="mobileOpen ? 'fa-times' : 'fa-bars'"></i>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             class="md:hidden pb-4 pt-2">
            <div class="flex flex-col gap-1" style="border-top: 1px solid var(--color-border); padding-top: 1rem;">
                <a href="{{ route('home') }}#about" @click="mobileOpen = false"
                   class="px-4 py-2.5 rounded-lg font-medium transition-colors"
                   style="color: var(--color-body);">{{ __('navigation.about') }}</a>
                <a href="{{ route('home') }}#skills" @click="mobileOpen = false"
                   class="px-4 py-2.5 rounded-lg font-medium transition-colors"
                   style="color: var(--color-body);">{{ __('navigation.skills') }}</a>
                <a href="{{ route('home') }}#projects" @click="mobileOpen = false"
                   class="px-4 py-2.5 rounded-lg font-medium transition-colors"
                   style="color: var(--color-body);">{{ __('navigation.projects') }}</a>
                <a href="{{ route('home') }}#experience" @click="mobileOpen = false"
                   class="px-4 py-2.5 rounded-lg font-medium transition-colors"
                   style="color: var(--color-body);">{{ __('navigation.experience') }}</a>
                <a href="{{ route('home') }}#certificates" @click="mobileOpen = false"
                   class="px-4 py-2.5 rounded-lg font-medium transition-colors"
                   style="color: var(--color-body);">{{ __('navigation.certificates') }}</a>
                <a href="{{ route('home') }}#contact" @click="mobileOpen = false"
                   class="px-4 py-2.5 rounded-lg font-medium transition-colors"
                   style="color: var(--color-body);">{{ __('navigation.contact') }}</a>
                @auth
                <a href="{{ route('admin.dashboard') }}" class="mt-2 btn-primary justify-center">
                    <i class="fas fa-tachometer-alt text-xs"></i>
                    {{ __('navigation.dashboard') }}
                </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
