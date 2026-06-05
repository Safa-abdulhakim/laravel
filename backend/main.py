import os
import re
import logging
from contextlib import asynccontextmanager
from typing import Optional

import joblib
import numpy as np
from fastapi import FastAPI, HTTPException
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel, field_validator

# ---------------------------------------------------------------------------
# Logging
# ---------------------------------------------------------------------------
logging.basicConfig(
    level=logging.INFO,
    format="%(asctime)s | %(levelname)s | %(name)s | %(message)s",
)
logger = logging.getLogger("arabic-dialect-api")

# ---------------------------------------------------------------------------
# Configuration (falls back to sensible defaults when .env is not present)
# ---------------------------------------------------------------------------
CORS_ORIGINS_RAW: str = os.getenv(
    "CORS_ORIGINS", "http://localhost:3000,http://127.0.0.1:3000"
)
CORS_ORIGINS: list[str] = [o.strip() for o in CORS_ORIGINS_RAW.split(",") if o.strip()]

MODEL_PATH: str = os.getenv("MODEL_PATH", "models/model.pkl")
VECTORIZER_PATH: str = os.getenv("VECTORIZER_PATH", "models/vectorizer.pkl")
LABEL_ENCODER_PATH: str = os.getenv("LABEL_ENCODER_PATH", "models/label_encoder.pkl")

# ---------------------------------------------------------------------------
# Arabic labels (fallback when label encoder is unavailable)
# ---------------------------------------------------------------------------
ARABIC_LABELS: list[str] = ["اكتئاب", "قلق", "ضغوط نفسية", "طبيعي"]

# ---------------------------------------------------------------------------
# Global model state — populated during startup
# ---------------------------------------------------------------------------
state: dict = {
    "model": None,
    "vectorizer": None,
    "label_encoder": None,
    "ready": False,
}


# ---------------------------------------------------------------------------
# Arabic text preprocessing helpers
# ---------------------------------------------------------------------------

# Unicode ranges / constants
_ARABIC_DIACRITICS_RE = re.compile(
    r"[ؐ-ؚ"   # Arabic Extended-A diacritics
    r"ً-ٟ"    # Arabic combining diacritics (fathah … small high yeh)
    r"ٰ"           # superscript alef
    r"ۖ-ۜ"    # Arabic small high ligatures
    r"۟-ۤ"    # Arabic small high rounded …
    r"ۧۨ"
    r"۪-ۭ]"   # Arabic phrase separator marks
)

_TATWEEL_RE = re.compile(r"ـ")  # Arabic tatweel (kashida) ـ

# Alef normalisation — collapse all alef variants to bare alef ا
_ALEF_RE = re.compile(r"[إأآٱ]")

# Waw with hamza → waw
_WAW_HAMZA_RE = re.compile(r"ؤ")

# Yeh with hamza → yeh
_YEH_HAMZA_RE = re.compile(r"ئ")

# Alef maqsura → yeh
_ALEF_MAQSURA_RE = re.compile(r"ى")

# Teh marbuta → heh
_TEH_MARBUTA_RE = re.compile(r"ة")

# Keep only Arabic letters and spaces; strip everything else
_NON_ARABIC_RE = re.compile(r"[^؀-ۿ\s]")

# Collapse multiple whitespace characters to a single space
_MULTI_SPACE_RE = re.compile(r"\s+")


