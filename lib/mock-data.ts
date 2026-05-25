import type { MentalStateKey } from "./constants";

// ─── Analysis Result Type ───────────────────────────────────────────────────

export interface AnalysisResult {
  id: string;
  text: string;
  prediction: MentalStateKey;
  confidence: number;
  scores: {
    depression: number;
    anxiety: number;
    stress: number;
  };
  keywords: string[];
  symptoms: string[];
  insight: string;
  suggestion: string;
  processingTime: number; // ms
  timestamp: Date;
}

// ─── Statistics Types ────────────────────────────────────────────────────────

export interface DailyActivity {
  date: string;
  total: number;
  depression: number;
  anxiety: number;
  stress: number;
}

export interface KeywordFrequency {
  word: string;
  count: number;
  category: MentalStateKey;
  percentage: number;
}

export interface Statistics {
  totalAnalyses: number;
  depressionCount: number;
  anxietyCount: number;
  stressCount: number;
  avgConfidence: number;
  todayCount: number;
  weeklyGrowth: number;
  dailyActivity: DailyActivity[];
  topKeywords: KeywordFrequency[];
  monthlyTrend: { month: string; count: number }[];
  confidenceDistribution: { range: string; count: number }[];
}

// ─── Mock Analysis Results ───────────────────────────────────────────────────

export const MOCK_ANALYSIS_RESULTS: Record<string, AnalysisResult> = {
  depression_example: {
    id: "ana_001",
    text: "أنا تعبان جداً من كل شي، ما عندي حيل أقوم وأسوي شي، حاسس إني فاشل بكل شي، مو لاقي راحة",
    prediction: "depression",
    confidence: 0.87,
    scores: { depression: 0.87, anxiety: 0.08, stress: 0.05 },
    keywords: ["تعبان", "فاشل", "راحة", "حيل"],
    symptoms: ["إرهاق شديد", "الشعور بالفشل", "فقدان الطاقة", "صعوبة الراحة"],
    insight:
      "النص يحتوي على مؤشرات واضحة للاكتئاب، تشمل الإرهاق المستمر، الشعور بعدم القدرة، والإحساس بالفشل. هذه التعبيرات تنسجم مع الأعراض الشائعة للاكتئاب الخفيف إلى المتوسط.",
    suggestion:
      "يُنصح بالتحدث مع متخصص نفسي. التمارين الخفيفة والنوم الكافي قد تساعد في تحسين المزاج.",
    processingTime: 1240,
    timestamp: new Date(),
  },
  anxiety_example: {
    id: "ana_002",
    text: "والله ما أقدر أنام من القلق، دايم خايف يصير شي، دقات قلبي سريعة ومو قادر أتركز",
    prediction: "anxiety",
    confidence: 0.91,
    scores: { depression: 0.05, anxiety: 0.91, stress: 0.04 },
    keywords: ["قلق", "خايف", "أنام", "تركز"],
    symptoms: ["اضطراب النوم", "الخوف المستمر", "تسارع القلب", "صعوبة التركيز"],
    insight:
      "النص يُظهر أعراضاً واضحة للقلق العام، تشمل اضطراب النوم، الخوف المستمر من المجهول، والأعراض الجسدية كتسارع القلب.",
    suggestion:
      "تقنيات التنفس العميق والتأمل قد تساعد. استشارة طبية موصى بها لتقييم الأعراض الجسدية.",
    processingTime: 980,
    timestamp: new Date(),
  },
  stress_example: {
    id: "ana_003",
    text: "مشغول ومرهق من الشغل والدراسة، ضايق ومو لاقي وقت لنفسي، طفشان من كل شي بس لازم أكمل",
    prediction: "stress",
    confidence: 0.82,
    scores: { depression: 0.10, anxiety: 0.08, stress: 0.82 },
    keywords: ["مرهق", "ضايق", "طفشان", "مشغول"],
    symptoms: ["الإرهاق اليومي", "نقص وقت الراحة", "الشعور بالضيق", "الالتزام رغم التعب"],
    insight:
      "النص يعكس ضغوطاً نفسية يومية مرتبطة بالمسؤوليات المتعددة. هذه الحالة شائعة وقابلة للإدارة مع التوازن الصحيح في الحياة.",
    suggestion:
      "جدولة وقت للراحة والترفيه أمر ضروري. تقليل الأعباء غير الضرورية وممارسة الهوايات يساعدان كثيراً.",
    processingTime: 870,
    timestamp: new Date(),
  },
};

// ─── Mock Statistics Data ────────────────────────────────────────────────────

