"use client";

import Link from "next/link";

const quickLinks = [
  { href: "/", label: "الصفحة الرئيسية" },
  { href: "/analyze", label: "تحليل النص" },
  { href: "/#about", label: "عن المشروع" },
  { href: "/#team", label: "فريق العمل" },
];

const projectInfo = [
  { icon: "🎓", text: "مشروع تخرج أكاديمي" },
  { icon: "🤖", text: "الذكاء الاصطناعي – NLP" },
  { icon: "🇾🇪", text: "اللهجة اليمنية" },
  { icon: "🧬", text: "تحليل الصحة النفسية" },
  { icon: "⚛️", text: "Next.js + Python" },
];

export default function Footer() {
  const currentYear = new Date().getFullYear();

  return (
    <footer className="bg-gradient-to-br from-brand-900 via-teal-800 to-brand-900 text-white">

      {/* Top wave */}
      <div className="overflow-hidden leading-none" aria-hidden>
        <svg
          viewBox="0 0 1440 40"
          preserveAspectRatio="none"
          className="w-full h-8 sm:h-10 fill-slate-50 block"
        >
          <path d="M0,20 C360,45 1080,0 1440,20 L1440,0 L0,0 Z" />
        </svg>
      </div>

      <div className="max-w-6xl mx-auto px-4 sm:px-6 pt-10 pb-8">

        {/* Main grid */}
        <div className="grid grid-cols-1 sm:grid-cols-3 gap-10 mb-10">

          {/* ─── Brand column ─── */}
          <div className="sm:col-span-1 space-y-4">
            {/* Logo */}
            <div className="flex items-center gap-3">
              <div className="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0 shadow-sm">
                <span className="text-xl" aria-hidden>🧠</span>
              </div>
              <div>
                <h3 className="font-extrabold text-white text-base leading-tight">
                  محلل اللهجة اليمنية
                </h3>
                <p className="text-white/50 text-xs">
                  Yemeni Dialect Analyzer
                </p>
              </div>
            </div>

            {/* Description */}
            <p className="text-white/65 text-sm leading-relaxed">
              نظام ذكاء اصطناعي لتحليل النصوص العربية باللهجة اليمنية
              والكشف عن الحالات النفسية. مشروع تخرج أكاديمي.
            </p>

            {/* Disclaimer */}
            <div className="bg-white/8 border border-white/12 rounded-xl p-3">
              <p className="text-white/50 text-xs leading-relaxed">
                ⚠️ هذا النظام أداة بحثية أكاديمية فقط.
                لا يُغني عن استشارة متخصص في الصحة النفسية.
              </p>
            </div>
          </div>

          {/* ─── Quick links ─── */}
          <div>
            <h4 className="font-bold text-white/90 mb-4 text-sm tracking-wide">
              روابط سريعة
            </h4>
            <ul className="space-y-2.5">
              {quickLinks.map(({ href, label }) => (
                <li key={href}>
                  <Link
                    href={href}
                    className="
                      flex items-center gap-2
                      text-white/60 hover:text-white
                      text-sm transition-all duration-200
                      hover:translate-x-[-4px]
                      group
                    "
                  >
                    <span
                      className="
                        w-1.5 h-1.5 rounded-full
                        bg-teal-400/60 group-hover:bg-teal-400
                        transition-colors duration-200 flex-shrink-0
                      "
                      aria-hidden
                    />
                    {label}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          {/* ─── Project info ─── */}
          <div>
            <h4 className="font-bold text-white/90 mb-4 text-sm tracking-wide">
              معلومات المشروع
            </h4>
            <ul className="space-y-2.5">
              {projectInfo.map(({ icon, text }) => (
                <li
                  key={text}
                  className="flex items-center gap-2.5 text-white/60 text-sm"
                >
                  <span className="text-base flex-shrink-0" aria-hidden>{icon}</span>
                  <span>{text}</span>
                </li>
              ))}
            </ul>
          </div>
        </div>

        {/* Divider */}
        <div className="border-t border-white/10 pt-6">
          <div className="flex flex-col sm:flex-row items-center justify-between gap-3">

            {/* Copyright */}
            <p className="text-white/45 text-xs">
              © 2024–{currentYear} محلل اللهجة اليمنية. جميع الحقوق محفوظة.
            </p>

            {/* Built with love */}
            <p className="text-white/45 text-xs flex items-center gap-1.5">
              <span>صُنع بـ</span>
              <span className="text-rose-400 text-sm" aria-label="حب">❤️</span>
              <span>لخدمة المجتمع اليمني</span>
            </p>

            {/* CTA link */}
            <Link
              href="/analyze"
              className="
                text-xs font-bold text-teal-300 hover:text-teal-200
                transition-colors duration-200
                flex items-center gap-1
              "
            >
              <span aria-hidden>🔍</span>
              ابدأ التحليل
            </Link>
          </div>
        </div>
      </div>
    </footer>
  );
}
