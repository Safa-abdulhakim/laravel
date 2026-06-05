"use client";

/* ────────────────────────────────────────────────────────────
   Types
   ──────────────────────────────────────────────────────────── */
interface LoadingSpinnerProps {
  /** Visual size of the spinner */
  size?: "sm" | "md" | "lg" | "xl";
  /** Color theme */
  color?: "white" | "brand" | "teal";
  /** Additional Tailwind classes */
  className?: string;
}

/* ────────────────────────────────────────────────────────────
   Maps
   ──────────────────────────────────────────────────────────── */
const sizeMap: Record<NonNullable<LoadingSpinnerProps["size"]>, string> = {
  sm: "w-4 h-4 border-2",
  md: "w-7 h-7 border-[3px]",
  lg: "w-12 h-12 border-[3px]",
  xl: "w-16 h-16 border-4",
};

const colorMap: Record<NonNullable<LoadingSpinnerProps["color"]>, string> = {
  white: "border-white/30 border-t-white",
  brand: "border-brand-200 border-t-brand-700",
  teal: "border-teal-200 border-t-teal-600",
};

/* ────────────────────────────────────────────────────────────
   Spinner (default export)
   ──────────────────────────────────────────────────────────── */
export default function LoadingSpinner({
  size = "md",
  color = "teal",
  className = "",
}: LoadingSpinnerProps) {
  return (
    <span
      role="status"
      aria-label="جاري التحميل"
      className={`
        inline-block rounded-full animate-spin
        ${sizeMap[size]}
        ${colorMap[color]}
        ${className}
      `.trim()}
    />
  );
}

/* ────────────────────────────────────────────────────────────
   Full-page overlay spinner
   ──────────────────────────────────────────────────────────── */
export function LoadingSpinnerOverlay({
  message = "جاري التحميل...",
}: {
  message?: string;
}) {
  return (
    <div
      className="flex flex-col items-center justify-center gap-5 py-16"
      role="status"
      aria-live="polite"
    >
      {/* Pulsing ring + spinner */}
      <div className="relative">
        <div className="absolute inset-0 rounded-full bg-teal-300/25 animate-ping" />
        <LoadingSpinner size="xl" color="teal" />
      </div>

      {/* Message */}
      <p className="text-slate-600 font-semibold text-base animate-pulse">
        {message}
      </p>
    </div>
  );
}

/* ────────────────────────────────────────────────────────────
   Inline skeleton shimmer block
   ──────────────────────────────────────────────────────────── */
export function SkeletonBlock({
  className = "",
}: {
  className?: string;
}) {
  return (
    <div
      aria-hidden="true"
      className={`
        bg-slate-200 rounded-xl overflow-hidden relative
        ${className}
      `}
    >
      <div className="absolute inset-0 shimmer" />
    </div>
  );
}
