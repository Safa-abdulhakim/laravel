"use client";

import { useEffect, useRef, useState } from "react";
import { motion, useInView, useReducedMotion } from "framer-motion";
import { TrendingUp, Sparkles, BookOpen, Layers3 } from "lucide-react";
import { cn } from "@/lib/utils";

/* ─────────────────────────────────────────────
   Stats data
───────────────────────────────────────────── */
interface StatItem {
  value: number;
  suffix: string;
  prefix?: string;
  label: string;
  sublabel: string;
  icon: React.ElementType;
  gradient: string;
  iconBg: string;
  glow: string;
}

const STATS: StatItem[] = [
  {
    value: 3847,
    suffix: "+",
    label: "تحليل نفسي",
    sublabel: "نص تم تحليله منذ الإطلاق",
    icon: TrendingUp,
    gradient: "from-violet-600 to-navy-600",
    iconBg: "bg-violet-100 dark:bg-violet-900/30",
    glow: "shadow-[0_0_40px_rgba(108,99,255,0.2)]",
  },
  {
    value: 84,
    suffix: "٪",
    label: "متوسط الدقة",
    sublabel: "نسبة التطابق مع التشخيص البشري",
    icon: Sparkles,
    gradient: "from-stress to-navy-500",
    iconBg: "bg-stress-light dark:bg-stress/10",
    glow: "shadow-[0_0_40px_rgba(82,183,136,0.2)]",
  },
  {
    value: 10000,
    suffix: "+",
    label: "كلمة مفتاحية",
    sublabel: "مفردة يمنية محللة في قاعدة البيانات",
    icon: BookOpen,
    gradient: "from-depression to-navy-600",
    iconBg: "bg-depression-light dark:bg-depression/10",
    glow: "shadow-[0_0_40px_rgba(74,144,217,0.2)]",
  },
  {
    value: 3,
    suffix: "",
    label: "تصنيفات نفسية",
    sublabel: "اكتئاب، قلق، وضغوط نفسية",
    icon: Layers3,
    gradient: "from-anxiety to-violet-600",
    iconBg: "bg-anxiety-light dark:bg-anxiety/10",
    glow: "shadow-[0_0_40px_rgba(232,146,74,0.2)]",
  },
];

/* ─────────────────────────────────────────────
   Arabic number formatter
───────────────────────────────────────────── */
function toArabicNumerals(n: number): string {
  return n.toLocaleString("ar-EG");
}

/* ─────────────────────────────────────────────
   Animated counter hook
───────────────────────────────────────────── */
function useCountUp(target: number, duration: number, active: boolean): number {
  const [count, setCount] = useState(0);
  const rafRef = useRef<number | null>(null);
  const startRef = useRef<number | null>(null);
  const prefersReduced = useReducedMotion();

  useEffect(() => {
    if (!active) return;

    if (prefersReduced) {
      setCount(target);
      return;
    }

    const startTime = performance.now();
    startRef.current = startTime;

    const animate = (now: number) => {
      const elapsed = now - (startRef.current ?? now);
      const progress = Math.min(elapsed / duration, 1);
      // Ease out cubic
      const eased = 1 - Math.pow(1 - progress, 3);
      setCount(Math.floor(eased * target));

      if (progress < 1) {
        rafRef.current = requestAnimationFrame(animate);
      } else {
        setCount(target);
      }
    };

    rafRef.current = requestAnimationFrame(animate);

    return () => {
      if (rafRef.current !== null) cancelAnimationFrame(rafRef.current);
    };
  }, [active, target, duration, prefersReduced]);

  return count;
}

