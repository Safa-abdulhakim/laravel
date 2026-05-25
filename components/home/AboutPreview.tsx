import Link from "next/link";
import { ArrowLeft, CheckCircle } from "lucide-react";

const points = [
  "تحليل النصوص العربية باللهجة اليمنية باستخدام نماذج NLP متقدمة",
  "التصنيف الدقيق بين الاكتئاب، القلق، والضغوط النفسية",
  "دعم الكشف المبكر وتعزيز الوعي بالصحة النفسية",
  "بناء قاعدة بيانات علمية للدراسات النفسية اليمنية",
];

export default function AboutPreview() {
  return (
    <section className="section-padding" style={{ background: "var(--background)" }}>
      <div className="max-w-7xl mx-auto px-4 sm:px-6">
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
          {/* Visual side */}
          <div className="relative order-2 lg:order-1">
            <div
              className="relative rounded-3xl overflow-hidden"
              style={{
                background: "linear-gradient(135deg, #1E3A5F 0%, #6C63FF 100%)",
                padding: "3px",
              }}
            >
              <div
                className="rounded-3xl p-8"
                style={{ background: "var(--card)" }}
              >
                <div className="text-6xl font-black gradient-text mb-4">وجدان</div>
                <p className="text-lg leading-relaxed mb-6" style={{ color: "var(--text-muted)" }}>
                  كلمة عربية تعني "الشعور والإدراك الداخلي" — اخترناها لأن النظام
                  يحاول فهم المشاعر المخفية في الكلمات.
                </p>
                <div
                  className="p-4 rounded-2xl"
                  style={{ background: "rgba(108, 99, 255, 0.08)", border: "1px solid rgba(108,99,255,0.15)" }}
                >
                  <div className="text-sm font-bold mb-2" style={{ color: "#6C63FF" }}>
                    🎓 مشروع تخرج 2025
                  </div>
                  <div className="text-sm" style={{ color: "var(--text-muted)" }}>
                    جامعة العلوم والتكنولوجيا — قسم علوم الحاسوب
                  </div>
                </div>
              </div>
            </div>
          </div>

          {/* Content side */}
          <div className="order-1 lg:order-2">
            <div
              className="inline-block px-4 py-1.5 rounded-full text-sm font-semibold mb-6"
              style={{
                background: "rgba(108, 99, 255, 0.1)",
                color: "#6C63FF",
                border: "1px solid rgba(108, 99, 255, 0.2)",
              }}
            >
              عن المشروع
            </div>
            <h2 className="text-3xl sm:text-4xl font-black mb-6" style={{ color: "var(--text)" }}>
              مشروع يهدف لتحسين
              <br />
              <span className="gradient-text">الصحة النفسية</span> في اليمن
            </h2>
            <p className="text-lg leading-relaxed mb-8" style={{ color: "var(--text-muted)" }}>
              وجدان هو مشروع تخرج يُطبّق تقنيات معالجة اللغة الطبيعية على اللهجة
              اليمنية لتحليل النصوص واكتشاف الاضطرابات النفسية بشكل مبكر.
            </p>

            <ul className="space-y-4 mb-8">
              {points.map((point) => (
                <li key={point} className="flex items-start gap-3">
                  <CheckCircle className="w-5 h-5 mt-0.5 flex-shrink-0" style={{ color: "#4ECDC4" }} />
                  <span style={{ color: "var(--text-muted)" }}>{point}</span>
                </li>
              ))}
            </ul>

            <Link href="/about" className="btn-primary inline-flex items-center gap-2">
              تعرف على الفريق
              <ArrowLeft className="w-4 h-4" />
            </Link>
          </div>
        </div>
      </div>
    </section>
  );
}
