"use client";

import { motion, AnimatePresence } from "framer-motion";
import { cn } from "@/lib/utils";

// ─── Step definitions ─────────────────────────────────────────────────────────

const STEPS = [
  { id: 0, label: "قراءة النص", icon: "📖", color: "from-navy-500 to-navy-600" },
  { id: 1, label: "تحليل المشاعر", icon: "💙", color: "from-depression to-depression-dark" },
  { id: 2, label: "تحديد التصنيف", icon: "🎯", color: "from-anxiety to-anxiety-dark" },
  { id: 3, label: "إعداد التقرير", icon: "📊", color: "from-stress to-stress-dark" },
] as const;

// ─── Neural node SVG paths ─────────────────────────────────────────────────────

const NEURAL_CONNECTIONS = [
  { x1: "50%", y1: "20%", x2: "30%", y2: "50%", delay: 0 },
  { x1: "50%", y1: "20%", x2: "70%", y2: "50%", delay: 0.2 },
  { x1: "30%", y1: "50%", x2: "50%", y2: "80%", delay: 0.4 },
  { x1: "70%", y1: "50%", x2: "50%", y2: "80%", delay: 0.6 },
  { x1: "30%", y1: "50%", x2: "70%", y2: "50%", delay: 0.8 },
];

const NEURAL_NODES = [
  { cx: "50%", cy: "20%", r: 8, delay: 0 },
  { cx: "30%", cy: "50%", r: 6, delay: 0.15 },
  { cx: "70%", cy: "50%", r: 6, delay: 0.3 },
  { cx: "50%", cy: "80%", r: 8, delay: 0.45 },
  { cx: "20%", cy: "30%", r: 4, delay: 0.6 },
  { cx: "80%", cy: "30%", r: 4, delay: 0.75 },
  { cx: "20%", cy: "70%", r: 4, delay: 0.9 },
  { cx: "80%", cy: "70%", r: 4, delay: 1.05 },
];

// ─── Props ────────────────────────────────────────────────────────────────────

interface LoadingAnimationProps {
  step: number;
}

// ─── Floating dot ─────────────────────────────────────────────────────────────

function FloatingDot({ delay, size, x, y }: { delay: number; size: number; x: string; y: string }) {
  return (
    <motion.div
      className="absolute rounded-full bg-violet-400/30 dark:bg-violet-500/20"
      style={{ width: size, height: size, left: x, top: y }}
      animate={{
        y: [0, -20, 0],
        opacity: [0.3, 0.8, 0.3],
        scale: [1, 1.4, 1],
      }}
      transition={{
        duration: 2.5 + delay,
        repeat: Infinity,
        ease: "easeInOut",
        delay,
      }}
    />
  );
}

// ─── Component ────────────────────────────────────────────────────────────────

