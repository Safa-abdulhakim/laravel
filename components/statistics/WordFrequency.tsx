"use client";

const words = [
  { word: "تعبت", count: 142, category: "اكتئاب", color: "#6C63FF" },
  { word: "حزين", count: 118, category: "اكتئاب", color: "#6C63FF" },
  { word: "خايف", count: 96, category: "قلق", color: "#4ECDC4" },
  { word: "زهقت", count: 87, category: "اكتئاب", color: "#6C63FF" },
  { word: "قلقان", count: 79, category: "قلق", color: "#4ECDC4" },
  { word: "ما أقدر", count: 74, category: "اكتئاب", color: "#6C63FF" },
  { word: "ضغط", count: 68, category: "ضغوط", color: "#f59e0b" },
  { word: "متوتر", count: 61, category: "قلق", color: "#4ECDC4" },
  { word: "مشغول", count: 55, category: "ضغوط", color: "#f59e0b" },
  { word: "وحيد", count: 48, category: "اكتئاب", color: "#6C63FF" },
  { word: "ما في فايدة", count: 43, category: "اكتئاب", color: "#6C63FF" },
  { word: "كثير مشاكل", count: 39, category: "ضغوط", color: "#f59e0b" },
];

const maxCount = Math.max(...words.map((w) => w.count));

const categoryColors: Record<string, string> = {
  "اكتئاب": "#6C63FF",
  "قلق": "#4ECDC4",
  "ضغوط": "#f59e0b",
};

export default function WordFrequency() {
  return (
    <div className="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
      {/* Word Frequency Bars */}
      <div
        className="rounded-2xl p-6"
        style={{ background: "var(--card)", border: "1px solid var(--border)", boxShadow: "var(--shadow-sm)" }}
      >
        <h3 className="font-bold text-lg mb-2" style={{ color: "var(--text)" }}>
          الكلمات الأكثر تكراراً
        </h3>
        <p className="text-sm mb-6" style={{ color: "var(--text-muted)" }}>
          الكلمات والعبارات الأكثر ظهوراً في النصوص المحلّلة
        </p>

        <div className="space-y-4">
          {words.slice(0, 8).map((item, i) => (
            <div key={item.word} className="group">
              <div className="flex items-center justify-between mb-1.5">
                <div className="flex items-center gap-2">
                  <span
                    className="text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center text-white"
                    style={{ background: item.color }}
                  >
                    {i + 1}
                  </span>
                  <span className="font-bold text-sm" style={{ color: "var(--text)" }}>
                    {item.word}
                  </span>
                  <span
                    className="text-xs px-2 py-0.5 rounded-full"
                    style={{
                      background: `${item.color}15`,
                      color: item.color,
                    }}
                  >
                    {item.category}
                  </span>
                </div>
                <span className="text-sm font-black" style={{ color: item.color }}>
                  {item.count}
                </span>
              </div>
              <div
                className="w-full h-2.5 rounded-full overflow-hidden"
                style={{ background: "var(--background)" }}
              >
                <div
                  className="h-full rounded-full transition-all duration-700 group-hover:opacity-80"
                  style={{
                    width: `${(item.count / maxCount) * 100}%`,
                    background: `linear-gradient(90deg, ${item.color}, ${item.color}99)`,
                  }}
                />
              </div>
            </div>
          ))}
        </div>
      </div>

      {/* Word Cloud + Table */}
      <div className="space-y-6">
        {/* Visual Word Cloud */}
        <div
          className="rounded-2xl p-6"
          style={{ background: "var(--card)", border: "1px solid var(--border)", boxShadow: "var(--shadow-sm)" }}
        >
          <h3 className="font-bold text-lg mb-6" style={{ color: "var(--text)" }}>
            سحابة الكلمات
          </h3>
          <div className="flex flex-wrap justify-center gap-3 py-4">
            {words.map((item) => {
              const size = 0.7 + (item.count / maxCount) * 1.1;
              return (
                <span
                  key={item.word}
                  className="font-black cursor-default transition-all duration-300 hover:scale-110 px-3 py-1 rounded-full"
                  style={{
                    fontSize: `${size}rem`,
                    color: item.color,
                    background: `${item.color}12`,
                    border: `1px solid ${item.color}25`,
                    opacity: 0.6 + (item.count / maxCount) * 0.4,
                  }}
                >
                  {item.word}
                </span>
              );
            })}
          </div>
        </div>

        {/* Category Legend */}
        <div
          className="rounded-2xl p-6"
          style={{ background: "var(--card)", border: "1px solid var(--border)", boxShadow: "var(--shadow-sm)" }}
        >
          <h3 className="font-bold mb-4" style={{ color: "var(--text)" }}>
            توزيع الكلمات حسب التصنيف
          </h3>
          {Object.entries(categoryColors).map(([cat, color]) => {
            const catWords = words.filter((w) => w.category === cat);
            const total = catWords.reduce((s, w) => s + w.count, 0);
            const pct = Math.round((total / words.reduce((s, w) => s + w.count, 0)) * 100);
            return (
              <div key={cat} className="mb-4">
                <div className="flex justify-between items-center mb-1.5">
                  <div className="flex items-center gap-2">
                    <div className="w-3 h-3 rounded-full" style={{ background: color }} />
                    <span className="text-sm font-semibold" style={{ color: "var(--text)" }}>
                      {cat}
                    </span>
                  </div>
                  <span className="text-sm font-bold" style={{ color }}>
                    {total} تكرار ({pct}%)
                  </span>
                </div>
                <div
                  className="w-full h-2 rounded-full overflow-hidden"
                  style={{ background: "var(--background)" }}
                >
                  <div
                    className="h-full rounded-full"
                    style={{ width: `${pct}%`, background: color }}
                  />
                </div>
              </div>
            );
          })}
        </div>
      </div>
    </div>
  );
}
