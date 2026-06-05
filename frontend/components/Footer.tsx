'use client';

import Link from 'next/link';

export default function Footer() {
  const currentYear = new Date().getFullYear();

  return (
    <footer className="bg-gradient-to-r from-brand-900 to-teal-800 text-white">
      <div className="max-w-6xl mx-auto px-4 sm:px-6 py-10">
        <div className="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
          {/* Brand */}
          <div className="space-y-3">
            <div className="flex items-center gap-2">
              <div className="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center">
                <span className="text-xl">🧠</span>
              </div>
              <h3 className="font-bold text-lg">محلل اللهجة اليمنية</h3>
            </div>
            <p className="text-white/70 text-sm leading-relaxed">
              نظام ذكاء اصطناعي لتحليل النصوص العربية باللهجة اليمنية والكشف عن الحالات النفسية.
            </p>
          </div>

          {/* Quick links */}
          <div>
            <h4 className="font-semibold text-white/90 mb-3 text-sm uppercase tracking-wider">
              روابط سريعة
            </h4>
            <ul className="space-y-2">
              {[
                { href: '/', label: 'الصفحة الرئيسية' },
                { href: '/analyze', label: 'تحليل النص' },
                { href: '/#about', label: 'عن المشروع' },
                { href: '/#team', label: 'فريق العمل' },
              ].map(({ href, label }) => (
                <li key={href}>
                  <Link
                    href={href}
                    className="text-white/60 hover:text-white text-sm transition-colors duration-200 hover:underline"
                  >
                    {label}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          {/* Project info */}
          <div>
            <h4 className="font-semibold text-white/90 mb-3 text-sm uppercase tracking-wider">
              معلومات المشروع
            </h4>
            <ul className="space-y-2 text-white/60 text-sm">
              <li className="flex items-center gap-2">
                <span>🎓</span>
                <span>مشروع تخرج أكاديمي</span>
              </li>
              <li className="flex items-center gap-2">
                <span>🤖</span>
                <span>الذكاء الاصطناعي – NLP</span>
              </li>
              <li className="flex items-center gap-2">
                <span>🇾🇪</span>
                <span>اللهجة اليمنية</span>
              </li>
              <li className="flex items-center gap-2">
                <span>🧬</span>
                <span>تحليل الصحة النفسية</span>
              </li>
            </ul>
          </div>
        </div>

        <div className="border-t border-white/10 pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-white/50 text-xs">
          <p>© {currentYear} محلل اللهجة اليمنية. جميع الحقوق محفوظة.</p>
          <p>صُنع بـ ❤️ لخدمة المجتمع اليمني</p>
        </div>
      </div>
    </footer>
  );
}
