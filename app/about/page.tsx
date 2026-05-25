import TeamSection from "@/components/about/TeamSection";
import TechStack from "@/components/about/TechStack";
import { Brain, Target, Heart, Lightbulb, CheckCircle, ArrowLeft } from "lucide-react";
import Link from "next/link";

export const metadata = {
  title: "عن المشروع | وجدان",
  description: "تعرف على مشروع وجدان وفريق العمل",
};

const goals = [
  "الكشف المبكر عن الاضطرابات النفسية في المجتمع اليمني",
  "تطوير نموذج NLP مخصص للهجة اليمنية",
  "بناء قاعدة بيانات نفسية موثوقة للأبحاث المستقبلية",
  "رفع الوعي بأهمية الصحة النفسية المبكرة",
  "توفير أداة مجانية وآمنة للتحليل الذاتي",
];

const aiSteps = [
  { step: "01", title: "استقبال النص", desc: "يتلقى النظام النص المكتوب باللهجة اليمنية" },
  { step: "02", title: "المعالجة اللغوية", desc: "يُنظَّف النص ويُرمَّز باستخدام Arabic BERT tokenizer" },
  { step: "03", title: "استخراج الميزات", desc: "يستخرج النموذج الميزات الدلالية والنحوية من النص" },
  { step: "04", title: "التصنيف", desc: "يُطبَّق نموذج التصنيف ويُنتج احتمالات لكل فئة نفسية" },
  { step: "05", title: "النتائج", desc: "تُعرض النتائج بشكل مرئي مع الأعراض والتوصيات" },
];

