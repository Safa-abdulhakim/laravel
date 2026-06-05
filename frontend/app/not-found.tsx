"use client";

import Link from "next/link";

export default function NotFound() {
  return (
    <div className="min-h-[80vh] flex flex-col items-center justify-center px-4 py-16 text-center bg-gradient-to-b from-slate-50 to-sky-50/40">
      <div className="max-w-lg w-full">

        {/* 404 Graphic */}
        <div className="relative mb-8 select-none">
          {/* Large 404 background text */}
          <p
            className="text-[10rem] sm:text-[12rem] font-black leading-none pointer-events-none"
            style={{
              background: "linear-gradient(135deg, #1e3a5f 0%, #0f766e 100%)",
              WebkitBackgroundClip: "text",
              WebkitTextFillColor: "transparent",
              backgroundClip: "text",
              opacity: 0.12,
            }}
            aria-hidden
          >
            404
          </p>

          {/* Floating emoji overlay */}
          <div className="absolute inset-0 flex items-center justify-center">
            <span className="text-7xl sm:text-8xl animate-bounce-gentle" role="img" aria-label="بحث">
              🔍
            </span>
          </div>
        </div>

        {/* Text content */}
        <div className="glass-card-light border border-slate-100 rounded-3xl p-8 sm:p-10 shadow-card mb-8">

          <h1 className="text-2xl sm:text-3xl font-black text-brand-900 mb-3 leading-tight">
            الصفحة غير موجودة
          </h1>

          <p className="text-slate-500 text-base leading-relaxed mb-2">
            عذراً، الصفحة التي تبحث عنها غير موجودة أو ربما تم نقلها.
          </p>
          <p className="text-slate-400 text-sm">
            تأكد من صحة الرابط أو استخدم الأزرار أدناه للتنقل.
          </p>

          {/* Divider */}
          <div className="my-6 h-px bg-gradient-to-r from-transparent via-slate-200 to-transparent" />

          {/* Action buttons */}
          <div className="flex flex-col sm:flex-row gap-3 justify-center">
            <Link
              href="/"
              className="
                btn-gradient px-8 py-3.5 rounded-xl font-bold text-white text-base
                flex items-center justify-center gap-2 group
              "
            >
              <svg
                className="w-5 h-5 group-hover:-translate-x-1 transition-transform"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                strokeWidth={2.5}
                aria-hidden
              >
                <path strokeLinecap="round" strokeLinejoin="round" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                <polyline points="9 22 9 12 15 12 15 22" />
              </svg>
              العودة للرئيسية
            </Link>

            <Link
              href="/analyze"
              className="
                px-8 py-3.5 rounded-xl font-bold text-base
                border-2 border-teal-200 text-teal-700
                hover:bg-teal-50 hover:border-teal-400
                transition-all duration-200
                flex items-center justify-center gap-2
              "
            >
              <span aria-hidden>🧠</span>
              ابدأ التحليل
            </Link>
          </div>
        </div>

        {/* Helpful links */}
        <p className="text-slate-400 text-sm">
          هل تبحث عن{" "}
          <Link href="/#about" className="text-teal-600 hover:underline font-medium">
            معلومات المشروع
          </Link>
          {" أو "}
          <Link href="/#team" className="text-teal-600 hover:underline font-medium">
            فريق العمل
          </Link>
          ؟
        </p>
      </div>
    </div>
  );
}
