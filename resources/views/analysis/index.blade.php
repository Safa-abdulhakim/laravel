@extends('layouts.platform')

@section('title', 'تحليل النص')

@section('content')

{{-- Page Header --}}
<div class="relative bg-gradient-to-bl from-[#0F172A] via-[#1E3A5F] to-[#0F172A] py-14 overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 1px 1px, #6C63FF 1px, transparent 0); background-size: 40px 40px;"></div>
    <div class="absolute top-0 left-1/3 w-64 h-64 bg-[#6C63FF]/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-xl">
            <div class="flex items-center gap-2 mb-4">
                <a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition-colors text-sm">الرئيسية</a>
                <svg class="w-4 h-4 text-gray-600 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-[#6C63FF] text-sm font-medium">التحليل</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-black text-white mb-3">تحليل النص اليمني</h1>
            <p class="text-gray-300 text-base leading-relaxed">
                أدخل أي نص باللهجة اليمنية وسيقوم الذكاء الاصطناعي بتحليله واكتشاف المؤشرات النفسية المحتملة.
            </p>
        </div>
    </div>
</div>

{{-- Main Content --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Analysis Form - Left (Main) --}}
        <div class="lg:col-span-2">
            <div x-data="analysisForm()" class="glass-card-solid p-6 sm:p-8">

                {{-- Form Header --}}
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#6C63FF]/20 to-[#6C63FF]/5 border border-[#6C63FF]/20 flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#6C63FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="font-bold text-[#1E3A5F] dark:text-white">إدخال النص</h2>
                        <p class="text-xs text-gray-400">اللهجة اليمنية • 10-5000 حرف</p>
                    </div>
                </div>

                {{-- Errors --}}
                @if($errors->any())
                <div class="mb-5 bg-red-50 dark:bg-red-900/20 border border-red-200/60 dark:border-red-800/40 rounded-xl p-4">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            @foreach($errors->all() as $error)
                            <p class="text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                {{-- Form --}}
                <form method="POST" action="{{ route('analysis.analyze') }}" @submit="handleSubmit()">
                    @csrf

                    {{-- Textarea --}}
                    <div class="relative mb-6">
                        <textarea
                            name="text"
                            x-model="text"
                            rows="10"
                            maxlength="5000"
                            class="input-field min-h-[260px] font-cairo text-base"
                            placeholder="اكتب ما تشعر به هنا... مثال: أحس بتعب شديد ومو قادر أكمل، كل شي صاير ثقيل عليّ..."
                            :disabled="loading"
                            required
                        >{{ old('text') }}</textarea>

                        {{-- Character Counter --}}
                        <div class="absolute bottom-3 left-3 flex items-center gap-2">
                            <span class="text-xs font-medium transition-colors"
                                  :class="text.length > 4500 ? 'text-red-400' : text.length > 3500 ? 'text-amber-400' : 'text-gray-400'">
                                <span x-text="text.length"></span>/5000
                            </span>
                        </div>
                    </div>

                    {{-- Example Texts --}}
                    <div class="mb-5">
                        <p class="text-xs font-medium text-gray-400 mb-2">نصوص للتجربة:</p>
                        <div class="flex flex-wrap gap-2">
                            @php
                                $examples = [
                                    'أحس بتعب شديد ومو قادر أكمل، كل شي صاير ثقيل عليّ وما عندي أمل في أي شي',
                                    'قلقان كثير وما أقدر أنام من كثرة التفكير، خايف من المستقبل وما أعرف ليش',
                                    'الضغوط فوق طاقتي، كل يوم مشاكل جديدة وما لقيت حل، منهك تمامًا',
                                ];
                            @endphp
                            @foreach($examples as $i => $ex)
                            <button type="button"
                                    @click="text = '{{ addslashes($ex) }}'"
                                    class="text-xs px-3 py-1.5 rounded-full border border-gray-200 dark:border-gray-600/50 text-gray-500 dark:text-gray-400 hover:border-[#6C63FF]/40 hover:text-[#6C63FF] hover:bg-[#6C63FF]/5 transition-all duration-200">
                                مثال {{ $i + 1 }}
                            </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit"
                            :disabled="loading || text.trim().length < 10"
                            class="w-full relative flex items-center justify-center gap-3 px-6 py-4 rounded-xl font-bold text-white text-base
                                   bg-gradient-to-l from-[#1E3A5F] to-[#6C63FF]
                                   hover:shadow-glow disabled:opacity-60 disabled:cursor-not-allowed
                                   hover:scale-[1.02] active:scale-[0.98] disabled:hover:scale-100
                                   transition-all duration-300 overflow-hidden group">

                        {{-- Loading Overlay --}}
                        <div x-show="loading" class="absolute inset-0 bg-gradient-to-l from-[#1E3A5F] to-[#6C63FF] flex items-center justify-center rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="flex gap-1.5">
                                    <div class="w-2 h-2 rounded-full bg-white animate-bounce" style="animation-delay: 0s"></div>
                                    <div class="w-2 h-2 rounded-full bg-white animate-bounce" style="animation-delay: 0.15s"></div>
                                    <div class="w-2 h-2 rounded-full bg-white animate-bounce" style="animation-delay: 0.3s"></div>
                                </div>
                                <span class="text-white font-semibold text-sm" x-text="loadingText"></span>
                            </div>
                        </div>

                        {{-- Normal State --}}
                        <svg x-show="!loading" class="w-5 h-5 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <span x-show="!loading" class="relative z-10">تحليل النص بالذكاء الاصطناعي</span>
                    </button>
                </form>

                {{-- Loading Progress --}}
                <div x-show="loading" x-transition class="mt-4">
                    <div class="flex items-center justify-between text-xs text-gray-400 mb-2">
                        <span x-text="loadingStage"></span>
                        <span x-text="Math.round(progress) + '%'"></span>
                    </div>
                    <div class="h-1.5 bg-gray-100 dark:bg-gray-700/50 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-l from-[#6C63FF] to-[#1E3A5F] rounded-full transition-all duration-500"
                             :style="'width:' + progress + '%'"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-5">

            {{-- How It Works Mini --}}
            <div class="glass-card-solid p-5">
                <h3 class="font-bold text-[#1E3A5F] dark:text-white text-sm mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#6C63FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    كيف يعمل؟
                </h3>
                <div class="space-y-3">
                    @php $miniSteps = [['أدخل النص باللهجة اليمنية في المربع.','#6C63FF'],['يعالج النظام النص ويحلله لغويًا.','#1E3A5F'],['يستخدم AI لاكتشاف المؤشرات النفسية.','#10B981'],['يعرض النتائج مع تفاصيل واضحة.','#F59E0B']]; @endphp
                    @foreach($miniSteps as $i => [$step, $color])
                    <div class="flex items-start gap-3">
                        <div class="w-5 h-5 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0 mt-0.5"
                             style="background: {{ $color }}">{{ $i+1 }}</div>
                        <span class="text-xs text-gray-600 dark:text-gray-400">{{ $step }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Supported Categories --}}
            <div class="glass-card-solid p-5">
                <h3 class="font-bold text-[#1E3A5F] dark:text-white text-sm mb-4">الفئات المكتشفة</h3>
                <div class="space-y-2">
                    @php
                        $cats = [
                            ['مؤشرات الاكتئاب',        '#3B82F6'],
                            ['مؤشرات القلق',           '#F59E0B'],
                            ['مؤشرات الضغوط النفسية',  '#F97316'],
                            ['مؤشرات ثنائي القطب',     '#8B5CF6'],
                            ['مؤشرات الفصام',          '#EF4444'],
                        ];
                    @endphp
                    @foreach($cats as [$cat, $color])
                    <div class="flex items-center gap-2">
                        <div class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background: {{ $color }}"></div>
                        <span class="text-xs text-gray-600 dark:text-gray-400">{{ $cat }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Disclaimer --}}
            <div class="disclaimer-card">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <p class="text-xs text-amber-700 dark:text-amber-300 leading-relaxed font-medium">
                        هذه النتائج لأغراض البحث العلمي فقط ولا تمثل تشخيصًا طبيًا معتمدًا.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function analysisForm() {
    return {
        text: '',
        loading: false,
        progress: 0,
        loadingText: 'جارٍ التحليل...',
        loadingStage: 'معالجة النص...',
        stages: [
            'تنظيف النص ومعالجته...',
            'استخراج الأنماط اللغوية...',
            'تطبيق نموذج الذكاء الاصطناعي...',
            'تحليل المؤشرات النفسية...',
            'إعداد النتائج...',
        ],

        handleSubmit() {
            if (this.text.trim().length < 10) return;
            this.loading = true;
            this.progress = 0;
            let stageIdx = 0;
            this.loadingStage = this.stages[0];

            const interval = setInterval(() => {
                this.progress += Math.random() * 18 + 5;
                if (this.progress > 95) this.progress = 95;

                stageIdx = Math.min(Math.floor((this.progress / 100) * this.stages.length), this.stages.length - 1);
                this.loadingStage = this.stages[stageIdx];
            }, 400);

            // Form will submit naturally; stop the interval when page unloads
            window.addEventListener('beforeunload', () => clearInterval(interval));
        }
    };
}
</script>
@endpush
