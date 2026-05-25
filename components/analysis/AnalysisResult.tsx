"use client";

import { motion } from "framer-motion";
import {
  Brain,
  Lightbulb,
  Tag,
  AlertTriangle,
  Clock,
  ChevronUp,
  RotateCcw,
  CheckCircle2,
  Activity,
} from "lucide-react";
import { cn } from "@/lib/utils";
import { getConfidenceLabel } from "@/lib/utils";
import { MENTAL_STATES } from "@/lib/constants";
import type { AnalysisResult } from "@/lib/mock-data";

// ─── Helpers ──────────────────────────────────────────────────────────────────

function getPredictionConfig(prediction: AnalysisResult["prediction"]) {
  const state = MENTAL_STATES[prediction];
  return {
    label: state.label,
    lightBg: state.lightBg,
    textColor: state.textColor,
    borderColor: state.borderColor,
    icon:
      prediction === "depression"
        ? "🌧️"
        : prediction === "anxiety"
        ? "⚡"
        : "🌿",
    gradientFrom: state.gradientFrom,
    gradientTo: state.gradientTo,
  };
}

function ScoreBar({
  label,
  value,
  colorClass,
  barColor,
  delay,
}: {
  label: string;
  value: number;
  colorClass: string;
  barColor: string;
  delay: number;
}) {
  const pct = Math.round(value * 100);
  return (
    <motion.div
      initial={{ opacity: 0, x: 12 }}
      animate={{ opacity: 1, x: 0 }}
      transition={{ duration: 0.4, delay }}
      className="space-y-1.5"
    >
      <div className="flex items-center justify-between text-sm">
        <span className={cn("font-semibold", colorClass)}>{label}</span>
        <span className={cn("font-bold tabular-nums", colorClass)}>{pct}%</span>
      </div>
      <div className="h-2.5 w-full overflow-hidden rounded-full bg-navy-100 dark:bg-navy-700">
        <motion.div
          className={cn("h-full rounded-full", barColor)}
          initial={{ width: 0 }}
          animate={{ width: `${pct}%` }}
          transition={{ duration: 0.8, delay: delay + 0.2, ease: "easeOut" }}
        />
      </div>
    </motion.div>
  );
}

// ─── Section wrapper ──────────────────────────────────────────────────────────

function Section({
  children,
  delay,
  className,
}: {
  children: React.ReactNode;
  delay: number;
  className?: string;
}) {
  return (
    <motion.div
      initial={{ opacity: 0, y: 20 }}
      animate={{ opacity: 1, y: 0 }}
      transition={{ duration: 0.5, delay }}
      className={cn(
        "rounded-2xl border border-white/20 bg-white/70 dark:bg-navy-800/50",
        "p-5 shadow-glass backdrop-blur-sm dark:border-navy-700/40",
        className
      )}
    >
      {children}
    </motion.div>
  );
}

// ─── Props ────────────────────────────────────────────────────────────────────

interface AnalysisResultProps {
  result: AnalysisResult;
  onReset: () => void;
}

// ─── Component ────────────────────────────────────────────────────────────────

