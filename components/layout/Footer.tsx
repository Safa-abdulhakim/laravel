import React from "react";
import Link from "next/link";
import { Brain, Heart, Sparkles, ExternalLink } from "lucide-react";
import { Separator } from "@/components/ui/separator";
import { NAV_LINKS } from "@/lib/constants";

export function Footer() {
  return (
    <footer className="bg-navy-950 text-white mt-0">
      {/* Top section */}
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div className="grid grid-cols-1 md:grid-cols-3 gap-12">
          {/* Brand */}
          <div className="md:col-span-1 space-y-4">
            <div className="flex items-center gap-2.5">
              <div className="w-9 h-9 rounded-xl bg-gradient-to-br from-navy-400 to-violet-500 flex items-center justify-center">
                <Brain className="w-5 h-5 text-white" />
              </div>
              <div>
                <span className="text-lg font-bold text-white">نبضات</span>
                <div className="text-xs text-navy-300 -mt-0.5">تحليل الصحة النفسية</div>
              </div>
            </div>
            <p className="text-navy-300 text-sm leading-relaxed max-w-xs">
              منصة ذكاء اصطناعي متخصصة في تحليل النصوص المكتوبة باللهجة اليمنية
              للكشف المبكر عن الحالات النفسية.
            </p>
            <div className="flex items-center gap-1.5 text-xs text-navy-400">
              <span>مبني بـ</span>
              <Heart className="w-3 h-3 text-red-400 fill-red-400" />
              <span>في اليمن</span>
            </div>
          </div>

          {/* Navigation */}
          <div className="space-y-4">
            <h4 className="text-sm font-semibold text-white uppercase tracking-wider">
              روابط سريعة
            </h4>
            <ul className="space-y-2.5">
              {NAV_LINKS.map((link) => (
                <li key={link.href}>
                  <Link
                    href={link.href}
                    className="text-navy-300 hover:text-white text-sm transition-colors duration-200 flex items-center gap-1.5 group"
                  >
                    <span className="w-1 h-1 rounded-full bg-violet-500 opacity-0 group-hover:opacity-100 transition-opacity duration-200" />
                    {link.label}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          {/* Info */}
          <div className="space-y-4">
            <h4 className="text-sm font-semibold text-white uppercase tracking-wider">
              ملاحظة مهمة
            </h4>
            <div className="bg-navy-900/60 border border-navy-700/50 rounded-xl p-4">
              <p className="text-navy-300 text-xs leading-relaxed">
                هذه المنصة أداة مساعدة تعليمية ولا تُغني عن الاستشارة الطبية
                المتخصصة. إذا كنت تعاني من أعراض نفسية، يُرجى التواصل مع
                متخصص صحي نفسي.
              </p>
            </div>
            <div className="flex items-center gap-2 text-xs text-navy-400">
              <Sparkles className="w-3.5 h-3.5 text-violet-400" />
              <span>مشروع بحثي أكاديمي — 2025</span>
            </div>
          </div>
        </div>
      </div>

      <Separator className="bg-navy-800" />

      {/* Bottom */}
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
        <div className="flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-navy-400">
          <span>© 2025 نبضات — جميع الحقوق محفوظة</span>
          <div className="flex items-center gap-4">
            <span className="flex items-center gap-1.5">
              <span className="w-1.5 h-1.5 rounded-full bg-stress animate-pulse" />
              النظام يعمل بكفاءة 99.8%
            </span>
            <Link
              href="/about"
              className="text-navy-300 hover:text-white transition-colors flex items-center gap-1"
            >
              عن المشروع <ExternalLink className="w-3 h-3" />
            </Link>
          </div>
        </div>
      </div>
    </footer>
  );
}
