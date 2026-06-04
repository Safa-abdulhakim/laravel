@extends('layouts.platform')

@section('title', 'نتائج التحليل')

@section('content')

@php
    $indicatorColors = [
        'depression'    => ['hex' => '#3B82F6', 'bg' => 'bg-blue-500',   'light' => 'bg-blue-50 dark:bg-blue-900/20',   'text' => 'text-blue-700 dark:text-blue-300',   'border' => 'border-blue-200 dark:border-blue-800/50'],
        'anxiety'       => ['hex' => '#F59E0B', 'bg' => 'bg-amber-500',  'light' => 'bg-amber-50 dark:bg-amber-900/20',  'text' => 'text-amber-700 dark:text-amber-300',  'border' => 'border-amber-200 dark:border-amber-800/50'],
        'stress'        => ['hex' => '#F97316', 'bg' => 'bg-orange-500', 'light' => 'bg-orange-50 dark:bg-orange-900/20','text' => 'text-orange-700 dark:text-orange-300','border' => 'border-orange-200 dark:border-orange-800/50'],
        'bipolar'       => ['hex' => '#8B5CF6', 'bg' => 'bg-purple-500', 'light' => 'bg-purple-50 dark:bg-purple-900/20','text' => 'text-purple-700 dark:text-purple-300','border' => 'border-purple-200 dark:border-purple-800/50'],
        'schizophrenia' => ['hex' => '#EF4444', 'bg' => 'bg-red-500',    'light' => 'bg-red-50 dark:bg-red-900/20',    'text' => 'text-red-700 dark:text-red-300',    'border' => 'border-red-200 dark:border-red-800/50'],
    ];
    $primary = $analysis->primary_indicator;
    $pc = $indicatorColors[$primary] ?? $indicatorColors['depression'];
    $confidenceLevel = $analysis->confidenceLevel();
    $confidenceColor = match($confidenceLevel) {
        'high'   => '#10B981',
        'medium' => '#F59E0B',
        default  => '#EF4444',
    };
@endphp

