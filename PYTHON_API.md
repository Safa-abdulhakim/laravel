# ربط Python FastAPI بـ Next.js

## الشكل المطلوب من Python API

---

### `POST /analyze`
**Input:**
```json
{ "text": "النص المكتوب باللهجة اليمنية..." }
```

**Output المطلوب:**
```json
{
  "label": "depression",
  "label_ar": "الاكتئاب",
  "confidence": 87.4,
  "scores": {
    "depression": 87,
    "anxiety": 9,
    "stress": 4
  },
  "symptoms": ["فقدان الاهتمام", "الإرهاق", "اضطراب النوم"],
  "highlighted_words": ["تعبت", "زهقت", "ما أقدر"],
  "recommendation": "يُنصح بالتحدث مع متخصص..."
}
```

---

### `GET /statistics`
**Output المطلوب:**
```json
{
  "total_analyses": 527,
  "classifications": {
    "depression": 248,
    "anxiety": 163,
    "stress": 116
  },
  "word_frequency": {
    "تعبت":  { "count": 142, "category": "depression" },
    "خايف":  { "count": 96,  "category": "anxiety"    },
    "ضغط":   { "count": 68,  "category": "stress"     }
  },
  "monthly_data": [
    { "month": "يناير", "depression": 32, "anxiety": 18, "stress": 12 },
    { "month": "فبراير","depression": 40, "anxiety": 22, "stress": 15 }
  ],
  "accuracy_history": [
    { "week": "أ1", "accuracy": 88 },
    { "week": "أ2", "accuracy": 90 }
  ]
}
```

---

## خطوات الربط

1. شغّل Python FastAPI على `http://localhost:8000`
2. في `.env.local` تأكد:
   ```
   PYTHON_API_URL=http://localhost:8000
   ```
3. شغّل Next.js: `npm run dev`
4. الواجهة ستتصل تلقائياً بـ Python

---

## مثال FastAPI بسيط

```python
from fastapi import FastAPI
from pydantic import BaseModel

app = FastAPI()

class TextInput(BaseModel):
    text: str

@app.post("/analyze")
def analyze(data: TextInput):
    # استدعي نموذجك هنا
    result = your_model.predict(data.text)
    return {
        "label": result.label,          # "depression" | "anxiety" | "stress"
        "label_ar": result.label_ar,
        "confidence": result.confidence,
        "scores": result.scores,
        "symptoms": result.symptoms,
        "highlighted_words": result.keywords,
        "recommendation": result.recommendation
    }

@app.get("/statistics")
def statistics():
    # جلب من قاعدة البيانات
    return db.get_statistics()
```
