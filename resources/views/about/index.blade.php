@extends('layouts.platform')

@section('title', 'حول المشروع')

@section('content')

{{-- Page Header --}}
<div class="relative bg-gradient-to-bl from-[#0F172A] via-[#1E3A5F] to-[#0F172A] py-16 overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 1px 1px, #6C63FF 1px, transparent 0); background-size: 40px 40px;"></div>
    <div class="absolute bottom-0 right-1/4 w-72 h-72 bg-[#6C63FF]/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl">
            <div class="flex items-center gap-2 mb-4">
                <a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition-colors text-sm">الرئيسية</a>
                <svg class="w-4 h-4 text-gray-600 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-[#6C63FF] text-sm font-medium">حول المشروع</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-black text-white mb-4">حول يمن ماينـد</h1>
            <p class="text-gray-300 text-base leading-relaxed max-w-xl">
                منصة بحثية أكاديمية تهدف إلى توظيف الذكاء الاصطناعي في فهم اللغة اليمنية وخدمة صحتنا النفسية.
            </p>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- ── Project Overview ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 mb-12 items-center">
        <div class="lg:col-span-3">
            <span class="inline-block px-4 py-1.5 rounded-full bg-[#6C63FF]/10 dark:bg-[#6C63FF]/20 text-[#6C63FF] text-sm font-semibold mb-5">
                نظرة عامة
            </span>
            <h2 class="section-title mb-5">
                ماذا نفعل في
                <span class="gradient-text">يمن ماينـد؟</span>
            </h2>
            <div class="space-y-4 text-gray-600 dark:text-gray-400 leading-relaxed">
                <p>
                    <strong class="text-[#1E3A5F] dark:text-white">يمن ماينـد</strong> هو مشروع بحثي أكاديمي يجمع بين علم اللغويات الحاسوبية والذكاء الاصطناعي لتحليل النصوص المكتوبة باللهجة اليمنية واكتشاف المؤشرات اللغوية المرتبطة بالحالات النفسية المحتملة.
                </p>
                <p>
                    يعتمد النظام على نموذج ذكاء اصطناعي مدرَّب خصيصًا على مدونات نصية باللهجة اليمنية، مستخدمًا تقنيات معالجة اللغة الطبيعية (NLP) والتعلم الآلي للكشف عن خمسة مؤشرات رئيسية.
                </p>
                <p class="text-sm bg-amber-50 dark:bg-amber-900/20 border border-amber-200/50 dark:border-amber-800/30 rounded-xl p-4 text-amber-700 dark:text-amber-300 font-medium">
                    ⚠️ تنبيه: هذه المنصة لأغراض البحث العلمي والكشف المبكر فقط، ولا تقدم أي تشخيص طبي أو نفسي معتمد.
                </p>
            </div>
        </div>
        <div class="lg:col-span-2">
            <div class="glass-card-solid p-6 space-y-4">
                @php
                    $overview = [
                        ['label' => 'نوع المشروع',   'val' => 'بحثي أكاديمي',      'color' => '#6C63FF'],
                        ['label' => 'اللهجة المدعومة','val' => 'اليمنية',          'color' => '#10B981'],
                        ['label' => 'الفئات النفسية', 'val' => '5 فئات',           'color' => '#F59E0B'],
                        ['label' => 'التقنية',        'val' => 'NLP + Machine Learning','color' => '#EF4444'],
                        ['label' => 'الإطار البرمجي', 'val' => 'Laravel 11 + Python API','color' => '#1E3A5F'],
                    ];
                @endphp
                @foreach($overview as $item)
                <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700/30 last:border-0">
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $item['label'] }}</span>
                    <span class="text-sm font-semibold text-[#1E3A5F] dark:text-white">{{ $item['val'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ── Objectives ── --}}
    <div class="mb-12">
        <div class="text-center mb-10">
            <span class="inline-block px-4 py-1.5 rounded-full bg-[#10B981]/10 dark:bg-[#10B981]/20 text-[#10B981] text-sm font-semibold mb-4">أهداف المشروع</span>
            <h2 class="section-title">ماذا نسعى لتحقيقه؟</h2>
        </div>
        @php
            $objectives = [
                ['title' => 'دعم الأبحاث اللغوية', 'desc' => 'المساهمة في بناء مدونات بيانات للهجة اليمنية وتوثيق أنماطها اللغوية لأغراض بحثية.', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'color' => '#6C63FF'],
                ['title' => 'توظيف الذكاء الاصطناعي', 'desc' => 'الاستفادة من أحدث تقنيات NLP والتعلم الآلي في تحليل النصوص العربية باللهجات المحلية.', 'icon' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z', 'color' => '#1E3A5F'],
                ['title' => 'الكشف المبكر', 'desc' => 'المساهمة في الكشف المبكر عن المؤشرات اللغوية المحتملة المرتبطة بالحالات النفسية لأغراض الوقاية.', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'color' => '#10B981'],
                ['title' => 'أداة بحثية وأكاديمية', 'desc' => 'توفير منصة مفيدة للباحثين والأكاديميين في مجالات علم النفس واللغويات الحاسوبية.', 'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z', 'color' => '#F59E0B'],
                ['title' => 'التوعية بالصحة النفسية', 'desc' => 'رفع مستوى الوعي بأهمية التعرف المبكر على مؤشرات الصحة النفسية في المجتمع اليمني.', 'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'color' => '#EF4444'],
                ['title' => 'لا للتشخيص الطبي', 'desc' => 'الالتزام الصارم بعدم استخدام النظام كبديل عن التشخيص المهني والتأكيد على أهمية الرجوع للمختص.', 'icon' => 'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636', 'color' => '#8B5CF6'],
            ];
        @endphp
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($objectives as $i => $obj)
            <div class="glass-card-solid p-5 hover:shadow-card-hover hover:-translate-y-1 transition-all duration-300 group opacity-0 animate-fade-in-up"
                 style="animation-delay: {{ $i*0.1 }}s; animation-fill-mode: forwards">
                <div class="w-11 h-11 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform"
                     style="background: {{ $obj['color'] }}15; border: 1px solid {{ $obj['color'] }}25">
                    <svg class="w-5 h-5" fill="none" stroke="{{ $obj['color'] }}" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $obj['icon'] }}"/>
                    </svg>
                </div>
                <h3 class="font-bold text-[#1E3A5F] dark:text-white text-sm mb-2">{{ $obj['title'] }}</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">{{ $obj['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>

    {{-- ── Why Early Detection ── --}}
    <div class="glass-card-solid p-8 mb-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
            <div>
                <span class="inline-block px-4 py-1.5 rounded-full bg-[#EF4444]/10 dark:bg-[#EF4444]/20 text-[#EF4444] text-sm font-semibold mb-5">
                    أهمية الكشف المبكر
                </span>
                <h2 class="text-2xl font-black text-[#1E3A5F] dark:text-white mb-5 leading-tight">
                    لماذا يهمنا التحليل المبكر للمؤشرات النفسية؟
                </h2>
                <div class="space-y-4 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                    <p>الصحة النفسية جزء لا يتجزأ من الصحة العامة، وكثير من الحالات النفسية تظهر مؤشراتها أولًا في طريقة التعبير اللغوي والكتابي للشخص.</p>
                    <p>الكشف المبكر عن هذه المؤشرات يتيح التدخل المناسب في الوقت المناسب، مما يحسن كثيرًا من فرص العلاج والتعافي.</p>
                    <p>في المجتمع اليمني، ولأسباب اجتماعية وثقافية، يلجأ كثيرون للتعبير الكتابي أكثر من مواجهة الآخرين، مما يجعل التحليل النصي أداة بحثية قيّمة.</p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                @php
                    $importance = [
                        ['num' => '60%', 'label' => 'من الحالات يمكن اكتشافها مبكرًا', 'color' => '#6C63FF'],
                        ['num' => '80%', 'label' => 'تحسن في النتائج مع التدخل المبكر', 'color' => '#10B981'],
                        ['num' => '3×', 'label' => 'أسرع للتعافي مع الكشف المبكر',     'color' => '#F59E0B'],
                        ['num' => '1B+', 'label' => 'شخص يعاني من حالات نفسية عالميًا','color' => '#EF4444'],
                    ];
                @endphp
                @foreach($importance as $stat)
                <div class="text-center p-4 rounded-2xl" style="background: {{ $stat['color'] }}10; border: 1px solid {{ $stat['color'] }}20">
                    <div class="text-2xl font-black mb-1" style="color: {{ $stat['color'] }}">{{ $stat['num'] }}</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">{{ $stat['label'] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ── How AI Works ── --}}
    <div class="mb-12">
        <div class="text-center mb-10">
            <span class="inline-block px-4 py-1.5 rounded-full bg-[#1E3A5F]/10 dark:bg-[#1E3A5F]/30 text-[#1E3A5F] dark:text-[#a8c4e8] text-sm font-semibold mb-4">
                آلية الذكاء الاصطناعي
            </span>
            <h2 class="section-title">كيف يعمل النموذج؟</h2>
        </div>
        @php
            $aiSteps = [
                ['num' => '01', 'title' => 'جمع البيانات', 'desc' => 'تجميع مدونات نصية متنوعة باللهجة اليمنية من مصادر متعددة مع ضمان الخصوصية والأخلاقيات البحثية.', 'color' => '#6C63FF'],
                ['num' => '02', 'title' => 'تنظيف النص', 'desc' => 'معالجة النصوص وتطبيع الكتابة اليمنية وإزالة التشويش وتوحيد الرموز والأشكال العربية المختلفة.', 'color' => '#1E3A5F'],
                ['num' => '03', 'title' => 'معالجة NLP', 'desc' => 'تطبيق تقنيات معالجة اللغة الطبيعية المتخصصة في اللهجات العربية لفهم البنية اللغوية.', 'color' => '#10B981'],
                ['num' => '04', 'title' => 'استخراج السمات', 'desc' => 'تحديد الأنماط اللغوية والكلمات المفتاحية والسياقات الدالة على كل مؤشر نفسي بدقة.', 'color' => '#F59E0B'],
                ['num' => '05', 'title' => 'تصنيف التعلم الآلي', 'desc' => 'استخدام نماذج تصنيف متقدمة مدربة على البيانات اليمنية المصنّفة للكشف عن المؤشرات.', 'color' => '#EF4444'],
                ['num' => '06', 'title' => 'عرض النتائج', 'desc' => 'تقديم النتائج بشكل مرئي واضح مع درجات الثقة والكلمات المفتاحية المؤثرة في القرار.', 'color' => '#8B5CF6'],
            ];
        @endphp
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($aiSteps as $i => $step)
            <div class="glass-card-solid p-5 hover:shadow-card-hover hover:-translate-y-1 transition-all duration-300 opacity-0 animate-fade-in-up"
                 style="animation-delay: {{ $i*0.1 }}s; animation-fill-mode: forwards">
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-xl text-white text-sm font-black flex items-center justify-center flex-shrink-0"
                         style="background: linear-gradient(135deg, {{ $step['color'] }}, {{ $step['color'] }}88)">
                        {{ $step['num'] }}
                    </div>
                    <div>
                        <h3 class="font-bold text-[#1E3A5F] dark:text-white text-sm mb-1.5">{{ $step['title'] }}</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">{{ $step['desc'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- ── Technologies ── --}}
    <div class="mb-12">
        <div class="text-center mb-10">
            <h2 class="section-title">التقنيات المستخدمة</h2>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            @php
                $techs = [
                    ['name' => 'Laravel 11',       'desc' => 'Backend Framework', 'color' => '#FF2D20', 'letter' => 'L'],
                    ['name' => 'PHP 8.2+',         'desc' => 'Server Language',   'color' => '#777BB4', 'letter' => 'P'],
                    ['name' => 'MySQL',            'desc' => 'Database',          'color' => '#4479A1', 'letter' => 'M'],
                    ['name' => 'Tailwind CSS',     'desc' => 'UI Framework',      'color' => '#06B6D4', 'letter' => 'T'],
                    ['name' => 'Alpine.js',        'desc' => 'Frontend JS',       'color' => '#8BC0D0', 'letter' => 'A'],
                    ['name' => 'Chart.js',         'desc' => 'Data Visualization','color' => '#FF6384', 'letter' => 'C'],
                    ['name' => 'Python AI API',    'desc' => 'AI Model API',      'color' => '#3776AB', 'letter' => 'Py'],
                    ['name' => 'Machine Learning', 'desc' => 'NLP & Classification','color' => '#F59E0B','letter' => 'ML'],
                ];
            @endphp
            @foreach($techs as $i => $tech)
            <div class="glass-card-solid p-4 text-center hover:shadow-card-hover hover:-translate-y-1 transition-all duration-300 group opacity-0 animate-fade-in-up"
                 style="animation-delay: {{ $i*0.08 }}s; animation-fill-mode: forwards">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center mx-auto mb-3 text-white font-black text-sm group-hover:scale-110 transition-transform"
                     style="background: linear-gradient(135deg, {{ $tech['color'] }}, {{ $tech['color'] }}99)">
                    {{ $tech['letter'] }}
                </div>
                <div class="font-bold text-[#1E3A5F] dark:text-white text-xs mb-1">{{ $tech['name'] }}</div>
                <div class="text-xs text-gray-400">{{ $tech['desc'] }}</div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- ── Team Section ── --}}
    <div class="mb-12">
        <div class="text-center mb-10">
            <span class="inline-block px-4 py-1.5 rounded-full bg-[#6C63FF]/10 dark:bg-[#6C63FF]/20 text-[#6C63FF] text-sm font-semibold mb-4">
                فريق العمل
            </span>
            <h2 class="section-title">من نحن؟</h2>
        </div>
        <div class="flex flex-wrap justify-center gap-6">
            @foreach($team as $member)
            <div class="glass-card-solid p-6 text-center w-72 hover:shadow-card-hover hover:-translate-y-2 transition-all duration-300 group">
                <div class="w-20 h-20 rounded-3xl mx-auto mb-4 flex items-center justify-center text-white text-2xl font-black group-hover:scale-110 transition-transform"
                     style="background: linear-gradient(135deg, {{ $member['color'] }}, #1E3A5F)">
                    {{ $member['initials'] }}
                </div>
                <h3 class="font-bold text-[#1E3A5F] dark:text-white text-base mb-1">{{ $member['name'] }}</h3>
                <div class="text-xs font-semibold mb-3 px-3 py-1 rounded-full inline-block"
                     style="background: {{ $member['color'] }}15; color: {{ $member['color'] }}">
                    {{ $member['role'] }}
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">{{ $member['description'] }}</p>
            </div>
            @endforeach
        </div>
    </div>

    {{-- ── CTA ── --}}
    <div class="relative rounded-3xl overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-bl from-[#1E3A5F] to-[#0F172A]"></div>
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 1px 1px, #6C63FF 1px, transparent 0); background-size: 40px 40px;"></div>
        <div class="absolute top-0 right-0 w-48 h-48 bg-[#6C63FF]/20 rounded-full blur-3xl"></div>
        <div class="relative p-10 sm:p-14 text-center">
            <h2 class="text-2xl sm:text-3xl font-black text-white mb-4">جاهز لتجربة المنصة؟</h2>
            <p class="text-gray-300 mb-8 max-w-lg mx-auto">ابدأ تحليل النصوص اليمنية واكتشف إمكانيات الذكاء الاصطناعي في خدمة الصحة النفسية.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('analysis.index') }}" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    ابدأ التحليل
                </a>
                <a href="{{ route('statistics.index') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-semibold text-white text-sm border border-white/20 bg-white/10 hover:bg-white/20 transition-all">
                    الإحصائيات
                </a>
            </div>
        </div>
    </div>

</div>

@endsection
