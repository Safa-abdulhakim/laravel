"use client";

import { useState, useCallback } from "react";
import { motion, AnimatePresence } from "framer-motion";
import Link from "next/link";
import {
  Brain,
  ArrowLeft,
  Sparkles,
  Tag,
  RotateCcw,
  CheckCircle2,
  AlertCircle,
} from "lucide-react";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { cn } from "@/lib/utils";

/* ─────────────────────────────────────────────
   Types
───────────────────────────────────────────── */
type MentalState = "depression" | "anxiety" | "stress";

interface AnalysisResult {
  state: MentalState;
  label: string;
  confidence: number;
  secondary?: { state: MentalState; label: string; confidence: number };
  keywords: string[];
  insight: string;
}

/* ─────────────────────────────────────────────
   Sample pre-filled texts
───────────────────────────────────────────── */
const SAMPLE_TEXTS = [
  "والله أنا تعبت من كل شيء، مو قادر أنام وكل يوم حاسس إن في ثقل على صدري وما عندي طاقة أطلع من البيت",
  "صارلي أسبوع ما نمت صح، أفكاري ما توقف وخايف من المستقبل وحاسس إن كل شيء ممكن يصير بشكل سيء",
  "مو قادر أكمل، كل شيء عليّ وما في أحد يفهمني، أحسس بالوحدة وما أقدر أفكر بأي شيء إيجابي",
];

/* ─────────────────────────────────────────────
   Mock analysis engine
───────────────────────────────────────────── */
function analyzeText(text: string): AnalysisResult {
  const t = text.toLowerCase();

  const depressionKws = ["تعبت", "ثقل", "وحدة", "يأس", "ما أقدر", "حزن", "بكاء", "فراغ", "إرهاق", "طاقة"];
  const anxietyKws = ["خايف", "قلق", "توتر", "أفكار", "مستقبل", "خوف", "أرق", "نمت", "ارتعاش", "ضيق"];
  const stressKws = ["ضغط", "متعب", "مشغول", "مو قادر", "عليّ", "أكمل", "ملول", "طفشان", "إرهاق", "مرهق"];

  const score = (keywords: string[]) =>
    keywords.filter((kw) => t.includes(kw)).length;

  const dScore = score(depressionKws);
  const aScore = score(anxietyKws);
  const sScore = score(stressKws);

  const total = Math.max(dScore + aScore + sScore, 1);
  const dConf = Math.min(0.55 + (dScore / total) * 0.38, 0.97);
  const aConf = Math.min(0.5 + (aScore / total) * 0.38, 0.95);
  const sConf = Math.min(0.48 + (sScore / total) * 0.36, 0.92);

  const scores: [MentalState, number][] = [
    ["depression", dConf],
    ["anxiety", aConf],
    ["stress", sConf],
  ];
  scores.sort((a, b) => b[1] - a[1]);

  const [primaryState, primaryConf] = scores[0];
  const [secondaryState, secondaryConf] = scores[1];

  const labelMap: Record<MentalState, string> = {
    depression: "اكتئاب",
    anxiety: "قلق",
    stress: "ضغوط نفسية",
  };

  const insightMap: Record<MentalState, string> = {
    depression: "النص يحتوي على مؤشرات واضحة للحالة المزاجية المنخفضة وفقدان الدافعية.",
    anxiety: "يتضمن النص مفردات تعكس حالة من التوتر والقلق من المجهول.",
    stress: "النص يُظهر أعراض التعب النفسي الناتج عن ضغوط متراكمة.",
  };

  const allKws = [...depressionKws, ...anxietyKws, ...stressKws];
  const found = allKws.filter((kw) => t.includes(kw)).slice(0, 6);
  const keywords = found.length > 0 ? found : ["لا توجد كلمات مفتاحية واضحة"];

  return {
    state: primaryState,
    label: labelMap[primaryState],
    confidence: primaryConf,
    secondary: {
      state: secondaryState,
      label: labelMap[secondaryState],
      confidence: secondaryConf,
    },
    keywords,
    insight: insightMap[primaryState],
  };
}

