import TextAnalyzer from "@/components/analysis/TextAnalyzer";
import { Brain, Shield, Sparkles } from "lucide-react";

export const metadata = {
  title: "تحليل النص | وجدان",
  description: "حلّل نصك باللهجة اليمنية واكتشف المؤشرات النفسية",
};

export default function AnalysisPage() {
  return (
    <div className="min-h-screen pt-24 pb-16" style={{ background: "var(--background)" }}>
      <div className="max-w-7xl mx-auto px-4 sm:px-6">
        {/* Page Header */}
        <div className="text-center mb-12">
          <div
            className="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold mb-6"
            style={{
              background: "rgba(108, 99, 255, 0.1)",
              color: "#6C63FF",
              border: "1px solid rgba(108, 99, 255, 0.2)",
            }}
          >
            <Brain className="w-4 h-4" />
            تحليل نفسي بالذكاء الاصطناعي
          </div>

          <h1 className="text-4xl sm:text-5xl font-black mb-4" style={{ color: "var(--text)" }}>
            حلّل{" "}
            <span className="gradient-text">نصك</span> الآن
          </h1>
          <p
            className="text-lg max-w-xl mx-auto mb-8"
            style={{ color: "var(--text-muted)" }}
          >
            اكتب ما تشعر به باللهجة اليمنية وسيقوم النموذج بتحليله
            واكتشاف المؤشرات النفسية بدقة عالية
          </p>

          {/* Feature chips */}
          <div className="flex flex-wrap items-center justify-center gap-3">
            {[
              { icon: Shield, text: "آمن وسري", color: "#4ECDC4" },
              { icon: Sparkles, text: "نتائج فورية", color: "#6C63FF" },
              { icon: Brain, text: "دقة 92%", color: "#1E3A5F" },
            ].map(({ icon: Icon, text, color }) => (
              <div
                key={text}
                className="flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium"
                style={{
                  background: "var(--card)",
                  color: "var(--text)",
                  border: "1px solid var(--border)",
                  boxShadow: "var(--shadow-sm)",
                }}
              >
                <Icon className="w-3.5 h-3.5" style={{ color }} />
                {text}
              </div>
            ))}
          </div>
        </div>

        {/* Analyzer Component */}
        <TextAnalyzer />

        {/* Disclaimer */}
        <div
          className="mt-8 p-4 rounded-2xl max-w-2xl mx-auto text-center text-sm"
          style={{
            background: "rgba(245, 158, 11, 0.08)",
            border: "1px solid rgba(245, 158, 11, 0.15)",
            color: "var(--text-muted)",
          }}
        >
          ⚠️ هذه المنصة لأغراض بحثية وأكاديمية فقط ولا تُغني عن الاستشارة النفسية المتخصصة.
          إذا كنت تعاني من مشكلة نفسية، يرجى التواصل مع متخصص.
        </div>
      </div>
    </div>
  );
}
