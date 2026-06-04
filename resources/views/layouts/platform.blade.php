<!DOCTYPE html>
<html lang="ar" dir="rtl"
      x-data="{
          isDark: localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches),
          mobileOpen: false,
          toggleDark() {
              this.isDark = !this.isDark;
              localStorage.setItem('theme', this.isDark ? 'dark' : 'light');
          }
      }"
      :class="{ 'dark': isDark }"
      class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'يمن ماينـد') — منصة التحليل النفسي للهجة اليمنية</title>
    <meta name="description" content="منصة ذكية لتحليل النصوص باللهجة اليمنية واكتشاف المؤشرات النفسية المحتملة باستخدام الذكاء الاصطناعي.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    @stack('head')
</head>
<body class="bg-[#F5F7FA] dark:bg-[#0F172A] text-[#222222] dark:text-[#F8FAFC] font-cairo antialiased min-h-screen flex flex-col transition-colors duration-300">

    {{-- ══════════════════════ NAVBAR ══════════════════════ --}}
    <nav class="sticky top-0 z-50 bg-white/80 dark:bg-[#0F172A]/80 backdrop-blur-xl border-b border-gray-200/50 dark:border-gray-700/30 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-bl from-[#6C63FF] to-[#1E3A5F] flex items-center justify-center shadow-glow group-hover:shadow-glow-lg transition-all duration-300 group-hover:scale-110">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <div class="leading-none">
                        <div class="text-base font-bold text-[#1E3A5F] dark:text-white group-hover:text-[#6C63FF] transition-colors">يمن ماينـد</div>
                        <div class="text-[10px] text-gray-400 dark:text-gray-500 font-medium">YemenMind AI</div>
                    </div>
                </a>

                {{-- Desktop Nav --}}
                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('home') }}"
                       class="nav-link px-4 py-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/40 {{ request()->routeIs('home') ? 'active' : '' }}">
                        الرئيسية
                    </a>
                    <a href="{{ route('analysis.index') }}"
                       class="nav-link px-4 py-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/40 {{ request()->routeIs('analysis.*') ? 'active' : '' }}">
                        التحليل
                    </a>
                    <a href="{{ route('statistics.index') }}"
                       class="nav-link px-4 py-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/40 {{ request()->routeIs('statistics.*') ? 'active' : '' }}">
                        الإحصائيات
                    </a>
                    <a href="{{ route('about.index') }}"
                       class="nav-link px-4 py-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/40 {{ request()->routeIs('about.*') ? 'active' : '' }}">
                        حول المشروع
                    </a>
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-2">
                    {{-- Dark Mode Toggle --}}
                    <button @click="toggleDark()"
                            class="w-9 h-9 rounded-xl flex items-center justify-center text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-[#6C63FF] dark:hover:text-[#6C63FF] transition-all duration-200"
                            :title="isDark ? 'وضع النهار' : 'الوضع الليلي'">
                        <svg x-show="!isDark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        <svg x-show="isDark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </button>

                    {{-- CTA Button --}}
                    <a href="{{ route('analysis.index') }}" class="hidden md:inline-flex btn-primary text-sm px-5 py-2.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        ابدأ التحليل
                    </a>

                    {{-- Mobile Menu Button --}}
                    <button @click="mobileOpen = !mobileOpen"
                            class="md:hidden w-9 h-9 rounded-xl flex items-center justify-center text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-all">
                        <svg x-show="!mobileOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg x-show="mobileOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="mobileOpen"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden border-t border-gray-100 dark:border-gray-700/50 bg-white dark:bg-[#0F172A] px-4 py-3 space-y-1">
            <a href="{{ route('home') }}" @click="mobileOpen=false"
               class="block px-4 py-2.5 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/40 hover:text-[#6C63FF] transition-all {{ request()->routeIs('home') ? 'bg-secondary-50 dark:bg-secondary-900/20 text-[#6C63FF]' : '' }}">
                الرئيسية
            </a>
            <a href="{{ route('analysis.index') }}" @click="mobileOpen=false"
               class="block px-4 py-2.5 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/40 hover:text-[#6C63FF] transition-all {{ request()->routeIs('analysis.*') ? 'bg-secondary-50 dark:bg-secondary-900/20 text-[#6C63FF]' : '' }}">
                التحليل
            </a>
            <a href="{{ route('statistics.index') }}" @click="mobileOpen=false"
               class="block px-4 py-2.5 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/40 hover:text-[#6C63FF] transition-all {{ request()->routeIs('statistics.*') ? 'bg-secondary-50 dark:bg-secondary-900/20 text-[#6C63FF]' : '' }}">
                الإحصائيات
            </a>
            <a href="{{ route('about.index') }}" @click="mobileOpen=false"
               class="block px-4 py-2.5 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/40 hover:text-[#6C63FF] transition-all {{ request()->routeIs('about.*') ? 'bg-secondary-50 dark:bg-secondary-900/20 text-[#6C63FF]' : '' }}">
                حول المشروع
            </a>
            <div class="pt-2 pb-1">
                <a href="{{ route('analysis.index') }}" class="btn-primary w-full text-sm py-3">
                    ابدأ التحليل الآن
                </a>
            </div>
        </div>
    </nav>

    {{-- ══════════════════════ MAIN ══════════════════════ --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- ══════════════════════ FOOTER ══════════════════════ --}}
    <footer class="bg-white dark:bg-[#1E293B] border-t border-gray-100 dark:border-gray-700/30 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">

                {{-- Brand --}}
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-bl from-[#6C63FF] to-[#1E3A5F] flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="font-bold text-[#1E3A5F] dark:text-white">يمن ماينـد</div>
                            <div class="text-xs text-gray-400">YemenMind AI Platform</div>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                        منصة ذكية لتحليل النصوص باللهجة اليمنية واكتشاف المؤشرات النفسية المحتملة لأغراض البحث العلمي.
                    </p>
                </div>

                {{-- Links --}}
                <div>
                    <h3 class="font-semibold text-[#1E3A5F] dark:text-white mb-4">روابط سريعة</h3>
                    <ul class="space-y-2.5">
                        @foreach([['home','الرئيسية'],['analysis.index','التحليل'],['statistics.index','الإحصائيات'],['about.index','حول المشروع']] as [$route, $label])
                        <li>
                            <a href="{{ route($route) }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-[#6C63FF] dark:hover:text-[#6C63FF] transition-colors flex items-center gap-2">
                                <svg class="w-3 h-3 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                {{ $label }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Disclaimer --}}
                <div>
                    <h3 class="font-semibold text-[#1E3A5F] dark:text-white mb-4">تنبيه مهم</h3>
                    <div class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed bg-amber-50 dark:bg-amber-900/20 border border-amber-200/50 dark:border-amber-800/30 rounded-xl p-3">
                        هذه المنصة تهدف للكشف عن مؤشرات لغوية محتملة لأغراض البحث العلمي فقط، ولا تمثل تشخيصًا طبيًا أو نفسيًا معتمدًا.
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-100 dark:border-gray-700/30 pt-6 flex flex-col sm:flex-row items-center justify-between gap-3">
                <p class="text-xs text-gray-400 dark:text-gray-500">
                    © {{ date('Y') }} يمن ماينـد — جميع الحقوق محفوظة. مشروع بحثي أكاديمي.
                </p>
                <div class="flex items-center gap-1">
                    <span class="text-xs text-gray-400 dark:text-gray-500">مبني بـ</span>
                    <span class="text-xs font-semibold text-[#6C63FF]">Laravel 11 + AI</span>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
