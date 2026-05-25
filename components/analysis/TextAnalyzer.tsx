"use client";

import { useState } from "react";
import { Brain, Send, RotateCcw, Sparkles, AlertCircle, Wifi, WifiOff } from "lucide-react";
import AnalysisResult from "./AnalysisResult";
import LoadingAnimation from "./LoadingAnimation";

export type AnalysisData = {
  label: "depression" | "anxiety" | "stress";
  label_ar: string;
  confidence: number;
  scores: { depression: number; anxiety: number; stress: number };
  symptoms: string[];
  highlighted_words: string[];
  recommendation: string;
  source?: "live" | "demo";
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

    try {
      const res = await fetch("/api/analyze", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ text }),
      });

      if (!res.ok) throw new Error("فشل التحليل");

      const data: AnalysisData = await res.json();
      setResult(data);
    } catch {
      setError("حدث خطأ أثناء التحليل. يرجى المحاولة مرة أخرى.");
    } finally {
      setLoading(false);
    }
  };

  const reset = () => { setText(""); setResult(null); setError(""); };

  return (
    <div className="max-w-4xl mx-auto">
      {loading && <LoadingAnimation />}

      {!result ? (
        <div
          className="rounded-3xl p-8 sm:p-10"
          style={{ background: "var(--card)", boxShadow: "var(--shadow-lg)", border: "1px solid var(--border)" }}
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
            <div className="absolute bottom-3 left-3 text-xs" style={{ color: "var(--text-muted)" }}>
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
          <div className="p-4 rounded-2xl mb-6"
            style={{ background: "rgba(108,99,255,0.06)", border: "1px solid rgba(108,99,255,0.12)" }}>
            <div className="flex items-center gap-2 mb-2">
              <Sparkles className="w-4 h-4" style={{ color: "#6C63FF" }} />
              <span className="text-sm font-bold" style={{ color: "#6C63FF" }}>نصائح لتحليل أفضل</span>
            </div>
            <ul className="text-sm space-y-1" style={{ color: "var(--text-muted)" }}>
              <li>• اكتب بشكل طبيعي باللهجة اليمنية كما تتحدث</li>
              <li>• صِف مشاعرك وأفكارك بحرية</li>
              <li>• كلما كان النص أطول، كانت النتائج أدق</li>
            </ul>
          </div>

          {/* Buttons */}
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
                style={{ background: "var(--background)", color: "var(--text-muted)", border: "1px solid var(--border)" }}
              >
                <RotateCcw className="w-5 h-5" />
              </button>
            )}
          </div>
        </div>
      ) : (
        <div>
          {/* مؤشر مصدر البيانات */}
          {result.source === "demo" && (
            <div
              className="flex items-center gap-2 px-4 py-2.5 rounded-xl mb-4 text-sm"
              style={{ background: "rgba(245,158,11,0.1)", border: "1px solid rgba(245,158,11,0.2)", color: "#f59e0b" }}
            >
              <WifiOff className="w-4 h-4 flex-shrink-0" />
              <span>
                <strong>وضع العرض:</strong> Python API غير متصل — النتائج تجريبية.
                شغّل Python وستتحول النتائج لحقيقية تلقائياً.
              </span>
            </div>
          )}
          {result.source === "live" && (
            <div
              className="flex items-center gap-2 px-4 py-2.5 rounded-xl mb-4 text-sm"
              style={{ background: "rgba(16,185,129,0.1)", border: "1px solid rgba(16,185,129,0.2)", color: "#10b981" }}
            >
              <Wifi className="w-4 h-4 flex-shrink-0" />
              <span><strong>متصل بالنموذج الحقيقي ✓</strong> — النتائج من AI مدرَّب</span>
            </div>
          )}

          <AnalysisResult result={result} originalText={text} onReset={reset} />
        </div>
      )}
    </div>
  );
}
