"use client";

import { useEffect, useRef, useState } from "react";
import { motion, useInView } from "framer-motion";
import {
  BarChart3,
  Brain,
  TrendingUp,
  Zap,
  ArrowUpRight,
  ArrowDownRight,
} from "lucide-react";

// ─── Types ───────────────────────────────────────────────────────────────────

interface KPICardProps {
  title: string;
  value: number;
  suffix?: string;
  description: string;
  icon: React.ReactNode;
  trend?: { value: number; positive: boolean };
  gradientFrom: string;
  gradientTo: string;
  delay?: number;
  format?: "number" | "percent" | "decimal";
}

// ─── Animated Number Hook ─────────────────────────────────────────────────────

function useCountUp(
  target: number,
  duration: number = 1800,
  enabled: boolean = true,
  decimals: number = 0
): string {
  const [count, setCount] = useState(0);

  useEffect(() => {
    if (!enabled) return;
    let startTime: number | null = null;
    const startValue = 0;

    function step(timestamp: number) {
      if (!startTime) startTime = timestamp;
      const progress = Math.min((timestamp - startTime) / duration, 1);
      // Ease out cubic
      const eased = 1 - Math.pow(1 - progress, 3);
      const current = startValue + eased * (target - startValue);
      setCount(current);
      if (progress < 1) requestAnimationFrame(step);
    }

    requestAnimationFrame(step);
  }, [target, duration, enabled]);

  if (decimals > 0) return count.toFixed(decimals);
  return Math.round(count).toLocaleString("ar-EG");
}

// ─── Single KPI Card ──────────────────────────────────────────────────────────

function KPICard({
  title,
  value,
  suffix = "",
  description,
  icon,
  trend,
  gradientFrom,
  gradientTo,
  delay = 0,
  format = "number",
}: KPICardProps) {
  const ref = useRef<HTMLDivElement>(null);
  const inView = useInView(ref, { once: true, margin: "-50px" });

  const decimals = format === "decimal" ? 1 : 0;
  const animated = useCountUp(value, 1800, inView, decimals);

  return (
    <motion.div
      ref={ref}
      initial={{ opacity: 0, y: 30 }}
      animate={inView ? { opacity: 1, y: 0 } : {}}
      transition={{ duration: 0.6, delay, ease: [0.22, 1, 0.36, 1] }}
      className="relative group"
    >
      {/* Glow effect */}
      <div
        className="absolute inset-0 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur-xl"
        style={{
          background: `linear-gradient(135deg, ${gradientFrom}22, ${gradientTo}22)`,
        }}
      />

      <div className="relative bg-white/70 dark:bg-navy-800/60 backdrop-blur-sm border border-white/60 dark:border-navy-700/60 rounded-2xl p-6 shadow-glass hover:shadow-glass-lg transition-all duration-300 hover:-translate-y-1 overflow-hidden">
        {/* Background gradient blob */}
        <div
          className="absolute -top-8 -right-8 w-32 h-32 rounded-full opacity-10 blur-2xl"
          style={{ background: `radial-gradient(circle, ${gradientFrom}, ${gradientTo})` }}
        />

        {/* Header: icon + trend */}
        <div className="flex items-start justify-between mb-4">
          <div
            className="w-12 h-12 rounded-xl flex items-center justify-center shadow-md"
            style={{
              background: `linear-gradient(135deg, ${gradientFrom}, ${gradientTo})`,
            }}
          >
            {icon}
          </div>

          {trend && (
            <div
              className={`flex items-center gap-1 text-xs font-semibold px-2 py-1 rounded-full ${
                trend.positive
                  ? "bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400"
                  : "bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400"
              }`}
            >
              {trend.positive ? (
                <ArrowUpRight className="w-3 h-3" />
              ) : (
                <ArrowDownRight className="w-3 h-3" />
              )}
              {trend.value}%
            </div>
          )}
        </div>

        {/* Animated number */}
        <div className="mb-1">
          <span className="text-4xl font-extrabold text-navy-800 dark:text-white tracking-tight tabular-nums">
            {format === "percent" ? `${animated}%` : animated}
            {suffix && <span className="text-2xl font-bold text-navy-500 dark:text-navy-300 mr-1">{suffix}</span>}
          </span>
        </div>

        {/* Title */}
        <p className="text-sm font-bold text-navy-700 dark:text-navy-100 mb-1">{title}</p>

        {/* Description */}
        <p className="text-xs text-navy-400 dark:text-navy-400 leading-relaxed">{description}</p>

        {/* Bottom accent bar */}
        <div
          className="absolute bottom-0 right-0 left-0 h-0.5 rounded-b-2xl"
          style={{ background: `linear-gradient(90deg, ${gradientFrom}, ${gradientTo})` }}
        />
      </div>
    </motion.div>
  );
}

// ─── KPI Cards Section ────────────────────────────────────────────────────────

export function KPICards() {
  const cards: KPICardProps[] = [
    {
      title: "إجمالي التحليلات",
      value: 3847,
      description: "إجمالي النصوص التي تم تحليلها منذ إطلاق المنصة",
      icon: <BarChart3 className="w-6 h-6 text-white" />,
      trend: { value: 12.5, positive: true },
      gradientFrom: "#6C63FF",
      gradientTo: "#1E3A5F",
      delay: 0,
      format: "number",
    },
    {
      title: "متوسط دقة النموذج",
      value: 84,
      suffix: "",
      description: "متوسط مستوى الثقة عبر جميع التحليلات المنجزة",
      icon: <Brain className="w-6 h-6 text-white" />,
      trend: { value: 3.2, positive: true },
      gradientFrom: "#4A90D9",
      gradientTo: "#1E6BAF",
      delay: 0.1,
      format: "percent",
    },
    {
      title: "تحليلات اليوم",
      value: 47,
      description: "عدد النصوص التي تم تحليلها خلال اليوم الحالي",
      icon: <Zap className="w-6 h-6 text-white" />,
      trend: { value: 8.1, positive: true },
      gradientFrom: "#52B788",
      gradientTo: "#2A8A5E",
      delay: 0.2,
      format: "number",
    },
    {
      title: "نمو أسبوعي",
      value: 12.5,
      description: "معدل النمو مقارنةً بالأسبوع الماضي في حجم التحليلات",
      icon: <TrendingUp className="w-6 h-6 text-white" />,
      trend: { value: 12.5, positive: true },
      gradientFrom: "#E8924A",
      gradientTo: "#BF6520",
      delay: 0.3,
      format: "decimal",
      suffix: "%",
    },
  ];

  return (
    <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
      {cards.map((card) => (
        <KPICard key={card.title} {...card} />
      ))}
    </div>
  );
}
