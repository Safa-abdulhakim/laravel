# Arabic Yemeni Dialect Analyser — Backend

A FastAPI service that classifies Arabic Yemeni dialect text into one of four psychological categories using a pre-trained scikit-learn model.

| Label | Meaning |
|---|---|
| اكتئاب | Depression |
| قلق | Anxiety |
| ضغوط نفسية | Psychological stress |
| طبيعي | Normal |

---

## Prerequisites

- Python 3.10 or later
- Trained model artefacts: `model.pkl`, `vectorizer.pkl`, `label_encoder.pkl`

---

## Setup

### 1. Clone / copy the project

```bash
cd backend
```

### 2. Create and activate a virtual environment

```bash
python -m venv venv
source venv/bin/activate        # Linux / macOS
# venv\Scripts\activate.bat     # Windows
```

### 3. Install dependencies

```bash
pip install -r requirements.txt
```

### 4. Configure environment variables

```bash
cp .env.example .env
# Edit .env as needed (CORS origins, model paths)
```

### 5. Place model artefacts

Copy your trained files into the `models/` directory:

```
models/
  model.pkl
  vectorizer.pkl
  label_encoder.pkl
```

### 6. Start the development server

```bash
uvicorn main:app --reload --host 0.0.0.0 --port 8000
```

The API will be available at `http://localhost:8000`.

Interactive docs: `http://localhost:8000/docs`

---

## API Reference

### `GET /api/health`

Returns service health and whether models are loaded.

**Response**
```json
{
  "status": "ok",
  "models_loaded": true,
  "version": "1.0.0"
}
```

---

### `POST /api/analyze`

Analyse a piece of Arabic text.

**Request body**
```json
{ "text": "أنا حاسس بضغط كبير وما أقدر أنام" }
```

**Response**
```json
{
  "prediction": "ضغوط نفسية",
  "confidence": 87.43,
  "label_index": 2,
  "preprocessed_text": "انا حاسس بضغط كبير وما اقدر انام"
}
```

| Field | Type | Description |
|---|---|---|
| `prediction` | string | Predicted Arabic label |
| `confidence` | float | Model confidence (0 – 100 %) |
| `label_index` | int | Integer index of the predicted class |
| `preprocessed_text` | string | Cleaned text fed to the model |

---

## Production deployment

```bash
uvicorn main:app --host 0.0.0.0 --port 8000 --workers 4
```

Or use `gunicorn` with the `uvicorn` worker class:

```bash
gunicorn main:app -k uvicorn.workers.UvicornWorker \
  --bind 0.0.0.0:8000 --workers 4
```
