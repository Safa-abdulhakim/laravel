"use client";

import { motion, useReducedMotion } from "framer-motion";
import { PenLine, Cpu, BarChart2, ArrowLeft } from "lucide-react";
import { cn } from "@/lib/utils";
import { HOW_IT_WORKS_STEPS } from "@/lib/constants";

/* ─────────────────────────────────────────────
   Icon map
───────────────────────────────────────────── */
const ICON_MAP: Record<string, React.ElementType> = {
  PenLine,
  Cpu,
  ChartBar: BarChart2,
};

/* ─────────────────────────────────────────────
   Animation variants
───────────────────────────────────────────── */
const sectionVariants = {
  hidden: { opacity: 0 },
  visible: {
    opacity: 1,
    transition: { staggerChildren: 0.18, delayChildren: 0.1 },
  },
};

const headingVariants = {
  hidden: { opacity: 0, y: 24 },
  visible: { opacity: 1, y: 0, transition: { duration: 0.6, ease: [0.22, 1, 0.36, 1] } },
};

const cardVariants = {
  hidden: { opacity: 0, y: 40 },
  visible: {
    opacity: 1,
    y: 0,
    transition: { duration: 0.65, ease: [0.22, 1, 0.36, 1] },
  },
};

/* ─────────────────────────────────────────────
   Gradient configs per step
───────────────────────────────────────────── */
const STEP_STYLES = [
  {
    gradient: "from-violet-500 to-navy-600",
    glow: "shadow-[0_0_32px_rgba(108,99,255,0.35)]",
    ring: "ring-violet-200 dark:ring-violet-700/40",
    iconBg: "from-violet-500 to-violet-700",
    numberColor: "text-violet-500/20 dark:text-violet-400/15",
    borderHover: "hover:border-violet-300 dark:hover:border-violet-600/50",
    topAccent: "from-violet-500/80 to-navy-600/80",
  },
  {
    gradient: "from-navy-500 to-depression",
    glow: "shadow-[0_0_32px_rgba(74,144,217,0.35)]",
    ring: "ring-depression/20 dark:ring-depression/20",
    iconBg: "from-navy-500 to-depression",
    numberColor: "text-depression/20 dark:text-depression/15",
    borderHover: "hover:border-depression/30 dark:hover:border-depression/30",
    topAccent: "from-navy-500/80 to-depression/80",
  },
  {
    gradient: "from-stress to-navy-600",
    glow: "shadow-[0_0_32px_rgba(82,183,136,0.35)]",
    ring: "ring-stress/20 dark:ring-stress/20",
    iconBg: "from-stress to-navy-600",
    numberColor: "text-stress/20 dark:text-stress/15",
    borderHover: "hover:border-stress/30 dark:hover:border-stress/30",
    topAccent: "from-stress/80 to-navy-600/80",
  },
];

/* ─────────────────────────────────────────────
   Connector Arrow
───────────────────────────────────────────── */
function StepConnector() {
  return (
    <div className="hidden lg:flex items-center justify-center self-center mt-[-2rem]">
      <motion.div
        initial={{ scaleX: 0, opacity: 0 }}
        whileInView={{ scaleX: 1, opacity: 1 }}
        viewport={{ once: true }}
        transition={{ duration: 0.6, delay: 0.4, ease: "easeOut" }}
        className="flex items-center gap-1"
      >
        <div className="h-px w-12 bg-gradient-to-l from-transparent via-violet-400/60 to-transparent" />
        <ArrowLeft className="h-4 w-4 text-violet-400/60" />
        <div className="h-px w-12 bg-gradient-to-l from-violet-400/60 via-transparent to-transparent" />
      </motion.div>
    </div>
  );
}

/* ─────────────────────────────────────────────
   Step Card
───────────────────────────────────────────── */
interface StepCardProps {
  step: (typeof HOW_IT_WORKS_STEPS)[number];
  index: number;
}

