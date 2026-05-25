import StatsOverview from "@/components/statistics/StatsOverview";
import ChartsSection from "@/components/statistics/ChartsSection";
import WordFrequency from "@/components/statistics/WordFrequency";
import { BarChart3, Wifi, WifiOff } from "lucide-react";
import type { StatsData } from "@/lib/mockData";

// جلب البيانات من API (يجدد كل 60 ثانية)
async function fetchStats(): Promise<StatsData & { source: "live" | "demo" }> {
  try {
    const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || "http://localhost:3000";
    const res = await fetch(`${baseUrl}/api/statistics`, {
      next: { revalidate: 60 },
    });
    return res.json();
  } catch {
    const { MOCK_STATS } = await import("@/lib/mockData");
    return { ...MOCK_STATS, source: "demo" };
  }
}

export const metadata = {
  title: "الإحصائيات | وجدان",
  description: "إحصائيات وتحليلات بيانات منصة وجدان",
};

export default async function StatisticsPage() {
  const stats = await fetchStats();
  const isLive = stats.source === "live";

  return (
    <div className="min-h-screen pt-24 pb-16" style={{ background: "var(--background)" }}>
      <div className="max-w-7xl mx-auto px-4 sm:px-6">

        {/* Header */}
        <div className="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-10">
          <div>
            <div
              className="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-semibold mb-3"
              style={{
                background: "rgba(108,99,255,0.1)",
                color: "#6C63FF",
                border: "1px solid rgba(108,99,255,0.2)",
              }}
            >
              <BarChart3 className="w-4 h-4" />
              لوحة البيانات
            </div>
            <h1 className="text-3xl sm:text-4xl font-black" style={{ color: "var(--text)" }}>
              إحصائيات <span className="gradient-text">وجدان</span>
            </h1>
            <p className="mt-2 text-base" style={{ color: "var(--text-muted)" }}>
              بيانات وتحليلات شاملة من النظام
            </p>
          </div>

          {/* مؤشر الاتصال */}
          <div
            className="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold"
            style={{
              background: isLive ? "rgba(16,185,129,0.1)" : "rgba(245,158,11,0.1)",
              border:     isLive ? "1px solid rgba(16,185,129,0.2)" : "1px solid rgba(245,158,11,0.2)",
              color:      isLive ? "#10b981" : "#f59e0b",
            }}
          >
            {isLive
              ? <><Wifi    className="w-4 h-4" /> متصل بـ Python API</>
              : <><WifiOff className="w-4 h-4" /> وضع العرض (Demo)</>
            }
          </div>
        </div>

        {/* Overview Cards */}
        <StatsOverview stats={stats} />

        {/* Charts */}
        <div className="mb-2">
          <h2 className="text-xl font-black mb-6" style={{ color: "var(--text)" }}>الرسوم البيانية</h2>
          <ChartsSection stats={stats} />
        </div>

        {/* Word Frequency */}
        <div>
          <h2 className="text-xl font-black mb-6" style={{ color: "var(--text)" }}>
            تحليل الكلمات الأكثر تكراراً
          </h2>
          <WordFrequency stats={stats} />
        </div>

        {/* Footer note */}
        <div
          className="mt-4 p-4 rounded-2xl text-center text-sm"
          style={{ background: "var(--card)", border: "1px solid var(--border)", color: "var(--text-muted)" }}
        >
          {isLive
            ? "📡 البيانات حقيقية قادمة من Python API — تتحدث كل دقيقة"
            : "📊 بيانات تجريبية للعرض — ستُستبدل بالبيانات الحقيقية عند تشغيل Python API"}
        </div>

      </div>
    </div>
  );
}