def preprocess_arabic(text: str) -> str:
    """
    Clean and normalise Arabic (Yemeni dialect) text before vectorisation.

    Steps
    -----
    1. Strip leading/trailing whitespace.
    2. Remove diacritics (tashkeel).
    3. Remove tatweel (kashida).
    4. Normalise alef / hamza variants → ا
    5. Normalise waw hamza → و
    6. Normalise yeh hamza → ي
    7. Normalise alef maqsura → ي
    8. Normalise teh marbuta → ه
    9. Remove non-Arabic characters (Latin, digits, punctuation, emoji …).
    10. Collapse multiple spaces; strip again.
    """
    if not isinstance(text, str):
        text = str(text)

    text = text.strip()
    text = _ARABIC_DIACRITICS_RE.sub("", text)
    text = _TATWEEL_RE.sub("", text)
    text = _ALEF_RE.sub("ا", text)
    text = _WAW_HAMZA_RE.sub("و", text)
    text = _YEH_HAMZA_RE.sub("ي", text)
    text = _ALEF_MAQSURA_RE.sub("ي", text)
    text = _TEH_MARBUTA_RE.sub("ه", text)
    text = _NON_ARABIC_RE.sub(" ", text)
    text = _MULTI_SPACE_RE.sub(" ", text).strip()

    return text


# ---------------------------------------------------------------------------
# Lifespan — load models once at startup
# ---------------------------------------------------------------------------

def _load_artifact(path: str, name: str):
    """Load a joblib/pickle artifact; raise RuntimeError on failure."""
    if not os.path.exists(path):
        raise FileNotFoundError(
            f"{name} not found at '{path}'. "
            "Place the trained artifact in the models/ directory."
        )
    artifact = joblib.load(path)
    logger.info("Loaded %s from '%s'", name, path)
    return artifact


@asynccontextmanager
async def lifespan(app: FastAPI):
    """Load ML artefacts before the application starts serving requests."""
    logger.info("Starting up — loading ML models …")
    try:
        state["model"] = _load_artifact(MODEL_PATH, "model")
        state["vectorizer"] = _load_artifact(VECTORIZER_PATH, "vectorizer")
        state["label_encoder"] = _load_artifact(LABEL_ENCODER_PATH, "label_encoder")
        state["ready"] = True
        logger.info("All models loaded successfully. API is ready.")
    except FileNotFoundError as exc:
        logger.warning("Model file missing: %s", exc)
        logger.warning(
            "The /api/analyze endpoint will be unavailable until all model "
            "files are present."
        )
    except Exception as exc:  # noqa: BLE001
        logger.error("Unexpected error loading models: %s", exc, exc_info=True)

    yield  # application runs here

    logger.info("Shutting down.")
    state["model"] = None
    state["vectorizer"] = None
    state["label_encoder"] = None
    state["ready"] = False


# ---------------------------------------------------------------------------
# FastAPI application
# ---------------------------------------------------------------------------

app = FastAPI(
    title="Arabic Yemeni Dialect Analyser",
    description=(
        "Classifies Arabic Yemeni dialect text into one of four psychological "
        "categories: اكتئاب (depression), قلق (anxiety), "
        "ضغوط نفسية (psychological stress), طبيعي (normal)."
    ),
    version="1.0.0",
    lifespan=lifespan,
)

# ---------------------------------------------------------------------------
# CORS
# ---------------------------------------------------------------------------
app.add_middleware(
    CORSMiddleware,
    allow_origins=CORS_ORIGINS,
    allow_credentials=True,
    allow_methods=["GET", "POST", "OPTIONS"],
    allow_headers=["*"],
)


# ---------------------------------------------------------------------------
# Schemas
# ---------------------------------------------------------------------------

class AnalyzeRequest(BaseModel):
    text: str

    @field_validator("text")
    @classmethod
    def text_must_not_be_empty(cls, value: str) -> str:
        stripped = value.strip()
        if not stripped:
            raise ValueError("text must not be empty or contain only whitespace.")
        return stripped


class AnalyzeResponse(BaseModel):
    prediction: str
    confidence: float
    label_index: int
    preprocessed_text: Optional[str] = None


class HealthResponse(BaseModel):
    status: str
    models_loaded: bool
    version: str


# ---------------------------------------------------------------------------
# Routes
# ---------------------------------------------------------------------------

