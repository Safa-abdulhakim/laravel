import { NextRequest, NextResponse } from "next/server";
import { getMockAnalysis } from "@/lib/mockData";

const PYTHON_URL = process.env.PYTHON_API_URL || "http://localhost:8000";

export async function POST(req: NextRequest) {
  const { text } = await req.json();

  if (!text || text.trim().length < 5) {
    return NextResponse.json({ error: "النص قصير جداً" }, { status: 400 });
  }

  // ── محاولة الاتصال بـ Python API ──────────────────
  try {
    const response = await fetch(`${PYTHON_URL}/analyze`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ text }),
      signal: AbortSignal.timeout(10000), // 10 ثوانٍ timeout
    });

    if (!response.ok) throw new Error(`Python API error: ${response.status}`);

    const data = await response.json();

    // ── الشكل المتوقع من Python ──────────────────────
    // {
    //   "label": "depression",
    //   "label_ar": "الاكتئاب",
    //   "confidence": 87.4,
    //   "scores": { "depression": 87, "anxiety": 9, "stress": 4 },
    //   "symptoms": ["..."],
    //   "highlighted_words": ["..."],
    //   "recommendation": "..."
    // }

    return NextResponse.json({ ...data, source: "live" });

  } catch (err) {
    // ── Python مش شغّال → رجوع للبيانات الوهمية ─────
    console.warn("⚠️  Python API غير متاح — وضع Demo:", err);

    const mockResult = getMockAnalysis(text);
    return NextResponse.json({ ...mockResult, source: "demo" });
  }
}
