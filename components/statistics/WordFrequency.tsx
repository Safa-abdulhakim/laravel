"use client";

import type { StatsData } from "@/lib/mockData";

const categoryColors: Record<string, string> = {
  depression: "#6C63FF",
  anxiety:    "#4ECDC4",
  stress:     "#f59e0b",
};
const categoryAr: Record<string, string> = {
  depression: "اكتئاب",
  anxiety:    "قلق",
  stress:     "ضغوط",
};

interface Props { stats: StatsData }

export default function WordFrequency({ stats }: Props) {
  // ترتيب الكلمات تنازلياً
  const words = Object.entries(stats.word_frequency)
    .map(([word, data]) => ({ word, ...data }))
    .sort((a, b) => b.count - a.count);

  const maxCount = words[0]?.count || 1;

  // إجماليات حسب التصنيف
  const catTotals = words.reduce<Record<string, number>>((acc, w) => {
    acc[w.category] = (acc[w.category] || 0) + w.count;
    return acc;
  }, {});
  const grandTotal = Object.values(catTotals).reduce((s, v) => s + v, 0) || 1;

  return (
    <div className="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
      {/* Frequency Bars */}
      <div className="rounded-2xl p-6"
        style={{ background: "var(--card)", border: "1px solid var(--border)", boxShadow: "var(--shadow-sm)" }}>
        <h3 className="font-bold text-lg mb-1" style={{ color: "var(--text)" }}>
          الكلمات الأكثر تكراراً
        </h3>
        <p className="text-sm mb-6" style={{ color: "var(--text-muted)" }}>
          الكلمات والعبارات الأكثر ظهوراً في النصوص المحلّلة
        </p>

        {words.length === 0 ? (
          <div className="text-center py-10 text-sm" style={{ color: "var(--text-muted)" }}>
            لا توجد بيانات بعد — ابدأ بتحليل النصوص
          </div>
        ) : (
          <div className="space-y-4">
            {words.slice(0, 10).map((item, i) => {
              const color = categoryColors[item.category] || "#6C63FF";
              return (
                <div key={item.word} className="group">
                  <div className="flex items-center justify-between mb-1.5">
                    <div className="flex items-center gap-2">
                      <span
                        className="text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center text-white"
                        style={{ background: color }}
                      >
                        {i + 1}
                      </span>
                      <span className="font-bold text-sm" style={{ color: "var(--text)" }}>
                        {item.word}
                      </span>
                      <span
                        className="text-xs px-2 py-0.5 rounded-full"
                        style={{ background: `${color}18`, color }}
                      >
                        {categoryAr[item.category] ?? item.category}
                      </span>
                    </div>
                    <span className="text-sm font-black" style={{ color }}>
                      {item.count}
                    </span>
                  </div>
                  <div className="w-full h-2.5 rounded-full overflow-hidden"
                    style={{ background: "var(--background)" }}>
                    <div
                      className="h-full rounded-full transition-all duration-700"
                      style={{ width: `${(item.count / maxCount) * 100}%`, background: color }}
                    />
                  </div>
                </div>
              );
            })}
          </div>
        )}
      </div>

      {/* Word Cloud + Category Totals */}
      <div className="space-y-6">
        {/* Word Cloud */}
        <div className="rounded-2xl p-6"
          style={{ background: "var(--card)", border: "1px solid var(--border)", boxShadow: "var(--shadow-sm)" }}>
          <h3 className="font-bold text-lg mb-6" style={{ color: "var(--text)" }}>سحابة الكلمات</h3>
          {words.length === 0 ? (
            <div className="text-center py-8 text-sm" style={{ color: "var(--text-muted)" }}>
              لا توجد بيانات بعد
            </div>
          ) : (
            <div className="flex flex-wrap justify-center gap-3 py-4">
              {words.map((item) => {
                const color = categoryColors[item.category] || "#6C63FF";
                const size  = 0.75 + (item.count / maxCount) * 1.0;
                return (
                  <span
                    key={item.word}
                    className="font-black cursor-default transition-all duration-300 hover:scale-110 px-3 py-1 rounded-full"
                    style={{
                      fontSize: `${size}rem`,
                      color,
                      background: `${color}12`,
                      border: `1px solid ${color}25`,
                      opacity: 0.6 + (item.count / maxCount) * 0.4,
                    }}
                  >
                    {item.word}
                  </span>
                );
              })}
            </div>
          )}
        </div>

        {/* Category Distribution */}
        <div className="rounded-2xl p-6"
          style={{ background: "var(--card)", border: "1px solid var(--border)", boxShadow: "var(--shadow-sm)" }}>
          <h3 className="font-bold mb-4" style={{ color: "var(--text)" }}>
            توزيع الكلمات حسب التصنيف
          </h3>
          {Object.entries(catTotals).length === 0 ? (
            <div className="text-center py-4 text-sm" style={{ color: "var(--text-muted)" }}>
              لا توجد بيانات بعد
            </div>
          ) : (
            Object.entries(catTotals).map(([cat, total]) => {
              const color = categoryColors[cat] || "#6C63FF";
              const pct   = Math.round((total / grandTotal) * 100);
              return (
                <div key={cat} className="mb-4">
                  <div className="flex justify-between items-center mb-1.5">
                    <div className="flex items-center gap-2">
                      <div className="w-3 h-3 rounded-full" style={{ background: color }} />
                      <span className="text-sm font-semibold" style={{ color: "var(--text)" }}>
                        {categoryAr[cat] ?? cat}
                      </span>
                    </div>
                    <span className="text-sm font-bold" style={{ color }}>
                      {total} تكرار ({pct}%)
                    </span>
                  </div>
                  <div className="w-full h-2 rounded-full overflow-hidden"
                    style={{ background: "var(--background)" }}>
                    <div className="h-full rounded-full"
                      style={{ width: `${pct}%`, background: color }} />
                  </div>
                </div>
              );
            })
          )}
        </div>
      </div>
    </div>
  );
}
