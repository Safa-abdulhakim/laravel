import axios, { AxiosError } from 'axios';

const API_BASE = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:8000';

export interface AnalyzeRequest {
  text: string;
}

export interface AnalyzeResponse {
  prediction: string;
  confidence: number;
  label_index: number;
}

const apiClient = axios.create({
  baseURL: API_BASE,
  timeout: 30000,
  headers: { 'Content-Type': 'application/json', Accept: 'application/json' },
});

export const analyzeText = async (text: string): Promise<AnalyzeResponse> => {
  try {
    const response = await apiClient.post<AnalyzeResponse>('/api/analyze', { text });
    return response.data;
  } catch (error) {
    const err = error as AxiosError<{ detail?: string; message?: string }>;
    if (err.response) {
      throw new Error(
        err.response.data?.detail || err.response.data?.message || 'حدث خطأ في الخادم'
      );
    } else if (err.request) {
      throw new Error('تعذّر الوصول إلى الخادم. تأكد من تشغيل Backend.');
    }
    throw new Error('حدث خطأ غير متوقع. حاول مرة أخرى.');
  }
};

export const checkHealth = async (): Promise<boolean> => {
  try {
    await apiClient.get('/api/health');
    return true;
  } catch {
    return false;
  }
};
