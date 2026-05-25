"use client";

import React, { useState, useEffect } from "react";
import Link from "next/link";
import { usePathname } from "next/navigation";
import { motion, AnimatePresence } from "framer-motion";
import { useTheme } from "next-themes";
import {
  Brain,
  Sun,
  Moon,
  Menu,
  X,
  Sparkles,
} from "lucide-react";
import { Button } from "@/components/ui/button";
import { cn } from "@/lib/utils";
import { NAV_LINKS } from "@/lib/constants";

export function Navbar() {
  const pathname = usePathname();
  const { theme, setTheme } = useTheme();
  const [isScrolled, setIsScrolled] = useState(false);
  const [mobileOpen, setMobileOpen] = useState(false);
  const [mounted, setMounted] = useState(false);

  useEffect(() => {
    setMounted(true);
    const handleScroll = () => setIsScrolled(window.scrollY > 20);
    window.addEventListener("scroll", handleScroll, { passive: true });
    return () => window.removeEventListener("scroll", handleScroll);
  }, []);

  const toggleTheme = () => setTheme(theme === "dark" ? "light" : "dark");

  return (
    <>
      <motion.header
        initial={{ y: -100, opacity: 0 }}
        animate={{ y: 0, opacity: 1 }}
        transition={{ duration: 0.5, ease: "easeOut" }}
        className={cn(
          "fixed top-0 right-0 left-0 z-50 transition-all duration-300",
          isScrolled
            ? "bg-white/90 dark:bg-navy-950/90 backdrop-blur-xl border-b border-border shadow-glass"
            : "bg-transparent"
        )}
      >
        <nav className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="flex items-center justify-between h-16 lg:h-18">
            {/* Logo */}
            <Link href="/" className="flex items-center gap-2.5 group">
              <div className="relative">
                <div className="w-9 h-9 rounded-xl bg-gradient-to-br from-navy-600 to-violet-600 flex items-center justify-center shadow-glow group-hover:shadow-glow-lg transition-shadow duration-300">
                  <Brain className="w-5 h-5 text-white" />
                </div>
                <div className="absolute -top-0.5 -right-0.5 w-3 h-3 rounded-full bg-gradient-to-br from-violet-400 to-violet-600 border-2 border-white dark:border-navy-950 flex items-center justify-center">
                  <Sparkles className="w-1.5 h-1.5 text-white" />
                </div>
              </div>
              <div>
                <span className="text-lg font-bold gradient-text">نبضات</span>
                <span className="hidden sm:block text-xs text-muted-foreground font-medium -mt-0.5">
                  تحليل الصحة النفسية
                </span>
              </div>
            </Link>

            {/* Desktop Nav Links */}
            <div className="hidden md:flex items-center gap-1">
              {NAV_LINKS.map((link) => (
                <Link
                  key={link.href}
                  href={link.href}
                  className={cn(
                    "nav-link px-4 py-2 rounded-lg font-medium text-sm transition-all duration-200",
                    pathname === link.href
                      ? "text-violet-600 dark:text-violet-400 bg-violet-50 dark:bg-violet-900/20 font-semibold"
                      : "text-foreground/70 hover:text-foreground hover:bg-muted"
                  )}
                >
                  {link.label}
                </Link>
              ))}
            </div>

            {/* Right Controls */}
            <div className="flex items-center gap-2">
              {/* Theme Toggle */}
              {mounted && (
                <Button
                  variant="ghost"
                  size="icon"
                  onClick={toggleTheme}
                  className="rounded-xl"
                  aria-label="تبديل المظهر"
                >
                  <AnimatePresence mode="wait">
                    {theme === "dark" ? (
                      <motion.div
                        key="sun"
                        initial={{ rotate: -90, scale: 0 }}
                        animate={{ rotate: 0, scale: 1 }}
                        exit={{ rotate: 90, scale: 0 }}
                        transition={{ duration: 0.2 }}
                      >
                        <Sun className="w-4 h-4 text-amber-500" />
                      </motion.div>
                    ) : (
                      <motion.div
                        key="moon"
                        initial={{ rotate: 90, scale: 0 }}
                        animate={{ rotate: 0, scale: 1 }}
                        exit={{ rotate: -90, scale: 0 }}
                        transition={{ duration: 0.2 }}
                      >
                        <Moon className="w-4 h-4 text-navy-600" />
                      </motion.div>
                    )}
                  </AnimatePresence>
                </Button>
              )}

              {/* CTA Button — Desktop */}
              <Link href="/analysis" className="hidden sm:block">
                <Button variant="primary" size="sm" className="gap-2">
                  <Sparkles className="w-3.5 h-3.5" />
                  ابدأ التحليل
                </Button>
              </Link>

              {/* Mobile Menu Toggle */}
              <Button
                variant="ghost"
                size="icon"
                className="md:hidden rounded-xl"
                onClick={() => setMobileOpen(!mobileOpen)}
                aria-label="القائمة"
              >
                <AnimatePresence mode="wait">
                  {mobileOpen ? (
                    <motion.div
                      key="close"
                      initial={{ rotate: -90, scale: 0 }}
                      animate={{ rotate: 0, scale: 1 }}
                      exit={{ rotate: 90, scale: 0 }}
                      transition={{ duration: 0.15 }}
                    >
                      <X className="w-5 h-5" />
                    </motion.div>
                  ) : (
                    <motion.div
                      key="menu"
                      initial={{ rotate: 90, scale: 0 }}
                      animate={{ rotate: 0, scale: 1 }}
                      exit={{ rotate: -90, scale: 0 }}
                      transition={{ duration: 0.15 }}
                    >
                      <Menu className="w-5 h-5" />
                    </motion.div>
                  )}
                </AnimatePresence>
              </Button>
            </div>
          </div>
        </nav>
      </motion.header>

      {/* Mobile Menu */}
      <AnimatePresence>
        {mobileOpen && (
          <motion.div
            initial={{ opacity: 0, height: 0 }}
            animate={{ opacity: 1, height: "auto" }}
            exit={{ opacity: 0, height: 0 }}
            transition={{ duration: 0.3, ease: "easeInOut" }}
            className="fixed top-16 right-0 left-0 z-40 bg-white/95 dark:bg-navy-950/95 backdrop-blur-xl border-b border-border shadow-glass-lg md:hidden overflow-hidden"
          >
            <div className="max-w-7xl mx-auto px-4 py-4 space-y-1">
              {NAV_LINKS.map((link, i) => (
                <motion.div
                  key={link.href}
                  initial={{ opacity: 0, x: 20 }}
                  animate={{ opacity: 1, x: 0 }}
                  transition={{ delay: i * 0.06 }}
                >
                  <Link
                    href={link.href}
                    onClick={() => setMobileOpen(false)}
                    className={cn(
                      "flex items-center w-full px-4 py-3 rounded-xl text-sm font-medium transition-all",
                      pathname === link.href
                        ? "text-violet-600 dark:text-violet-400 bg-violet-50 dark:bg-violet-900/20 font-semibold"
                        : "text-foreground/70 hover:text-foreground hover:bg-muted"
                    )}
                  >
                    {link.label}
                  </Link>
                </motion.div>
              ))}
              <div className="pt-2 pb-1">
                <Link href="/analysis" onClick={() => setMobileOpen(false)}>
                  <Button variant="primary" className="w-full gap-2">
                    <Sparkles className="w-4 h-4" />
                    ابدأ التحليل الآن
                  </Button>
                </Link>
              </div>
            </div>
          </motion.div>
        )}
      </AnimatePresence>
    </>
  );
}
