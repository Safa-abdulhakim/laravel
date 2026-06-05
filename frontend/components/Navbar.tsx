"use client";

import Link from "next/link";
import { usePathname } from "next/navigation";
import { useState, useEffect } from "react";

const navLinks = [
  { href: "/", label: "الرئيسية" },
  { href: "/analyze", label: "التحليل" },
];

export default function Navbar() {
  const pathname = usePathname();
  const [menuOpen, setMenuOpen] = useState(false);
  const [scrolled, setScrolled] = useState(false);

  // Shadow/backdrop effect on scroll
  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 16);
    window.addEventListener("scroll", onScroll, { passive: true });
    return () => window.removeEventListener("scroll", onScroll);
  }, []);

  // Auto-close menu on navigation
  useEffect(() => {
    setMenuOpen(false);
  }, [pathname]);

  // Lock body scroll when mobile menu is open
  useEffect(() => {
    if (menuOpen) {
      document.body.style.overflow = "hidden";
    } else {
      document.body.style.overflow = "";
    }
    return () => {
      document.body.style.overflow = "";
    };
  }, [menuOpen]);

  const isActive = (href: string) =>
    href === "/" ? pathname === "/" : pathname.startsWith(href);

  return (
    <header
      className={`
        sticky top-0 z-50 w-full
        transition-all duration-300
        ${
          scrolled
            ? "bg-white/92 backdrop-blur-xl shadow-md border-b border-slate-200/80"
            : "bg-white/80 backdrop-blur-md border-b border-slate-100/80"
        }
      `}
    >
      <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex items-center justify-between h-16">

          {/* ─── Logo ─── */}
          <Link
            href="/"
            className="flex items-center gap-2.5 group flex-shrink-0"
            aria-label="الصفحة الرئيسية - محلل اللهجة اليمنية"
          >
            {/* Icon bubble */}
            <div
              className="
                w-9 h-9 rounded-xl
                bg-gradient-to-br from-brand-900 to-teal-700
                flex items-center justify-center
                shadow-sm group-hover:shadow-teal
                group-hover:scale-105
                transition-all duration-300
              "
            >
              <span className="text-lg select-none" aria-hidden>🧠</span>
            </div>

            {/* Name */}
            <div className="flex flex-col leading-none">
              <span className="text-sm sm:text-base font-extrabold text-brand-900 group-hover:text-teal-700 transition-colors duration-200">
                محلل اللهجة
              </span>
              <span className="text-[11px] font-semibold text-teal-600 mt-0.5">
                اليمنية
              </span>
            </div>
          </Link>

          {/* ─── Desktop Navigation ─── */}
          <nav
            className="hidden md:flex items-center gap-1"
            aria-label="التنقل الرئيسي"
          >
            {navLinks.map(({ href, label }) => (
              <Link
                key={href}
                href={href}
                className={`
                  relative px-4 py-2 rounded-lg text-sm font-semibold
                  transition-all duration-200
                  ${
                    isActive(href)
                      ? "text-teal-700 bg-teal-50/80"
                      : "text-slate-600 hover:text-brand-900 hover:bg-slate-100/80"
                  }
                `}
                aria-current={isActive(href) ? "page" : undefined}
              >
                {label}
                {/* Active underline */}
                {isActive(href) && (
                  <span
                    className="
                      absolute bottom-1 right-1/2 translate-x-1/2
                      w-5 h-0.5 rounded-full
                      bg-gradient-to-r from-teal-600 to-brand-900
                    "
                    aria-hidden
                  />
                )}
              </Link>
            ))}

            {/* CTA button */}
            <Link
              href="/analyze"
              className="
                mr-3 px-5 py-2 rounded-xl
                text-sm font-bold text-white
                bg-gradient-to-l from-brand-900 to-teal-700
                shadow-sm hover:shadow-teal
                hover:-translate-y-0.5 active:translate-y-0
                transition-all duration-200
              "
            >
              ابدأ التحليل
            </Link>
          </nav>

          {/* ─── Mobile hamburger ─── */}
          <button
            onClick={() => setMenuOpen((v) => !v)}
            aria-expanded={menuOpen}
            aria-controls="mobile-nav-menu"
            aria-label={menuOpen ? "إغلاق القائمة" : "فتح القائمة"}
            className="
              md:hidden p-2 rounded-lg
              text-slate-600 hover:text-brand-900 hover:bg-slate-100
              transition-all duration-200
            "
          >
            {/* Animated hamburger lines */}
            <div className="w-5 h-4 flex flex-col justify-between" aria-hidden>
              <span
                className={`block h-0.5 bg-current rounded-full origin-center transition-all duration-300 ${
                  menuOpen ? "rotate-45 translate-y-[7.5px]" : ""
                }`}
              />
              <span
                className={`block h-0.5 bg-current rounded-full transition-all duration-200 ${
                  menuOpen ? "opacity-0 scale-x-0" : ""
                }`}
              />
              <span
                className={`block h-0.5 bg-current rounded-full origin-center transition-all duration-300 ${
                  menuOpen ? "-rotate-45 -translate-y-[7.5px]" : ""
                }`}
              />
            </div>
          </button>
        </div>

        {/* ─── Mobile Menu Dropdown ─── */}
        <div
          id="mobile-nav-menu"
          className={`
            md:hidden overflow-hidden
            transition-all duration-300 ease-in-out
            ${menuOpen ? "max-h-72 opacity-100 pb-4" : "max-h-0 opacity-0 pointer-events-none"}
          `}
        >
          <nav
            className="pt-2 border-t border-slate-100 space-y-1"
            aria-label="قائمة التنقل للجوال"
          >
            {navLinks.map(({ href, label }) => (
              <Link
                key={href}
                href={href}
                aria-current={isActive(href) ? "page" : undefined}
                className={`
                  flex items-center px-4 py-3 rounded-xl
                  text-sm font-semibold
                  transition-all duration-200
                  ${
                    isActive(href)
                      ? "text-teal-700 bg-teal-50 border border-teal-100"
                      : "text-slate-600 hover:text-brand-900 hover:bg-slate-50"
                  }
                `}
              >
                {label}
              </Link>
            ))}

            <Link
              href="/analyze"
              className="
                flex items-center justify-center mt-2
                px-4 py-3 rounded-xl
                text-sm font-bold text-white
                bg-gradient-to-l from-brand-900 to-teal-700
                shadow-sm transition-all duration-200
              "
            >
              ابدأ التحليل الآن
            </Link>
          </nav>
        </div>
      </div>
    </header>
  );
}
