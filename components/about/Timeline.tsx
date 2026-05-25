"use client";

import { useRef } from "react";
import { motion, useInView, useScroll, useTransform } from "framer-motion";
import { Lightbulb, Database, Brain, Rocket } from "lucide-react";
import { PROJECT_TIMELINE } from "@/lib/constants";

// ─── Icon map ─────────────────────────────────────────────────────────────────

const ICON_MAP: Record<string, React.ReactNode> = {
  Lightbulb: <Lightbulb className="w-5 h-5" />,
  Database: <Database className="w-5 h-5" />,
  Brain: <Brain className="w-5 h-5" />,
  Rocket: <Rocket className="w-5 h-5" />,
};

const MILESTONE_COLORS = [
  { icon: "#6C63FF", bg: "from-violet-500/15 to-navy-50/60 dark:from-violet-900/25 dark:to-navy-800", dot: "#6C63FF" },
  { icon: "#4A90D9", bg: "from-depression/10 to-navy-50/60 dark:from-depression/20 dark:to-navy-800", dot: "#4A90D9" },
  { icon: "#52B788", bg: "from-stress/10 to-navy-50/60 dark:from-stress/20 dark:to-navy-800", dot: "#52B788" },
  { icon: "#E8924A", bg: "from-anxiety/10 to-navy-50/60 dark:from-anxiety/20 dark:to-navy-800", dot: "#E8924A" },
];

// ─── Animated vertical line ───────────────────────────────────────────────────

function TimelineLine({ count }: { count: number }) {
  const ref = useRef<HTMLDivElement>(null);
  const { scrollYProgress } = useScroll({
    target: ref,
    offset: ["start 80%", "end 20%"],
  });
  const height = useTransform(scrollYProgress, [0, 1], ["0%", "100%"]);

  return (
    <div ref={ref} className="absolute right-1/2 top-0 bottom-0 translate-x-1/2 w-0.5 bg-navy-100 dark:bg-navy-700/60 hidden md:block">
      <motion.div
        className="w-full bg-gradient-to-b from-violet-500 via-depression to-anxiety rounded-full"
        style={{ height }}
      />
    </div>
  );
}

// ─── Milestone Card ───────────────────────────────────────────────────────────

function MilestoneCard({
  milestone,
  index,
}: {
  milestone: (typeof PROJECT_TIMELINE)[number];
  index: number;
}) {
  const ref = useRef<HTMLDivElement>(null);
  const inView = useInView(ref, { once: true, margin: "-60px" });
  const isRight = index % 2 === 0; // alternates: right side = start for RTL
  const colors = MILESTONE_COLORS[index % MILESTONE_COLORS.length];

  return (
    <div
      ref={ref}
      className={`relative flex items-center gap-0 md:gap-8 ${
        isRight ? "md:flex-row-reverse" : "md:flex-row"
      } flex-row`}
    >
      {/* Card (half width on desktop) */}
      <motion.div
        initial={{ opacity: 0, x: isRight ? 40 : -40 }}
        animate={inView ? { opacity: 1, x: 0 } : {}}
        transition={{ duration: 0.6, delay: 0.1, ease: [0.22, 1, 0.36, 1] }}
        className="w-full md:w-[calc(50%-2.5rem)] mr-12 md:mr-0"
      >
        <div
          className={`relative bg-gradient-to-br ${colors.bg} backdrop-blur-sm border border-white/60 dark:border-navy-700/50 rounded-2xl p-5 shadow-glass group hover:-translate-y-1 hover:shadow-glass-lg transition-all duration-300`}
        >
          {/* Year badge */}
          <span
            className="inline-block text-xs font-bold px-3 py-1 rounded-full mb-3"
            style={{ backgroundColor: `${colors.icon}18`, color: colors.icon }}
          >
            {milestone.year}
          </span>

          {/* Title */}
          <h3 className="text-base font-extrabold text-navy-900 dark:text-white mb-2">
            {milestone.title}
          </h3>

          {/* Description */}
          <p className="text-sm text-navy-500 dark:text-navy-400 leading-relaxed">
            {milestone.description}
          </p>

          {/* Arrow pointing to center line on desktop */}
          <div
            className={`absolute top-6 hidden md:block w-5 h-0.5 ${
              isRight ? "left-full" : "right-full"
            }`}
            style={{ backgroundColor: `${colors.icon}60` }}
          />
        </div>
      </motion.div>

      {/* Center dot (desktop) */}
      <motion.div
        initial={{ opacity: 0, scale: 0 }}
        animate={inView ? { opacity: 1, scale: 1 } : {}}
        transition={{ duration: 0.4, delay: 0.2, type: "spring", stiffness: 200 }}
        className="absolute right-1/2 translate-x-1/2 z-10 hidden md:flex"
      >
        <div
          className="w-11 h-11 rounded-full flex items-center justify-center shadow-lg ring-4 ring-white dark:ring-navy-900"
          style={{ background: `linear-gradient(135deg, ${colors.icon}, ${colors.icon}BB)` }}
        >
          <span style={{ color: "white" }}>{ICON_MAP[milestone.icon]}</span>
        </div>
      </motion.div>

      {/* Mobile: left-side dot + line */}
      <motion.div
        initial={{ opacity: 0, scale: 0 }}
        animate={inView ? { opacity: 1, scale: 1 } : {}}
        transition={{ duration: 0.4, delay: 0.2, type: "spring" }}
        className="absolute right-0 top-5 z-10 flex md:hidden"
      >
        <div
          className="w-8 h-8 rounded-full flex items-center justify-center shadow-md ring-2 ring-white dark:ring-navy-900"
          style={{ background: `linear-gradient(135deg, ${colors.icon}, ${colors.icon}BB)` }}
        >
          <span style={{ color: "white", display: "flex" }}>
            {ICON_MAP[milestone.icon] &&
              // Smaller icon for mobile
              <span className="scale-75">{ICON_MAP[milestone.icon]}</span>}
          </span>
        </div>
      </motion.div>

      {/* Empty half for desktop layout */}
      <div className="hidden md:block w-[calc(50%-2.5rem)]" />
    </div>
  );
}

