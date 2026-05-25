"use client";

import { useState, useCallback } from "react";
import { simulateAnalysis, type AnalysisResult } from "@/lib/mock-data";

type AnalysisState = "idle" | "loading" | "success" | "error";

export function useAnalysis() {
  const [state, setState] = useState<AnalysisState>("idle");
  const [result, setResult] = useState<AnalysisResult | null>(null);
  const [error, setError] = useState<string | null>(null);
  const [loadingStep, setLoadingStep] = useState(0);

  const analyze = useCallback(async (text: string) => {
    if (!text.trim() || text.trim().length < 10) {
      setError("يرجى إدخال نص لا يقل عن 10 أحرف");
      return;
    }

    setState("loading");
    setResult(null);
    setError(null);
    setLoadingStep(0);

    // Simulate progressive loading steps
    const stepTimers = [
      setTimeout(() => setLoadingStep(1), 300),
      setTimeout(() => setLoadingStep(2), 800),
      setTimeout(() => setLoadingStep(3), 1300),
    ];

    try {
      const analysisResult = await simulateAnalysis(text);
      stepTimers.forEach(clearTimeout);
      setResult(analysisResult);
      setState("success");
    } catch {
      stepTimers.forEach(clearTimeout);
      setError("حدث خطأ أثناء التحليل. يرجى المحاولة مجدداً.");
      setState("error");
    }
  }, []);

  const reset = useCallback(() => {
    setState("idle");
    setResult(null);
    setError(null);
    setLoadingStep(0);
  }, []);

  return {
    state,
    result,
    error,
    loadingStep,
    analyze,
    reset,
    isLoading: state === "loading",
    isSuccess: state === "success",
    isIdle: state === "idle",
    isError: state === "error",
  };
}
