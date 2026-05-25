"use client";

import { useState } from "react";
import { Brain, Send, RotateCcw, Sparkles, AlertCircle } from "lucide-react";
import AnalysisResult from "./AnalysisResult";
import LoadingAnimation from "./LoadingAnimation";

export type AnalysisData = {
  label: "depression" | "anxiety" | "stress";
  labelAr: string;
  confidence: number;
  scores: { label: string; labelAr: string; score: number; color: string }[];
  symptoms: string[];
  highlightedWords: string[];
  recommendation: string;
};

const MOCK_RESULTS: Record<string, AnalysisData> = {
  default: {
    label: "depression",
    labelAr: "الاكتئاب",
    confidence: 87.4,
    scores: [
      { label: "depression", labelAr: "الاكتئاب", score: 87, color: "#6C63FF" },
      { label: "anxiety", labelAr: "القلق", score: 9, color: "#4ECDC4" },
      { label: "stress", labelAr: "الضغوط النفسية", score: 4, color: "#f59e0b" },
    ],
    symptoms: ["فقدان الاهتمام", "الإرهاق المزمن", "اضطراب النوم", "الشعور بالفراغ", "العزلة الاجتماعية"],
    highlightedWords: ["تعبت", "زهقت", "ما أقدر", "ما في فايدة", "حزين"],
    recommendation: "تشير النتائج إلى وجود مؤشرات للاكتئاب. يُنصح بالتحدث مع متخصص في الصحة النفسية للحصول على تقييم أكثر دقة.",
  },
  anxiety: {
    label: "anxiety",
    labelAr: "القلق",
    confidence: 82.1,
    scores: [
      { label: "depression", labelAr: "الاكتئاب", score: 12, color: "#6C63FF" },
      { label: "anxiety", labelAr: "القلق", score: 82, color: "#4ECDC4" },
      { label: "stress", labelAr: "الضغوط النفسية", score: 6, color: "#f59e0b" },
    ],
    symptoms: ["التوتر المستمر", "الخوف المفرط", "صعوبة التركيز", "الأرق", "التفكير الزائد"],
    highlightedWords: ["خايف", "قلقان", "توتر", "ما أقدر أنام", "كل شي يخوفني"],
    recommendation: "تشير النتائج إلى مستوى مرتفع من القلق. تقنيات الاسترخاء والتنفس قد تساعد، ويُنصح بزيارة متخصص.",
  },
  stress: {
    label: "stress",
    labelAr: "الضغوط النفسية",
    confidence: 79.3,
    scores: [
      { label: "depression", labelAr: "الاكتئاب", score: 15, color: "#6C63FF" },
      { label: "anxiety", labelAr: "القلق", score: 6, color: "#4ECDC4" },
      { label: "stress", labelAr: "الضغوط النفسية", score: 79, color: "#f59e0b" },
    ],
    symptoms: ["الإجهاد اليومي", "ضغط العمل أو الدراسة", "التعب الجسدي", "قلة الوقت", "المشكلات اليومية"],
    highlightedWords: ["مشغول", "تعبان", "ضغط", "كثير مشاكل", "ما في وقت"],
    recommendation: "الحالة تعكس ضغوطاً يومية طبيعية. يُنصح بإدارة الوقت وممارسة الرياضة والراحة الكافية.",
  },
};