@app.get(
    "/api/health",
    response_model=HealthResponse,
    summary="Health check",
    tags=["Utility"],
)
async def health_check() -> HealthResponse:
    """
    Returns the current health status of the API and whether the ML models
    have been loaded successfully.
    """
    return HealthResponse(
        status="ok" if state["ready"] else "degraded",
        models_loaded=state["ready"],
        version=app.version,
    )


@app.post(
    "/api/analyze",
    response_model=AnalyzeResponse,
    summary="Analyse Arabic Yemeni dialect text",
    tags=["Analysis"],
)
async def analyze_text(body: AnalyzeRequest) -> AnalyzeResponse:
    """
    Accept a piece of Arabic (Yemeni dialect) text and return:

    - **prediction** — the predicted label in Arabic
    - **confidence** — model confidence as a percentage (0 – 100)
    - **label_index** — the integer index of the predicted class
    - **preprocessed_text** — the cleaned text that was fed to the model
    """
    if not state["ready"]:
        raise HTTPException(
            status_code=503,
            detail=(
                "ML models are not loaded. "
                "Ensure model.pkl, vectorizer.pkl, and label_encoder.pkl "
                "exist in the models/ directory and restart the server."
            ),
        )

    model = state["model"]
    vectorizer = state["vectorizer"]
    label_encoder = state["label_encoder"]

    # 1. Preprocess
    clean_text = preprocess_arabic(body.text)
    if not clean_text:
        raise HTTPException(
            status_code=422,
            detail=(
                "After preprocessing, the text contained no Arabic characters. "
                "Please provide text that includes Arabic script."
            ),
        )

    logger.info("Analysing text (first 80 chars): '%s'", clean_text[:80])

    # 2. Vectorise
    try:
        features = vectorizer.transform([clean_text])
    except Exception as exc:  # noqa: BLE001
        logger.error("Vectorisation failed: %s", exc, exc_info=True)
        raise HTTPException(
            status_code=500, detail="Failed to vectorise input text."
        ) from exc

    # 3. Predict
    try:
        prediction_index: int = int(model.predict(features)[0])
    except Exception as exc:  # noqa: BLE001
        logger.error("Prediction failed: %s", exc, exc_info=True)
        raise HTTPException(
            status_code=500, detail="Model prediction failed."
        ) from exc

    # 4. Confidence
    confidence_pct: float = 0.0
    try:
        if hasattr(model, "predict_proba"):
            probabilities: np.ndarray = model.predict_proba(features)[0]
            confidence_pct = float(round(float(probabilities[prediction_index]) * 100, 2))
        elif hasattr(model, "decision_function"):
            # SVM / linear models — convert decision score to a pseudo-probability
            scores: np.ndarray = model.decision_function(features)[0]
            if scores.ndim == 0:
                # Binary classifier returns a scalar
                scores = np.array([scores, -scores])
            exp_scores = np.exp(scores - np.max(scores))
            softmax_probs = exp_scores / exp_scores.sum()
            confidence_pct = float(round(float(softmax_probs[prediction_index]) * 100, 2))
        else:
            # Fallback: no probability information available
            confidence_pct = 100.0
    except Exception as exc:  # noqa: BLE001
        logger.warning("Could not compute confidence: %s", exc)
        confidence_pct = 0.0

    # 5. Decode label
    try:
        predicted_label: str = str(label_encoder.inverse_transform([prediction_index])[0])
    except Exception:  # noqa: BLE001
        # Graceful fallback to the hard-coded label list
        predicted_label = (
            ARABIC_LABELS[prediction_index]
            if prediction_index < len(ARABIC_LABELS)
            else str(prediction_index)
        )

    logger.info(
        "Result → label='%s' (index=%d, confidence=%.2f%%)",
        predicted_label,
        prediction_index,
        confidence_pct,
    )

    return AnalyzeResponse(
        prediction=predicted_label,
        confidence=confidence_pct,
        label_index=prediction_index,
        preprocessed_text=clean_text,
    )
