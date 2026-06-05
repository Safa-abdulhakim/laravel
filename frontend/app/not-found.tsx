'use client';

import Link from 'next/link';

export default function NotFound() {
  return (
    <div className="min-h-[70vh] flex flex-col items-center justify-center px-4 text-center">
      <div className="max-w-md">
        {/* 404 number */}
        <div className="relative mb-6">
          <p className="text-[9rem] font-black leading-none gradient-text-brand opacity-20 select-none">
            404
          </p>
          <div className="absolute inset-0 flex items-center justify-center">
            <span className="text-7xl animate-bounce-gentle">🔍</span>
          </div>
        </div>

        <h1 className="text-2xl sm:text-3xl font-black text-brand-900 mb-3">
          الصفحة غير موجودة
        </h1>
        <p className="text-slate-500 text-base leading-relaxed mb-8">
          عذراً، الصفحة التي تبحث عنها غير موجودة أو تم نقلها.
          تأكد من الرابط أو عد إلى الصفحة الرئيسية.
        </p>

        <div className="flex flex-col sm:flex-row gap-3 justify-center">
          <Link
            href="/"
            className="btn-gradient px-8 py-3.5 rounded-xl font-bold text-white"
          >
            العودة للرئيسية
          </Link>
          <Link
            href="/analyze"
            className="btn-outline-white px-8 py-3.5 rounded-xl font-semibold border-2 border-brand-200 text-brand-800 hover:bg-brand-50"
          >
            ابدأ التحليل
          </Link>
        </div>
      </div>
    </div>
  );
}
