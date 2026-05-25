"""
قاعدة البيانات — SQLite
=========================
جدولان:
  ┌─────────────────────────────────────────────┐
  │  analyses       → كل تحليل يُحفظ هنا       │
  │  word_frequency → عدد تكرار كل كلمة        │
  └─────────────────────────────────────────────┘
"""

import sqlite3
import os
from collections import defaultdict

# مسار ملف قاعدة البيانات
DB_PATH = os.path.join(os.path.dirname(__file__), "data", "wejdan.db")

# ── أسماء الأشهر بالعربية ──────────────────────────────
MONTH_NAMES = {
    "01": "يناير",  "02": "فبراير", "03": "مارس",
    "04": "أبريل",  "05": "مايو",   "06": "يونيو",
    "07": "يوليو",  "08": "أغسطس",  "09": "سبتمبر",
    "10": "أكتوبر", "11": "نوفمبر", "12": "ديسمبر",
}


def get_conn() -> sqlite3.Connection:
    """فتح اتصال بقاعدة البيانات"""
    return sqlite3.connect(DB_PATH)


# ╔══════════════════════════════════════════════════════╗
# ║               إنشاء الجداول                          ║
# ╚══════════════════════════════════════════════════════╝
def init_db() -> None:
    """
    يُنفَّذ مرة واحدة عند بدء تشغيل السيرفر.
    ينشئ الجداول إذا لم تكن موجودة.
    """
    os.makedirs(os.path.dirname(DB_PATH), exist_ok=True)

    with get_conn() as conn:
        # ── جدول التحليلات ─────────────────────────────
        conn.execute("""
            CREATE TABLE IF NOT EXISTS analyses (
                id                INTEGER PRIMARY KEY AUTOINCREMENT,
                text              TEXT    NOT NULL,
                label             TEXT    NOT NULL,
                confidence        REAL    NOT NULL,
                depression_score  REAL    DEFAULT 0,
                anxiety_score     REAL    DEFAULT 0,
                stress_score      REAL    DEFAULT 0,
                created_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        """)

        # ── جدول تكرار الكلمات ─────────────────────────
        # ON CONFLICT(word) → كل كلمة محفوظة مرة واحدة فقط
        # عند التكرار يُزاد العدد بـ 1
        conn.execute("""
            CREATE TABLE IF NOT EXISTS word_frequency (
                word        TEXT    PRIMARY KEY,
                count       INTEGER DEFAULT 0,
                category    TEXT    NOT NULL,
                updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        """)

        conn.commit()

    print(f"✅ قاعدة البيانات جاهزة: {DB_PATH}")


# ╔══════════════════════════════════════════════════════╗
# ║               حفظ التحليل                            ║
# ╚══════════════════════════════════════════════════════╝
def save_analysis(text: str, label: str, confidence: float, scores: dict) -> None:
    """
    يحفظ نتيجة التحليل في جدول analyses.

    المدخلات:
        text        → النص الأصلي
        label       → التصنيف: "depression" | "anxiety" | "stress"
        confidence  → نسبة الثقة: 87.4
        scores      → {"depression": 87, "anxiety": 9, "stress": 4}
    """
    with get_conn() as conn:
        conn.execute(
            """
            INSERT INTO analyses
                (text, label, confidence, depression_score, anxiety_score, stress_score)
            VALUES (?, ?, ?, ?, ?, ?)
            """,
            (
                text,
                label,
                confidence,
                scores.get("depression", 0),
                scores.get("anxiety",    0),
                scores.get("stress",     0),
            ),
        )
        conn.commit()


# ╔══════════════════════════════════════════════════════╗
# ║           تحديث عدد الكلمات (القلب)                  ║
# ╚══════════════════════════════════════════════════════╝
def update_word_frequency(words: list[str], category: str) -> None:
    """
    يُحدِّث جدول word_frequency بعد كل تحليل.

    المنطق:
        إذا الكلمة موجودة → count = count + 1
        إذا الكلمة جديدة  → أضفها بـ count = 1
    """
    if not words:
        return

    with get_conn() as conn:
        for word in words:
            conn.execute(
                """
                INSERT INTO word_frequency (word, count, category)
                VALUES (?, 1, ?)
                ON CONFLICT(word) DO UPDATE SET
                    count      = count + 1,
                    updated_at = CURRENT_TIMESTAMP
                """,
                (word, category),
            )
        conn.commit()


# ╔══════════════════════════════════════════════════════╗
# ║               جلب الإحصائيات                         ║
# ╚══════════════════════════════════════════════════════╝
def get_statistics() -> dict:
    """
    يجمع كل الإحصائيات من قاعدة البيانات ويُرجعها
    بالشكل الذي يتوقعه Next.js.
    """
    with get_conn() as conn:

        # 1. إجمالي عدد التحليلات
        total: int = conn.execute(
            "SELECT COUNT(*) FROM analyses"
        ).fetchone()[0]

        # 2. توزيع التصنيفات
        raw_classifications = conn.execute(
            "SELECT label, COUNT(*) FROM analyses GROUP BY label"
        ).fetchall()

        classifications = {"depression": 0, "anxiety": 0, "stress": 0}
        for label, count in raw_classifications:
            if label in classifications:
                classifications[label] = count

        # 3. الكلمات الأكثر تكراراً (أعلى 20)
        word_rows = conn.execute(
            """
            SELECT word, count, category
            FROM   word_frequency
            ORDER  BY count DESC
            LIMIT  20
            """
        ).fetchall()

        word_frequency = {
            row[0]: {"count": row[1], "category": row[2]}
            for row in word_rows
        }

        # 4. البيانات الشهرية (آخر 6 أشهر)
        monthly_rows = conn.execute(
            """
            SELECT
                strftime('%m', created_at) AS month_num,
                label,
                COUNT(*)                   AS cnt
            FROM   analyses
            WHERE  created_at >= date('now', '-6 months')
            GROUP  BY month_num, label
            ORDER  BY month_num
            """
        ).fetchall()

        # دمج الصفوف في dict
        monthly_dict: dict = defaultdict(
            lambda: {"depression": 0, "anxiety": 0, "stress": 0}
        )
        for month_num, label, cnt in monthly_rows:
            month_ar = MONTH_NAMES.get(month_num, month_num)
            if label in ("depression", "anxiety", "stress"):
                monthly_dict[month_ar][label] = cnt

        monthly_data = [
            {"month": month, **data}
            for month, data in monthly_dict.items()
        ]

        # 5. سجل الدقة
        # ملاحظة: اربطه بنتائج التقييم الحقيقي لاحقاً
        accuracy_history = [
            {"week": "أ1", "accuracy": 88},
            {"week": "أ2", "accuracy": 89},
            {"week": "أ3", "accuracy": 90},
            {"week": "أ4", "accuracy": 91},
            {"week": "م1", "accuracy": 91},
            {"week": "م2", "accuracy": 92},
            {"week": "م3", "accuracy": 93},
            {"week": "م4", "accuracy": 92},
        ]

        return {
            "total_analyses":   total,
            "classifications":  classifications,
            "word_frequency":   word_frequency,
            "monthly_data":     monthly_data,
            "accuracy_history": accuracy_history,
        }
