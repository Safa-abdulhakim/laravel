"use client";

import {
  Globe,
  Brain,
  Shield,
  Zap,
  BarChart3,
  Lock,
  Sparkles,
  Target,
} from "lucide-react";

const features = [
  {
    icon: Globe,
    title: "دعم اللهجة اليمنية",
    description: "النموذج مدرّب خصيصاً على نصوص باللهجة اليمنية بكل تنوعاتها المناطقية",
    color: "#6C63FF",
    bg: "rgba(108, 99, 255, 0.08)",
  },
  {
    icon: Brain,
    title: "ذكاء اصطناعي متقدم",
    description: "نماذج تعلم آلي حديثة مدرّبة على آلاف النصوص النفسية العربية",
    color: "#1E3A5F",
    bg: "rgba(30, 58, 95, 0.08)",
  },
  {
    icon: Target,
    title: "تصنيف دقيق",
    description: "يميز بدقة بين الاكتئاب والقلق والضغوط النفسية اليومية",
    color: "#4ECDC4",
    bg: "rgba(78, 205, 196, 0.08)",
  },
  {
    icon: Zap,
    title: "تحليل فوري",
    description: "النتائج خلال ثوانٍ معدودة مع تقرير مفصّل وسهل الفهم",
    color: "#f59e0b",
    bg: "rgba(245, 158, 11, 0.08)",
  },
  {
    icon: BarChart3,
    title: "إحصائيات تفصيلية",
    description: "لوحة تحكم شاملة تعرض توجهات وأنماط التحليلات مع رسوم بيانية",
    color: "#10b981",
    bg: "rgba(16, 185, 129, 0.08)",
  },
  {
    icon: Shield,
    title: "خصوصية تامة",
    description: "لا يتم تخزين أي بيانات شخصية — التحليل يحدث بشكل آمن وسري",
    color: "#ef4444",
    bg: "rgba(239, 68, 68, 0.08)",
  },
  {
    icon: Lock,
    title: "بدون تسجيل",
    description: "استخدم المنصة فوراً بدون إنشاء حساب أو تسجيل دخول",
    color: "#8b5cf6",
    bg: "rgba(139, 92, 246, 0.08)",
  },
  {
    icon: Sparkles,
    title: "تقارير مرئية",
    description: "نتائج معروضة بشكل بصري جميل مع Progress bars وBadges تفصيلية",
    color: "#ec4899",
    bg: "rgba(236, 72, 153, 0.08)",
  },
];

export default function Features() {
  return (
    <section
      className="section-padding"
      style={{ background: "var(--background)" }}
    >
      <div className="max-w-7xl mx-auto px-4 sm:px-6">
        <div className="text-center mb-16">
          <div
            className="inline-block px-4 py-1.5 rounded-full text-sm font-semibold mb-4"
            style={{
              background: "rgba(30, 58, 95, 0.08)",
              color: "#1E3A5F",
              border: "1px solid rgba(30, 58, 95, 0.15)",
            }}
          >
            المميزات
          </div>
          <h2 className="text-3xl sm:text-4xl font-black mb-4" style={{ color: "var(--text)" }}>
            لماذا تختار{" "}
            <span className="gradient-text">وجدان</span>؟
          </h2>
          <p className="text-lg max-w-xl mx-auto" style={{ color: "var(--text-muted)" }}>
            منصة مصممة خصيصاً لتلبية احتياجات المجتمع اليمني في مجال الصحة النفسية
          </p>
        </div>

        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          {features.map((feature, i) => (
            <div
              key={feature.title}
              className="rounded-2xl p-6 card-hover"
              style={{
                background: "var(--card)",
                border: "1px solid var(--border)",
                boxShadow: "var(--shadow-sm)",
                animationDelay: `${i * 0.05}s`,
              }}
            >
              <div
                className="w-12 h-12 rounded-xl flex items-center justify-center mb-4"
                style={{ background: feature.bg }}
              >
                <feature.icon className="w-6 h-6" style={{ color: feature.color }} />
              </div>
              <h3 className="font-bold mb-2 text-base" style={{ color: "var(--text)" }}>
                {feature.title}
              </h3>
              <p className="text-sm leading-relaxed" style={{ color: "var(--text-muted)" }}>
                {feature.description}
              </p>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
