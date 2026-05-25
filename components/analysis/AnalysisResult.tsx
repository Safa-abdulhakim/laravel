"use client";

import { RotateCcw, Shield, TrendingUp, AlertCircle, CheckCircle, Brain } from "lucide-react";
import type { AnalysisData } from "./TextAnalyzer";

const labelConfig = {
  depression: {
    emoji: "💜",
    color: "#6C63FF",
    bg: "rgba(108, 99, 255, 0.1)",
    border: "rgba(108, 99, 255, 0.25)",
    gradient: "linear-gradient(135deg, #6C63FF, #8b85ff)",
  },
  anxiety: {
    emoji: "🩵",
    color: "#4ECDC4",
    bg: "rgba(78, 205, 196, 0.1)",
    border: "rgba(78, 205, 196, 0.25)",
    gradient: "linear-gradient(135deg, #4ECDC4, #7eddd8)",
  },
  stress: {
    emoji: "🟡",
    color: "#f59e0b",
    bg: "rgba(245, 158, 11, 0.1)",
    border: "rgba(245, 158, 11, 0.25)",
    gradient: "linear-gradient(135deg, #f59e0b, #fbbf24)",
  },
};

const scoreLabels: Record<string, string> = {
  depression: "الاكتئاب",
  anxiety: "القلق",
  stress: "الضغوط النفسية",
};
const scoreColors: Record<string, string> = {
  depression: "#6C63FF",
  anxiety: "#4ECDC4",
  stress: "#f59e0b",
};

function highlightText(text: string, words: string[]) {
  let result = text;
  words.forEach((word) => {
    result = result.replace(
      new RegExp(word, "g"),
      `<mark style="background:rgba(108,99,255,0.2);color:#6C63FF;border-radius:4px;padding:0 3px;font-weight:700;">${word}</mark>`
    );
  });
  return result;
}

interface Props {
  result: AnalysisData;
  originalText: string;
  onReset: () => void;
}