{{-- Page Header --}}
<div class="relative bg-gradient-to-bl from-[#0F172A] via-[#1E3A5F] to-[#0F172A] py-10 overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 1px 1px, #6C63FF 1px, transparent 0); background-size: 40px 40px;"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition-colors text-sm">الرئيسية</a>
                    <svg class="w-4 h-4 text-gray-600 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <a href="{{ route('analysis.index') }}" class="text-gray-400 hover:text-white transition-colors text-sm">التحليل</a>
                    <svg class="w-4 h-4 text-gray-600 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <span class="text-[#6C63FF] text-sm font-medium">النتائج</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-white mb-1">نتائج تحليل النص</h1>
                <p class="text-gray-400 text-sm">
                    تم التحليل {{ $analysis->created_at->diffForHumans() }}
                    @if($analysis->processing_time)
                    · وقت المعالجة: {{ $analysis->processing_time }}ث
                    @endif
                    · {{ $analysis->word_count }} كلمة
                </p>
            </div>
            <a href="{{ route('analysis.index') }}" class="btn-secondary text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                تحليل نص جديد
            </a>
        </div>
    </div>
</div>

{{-- Main Content --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="resultsPage()">

    {{-- ── Top Row: Primary Result + Confidence ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-6">

        {{-- Primary Indicator Card --}}
        <div class="lg:col-span-2 glass-card-solid p-6 sm:p-8 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-40 h-40 rounded-full blur-3xl opacity-20 pointer-events-none"
                 style="background: {{ $pc['hex'] }}"></div>
            <div class="relative">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl flex items-center justify-center flex-shrink-0"
                         style="background: {{ $pc['hex'] }}20; border: 2px solid {{ $pc['hex'] }}30">
                        <div class="w-7 h-7 rounded-full" style="background: {{ $pc['hex'] }}"></div>
                    </div>
                    <div class="flex-1">
                        <div class="text-xs font-semibold text-gray-400 mb-1">المؤشر الرئيسي المكتشف</div>
                        <h2 class="text-2xl sm:text-3xl font-black text-[#1E3A5F] dark:text-white mb-2">
                            {{ $indicators[$primary] ?? $primary }}
                        </h2>
                        <div class="flex flex-wrap gap-2 mt-3">
                            <span class="badge {{ 'badge-'.$primary }}">
                                الفئة الأكثر احتمالًا
                            </span>
                            <span class="badge" style="background: {{ $confidenceColor }}15; color: {{ $confidenceColor }}; border: 1px solid {{ $confidenceColor }}30">
                                ثقة {{ $analysis->confidenceLabel() }}
                            </span>
                            <span class="badge bg-gray-100 dark:bg-gray-700/50 text-gray-600 dark:text-gray-300">
                                تحليل #{{ $analysis->id }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Confidence Score --}}
        <div class="glass-card-solid p-6 flex flex-col items-center justify-center text-center">
            <div class="text-xs font-semibold text-gray-400 mb-3">درجة الثقة</div>
            <div class="relative w-32 h-32 mb-4">
                <svg class="w-full h-full -rotate-90" viewBox="0 0 36 36">
                    <circle cx="18" cy="18" r="15.9155" fill="none" stroke="currentColor"
                            class="text-gray-100 dark:text-gray-700/50" stroke-width="2.5"/>
                    <circle cx="18" cy="18" r="15.9155" fill="none"
                            stroke="{{ $confidenceColor }}" stroke-width="2.5"
                            stroke-dasharray="{{ $analysis->confidence_score }}, 100"
                            stroke-linecap="round" class="transition-all duration-1000"
                            x-bind:stroke-dasharray="animated ? '{{ $analysis->confidence_score }}, 100' : '0, 100'"/>
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-3xl font-black" style="color: {{ $confidenceColor }}">
                        {{ $analysis->confidence_score }}%
                    </span>
                    <span class="text-xs text-gray-400">{{ $analysis->confidenceLabel() }}</span>
                </div>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400">مستوى ثقة النموذج في النتيجة</p>
        </div>
    </div>

    {{-- ── Probability Distribution ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-6">

        {{-- Progress Bars --}}
        <div class="glass-card-solid p-6">
            <h3 class="font-bold text-[#1E3A5F] dark:text-white mb-5 flex items-center gap-2 text-sm">
                <svg class="w-4 h-4 text-[#6C63FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                توزيع الاحتمالات
            </h3>
            <div class="space-y-4">
                @foreach($analysis->probabilities as $cat => $prob)
                @php $catColor = $colors[$cat] ?? '#6C63FF'; $catLabel = $indicators[$cat] ?? $cat; @endphp
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <div class="flex items-center gap-2">
                            <div class="w-2.5 h-2.5 rounded-full" style="background: {{ $catColor }}"></div>
                            <span class="text-xs font-medium text-gray-700 dark:text-gray-300">{{ $catLabel }}</span>
                        </div>
                        <span class="text-xs font-bold" style="color: {{ $catColor }}">{{ $prob }}%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill rounded-full"
                             x-bind:style="animated ? 'width: {{ $prob }}%; background: linear-gradient(to right, {{ $catColor }}88, {{ $catColor }})' : 'width: 0%; background: {{ $catColor }}'">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Chart --}}
        <div class="glass-card-solid p-6">
            <h3 class="font-bold text-[#1E3A5F] dark:text-white mb-5 text-sm flex items-center gap-2">
                <svg class="w-4 h-4 text-[#6C63FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                </svg>
                المخطط البياني
            </h3>
            <div class="flex items-center justify-center h-52">
                <canvas id="probChart"></canvas>
            </div>
        </div>
    </div>

    {{-- ── Detected Keywords ── --}}
    @if($analysis->detected_keywords && count($analysis->detected_keywords) > 0)
    <div class="glass-card-solid p-6 mb-6">
        <h3 class="font-bold text-[#1E3A5F] dark:text-white mb-5 text-sm flex items-center gap-2">
            <svg class="w-4 h-4 text-[#6C63FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
            المؤشرات اللغوية المكتشفة
        </h3>
        <div class="space-y-4">
            @foreach($analysis->detected_keywords as $cat => $keywords)
            @if(!empty($keywords))
            @php $catColor = $colors[$cat] ?? '#6C63FF'; $catLabel = $indicators[$cat] ?? $cat; @endphp
            <div>
                <div class="text-xs font-semibold mb-2" style="color: {{ $catColor }}">{{ $catLabel }}</div>
                <div class="flex flex-wrap gap-2">
                    @foreach($keywords as $kw)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border"
                          style="background: {{ $catColor }}12; color: {{ $catColor }}; border-color: {{ $catColor }}25">
                        {{ $kw }}
                    </span>
                    @endforeach
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
    @endif

    {{-- ── Highlighted Text ── --}}
    <div class="glass-card-solid p-6 mb-6">
        <h3 class="font-bold text-[#1E3A5F] dark:text-white mb-4 text-sm flex items-center gap-2">
            <svg class="w-4 h-4 text-[#6C63FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
            </svg>
            النص مع الكلمات المؤثرة المُبرَزة
        </h3>
        <div class="bg-gray-50 dark:bg-[#0F172A]/50 rounded-xl p-5 text-base leading-relaxed font-cairo text-gray-700 dark:text-gray-300 border border-gray-100 dark:border-gray-700/30">
            @if($analysis->highlighted_segments && count($analysis->highlighted_segments) > 0)
                @foreach($analysis->highlighted_segments as $segment)
                    @if($segment['highlight'])
                        <mark class="keyword-highlight bg-[#6C63FF]/15 dark:bg-[#6C63FF]/25 text-[#6C63FF] dark:text-[#8B83FF] rounded px-0.5 font-semibold not-italic">{{ $segment['text'] }}</mark>
                    @else
                        {{ $segment['text'] }}
                    @endif
                @endforeach
            @else
                {{ $analysis->text }}
            @endif
        </div>
        @if($analysis->highlighted_segments && count(array_filter($analysis->highlighted_segments, fn($s) => $s['highlight'])) > 0)
        <div class="mt-3 flex items-center gap-2">
            <div class="w-4 h-3 rounded bg-[#6C63FF]/20 border border-[#6C63FF]/30"></div>
            <span class="text-xs text-gray-400">الكلمات المُظلَّلة هي المؤشرات الأكثر تأثيرًا في النتيجة</span>
        </div>
        @endif
    </div>

    {{-- ── Disclaimer Card ── --}}
    <div class="disclaimer-card mb-6">
        <div class="flex gap-4">
            <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <h4 class="font-bold text-amber-700 dark:text-amber-300 text-sm mb-1">تنبيه مهم — إخلاء المسؤولية</h4>
                <p class="text-sm text-amber-700/80 dark:text-amber-300/80 leading-relaxed">
                    هذه النتائج تعتمد على <strong>تحليل لغوي باستخدام الذكاء الاصطناعي</strong> وتهدف إلى اكتشاف مؤشرات نفسية محتملة من خلال الأنماط النصية فقط، <strong>ولا تمثل تشخيصًا طبيًا أو نفسيًا معتمدًا</strong>. للحصول على تقييم مهني دقيق يُنصح بمراجعة مختص مؤهل.
                </p>
            </div>
        </div>
    </div>

    {{-- ── Actions ── --}}
    <div class="flex flex-wrap gap-3">
        <a href="{{ route('analysis.index') }}" class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            تحليل نص جديد
        </a>
        <a href="{{ route('statistics.index') }}" class="btn-secondary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            عرض الإحصائيات
        </a>
    </div>
</div>

@endsection

@push('scripts')
<script>
function resultsPage() {
    return {
        animated: false,
        init() {
            setTimeout(() => { this.animated = true; }, 300);
            this.renderChart();
        },
        renderChart() {
            const ctx = document.getElementById('probChart');
            if (!ctx) return;
            const isDark = document.documentElement.classList.contains('dark');
            const textColor = isDark ? '#94a3b8' : '#64748b';

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: @json(array_map(fn($k) => $indicators[$k] ?? $k, array_keys($analysis->probabilities))),
                    datasets: [{
                        data: @json(array_values($analysis->probabilities)),
                        backgroundColor: @json(array_map(fn($k) => ($colors[$k] ?? '#6C63FF') . '99', array_keys($analysis->probabilities))),
                        borderColor:     @json(array_map(fn($k) => $colors[$k] ?? '#6C63FF', array_keys($analysis->probabilities))),
                        borderWidth: 2,
                        hoverOffset: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            rtl: true,
                            callbacks: {
                                label: ctx => ` ${ctx.label}: ${ctx.parsed}%`
                            }
                        }
                    }
                }
            });
        }
    };
}
</script>
@endpush
