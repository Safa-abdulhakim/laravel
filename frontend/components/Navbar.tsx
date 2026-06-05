'use client';

import Link from 'next/link';
import { usePathname } from 'next/navigation';
import { useState, useEffect } from 'react';

export default function Navbar() {
  const pathname = usePathname();
  const [menuOpen, setMenuOpen] = useState(false);
  const [scrolled, setScrolled] = useState(false);

  useEffect(() => {
    const handleScroll = () => setScrolled(window.scrollY > 20);
    window.addEventListener('scroll', handleScroll, { passive: true });
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  useEffect(() => {
    setMenuOpen(false);
  }, [pathname]);

  const isActive = (href: string) =>
    href === '/' ? pathname === '/' : pathname.startsWith(href);

  const navLinks = [
    { href: '/', label: 'الرئيسية' },
    { href: '/analyze', label: 'التحليل' },
  ];

  return (
    <header
      className={`sticky top-0 z-50 transition-all duration-300 ${
        scrolled
          ? 'bg-white/95 backdrop-blur-md shadow-md border-b border-slate-100'
          : 'bg-white/80 backdrop-blur-sm border-b border-transparent'
      }`}
    >
      <nav className="max-w-6xl mx-auto px-4 sm:px-6">
        <div className="flex items-center justify-between h-16 sm:h-18">
          {/* Logo */}
          <Link
            href="/"
            className="flex items-center gap-2.5 group"
            aria-label="الصفحة الرئيسية"
          >
            <div className="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-900 to-teal-700 flex items-center justify-center shadow-md group-hover:shadow-teal transition-shadow duration-300">
              <span className="text-xl">🧠</span>
            </div>
            <div className="flex flex-col leading-tight">
              <span className="font-bold text-brand-900 text-sm sm:text-base">محلل اللهجة</span>
              <span className="text-teal-600 text-xs font-medium hidden sm:block">اليمنية</span>
            </div>
          </Link>

          {/* Desktop links */}
          <ul className="hidden md:flex items-center gap-1">
            {navLinks.map(({ href, label }) => (
              <li key={href}>
                <Link
                  href={href}
                  className={`px-4 py-2 rounded-lg font-medium text-sm transition-all duration-200 ${
                    isActive(href)
                      ? 'bg-teal-50 text-teal-700 font-bold'
                      : 'text-slate-600 hover:text-brand-900 hover:bg-slate-50'
                  }`}
                >
                  {label}
                </Link>
              </li>
            ))}
            <li>
              <Link
                href="/analyze"
                className="mr-2 px-5 py-2 rounded-xl btn-gradient text-sm font-semibold text-white shadow-sm"
              >
                ابدأ التحليل
              </Link>
            </li>
          </ul>

          {/* Mobile hamburger */}
          <button
            className="md:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100 transition-colors"
            onClick={() => setMenuOpen((o) => !o)}
            aria-label="قائمة التنقل"
            aria-expanded={menuOpen}
          >
            <div className="w-5 h-4 flex flex-col justify-between">
              <span
                className={`block h-0.5 bg-current rounded transition-all duration-300 ${
                  menuOpen ? 'rotate-45 translate-y-[7px]' : ''
                }`}
              />
              <span
                className={`block h-0.5 bg-current rounded transition-all duration-300 ${
                  menuOpen ? 'opacity-0' : ''
                }`}
              />
              <span
                className={`block h-0.5 bg-current rounded transition-all duration-300 ${
                  menuOpen ? '-rotate-45 -translate-y-[7px]' : ''
                }`}
              />
            </div>
          </button>
        </div>

        {/* Mobile menu */}
        {menuOpen && (
          <div className="md:hidden border-t border-slate-100 py-3 space-y-1 animate-slide-in-up">
            {navLinks.map(({ href, label }) => (
              <Link
                key={href}
                href={href}
                className={`flex items-center px-4 py-3 rounded-xl font-medium text-sm transition-colors ${
                  isActive(href)
                    ? 'bg-teal-50 text-teal-700 font-bold'
                    : 'text-slate-600 hover:bg-slate-50'
                }`}
              >
                {label}
              </Link>
            ))}
            <Link
              href="/analyze"
              className="flex items-center justify-center mt-2 py-3 px-4 rounded-xl btn-gradient text-sm font-semibold text-white"
            >
              ابدأ التحليل الآن
            </Link>
          </div>
        )}
      </nav>
    </header>
  );
}
