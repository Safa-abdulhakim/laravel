import { type ClassValue, clsx } from "clsx";
import { twMerge } from "tailwind-merge";

export function cn(...inputs: ClassValue[]) {
  return twMerge(clsx(inputs));
}

export function formatNumber(num: number): string {
  if (num >= 1000000) return (num / 1000000).toFixed(1) + "م";
  if (num >= 1000) return (num / 1000).toFixed(1) + "ك";
  return num.toString();
}

export function formatPercent(value: number, total: number): string {
  return ((value / total) * 100).toFixed(1) + "%";
}

export function getConfidenceLabel(score: number): string {
  if (score >= 0.85) return "عالية جداً";
  if (score >= 0.70) return "عالية";
  if (score >= 0.55) return "متوسطة";
  return "منخفضة";
}

export function getConfidenceColor(score: number): string {
  if (score >= 0.85) return "text-stress-text dark:text-stress";
  if (score >= 0.70) return "text-navy-600 dark:text-navy-300";
  if (score >= 0.55) return "text-anxiety-text dark:text-anxiety";
  return "text-muted-foreground";
}

export function sleep(ms: number): Promise<void> {
  return new Promise((resolve) => setTimeout(resolve, ms));
}

export function highlight(text: string, keywords: string[]): string {
  let result = text;
  keywords.forEach((kw) => {
    const regex = new RegExp(`(${kw})`, "gi");
    result = result.replace(regex, `<mark class="highlight-keyword">$1</mark>`);
  });
  return result;
}
