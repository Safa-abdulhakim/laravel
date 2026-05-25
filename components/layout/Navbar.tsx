"use client";

import { useState, useEffect } from "react";
import Link from "next/link";
import { usePathname } from "next/navigation";
import { Brain, Menu, X, Sun, Moon, Sparkles } from "lucide-react";
import { useTheme } from "@/components/providers/ThemeProvider";

const navLinks = [
  { href: "/", label: "الرئيسية" },
  { href: "/analysis", label: "التحليل" },
  { href: "/statistics", label: "الإحصائيات" },
  { href: "/about", label: "عن المشروع" },
];

export default function Navbar() {
  const [isOpen, setIsOpen] = useState(false);
  const [scrolled, setScrolled] = useState(false);
  const { theme, toggleTheme } = useTheme();
  const pathname = usePathname();

  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 20);
    window.addEventListener("scroll", onScroll);
    return () => window.removeEventListener("scroll", onScroll);
  }, []);

  return (
    <nav
      className={`fixed top-0 left-0 right-0 z-50 transition-all duration-500 ${
        scrolled
          ? "glass shadow-lg py-3"
          : "py-5 bg-transparent"
      }`}
    >
      <div className="max-w-7xl mx-auto px-4 sm:px-6 flex items-center justify-between">
        {/* Logo */}
        <Link href="/" className="flex items-center gap-3 group">
          <div className="relative w-10 h-10 rounded-2xl gradient-bg flex items-center justify-center shadow-lg group-hover:shadow-purple-300/50 transition-all duration-300 group-hover:scale-110">
            <Brain className="w-5 h-5 text-white" />
            <div className="absolute -top-1 -right-1 w-3 h-3 bg-teal-400 rounded-full animate-pulse" />
          </div>
          <div>
            <span
              className="text-xl font-black gradient-text tracking-wide"
            >
              وجدان
            </span>
            <div className="text-xs font-medium" style={{ color: "var(--text-muted)" }}>
              تحليل نفسي ذكي
            </div>
          </div>
        </Link>

        {/* Desktop Nav */}
        <div className="hidden md:flex items-center gap-1">
          {navLinks.map((link) => (
            <Link
              key={link.href}
              href={link.href}
              className={`px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300 relative ${
                pathname === link.href
                  ? "text-white gradient-bg shadow-md"
                  : "hover:bg-white/50 dark:hover:bg-white/10"
              }`}
              style={{
                color: pathname === link.href ? "white" : "var(--text)",
              }}
            >
              {link.label}
            </Link>
          ))}
        </div>

        {/* Actions */}
        <div className="flex items-center gap-3">
          <button
            onClick={toggleTheme}
            className="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110"
            style={{
              background: "var(--card)",
              boxShadow: "var(--shadow-sm)",
              color: "var(--text)",
            }}
            aria-label="تبديل الوضع"
          >
            {theme === "dark" ? (
              <Sun className="w-4 h-4 text-yellow-400" />
            ) : (
              <Moon className="w-4 h-4" style={{ color: "var(--primary)" }} />
            )}
          </button>

          <Link
            href="/analysis"
            className="hidden md:flex items-center gap-2 btn-primary text-sm py-2 px-5"
          >
            <Sparkles className="w-4 h-4" />
            ابدأ التحليل
          </Link>

          <button
            onClick={() => setIsOpen(!isOpen)}
            className="md:hidden w-10 h-10 rounded-xl flex items-center justify-center"
            style={{ background: "var(--card)", color: "var(--text)" }}
          >
            {isOpen ? <X className="w-5 h-5" /> : <Menu className="w-5 h-5" />}
          </button>
        </div>
      </div>

      {/* Mobile Menu */}
      <div
        className={`md:hidden transition-all duration-300 overflow-hidden ${
          isOpen ? "max-h-96 opacity-100" : "max-h-0 opacity-0"
        }`}
      >
        <div className="glass mx-4 mt-2 rounded-2xl p-4 flex flex-col gap-2">
          {navLinks.map((link) => (
            <Link
              key={link.href}
              href={link.href}
              onClick={() => setIsOpen(false)}
              className={`px-4 py-3 rounded-xl text-sm font-semibold transition-all ${
                pathname === link.href
                  ? "text-white gradient-bg"
                  : ""
              }`}
              style={{
                color: pathname === link.href ? "white" : "var(--text)",
              }}
            >
              {link.label}
            </Link>
          ))}
          <Link
            href="/analysis"
            onClick={() => setIsOpen(false)}
            className="btn-primary text-center mt-2"
          >
            ابدأ التحليل
          </Link>
        </div>
      </div>
    </nav>
  );
}
