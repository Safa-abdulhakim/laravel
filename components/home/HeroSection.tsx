"use client";

import { motion, useReducedMotion } from "framer-motion";
import Link from "next/link";
import { ArrowLeft, Sparkles, TrendingUp, Layers3, Brain } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { cn } from "@/lib/utils";

/* ─────────────────────────────────────────────
   Animation variants
───────────────────────────────────────────── */
const containerVariants = {
  hidden: { opacity: 0 },
  visible: {
    opacity: 1,
    transition: { staggerChildren: 0.15, delayChildren: 0.1 },
  },
};

const itemVariants = {
  hidden: { opacity: 0, y: 32 },
  visible: { opacity: 1, y: 0, transition: { duration: 0.65, ease: [0.22, 1, 0.36, 1] } },
};

const cardVariants = {
  hidden: { opacity: 0, x: 60, scale: 0.92 },
  visible: {
    opacity: 1,
    x: 0,
    scale: 1,
    transition: { duration: 0.75, ease: [0.22, 1, 0.36, 1], delay: 0.45 },
  },
};

const blobVariants = {
  animate: {
    scale: [1, 1.12, 0.92, 1],
    x: [0, 30, -20, 0],
    y: [0, -50, 20, 0],
    transition: { duration: 8, repeat: Infinity, ease: "easeInOut" },
  },
};

/* ─────────────────────────────────────────────
   Demo card data
───────────────────────────────────────────── */
const DEMO_TEXT =
  "والله أنا تعبت من كل شيء، مو قادر أنام وكل يوم حاسس إن في ثقل على صدري...";

const DEMO_KEYWORDS = ["تعبت", "مو قادر", "ثقل", "أنام"];

/* ─────────────────────────────────────────────
   Sub-components
───────────────────────────────────────────── */
function AnimatedBlobs() {
  return (
    <div className="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden>
      {/* Primary violet blob */}
      <motion.div
        variants={blobVariants}
        animate="animate"
        className="absolute -top-32 -right-32 h-[520px] w-[520px] rounded-full bg-violet-500/10 blur-3xl"
      />
      {/* Navy blob */}
      <motion.div
        variants={blobVariants}
        animate="animate"
        style={{ animationDelay: "2s" }}
        className="absolute -bottom-40 -left-40 h-[480px] w-[480px] rounded-full bg-navy-600/10 blur-3xl"
        transition={{ delay: 2 }}
      />
      {/* Accent stress blob */}
      <motion.div
        initial={{ opacity: 0 }}
        animate={{
          opacity: [0.05, 0.12, 0.05],
          scale: [1, 1.08, 1],
          transition: { duration: 6, repeat: Infinity, ease: "easeInOut", delay: 1 },
        }}
        className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 h-[600px] w-[600px] rounded-full bg-violet-400/8 blur-3xl"
      />
      {/* Small floating orbs */}
      {[
        { top: "15%", right: "25%", size: 80, color: "bg-violet-400/20", delay: 0 },
        { top: "65%", right: "8%", size: 56, color: "bg-navy-400/20", delay: 1.5 },
        { top: "30%", left: "10%", size: 64, color: "bg-stress/20", delay: 0.8 },
        { top: "75%", left: "30%", size: 48, color: "bg-depression/20", delay: 2.2 },
      ].map((orb, i) => (
        <motion.div
          key={i}
          animate={{
            y: [0, -14, 0],
            transition: {
              duration: 4 + i * 0.7,
              repeat: Infinity,
              ease: "easeInOut",
              delay: orb.delay,
            },
          }}
          className={cn("absolute rounded-full blur-md", orb.color)}
          style={{
            width: orb.size,
            height: orb.size,
            top: orb.top,
            right: (orb as { right?: string }).right,
            left: (orb as { left?: string }).left,
          }}
        />
      ))}
    </div>
  );
}

function StatBadge({
  icon,
  label,
  delay,
}: {
  icon: React.ReactNode;
  label: string;
  delay: number;
}) {
  return (
    <motion.div
      initial={{ opacity: 0, scale: 0.8, y: 12 }}
      animate={{ opacity: 1, scale: 1, y: 0 }}
      transition={{ duration: 0.5, delay, ease: [0.22, 1, 0.36, 1] }}
      className="glass-card flex items-center gap-2 rounded-full px-4 py-2 shadow-glass"
    >
      <span className="text-violet-500">{icon}</span>
      <span className="text-sm font-semibold text-foreground">{label}</span>
    </motion.div>
  );
}

