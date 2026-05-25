"use client";

const steps = [
  "تحليل النص اللغوي...",
  "استخراج المؤشرات النفسية...",
  "تطبيق نموذج الذكاء الاصطناعي...",
  "إنتاج التقرير النهائي...",
];

export default function LoadingAnimation() {
  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center"
      style={{ background: "rgba(0,0,0,0.5)", backdropFilter: "blur(8px)" }}>
      <div
        className="rounded-3xl p-10 text-center max-w-sm w-full mx-4 shadow-2xl"
        style={{ background: "var(--card)" }}
      >
        {/* Animated brain icon */}
        <div className="relative w-20 h-20 mx-auto mb-6">
          <div
            className="absolute inset-0 rounded-full animate-ping opacity-20"
            style={{ background: "linear-gradient(135deg, #6C63FF, #4ECDC4)" }}
          />
          <div
            className="absolute inset-2 rounded-full animate-pulse"
            style={{ background: "linear-gradient(135deg, #1E3A5F, #6C63FF)" }}
          />
          <div className="absolute inset-0 flex items-center justify-center">
            <span className="text-2xl">🧠</span>
          </div>
        </div>

        <h3 className="text-lg font-bold mb-2" style={{ color: "var(--text)" }}>
          جارٍ تحليل النص
        </h3>
        <p className="text-sm mb-6" style={{ color: "var(--text-muted)" }}>
          يعمل النموذج على تحليل نصك بدقة...
        </p>

        {/* Steps */}
        <div className="space-y-2 text-right mb-6">
          {steps.map((step, i) => (
            <div
              key={step}
              className="flex items-center gap-3 p-3 rounded-xl text-sm"
              style={{
                background: i === 2 ? "rgba(108,99,255,0.1)" : "var(--background)",
                color: i === 2 ? "#6C63FF" : "var(--text-muted)",
                fontWeight: i === 2 ? "600" : "400",
              }}
            >
              <div
                className="w-5 h-5 rounded-full flex-shrink-0 flex items-center justify-center text-xs"
                style={{
                  background: i < 2 ? "#4ECDC4" : i === 2 ? "#6C63FF" : "var(--border)",
                  color: i <= 2 ? "white" : "var(--text-muted)",
                }}
              >
                {i < 2 ? "✓" : i === 2 ? <span className="animate-pulse">●</span> : "○"}
              </div>
              {step}
            </div>
          ))}
        </div>

        {/* Progress bar */}
        <div
          className="w-full h-2 rounded-full overflow-hidden"
          style={{ background: "var(--background)" }}
        >
          <div
            className="h-full rounded-full"
            style={{
              width: "65%",
              background: "linear-gradient(90deg, #1E3A5F, #6C63FF, #4ECDC4)",
              backgroundSize: "200% 100%",
              animation: "shimmer 1.5s infinite",
            }}
          />
        </div>
      </div>
    </div>
  );
}
