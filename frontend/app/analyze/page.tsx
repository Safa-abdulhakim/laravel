'use client';

import { useState, useRef } from 'react';
import { analyzeText, type AnalyzeResponse } from '@/lib/api';
import { useToast } from '@/components/Toast';

const MAX_CHARS = 2000;

type ResultState =
  | { status: 'idle' }
  | { status: 'loading' }
  | { status: 'success'; data: AnalyzeResponse }
  | { status: 'error'; message: string };

interface CategoryConfig {
  emoji: string;
  label: string;
  description: string;
  cardBg: string;
  border: string;
  titleColor: string;
  badgeBg: string;
  badgeText: string;
  progressColor: string;
  iconBg: string;
}

const categoryConfig: Record<string, CategoryConfig> = {
  اكتئاب: {
    emoji: '😔',
    label: 'اكتئاب',
    description: 'تشير النتائج إلى وجود علامات اكتئابية. يُنصح بالتواصل مع متخصص.',
    cardBg: 'bg-gradient-to-br from-rose-50 to-pink-50',
    border: 'border-rose-200',
    titleColor: 'text-rose-700',
    badgeBg: 'bg-rose-100',
    badgeText: 'text-rose-700',
    progressColor: 'bg-gradient-to-r from-rose-400 to-pink-500',
    iconBg: 'bg-rose-100',
  },
  قلق: {
    emoji: '😰',
    label: 'قلق',
    description: 'تشير النتائج إلى علامات قلق. تمارين التنفس والاسترخاء قد تساعد.',
    cardBg: 'bg-gradient-to-br from-amber-50 to-yellow-50',
    border: 'border-amber-200',
    titleColor: 'text-amber-700',
    badgeBg: 'bg-amber-100',
    badgeText: 'text-amber-700',
    progressColor: 'bg-gradient-to-r from-amber-400 to-yellow-500',
    iconBg: 'bg-amber-100',
  },
  'ضغوط نفسية': {
    emoji: '😤',
    label: 'ضغوط نفسية',
    description: 'تشير النتائج إلى ضغوط نفسية. الراحة وإدارة الوقت مفيدة جداً.',
    cardBg: 'bg-gradient-to-br from-orange-50 to-amber-50',
    border: 'border-orange-200',
    titleColor: 'text-orange-700',
    badgeBg: 'bg-orange-100',
    badgeText: 'text-orange-700',
    progressColor: 'bg-gradient-to-r from-orange-400 to-amber-500',
    iconBg: 'bg-orange-100',
  },
  طبيعي: {
    emoji: '😊',
    label: 'طبيعي',
    description: 'تشير النتائج إلى حالة نفسية طبيعية وصحية. استمر على هذا المنوال!',
    cardBg: 'bg-gradient-to-br from-emerald-50 to-teal-50',
    border: 'border-emerald-200',
    titleColor: 'text-emerald-700',
    badgeBg: 'bg-emerald-100',
    badgeText: 'text-emerald-700',
    progressColor: 'bg-gradient-to-r from-emerald-400 to-teal-500',
    iconBg: 'bg-emerald-100',
  },
};

const defaultCategoryConfig: CategoryConfig = {
  emoji: '🔍',
  label: 'نتيجة التحليل',
  description: 'تم تحليل النص بنجاح.',
  cardBg: 'bg-gradient-to-br from-slate-50 to-blue-50',
  border: 'border-slate-200',
  titleColor: 'text-slate-700',
  badgeBg: 'bg-slate-100',
  badgeText: 'text-slate-700',
  progressColor: 'bg-gradient-to-r from-slate-400 to-blue-500',
  iconBg: 'bg-slate-100',
};

function AnalysisLoadingCard() {
  return (
    <div className="bg-white border-2 border-brand-100 rounded-3xl p-10 text-center shadow-card animate-scale-in">
      <div className="relative mx-auto w-24 h-24 mb-6">
        <div className="absolute inset-0 rounded-full bg-teal-100 animate-ping opacity-60" />
        <div className="relative w-24 h-24 border-4 border-teal-100 border-t-teal-600 rounded-full animate-spin" />
        <div className="absolute inset-0 flex items-center justify-center">
          <span className="text-3xl">🧠</span>
        </div>
      </div>
      <h3 className="text-xl font-bold text-brand-900 mb-2">جاري تحليل النص...</h3>
      <p className="text-slate-500 text-sm mb-6">يتم معالجة النص بالذكاء الاصطناعي</p>
      <div className="flex justify-center gap-2">
        {[0, 1, 2, 3, 4].map((i) => (
          <div
            key={i}
            className="w-2 h-2 rounded-full bg-teal-400"
            style={{
              animation: `bounce 1s ease-in-out ${i * 0.15}s infinite`,
            }}
          />
        ))}
      </div>
    </div>
  );
}