function FloatingDemoCard() {
  const stages = [
    { label: "تحليل النص...", done: false },
    { label: "اكتشاف المشاعر...", done: false },
    { label: "اكتمل التحليل", done: true },
  ];

  return (
    <motion.div
      variants={cardVariants}
      initial="hidden"
      animate="visible"
      className="relative"
    >
      {/* Glow ring */}
      <div className="absolute -inset-1 rounded-3xl bg-gradient-to-br from-violet-500/30 to-navy-600/30 blur-lg" />

      <div className="relative glass-card rounded-3xl p-6 shadow-glass-xl w-full max-w-sm mx-auto">
        {/* Card header */}
        <div className="flex items-center justify-between mb-5">
          <div className="flex items-center gap-2">
            <div className="h-8 w-8 rounded-xl bg-gradient-to-br from-violet-500 to-navy-600 flex items-center justify-center shadow-glow">
              <Brain className="h-4 w-4 text-white" />
            </div>
            <div>
              <p className="text-xs font-semibold text-foreground">نبضات AI</p>
              <p className="text-[10px] text-muted-foreground">تحليل نفسي</p>
            </div>
          </div>
          <Badge variant="stress" className="text-[10px] px-2 py-0.5">
            مكتمل ✓
          </Badge>
        </div>

        {/* Input text preview */}
        <div className="mb-4 rounded-xl bg-muted/60 dark:bg-navy-900/60 p-3 border border-border/60">
          <p className="text-xs text-muted-foreground leading-relaxed line-clamp-2">{DEMO_TEXT}</p>
        </div>

        {/* Result badges */}
        <div className="flex flex-wrap gap-2 mb-4">
          <Badge variant="depression" className="text-xs">🌧 اكتئاب — ٨٦٪</Badge>
          <Badge variant="anxiety" className="text-xs">⚡ قلق — ٧٢٪</Badge>
          <Badge variant="stress" className="text-xs">🌿 ضغوط — ٦٤٪</Badge>
        </div>

        {/* Confidence bar */}
        <div className="mb-4">
          <div className="flex justify-between text-[10px] text-muted-foreground mb-1">
            <span>درجة الثقة الإجمالية</span>
            <span className="font-semibold text-violet-500">٨٦٪</span>
          </div>
          <div className="h-1.5 w-full rounded-full bg-muted overflow-hidden">
            <motion.div
              initial={{ width: 0 }}
              animate={{ width: "86%" }}
              transition={{ duration: 1.2, delay: 1, ease: "easeOut" }}
              className="h-full rounded-full bg-gradient-to-l from-violet-500 to-navy-500"
            />
          </div>
        </div>

        {/* Processing stages */}
        <div className="space-y-1.5">
          {stages.map((s, i) => (
            <motion.div
              key={i}
              initial={{ opacity: 0, x: 10 }}
              animate={{ opacity: 1, x: 0 }}
              transition={{ delay: 0.9 + i * 0.25 }}
              className="flex items-center gap-2"
            >
              <div
                className={cn(
                  "h-1.5 w-1.5 rounded-full shrink-0",
                  s.done ? "bg-stress" : "bg-violet-400"
                )}
              />
              <span className="text-[10px] text-muted-foreground">{s.label}</span>
            </motion.div>
          ))}
        </div>

        {/* Keywords */}
        <div className="mt-4 pt-3 border-t border-border/60">
          <p className="text-[10px] text-muted-foreground mb-2">الكلمات المفتاحية المكتشفة:</p>
          <div className="flex flex-wrap gap-1.5">
            {DEMO_KEYWORDS.map((kw) => (
              <span
                key={kw}
                className="text-[10px] rounded-full bg-depression-light text-depression-text dark:bg-depression/10 dark:text-depression px-2.5 py-0.5 border border-depression-medium dark:border-depression/30"
              >
                {kw}
              </span>
            ))}
          </div>
        </div>
      </div>

      {/* Floating badge above card */}
      <motion.div
        animate={{ y: [0, -8, 0] }}
        transition={{ duration: 3, repeat: Infinity, ease: "easeInOut" }}
        className="absolute -top-4 -left-4 glass-card rounded-2xl px-3 py-2 shadow-glass flex items-center gap-2"
      >
        <Sparkles className="h-3.5 w-3.5 text-violet-500" />
        <span className="text-xs font-semibold text-foreground">ذكاء اصطناعي</span>
      </motion.div>

      {/* Floating accuracy badge */}
      <motion.div
        animate={{ y: [0, 8, 0] }}
        transition={{ duration: 4, repeat: Infinity, ease: "easeInOut", delay: 1 }}
        className="absolute -bottom-4 -right-4 glass-card rounded-2xl px-3 py-2 shadow-glass flex items-center gap-2"
      >
        <TrendingUp className="h-3.5 w-3.5 text-stress" />
        <span className="text-xs font-semibold text-foreground">٨٤٪ دقة</span>
      </motion.div>
    </motion.div>
  );
}

