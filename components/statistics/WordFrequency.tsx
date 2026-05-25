"use client";

import { useRef } from "react";
import { motion, useInView } from "framer-motion";
import type { KeywordFrequency } from "@/lib/mock-data";

// ─── Category Config ──────────────────────────────────────────────────────────

const CATEGORY_CONFIG = {
  depression: {
    label: "اكتئاب",
    color: "#4A90D9",
    barBg: "from-[#4A90D9] to-[#1E6BAF]",
    badgeBg: "bg-depression-light dark:bg-depression/20 text-depression-text dark:text-depression",
    cloudColor: "#4A90D9",
  },
  anxiety: {
    label: "قلق",
    color: "#E8924A",
    barBg: "from-[#E8924A] to-[#BF6520]",
    badgeBg: "bg-anxiety-light dark:bg-anxiety/20 text-anxiety-text dark:text-anxiety",
    cloudColor: "#E8924A",
  },
  stress: {
    label: "ضغوط",
    color: "#52B788",
    barBg: "from-[#52B788] to-[#2A8A5E]",
    badgeBg: "bg-stress-light dark:bg-stress/20 text-stress-text dark:text-stress",
    cloudColor: "#52B788",
  },
};

// ─── Word Cloud Display ───────────────────────────────────────────────────────

function WordCloud({ keywords }: { keywords: KeywordFrequency[] }) {
  const maxCount = Math.max(...keywords.map((k) => k.count));

  return (
    <div className="flex flex-wrap gap-2 items-center justify-center py-4 px-2 min-h-[100px]">
      {keywords.map((kw, i) => {
        const scale = 0.75 + (kw.count / maxCount) * 1.0;
        const cfg = CATEGORY_CONFIG[kw.category];
        return (
          <motion.span
            key={kw.word}
            initial={{ opacity: 0, scale: 0.5 }}
            whileInView={{ opacity: 1, scale: 1 }}
            viewport={{ once: true }}
            transition={{ duration: 0.4, delay: i * 0.05, ease: "easeOut" }}
            whileHover={{ scale: 1.15, y: -2 }}
            className="inline-flex items-center cursor-default select-none rounded-full px-3 py-1 font-bold transition-shadow"
            style={{
              fontSize: `${Math.round(scale * 14)}px`,
              color: cfg.cloudColor,
              backgroundColor: `${cfg.cloudColor}18`,
              border: `1.5px solid ${cfg.cloudColor}40`,
            }}
          >
            {kw.word}
          </motion.span>
        );
      })}
    </div>
  );
}

// ─── Keyword Row ──────────────────────────────────────────────────────────────

function KeywordRow({
  keyword,
  maxCount,
  index,
}: {
  keyword: KeywordFrequency;
  maxCount: number;
  index: number;
}) {
  const cfg = CATEGORY_CONFIG[keyword.category];
  const pct = (keyword.count / maxCount) * 100;

  return (
    <motion.div
      initial={{ opacity: 0, x: 30 }}
      whileInView={{ opacity: 1, x: 0 }}
      viewport={{ once: true }}
      transition={{ duration: 0.5, delay: index * 0.07, ease: [0.22, 1, 0.36, 1] }}
      className="group flex items-center gap-4 py-3 px-4 rounded-xl hover:bg-navy-50/80 dark:hover:bg-navy-900/40 transition-colors"
    >
      {/* Rank */}
      <span className="text-xs font-bold text-navy-300 dark:text-navy-600 w-6 text-center flex-shrink-0">
        {index + 1}
      </span>

      {/* Word */}
      <span
        className="text-base font-extrabold w-16 flex-shrink-0 text-right"
        style={{ color: cfg.color }}
      >
        {keyword.word}
      </span>

      {/* Progress bar */}
      <div className="flex-1 h-6 bg-navy-100/80 dark:bg-navy-900/60 rounded-lg overflow-hidden">
        <motion.div
          initial={{ width: 0 }}
          whileInView={{ width: `${pct}%` }}
          viewport={{ once: true }}
          transition={{ duration: 0.7, delay: 0.1 + index * 0.05, ease: "easeOut" }}
          className={`h-full rounded-lg bg-gradient-to-l ${cfg.barBg} flex items-center justify-end px-2`}
        >
          {pct > 20 && (
            <span className="text-xs font-bold text-white/90">
              {keyword.count.toLocaleString("ar-EG")}
            </span>
          )}
        </motion.div>
      </div>

      {/* Count (outside bar for narrow bars) */}
      {pct <= 20 && (
        <span className="text-xs font-bold text-navy-600 dark:text-navy-300 w-10 text-left flex-shrink-0">
          {keyword.count.toLocaleString("ar-EG")}
        </span>
      )}

      {/* Category badge */}
      <span
        className={`text-xs font-semibold px-2.5 py-0.5 rounded-full flex-shrink-0 ${cfg.badgeBg}`}
      >
        {cfg.label}
      </span>

      {/* Percentage */}
      <span className="text-xs text-navy-400 dark:text-navy-500 w-10 text-left flex-shrink-0">
        {keyword.percentage}%
      </span>
    </motion.div>
  );
}