// ─── Section ──────────────────────────────────────────────────────────────────

export function Timeline() {
  return (
    <section>
      {/* Header */}
      <motion.div
        initial={{ opacity: 0, y: 20 }}
        whileInView={{ opacity: 1, y: 0 }}
        viewport={{ once: true }}
        transition={{ duration: 0.5 }}
        className="text-center mb-12"
      >
        <span className="inline-block text-xs font-bold text-stress-text dark:text-stress bg-stress-light dark:bg-stress/20 px-3 py-1 rounded-full mb-3">
          الرحلة
        </span>
        <h2 className="text-3xl font-extrabold text-navy-900 dark:text-white mb-3">
          مراحل المشروع
        </h2>
        <p className="text-navy-500 dark:text-navy-400 max-w-xl mx-auto text-sm leading-relaxed">
          رحلة من الفكرة إلى المنصة الكاملة — اكتشف كيف تطوّر مشروع نبضات عبر مراحله الأربع الرئيسية.
        </p>
      </motion.div>

      {/* Timeline */}
      <div className="relative">
        {/* Vertical line (desktop) */}
        <div className="absolute right-1/2 top-5 bottom-5 translate-x-1/2 w-0.5 bg-navy-100 dark:bg-navy-700/60 hidden md:block overflow-hidden">
          <motion.div
            initial={{ scaleY: 0, originY: 0 }}
            whileInView={{ scaleY: 1 }}
            viewport={{ once: true }}
            transition={{ duration: 1.4, ease: "easeInOut" }}
            className="w-full h-full bg-gradient-to-b from-violet-500 via-depression to-anxiety"
          />
        </div>

        {/* Mobile vertical line */}
        <div className="absolute right-4 top-5 bottom-5 w-0.5 bg-navy-100 dark:bg-navy-700/60 md:hidden overflow-hidden">
          <motion.div
            initial={{ scaleY: 0, originY: 0 }}
            whileInView={{ scaleY: 1 }}
            viewport={{ once: true }}
            transition={{ duration: 1.2, ease: "easeInOut" }}
            className="w-full h-full bg-gradient-to-b from-violet-500 to-anxiety"
          />
        </div>

        {/* Milestones */}
        <div className="flex flex-col gap-10">
          {PROJECT_TIMELINE.map((milestone, i) => (
            <MilestoneCard key={milestone.year} milestone={milestone} index={i} />
          ))}
        </div>
      </div>
    </section>
  );
}