/* ─────────────────────────────────────────────
   Main Hero Section
───────────────────────────────────────────── */
export default function HeroSection() {
  const prefersReduced = useReducedMotion();

  return (
    <section
      dir="rtl"
      className="relative min-h-[calc(100vh-4rem)] flex items-center overflow-hidden hero-bg bg-grid"
      aria-label="القسم الرئيسي"
    >
      {/* Background patterns */}
      <div className="pointer-events-none absolute inset-0 bg-dots opacity-40 dark:opacity-20" aria-hidden />

      {/* Animated blobs */}
      {!prefersReduced && <AnimatedBlobs />}

      <div className="relative mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
          {/* ── Left content column ── */}
          <motion.div
            variants={containerVariants}
            initial="hidden"
            animate="visible"
            className="flex flex-col items-start text-right"
          >
            {/* Pre-headline badge */}
            <motion.div variants={itemVariants} className="mb-6">
              <span className="inline-flex items-center gap-2 rounded-full border border-violet-200 dark:border-violet-700/50 bg-violet-50 dark:bg-violet-900/20 px-4 py-1.5 text-sm font-semibold text-violet-700 dark:text-violet-300">
                <Sparkles className="h-3.5 w-3.5 animate-pulse-glow" />
                منصة الصحة النفسية باللهجة اليمنية
              </span>
            </motion.div>

            {/* Main headline */}
            <motion.h1
              variants={itemVariants}
              className="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight tracking-tight text-foreground mb-6"
            >
              <span className="block">الكلمات أحيانًا</span>
              <span className="block gradient-text mt-1">تكشف ما يخفيه</span>
              <span className="block">الإنسان</span>
            </motion.h1>

            {/* Subtitle */}
            <motion.p
              variants={itemVariants}
              className="text-lg sm:text-xl text-muted-foreground leading-relaxed mb-8 max-w-xl"
            >
              منصة ذكاء اصطناعي متخصصة في تحليل النصوص المكتوبة باللهجة اليمنية
              للكشف المبكر عن حالات{" "}
              <span className="font-semibold text-depression">الاكتئاب</span>،{" "}
              <span className="font-semibold text-anxiety">القلق</span>، و
              <span className="font-semibold text-stress">الضغوط النفسية</span>.
            </motion.p>

            {/* CTA buttons */}
            <motion.div
              variants={itemVariants}
              className="flex flex-wrap gap-3 mb-10"
            >
              <Button asChild variant="primary" size="xl" className="group">
                <Link href="/analysis">
                  ابدأ التحليل
                  <ArrowLeft className="h-5 w-5 transition-transform group-hover:-translate-x-1" />
                </Link>
              </Button>
              <Button asChild variant="outline" size="xl">
                <Link href="/about">تعرف على المشروع</Link>
              </Button>
            </motion.div>

            {/* Stats badges row */}
            <motion.div
              variants={itemVariants}
              className="flex flex-wrap gap-3"
            >
              <StatBadge
                icon={<TrendingUp className="h-3.5 w-3.5" />}
                label="٣٨٤٧+ تحليل"
                delay={0.8}
              />
              <StatBadge
                icon={<Sparkles className="h-3.5 w-3.5" />}
                label="٨٤٪ دقة"
                delay={0.95}
              />
              <StatBadge
                icon={<Layers3 className="h-3.5 w-3.5" />}
                label="٣ تصنيفات"
                delay={1.1}
              />
            </motion.div>
          </motion.div>

          {/* ── Right demo card column ── */}
          <div className="flex justify-center lg:justify-end">
            <FloatingDemoCard />
          </div>
        </div>
      </div>

      {/* Bottom fade */}
      <div
        className="pointer-events-none absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-background to-transparent"
        aria-hidden
      />
    </section>
  );
}