/* ─────────────────────────────────────────────
   Confidence bar
───────────────────────────────────────────── */
function ConfidenceBar({
  label,
  value,
  gradient,
  delay = 0,
}: {
  label: string;
  value: number;
  gradient: string;
  delay?: number;
}) {
  const pct = Math.round(value * 100);
  return (
    <div>
      <div className="flex justify-between text-xs text-muted-foreground mb-1.5">
        <span>{label}</span>
        <span className="font-semibold">{pct}٪</span>
      </div>
      <div className="h-2 w-full rounded-full bg-muted overflow-hidden">
        <motion.div
          initial={{ width: 0 }}
          animate={{ width: `${pct}%` }}
          transition={{ duration: 0.9, delay, ease: "easeOut" }}
          className={cn("h-full rounded-full bg-gradient-to-l", gradient)}
        />
      </div>
    </div>
  );
}

/* ─────────────────────────────────────────────
   Loading Animation
───────────────────────────────────────────── */
function LoadingState() {
  return (
    <motion.div
      key="loading"
      initial={{ opacity: 0 }}
      animate={{ opacity: 1 }}
      exit={{ opacity: 0 }}
      className="flex flex-col items-center justify-center gap-4 py-10"
    >
      <div className="relative">
        <div className="h-14 w-14 rounded-full border-2 border-violet-200 dark:border-violet-800 border-t-violet-500 animate-spin" />
        <div className="absolute inset-0 flex items-center justify-center">
          <Brain className="h-6 w-6 text-violet-500" />
        </div>
      </div>
      <div className="space-y-1 text-center">
        <p className="text-sm font-medium text-foreground">جارٍ تحليل النص...</p>
        <p className="text-xs text-muted-foreground">معالجة اللغة الطبيعية بالذكاء الاصطناعي</p>
      </div>
      <div className="flex gap-1.5">
        {[0, 1, 2].map((i) => (
          <div
            key={i}
            className="h-2 w-2 rounded-full bg-violet-400 animate-bounce"
            style={{ animationDelay: `${i * 0.15}s` }}
          />
        ))}
      </div>
    </motion.div>
  );
}

/* ─────────────────────────────────────────────
   Result Panel
───────────────────────────────────────────── */
function ResultPanel({ result }: { result: AnalysisResult }) {
  const badgeMap: Record<MentalState, React.ComponentProps<typeof Badge>["variant"]> = {
    depression: "depression",
    anxiety: "anxiety",
    stress: "stress",
  };

  const iconMap: Record<MentalState, string> = {
    depression: "🌧",
    anxiety: "⚡",
    stress: "🌿",
  };

  const gradientMap: Record<MentalState, string> = {
    depression: "from-depression to-navy-600",
    anxiety: "from-anxiety to-violet-600",
    stress: "from-stress to-navy-500",
  };

  return (
    <motion.div
      key="result"
      initial={{ opacity: 0, y: 16 }}
      animate={{ opacity: 1, y: 0 }}
      exit={{ opacity: 0, y: -16 }}
      transition={{ duration: 0.45, ease: [0.22, 1, 0.36, 1] }}
      className="space-y-4"
    >
      {/* Success indicator */}
      <div className="flex items-center gap-2 text-stress text-sm font-medium">
        <CheckCircle2 className="h-4 w-4 shrink-0" />
        <span>اكتمل التحليل بنجاح</span>
      </div>

      {/* Primary result card */}
      <div className="rounded-2xl border border-border bg-muted/40 p-4">
        <p className="text-xs text-muted-foreground mb-2">التصنيف الرئيسي</p>
        <div className="flex items-center justify-between">
          <div className="flex items-center gap-2">
            <span className="text-2xl">{iconMap[result.state]}</span>
            <span className="text-xl font-black text-foreground">{result.label}</span>
          </div>
          <Badge variant={badgeMap[result.state]} className="text-sm px-3 py-1">
            {Math.round(result.confidence * 100)}٪ ثقة
          </Badge>
        </div>
      </div>

      {/* Confidence bars */}
      <div className="space-y-2.5">
        <p className="text-xs font-semibold text-muted-foreground uppercase tracking-wider">
          درجات الثقة
        </p>
        <ConfidenceBar
          label={result.label}
          value={result.confidence}
          gradient={gradientMap[result.state]}
          delay={0.1}
        />
        {result.secondary && (
          <ConfidenceBar
            label={result.secondary.label}
            value={result.secondary.confidence}
            gradient={gradientMap[result.secondary.state]}
            delay={0.25}
          />
        )}
      </div>

      {/* Keywords */}
      <div>
        <div className="flex items-center gap-1.5 mb-2">
          <Tag className="h-3.5 w-3.5 text-muted-foreground" />
          <p className="text-xs font-semibold text-muted-foreground">الكلمات المفتاحية</p>
        </div>
        <div className="flex flex-wrap gap-1.5">
          {result.keywords.map((kw) => (
            <motion.span
              key={kw}
              initial={{ opacity: 0, scale: 0.8 }}
              animate={{ opacity: 1, scale: 1 }}
              transition={{ duration: 0.3 }}
              className="inline-flex items-center rounded-full bg-depression-light dark:bg-depression/10 text-depression-text dark:text-depression border border-depression-medium dark:border-depression/30 px-3 py-1 text-xs font-medium"
            >
              {kw}
            </motion.span>
          ))}
        </div>
      </div>

      {/* AI Insight */}
      <div className="rounded-xl border border-violet-200 dark:border-violet-700/30 bg-violet-50 dark:bg-violet-900/10 p-3">
        <div className="flex gap-2">
          <Sparkles className="h-4 w-4 text-violet-500 mt-0.5 shrink-0" />
          <p className="text-xs text-foreground/80 leading-relaxed">{result.insight}</p>
        </div>
      </div>
    </motion.div>
  );
}

