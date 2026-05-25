"use client";

import { PenLine, Brain, BarChart3, CheckCircle } from "lucide-react";

const steps = [
  {
    icon: PenLine,
    number: "01",
    title: "اكتب نصك",
    description: "اكتب ما تشعر به باللهجة اليمنية بشكل حر وطبيعي دون قيود",
    color: "#6C63FF",
    bg: "rgba(108, 99, 255, 0.08)",
  },
  {
    icon: Brain,
    number: "02",
    title: "التحليل الذكي",
    description: "يقوم نموذج الذكاء الاصطناعي بتحليل النص واستخراج المؤشرات النفسية",
    color: "#1E3A5F",
    bg: "rgba(30, 58, 95, 0.08)",
  },
  {
    icon: BarChart3,
    number: "03",
    title: "النتائج التفصيلية",
    description: "تحصل على تقرير شامل يوضح التصنيف ونسب الثقة والأعراض المكتشفة",
    color: "#4ECDC4",
    bg: "rgba(78, 205, 196, 0.08)",
  },
  {
    icon: CheckCircle,
    number: "04",
    title: "توصيات ذكية",
    description: "تلقى توصيات ومؤشرات مخصصة تساعد على فهم الحالة النفسية بشكل أوضح",
    color: "#f59e0b",
    bg: "rgba(245, 158, 11, 0.08)",
  },
];

export default function HowItWorks() {
  return (
    <section className="section-padding" id="how-it-works">
      <div className="max-w-7xl mx-auto px-4 sm:px-6">
        <div className="text-center mb-16">
          <div
            className="inline-block px-4 py-1.5 rounded-full text-sm font-semibold mb-4"
            style={{
              background: "rgba(108, 99, 255, 0.1)",
              color: "#6C63FF",
              border: "1px solid rgba(108, 99, 255, 0.2)",
            }}
          >
            آلية العمل
          </div>
          <h2 className="text-3xl sm:text-4xl font-black mb-4" style={{ color: "var(--text)" }}>
            كيف يعمل{" "}
            <span className="gradient-text">وجدان</span>؟
          </h2>
          <p className="text-lg max-w-xl mx-auto" style={{ color: "var(--text-muted)" }}>
            أربع خطوات بسيطة للحصول على تحليل نفسي دقيق
          </p>
        </div>

        <div className="relative">
          {/* Connector line */}
          <div
            className="absolute top-12 right-0 left-0 h-0.5 hidden lg:block"
            style={{
              background: "linear-gradient(90deg, transparent, rgba(108,99,255,0.3), transparent)",
            }}
          />

          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            {steps.map((step, i) => (
              <div
                key={step.number}
                className="relative flex flex-col items-center text-center card-hover"
                style={{ animationDelay: `${i * 0.1}s` }}
              >
                {/* Number badge */}
                <div
                  className="relative z-10 w-20 h-20 rounded-2xl flex items-center justify-center mb-6 shadow-lg"
                  style={{ background: step.bg, border: `2px solid ${step.color}20` }}
                >
                  <step.icon className="w-8 h-8" style={{ color: step.color }} />
                  <div
                    className="absolute -top-3 -left-3 w-7 h-7 rounded-full flex items-center justify-center text-xs font-black text-white"
                    style={{ background: step.color }}
                  >
                    {i + 1}
                  </div>
                </div>

                <h3 className="text-lg font-bold mb-3" style={{ color: "var(--text)" }}>
                  {step.title}
                </h3>
                <p className="text-sm leading-relaxed" style={{ color: "var(--text-muted)" }}>
                  {step.description}
                </p>
              </div>
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}