function ResultCard({
  data,
  onReset,
}: {
  data: AnalyzeResponse;
  onReset: () => void;
}) {
  const config = categoryConfig[data.prediction] ?? defaultCategoryConfig;
  const confidence = Math.round(data.confidence * 10) / 10;

  return (
    <div
      className={`${config.cardBg} border-2 ${config.border} rounded-3xl p-8 shadow-card-hover animate-scale-in`}
    >
      {/* Icon */}
      <div className="text-center mb-6">
        <div
          className={`w-20 h-20 ${config.iconBg} rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm`}
        >
          <span className="text-5xl">{config.emoji}</span>
        </div>
        <span
          className={`inline-block px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider ${config.badgeBg} ${config.badgeText}`}
        >
          نتيجة التحليل
        </span>
      </div>

      {/* Category name */}
      <div className="text-center mb-6">
        <h2 className={`text-4xl font-black ${config.titleColor} mb-3`}>
          {data.prediction}
        </h2>
        <p className="text-slate-600 text-sm leading-relaxed max-w-xs mx-auto">
          {config.description}
        </p>
      </div>

      {/* Confidence */}
      <div className="mb-8">
        <div className="flex items-center justify-between mb-2 text-sm font-semibold">
          <span className="text-slate-600">نسبة الثقة</span>
          <span className={`${config.titleColor} font-black text-lg`}>{confidence}%</span>
        </div>
        <div className="w-full bg-white/80 rounded-full h-4 shadow-inner overflow-hidden">
          <div
            className={`h-full rounded-full ${config.progressColor} shadow-sm transition-all duration-1000 ease-out`}
            style={{ width: `${confidence}%` }}
          />
        </div>
        <div className="flex justify-between text-xs text-slate-400 mt-1">
          <span>0%</span>
          <span>100%</span>
        </div>
      </div>

      {/* Disclaimer */}
      <div className="bg-white/60 rounded-2xl p-4 mb-6 border border-white/80">
        <p className="text-xs text-slate-500 text-center leading-relaxed">
          ⚠️ هذا النظام أداة بحثية لأغراض أكاديمية فقط.
          لا يُغني عن الاستشارة المتخصصة مع طبيب نفسي.
        </p>
      </div>

      {/* Reset button */}
      <button
        onClick={onReset}
        className="w-full btn-gradient py-3.5 rounded-2xl font-bold text-white text-base flex items-center justify-center gap-2"
      >
        <span>🔄</span>
        تحليل نص جديد
      </button>
    </div>
  );
}

function ErrorCard({ message, onReset }: { message: string; onReset: () => void }) {
  return (
    <div className="bg-red-50 border-2 border-red-200 rounded-3xl p-8 text-center shadow-card animate-scale-in">
      <div className="text-5xl mb-4">❌</div>
      <h3 className="text-xl font-bold text-red-700 mb-2">حدث خطأ</h3>
      <p className="text-red-600 text-sm mb-6 leading-relaxed">{message}</p>
      <button
        onClick={onReset}
        className="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-semibold transition-colors"
      >
        المحاولة مجدداً
      </button>
    </div>
  );
}

