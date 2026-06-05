"use client";

import Link from "next/link";
import { useEffect, useRef, useState } from "react";

/* ────────────────────────────────────────────────────────────
   Data
   ──────────────────────────────────────────────────────────── */
const steps = [
  {
    number: "١",
    icon: "✏️",
    title: "أدخل النص",
    desc: "اكتب أو الصق نصاً باللهجة اليمنية في حقل الإدخال",
  },
  {
    number: "٢",
    icon: "🔬",
    title: "معالجة اللغة الطبيعية",
    desc: "يقوم النظام بتنظيف النص وتحليل مكوناته اللغوية",
  },
  {
    number: "٣",
    icon: "🤖",
    title: "التحليل بالذكاء الاصطناعي",
    desc: "يُطبَّق نموذج التعلم العميق المدرَّب على اللهجة اليمنية",
  },
  {
    number: "٤",
    icon: "📊",
    title: "استقبل النتيجة",
    desc: "تظهر نتيجة التصنيف النفسي مع نسبة الثقة بشكل واضح",
  },
];

const objectives = [
  {
    icon: "🎯",
    title: "الكشف المبكر",
    desc: "تحديد الحالات النفسية مبكرًا من خلال تحليل أنماط الكتابة باللهجة اليمنية",
    colorCard: "from-rose-50 to-pink-50 border-rose-200",
    iconBg: "bg-rose-100",
  },
  {
    icon: "🧠",
    title: "دعم الصحة النفسية",
    desc: "توعية المجتمع اليمني وتقديم أداة فعالة لدعم الصحة النفسية",
    colorCard: "from-purple-50 to-violet-50 border-purple-200",
    iconBg: "bg-purple-100",
  },
  {
    icon: "📈",
    title: "دقة عالية",
    desc: "الوصول إلى نسبة دقة مرتفعة في تصنيف الحالات النفسية الأربع",
    colorCard: "from-teal-50 to-emerald-50 border-teal-200",
    iconBg: "bg-teal-100",
  },
  {
    icon: "🌍",
    title: "خدمة المجتمع",
    desc: "دعم اللهجة اليمنية في مجال معالجة اللغة الطبيعية وتعزيز الهوية اللغوية",
    colorCard: "from-sky-50 to-blue-50 border-sky-200",
    iconBg: "bg-sky-100",
  },
];

const team = [
  {
    initials: "سع",
    name: "سفاء عبدالحكيم",
    role: "قائد الفريق",
    gradient: "from-teal-600 to-brand-900",
    color: "teal",
  },
  {
    initials: "عض",
    name: "عضو الفريق 2",
    role: "مطور الخلفية",
    gradient: "from-purple-600 to-indigo-700",
    color: "purple",
  },
  {
    initials: "عض",
    name: "عضو الفريق 3",
    role: "مطور الواجهة",
    gradient: "from-rose-500 to-pink-700",
    color: "rose",
  },
];

/* ────────────────────────────────────────────────────────────
   Animated Counter Component
   ──────────────────────────────────────────────────────────── */
function AnimatedCounter({
  target,
  suffix = "",
}: {
  target: number;
  suffix?: string;
}) {
  const [count, setCount] = useState(0);
  const ref = useRef<HTMLSpanElement>(null);
  const started = useRef(false);

  useEffect(() => {
    const el = ref.current;
    if (!el) return;
    const observer = new IntersectionObserver(
      ([entry]) => {
        if (entry.isIntersecting && !started.current) {
          started.current = true;
          const totalDuration = 1600;
          const fps = 60;
          const totalFrames = (totalDuration / 1000) * fps;
          let frame = 0;
          const timer = setInterval(() => {
            frame++;
            const progress = frame / totalFrames;
            // easeOut
            const eased = 1 - Math.pow(1 - progress, 3);
            setCount(Math.round(eased * target));
            if (frame >= totalFrames) {
              clearInterval(timer);
              setCount(target);
            }
          }, 1000 / fps);
        }
      },
      { threshold: 0.5 }
    );
    observer.observe(el);
    return () => observer.unobserve(el);
  }, [target]);

  return (
    <span ref={ref}>
      {count}
      {suffix}
    </span>
  );
}

/* ────────────────────────────────────────────────────────────
   Home Page
   ──────────────────────────────────────────────────────────── */