export default function AnalysisResult({ result, originalText, onReset }: Props) {
  const config = labelConfig[result.label];

  return (
    <div className="space-y-6 animate-fade-in">
      {/* ── البطاقة الرئيسية ── */}
      <div
        className="rounded-3xl p-8 text-center relative overflow-hidden"
        style={{ background: config.gradient, boxShadow: `0 20px 60px ${config.color}30` }}
      >
        <div className="absolute inset-0 opacity-10"
          style={{
            backgroundImage: "radial-gradient(circle at 20% 50%, white 1px, transparent 1px)",
            backgroundSize: "30px 30px",
          }}
        />
        <div className="relative">
          <div className="text-5xl mb-4">{config.emoji}</div>
          <div className="text-white/80 text-sm font-medium mb-2 uppercase tracking-wider">
            التصنيف المكتشف
          </div>
          <div className="text-4xl font-black text-white mb-4">{result.label_ar}</div>
          <div
            className="inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-white font-bold text-lg"
            style={{ background: "rgba(255,255,255,0.2)", backdropFilter: "blur(10px)" }}
          >
            <Shield className="w-5 h-5" />
            نسبة الثقة: {result.confidence}%
          </div>
        </div>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {/* ── نسب التصنيفات ── */}
        <div
          className="rounded-2xl p-6"
          style={{ background: "var(--card)", border: "1px solid var(--border)", boxShadow: "var(--shadow-sm)" }}
        >
          <div className="flex items-center gap-3 mb-5">
            <TrendingUp className="w-5 h-5" style={{ color: config.color }} />
            <h3 className="font-bold" style={{ color: "var(--text)" }}>نسب التصنيفات</h3>
          </div>
          <div className="space-y-4">
            {Object.entries(result.scores).map(([key, score]) => (
              <div key={key}>
                <div className="flex justify-between items-center mb-2">
                  <span className="text-sm font-semibold" style={{ color: "var(--text)" }}>
                    {scoreLabels[key]}
                  </span>
                  <span className="text-sm font-bold" style={{ color: scoreColors[key] }}>
                    {score}%
                  </span>
                </div>
                <div className="w-full h-3 rounded-full overflow-hidden" style={{ background: "var(--background)" }}>
                  <div
                    className="h-full rounded-full transition-all duration-1000"
                    style={{
                      width: `${score}%`,
                      background: scoreColors[key],
                      boxShadow: `0 0 8px ${scoreColors[key]}60`,
                    }}
                  />
                </div>
              </div>
            ))}
          </div>
        </div>

        {/* ── الأعراض المكتشفة ── */}
        <div
          className="rounded-2xl p-6"
          style={{ background: "var(--card)", border: "1px solid var(--border)", boxShadow: "var(--shadow-sm)" }}
        >
          <div className="flex items-center gap-3 mb-5">
            <AlertCircle className="w-5 h-5" style={{ color: config.color }} />
            <h3 className="font-bold" style={{ color: "var(--text)" }}>الأعراض المكتشفة</h3>
          </div>
          <div className="flex flex-wrap gap-2">
            {result.symptoms.map((symptom) => (
              <span
                key={symptom}
                className="text-sm px-3 py-1.5 rounded-full font-medium"
                style={{ background: config.bg, color: config.color, border: `1px solid ${config.border}` }}
              >
                {symptom}
              </span>
            ))}
          </div>
        </div>
      </div>

      {/* ── النص المحلَّل ── */}
      <div
        className="rounded-2xl p-6"
        style={{ background: "var(--card)", border: "1px solid var(--border)", boxShadow: "var(--shadow-sm)" }}
      >
        <div className="flex items-center gap-3 mb-4">
          <Brain className="w-5 h-5" style={{ color: config.color }} />
          <h3 className="font-bold" style={{ color: "var(--text)" }}>
            النص المحلَّل — الكلمات المؤثرة
          </h3>
        </div>
        <div
          className="p-4 rounded-xl text-base leading-loose"
          style={{ background: "var(--background)", color: "var(--text)", direction: "rtl", fontFamily: "'Cairo', sans-serif" }}
          dangerouslySetInnerHTML={{ __html: highlightText(originalText, result.highlighted_words) }}
        />
        <div className="mt-3 flex items-center gap-2">
          <div className="w-4 h-4 rounded" style={{ background: "rgba(108,99,255,0.2)" }} />
          <span className="text-xs" style={{ color: "var(--text-muted)" }}>
            الكلمات المضيئة تمثل المؤشرات النفسية الرئيسية
          </span>
        </div>
      </div>

      {/* ── التوصية ── */}
      <div
        className="rounded-2xl p-6"
        style={{ background: "rgba(78,205,196,0.08)", border: "1px solid rgba(78,205,196,0.2)" }}
      >
        <div className="flex items-start gap-3">
          <CheckCircle className="w-5 h-5 mt-0.5 flex-shrink-0" style={{ color: "#4ECDC4" }} />
          <div>
            <h3 className="font-bold mb-2" style={{ color: "var(--text)" }}>توصية النظام</h3>
            <p className="text-sm leading-relaxed" style={{ color: "var(--text-muted)" }}>
              {result.recommendation}
            </p>
            <p className="text-xs mt-3 italic" style={{ color: "var(--text-muted)" }}>
              ⚠️ هذا التحليل للأغراض الأكاديمية فقط ولا يُغني عن الاستشارة المتخصصة
            </p>
          </div>
        </div>
      </div>

      {/* ── زر إعادة التحليل ── */}
      <button
        onClick={onReset}
        className="w-full py-4 rounded-2xl font-bold flex items-center justify-center gap-3 transition-all duration-300 hover:scale-[1.01]"
        style={{ background: "var(--card)", color: "var(--text)", border: "2px solid var(--border)", boxShadow: "var(--shadow-sm)" }}
      >
        <RotateCcw className="w-5 h-5" />
        تحليل نص جديد
      </button>
    </div>
  );
}
