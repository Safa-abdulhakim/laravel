@extends('layouts.platform')

@section('title', 'الرئيسية')

@section('content')

{{-- ══════════════════════════════════════════════════════════════════
     HERO SECTION
══════════════════════════════════════════════════════════════════ --}}
<section class="relative min-h-[92vh] flex items-center overflow-hidden">

    {{-- Animated Gradient Background --}}
    <div class="absolute inset-0 bg-gradient-to-bl from-[#0F172A] via-[#1E3A5F] to-[#0F172A] dark:from-[#0F172A] dark:via-[#1a1f35] dark:to-[#0F172A]"></div>

    {{-- Mesh Gradient Blobs --}}
    <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-[#6C63FF]/20 rounded-full blur-3xl animate-float pointer-events-none"></div>
    <div class="absolute bottom-1/4 left-1/3 w-80 h-80 bg-[#1E3A5F]/40 rounded-full blur-3xl animate-float-delay pointer-events-none"></div>
    <div class="absolute top-1/2 left-1/4 w-64 h-64 bg-[#6C63FF]/15 rounded-full blur-2xl animate-float-delay2 pointer-events-none"></div>

    {{-- Grid Pattern --}}
    <div class="absolute inset-0 opacity-5"
         style="background-image: radial-gradient(circle at 1px 1px, #6C63FF 1px, transparent 0); background-size: 40px 40px;"></div>

    {{-- Floating Decorative Elements --}}
    <div class="absolute top-20 left-16 w-3 h-3 rounded-full bg-[#6C63FF]/60 animate-bounce-slow"></div>
    <div class="absolute top-40 right-20 w-2 h-2 rounded-full bg-white/40 animate-float"></div>
    <div class="absolute bottom-32 right-16 w-4 h-4 rounded-full bg-[#6C63FF]/40 animate-float-delay"></div>
    <div class="absolute bottom-20 left-32 w-2 h-2 rounded-full bg-white/30 animate-float-delay2"></div>

    {{-- Brain / AI floating icon --}}
    <div class="absolute top-24 left-1/4 opacity-10 animate-spin-slow pointer-events-none hidden lg:block">
        <svg class="w-24 h-24 text-[#6C63FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
        </svg>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32 w-full">
        <div class="max-w-4xl mx-auto text-center" x-data="{}" x-init="
            $nextTick(() => {
                document.querySelectorAll('.hero-animate').forEach((el, i) => {
                    el.style.animationDelay = (i * 0.15) + 's';
                    el.classList.add('animate-fade-in-up');
                });
            })
        ">

            {{-- Badge --}}
            <div class="hero-animate opacity-0 inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#6C63FF]/20 border border-[#6C63FF]/30 text-[#a89dff] text-sm font-medium mb-8">
                <div class="w-1.5 h-1.5 rounded-full bg-[#6C63FF] animate-pulse"></div>
                منصة ذكاء اصطناعي للتحليل اللغوي
                <div class="w-1.5 h-1.5 rounded-full bg-[#6C63FF] animate-pulse"></div>
            </div>

            {{-- Main Headline --}}
            <h1 class="hero-animate opacity-0 text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-black text-white leading-tight mb-6">
                الكلمات أحيانًا
                <span class="block bg-gradient-to-l from-[#6C63FF] to-[#a89dff] bg-clip-text text-transparent mt-2">
                    تكشف ما يخفيه الإنسان
                </span>
            </h1>

            {{-- Subtitle --}}
            <p class="hero-animate opacity-0 text-lg sm:text-xl text-gray-300 leading-relaxed max-w-3xl mx-auto mb-10 font-light">
                منصة ذكية لتحليل النصوص باللهجة اليمنية واكتشاف المؤشرات النفسية المحتملة باستخدام الذكاء الاصطناعي ومعالجة اللغة الطبيعية
            </p>

            {{-- CTA Buttons --}}
            <div class="hero-animate opacity-0 flex flex-col sm:flex-row items-center justify-center gap-4 mb-16">
                <a href="{{ route('analysis.index') }}"
                   class="group relative w-full sm:w-auto inline-flex items-center justify-center gap-3 px-8 py-4 rounded-2xl font-bold text-white text-base
                          bg-gradient-to-l from-[#6C63FF] to-[#4B41FF]
                          hover:shadow-glow-lg hover:scale-105 active:scale-95
                          transition-all duration-300 overflow-hidden">
                    <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <svg class="w-5 h-5 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <span class="relative z-10">ابدأ التحليل الآن</span>
                    <svg class="w-4 h-4 relative z-10 rotate-180 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>

                <a href="{{ route('about.index') }}"
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-8 py-4 rounded-2xl font-semibold text-white text-base
                          border border-white/20 bg-white/10 backdrop-blur-sm
                          hover:bg-white/20 hover:border-white/40 hover:scale-105 active:scale-95
                          transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    تعرف على المشروع
                </a>
            </div>

            {{-- Stats Row --}}
            <div class="hero-animate opacity-0 grid grid-cols-2 sm:grid-cols-4 gap-4 max-w-2xl mx-auto">
                @php
                    $heroStats = [
                        ['value' => number_format($stats['total_analyses']), 'label' => 'نص محلَّل', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['value' => $stats['avg_confidence'] . '%', 'label' => 'متوسط الثقة', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                        ['value' => $stats['categories'], 'label' => 'فئة مدعومة', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
                        ['value' => 'NLP', 'label' => 'معالجة لغوية', 'icon' => 'M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129'],
                    ];
                @endphp
                @foreach($heroStats as $stat)
                <div class="bg-white/10 backdrop-blur-sm border border-white/15 rounded-2xl p-4 hover:bg-white/15 transition-all duration-200">
                    <div class="text-2xl font-black text-white mb-1">{{ $stat['value'] }}</div>
                    <div class="text-xs text-gray-400 font-medium">{{ $stat['label'] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Wave Divider --}}
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full dark:fill-[#0F172A] fill-[#F5F7FA]" preserveAspectRatio="none">
            <path d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z"/>
        </svg>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════════
     HOW IT WORKS
══════════════════════════════════════════════════════════════════ --}}
<section class="py-20 lg:py-28">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Section Header --}}
        <div class="text-center mb-16" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
            <span class="inline-block px-4 py-1.5 rounded-full bg-[#6C63FF]/10 dark:bg-[#6C63FF]/20 text-[#6C63FF] text-sm font-semibold mb-4">
                كيف يعمل النظام
            </span>
            <h2 class="section-title mb-4">آلية عمل المنصة</h2>
            <p class="section-subtitle max-w-2xl mx-auto">
                أربع خطوات بسيطة من إدخال النص حتى الحصول على تقرير تحليلي مفصّل
            </p>
        </div>

        {{-- Steps --}}
        <div class="relative">
            {{-- Connector Line (desktop) --}}
            <div class="hidden lg:block absolute top-12 right-[12.5%] left-[12.5%] h-px bg-gradient-to-l from-[#6C63FF]/10 via-[#6C63FF]/40 to-[#6C63FF]/10"></div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $steps = [
                        [
                            'num' => '01',
                            'title' => 'إدخال النص',
                            'desc' => 'اكتب أو الصق أي نص باللهجة اليمنية في مربع النص المخصص.',
                            'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z',
                            'color' => '#1E3A5F',
                            'bg'    => 'from-[#1E3A5F]/10 to-[#1E3A5F]/5',
                        ],
                        [
                            'num' => '02',
                            'title' => 'معالجة النص',
                            'desc' => 'يقوم النظام بتنظيف النص ومعالجته لغويًا وتحليل بنيته.',
                            'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z',
                            'color' => '#6C63FF',
                            'bg'    => 'from-[#6C63FF]/10 to-[#6C63FF]/5',
                        ],
                        [
                            'num' => '03',
                            'title' => 'تحليل الذكاء الاصطناعي',
                            'desc' => 'يستخدم نموذج الذكاء الاصطناعي المدرَّب على اللهجة اليمنية لتحليل الأنماط.',
                            'icon' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z',
                            'color' => '#10B981',
                            'bg'    => 'from-[#10B981]/10 to-[#10B981]/5',
                        ],
                        [
                            'num' => '04',
                            'title' => 'نتائج تفصيلية',
                            'desc' => 'عرض المؤشرات النفسية المكتشفة مع درجات الثقة والكلمات المفتاحية.',
                            'icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                            'color' => '#F59E0B',
                            'bg'    => 'from-[#F59E0B]/10 to-[#F59E0B]/5',
                        ],
                    ];
                @endphp

                @foreach($steps as $i => $step)
                <div class="relative group"
                     x-data x-intersect.once="$el.querySelector('.step-card').classList.add('animate-fade-in-up')"
                     style="--delay: {{ $i * 0.15 }}s">
                    <div class="step-card opacity-0 glass-card-solid p-6 text-center hover:shadow-card-hover hover:-translate-y-2 transition-all duration-300"
                         style="animation-delay: var(--delay)">

                        {{-- Step Number --}}
                        <div class="text-xs font-black text-gray-300 dark:text-gray-600 mb-4">{{ $step['num'] }}</div>

                        {{-- Icon --}}
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br {{ $step['bg'] }} flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300"
                             style="border: 1px solid {{ $step['color'] }}22">
                            <svg class="w-7 h-7" fill="none" stroke="{{ $step['color'] }}" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $step['icon'] }}"/>
                            </svg>
                        </div>

                        <h3 class="font-bold text-[#1E3A5F] dark:text-white text-base mb-2">{{ $step['title'] }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">{{ $step['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════════
     FEATURES SECTION
══════════════════════════════════════════════════════════════════ --}}
<section class="py-20 lg:py-28 bg-gradient-to-b from-white to-[#F5F7FA] dark:from-[#1E293B] dark:to-[#0F172A]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-16">
            <span class="inline-block px-4 py-1.5 rounded-full bg-[#1E3A5F]/10 dark:bg-[#1E3A5F]/30 text-[#1E3A5F] dark:text-[#a8c4e8] text-sm font-semibold mb-4">
                مميزات المنصة
            </span>
            <h2 class="section-title mb-4">لماذا يمن ماينـد؟</h2>
            <p class="section-subtitle max-w-xl mx-auto">مميزات فريدة مصممة خصيصًا لتحليل اللهجة اليمنية</p>
        </div>

        @php
            $features = [
                ['icon' => 'M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129', 'title' => 'دعم اللهجة اليمنية', 'desc' => 'نموذج مدرَّب خصيصًا على النصوص والأنماط اللغوية الخاصة باللهجة اليمنية بمختلف مناطقها.', 'color' => '#6C63FF', 'bg' => 'bg-[#6C63FF]/10 dark:bg-[#6C63FF]/20'],
                ['icon' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z', 'title' => 'تحليل ذكي للنصوص', 'desc' => 'تقنيات NLP متقدمة لاستخراج الأنماط والمؤشرات اللغوية بدقة عالية من النصوص.', 'color' => '#1E3A5F', 'bg' => 'bg-[#1E3A5F]/10 dark:bg-[#1E3A5F]/30'],
                ['icon' => 'M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z', 'title' => 'واجهة سهلة الاستخدام', 'desc' => 'تصميم بسيط وأنيق يتيح لأي شخص استخدام المنصة دون الحاجة لخلفية تقنية.', 'color' => '#10B981', 'bg' => 'bg-[#10B981]/10 dark:bg-[#10B981]/20'],
                ['icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'title' => 'رسوم وإحصائيات تفاعلية', 'desc' => 'مخططات بيانية تفاعلية تعرض النتائج والإحصائيات بشكل مرئي واضح وسهل الفهم.', 'color' => '#F59E0B', 'bg' => 'bg-[#F59E0B]/10 dark:bg-[#F59E0B]/20'],
                ['icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z', 'title' => 'دعم عدة فئات', 'desc' => 'تغطي المنصة خمس فئات من المؤشرات النفسية: الاكتئاب، القلق، الضغوط، ثنائي القطب، الفصام.', 'color' => '#EF4444', 'bg' => 'bg-[#EF4444]/10 dark:bg-[#EF4444]/20'],
                ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'نتائج قابلة للفهم', 'desc' => 'تقارير واضحة ومفصّلة تشرح المؤشرات المكتشفة والكلمات الدالة بلغة عربية سهلة.', 'color' => '#8B5CF6', 'bg' => 'bg-[#8B5CF6]/10 dark:bg-[#8B5CF6]/20'],
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($features as $i => $feature)
            <div class="glass-card-solid p-6 group hover:shadow-card-hover hover:-translate-y-1 transition-all duration-300 opacity-0 animate-fade-in-up"
                 style="animation-delay: {{ $i * 0.1 }}s; animation-fill-mode: forwards">
                <div class="w-12 h-12 rounded-2xl {{ $feature['bg'] }} flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="{{ $feature['color'] }}" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $feature['icon'] }}"/>
                    </svg>
                </div>
                <h3 class="font-bold text-[#1E3A5F] dark:text-white text-base mb-2">{{ $feature['title'] }}</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">{{ $feature['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════════
     INDICATORS SECTION
══════════════════════════════════════════════════════════════════ --}}
<section class="py-20 lg:py-28">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-1.5 rounded-full bg-[#6C63FF]/10 dark:bg-[#6C63FF]/20 text-[#6C63FF] text-sm font-semibold mb-4">
                الفئات المدعومة
            </span>
            <h2 class="section-title mb-4">المؤشرات النفسية التي نكتشفها</h2>
            <p class="section-subtitle max-w-xl mx-auto">خمس فئات تغطي أبرز المؤشرات النفسية التي يمكن رصدها لغويًا</p>
        </div>

        @php
            $indicators = [
                ['key' => 'depression',    'label' => 'مؤشرات الاكتئاب',          'color' => '#3B82F6', 'desc' => 'رصد الأنماط اللغوية المرتبطة باليأس والحزن وفقدان الرغبة في الحياة.', 'keywords' => ['يأس','حزن','وحدة','فراغ','تعب']],
                ['key' => 'anxiety',       'label' => 'مؤشرات القلق',             'color' => '#F59E0B', 'desc' => 'كشف مؤشرات التوتر والخوف والأفكار القلقة المتكررة في النص.', 'keywords' => ['خوف','قلق','توتر','مخاوف','رهبة']],
                ['key' => 'stress',        'label' => 'مؤشرات الضغوط النفسية',   'color' => '#F97316', 'desc' => 'تحليل المؤشرات المرتبطة بالإرهاق والأعباء النفسية والمشاكل المتراكمة.', 'keywords' => ['ضغط','إرهاق','أعباء','مشاكل','انهاك']],
                ['key' => 'bipolar',       'label' => 'مؤشرات ثنائي القطب',      'color' => '#8B5CF6', 'desc' => 'اكتشاف أنماط التقلبات المزاجية الحادة والتناقضات العاطفية في الكتابة.', 'keywords' => ['تقلب','مرة سعيد','مرة حزين','طاقة','إرهاق']],
                ['key' => 'schizophrenia', 'label' => 'مؤشرات الفصام',           'color' => '#EF4444', 'desc' => 'رصد الأنماط اللغوية المرتبطة بالتفكير غير المنظم والأفكار الاضطهادية.', 'keywords' => ['أصوات','يراقبون','أشوف','ارتباك','أفكار']],
            ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
            @foreach($indicators as $i => $ind)
            <div class="glass-card-solid p-5 hover:shadow-card-hover hover:-translate-y-1 transition-all duration-300 group opacity-0 animate-fade-in-up"
                 style="animation-delay: {{ $i * 0.1 }}s; animation-fill-mode: forwards">
                <div class="flex items-start gap-4">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform"
                         style="background: {{ $ind['color'] }}18; border: 1px solid {{ $ind['color'] }}30">
                        <div class="w-4 h-4 rounded-full" style="background: {{ $ind['color'] }}"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-[#1E3A5F] dark:text-white text-sm mb-1">{{ $ind['label'] }}</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed mb-3">{{ $ind['desc'] }}</p>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($ind['keywords'] as $kw)
                            <span class="text-xs px-2 py-0.5 rounded-full font-medium"
                                  style="background: {{ $ind['color'] }}15; color: {{ $ind['color'] }}; border: 1px solid {{ $ind['color'] }}25">
                                {{ $kw }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            {{-- CTA Card --}}
            <div class="md:col-span-2 xl:col-span-1 glass-card p-5 bg-gradient-to-bl from-[#6C63FF]/20 to-[#1E3A5F]/20 border-[#6C63FF]/20 flex flex-col items-center justify-center text-center gap-4 hover:shadow-glow transition-all duration-300 group">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#6C63FF] to-[#1E3A5F] flex items-center justify-center shadow-glow group-hover:shadow-glow-lg transition-all group-hover:scale-110">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-[#1E3A5F] dark:text-white mb-1">جرّب التحليل الآن</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">أدخل أي نص واكتشف المؤشرات في ثوانٍ</p>
                </div>
                <a href="{{ route('analysis.index') }}" class="btn-primary text-sm px-6 py-2.5">
                    ابدأ التحليل
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════════
     STATISTICS PREVIEW
══════════════════════════════════════════════════════════════════ --}}
<section class="py-20 lg:py-28 bg-gradient-to-b from-[#F5F7FA] to-white dark:from-[#0F172A] dark:to-[#1E293B]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-16">
            <span class="inline-block px-4 py-1.5 rounded-full bg-[#10B981]/10 dark:bg-[#10B981]/20 text-[#10B981] text-sm font-semibold mb-4">
                إحصائيات المنصة
            </span>
            <h2 class="section-title mb-4">أرقام تتحدث عن نفسها</h2>
            <p class="section-subtitle max-w-xl mx-auto">إحصائيات حية من عمليات التحليل الفعلية على المنصة</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-10">
            @php
                $statCards = [
                    ['val' => number_format($stats['total_analyses']), 'label' => 'إجمالي النصوص المحللة', 'sub' => 'منذ إطلاق المنصة', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => '#6C63FF', 'bg' => 'from-[#6C63FF]/10'],
                    ['val' => $stats['avg_confidence'] . '%', 'label' => 'متوسط درجة الثقة', 'sub' => 'في نتائج التحليل', 'icon' => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6', 'color' => '#10B981', 'bg' => 'from-[#10B981]/10'],
                    ['val' => $stats['categories'], 'label' => 'فئة نفسية مدعومة', 'sub' => 'مؤشرات مختلفة', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z', 'color' => '#F59E0B', 'bg' => 'from-[#F59E0B]/10'],
                    ['val' => 'AI', 'label' => 'نموذج ذكاء اصطناعي', 'sub' => 'مدرَّب على اللهجة اليمنية', 'icon' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z', 'color' => '#EF4444', 'bg' => 'from-[#EF4444]/10'],
                ];
            @endphp
            @foreach($statCards as $i => $sc)
            <div class="stat-card group opacity-0 animate-fade-in-up" style="animation-delay: {{ $i*0.1 }}s; animation-fill-mode: forwards">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <div class="text-3xl font-black" style="color: {{ $sc['color'] }}">{{ $sc['val'] }}</div>
                        <div class="text-sm font-semibold text-[#1E3A5F] dark:text-white mt-1">{{ $sc['label'] }}</div>
                        <div class="text-xs text-gray-400 mt-0.5">{{ $sc['sub'] }}</div>
                    </div>
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br {{ $sc['bg'] }} to-transparent flex items-center justify-center group-hover:scale-110 transition-transform"
                         style="border: 1px solid {{ $sc['color'] }}20">
                        <svg class="w-5 h-5" fill="none" stroke="{{ $sc['color'] }}" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $sc['icon'] }}"/>
                        </svg>
                    </div>
                </div>
                <div class="h-1 rounded-full bg-gray-100 dark:bg-gray-700/50 overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-1000" style="width: 75%; background: {{ $sc['color'] }}40"></div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center">
            <a href="{{ route('statistics.index') }}" class="btn-secondary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                عرض الإحصائيات الكاملة
            </a>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════════
     ABOUT PREVIEW
══════════════════════════════════════════════════════════════════ --}}
<section class="py-20 lg:py-28">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            {{-- Text --}}
            <div>
                <span class="inline-block px-4 py-1.5 rounded-full bg-[#1E3A5F]/10 dark:bg-[#1E3A5F]/30 text-[#1E3A5F] dark:text-[#a8c4e8] text-sm font-semibold mb-6">
                    حول المشروع
                </span>
                <h2 class="section-title mb-5">
                    مشروع بحثي أكاديمي
                    <span class="gradient-text block">لخدمة المجتمع</span>
                </h2>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed mb-6">
                    يمن ماينـد مشروع بحثي أكاديمي يهدف إلى توظيف تقنيات الذكاء الاصطناعي ومعالجة اللغة الطبيعية في تحليل النصوص باللهجة اليمنية، والكشف المبكر عن المؤشرات اللغوية المحتملة المرتبطة بالحالات النفسية.
                </p>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed mb-8">
                    تجدر الإشارة بوضوح أن هذه المنصة <strong class="text-[#1E3A5F] dark:text-white">لا تقدم أي تشخيص طبي أو نفسي</strong>، وإنما تكتشف أنماطًا لغوية محتملة لأغراض البحث العلمي والتوعية فقط.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('about.index') }}" class="btn-primary">
                        اقرأ المزيد
                        <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                    <a href="{{ route('analysis.index') }}" class="btn-secondary">
                        جرّب التحليل
                    </a>
                </div>
            </div>

            {{-- Visual --}}
            <div class="relative">
                <div class="relative bg-gradient-to-bl from-[#1E3A5F] to-[#0F172A] rounded-3xl p-8 shadow-glass-lg overflow-hidden">
                    {{-- Background decoration --}}
                    <div class="absolute top-0 left-0 w-48 h-48 bg-[#6C63FF]/20 rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 right-0 w-48 h-48 bg-[#1E3A5F]/30 rounded-full blur-3xl"></div>

                    <div class="relative space-y-4">
                        @php $objList = [['المساهمة في الكشف المبكر عن المؤشرات النفسية.','#6C63FF'],['دعم الأبحاث باللهجة اليمنية وتوثيق أنماطها.','#10B981'],['توفير أداة بحثية وأكاديمية مساعدة.','#F59E0B'],['الاستفادة من الذكاء الاصطناعي لخدمة المجتمع.','#EF4444'],['عدم استخدام النظام كأداة تشخيص طبي.','#8B5CF6']]; @endphp
                        @foreach($objList as [$obj, $color])
                        <div class="flex items-start gap-3 bg-white/5 rounded-xl p-3 border border-white/10 hover:bg-white/10 transition-colors">
                            <div class="w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5"
                                 style="background: {{ $color }}30; border: 1px solid {{ $color }}50">
                                <svg class="w-3 h-3" fill="none" stroke="{{ $color }}" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <span class="text-sm text-gray-300">{{ $obj }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════════
     FINAL CTA SECTION
══════════════════════════════════════════════════════════════════ --}}
<section class="py-20 lg:py-28 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-bl from-[#1E3A5F] to-[#0F172A]"></div>
    <div class="absolute inset-0 opacity-10"
         style="background-image: radial-gradient(circle at 1px 1px, #6C63FF 1px, transparent 0); background-size: 40px 40px;"></div>
    <div class="absolute top-1/3 left-1/4 w-64 h-64 bg-[#6C63FF]/20 rounded-full blur-3xl"></div>
    <div class="absolute bottom-1/3 right-1/4 w-64 h-64 bg-[#6C63FF]/10 rounded-full blur-3xl"></div>

    <div class="relative max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white leading-tight mb-5">
            جاهز لتجربة
            <span class="bg-gradient-to-l from-[#6C63FF] to-[#a89dff] bg-clip-text text-transparent"> التحليل الذكي؟</span>
        </h2>
        <p class="text-gray-300 text-lg mb-10 leading-relaxed">
            أدخل أي نص باللهجة اليمنية واحصل على تقرير تحليلي مفصّل في ثوانٍ.
        </p>
        <a href="{{ route('analysis.index') }}"
           class="inline-flex items-center gap-3 px-10 py-4 rounded-2xl bg-gradient-to-l from-[#6C63FF] to-[#4B41FF] text-white font-bold text-lg hover:shadow-glow-lg hover:scale-105 active:scale-95 transition-all duration-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
            ابدأ التحليل مجانًا
        </a>
    </div>
</section>

@endsection
