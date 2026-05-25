"use client";

import { motion } from "framer-motion";
import {
  Brain,
  Shield,
  Zap,
  BarChart3,
  Globe,
  Layers,
} from "lucide-react";
import { cn } from "@/lib/utils";
import { FEATURES } from "@/lib/constants";

/* ─────────────────────────────────────────────
   Icon map (matches constants.ts icon names)
───────────────────────────────────────────── */
const ICON_MAP: Record<string, React.ElementType> = {
  Brain,
  Shield,
  Zap,
  BarChart3,
  Globe,
  Layers,
};

/* ─────────────────────────────────────────────
   Animation variants
───────────────────────────────────────────── */
const containerVariants = {
  hidden: { opacity: 0 },
  visible: {
    opacity: 1,
    transition: { staggerChildren: 0.1, delayChildren: 0.05 },
  },
};

const headingVariants = {
  hidden: { opacity: 0, y: 24 },
  visible: { opacity: 1, y: 0, transition: { duration: 0.6, ease: [0.22, 1, 0.36, 1] } },
};

const cardVariants = {
  hidden: { opacity: 0, y: 32 },
  visible: {
    opacity: 1,
    y: 0,
    transition: { duration: 0.6, ease: [0.22, 1, 0.36, 1] },
  },
};

/* ─────────────────────────────────────────────
   Feature Card
───────────────────────────────────────────── */
interface FeatureCardProps {
  feature: (typeof FEATURES)[number];
  index: number;
}

function FeatureCard({ feature, index }: FeatureCardProps) {
  const IconComponent = ICON_MAP[feature.icon] ?? Brain;

  return (
    <motion.div
      variants={cardVariants}
      whileHover={{
        y: -8,
        transition: { duration: 0.25, ease: "easeOut" },
      }}
      className="feature-card group relative overflow-hidden"
    >
      {/* Hover glow overlay */}
      <div className="pointer-events-none absolute inset-0 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-gradient-to-br from-violet-500/4 to-navy-600/4" />

      {/* Corner accent */}
      <div className="pointer-events-none absolute top-0 right-0 h-20 w-20 overflow-hidden rounded-bl-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <div className="absolute -top-10 -right-10 h-20 w-20 rounded-full bg-gradient-to-br from-violet-500/10 to-transparent" />
      </div>

      <div className="relative z-10">
        {/* Icon */}
        <div
          className={cn(
            "mb-4 inline-flex h-12 w-12 items-center justify-center rounded-2xl transition-transform duration-300 group-hover:scale-110",
            feature.bg
          )}
        >
          <IconComponent
            className={cn("h-6 w-6 transition-colors duration-200", feature.color)}
            strokeWidth={1.75}
          />
        </div>

        {/* Index badge */}
        <span className="absolute top-0 left-0 text-6xl font-black text-muted/30 dark:text-white/5 select-none leading-none pointer-events-none">
          {String(index + 1).padStart(2, "0")}
        </span>

        {/* Content */}
        <h3 className="text-base font-bold text-foreground mb-2 leading-snug">
          {feature.title}
        </h3>
        <p className="text-sm leading-relaxed text-muted-foreground">
          {feature.description}
        </p>

        {/* Bottom arrow indicator */}
        <div className="mt-5 flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-x-2 group-hover:translate-x-0">
          <span className={cn("text-xs font-semibold", feature.color)}>اكتشف المزيد</span>
          <div
            className={cn(
              "h-0.5 w-6 rounded-full transition-all duration-300 group-hover:w-8",
              feature.color.replace("text-", "bg-")
            )}
          />
        </div>
      </div>
    </motion.div>
  );
}

/* ─────────────────────────────────────────────
   Main Section
───────────────────────────────────────────── */
export default function FeaturesSection() {
  const viewportConfig = { once: true, amount: 0.1 };

  return (
    <section
      dir="rtl"
      className="relative py-20 lg:py-28 bg-muted/30 dark:bg-navy-900/30 overflow-hidden"
      aria-labelledby="features-heading"
    >
      {/* Subtle background texture */}
      <div
        className="pointer-events-none absolute inset-0 bg-grid opacity-50 dark:opacity-20"
        aria-hidden
      />

      {/* Top fade */}
      <div
        className="pointer-events-none absolute top-0 left-0 right-0 h-16 bg-gradient-to-b from-background to-transparent"
        aria-hidden
      />
      {/* Bottom fade */}
      <div
        className="pointer-events-none absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-background to-transparent"
        aria-hidden
      />

      <div className="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {/* Section heading */}
        <motion.div
          variants={containerVariants}
          initial="hidden"
          whileInView="visible"
          viewport={viewportConfig}
          className="text-center mb-16"
        >
          <motion.span
            variants={headingVariants}
            className="inline-block rounded-full border border-navy-200 dark:border-navy-700/50 bg-navy-50 dark:bg-navy-900/40 px-4 py-1.5 text-sm font-semibold text-navy-700 dark:text-navy-300 mb-4"
          >
            مميزات المنصة
          </motion.span>

          <motion.h2
            variants={headingVariants}
            id="features-heading"
            className="text-3xl sm:text-4xl lg:text-5xl font-black text-foreground mb-4"
          >
            لماذا{" "}
            <span className="gradient-text">نبضات؟</span>
          </motion.h2>

          <motion.p
            variants={headingVariants}
            className="text-lg text-muted-foreground max-w-2xl mx-auto"
          >
            أداة متكاملة تجمع الدقة العلمية مع سهولة الاستخدام لفهم حالتك النفسية
          </motion.p>
        </motion.div>

        {/* Features grid */}
        <motion.div
          variants={containerVariants}
          initial="hidden"
          whileInView="visible"
          viewport={viewportConfig}
          className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 lg:gap-6"
        >
          {FEATURES.map((feature, index) => (
            <FeatureCard key={feature.title} feature={feature} index={index} />
          ))}
        </motion.div>

        {/* Bottom CTA banner */}
        <motion.div
          initial={{ opacity: 0, y: 24 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          transition={{ duration: 0.6, delay: 0.3 }}
          className="mt-16 rounded-3xl border border-violet-200 dark:border-violet-700/30 bg-gradient-to-l from-violet-50 to-navy-50 dark:from-violet-900/10 dark:to-navy-900/20 p-8 text-center"
        >
          <h3 className="text-xl font-bold text-foreground mb-2">
            جاهز لتجربة التحليل الذكي؟
          </h3>
          <p className="text-muted-foreground text-sm mb-4">
            ابدأ مجاناً — لا تسجيل، لا حفظ للبيانات الشخصية
          </p>
          <a
            href="/analysis"
            className="inline-flex items-center gap-2 rounded-xl bg-gradient-to-l from-navy-600 to-violet-600 px-6 py-3 text-sm font-semibold text-white shadow-glow hover:shadow-glow-lg transition-shadow duration-200 hover:-translate-y-0.5 active:scale-95"
          >
            <Brain className="h-4 w-4" />
            ابدأ التحليل مجاناً
          </a>
        </motion.div>
      </div>
    </section>
  );
}