// ─── Main Component ───────────────────────────────────────────────────────────

export function WordFrequency({ keywords }: { keywords: KeywordFrequency[] }) {
  const ref = useRef<HTMLDivElement>(null);
  const inView = useInView(ref, { once: true, margin: "-60px" });

  const sorted = [...keywords].sort((a, b) => b.count - a.count);
  const maxCount = sorted[0]?.count ?? 1;

  return (
    <div
      ref={ref}
      className="bg-white/70 dark:bg-navy-800/60 backdrop-blur-sm border border-white/60 dark:border-navy-700/60 rounded-2xl shadow-glass overflow-hidden"
    >
      {/* Header */}
      <div className="px-6 pt-6 pb-4 border-b border-navy-100/60 dark:border-navy-700/40">
        <motion.div
          initial={{ opacity: 0, y: -10 }}
          animate={inView ? { opacity: 1, y: 0 } : {}}
          transition={{ duration: 0.5 }}
        >
          <h3 className="text-base font-bold text-navy-800 dark:text-white">
            الكلمات الأكثر تكراراً
          </h3>
          <p className="text-xs text-navy-400 dark:text-navy-400 mt-0.5">
            أبرز 12 كلمة مصنّفة حسب الحالة النفسية
          </p>
        </motion.div>

        {/* Legend */}
        <div className="flex gap-4 mt-3">
          {Object.entries(CATEGORY_CONFIG).map(([key, cfg]) => (
            <div key={key} className="flex items-center gap-1.5">
              <span
                className="w-2.5 h-2.5 rounded-full"
                style={{ backgroundColor: cfg.color }}
              />
              <span className="text-xs text-navy-500 dark:text-navy-400">{cfg.label}</span>
            </div>
          ))}
        </div>
      </div>

      {/* Word Cloud */}
      <div className="px-6 pt-4 pb-2 border-b border-navy-100/40 dark:border-navy-700/30 bg-navy-50/30 dark:bg-navy-900/20">
        <WordCloud keywords={sorted} />
      </div>

      {/* Keyword List */}
      <div className="p-4">
        {/* Column headers */}
        <div className="flex items-center gap-4 px-4 mb-1">
          <span className="w-6" />
          <span className="text-xs text-navy-400 w-16 text-right">الكلمة</span>
          <span className="flex-1 text-xs text-navy-400 text-center">التكرار</span>
          <span className="text-xs text-navy-400 text-left">الفئة</span>
          <span className="text-xs text-navy-400 w-10 text-left">النسبة</span>
        </div>

        <div className="space-y-0.5">
          {sorted.map((kw, i) => (
            <KeywordRow key={kw.word} keyword={kw} maxCount={maxCount} index={i} />
          ))}
        </div>
      </div>
    </div>
  );
}