export default function TextAnalyzer() {
  const [text, setText] = useState("");
  const [loading, setLoading] = useState(false);
  const [result, setResult] = useState<AnalysisData | null>(null);
  const [error, setError] = useState("");

  const analyze = async () => {
    if (text.trim().length < 10) {
      setError("يرجى كتابة نص أطول (10 أحرف على الأقل)");
      return;
    }
    setError("");
    setLoading(true);
    setResult(null);

    await new Promise((r) => setTimeout(r, 2200));

    // Simulate result based on text content
    const lower = text.toLowerCase();
    let res = MOCK_RESULTS.default;
    if (lower.includes("خايف") || lower.includes("قلق") || lower.includes("خوف")) {
      res = MOCK_RESULTS.anxiety;
    } else if (lower.includes("ضغط") || lower.includes("مشغول") || lower.includes("شغل")) {
      res = MOCK_RESULTS.stress;
    }

    setLoading(false);
    setResult(res);
  };

  const reset = () => {
    setText("");
    setResult(null);
    setError("");
  };

  return (
    <div className="max-w-4xl mx-auto">
      {!result ? (
        <div
          className="rounded-3xl p-8 sm:p-10"
          style={{
            background: "var(--card)",
            boxShadow: "var(--shadow-lg)",
            border: "1px solid var(--border)",
          }}
        >
          {/* Header */}
          <div className="flex items-center gap-4 mb-8">
            <div className="w-12 h-12 rounded-2xl gradient-bg flex items-center justify-center shadow-lg">
              <Brain className="w-6 h-6 text-white" />
            </div>
            <div>
              <h2 className="text-xl font-black" style={{ color: "var(--text)" }}>
                محلّل النصوص النفسية
              </h2>
              <p className="text-sm" style={{ color: "var(--text-muted)" }}>
                اكتب ما تشعر به بحرية — النظام يفهم اللهجة اليمنية
              </p>
            </div>
          </div>

          {/* Textarea */}
          <div className="relative mb-6">
            <textarea
              value={text}
              onChange={(e) => { setText(e.target.value); setError(""); }}
              placeholder="اكتب ما تشعر به هنا... مثلاً: تعبت من كل شي، ما عاد أقدر أكمّل..."
              rows={8}
              className="w-full resize-none rounded-2xl p-5 text-base leading-relaxed outline-none transition-all duration-300"
              style={{
                background: "var(--background)",
                color: "var(--text)",
                border: `2px solid ${error ? "#ef4444" : "var(--border)"}`,
                fontFamily: "'Cairo', sans-serif",
                direction: "rtl",
              }}
              onFocus={(e) => {
                e.target.style.borderColor = "#6C63FF";
                e.target.style.boxShadow = "0 0 0 4px rgba(108,99,255,0.1)";
              }}
              onBlur={(e) => {
                e.target.style.borderColor = error ? "#ef4444" : "var(--border)";
                e.target.style.boxShadow = "none";
              }}
            />

            {/* Char counter */}
            <div
              className="absolute bottom-3 left-3 text-xs"
              style={{ color: "var(--text-muted)" }}
            >
              {text.length} حرف
            </div>
          </div>

          {error && (
            <div className="flex items-center gap-2 mb-4 p-3 rounded-xl"
              style={{ background: "rgba(239,68,68,0.1)", color: "#ef4444" }}>
              <AlertCircle className="w-4 h-4 flex-shrink-0" />
              <span className="text-sm">{error}</span>
            </div>
          )}

          {/* Tips */}
          <div
            className="p-4 rounded-2xl mb-6"
            style={{
              background: "rgba(108, 99, 255, 0.06)",
              border: "1px solid rgba(108,99,255,0.12)",
            }}
          >
            <div className="flex items-center gap-2 mb-2">
              <Sparkles className="w-4 h-4" style={{ color: "#6C63FF" }} />
              <span className="text-sm font-bold" style={{ color: "#6C63FF" }}>
                نصائح لتحليل أفضل
              </span>
            </div>
            <ul className="text-sm space-y-1" style={{ color: "var(--text-muted)" }}>
              <li>• اكتب بشكل طبيعي باللهجة اليمنية كما تتحدث</li>
              <li>• صِف مشاعرك وأفكارك بحرية — لا توجد إجابة صحيحة أو خاطئة</li>
              <li>• كلما كان النص أطول، كانت النتائج أدق</li>
            </ul>
          </div>

          {/* Actions */}
          <div className="flex gap-4">
            <button
              onClick={analyze}
              disabled={loading || text.trim().length < 3}
              className="flex-1 btn-primary flex items-center justify-center gap-3 py-4 text-base disabled:opacity-50 disabled:cursor-not-allowed"
            >
              <Brain className="w-5 h-5" />
              تحليل النص
              <Send className="w-4 h-4" />
            </button>

            {text && (
              <button
                onClick={reset}
                className="w-14 h-14 rounded-2xl flex items-center justify-center transition-all hover:scale-105"
                style={{
                  background: "var(--background)",
                  color: "var(--text-muted)",
                  border: "1px solid var(--border)",
                }}
              >
                <RotateCcw className="w-5 h-5" />
              </button>
            )}
          </div>
        </div>
      ) : (
        <div>
          <AnalysisResult result={result} originalText={text} onReset={reset} />
        </div>
      )}

      {loading && <LoadingAnimation />}
    </div>
  );
}