export default function HomePage() {
  const scrollToAbout = () => {
    document.getElementById("about")?.scrollIntoView({ behavior: "smooth" });
  };

  return (
    <div className="overflow-x-hidden">

      {/* ══════════════════════════════════════════════
          HERO SECTION
          ══════════════════════════════════════════════ */}
      <section className="hero-bg relative min-h-[92vh] flex items-center justify-center px-4 py-20 sm:py-24">

        {/* Decorative floating blobs */}
        <div
          className="floating-shape w-80 h-80 -top-20 -right-20"
          style={{ animationDelay: "0s" }}
          aria-hidden
        />
        <div
          className="floating-shape w-60 h-60 bottom-10 -left-16"
          style={{ animationDelay: "1.5s" }}
          aria-hidden
        />
        <div
          className="floating-shape w-36 h-36 top-1/3 left-1/3"
          style={{ animationDelay: "3s" }}
          aria-hidden
        />

        {/* Content wrapper */}
        <div className="relative z-10 max-w-4xl mx-auto text-center">

          {/* Badge */}
          <div className="inline-flex items-center gap-2.5 px-5 py-2 rounded-full bg-white/10 border border-white/25 backdrop-blur-sm text-white/85 text-sm font-medium mb-8">
            <span className="w-2.5 h-2.5 rounded-full bg-teal-400 animate-pulse-slow" />
            مشروع تخرج أكاديمي — الذكاء الاصطناعي
          </div>

          {/* Main heading */}
          <h1 className="text-5xl sm:text-6xl md:text-7xl xl:text-8xl font-black leading-tight mb-6">
            <span className="gradient-text">محلل اللهجة</span>
            <br />
            <span className="text-white drop-shadow-lg">اليمنية</span>
          </h1>

          {/* Subtitle */}
          <p className="text-white/75 text-base sm:text-lg md:text-xl leading-loose max-w-2xl mx-auto mb-10 px-2">
            نظام ذكاء اصطناعي متقدم يُحلِّل النصوص المكتوبة باللهجة اليمنية
            للكشف المبكر عن الحالات النفسية باستخدام تقنيات معالجة اللغة الطبيعية
          </p>

          {/* CTA Buttons */}
          <div className="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <Link
              href="/analyze"
              className="
                btn-gradient px-9 py-4 rounded-2xl text-lg font-bold text-white
                flex items-center gap-3 group w-full sm:w-auto justify-center
                shadow-brand-lg
              "
            >
              <span className="text-2xl group-hover:rotate-12 group-hover:scale-110 transition-transform duration-300" aria-hidden>
                🧠
              </span>
              ابدأ التحليل
            </Link>

            <button
              onClick={scrollToAbout}
              className="
                btn-outline-white px-9 py-4 rounded-2xl text-lg font-bold
                flex items-center gap-3 group w-full sm:w-auto justify-center
              "
              aria-label="التمرير لقسم عن المشروع"
            >
              تعرف أكثر
              <svg
                className="w-5 h-5 group-hover:translate-y-1 transition-transform duration-300"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                strokeWidth={2.5}
                aria-hidden
              >
                <path strokeLinecap="round" strokeLinejoin="round" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
          </div>

          {/* Stats row */}
          <div className="mt-16 grid grid-cols-3 gap-3 sm:gap-6 max-w-md mx-auto">
            {[
              { value: 4, suffix: "", label: "تصنيفات" },
              { value: 95, suffix: "%", label: "دقة" },
              { value: 3, suffix: "", label: "أعضاء" },
            ].map(({ value, suffix, label }) => (
              <div
                key={label}
                className="glass-card px-3 py-4 rounded-2xl text-center"
              >
                <p className="text-2xl sm:text-3xl font-black text-white ltr-only">
                  <AnimatedCounter target={value} suffix={suffix} />
                </p>
                <p className="text-white/60 text-xs sm:text-sm mt-1">{label}</p>
              </div>
            ))}
          </div>
        </div>

        {/* Wave divider */}
        <div className="absolute bottom-0 left-0 right-0 overflow-hidden" aria-hidden>
          <svg
            viewBox="0 0 1440 56"
            preserveAspectRatio="none"
            className="w-full h-10 sm:h-14 fill-slate-50 block"
          >
            <path d="M0,32 C480,70 960,0 1440,32 L1440,56 L0,56 Z" />
          </svg>
        </div>
      </section>

      {/* ══════════════════════════════════════════════
          ABOUT SECTION
          ══════════════════════════════════════════════ */}
      <section id="about" className="py-20 sm:py-28 bg-slate-50 px-4">
        <div className="max-w-5xl mx-auto">

          {/* Section header */}
          <div className="text-center mb-14">
            <span className="inline-block px-4 py-1.5 rounded-full bg-teal-50 text-teal-700 text-sm font-bold border border-teal-200 mb-4">
              نبذة عن المشروع
            </span>
            <h2 className="text-3xl sm:text-4xl font-extrabold text-brand-900 mb-4">
              <span className="section-title">عن المشروع</span>
            </h2>
            <p className="text-slate-500 text-base sm:text-lg max-w-xl mx-auto leading-relaxed mt-6">
              نظرة شاملة على هذا النظام وما يُقدمه للمجتمع اليمني
            </p>
          </div>

          {/* About main card */}
          <div className="glass-card-light border border-slate-100 p-8 sm:p-10 shadow-card mb-8">
            <div className="flex flex-col md:flex-row gap-8 items-center">

              {/* Animated icon */}
              <div className="flex-shrink-0 flex justify-center">
                <div
                  className="
                    w-28 h-28 sm:w-36 sm:h-36 rounded-3xl
                    bg-gradient-to-br from-brand-900 to-teal-700
                    flex items-center justify-center
                    shadow-brand animate-bounce-gentle
                  "
                >
                  <span className="text-5xl sm:text-6xl" aria-hidden>🧠</span>
                </div>
              </div>

              {/* Text */}
              <div className="flex-1 text-center md:text-right">
                <h3 className="text-xl sm:text-2xl font-extrabold text-brand-900 mb-4">
                  محلل الصحة النفسية باللهجة اليمنية
                </h3>
                <p className="text-slate-600 leading-loose text-sm sm:text-base mb-4">
                  نظام ذكاء اصطناعي متكامل يستخدم تقنيات <strong className="text-brand-900">معالجة اللغة الطبيعية (NLP)</strong> لتحليل النصوص
                  المكتوبة باللهجة اليمنية العامية. يُصنِّف النظام النصوص إلى أربع فئات:
                  اكتئاب، قلق، ضغوط نفسية، أو طبيعي.
                </p>
                <p className="text-slate-500 leading-loose text-sm">
                  يُعدّ هذا المشروع إسهامًا أكاديميًا في مجال معالجة اللغات العربية،
                  لا سيما فيما يتعلق باللهجات المحلية التي تعاني من شُحّ في الموارد البحثية.
                </p>

                {/* Tags */}
                <div className="flex flex-wrap gap-2 justify-center md:justify-end mt-5">
                  {[
                    "NLP",
                    "تعلم عميق",
                    "اللهجة اليمنية",
                    "صحة نفسية",
                    "Next.js",
                    "Python",
                  ].map((tag) => (
                    <span
                      key={tag}
                      className="px-3 py-1 rounded-full bg-teal-50 text-teal-700 text-xs font-semibold border border-teal-100 hover:bg-teal-100 transition-colors"
                    >
                      {tag}
                    </span>
                  ))}
                </div>
              </div>
            </div>

            {/* Info grid */}
            <div className="mt-8 pt-8 border-t border-slate-100 grid grid-cols-2 sm:grid-cols-4 gap-4">
              {[
                { icon: "📝", label: "اللهجة", value: "اليمنية" },
                { icon: "🏷️", label: "التصنيفات", value: "٤ فئات" },
                { icon: "🤖", label: "التقنية", value: "Deep Learning" },
                { icon: "🎓", label: "النوع", value: "مشروع تخرج" },
              ].map(({ icon, label, value }) => (
                <div
                  key={label}
                  className="text-center p-3 rounded-xl bg-slate-50 hover:bg-teal-50 transition-colors duration-200"
                >
                  <span className="text-2xl block mb-1.5" aria-hidden>{icon}</span>
                  <p className="text-xs text-slate-500 mb-0.5">{label}</p>
                  <p className="text-sm font-bold text-brand-900">{value}</p>
                </div>
              ))}
            </div>
          </div>

          {/* Feature cards grid */}
          <div className="grid grid-cols-1 sm:grid-cols-2 gap-5">
            {[
              {
                icon: "🎓",
                title: "مشروع أكاديمي",
                desc: "يجمع بين علوم الحاسوب ومعالجة اللغة وعلم النفس لخدمة المجتمع اليمني.",
              },
              {
                icon: "🧬",
                title: "تقنية متقدمة",
                desc: "نماذج تعلم آلة مدربة على بيانات حقيقية مع معالجة خاصة لخصائص اللهجة اليمنية.",
              },
              {
                icon: "💡",
                title: "فكرة النظام",
                desc: "المستخدم يُدخل النص فيعالجه النظام ويصنّفه: اكتئاب، قلق، ضغوط نفسية، أو طبيعي.",
              },
              {
                icon: "🌐",
                title: "واجهة حديثة",
                desc: "مبنيّة بـ Next.js وTailwind CSS مع دعم كامل للغة العربية واتجاه RTL.",
              },
            ].map(({ icon, title, desc }) => (
              <div
                key={title}
                className="glass-card-light border border-slate-100 p-6 card-hover hover:border-teal-200"
              >
                <div className="flex items-start gap-4">
                  <div
                    className="
                      w-12 h-12 rounded-xl flex-shrink-0
                      bg-gradient-to-br from-brand-900 to-teal-700
                      flex items-center justify-center
                      shadow-sm text-2xl
                    "
                    aria-hidden
                  >
                    {icon}
                  </div>
                  <div>
                    <h3 className="font-bold text-brand-900 text-base mb-1.5">{title}</h3>
                    <p className="text-slate-500 text-sm leading-relaxed">{desc}</p>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* ══════════════════════════════════════════════
          HOW IT WORKS SECTION
          ══════════════════════════════════════════════ */}
      <section className="py-20 sm:py-28 bg-white px-4">
        <div className="max-w-5xl mx-auto">

          {/* Section header */}
          <div className="text-center mb-14">
            <span className="inline-block px-4 py-1.5 rounded-full bg-brand-50 text-brand-700 text-sm font-bold border border-brand-200 mb-4">
              طريقة العمل
            </span>
            <h2 className="text-3xl sm:text-4xl font-extrabold text-brand-900 mb-4">
              <span className="section-title">كيف يعمل النظام؟</span>
            </h2>
            <p className="text-slate-500 text-base sm:text-lg max-w-xl mx-auto mt-6">
              أربع خطوات بسيطة من إدخال النص إلى استقبال النتيجة
            </p>
          </div>

          {/* Steps */}
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {steps.map((step, i) => (
              <div key={i} className="relative group">
                {/* Arrow connector for desktop */}
                {i < steps.length - 1 && (
                  <div
                    className="hidden lg:flex absolute top-10 -left-3 z-10 items-center justify-center w-6 h-6 text-teal-400 text-lg font-bold"
                    aria-hidden
                  >
                    ←
                  </div>
                )}

                <div
                  className="
                    glass-card-light border border-slate-100
                    p-6 h-full text-center
                    card-hover hover:border-teal-200
                  "
                >
                  {/* Step number badge */}
                  <div className="flex justify-center mb-4">
                    <span
                      className="
                        step-badge text-base
                        group-hover:scale-110 transition-transform duration-300
                      "
                    >
                      {step.number}
                    </span>
                  </div>

                  {/* Emoji */}
                  <div className="text-4xl mb-4" aria-hidden>{step.icon}</div>

                  {/* Text */}
                  <h3 className="font-extrabold text-brand-900 mb-2 text-sm sm:text-base">
                    {step.title}
                  </h3>
                  <p className="text-slate-500 text-sm leading-relaxed">{step.desc}</p>
                </div>
              </div>
            ))}
          </div>

          {/* CTA */}
          <div className="text-center mt-12">
            <Link
              href="/analyze"
              className="
                btn-gradient inline-flex items-center gap-3
                px-9 py-4 rounded-2xl text-lg font-bold text-white
                group shadow-teal
              "
            >
              <span className="text-2xl group-hover:rotate-12 transition-transform duration-300" aria-hidden>
                🚀
              </span>
              جرّب النظام الآن
            </Link>
          </div>
        </div>
      </section>

      {/* ══════════════════════════════════════════════
          OBJECTIVES SECTION
          ══════════════════════════════════════════════ */}
      <section className="py-20 sm:py-28 bg-gradient-to-b from-slate-50 to-sky-50/50 px-4">
        <div className="max-w-5xl mx-auto">

          {/* Section header */}
          <div className="text-center mb-14">
            <span className="inline-block px-4 py-1.5 rounded-full bg-teal-50 text-teal-700 text-sm font-bold border border-teal-200 mb-4">
              الأهداف
            </span>
            <h2 className="text-3xl sm:text-4xl font-extrabold text-brand-900 mb-4">
              <span className="section-title">أهداف المشروع</span>
            </h2>
            <p className="text-slate-500 text-base sm:text-lg max-w-xl mx-auto mt-6">
              ما نسعى إلى تحقيقه من خلال هذا النظام الذكي
            </p>
          </div>

          {/* Objective cards */}
          <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
            {objectives.map(({ icon, title, desc, colorCard, iconBg }, i) => (
              <div
                key={i}
                className={`
                  bg-gradient-to-br ${colorCard}
                  border rounded-3xl p-7
                  card-hover shadow-card
                  flex gap-5 items-start
                `}
              >
                {/* Icon circle */}
                <div
                  className={`
                    flex-shrink-0 w-14 h-14 rounded-2xl
                    ${iconBg} flex items-center justify-center
                    text-3xl shadow-sm
                  `}
                  aria-hidden
                >
                  {icon}
                </div>

                {/* Text */}
                <div>
                  <h3 className="font-extrabold text-brand-900 text-lg mb-2">{title}</h3>
                  <p className="text-slate-600 text-sm leading-relaxed">{desc}</p>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* ══════════════════════════════════════════════
          TEAM SECTION
          ══════════════════════════════════════════════ */}
      <section id="team" className="py-20 sm:py-28 bg-white px-4">
        <div className="max-w-4xl mx-auto">

          {/* Section header */}
          <div className="text-center mb-14">
            <span className="inline-block px-4 py-1.5 rounded-full bg-purple-50 text-purple-700 text-sm font-bold border border-purple-200 mb-4">
              الفريق
            </span>
            <h2 className="text-3xl sm:text-4xl font-extrabold text-brand-900 mb-4">
              <span className="section-title">فريق العمل</span>
            </h2>
            <p className="text-slate-500 text-base sm:text-lg max-w-xl mx-auto mt-6">
              الفريق المتخصص الذي أبدع في تصميم وتطوير هذا النظام
            </p>
          </div>

          {/* Team cards */}
          <div className="grid grid-cols-1 sm:grid-cols-3 gap-6">
            {team.map(({ initials, name, role, gradient }, i) => (
              <div
                key={i}
                className="
                  glass-card-light border border-slate-100
                  p-8 text-center
                  card-hover hover:border-teal-200
                  group
                "
              >
                {/* Avatar */}
                <div className="flex justify-center mb-5">
                  <div
                    className={`
                      w-20 h-20 rounded-full
                      bg-gradient-to-br ${gradient}
                      flex items-center justify-center
                      text-white text-2xl font-black
                      shadow-lg ring-4 ring-white
                      group-hover:scale-105 transition-transform duration-300
                    `}
                    aria-hidden
                  >
                    {initials}
                  </div>
                </div>

                {/* Name */}
                <h3 className="font-extrabold text-brand-900 text-lg mb-2">{name}</h3>

                {/* Role badge */}
                <span className="inline-block px-4 py-1 rounded-full bg-teal-50 text-teal-700 text-xs font-bold border border-teal-100">
                  {role}
                </span>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* ══════════════════════════════════════════════
          FINAL CTA SECTION
          ══════════════════════════════════════════════ */}
      <section className="hero-bg relative py-20 sm:py-28 px-4 overflow-hidden">
        {/* Background glow */}
        <div
          className="absolute inset-0 pointer-events-none"
          style={{
            background:
              "radial-gradient(ellipse at 25% 50%, rgba(20,184,166,0.25) 0%, transparent 55%), radial-gradient(ellipse at 75% 50%, rgba(30,151,205,0.2) 0%, transparent 55%)",
          }}
          aria-hidden
        />

        {/* Floating shapes */}
        <div
          className="floating-shape w-64 h-64 top-[-10%] right-[-5%]"
          style={{ animationDelay: "0.5s" }}
          aria-hidden
        />
        <div
          className="floating-shape w-44 h-44 bottom-[-5%] left-[-3%]"
          style={{ animationDelay: "2s" }}
          aria-hidden
        />

        <div className="relative z-10 max-w-3xl mx-auto text-center">
          <h2 className="text-3xl sm:text-4xl md:text-5xl font-black text-white mb-6 leading-tight">
            هل أنت مستعد للتحليل؟
          </h2>
          <p className="text-white/70 text-base sm:text-lg mb-10 max-w-xl mx-auto leading-relaxed">
            ابدأ الآن بإدخال نص باللهجة اليمنية وانتظر نتيجة التحليل الدقيقة
            من نظامنا الذكي في ثوانٍ معدودة
          </p>
          <Link
            href="/analyze"
            className="
              inline-flex items-center gap-3
              bg-white text-brand-900
              px-10 py-5 rounded-2xl
              text-xl font-black
              shadow-2xl hover:shadow-white/20
              hover:-translate-y-1 active:translate-y-0
              transition-all duration-300 group
            "
          >
            <span
              className="text-3xl group-hover:scale-110 transition-transform duration-300"
              aria-hidden
            >
              🚀
            </span>
            ابدأ التحليل الآن
          </Link>
        </div>
      </section>

    </div>
  );
}
