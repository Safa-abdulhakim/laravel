import StatsOverview from "@/components/statistics/StatsOverview";
import ChartsSection from "@/components/statistics/ChartsSection";
import WordFrequency from "@/components/statistics/WordFrequency";
import { BarChart3, RefreshCw } from "lucide-react";

export const metadata = {
  title: "الإحصائيات | وجدان",
  description: "إحصائيات وتحليلات بيانات منصة وجدان",
};

export default function StatisticsPage() {
  return (
    <div className="min-h-screen pt-24 pb-16" style={{ background: "var(--background)" }}>
      <div className="max-w-7xl mx-auto px-4 sm:px-6">
        {/* Header */}
        <div className="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-10">
          <div>
            <div
              className="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-semibold mb-3"
              style={{
                background: "rgba(108, 99, 255, 0.1)",
                color: "#6C63FF",
                border: "1px solid rgba(108, 99, 255, 0.2)",
              }}
            >
              <BarChart3 className="w-4 h-4" />
              لوحة البيانات
            </div>
            <h1 className="text-3xl sm:text-4xl font-black" style={{ color: "var(--text)" }}>
              إحصائيات{" "}
              <span className="gradient-text">وجدان</span>
            </h1>
            <p className="mt-2 text-base" style={{ color: "var(--text-muted)" }}>
              بيانات وتحليلات شاملة من النظام — تُحدَّث يومياً
            </p>
          </div>

          <button
            className="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all hover:scale-105"
            style={{
              background: "var(--card)",
              color: "var(--text)",
              border: "1px solid var(--border)",
              boxShadow: "var(--shadow-sm)",
            }}
          >
            <RefreshCw className="w-4 h-4" />
            تحديث البيانات
          </button>
        </div>

        {/* Overview Cards */}
        <StatsOverview />

        {/* Charts */}
        <div className="mb-2">
          <h2 className="text-xl font-black mb-6" style={{ color: "var(--text)" }}>
            الرسوم البيانية
          </h2>
          <ChartsSection />
        </div>

        {/* Word Frequency */}
        <div>
          <h2 className="text-xl font-black mb-6" style={{ color: "var(--text)" }}>
            تحليل الكلمات الأكثر تكراراً
          </h2>
          <WordFrequency />
        </div>

        {/* Footer note */}
        <div
          className="mt-4 p-4 rounded-2xl text-center text-sm"
          style={{
            background: "var(--card)",
            border: "1px solid var(--border)",
            color: "var(--text-muted)",
          }}
        >
          📊 جميع البيانات المعروضة هي بيانات تجريبية لأغراض العرض والتظاهر — آخر تحديث: اليوم
        </div>
      </div>
    </div>
  );
}