export default function AboutPage() {
  return (
    <div className="min-h-screen pt-24" style={{ background: "var(--background)" }}>
      {/* Hero */}
      <section
        className="relative py-20 overflow-hidden"
        style={{
          background: "linear-gradient(135deg, #1E3A5F 0%, #6C63FF 100%)",
        }}
      >
        <div className="absolute inset-0 opacity-10">
          <div className="absolute inset-0"
            style={{
              backgroundImage: "radial-gradient(circle at 25% 25%, white 1px, transparent 1px), radial-gradient(circle at 75% 75%, white 1px, transparent 1px)",
              backgroundSize: "40px 40px",
            }}
          />
        </div>
        <div className="relative max-w-4xl mx-auto px-4 sm:px-6 text-center">
          <div
            className="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold mb-6 text-white"
            style={{ background: "rgba(255,255,255,0.15)", backdropFilter: "blur(10px)" }}
          >
            <Brain className="w-4 h-4" />
            مشروع تخرج 2025
          </div>
          <h1 className="text-4xl sm:text-5xl font-black text-white mb-6">
            عن مشروع{" "}
            <span style={{ color: "#4ECDC4" }}>وجدان</span>
          </h1>
          <p className="text-xl text-white/80 leading-relaxed max-w-2xl mx-auto mb-8">
            مشروع تخرج يطبّق أحدث تقنيات الذكاء الاصطناعي ومعالجة اللغة الطبيعية
            لتحليل النصوص النفسية باللهجة اليمنية — لأن الصحة النفسية تستحق الاهتمام.
          </p>
          <Link href="/analysis" className="inline-flex items-center gap-2 px-6 py-3 rounded-full font-bold text-base transition-all hover:scale-105"
            style={{ background: "white", color: "#1E3A5F" }}>
            جرّب المنصة الآن
            <ArrowLeft className="w-4 h-4" />
          </Link>
        </div>
      </section>

      {/* Project Idea + Goals */}
      <section className="section-padding">
        <div className="max-w-7xl mx-auto px-4 sm:px-6">
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-16">
            {/* Project Idea */}
            <div>
              <div className="flex items-center gap-3 mb-6">
                <div className="w-10 h-10 rounded-xl gradient-bg flex items-center justify-center">
                  <Lightbulb className="w-5 h-5 text-white" />
                </div>
                <h2 className="text-2xl font-black" style={{ color: "var(--text)" }}>
                  فكرة المشروع
                </h2>
              </div>
              <p className="text-base leading-relaxed mb-4" style={{ color: "var(--text-muted)" }}>
                في ظل تصاعد أعباء الحياة اليومية وشُح الموارد الصحية النفسية في اليمن،
                جاءت فكرة مشروع <strong style={{ color: "var(--text)" }}>وجدان</strong> لتقديم أداة تقنية
                تساعد في الكشف المبكر عن الاضطرابات النفسية من خلال تحليل ما يكتبه الإنسان.
              </p>
              <p className="text-base leading-relaxed mb-4" style={{ color: "var(--text-muted)" }}>
                الكلمات المكتوبة تحمل دلالات نفسية عميقة — والذكاء الاصطناعي قادر على
                قراءة هذه الدلالات بدقة عالية، خاصة حين يُدرَّب على نصوص باللهجة المحلية.
              </p>
              <p className="text-base leading-relaxed" style={{ color: "var(--text-muted)" }}>
                يميّز النظام بين ثلاثة تصنيفات رئيسية: الاكتئاب، القلق، والضغوط النفسية —
                مما يوفر صورة أوضح وأدق للحالة النفسية.
              </p>
            </div>

            {/* Goals */}
            <div>
              <div className="flex items-center gap-3 mb-6">
                <div className="w-10 h-10 rounded-xl flex items-center justify-center"
                  style={{ background: "rgba(78,205,196,0.1)" }}>
                  <Target className="w-5 h-5" style={{ color: "#4ECDC4" }} />
                </div>
                <h2 className="text-2xl font-black" style={{ color: "var(--text)" }}>
                  أهداف المشروع
                </h2>
              </div>
              <ul className="space-y-4">
                {goals.map((goal) => (
                  <li key={goal} className="flex items-start gap-3">
                    <CheckCircle className="w-5 h-5 mt-0.5 flex-shrink-0" style={{ color: "#4ECDC4" }} />
                    <span style={{ color: "var(--text-muted)" }}>{goal}</span>
                  </li>
                ))}
              </ul>
            </div>
          </div>
        </div>
      </section>

      {/* How AI Works */}
      <section
        className="section-padding"
        style={{
          background: "linear-gradient(135deg, rgba(30,58,95,0.04) 0%, rgba(108,99,255,0.04) 100%)",
        }}
      >
        <div className="max-w-7xl mx-auto px-4 sm:px-6">
          <div className="text-center mb-16">
            <div className="flex items-center justify-center gap-3 mb-4">
              <div className="w-10 h-10 rounded-xl gradient-bg flex items-center justify-center">
                <Brain className="w-5 h-5 text-white" />
              </div>
              <h2 className="text-3xl font-black" style={{ color: "var(--text)" }}>
                كيف يعمل الذكاء الاصطناعي؟
              </h2>
            </div>
            <p className="text-lg" style={{ color: "var(--text-muted)" }}>
              رحلة النص من الإدخال إلى التحليل النهائي
            </p>
          </div>

          <div className="relative">
            <div className="space-y-4 max-w-3xl mx-auto">
              {aiSteps.map((item, i) => (
                <div
                  key={item.step}
                  className="flex items-start gap-5 p-5 rounded-2xl card-hover"
                  style={{
                    background: "var(--card)",
                    border: "1px solid var(--border)",
                    boxShadow: "var(--shadow-sm)",
                  }}
                >
                  <div
                    className="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 font-black text-white text-sm"
                    style={{ background: "linear-gradient(135deg, #1E3A5F, #6C63FF)" }}
                  >
                    {item.step}
                  </div>
                  <div>
                    <h3 className="font-bold mb-1" style={{ color: "var(--text)" }}>
                      {item.title}
                    </h3>
                    <p className="text-sm" style={{ color: "var(--text-muted)" }}>
                      {item.desc}
                    </p>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* Importance section */}
      <section className="section-padding">
        <div className="max-w-7xl mx-auto px-4 sm:px-6">
          <div
            className="rounded-3xl p-10 text-center relative overflow-hidden"
            style={{
              background: "linear-gradient(135deg, #1E3A5F 0%, #6C63FF 100%)",
            }}
          >
            <div className="absolute inset-0 opacity-10"
              style={{
                backgroundImage: "radial-gradient(circle at 50% 50%, white 1px, transparent 1px)",
                backgroundSize: "30px 30px",
              }}
            />
            <Heart className="w-12 h-12 text-white/60 mx-auto mb-4" />
            <h2 className="text-3xl font-black text-white mb-4">
              أهمية التحليل النفسي المبكر
            </h2>
            <p className="text-white/80 text-lg leading-relaxed max-w-2xl mx-auto mb-6">
              الكشف المبكر عن الاضطرابات النفسية يُقلل من تفاقم الحالة ويُحسّن فرص العلاج بنسبة تصل إلى
              <strong className="text-white"> 70%</strong>. وجدان يُشكّل الخطوة الأولى نحو مجتمع أكثر وعياً وصحةً نفسياً.
            </p>
            <Link href="/analysis" className="inline-flex items-center gap-2 px-6 py-3 rounded-full font-bold bg-white transition-all hover:scale-105"
              style={{ color: "#1E3A5F" }}>
              ابدأ التحليل الآن
              <ArrowLeft className="w-4 h-4" />
            </Link>
          </div>
        </div>
      </section>

      {/* Team */}
      <TeamSection />

      {/* Tech Stack */}
      <TechStack />
    </div>
  );
}
