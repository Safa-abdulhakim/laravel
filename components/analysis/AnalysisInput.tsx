"use client";

import { useState, useRef, useCallback } from "react";
import { motion, AnimatePresence } from "framer-motion";
import { Brain, RotateCcw, Sparkles, AlertCircle, ChevronLeft } from "lucide-react";
import { cn } from "@/lib/utils";

// ─── Sample texts for the example buttons ────────────────────────────────────

const EXAMPLE_TEXTS = {
  depression:
    "أنا تعبان جداً من كل شي، ما عندي حيل أقوم وأسوي شي، حاسس إني فاشل بكل شي، مو لاقي راحة ولا فرحة، كل يوم بالنسبة لي زي اللي قبله بدون أي معنى",
  anxiety:
    "والله ما أقدر أنام من القلق، دايم خايف يصير شي، دقات قلبي سريعة ومو قادر أتركز، كل شوية أحس إن في شي غلط رح يصير",
  stress:
    "مشغول ومرهق من الشغل والدراسة، ضايق ومو لاقي وقت لنفسي، طفشان من كل شي بس لازم أكمل لأن ما عندي خيار ثاني",
};

const EXAMPLE_LABELS: Record<keyof typeof EXAMPLE_TEXTS, { label: string; color: string; bg: string; border: string }> = {
  depression: {
    label: "مثال: اكتئاب",
    color: "text-depression-text",
    bg: "bg-depression-light hover:bg-depression-medium/30",
    border: "border-depression-medium",
  },
  anxiety: {
    label: "مثال: قلق",
    color: "text-anxiety-text",
    bg: "bg-anxiety-light hover:bg-anxiety-medium/30",
    border: "border-anxiety-medium",
  },
  stress: {
    label: "مثال: ضغوط",
    color: "text-stress-text",
    bg: "bg-stress-light hover:bg-stress-medium/30",
    border: "border-stress-medium",
  },
};

// ─── Props ────────────────────────────────────────────────────────────────────

interface AnalysisInputProps {
  onAnalyze: (text: string) => void;
  isLoading: boolean;
  onReset: () => void;
  hasResult: boolean;
}

// ─── Component ────────────────────────────────────────────────────────────────

