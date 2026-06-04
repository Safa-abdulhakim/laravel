@extends('layouts.platform')

@section('title', 'الإحصائيات')

@section('content')

{{-- Page Header --}}
<div class="relative bg-gradient-to-bl from-[#0F172A] via-[#1E3A5F] to-[#0F172A] py-14 overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 1px 1px, #6C63FF 1px, transparent 0); background-size: 40px 40px;"></div>
    <div class="absolute top-0 right-1/3 w-64 h-64 bg-[#6C63FF]/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-xl">
            <div class="flex items-center gap-2 mb-4">
                <a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition-colors text-sm">الرئيسية</a>
                <svg class="w-4 h-4 text-gray-600 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-[#6C63FF] text-sm font-medium">الإحصائيات</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-black text-white mb-3">لوحة الإحصائيات</h1>
            <p class="text-gray-300 text-base">تقارير ومؤشرات حية من عمليات التحليل الفعلية على المنصة.</p>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="statsPage()">

    {{-- ── KPI Cards ── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @php
            $kpis = [
                ['val' => number_format($stats['total']),    'label' => 'نصوص محللة',          'sub' => 'إجمالي عمليات التحليل',  'color' => '#6C63FF', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['val' => $stats['avg_confidence'] . '%',    'label' => 'متوسط الثقة',          'sub' => 'دقة نتائج التحليل',      'color' => '#10B981', 'icon' => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6'],
                ['val' => $stats['most_common'],             'label' => 'أكثر مؤشر ظهورًا',    'sub' => 'في عمليات التحليل',      'color' => '#F59E0B', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
                ['val' => $stats['last_analysis'],           'label' => 'آخر عملية تحليل',      'sub' => 'آخر نشاط على المنصة',    'color' => '#EF4444', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
            ];
        @endphp
        @foreach($kpis as $i => $kpi)
        <div class="stat-card group opacity-0 animate-fade-in-up"
             style="animation-delay: {{ $i*0.1 }}s; animation-fill-mode: forwards">
            <div class="flex items-start justify-between gap-2">
                <div class="min-w-0">
                    <div class="text-xl sm:text-2xl font-black leading-tight truncate" style="color: {{ $kpi['color'] }}">
                        {{ $kpi['val'] }}
                    </div>
                    <div class="text-xs sm:text-sm font-semibold text-[#1E3A5F] dark:text-white mt-1">{{ $kpi['label'] }}</div>
                    <div class="text-xs text-gray-400 mt-0.5 hidden sm:block">{{ $kpi['sub'] }}</div>
                </div>
                <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform"
                     style="background: {{ $kpi['color'] }}15; border: 1px solid {{ $kpi['color'] }}25">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="{{ $kpi['color'] }}" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $kpi['icon'] }}"/>
                    </svg>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ── Empty State ── --}}
    @if($stats['total'] === 0)
    <div class="glass-card-solid p-16 text-center">
        <div class="w-20 h-20 rounded-3xl bg-[#6C63FF]/10 flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-[#6C63FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
        </div>
        <h2 class="text-xl font-bold text-[#1E3A5F] dark:text-white mb-3">لا توجد بيانات بعد</h2>
        <p class="text-gray-500 dark:text-gray-400 mb-6 max-w-md mx-auto">ابدأ بتحليل النصوص لتظهر هنا الإحصائيات والمخططات البيانية.</p>
        <a href="{{ route('analysis.index') }}" class="btn-primary">
            ابدأ أول تحليل
        </a>
    </div>
    @else

    {{-- ── Charts Row ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-6">

        {{-- Doughnut Chart --}}
        <div class="glass-card-solid p-6">
            <h3 class="font-bold text-[#1E3A5F] dark:text-white mb-5 text-sm">توزيع المؤشرات النفسية</h3>
            <div class="flex flex-col sm:flex-row items-center gap-6">
                <div class="relative w-48 h-48 flex-shrink-0">
                    <canvas id="doughnutChart"></canvas>
                </div>
                <div class="flex flex-col gap-2 flex-1">
                    @foreach($distribution as $key => $data)
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex items-center gap-2 min-w-0">
                            <div class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background: {{ $data['color'] }}"></div>
                            <span class="text-xs text-gray-600 dark:text-gray-400 truncate">{{ $data['label'] }}</span>
                        </div>
                        <span class="text-xs font-bold flex-shrink-0" style="color: {{ $data['color'] }}">{{ $data['count'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Bar Chart --}}
        <div class="glass-card-solid p-6">
            <h3 class="font-bold text-[#1E3A5F] dark:text-white mb-5 text-sm">مقارنة المؤشرات</h3>
            <div class="h-48">
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>

    {{-- ── Line Chart (Daily) ── --}}
    @if(!empty($dailyStats))
    <div class="glass-card-solid p-6 mb-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-bold text-[#1E3A5F] dark:text-white text-sm">التحليلات اليومية (آخر 14 يوم)</h3>
            <span class="badge bg-[#6C63FF]/10 dark:bg-[#6C63FF]/20 text-[#6C63FF]">{{ $stats['total'] }} إجمالي</span>
        </div>
        <div class="h-48">
            <canvas id="lineChart"></canvas>
        </div>
    </div>
    @endif

    {{-- ── Indicator Distribution Table ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-6">

        {{-- Distribution Details --}}
        <div class="glass-card-solid p-6">
            <h3 class="font-bold text-[#1E3A5F] dark:text-white mb-5 text-sm">تفاصيل توزيع المؤشرات</h3>
            <div class="space-y-4">
                @php $total = $stats['total'] ?: 1; @endphp
                @foreach($distribution as $key => $data)
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <div class="flex items-center gap-2">
                            <div class="w-2.5 h-2.5 rounded-full" style="background: {{ $data['color'] }}"></div>
                            <span class="text-xs font-medium text-gray-700 dark:text-gray-300">{{ $data['label'] }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-400">{{ $data['count'] }}</span>
                            <span class="text-xs font-bold" style="color: {{ $data['color'] }}">
                                {{ $total > 0 ? round(($data['count'] / $total) * 100, 1) : 0 }}%
                            </span>
                        </div>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill"
                             style="width: {{ $total > 0 ? ($data['count'] / $total) * 100 : 0 }}%; background: linear-gradient(to right, {{ $data['color'] }}66, {{ $data['color'] }})">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Top Keywords --}}
        <div class="glass-card-solid p-6">
            <h3 class="font-bold text-[#1E3A5F] dark:text-white mb-5 text-sm">أكثر الكلمات ظهورًا</h3>
            @if(!empty($topKeywords))
            <div class="flex flex-wrap gap-2">
                @php $maxCount = max($topKeywords) ?: 1; @endphp
                @foreach($topKeywords as $kw => $count)
                @php
                    $size = match(true) {
                        $count / $maxCount > 0.8 => 'text-lg font-black',
                        $count / $maxCount > 0.6 => 'text-base font-bold',
                        $count / $maxCount > 0.4 => 'text-sm font-semibold',
                        default                  => 'text-xs font-medium',
                    };
                    $opacity = max(0.4, $count / $maxCount);
                @endphp
                <span class="{{ $size }} px-3 py-1 rounded-full transition-all hover:scale-105 cursor-default"
                      style="background: #6C63FF{{ dechex(intval($opacity * 30)) }}; color: #6C63FF; border: 1px solid #6C63FF{{ dechex(intval($opacity * 50)) }}; opacity: {{ 0.6 + ($count / $maxCount) * 0.4 }}">
                    {{ $kw }}
                    <span class="text-xs font-normal opacity-70">({{ $count }})</span>
                </span>
                @endforeach
            </div>
            @else
            <p class="text-sm text-gray-400 text-center py-8">لا توجد كلمات مكتشفة بعد</p>
            @endif
        </div>
    </div>

    {{-- ── CTA ── --}}
    <div class="text-center py-4">
        <a href="{{ route('analysis.index') }}" class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
            تحليل نص جديد
        </a>
    </div>

    @endif
</div>

@endsection

@push('scripts')
<script>
function statsPage() {
    return {
        init() {
            this.$nextTick(() => {
                const isDark = document.documentElement.classList.contains('dark');
                const textColor = isDark ? '#94a3b8' : '#64748b';
                const gridColor = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.05)';

                @if($stats['total'] > 0)

                // Doughnut
                const dCtx = document.getElementById('doughnutChart');
                if (dCtx) {
                    new Chart(dCtx, {
                        type: 'doughnut',
                        data: {
                            labels: @json(array_map(fn($d) => $d['label'], $distribution)),
                            datasets: [{
                                data: @json(array_map(fn($d) => $d['count'], $distribution)),
                                backgroundColor: @json(array_map(fn($d) => $d['color'] . '99', $distribution)),
                                borderColor:     @json(array_map(fn($d) => $d['color'], $distribution)),
                                borderWidth: 2,
                                hoverOffset: 6,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '60%',
                            plugins: {
                                legend: { display: false },
                                tooltip: { rtl: true, callbacks: { label: ctx => ` ${ctx.label}: ${ctx.parsed}` } }
                            }
                        }
                    });
                }

                // Bar
                const bCtx = document.getElementById('barChart');
                if (bCtx) {
                    new Chart(bCtx, {
                        type: 'bar',
                        data: {
                            labels: @json(array_map(fn($d) => $d['label'], $distribution)),
                            datasets: [{
                                label: 'عدد التحليلات',
                                data: @json(array_map(fn($d) => $d['count'], $distribution)),
                                backgroundColor: @json(array_map(fn($d) => $d['color'] . '80', $distribution)),
                                borderColor:     @json(array_map(fn($d) => $d['color'], $distribution)),
                                borderWidth: 2,
                                borderRadius: 8,
                                borderSkipped: false,
                            }]
                        },
                        options: {
                            responsive: true, maintainAspectRatio: false,
                            plugins: { legend: { display: false }, tooltip: { rtl: true } },
                            scales: {
                                x: { ticks: { color: textColor, font: { family: 'Cairo', size: 10 } }, grid: { color: gridColor } },
                                y: { ticks: { color: textColor, font: { family: 'Cairo' }, stepSize: 1 }, grid: { color: gridColor }, beginAtZero: true }
                            }
                        }
                    });
                }

                // Line
                @if(!empty($dailyStats))
                const lCtx = document.getElementById('lineChart');
                if (lCtx) {
                    new Chart(lCtx, {
                        type: 'line',
                        data: {
                            labels: @json(array_keys($dailyStats)),
                            datasets: [{
                                label: 'التحليلات',
                                data: @json(array_values($dailyStats)),
                                borderColor: '#6C63FF',
                                backgroundColor: 'rgba(108,99,255,0.1)',
                                borderWidth: 2.5,
                                pointBackgroundColor: '#6C63FF',
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                tension: 0.4,
                                fill: true,
                            }]
                        },
                        options: {
                            responsive: true, maintainAspectRatio: false,
                            plugins: { legend: { display: false }, tooltip: { rtl: true } },
                            scales: {
                                x: { ticks: { color: textColor, font: { family: 'Cairo', size: 10 } }, grid: { color: gridColor } },
                                y: { ticks: { color: textColor, font: { family: 'Cairo' }, stepSize: 1 }, grid: { color: gridColor }, beginAtZero: true }
                            }
                        }
                    });
                }
                @endif

                @endif
            });
        }
    };
}
</script>
@endpush
