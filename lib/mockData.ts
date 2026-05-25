// ======================================================
// بيانات وهمية للعرض — تُستبدل تلقائياً بـ Python API
// ======================================================

export type AnalysisResult = {
  label: "depression" | "anxiety" | "stress";
  label_ar: string;
  confidence: number;
  scores: {
    depression: number;
    anxiety: number;
    stress: number;
  };
  symptoms: string[];
  highlighted_words: string[];
  recommendation: string;
};

export type StatsData = {
  total_analyses: number;
  classifications: {
    depression: number;
    anxiety: number;
    stress: number;
  };
  word_frequency: Record<string, { count: number; category: string }>;
  monthly_data: Array<{
    month: string;
    depression: number;
    anxiety: number;
    stress: number;
  }>;
  accuracy_history: Array<{ week: string; accuracy: number }>;
};

// ── محاكاة نتيجة التحليل ──────────────────────────
export function getMockAnalysis(text: string): AnalysisResult {
  const lower = text.toLowerCase();

  if (lower.includes("خايف") || lower.includes("قلق") || lower.includes("خوف") || lower.includes("توتر")) {
    return {
      label: "anxiety",
      label_ar: "القلق",
      confidence: 82.1,
      scores: { depression: 12, anxiety: 82, stress: 6 },
      symptoms: ["التوتر المستمر", "الخوف المفرط", "صعوبة التركيز", "الأرق", "التفكير الزائد"],
      highlighted_words: ["خايف", "قلقان", "توتر", "ما أقدر أنام"],
      recommendation: "تشير النتائج إلى مستوى مرتفع من القلق. تقنيات الاسترخاء والتنفس قد تساعد، ويُنصح بزيارة متخصص.",
    };
  }

  if (lower.includes("ضغط") || lower.includes("مشغول") || lower.includes("شغل") || lower.includes("دراسة")) {
    return {
      label: "stress",
      label_ar: "الضغوط النفسية",
      confidence: 79.3,
      scores: { depression: 15, anxiety: 6, stress: 79 },
      symptoms: ["الإجهاد اليومي", "ضغط العمل أو الدراسة", "التعب الجسدي", "قلة الوقت"],
      highlighted_words: ["مشغول", "تعبان", "ضغط", "كثير مشاكل"],
      recommendation: "الحالة تعكس ضغوطاً يومية طبيعية. يُنصح بإدارة الوقت وممارسة الرياضة والراحة الكافية.",
    };
  }

  return {
    label: "depression",
    label_ar: "الاكتئاب",
    confidence: 87.4,
    scores: { depression: 87, anxiety: 9, stress: 4 },
    symptoms: ["فقدان الاهتمام", "الإرهاق المزمن", "اضطراب النوم", "الشعور بالفراغ", "العزلة الاجتماعية"],
    highlighted_words: ["تعبت", "زهقت", "ما أقدر", "ما في فايدة", "حزين"],
    recommendation: "تشير النتائج إلى وجود مؤشرات للاكتئاب. يُنصح بالتحدث مع متخصص في الصحة النفسية.",
  };
}

// ── إحصائيات وهمية ───────────────────────────────
export const MOCK_STATS: StatsData = {
  total_analyses: 527,
  classifications: { depression: 248, anxiety: 163, stress: 116 },
  word_frequency: {
    "تعبت":         { count: 142, category: "depression" },
    "حزين":         { count: 118, category: "depression" },
    "خايف":         { count: 96,  category: "anxiety"    },
    "زهقت":         { count: 87,  category: "depression" },
    "قلقان":        { count: 79,  category: "anxiety"    },
    "ما أقدر":      { count: 74,  category: "depression" },
    "ضغط":          { count: 68,  category: "stress"     },
    "متوتر":        { count: 61,  category: "anxiety"    },
    "مشغول":        { count: 55,  category: "stress"     },
    "وحيد":         { count: 48,  category: "depression" },
    "ما في فايدة":  { count: 43,  category: "depression" },
    "كثير مشاكل":  { count: 39,  category: "stress"     },
  },
  monthly_data: [
    { month: "يناير",  depression: 32, anxiety: 18, stress: 12 },
    { month: "فبراير", depression: 40, anxiety: 22, stress: 15 },
    { month: "مارس",   depression: 35, anxiety: 28, stress: 19 },
    { month: "أبريل",  depression: 50, anxiety: 32, stress: 22 },
    { month: "مايو",   depression: 45, anxiety: 38, stress: 28 },
    { month: "يونيو",  depression: 46, anxiety: 25, stress: 20 },
  ],
  accuracy_history: [
    { week: "أ1", accuracy: 88 },
    { week: "أ2", accuracy: 89 },
    { week: "أ3", accuracy: 90 },
    { week: "أ4", accuracy: 88 },
    { week: "م1", accuracy: 91 },
    { week: "م2", accuracy: 92 },
    { week: "م3", accuracy: 93 },
    { week: "م4", accuracy: 92 },
  ],
};