/* ─────────────────────────────────────────────
   Stat Card
───────────────────────────────────────────── */
function StatCard({ stat, delay }: { stat: StatItem; delay: number }) {
  const ref = useRef<HTMLDivElement>(null);
  const isInView = useInView(ref, { once: true, amount: 0.5 });
  const count = useCountUp(stat.value, 1800, isInView);

  const Icon = stat.icon;

  return (
    <motion.div
      ref={ref}
      initial={{ opacity: 0, y: 32 }}
      whileInView={{ opacity: 1, y: 0 }}
      viewport={{ once: true, amount: 0.4 }}
      transition={{ duration: 0.6, delay, ease: [0.22, 1, 0.36, 1] }}
      whileHover={{ y: -4, transition: { duration: 0.2 } }}
      className={cn(
        "relative group rounded-2xl border border-white/10 bg-white/5 backdrop-blur-sm p-7 overflow-hidden cursor-default",
        "transition-shadow duration-300",
        stat.glow
      )}
    >
      {/* Card background gradient on hover */}
      <div className="pointer-events-none absolute inset-0 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-400 bg-white/3" />

      {/* Top gradient border line */}
      <div
        className={cn(
          "absolute top-0 left-0 right-0 h-0.5 bg-gradient-to-l",
          stat.gradient
        )}
      />

      {/* Icon */}
      <div className={cn("mb-5 inline-flex h-12 w-12 items-center justify-center rounded-xl", stat.iconBg)}>
        <Icon
          className={cn(
            "h-6 w-6",
            stat.iconBg.includes("violet")
              ? "text-violet-600 dark:text-violet-400"
              : stat.iconBg.includes("stress")
              ? "text-stress dark:text-stress"
              : stat.iconBg.includes("depression")
              ? "text-depression dark:text-depression"
              : "text-anxiety dark:text-anxiety"
          )}
          strokeWidth={1.75}
        />
      </div>

      {/* Counter */}
      <div className="flex items-end gap-1 mb-2">
        <span
          className={cn(
            "text-5xl font-black leading-none bg-gradient-to-l bg-clip-text text-transparent",
            stat.gradient
          )}
        >
          {toArabicNumerals(count)}
        </span>
        {stat.suffix && (
          <span
            className={cn(
              "text-3xl font-black leading-none pb-0.5 bg-gradient-to-l bg-clip-text text-transparent",
              stat.gradient
            )}
          >
            {stat.suffix}
          </span>
        )}
      </div>

      {/* Label */}
      <p className="text-base font-bold text-white mb-1">{stat.label}</p>
      <p className="text-sm text-white/50 leading-relaxed">{stat.sublabel}</p>

      {/* Decorative corner orb */}
      <div
        className={cn(
          "pointer-events-none absolute -bottom-8 -left-8 h-24 w-24 rounded-full opacity-20 blur-xl bg-gradient-to-br",
          stat.gradient
        )}
      />
    </motion.div>
  );
}

/* ─────────────────────────────────────────────
   Main Section
───────────────────────────────────────────── */
export default function StatsSection() {
  return (
    <section
      dir="rtl"
      className="relative py-20 lg:py-28 overflow-hidden bg-navy-900 dark:bg-navy-950"
      aria-labelledby="stats-heading"
    >
      {/* Background blobs */}
      <div
        className="pointer-events-none absolute -top-40 -right-40 h-96 w-96 rounded-full bg-violet-600/10 blur-3xl"
        aria-hidden
      />
      <div
        className="pointer-events-none absolute -bottom-40 -left-40 h-96 w-96 rounded-full bg-navy-500/20 blur-3xl"
        aria-hidden
      />
      <div
        className="pointer-events-none absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 h-[600px] w-[600px] rounded-full bg-violet-900/20 blur-3xl"
        aria-hidden
      />

      {/* Grid pattern */}
      <div className="pointer-events-none absolute inset-0 bg-grid opacity-20" aria-hidden />

      <div className="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {/* Heading */}
        <motion.div
          initial={{ opacity: 0, y: 24 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true, amount: 0.3 }}
          transition={{ duration: 0.6 }}
          className="text-center mb-14"
        >
          <span className="inline-block rounded-full border border-white/10 bg-white/5 px-4 py-1.5 text-sm font-semibold text-white/70 mb-4 backdrop-blur-sm">
            بالأرقام
          </span>

          <h2
            id="stats-heading"
            className="text-3xl sm:text-4xl lg:text-5xl font-black text-white mb-4"
          >
            منصة موثوقة{" "}
            <span className="bg-gradient-to-l from-violet-400 to-navy-300 bg-clip-text text-transparent">
              بالأرقام
            </span>
          </h2>

          <p className="text-lg text-white/50 max-w-xl mx-auto">
            نتائج حقيقية من تحليلات فعلية تُثبت دقة نماذجنا وكفاءة منصتنا
          </p>
        </motion.div>

        {/* Stats grid */}
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 lg:gap-6">
          {STATS.map((stat, index) => (
            <StatCard key={stat.label} stat={stat} delay={index * 0.12} />
          ))}
        </div>

        {/* Bottom divider line */}
        <motion.div
          initial={{ scaleX: 0, opacity: 0 }}
          whileInView={{ scaleX: 1, opacity: 1 }}
          viewport={{ once: true }}
          transition={{ duration: 0.8, delay: 0.5 }}
          className="mt-16 h-px w-full bg-gradient-to-l from-transparent via-white/10 to-transparent"
        />

        {/* Footer note */}
        <motion.p
          initial={{ opacity: 0 }}
          whileInView={{ opacity: 1 }}
          viewport={{ once: true }}
          transition={{ delay: 0.7 }}
          className="text-center text-sm text-white/30 mt-6"
        >
          البيانات محدّثة باستمرار — آخر تحديث: ٢٠٢٥
        </motion.p>
      </div>
    </section>
  );
}