export default function AnalyzePage() {
  const [text, setText] = useState('');
  const [result, setResult] = useState<ResultState>({ status: 'idle' });
  const { showToast } = useToast();
  const textareaRef = useRef<HTMLTextAreaElement>(null);
  const resultRef = useRef<HTMLDivElement>(null);

  const charCount = text.length;
  const isOverLimit = charCount > MAX_CHARS;
  const canAnalyze =
    text.trim().length > 0 && !isOverLimit && result.status !== 'loading';

  const handleAnalyze = async () => {
    if (!canAnalyze) {
      if (text.trim().length === 0) {
        showToast('الرجاء إدخال نص قبل التحليل', 'warning');
        textareaRef.current?.focus();
      }
      return;
    }

    setResult({ status: 'loading' });

    // Scroll to result section
    setTimeout(() => {
      resultRef.current?.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }, 100);

    try {
      const data = await analyzeText(text.trim());
      setResult({ status: 'success', data });
      showToast('تم تحليل النص بنجاح!', 'success');
    } catch (err) {
      const message = err instanceof Error ? err.message : 'حدث خطأ غير متوقع';
      setResult({ status: 'error', message });
      showToast(message, 'error');
    }
  };

  const handleReset = () => {
    setResult({ status: 'idle' });
    setText('');
    setTimeout(() => textareaRef.current?.focus(), 100);
  };

  const handleKeyDown = (e: React.KeyboardEvent<HTMLTextAreaElement>) => {
    if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
      e.preventDefault();
      handleAnalyze();
    }
  };

  return (
    <div className="min-h-screen bg-gradient-to-b from-slate-50 to-white">
      {/* ─── Header ─── */}
      <div className="hero-bg py-14 text-center">
        <div className="floating-shape w-48 h-48 top-[-20px] right-[5%]" style={{ animationDelay: '0s' }} />
        <div className="floating-shape w-32 h-32 bottom-[-10px] left-[10%]" style={{ animationDelay: '2s' }} />
        <div className="relative z-10 max-w-2xl mx-auto px-4">
          <div className="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-4 py-1.5 mb-6 text-white/80 text-sm">
            <span className="w-2 h-2 bg-teal-400 rounded-full animate-pulse" />
            تحليل بالذكاء الاصطناعي
          </div>
          <h1 className="text-3xl sm:text-4xl md:text-5xl font-black text-white mb-4">
            تحليل النص اليمني
          </h1>
          <p className="text-white/70 text-base sm:text-lg leading-relaxed">
            أدخل نصاً باللهجة اليمنية لتحليل الحالة النفسية تلقائياً
          </p>
        </div>
      </div>

      {/* ─── Main content ─── */}
      <div className="max-w-2xl mx-auto px-4 sm:px-6 py-12 space-y-8">

        {/* Input Card */}
        <div className="glass-card-light p-6 sm:p-8 border border-slate-100 shadow-card">
          <div className="flex items-center justify-between mb-4">
            <label
              htmlFor="input-text"
              className="font-bold text-brand-900 text-lg"
            >
              أدخل النص هنا
            </label>
            {text.length > 0 && (
              <button
                onClick={() => { setText(''); textareaRef.current?.focus(); }}
                className="text-slate-400 hover:text-red-500 text-sm transition-colors flex items-center gap-1"
              >
                <span>مسح</span>
                <span>✕</span>
              </button>
            )}
          </div>

          <div className="relative">
            <textarea
              id="input-text"
              ref={textareaRef}
              value={text}
              onChange={(e) => setText(e.target.value)}
              onKeyDown={handleKeyDown}
              placeholder="اكتب النص باللهجة اليمنية هنا... مثال: أنا تعبان ومو قادر أنام الليل، كل شي يضايقني"
              disabled={result.status === 'loading'}
              rows={7}
              maxLength={MAX_CHARS + 50}
              className={`
                w-full resize-none border-2 rounded-2xl p-4 text-base leading-relaxed
                focus:outline-none transition-all duration-200 bg-white
                placeholder:text-slate-400 text-slate-800
                disabled:opacity-50 disabled:cursor-not-allowed
                ${isOverLimit
                  ? 'border-red-300 focus:border-red-400 bg-red-50/30'
                  : 'border-slate-200 focus:border-teal-400 focus:shadow-[0_0_0_3px_rgba(15,118,110,0.1)]'
                }
              `}
            />

            {/* Char counter */}
            <div
              className={`absolute bottom-3 left-3 text-xs font-medium px-2 py-1 rounded-lg ${
                isOverLimit
                  ? 'bg-red-100 text-red-600'
                  : charCount > MAX_CHARS * 0.85
                  ? 'bg-amber-100 text-amber-600'
                  : 'bg-slate-100 text-slate-500'
              }`}
            >
              {charCount} / {MAX_CHARS} حرف
            </div>
          </div>

          {isOverLimit && (
            <p className="mt-2 text-red-500 text-xs">
              تجاوز النص الحد المسموح به ({MAX_CHARS} حرف).
            </p>
          )}

          <p className="mt-3 text-slate-400 text-xs">
            💡 اضغط Ctrl + Enter للتحليل السريع
          </p>
        </div>

        {/* Analyze Button */}
        <button
          onClick={handleAnalyze}
          disabled={!canAnalyze}
          className={`
            w-full py-4 sm:py-5 rounded-2xl font-black text-xl flex items-center justify-center gap-3
            transition-all duration-300 shadow-lg
            ${canAnalyze
              ? 'btn-gradient hover:scale-[1.02] active:scale-[0.98]'
              : 'bg-slate-200 text-slate-400 cursor-not-allowed'
            }
          `}
        >
          {result.status === 'loading' ? (
            <>
              <div className="w-6 h-6 border-2 border-white/30 border-t-white rounded-full animate-spin" />
              <span>جاري التحليل...</span>
            </>
          ) : (
            <>
              <span className="text-2xl">🔍</span>
              <span>تحليل النص</span>
            </>
          )}
        </button>

        {/* Result Section */}
        {result.status !== 'idle' && (
          <div ref={resultRef} className="animate-slide-in-up">
            {result.status === 'loading' && <AnalysisLoadingCard />}
            {result.status === 'success' && (
              <ResultCard data={result.data} onReset={handleReset} />
            )}
            {result.status === 'error' && (
              <ErrorCard message={result.message} onReset={handleReset} />
            )}
          </div>
        )}

        {/* Help card */}
        {result.status === 'idle' && (
          <div className="bg-blue-50 border border-blue-100 rounded-2xl p-5">
            <h4 className="font-bold text-blue-800 mb-3 flex items-center gap-2">
              <span>💡</span> تصنيفات النظام
            </h4>
            <div className="grid grid-cols-2 gap-2 text-sm">
              {[
                { label: 'اكتئاب', emoji: '😔', color: 'text-rose-600' },
                { label: 'قلق', emoji: '😰', color: 'text-amber-600' },
                { label: 'ضغوط نفسية', emoji: '😤', color: 'text-orange-600' },
                { label: 'طبيعي', emoji: '😊', color: 'text-emerald-600' },
              ].map(({ label, emoji, color }) => (
                <div key={label} className="flex items-center gap-2 bg-white rounded-xl p-2.5 shadow-sm">
                  <span>{emoji}</span>
                  <span className={`font-semibold ${color}`}>{label}</span>
                </div>
              ))}
            </div>
          </div>
        )}
      </div>
    </div>
  );
}