function StepCard({ step, index }: StepCardProps) {
  const style = STEP_STYLES[index] ?? STEP_STYLES[0];
  const IconComponent = ICON_MAP[step.icon] ?? PenLine;

  return (
    <motion.div
      variants={cardVariants}
      whileHover={{ y: -6, transition: { duration: 0.25 } }}
      className={cn(
        "relative flex flex-col rounded-3xl border border-border bg-white dark:bg-navy-800/50",
        "overflow-hidden transition-shadow duration-300 group cursor-default",
        style.borderHover
      )}
    >
      {/* Top gradient accent bar */}
      <div
        className={cn(
          "h-1 w-full bg-gradient-to-l shrink-0",
          style.topAccent
        )}
      />

      {/* Background step number watermark */}
      <span
        className={cn(
          "pointer-events-none absolute bottom-4 left-4 select-none text-8xl font-black leading-none",
          style.numberColor
        )}
        aria-hidden
      >
        {step.step}
      </span>

      <div className="relative z-10 flex flex-col gap-5 p-7">
        {/* Step number pill */}
        <div className="flex items-center gap-3">
          <span
            className={cn(
              "inline-flex h-8 w-14 items-center justify-center rounded-full text-sm font-black text-white bg-gradient-to-l shrink-0",
              style.gradient
            )}
          >
            {step.step}
          </span>
        </div>

        {/* Icon circle */}
        <div
          className={cn(
            "h-14 w-14 rounded-2xl flex items-center justify-center bg-gradient-to-br shadow-lg transition-transform duration-300 group-hover:scale-110",
            style.iconBg
          )}
        >
          <IconComponent className="h-7 w-7 text-white" strokeWidth={1.75} />
        </div>

        {/* Text content */}
        <div>
          <h3 className="text-xl font-bold text-foreground mb-2 leading-snug">
            {step.title}
          </h3>
          <p className="text-sm leading-relaxed text-muted-foreground">
            {step.description}
          </p>
        </div>

        {/* Subtle bottom indicator dots */}
        <div className="flex gap-1.5 mt-auto pt-2">
          {Array.from({ length: 3 }).map((_, i) => (
            <div
              key={i}
              className={cn(
                "h-1.5 rounded-full transition-all duration-300",
                i === index
                  ? cn("w-5 bg-gradient-to-l", style.gradient)
                  : "w-1.5 bg-muted-foreground/20"
              )}
            />
          ))}
        </div>
      </div>
    </motion.div>
  );
}

/* ─────────────────────────────────────────────
   Main Component
───────────────────────────────────────────── */
export default function HowItWorksSection() {
  const prefersReduced = useReducedMotion();

  const viewportConfig = { once: true, amount: 0.15 };

  return (
    <section
      dir="rtl"
      className="relative py-20 lg:py-28 bg-background overflow-hidden"
      aria-labelledby="how-it-works-heading"
    >
      {/* Subtle background blob */}
      {!prefersReduced && (
        <div
          className="pointer-events-none absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 h-[600px] w-[600px] rounded-full bg-violet-500/5 blur-3xl"
          aria-hidden
        />
      )}

      <div className="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {/* Section heading */}
        <motion.div
          variants={sectionVariants}
          initial="hidden"
          whileInView="visible"
          viewport={viewportConfig}
          className="text-center mb-16"
        >
          <motion.span
            variants={headingVariants}
            className="inline-block rounded-full border border-violet-200 dark:border-violet-700/50 bg-violet-50 dark:bg-violet-900/20 px-4 py-1.5 text-sm font-semibold text-violet-700 dark:text-violet-300 mb-4"
          >
            خطوات بسيطة
          </motion.span>

          <motion.h2
            variants={headingVariants}
            id="how-it-works-heading"
            className="text-3xl sm:text-4xl lg:text-5xl font-black text-foreground mb-4"
          >
            كيف يعمل{" "}
            <span className="gradient-text">النظام؟</span>
          </motion.h2>

          <motion.p
            variants={headingVariants}
            className="text-lg text-muted-foreground max-w-2xl mx-auto"
          >
            ثلاث خطوات بسيطة تحوّل كلماتك إلى تحليل نفسي دقيق مدعوم بالذكاء الاصطناعي
          </motion.p>
        </motion.div>

        {/* Steps grid */}
        <motion.div
          variants={sectionVariants}
          initial="hidden"
          whileInView="visible"
          viewport={viewportConfig}
          className="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 items-start"
        >
          {HOW_IT_WORKS_STEPS.map((step, index) => (
            <div key={step.step} className="contents">
              <StepCard step={step} index={index} />
              {index < HOW_IT_WORKS_STEPS.length - 1 && (
                <StepConnector />
              )}
            </div>
          ))}
        </motion.div>

        {/* Bottom decorative line */}
        <motion.div
          initial={{ scaleX: 0, opacity: 0 }}
          whileInView={{ scaleX: 1, opacity: 1 }}
          viewport={{ once: true }}
          transition={{ duration: 0.8, delay: 0.6 }}
          className="mt-16 h-px w-full max-w-md mx-auto bg-gradient-to-l from-transparent via-violet-400/40 to-transparent"
        />
      </div>
    </section>
  );
}
