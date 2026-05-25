"""
وجدان — Python FastAPI Backend
================================
نقاط النهاية:
  GET  /              → فحص الحالة
  POST /analyze       → تحليل النص + حفظ النتيجة + تحديث الكلمات
  GET  /statistics    → جلب الإحصائيات الكاملة
"""

from fastapi import FastAPI, HTTPException
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel

from database import init_db, save_analysis, update_word_frequency, get_statistics
from classifier import classify_text
from keywords import extract_keywords


# ── إنشاء التطبيق ─────────────────────────────────────
app = FastAPI(
    title="وجدان API",
    description="تحليل النصوص النفسية باللهجة اليمنية",
    version="1.0.0",
)

# ── السماح لـ Next.js بالاتصال ─────────────────────────
app.add_middleware(
    CORSMiddleware,
    allow_origins=["http://localhost:3000"],   # رابط Next.js
    allow_methods=["GET", "POST"],
    allow_headers=["*"],
)


# ── تهيئة DB عند بدء التشغيل ──────────────────────────
@app.on_event("startup")
async def on_startup():
    init_db()


# ╔══════════════════════════════════════════════════════╗
# ║   شكل البيانات القادمة من Next.js                    ║
# ╚══════════════════════════════════════════════════════╝
class TextInput(BaseModel):
    text: str


# ╔══════════════════════════════════════════════════════╗
# ║   GET /  →  فحص الحالة                               ║
# ╚══════════════════════════════════════════════════════╝
@app.get("/")
def health_check():
    return {
        "status":  "ok",
        "message": "وجدان API شغّالة ✅",
    }


# ╔══════════════════════════════════════════════════════╗
# ║   POST /analyze  →  تحليل النص                       ║
# ╚══════════════════════════════════════════════════════╝
@app.post("/analyze")
def analyze(data: TextInput):
    """
    الخطوات:
      1. النموذج يصنّف النص
      2. استخراج الكلمات المهمة
      3. حفظ التحليل في جدول analyses
      4. تحديث عدد الكلمات في جدول word_frequency  ← القلب
      5. إرجاع النتيجة لـ Next.js
    """
    # تحقق من طول النص
    if len(data.text.strip()) < 5:
        raise HTTPException(status_code=400, detail="النص قصير جداً")

    # ── 1. تصنيف النص ─────────────────────────────────
    result = classify_text(data.text)
    #
    # result = {
    #   "label":          "depression",
    #   "label_ar":       "الاكتئاب",
    #   "confidence":     87.4,
    #   "scores":         {"depression": 87, "anxiety": 9, "stress": 4},
    #   "symptoms":       [...],
    #   "recommendation": "...",
    # }

    # ── 2. استخراج الكلمات المهمة من النص ─────────────
    highlighted_words = extract_keywords(data.text, result["label"])

    # ── 3. حفظ التحليل في DB ──────────────────────────
    save_analysis(
        text=data.text,
        label=result["label"],
        confidence=result["confidence"],
        scores=result["scores"],
    )

    # ── 4. تحديث عدد الكلمات ← هنا يُحفظ العدد ────────
    #
    # مثال: النص فيه "تعبت" و"زهقت"
    #   word_frequency:
    #     تعبت  → كان 141 ← صار 142
    #     زهقت  → كان 86  ← صار 87
    #
    update_word_frequency(highlighted_words, result["label"])

    # ── 5. إرجاع النتيجة ──────────────────────────────
    return {
        "label":             result["label"],
        "label_ar":          result["label_ar"],
        "confidence":        result["confidence"],
        "scores":            result["scores"],
        "symptoms":          result["symptoms"],
        "highlighted_words": highlighted_words,
        "recommendation":    result["recommendation"],
    }


# ╔══════════════════════════════════════════════════════╗
# ║   GET /statistics  →  الإحصائيات                     ║
# ╚══════════════════════════════════════════════════════╝
@app.get("/statistics")
def statistics():
    """
    يقرأ من قاعدة البيانات ويُرجع:
      - إجمالي التحليلات
      - توزيع التصنيفات
      - الكلمات الأكثر تكراراً  ← من word_frequency
      - البيانات الشهرية
      - سجل الدقة
    """
    return get_statistics()


# ── تشغيل السيرفر مباشرة ──────────────────────────────
if __name__ == "__main__":
    import uvicorn
    uvicorn.run("main:app", host="0.0.0.0", port=8000, reload=True)
