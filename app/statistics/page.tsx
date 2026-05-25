import type { Metadata } from "next";
import { MOCK_STATISTICS } from "@/lib/mock-data";
import { KPICards } from "@/components/statistics/KPICards";
import { ChartsSection } from "@/components/statistics/ChartsSection";
import { WordFrequency } from "@/components/statistics/WordFrequency";

// ─── Metadata ─────────────────────────────────────────────────────────────────

export const metadata: Metadata = {
  title: "لوحة الإحصائيات",
  description:
    "تصفّح إحصائيات شاملة حول تحليلات الصحة النفسية — توزيع الحالات، الكلمات الأكثر تكراراً، الاتجاهات الشهرية، ومستويات الدقة.",
};

// ─── Page ─────────────────────────────────────────────────────────────────────

export default function StatisticsPage() {
  const stats = MOCK_STATISTICS;

  return (
    <div className="min-h-screen bg-gradient-to-br from-slate-50 via-white to-violet-50/30 dark:from-navy-950 dark:via-navy-900 dark:to-navy-800">
      {/* Background decoration */}
      <div className="fixed inset-0 overflow-hidden pointer-events-none -z-10">
        <div className="absolute top-20 right-0 w-96 h-96 bg-violet-500/5 dark:bg-violet-500/10 rounded-full blur-3xl" />
        <div className="absolute bottom-40 left-0 w-80 h-80 bg-depression/5 dark:bg-depression/10 rounded-full blur-3xl" />
        <div className="absolute top-1/2 left-1/2 -translate-x-1/2 w-[600px] h-[400px] bg-navy-500/3 rounded-full blur-3xl" />
      </div>

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        {/* ── Page Header ─────────────────────────────────────────────────── */}
        <div className="mb-10">
          <div className="inline-flex items-center gap-2 bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300 rounded-full px-3 py-1.5 text-xs font-semibold mb-4">
            <span className="w-1.5 h-1.5 bg-violet-500 rounded-full animate-pulse" />
            بيانات محدّثة لحظياً
          </div>

          <h1 className="text-3xl sm:text-4xl font-extrabold text-navy-900 dark:text-white tracking-tight mb-3">
            لوحة الإحصائيات
          </h1>
          <p className="text-navy-500 dark:text-navy-400 max-w-2xl leading-relaxed">
            نظرة شاملة على بيانات التحليلات النفسية — من توزيع الحالات إلى الكلمات الأكثر تكراراً
            واتجاهات النمو الشهري. جميع البيانات مجهولة الهوية تماماً.
          </p>

          {/* Quick stats bar */}
          <div className="flex flex-wrap gap-3 mt-5">
            {[
              { label: "تحليل منجز", value: stats.totalAnalyses.toLocaleString("ar-EG") },
              { label: "أعلى فئة: اكتئاب", value: `${((stats.depressionCount / stats.totalAnalyses) * 100).toFixed(1)}%` },
              { label: "دقة متوسطة", value: `${(stats.avgConfidence * 100).toFixed(0)}%` },
              { label: "نمو أسبوعي", value: `+${stats.weeklyGrowth}%` },
            ].map((item) => (
              <div
                key={item.label}
                className="flex items-center gap-2 bg-white/70 dark:bg-navy-800/50 border border-navy-100/60 dark:border-navy-700/40 rounded-xl px-4 py-2 text-sm shadow-glass"
              >
                <span className="font-extrabold text-navy-800 dark:text-white">{item.value}</span>
                <span className="text-navy-400 dark:text-navy-400">{item.label}</span>
              </div>
            ))}
          </div>
        </div>

        {/* ── KPI Cards ────────────────────────────────────────────────────── */}
        <section className="mb-8">
          <KPICards />
        </section>

        {/* ── Charts Section ───────────────────────────────────────────────── */}
        <section className="mb-8">
          <div className="flex items-center gap-3 mb-5">
            <h2 className="text-lg font-bold text-navy-800 dark:text-white">الرسوم البيانية</h2>
            <div className="flex-1 h-px bg-gradient-to-l from-transparent via-navy-200 dark:via-navy-700 to-transparent" />
          </div>
          <ChartsSection stats={stats} />
        </section>

        {/* ── Word Frequency ───────────────────────────────────────────────── */}
        <section className="mb-8">
          <div className="flex items-center gap-3 mb-5">
            <h2 className="text-lg font-bold text-navy-800 dark:text-white">
              تحليل الكلمات المفتاحية
            </h2>
            <div className="flex-1 h-px bg-gradient-to-l from-transparent via-navy-200 dark:via-navy-700 to-transparent" />
          </div>
          <WordFrequency keywords={stats.topKeywords} />
        </section>

        {/* ── Footer note ──────────────────────────────────────────────────── */}
        <p className="text-center text-xs text-navy-400 dark:text-navy-500 pb-4">
          جميع البيانات المعروضة مجهولة الهوية ولا تحتوي على أي معلومات شخصية قابلة للتعريف.
          هذه الإحصائيات تُستخدم لأغراض بحثية وتحسين النموذج فحسب.
        </p>
      </div>
    </div>
  );
}