export function AnalysisResult({ result, onReset }: AnalysisResultProps) {
  const config = getPredictionConfig(result.prediction);
  const confidencePct = Math.round(result.confidence * 100);
  const confidenceLabel = getConfidenceLabel(result.confidence);

  // Highlighted text — replace keywords with <mark> spans
  const highlightedText = (() => {
    let html = result.text;
    result.keywords.forEach((kw) => {
      const escaped = kw.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
      const regex = new RegExp(`(${escaped})`, "g");
      html = html.replace(
        regex,
        `<mark class="rounded-sm bg-yellow-200 text-yellow-900 dark:bg-yellow-700/40 dark:text-yellow-200 px-0.5">$1</mark>`
      );
    });
    return html;
  })();

  return (
    <motion.div
      initial={{ opacity: 0 }}
      animate={{ opacity: 1 }}
      className="space-y-5 w-full"
    >
      {/* ══════════════════════════════════════════════
          1. TOP SECTION — Main prediction badge
      ══════════════════════════════════════════════ */}
      <motion.div
        initial={{ opacity: 0, scale: 0.96 }}
        animate={{ opacity: 1, scale: 1 }}
        transition={{ duration: 0.5 }}
        className={cn(
          "relative overflow-hidden rounded-3xl border-2 p-6",
          config.lightBg,
          config.borderColor,
          "dark:bg-navy-800/60 dark:border-navy-600/50"
        )}
      >
        {/* Top gradient strip */}
        <div
          className="absolute inset-x-0 top-0 h-1 rounded-t-3xl"
          style={{
            background: `linear-gradient(to right, ${config.gradientFrom}, ${config.gradientTo})`,
          }}
        />

        {/* Background icon */}
        <div className="pointer-events-none absolute -left-4 -bottom-4 text-9xl opacity-10 select-none">
          {config.icon}
        </div>

        <div className="relative z-10 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
          {/* Left: badge + confidence */}
          <div className="space-y-3">
            {/* Prediction badge */}
            <div className="flex items-center gap-3">
              <span className="text-3xl">{config.icon}</span>
              <div>
                <p className="text-xs font-semibold uppercase tracking-wider text-muted-foreground">
                  التصنيف المكتشف
                </p>
                <h3 className={cn("text-2xl font-extrabold", config.textColor)}>
                  {config.label}
                </h3>
              </div>
            </div>

            {/* Confidence badge */}
            <div className="flex flex-wrap items-center gap-2">
              <span
                className={cn(
                  "inline-flex items-center gap-1.5 rounded-xl px-4 py-1.5 text-sm font-bold shadow-sm",
                  config.lightBg,
                  config.textColor,
                  "border",
                  config.borderColor,
                  "dark:bg-navy-700/50"
                )}
              >
                <ChevronUp className="h-3.5 w-3.5" />
                درجة الثقة: {confidencePct}% — {confidenceLabel}
              </span>

              {/* Processing time badge */}
              <span className="inline-flex items-center gap-1.5 rounded-xl border border-navy-200 bg-white/60 px-3 py-1.5 text-xs font-medium text-muted-foreground dark:border-navy-600 dark:bg-navy-700/40">
                <Clock className="h-3.5 w-3.5" />
                {(result.processingTime / 1000).toFixed(2)} ثانية
              </span>
            </div>
          </div>

          {/* Right: reset button */}
          <motion.button
            onClick={onReset}
            whileTap={{ scale: 0.95 }}
            className={cn(
              "flex shrink-0 items-center gap-2 self-start rounded-xl border px-4 py-2.5",
              "text-sm font-semibold transition-all duration-200",
              "border-navy-200 bg-white/70 text-navy-700 hover:bg-white",
              "dark:border-navy-600 dark:bg-navy-700/50 dark:text-navy-200 dark:hover:bg-navy-700"
            )}
          >
            <RotateCcw className="h-4 w-4" />
            تحليل نص جديد
          </motion.button>
        </div>
      </motion.div>

      {/* ══════════════════════════════════════════════
          2. CONFIDENCE SCORES — 3 progress bars
      ══════════════════════════════════════════════ */}
      <Section delay={0.1}>
        <div className="mb-4 flex items-center gap-2">
          <div className="flex h-8 w-8 items-center justify-center rounded-xl bg-gradient-to-br from-violet-500 to-navy-600">
            <Activity className="h-4 w-4 text-white" />
          </div>
          <h4 className="text-sm font-bold text-navy-800 dark:text-navy-100">
            درجات التصنيف
          </h4>
        </div>

        <div className="space-y-4">
          <ScoreBar
            label="اكتئاب"
            value={result.scores.depression}
            colorClass="text-depression-text dark:text-depression"
            barColor="bg-depression"
            delay={0.15}
          />
          <ScoreBar
            label="قلق"
            value={result.scores.anxiety}
            colorClass="text-anxiety-text dark:text-anxiety"
            barColor="bg-anxiety"
            delay={0.25}
          />
          <ScoreBar
            label="ضغوط نفسية"
            value={result.scores.stress}
            colorClass="text-stress-text dark:text-stress"
            barColor="bg-stress"
            delay={0.35}
          />
        </div>
      </Section>

      {/* ══════════════════════════════════════════════
          3. KEYWORDS & SYMPTOMS
      ══════════════════════════════════════════════ */}
      <Section delay={0.2}>
        <div className="mb-4 flex items-center gap-2">
          <div className="flex h-8 w-8 items-center justify-center rounded-xl bg-gradient-to-br from-depression to-depression-dark">
            <Tag className="h-4 w-4 text-white" />
          </div>
          <h4 className="text-sm font-bold text-navy-800 dark:text-navy-100">
            الكلمات المفتاحية والأعراض
          </h4>
        </div>

        {/* Keywords */}
        <div className="mb-4">
          <p className="mb-2 text-xs font-semibold text-muted-foreground">
            كلمات مفتاحية مكتشفة
          </p>
          <div className="flex flex-wrap gap-2">
            {result.keywords.map((kw, i) => (
              <motion.span
                key={kw}
                initial={{ opacity: 0, scale: 0.8 }}
                animate={{ opacity: 1, scale: 1 }}
                transition={{ delay: 0.25 + i * 0.06 }}
                className={cn(
                  "inline-flex items-center gap-1 rounded-xl border px-3 py-1 text-sm font-medium",
                  config.lightBg,
                  config.textColor,
                  config.borderColor,
                  "dark:bg-navy-700/50 dark:border-navy-600"
                )}
              >
                <span className="text-xs opacity-60">#</span>
                {kw}
              </motion.span>
            ))}
          </div>
        </div>

        {/* Symptoms */}
        <div className="mb-5">
          <p className="mb-2 text-xs font-semibold text-muted-foreground">
            أعراض مُكتشفة
          </p>
          <div className="flex flex-wrap gap-2">
            {result.symptoms.map((sym, i) => (
              <motion.span
                key={sym}
                initial={{ opacity: 0, scale: 0.8 }}
                animate={{ opacity: 1, scale: 1 }}
                transition={{ delay: 0.3 + i * 0.07 }}
                className="inline-flex items-center gap-1.5 rounded-xl border border-navy-200 bg-navy-50 px-3 py-1 text-xs font-medium text-navy-700 dark:border-navy-600 dark:bg-navy-700/40 dark:text-navy-200"
              >
                <CheckCircle2 className="h-3.5 w-3.5 text-stress" />
                {sym}
              </motion.span>
            ))}
          </div>
        </div>

        {/* Highlighted original text */}
        <div>
          <p className="mb-2 text-xs font-semibold text-muted-foreground">
            النص الأصلي مع إبراز الكلمات
          </p>
          <div
            dir="rtl"
            className={cn(
              "rounded-xl border p-4 text-sm leading-relaxed text-navy-800 dark:text-navy-100",
              "border-navy-100 bg-white/60 dark:border-navy-700 dark:bg-navy-900/40",
              "font-arabic"
            )}
            dangerouslySetInnerHTML={{ __html: highlightedText }}
          />
        </div>
      </Section>

      {/* ══════════════════════════════════════════════
          4. INSIGHT — AI-generated insight
      ══════════════════════════════════════════════ */}
      <Section delay={0.3}>
        <div className="mb-4 flex items-center gap-2">
          <div className="flex h-8 w-8 items-center justify-center rounded-xl bg-gradient-to-br from-violet-500 to-violet-700">
            <Brain className="h-4 w-4 text-white" />
          </div>
          <h4 className="text-sm font-bold text-navy-800 dark:text-navy-100">
            رؤية الذكاء الاصطناعي
          </h4>
        </div>

        <div
          className={cn(
            "rounded-xl border p-4",
            "border-violet-200 bg-violet-50/70 dark:border-violet-800/40 dark:bg-violet-900/10"
          )}
        >
          {/* Decorative quote mark */}
          <span
            className="float-right mr-1 -mt-1 text-5xl leading-none text-violet-300 dark:text-violet-700 select-none"
            aria-hidden="true"
          >
            &ldquo;
          </span>
          <p className="text-sm leading-relaxed text-navy-700 dark:text-navy-200">
            {result.insight}
          </p>
        </div>
      </Section>

      {/* ══════════════════════════════════════════════
          5. SUGGESTION — Recommendation
      ══════════════════════════════════════════════ */}
      <Section delay={0.4}>
        <div className="mb-4 flex items-center gap-2">
          <div className="flex h-8 w-8 items-center justify-center rounded-xl bg-gradient-to-br from-stress to-stress-dark">
            <Lightbulb className="h-4 w-4 text-white" />
          </div>
          <h4 className="text-sm font-bold text-navy-800 dark:text-navy-100">
            التوصية
          </h4>
        </div>

        <div className="rounded-xl border border-stress-medium bg-stress-light p-4 dark:border-stress/30 dark:bg-stress/10">
          <p className="text-sm leading-relaxed text-stress-text dark:text-stress-medium">
            {result.suggestion}
          </p>
        </div>
      </Section>

      {/* ══════════════════════════════════════════════
          6. DISCLAIMER
      ══════════════════════════════════════════════ */}
      <motion.div
        initial={{ opacity: 0 }}
        animate={{ opacity: 1 }}
        transition={{ delay: 0.55 }}
        className={cn(
          "flex items-start gap-3 rounded-2xl border p-4",
          "border-amber-200 bg-amber-50/70 dark:border-amber-800/30 dark:bg-amber-900/10"
        )}
      >
        <AlertTriangle className="mt-0.5 h-4 w-4 shrink-0 text-amber-500" />
        <p className="text-xs leading-relaxed text-amber-800 dark:text-amber-300">
          <strong>تنبيه مهم:</strong> هذا التحليل مُنجز بالذكاء الاصطناعي ولأغراض توعوية وبحثية
          فقط، ولا يُعدّ تشخيصاً طبياً أو نفسياً. إذا كنت تعاني من أعراض نفسية، يرجى
          استشارة متخصص صحي مؤهل.
        </p>
      </motion.div>
    </motion.div>
  );
}
