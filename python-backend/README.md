# وجدان — Python Backend

## هيكل الملفات

```
python-backend/
├── main.py          ← FastAPI (نقاط النهاية)
├── database.py      ← SQLite (حفظ + قراءة)
├── classifier.py    ← نموذج الذكاء الاصطناعي
├── keywords.py      ← قوائم الكلمات المفتاحية
├── requirements.txt ← المكتبات المطلوبة
└── data/
    └── wejdan.db    ← قاعدة البيانات (تُنشأ تلقائياً)
```

---

## التشغيل

```bash
# 1. تثبيت المكتبات
pip install -r requirements.txt

# 2. تشغيل السيرفر
python main.py
# أو
uvicorn main:app --reload --port 8000
```

---

## دمج نموذجك

افتح `classifier.py` وابحث عن:
```python
# ════════════════════════════════════════
# الخيار 1: scikit-learn (joblib)
# ════════════════════════════════════════
```
ألغِ تعليق الكود المناسب وضع ملف نموذجك في مجلد `model/`.

---

## كيف تُحفظ الكلمات؟

```
POST /analyze  ←── يأتي النص من Next.js
     ↓
النموذج يصنّف
     ↓
extract_keywords()  ←── يبحث عن الكلمات الموجودة في النص
     ↓
update_word_frequency()  ←── يزيد عدد كل كلمة بـ 1 في DB
     ↓
جدول word_frequency:
  تعبت  | 142 | depression
  خايف  |  96 | anxiety
```