/* ─────────────────────────────────────────────
   Empty State
───────────────────────────────────────────── */
function EmptyResultState() {
  return (
    <motion.div
      key="empty"
      initial={{ opacity: 0 }}
      animate={{ opacity: 1 }}
      exit={{ opacity: 0 }}
      className="flex flex-col items-center justify-center py-12 text-center"
    >
      <div className="h-16 w-16 rounded-full bg-muted flex items-center justify-center mb-4">
        <Brain className="h-8 w-8 text-muted-foreground" strokeWidth={1.25} />
      </div>
      <p className="text-sm font-medium text-foreground mb-1">النتيجة ستظهر هنا</p>
      <p className="text-xs text-muted-foreground max-w-[180px]">
        اضغط على &quot;تحليل النص&quot; لرؤية النتيجة
      </p>
    </motion.div>
  );
}

/* ─────────────────────────────────────────────
   Main Section
───────────────────────────────────────────── */
type AnalysisState = "idle" | "loading" | "done";

export function LivePreviewSection() {
  const [text, setText] = useState(SAMPLE_TEXTS[0]);
  const [analysisState, setAnalysisState] = useState<AnalysisState>("idle");
  const [result, setResult] = useState<AnalysisResult | null>(null);
  const [charCount, setCharCount] = useState(SAMPLE_TEXTS[0].length);

  const handleAnalyze = useCallback(async () => {
    if (!text.trim() || text.trim().length < 10) return;

    setAnalysisState("loading");
    setResult(null);

    await new Promise((r) => setTimeout(r, 2000));

    const res = analyzeText(text);
    setResult(res);
    setAnalysisState("done");
  }, [text]);

  const handleReset = useCallback(() => {
    setAnalysisState("idle");
    setResult(null);
    const currentIdx = SAMPLE_TEXTS.indexOf(text);
    const next = SAMPLE_TEXTS[(currentIdx + 1) % SAMPLE_TEXTS.length];
    setText(next);
    setCharCount(next.length);
  }, [text]);

  const handleTextChange = (e: React.ChangeEvent<HTMLTextAreaElement>) => {
    setText(e.target.value);
    setCharCount(e.target.value.length);
    if (analysisState === "done") {
      setAnalysisState("idle");
      setResult(null);
    }
  };

  const isLoading = analysisState === "loading";
  const canAnalyze = text.trim().length >= 10 && !isLoading;

  return (
    <section
      dir="rtl"
      className="relative py-20 lg:py-28 overflow-hidden"
      aria-labelledby="live-preview-heading"
    >
      {/* Background gradient */}
      <div className="absolute inset-0 bg-gradient-to-b from-background via-violet-50/30 to-background dark:from-background dark:via-violet-950/10 dark:to-background" />

      {/* Blobs */}
      <div
        className="pointer-events-none absolute top-1/4 right-0 h-80 w-80 rounded-full bg-violet-500/6 blur-3xl"
        aria-hidden
      />
      <div
        className="pointer-events-none absolute bottom-1/4 left-0 h-80 w-80 rounded-full bg-navy-600/6 blur-3xl"
        aria-hidden
      />

      <div className="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {/* Heading */}
        <motion.div
          initial={{ opacity: 0, y: 24 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true, amount: 0.2 }}
          transition={{ duration: 0.6 }}
          className="text-center mb-12"
        >
          <span className="inline-block rounded-full border border-violet-200 dark:border-violet-700/50 bg-violet-50 dark:bg-violet-900/20 px-4 py-1.5 text-sm font-semibold text-violet-700 dark:text-violet-300 mb-4">
            تجربة تفاعلية
          </span>
          <h2
            id="live-preview-heading"
            className="text-3xl sm:text-4xl lg:text-5xl font-black text-foreground mb-4"
          >
            جرّب التحليل{" "}
            <span className="gradient-text">الآن</span>
          </h2>
          <p className="text-lg text-muted-foreground max-w-xl mx-auto">
            أدخل نصاً باللهجة اليمنية وشاهد كيف يعمل نظام الذكاء الاصطناعي
          </p>
        </motion.div>

        {/* Demo panel */}
        <motion.div
          initial={{ opacity: 0, y: 32 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true, amount: 0.15 }}
          transition={{ duration: 0.7, ease: [0.22, 1, 0.36, 1] }}
          className="max-w-5xl mx-auto"
        >
          <div className="relative">
            <div className="absolute -inset-px rounded-3xl bg-gradient-to-br from-violet-500/20 via-transparent to-navy-600/20 blur-sm" />

            <div className="relative glass-card rounded-3xl overflow-hidden shadow-glass-xl">
              {/* Panel header */}
              <div className="flex items-center justify-between border-b border-border/60 px-6 py-4 bg-muted/30">
                <div className="flex items-center gap-3">
                  <div className="h-9 w-9 rounded-xl bg-gradient-to-br from-violet-500 to-navy-600 flex items-center justify-center shadow-glow">
                    <Brain className="h-4 w-4 text-white" />
                  </div>
                  <div>
                    <p className="text-sm font-bold text-foreground">محلل نبضات التجريبي</p>
                    <p className="text-xs text-muted-foreground">نموذج مصغر للعرض التوضيحي</p>
                  </div>
                </div>

                <div className="flex items-center gap-2">
                  <div className={cn(
                    "flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-medium border",
                    analysisState === "done"
                      ? "bg-stress-light dark:bg-stress/10 text-stress-text dark:text-stress border-stress-medium dark:border-stress/30"
                      : analysisState === "loading"
                      ? "bg-violet-50 dark:bg-violet-900/20 text-violet-700 dark:text-violet-300 border-violet-200 dark:border-violet-700/30"
                      : "bg-muted text-muted-foreground border-border"
                  )}>
                    <div className={cn(
                      "h-1.5 w-1.5 rounded-full",
                      analysisState === "done"
                        ? "bg-stress"
                        : analysisState === "loading"
                        ? "bg-violet-500 animate-pulse"
                        : "bg-muted-foreground/50"
                    )} />
                    {analysisState === "done" ? "مكتمل" : analysisState === "loading" ? "جارٍ التحليل" : "جاهز"}
                  </div>

                  <div className="hidden sm:flex items-center gap-1 text-xs text-muted-foreground/60">
                    <AlertCircle className="h-3 w-3" />
                    <span>تجريبي فقط</span>
                  </div>
                </div>
              </div>

              {/* Two-column content */}
              <div className="grid grid-cols-1 lg:grid-cols-2 divide-y lg:divide-y-0 lg:divide-x lg:divide-x-reverse divide-border/60">
                {/* Input column */}
                <div className="p-6 flex flex-col gap-5">
                  <div>
                    <label
                      htmlFor="analysis-input"
                      className="block text-sm font-semibold text-foreground mb-1"
                    >
                      أدخل النص هنا
                    </label>
                    <p className="text-xs text-muted-foreground mb-3">
                      اكتب بالعربية أو اللهجة اليمنية — لا يقل عن ١٠ أحرف
                    </p>

                    <div className="relative">
                      <textarea
                        id="analysis-input"
                        value={text}
                        onChange={handleTextChange}
                        disabled={isLoading}
                        rows={6}
                        className={cn(
                          "w-full resize-none rounded-2xl border border-border bg-muted/40 dark:bg-navy-900/40 px-4 py-3",
                          "text-sm text-foreground placeholder:text-muted-foreground/60 leading-relaxed",
                          "focus:outline-none focus:ring-2 focus:ring-violet-500/40 focus:border-violet-400",
                          "transition-all duration-200 disabled:opacity-60 disabled:cursor-not-allowed"
                        )}
                        placeholder="اكتب ما تشعر به هنا..."
                        dir="rtl"
                      />
                      <span className="absolute bottom-2 left-3 text-[10px] text-muted-foreground/50">
                        {charCount} حرف
                      </span>
                    </div>
                  </div>

                  {/* Sample text pills */}
                  <div>
                    <p className="text-xs text-muted-foreground mb-2">أمثلة جاهزة:</p>
                    <div className="flex flex-wrap gap-2">
                      {SAMPLE_TEXTS.map((sample, i) => (
                        <button
                          key={i}
                          onClick={() => {
                            setText(sample);
                            setCharCount(sample.length);
                            setAnalysisState("idle");
                            setResult(null);
                          }}
                          className={cn(
                            "rounded-full border px-3 py-1 text-xs font-medium transition-all duration-200",
                            text === sample
                              ? "bg-violet-500 text-white border-violet-500 shadow-glow"
                              : "border-border text-muted-foreground hover:border-violet-400 hover:text-violet-500 bg-transparent"
                          )}
                        >
                          مثال {i + 1}
                        </button>
                      ))}
                    </div>
                  </div>

                  {/* Action buttons */}
                  <div className="flex gap-3 mt-auto">
                    <Button
                      onClick={handleAnalyze}
                      disabled={!canAnalyze}
                      variant="primary"
                      size="lg"
                      className="flex-1"
                    >
                      {isLoading ? (
                        <span className="flex items-center gap-2">
                          <div className="h-4 w-4 border-2 border-white/30 border-t-white rounded-full animate-spin" />
                          جارٍ التحليل...
                        </span>
                      ) : (
                        <span className="flex items-center gap-2">
                          <Brain className="h-4 w-4" />
                          تحليل النص
                        </span>
                      )}
                    </Button>

                    {analysisState !== "idle" && (
                      <Button
                        onClick={handleReset}
                        variant="outline"
                        size="lg"
                        disabled={isLoading}
                        className="shrink-0"
                      >
                        <RotateCcw className="h-4 w-4" />
                      </Button>
                    )}
                  </div>
                </div>

                {/* Result column */}
                <div className="p-6 min-h-[320px] flex flex-col">
                  <p className="text-sm font-semibold text-foreground mb-4 flex items-center gap-2">
                    <Sparkles className="h-4 w-4 text-violet-500" />
                    نتيجة التحليل
                  </p>

                  <div className="flex-1">
                    <AnimatePresence mode="wait">
                      {isLoading ? (
                        <LoadingState />
                      ) : result ? (
                        <ResultPanel result={result} />
                      ) : (
                        <EmptyResultState />
                      )}
                    </AnimatePresence>
                  </div>
                </div>
              </div>

              {/* Panel footer */}
              <div className="flex flex-col sm:flex-row items-center justify-between gap-3 border-t border-border/60 px-6 py-4 bg-muted/20">
                <p className="text-xs text-muted-foreground text-center sm:text-right">
                  هذا نموذج تجريبي مبسط — للتحليل الكامل استخدم الصفحة الرسمية
                </p>
                <Button asChild variant="secondary" size="sm" className="group shrink-0">
                  <Link href="/analysis">
                    التحليل الكامل
                    <ArrowLeft className="h-3.5 w-3.5 transition-transform group-hover:-translate-x-0.5" />
                  </Link>
                </Button>
              </div>
            </div>
          </div>

          {/* Bottom CTA */}
          <motion.div
            initial={{ opacity: 0 }}
            whileInView={{ opacity: 1 }}
            viewport={{ once: true }}
            transition={{ delay: 0.4 }}
            className="text-center mt-8"
          >
            <p className="text-sm text-muted-foreground">
              مجاني تماماً — لا يتطلب تسجيل — لا تُحفظ بياناتك
            </p>
          </motion.div>
        </motion.div>
      </div>
    </section>
  );
}