export function LoadingAnimation({ step }: LoadingAnimationProps) {
  const progressPercent = Math.round(((step + 1) / STEPS.length) * 100);

  return (
    <motion.div
      initial={{ opacity: 0, scale: 0.95 }}
      animate={{ opacity: 1, scale: 1 }}
      exit={{ opacity: 0, scale: 0.95 }}
      transition={{ duration: 0.4, ease: "easeOut" }}
      className="w-full"
    >
      <div
        className={cn(
          "relative overflow-hidden rounded-3xl",
          "bg-gradient-to-br from-navy-800 via-navy-900 to-navy-950",
          "dark:from-navy-950 dark:via-navy-900 dark:to-navy-950",
          "border border-navy-700/50",
          "shadow-navy-lg",
          "px-6 py-10 sm:px-10 sm:py-14"
        )}
      >
        {/* ── Background gradient blobs ── */}
        <div className="pointer-events-none absolute inset-0 overflow-hidden">
          <div className="absolute -top-16 -right-16 h-64 w-64 rounded-full bg-violet-600/10 blur-3xl animate-blob" />
          <div className="absolute -bottom-16 -left-16 h-64 w-64 rounded-full bg-depression/10 blur-3xl animate-blob [animation-delay:3s]" />
          <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 h-48 w-48 rounded-full bg-navy-500/10 blur-2xl animate-pulse" />
        </div>

        {/* ── Floating dots ── */}
        <div className="pointer-events-none absolute inset-0">
          <FloatingDot delay={0} size={6} x="10%" y="20%" />
          <FloatingDot delay={0.4} size={4} x="85%" y="15%" />
          <FloatingDot delay={0.8} size={8} x="90%" y="70%" />
          <FloatingDot delay={1.2} size={5} x="5%" y="75%" />
          <FloatingDot delay={0.6} size={4} x="45%" y="90%" />
          <FloatingDot delay={1.0} size={6} x="60%" y="8%" />
        </div>

        {/* ── Neural Network SVG ── */}
        <div className="relative mx-auto mb-8 flex h-40 w-40 items-center justify-center">
          {/* Outer rotating ring */}
          <motion.div
            className="absolute inset-0 rounded-full border-2 border-violet-500/30"
            animate={{ rotate: 360 }}
            transition={{ duration: 8, repeat: Infinity, ease: "linear" }}
          />
          {/* Inner rotating ring (opposite) */}
          <motion.div
            className="absolute inset-3 rounded-full border border-navy-400/20"
            animate={{ rotate: -360 }}
            transition={{ duration: 6, repeat: Infinity, ease: "linear" }}
          />

          {/* SVG neural network */}
          <svg
            viewBox="0 0 100 100"
            className="absolute inset-0 h-full w-full"
            aria-hidden="true"
          >
            {/* Connection lines */}
            {NEURAL_CONNECTIONS.map((conn, i) => (
              <motion.line
                key={i}
                x1={conn.x1}
                y1={conn.y1}
                x2={conn.x2}
                y2={conn.y2}
                stroke="rgba(108,99,255,0.4)"
                strokeWidth="0.8"
                initial={{ pathLength: 0, opacity: 0 }}
                animate={{ pathLength: 1, opacity: [0.2, 0.6, 0.2] }}
                transition={{
                  pathLength: { duration: 1.5, delay: conn.delay },
                  opacity: { duration: 2, repeat: Infinity, delay: conn.delay },
                }}
              />
            ))}

            {/* Nodes */}
            {NEURAL_NODES.map((node, i) => (
              <motion.circle
                key={i}
                cx={node.cx}
                cy={node.cy}
                r={node.r}
                fill="rgba(108,99,255,0.6)"
                initial={{ scale: 0, opacity: 0 }}
                animate={{
                  scale: [0.8, 1.2, 0.8],
                  opacity: [0.5, 1, 0.5],
                  fill: [
                    "rgba(108,99,255,0.6)",
                    "rgba(74,144,217,0.8)",
                    "rgba(108,99,255,0.6)",
                  ],
                }}
                transition={{
                  duration: 2,
                  repeat: Infinity,
                  delay: node.delay,
                  ease: "easeInOut",
                }}
              />
            ))}
          </svg>

          {/* Center brain pulse */}
          <motion.div
            className="relative z-10 flex h-14 w-14 items-center justify-center rounded-full bg-gradient-to-br from-violet-500 to-navy-600 shadow-glow"
            animate={{
              boxShadow: [
                "0 0 20px rgba(108,99,255,0.3)",
                "0 0 40px rgba(108,99,255,0.6)",
                "0 0 20px rgba(108,99,255,0.3)",
              ],
            }}
            transition={{ duration: 2, repeat: Infinity, ease: "easeInOut" }}
          >
            {/* Animated brain icon using text emoji for RTL safety */}
            <motion.span
              className="text-2xl"
              animate={{ scale: [1, 1.1, 1] }}
              transition={{ duration: 2, repeat: Infinity }}
            >
              🧠
            </motion.span>
          </motion.div>
        </div>

        {/* ── Main heading with typing dots ── */}
        <div className="relative z-10 mb-8 text-center">
          <h3 className="mb-2 text-xl font-bold text-white">
            جارٍ تحليل النص
          </h3>
          <div className="flex items-center justify-center gap-1.5">
            <span className="text-sm text-navy-300">معالجة بالذكاء الاصطناعي</span>
            {[0, 1, 2].map((i) => (
              <motion.span
                key={i}
                className="inline-block h-1.5 w-1.5 rounded-full bg-violet-400"
                animate={{ opacity: [0, 1, 0], y: [0, -4, 0] }}
                transition={{
                  duration: 1.2,
                  repeat: Infinity,
                  delay: i * 0.2,
                }}
              />
            ))}
          </div>
        </div>

        {/* ── Progress bar ── */}
        <div className="relative z-10 mb-8">
          <div className="mb-2 flex items-center justify-between text-xs">
            <span className="font-semibold text-navy-300">التقدم</span>
            <motion.span
              key={progressPercent}
              initial={{ opacity: 0, y: -4 }}
              animate={{ opacity: 1, y: 0 }}
              className="font-bold text-violet-400"
            >
              {progressPercent}%
            </motion.span>
          </div>
          <div className="h-2 w-full overflow-hidden rounded-full bg-navy-700">
            <motion.div
              className="h-full rounded-full bg-gradient-to-l from-violet-400 to-navy-400"
              initial={{ width: "10%" }}
              animate={{ width: `${progressPercent}%` }}
              transition={{ duration: 0.6, ease: "easeOut" }}
            />
          </div>
        </div>

        {/* ── Steps list ── */}
        <div className="relative z-10 space-y-3">
          {STEPS.map((s) => {
            const isActive = s.id === step;
            const isDone = s.id < step;
            const isPending = s.id > step;

            return (
              <motion.div
                key={s.id}
                initial={{ opacity: 0, x: 16 }}
                animate={{ opacity: isPending ? 0.4 : 1, x: 0 }}
                transition={{ duration: 0.4, delay: s.id * 0.08 }}
                className={cn(
                  "flex items-center gap-4 rounded-2xl px-4 py-3 transition-all duration-300",
                  isActive && "bg-white/10 ring-1 ring-violet-500/30",
                  isDone && "bg-white/5",
                  isPending && "bg-transparent"
                )}
              >
                {/* Step icon / check */}
                <div
                  className={cn(
                    "flex h-9 w-9 shrink-0 items-center justify-center rounded-xl text-lg transition-all duration-300",
                    isActive && "bg-gradient-to-br from-violet-500 to-navy-600 shadow-glow animate-pulse-glow",
                    isDone && "bg-stress/30",
                    isPending && "bg-navy-700"
                  )}
                >
                  {isDone ? (
                    <motion.span
                      initial={{ scale: 0 }}
                      animate={{ scale: 1 }}
                      transition={{ type: "spring", stiffness: 400 }}
                    >
                      ✓
                    </motion.span>
                  ) : (
                    <span>{s.icon}</span>
                  )}
                </div>

                {/* Step label */}
                <div className="flex-1 min-w-0">
                  <span
                    className={cn(
                      "text-sm font-semibold transition-colors duration-200",
                      isActive ? "text-white" : isDone ? "text-stress-medium" : "text-navy-500"
                    )}
                  >
                    {s.label}
                  </span>

                  {/* Active step — animated processing text */}
                  <AnimatePresence>
                    {isActive && (
                      <motion.p
                        key="processing"
                        initial={{ opacity: 0, height: 0 }}
                        animate={{ opacity: 1, height: "auto" }}
                        exit={{ opacity: 0, height: 0 }}
                        className="mt-0.5 text-xs text-navy-400"
                      >
                        جارٍ المعالجة...
                      </motion.p>
                    )}
                  </AnimatePresence>
                </div>

                {/* Active spinner */}
                {isActive && (
                  <svg
                    className="h-4 w-4 shrink-0 animate-spin text-violet-400"
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
                )}
              </motion.div>
            );
          })}
        </div>
      </div>
    </motion.div>
  );
}