export function AnalysisInput({ onAnalyze, isLoading, onReset, hasResult }: AnalysisInputProps) {
  const [text, setText] = useState("");
  const [validationError, setValidationError] = useState<string | null>(null);
  const textareaRef = useRef<HTMLTextAreaElement>(null);

  const MIN_CHARS = 10;
  const MAX_CHARS = 1000;
  const charCount = text.length;
  const progressPercent = Math.min((charCount / MAX_CHARS) * 100, 100);
  const isValid = charCount >= MIN_CHARS && charCount <= MAX_CHARS;

  const handleTextChange = useCallback((e: React.ChangeEvent<HTMLTextAreaElement>) => {
    const val = e.target.value;
    if (val.length <= MAX_CHARS) {
      setText(val);
      if (validationError && val.length >= MIN_CHARS) {
        setValidationError(null);
      }
    }
  }, [validationError]);

  const handleExampleClick = useCallback((key: keyof typeof EXAMPLE_TEXTS) => {
    setText(EXAMPLE_TEXTS[key]);
    setValidationError(null);
    textareaRef.current?.focus();
  }, []);

  const handleAnalyze = useCallback(() => {
    if (!isValid) {
      if (charCount < MIN_CHARS) {
        setValidationError(`يرجى كتابة ما لا يقل عن ${MIN_CHARS} أحرف`);
      } else {
        setValidationError(`لا يمكن تجاوز ${MAX_CHARS} حرف`);
      }
      return;
    }
    setValidationError(null);
    onAnalyze(text);
  }, [isValid, charCount, text, onAnalyze]);

  const handleReset = useCallback(() => {
    setText("");
    setValidationError(null);
    onReset();
    textareaRef.current?.focus();
  }, [onReset]);

  // Progress bar color based on progress
  const progressColor =
    progressPercent > 90
      ? "bg-anxiety"
      : progressPercent > 70
      ? "bg-violet-400"
      : "bg-violet-500";

  return (
    <motion.div
      initial={{ opacity: 0, y: 24 }}
      animate={{ opacity: 1, y: 0 }}
      transition={{ duration: 0.5, ease: "easeOut" }}
      className="w-full"
    >
      {/* ── Glass Card ── */}
      <div
        className={cn(
          "relative rounded-3xl border border-white/20 bg-white/80 dark:bg-navy-800/60",
          "shadow-glass-lg backdrop-blur-sm",
          "dark:border-navy-700/40",
          "transition-all duration-300"
        )}
      >
        {/* Top decorative gradient strip */}
        <div className="absolute inset-x-0 top-0 h-1 rounded-t-3xl bg-gradient-to-r from-violet-500 via-navy-500 to-depression" />

        <div className="p-6 pt-7 sm:p-8 sm:pt-9">
          {/* ── Header ── */}
          <div className="mb-6 flex items-center gap-3">
            <div className="flex h-10 w-10 items-center justify-center rounded-2xl bg-gradient-to-br from-violet-500 to-navy-600 shadow-glow">
              <Brain className="h-5 w-5 text-white" />
            </div>
            <div>
              <h2 className="text-lg font-bold text-navy-800 dark:text-navy-100">
                أدخل النص للتحليل
              </h2>
              <p className="text-xs text-muted-foreground">
                اكتب باللهجة اليمنية أو الفصحى
              </p>
            </div>
          </div>

          {/* ── Textarea ── */}
          <div className="relative">
            <textarea
              ref={textareaRef}
              dir="rtl"
              value={text}
              onChange={handleTextChange}
              disabled={isLoading}
              placeholder="اكتب ما تشعر به هنا... (باللهجة اليمنية)"
              className={cn(
                "w-full resize-none rounded-2xl border-2 bg-white/60 dark:bg-navy-900/40",
                "px-5 py-4 text-base leading-relaxed text-navy-900 dark:text-navy-50",
                "placeholder:text-muted-foreground/60",
                "font-arabic transition-all duration-200",
                "focus:outline-none focus:ring-0",
                "disabled:cursor-not-allowed disabled:opacity-60",
                validationError
                  ? "border-red-300 focus:border-red-400 dark:border-red-700"
                  : "border-navy-100 dark:border-navy-700 focus:border-violet-400 dark:focus:border-violet-500"
              )}
              style={{ minHeight: "200px" }}
              aria-label="نص التحليل"
            />

            {/* Floating sparkle icon */}
            {charCount === 0 && (
              <div className="pointer-events-none absolute bottom-4 left-4 opacity-20">
                <Sparkles className="h-5 w-5 text-violet-500" />
              </div>
            )}
          </div>

          {/* ── Character counter + progress ── */}
          <div className="mt-3 space-y-2">
            {/* Progress bar */}
            <div className="h-1.5 w-full overflow-hidden rounded-full bg-navy-100 dark:bg-navy-700">
              <motion.div
                className={cn("h-full rounded-full transition-colors duration-300", progressColor)}
                initial={{ width: "0%" }}
                animate={{ width: `${progressPercent}%` }}
                transition={{ duration: 0.3 }}
              />
            </div>

            <div className="flex items-center justify-between text-xs">
              {/* Validation error / hint */}
              <AnimatePresence mode="wait">
                {validationError ? (
                  <motion.span
                    key="error"
                    initial={{ opacity: 0, x: 6 }}
                    animate={{ opacity: 1, x: 0 }}
                    exit={{ opacity: 0 }}
                    className="flex items-center gap-1 text-red-500 dark:text-red-400"
                  >
                    <AlertCircle className="h-3.5 w-3.5" />
                    {validationError}
                  </motion.span>
                ) : (
                  <motion.span
                    key="hint"
                    initial={{ opacity: 0 }}
                    animate={{ opacity: 1 }}
                    className="text-muted-foreground"
                  >
                    {charCount < MIN_CHARS
                      ? `${MIN_CHARS - charCount} حرف إضافي على الأقل`
                      : "جاهز للتحليل"}
                  </motion.span>
                )}
              </AnimatePresence>

              {/* Char count */}
              <span
                className={cn(
                  "font-medium tabular-nums",
                  charCount > MAX_CHARS * 0.9
                    ? "text-anxiety-text dark:text-anxiety"
                    : "text-muted-foreground"
                )}
              >
                {charCount.toLocaleString("ar-EG")} / {MAX_CHARS.toLocaleString("ar-EG")}
              </span>
            </div>
          </div>

          {/* ── Example buttons ── */}
          <div className="mt-5">
            <p className="mb-3 text-xs font-semibold uppercase tracking-wide text-muted-foreground">
              جرب مثالاً
            </p>
            <div className="flex flex-wrap gap-2">
              {(Object.keys(EXAMPLE_LABELS) as Array<keyof typeof EXAMPLE_TEXTS>).map((key) => {
                const config = EXAMPLE_LABELS[key];
                return (
                  <button
                    key={key}
                    onClick={() => handleExampleClick(key)}
                    disabled={isLoading}
                    className={cn(
                      "rounded-xl border px-4 py-2 text-sm font-medium transition-all duration-200",
                      "active:scale-95 disabled:cursor-not-allowed disabled:opacity-50",
                      config.bg,
                      config.color,
                      config.border
                    )}
                  >
                    {config.label}
                  </button>
                );
              })}
            </div>
          </div>

          {/* ── Action buttons ── */}
          <div className="mt-6 flex flex-col gap-3 sm:flex-row">
            {/* Analyze button */}
            <motion.button
              onClick={handleAnalyze}
              disabled={isLoading || !isValid}
              whileTap={{ scale: 0.97 }}
              whileHover={{ scale: isLoading || !isValid ? 1 : 1.02 }}
              className={cn(
                "relative flex-1 overflow-hidden rounded-2xl px-8 py-4",
                "text-base font-bold text-white shadow-glow transition-all duration-300",
                "flex items-center justify-center gap-3",
                "disabled:cursor-not-allowed disabled:opacity-60 disabled:shadow-none",
                "bg-gradient-to-l from-violet-500 to-navy-600",
                "hover:from-violet-600 hover:to-navy-700",
                "focus:outline-none focus-visible:ring-2 focus-visible:ring-violet-400"
              )}
              aria-label="بدء التحليل"
            >
              {/* Shimmer overlay */}
              {!isLoading && isValid && (
                <span
                  className="pointer-events-none absolute inset-0 rounded-2xl bg-gradient-to-l from-transparent via-white/10 to-transparent animate-shimmer"
                  style={{ backgroundSize: "200% 100%" }}
                />
              )}

              {isLoading ? (
                <>
                  {/* Spinner */}
                  <svg
                    className="h-5 w-5 animate-spin text-white"
                    fill="none"
                    viewBox="0 0 24 24"
                  >
                    <circle
                      className="opacity-25"
                      cx="12"
                      cy="12"
                      r="10"
                      stroke="currentColor"
                      strokeWidth="4"
                    />
                    <path
                      className="opacity-75"
                      fill="currentColor"
                      d="M4 12a8 8 0 018-8v8H4z"
                    />
                  </svg>
                  <span>جارٍ التحليل...</span>
                </>
              ) : (
                <>
                  <Brain className="h-5 w-5" />
                  <span>بدء التحليل</span>
                  <ChevronLeft className="h-4 w-4 opacity-70" />
                </>
              )}
            </motion.button>

            {/* Reset / New analysis button — shown when there's a result */}
            <AnimatePresence>
              {hasResult && (
                <motion.button
                  initial={{ opacity: 0, width: 0 }}
                  animate={{ opacity: 1, width: "auto" }}
                  exit={{ opacity: 0, width: 0 }}
                  onClick={handleReset}
                  disabled={isLoading}
                  whileTap={{ scale: 0.97 }}
                  className={cn(
                    "flex items-center justify-center gap-2 rounded-2xl border-2 px-6 py-4",
                    "text-sm font-semibold transition-all duration-200",
                    "border-navy-200 text-navy-600 hover:bg-navy-50",
                    "dark:border-navy-600 dark:text-navy-300 dark:hover:bg-navy-800",
                    "disabled:cursor-not-allowed disabled:opacity-50"
                  )}
                >
                  <RotateCcw className="h-4 w-4" />
                  <span className="whitespace-nowrap">تحليل نص جديد</span>
                </motion.button>
              )}
            </AnimatePresence>
          </div>
        </div>
      </div>
    </motion.div>
  );
}
