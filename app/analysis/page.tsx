"use client";

import { AnimatePresence, motion } from "framer-motion";
import { Brain, Sparkles } from "lucide-react";
import { useAnalysis } from "@/hooks/useAnalysis";
import { AnalysisInput } from "@/components/analysis/AnalysisInput";
import { LoadingAnimation } from "@/components/analysis/LoadingAnimation";
import { AnalysisResult } from "@/components/analysis/AnalysisResult";
import { cn } from "@/lib/utils";

// ─── Background dot pattern ────────────────────────────────────────────────────

function DotPattern() {
  return (
    <div
      className="pointer-events-none absolute inset-0 opacity-30 dark:opacity-10"
      aria-hidden="true"
      style={{
        backgroundImage:
          "radial-gradient(circle, rgba(108,99,255,0.15) 1px, transparent 1px)",
        backgroundSize: "28px 28px",
      }}
    />
  );
}

// ─── Page header ──────────────────────────────────────────────────────────────

function PageHeader() {
  return (
    <motion.div
      initial={{ opacity: 0, y: -16 }}
      animate={{ opacity: 1, y: 0 }}
      transition={{ duration: 0.5 }}
      className="mb-10 text-center"
    >
      {/* Badge */}
      <div className="mb-4 inline-flex items-center gap-2 rounded-2xl border border-violet-200 bg-violet-50 px-4 py-2 dark:border-violet-800/40 dark:bg-violet-900/20">
        <Sparkles className="h-4 w-4 text-violet-500" />
        <span className="text-sm font-semibold text-violet-700 dark:text-violet-300">
          تحليل نفسي بالذكاء الاصطناعي
        </span>
      </div>

      {/* Title */}
      <h1 className="mb-3 text-3xl font-extrabold text-navy-900 dark:text-white sm:text-4xl">
        <span className="bg-gradient-to-l from-violet-500 to-navy-600 bg-clip-text text-transparent">
          تحليل النص
        </span>
      </h1>

      {/* Description */}
      <p className="mx-auto max-w-xl text-sm leading-relaxed text-muted-foreground sm:text-base">
        اكتب ما تشعر به باللهجة اليمنية أو الفصحى، وسيقوم الذكاء الاصطناعي بتحليل
        حالتك النفسية وتقديم رؤى مفيدة خلال ثوانٍ.
      </p>

      {/* Decorative divider */}
      <div className="mt-5 flex items-center justify-center gap-3">
        <div className="h-px w-16 bg-gradient-to-r from-transparent to-violet-300 dark:to-violet-700" />
        <div className="flex h-7 w-7 items-center justify-center rounded-full bg-gradient-to-br from-violet-500 to-navy-600">
          <Brain className="h-3.5 w-3.5 text-white" />
        </div>
        <div className="h-px w-16 bg-gradient-to-l from-transparent to-violet-300 dark:to-violet-700" />
      </div>
    </motion.div>
  );
}

// ─── Page component ────────────────────────────────────────────────────────────

export default function AnalysisPage() {
  const { analyze, reset, result, loadingStep, isLoading, isSuccess } = useAnalysis();

  return (
    <div
      className={cn(
        "relative min-h-screen overflow-x-hidden",
        "bg-gradient-to-br from-slate-50 via-white to-violet-50/40",
        "dark:from-navy-950 dark:via-navy-900 dark:to-navy-950"
      )}
      dir="rtl"
    >
      {/* Background patterns */}
      <DotPattern />

      {/* Gradient blobs */}
      <div className="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
        <div className="absolute -top-32 -right-32 h-96 w-96 rounded-full bg-violet-400/8 blur-3xl dark:bg-violet-600/5 animate-blob" />
        <div className="absolute top-1/3 -left-24 h-80 w-80 rounded-full bg-navy-400/6 blur-3xl dark:bg-navy-500/5 animate-blob [animation-delay:3s]" />
        <div className="absolute bottom-0 right-1/4 h-64 w-64 rounded-full bg-depression/5 blur-3xl animate-blob [animation-delay:6s]" />
      </div>

      {/* ── Main content ── */}
      <div className="relative z-10 mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
        {/* Header */}
        <PageHeader />

        {/* ── Layout: idle/loading = single column, success = two columns ── */}
        <AnimatePresence mode="wait">
          {!isSuccess ? (
            /* ── IDLE / LOADING state ── single centered column */
            <motion.div
              key="pre-result"
              initial={{ opacity: 0 }}
              animate={{ opacity: 1 }}
              exit={{ opacity: 0, y: -12 }}
              transition={{ duration: 0.35 }}
              className="mx-auto max-w-2xl space-y-6"
            >
              <AnalysisInput
                onAnalyze={analyze}
                isLoading={isLoading}
                onReset={reset}
                hasResult={false}
              />

              <AnimatePresence>
                {isLoading && (
                  <motion.div
                    key="loading-anim"
                    initial={{ opacity: 0, y: 16 }}
                    animate={{ opacity: 1, y: 0 }}
                    exit={{ opacity: 0, y: -8 }}
                    transition={{ duration: 0.4 }}
                  >
                    <LoadingAnimation step={loadingStep} />
                  </motion.div>
                )}
              </AnimatePresence>
            </motion.div>
          ) : (
            /* ── SUCCESS state ── two-column layout */
            <motion.div
              key="with-result"
              initial={{ opacity: 0 }}
              animate={{ opacity: 1 }}
              exit={{ opacity: 0 }}
              transition={{ duration: 0.4 }}
              className={cn(
                "grid gap-6",
                "grid-cols-1 lg:grid-cols-[380px_1fr]"
              )}
            >
              {/* Left column — input (compact) */}
              <div className="lg:sticky lg:top-6 lg:self-start">
                <AnalysisInput
                  onAnalyze={analyze}
                  isLoading={isLoading}
                  onReset={reset}
                  hasResult={isSuccess}
                />

                {/* Show loading animation in left column if re-analyzing */}
                <AnimatePresence>
                  {isLoading && (
                    <motion.div
                      key="re-loading"
                      initial={{ opacity: 0, y: 12 }}
                      animate={{ opacity: 1, y: 0 }}
                      exit={{ opacity: 0 }}
                      className="mt-6"
                    >
                      <LoadingAnimation step={loadingStep} />
                    </motion.div>
                  )}
                </AnimatePresence>
              </div>

              {/* Right column — results */}
              <div>
                <AnimatePresence mode="wait">
                  {result && !isLoading && (
                    <motion.div
                      key={result.id}
                      initial={{ opacity: 0, x: -16 }}
                      animate={{ opacity: 1, x: 0 }}
                      exit={{ opacity: 0, x: 16 }}
                      transition={{ duration: 0.45, ease: "easeOut" }}
                    >
                      <AnalysisResult result={result} onReset={reset} />
                    </motion.div>
                  )}
                </AnimatePresence>
              </div>
            </motion.div>
          )}
        </AnimatePresence>

        {/* ── Footer note ── */}
        <motion.p
          initial={{ opacity: 0 }}
          animate={{ opacity: 1 }}
          transition={{ delay: 0.8 }}
          className="mt-12 text-center text-xs text-muted-foreground/60"
        >
          نبضات — منصة تحليل الصحة النفسية باللهجة اليمنية · مشروع بحثي أكاديمي
        </motion.p>
      </div>
    </div>
  );
}
