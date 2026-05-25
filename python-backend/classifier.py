"""
واجهة النموذج (classifier.py)
================================
هذا الملف هو الجسر بين FastAPI ونموذجك المدرَّب.

الوضع الحالي  : تصنيف بالكلمات المفتاحية (للتجربة)
بعد التدريب   : ضع نموذجك في قسم "تحميل النموذج" أدناه
"""

# ── إعدادات كل تصنيف ──────────────────────────────────
LABEL_CONFIG: dict[str, dict] = {
    "depression": {
        "ar": "الاكتئاب",
        "symptoms": [
            "فقدان الاهتمام",
            "الإرهاق المزمن",
            "اضطراب النوم",
            "الشعور بالفراغ",
            "العزلة الاجتماعية",
        ],
        "recommendation": (
            "تشير النتائج إلى وجود مؤشرات للاكتئاب. "
            "يُنصح بالتحدث مع متخصص في الصحة النفسية "
            "للحصول على تقييم أكثر دقة."
        ),
    },
    "anxiety": {
        "ar": "القلق",
        "symptoms": [
            "التوتر المستمر",
            "الخوف المفرط",
            "صعوبة التركيز",
            "الأرق",
            "التفكير الزائد",
        ],
        "recommendation": (
            "تشير النتائج إلى مستوى مرتفع من القلق. "
            "تقنيات الاسترخاء والتنفس قد تساعد، "
            "ويُنصح بزيارة متخصص."
        ),
    },
    "stress": {
        "ar": "الضغوط النفسية",
        "symptoms": [
            "الإجهاد اليومي",
            "ضغط العمل أو الدراسة",
            "التعب الجسدي",
            "قلة الوقت",
            "المشكلات اليومية",
        ],
        "recommendation": (
            "الحالة تعكس ضغوطاً يومية طبيعية. "
            "يُنصح بإدارة الوقت وممارسة الرياضة والراحة الكافية."
        ),
    },
}


# ╔══════════════════════════════════════════════════════╗
# ║          ★★★  ضع نموذجك هنا  ★★★                    ║
# ╚══════════════════════════════════════════════════════╝
model = None          # سيُعيَّن عند التحميل الناجح
vectorizer = None     # إذا كنت تستخدم TF-IDF


def load_model() -> None:
    """
    يُنفَّذ مرة واحدة عند بدء السيرفر.
    ألغِ تعليق الكود المناسب لنموذجك.
    """
    global model, vectorizer

    try:
        # ════════════════════════════════════════
        # الخيار 1: scikit-learn (joblib)
        # ════════════════════════════════════════
        # import joblib
        # model      = joblib.load("model/wejdan_model.pkl")
        # vectorizer = joblib.load("model/vectorizer.pkl")
        # print("✅ تم تحميل نموذج sklearn")

        # ════════════════════════════════════════
        # الخيار 2: Hugging Face Transformers
        # ════════════════════════════════════════
        # from transformers import pipeline
        # model = pipeline(
        #     "text-classification",
        #     model="./model/",          # مجلد النموذج المحلي
        #     tokenizer="./model/",
        #     return_all_scores=True,
        # )
        # print("✅ تم تحميل نموذج Transformers")

        # ════════════════════════════════════════
        # الخيار 3: TensorFlow / Keras
        # ════════════════════════════════════════
        # import tensorflow as tf
        # import joblib
        # model      = tf.keras.models.load_model("model/wejdan.h5")
        # vectorizer = joblib.load("model/tokenizer.pkl")
        # print("✅ تم تحميل نموذج TensorFlow")

        print("⚠️  النموذج لم يُحمَّل — يعمل بوضع الكلمات المفتاحية")

    except FileNotFoundError:
        print("⚠️  ملف النموذج غير موجود — يعمل بوضع الكلمات المفتاحية")
    except Exception as e:
        print(f"❌ خطأ في تحميل النموذج: {e}")


load_model()   # تحميل تلقائي عند استيراد الملف


# ╔══════════════════════════════════════════════════════╗
# ║               الدالة الرئيسية                        ║
# ╚══════════════════════════════════════════════════════╝
def classify_text(text: str) -> dict:
    """
    تصنيف النص — نقطة الدخول الوحيدة من main.py

    تنطق:
        إذا النموذج محمّل → استخدامه
        وإلا               → التصنيف بالكلمات المفتاحية
    """
    if model is not None:
        return _classify_with_model(text)
    else:
        return _classify_with_keywords(text)


# ── التصنيف بالنموذج الحقيقي ──────────────────────────
def _classify_with_model(text: str) -> dict:
    """
    عدّل هذه الدالة بما يناسب نموذجك.
    المطلوب: ترجع dict بنفس شكل _classify_with_keywords
    """
    try:
        # ════════════════════════════════════════
        # Transformers pipeline
        # ════════════════════════════════════════
        # results   = model(text)[0]  # قائمة scores
        # label_map = {"LABEL_0": "depression", "LABEL_1": "anxiety", "LABEL_2": "stress"}
        # scores_raw = {label_map[r["label"]]: round(r["score"] * 100, 1) for r in results}
        # label      = max(scores_raw, key=scores_raw.get)
        # confidence = scores_raw[label]

        # ════════════════════════════════════════
        # sklearn / TF-IDF
        # ════════════════════════════════════════
        # X          = vectorizer.transform([text])
        # label      = model.predict(X)[0]
        # proba      = model.predict_proba(X)[0]
        # classes    = model.classes_
        # scores_raw = {c: round(p * 100, 1) for c, p in zip(classes, proba)}
        # confidence = round(max(proba) * 100, 1)

        pass  # ← احذف هذا السطر عند إضافة كودك

    except Exception as e:
        print(f"⚠️  خطأ في النموذج، Fallback: {e}")

    return _classify_with_keywords(text)  # Fallback


# ── التصنيف بالكلمات المفتاحية (Fallback) ─────────────
def _classify_with_keywords(text: str) -> dict:
    """
    تصنيف بسيط:
      - يعدّ كلمات كل تصنيف في النص
      - التصنيف الأعلى عدداً يفوز
    """
    from keywords import KEYWORDS

    counts: dict[str, int] = {"depression": 0, "anxiety": 0, "stress": 0}

    for label, words in KEYWORDS.items():
        for word in words:
            if word in text:
                counts[label] += 1

    total = sum(counts.values()) or 1
    label = max(counts, key=counts.get)  # type: ignore

    # تحويل العدد إلى نسب مئوية
    scores = {k: round((v / total) * 100, 1) for k, v in counts.items()}
    confidence = scores[label]

    # إذا كل الأعداد صفر → افتراضي اكتئاب بثقة 50
    if total == 1:
        label = "depression"
        scores = {"depression": 50.0, "anxiety": 30.0, "stress": 20.0}
        confidence = 50.0

    config = LABEL_CONFIG[label]

    return {
        "label":          label,
        "label_ar":       config["ar"],
        "confidence":     confidence,
        "scores":         scores,
        "symptoms":       config["symptoms"],
        "recommendation": config["recommendation"],
    }
