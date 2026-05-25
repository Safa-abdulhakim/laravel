import Link from "next/link";
import { Brain, Heart, GitFork, Share2, Mail, ArrowUp } from "lucide-react";

export default function Footer() {
  return (
    <footer
      className="relative overflow-hidden pt-16 pb-8"
      style={{
        background: "linear-gradient(135deg, #0d1b2e 0%, #1a1040 100%)",
        color: "white",
      }}
    >
      {/* Background decoration */}
      <div className="absolute inset-0 opacity-10">
        <div
          className="absolute top-0 right-0 w-96 h-96 rounded-full blur-3xl"
          style={{ background: "radial-gradient(circle, #6C63FF, transparent)" }}
        />
        <div
          className="absolute bottom-0 left-0 w-80 h-80 rounded-full blur-3xl"
          style={{ background: "radial-gradient(circle, #4ECDC4, transparent)" }}
        />
      </div>

      <div className="relative max-w-7xl mx-auto px-4 sm:px-6">
        <div className="grid grid-cols-1 md:grid-cols-4 gap-10 pb-12 border-b border-white/10">
          {/* Brand */}
          <div className="md:col-span-2">
            <Link href="/" className="flex items-center gap-3 mb-4">
              <div className="w-10 h-10 rounded-2xl gradient-bg flex items-center justify-center">
                <Brain className="w-5 h-5 text-white" />
              </div>
              <span className="text-2xl font-black text-white">وجدان</span>
            </Link>
            <p className="text-white/60 text-sm leading-relaxed mb-6 max-w-xs">
              منصة ذكاء اصطناعي متخصصة في تحليل النصوص النفسية باللهجة اليمنية،
              نساعد في الكشف المبكر عن الاضطرابات النفسية لتحسين الصحة المجتمعية.
            </p>
            <div className="flex items-center gap-3">
              {[
                { icon: GitFork, label: "GitHub" },
                { icon: Share2, label: "Twitter" },
                { icon: Mail, label: "Email" },
              ].map(({ icon: Icon, label }) => (
                <button
                  key={label}
                  aria-label={label}
                  className="w-9 h-9 rounded-xl flex items-center justify-center bg-white/10 hover:bg-white/20 transition-all duration-300 hover:scale-110"
                >
                  <Icon className="w-4 h-4 text-white/70" />
                </button>
              ))}
            </div>
          </div>

          {/* Links */}
          <div>
            <h4 className="font-bold text-white mb-4">الصفحات</h4>
            <ul className="space-y-3">
              {[
                { href: "/", label: "الرئيسية" },
                { href: "/analysis", label: "تحليل النصوص" },
                { href: "/statistics", label: "الإحصائيات" },
                { href: "/about", label: "عن المشروع" },
              ].map((link) => (
                <li key={link.href}>
                  <Link
                    href={link.href}
                    className="text-white/60 hover:text-white transition-colors text-sm hover:translate-x-1 inline-block"
                    style={{ direction: "rtl" }}
                  >
                    {link.label}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          {/* Info */}
          <div>
            <h4 className="font-bold text-white mb-4">التصنيفات</h4>
            <ul className="space-y-3">
              {[
                { label: "الاكتئاب", color: "#6C63FF" },
                { label: "القلق", color: "#4ECDC4" },
                { label: "الضغوط النفسية", color: "#f59e0b" },
              ].map((item) => (
                <li key={item.label} className="flex items-center gap-2">
                  <div
                    className="w-2 h-2 rounded-full"
                    style={{ background: item.color }}
                  />
                  <span className="text-white/60 text-sm">{item.label}</span>
                </li>
              ))}
            </ul>
          </div>
        </div>

        <div className="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
          <p className="text-white/40 text-xs flex items-center gap-1">
            صُنع بـ <Heart className="w-3 h-3 text-red-400 fill-current" /> من فريق وجدان — مشروع تخرج 2025
          </p>
          <Link
            href="#top"
            className="w-8 h-8 rounded-xl bg-white/10 hover:bg-white/20 flex items-center justify-center transition-all hover:scale-110"
            aria-label="العودة للأعلى"
          >
            <ArrowUp className="w-4 h-4 text-white/70" />
          </Link>
        </div>
      </div>
    </footer>
  );
}