export const MOCK_STATISTICS: Statistics = {
  totalAnalyses: 3847,
  depressionCount: 1423,
  anxietyCount: 1186,
  stressCount: 1238,
  avgConfidence: 0.84,
  todayCount: 47,
  weeklyGrowth: 12.5,

  dailyActivity: [
    { date: "السبت", total: 35, depression: 14, anxiety: 11, stress: 10 },
    { date: "الأحد", total: 42, depression: 16, anxiety: 13, stress: 13 },
    { date: "الاثنين", total: 58, depression: 22, anxiety: 19, stress: 17 },
    { date: "الثلاثاء", total: 51, depression: 19, anxiety: 17, stress: 15 },
    { date: "الأربعاء", total: 63, depression: 24, anxiety: 20, stress: 19 },
    { date: "الخميس", total: 47, depression: 18, anxiety: 15, stress: 14 },
    { date: "الجمعة", total: 29, depression: 11, anxiety: 9, stress: 9 },
  ],

  topKeywords: [
    { word: "متعب", count: 542, category: "depression", percentage: 14.1 },
    { word: "قلق", count: 489, category: "anxiety", percentage: 12.7 },
    { word: "ضايق", count: 431, category: "stress", percentage: 11.2 },
    { word: "خايف", count: 387, category: "anxiety", percentage: 10.1 },
    { word: "حزين", count: 362, category: "depression", percentage: 9.4 },
    { word: "مرهق", count: 318, category: "stress", percentage: 8.3 },
    { word: "طفشان", count: 294, category: "stress", percentage: 7.6 },
    { word: "وحيد", count: 271, category: "depression", percentage: 7.0 },
    { word: "متوتر", count: 248, category: "anxiety", percentage: 6.4 },
    { word: "يأس", count: 226, category: "depression", percentage: 5.9 },
    { word: "أرق", count: 198, category: "anxiety", percentage: 5.1 },
    { word: "فاشل", count: 183, category: "depression", percentage: 4.8 },
  ],

  monthlyTrend: [
    { month: "يناير", count: 210 },
    { month: "فبراير", count: 285 },
    { month: "مارس", count: 342 },
    { month: "أبريل", count: 398 },
    { month: "مايو", count: 467 },
    { month: "يونيو", count: 521 },
    { month: "يوليو", count: 489 },
    { month: "أغسطس", count: 558 },
    { month: "سبتمبر", count: 612 },
    { month: "أكتوبر", count: 684 },
    { month: "نوفمبر", count: 542 },
    { month: "ديسمبر", count: 339 },
  ],

  confidenceDistribution: [
    { range: "90%+", count: 1124 },
    { range: "80-90%", count: 1538 },
    { range: "70-80%", count: 841 },
    { range: "60-70%", count: 284 },
    { range: "أقل من 60%", count: 60 },
  ],
};

// ─── Simulate Analysis (Mock API) ────────────────────────────────────────────

export function simulateAnalysis(text: string): Promise<AnalysisResult> {
  return new Promise((resolve) => {
    const delay = 1500 + Math.random() * 1000;

    setTimeout(() => {
      const lower = text.toLowerCase();

      let scores = { depression: 0.15, anxiety: 0.15, stress: 0.70 };
      let prediction: MentalStateKey = "stress";

      // Simple heuristic keyword matching for demo
      const depKeywords = ["حزين", "تعبان", "وحيد", "فاشل", "يأس", "بكاء", "فراغ", "ما عندي حيل", "بكت", "اكتئاب"];
      const anxKeywords = ["خايف", "قلق", "أرق", "توتر", "ارتعاش", "تشتت", "خوف", "مو قادر أنام", "ما أقدر"];
      const stressKeywords = ["مرهق", "مشغول", "ضايق", "طفشان", "تعب", "عبئ", "ضغط", "وقت", "شغل", "دراسة"];

      const depScore = depKeywords.filter((k) => lower.includes(k)).length;
      const anxScore = anxKeywords.filter((k) => lower.includes(k)).length;
      const stressScore = stressKeywords.filter((k) => lower.includes(k)).length;
      const total = depScore + anxScore + stressScore || 1;

      scores = {
        depression: 0.1 + (depScore / total) * 0.8,
        anxiety: 0.1 + (anxScore / total) * 0.8,
        stress: 0.1 + (stressScore / total) * 0.8,
      };

      if (scores.depression > scores.anxiety && scores.depression > scores.stress) {
        prediction = "depression";
      } else if (scores.anxiety > scores.depression && scores.anxiety > scores.stress) {
        prediction = "anxiety";
      } else {
        prediction = "stress";
      }

      const confidence = Math.max(scores.depression, scores.anxiety, scores.stress);
      const normalizedConfidence = Math.min(0.97, Math.max(0.52, confidence));

      const baseResult = MOCK_ANALYSIS_RESULTS[`${prediction}_example`];

      resolve({
        ...baseResult,
        id: `ana_${Date.now()}`,
        text,
        prediction,
        confidence: normalizedConfidence,
        scores,
        processingTime: Math.round(delay),
        timestamp: new Date(),
      });
    }, delay);
  });
}
