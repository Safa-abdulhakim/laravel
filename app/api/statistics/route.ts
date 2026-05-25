import { NextResponse } from "next/server";
import { MOCK_STATS } from "@/lib/mockData";

const PYTHON_URL = process.env.PYTHON_API_URL || "http://localhost:8000";

export async function GET() {
  // ── محاولة الاتصال بـ Python API ──────────────────
  try {
    const response = await fetch(`${PYTHON_URL}/statistics`, {
      signal: AbortSignal.timeout(5000),
      next: { revalidate: 60 }, // cache لمدة دقيقة
    });

    if (!response.ok) throw new Error("Python stats error");

    const data = await response.json();

    // ── الشكل المتوقع من Python ──────────────────────
    // {
    //   "total_analyses": 527,
    //   "classifications": { "depression": 248, "anxiety": 163, "stress": 116 },
    //   "word_frequency": { "تعبت": { "count": 142, "category": "depression" }, ... },
    //   "monthly_data": [...],
    //   "accuracy_history": [...]
    // }

    return NextResponse.json({ ...data, source: "live" });

  } catch (err) {
    // ── Python مش شغّال → بيانات وهمية ──────────────
    console.warn("⚠️  Python API غير متاح — إحصائيات Demo:", err);
    return NextResponse.json({ ...MOCK_STATS, source: "demo" });
  }
}
