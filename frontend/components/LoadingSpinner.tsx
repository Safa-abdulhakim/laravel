"use client";

interface LoadingSpinnerProps {
  size?: "sm" | "md" | "lg" | "xl";
  color?: "white" | "brand" | "teal";
  className?: string;
}

const sizeMap = {
  sm: "w-4 h-4 border-2",
  md: "w-8 h-8 border-3",
  lg: "w-12 h-12 border-4",
  xl: "w-16 h-16 border-4",
};

const colorMap = {
  white: "border-white/30 border-t-white",
  brand: "border-brand-200 border-t-brand-700",
  teal: "border-teal-200 border-t-teal-600",
};

export default function LoadingSpinner({
  size = "md",
  color = "teal",
  className = "",
}: LoadingSpinnerProps) {
  return (
    <div
      role="status"
      aria-label="جاري التحميل"
      className={`
        inline-block
        rounded-full
        animate-spin
        ${sizeMap[size]}
        ${colorMap[color]}
        ${className}
      `}
    />
  );
}

export function LoadingSpinnerOverlay({ message = "جاري التحميل..." }: { message?: string }) {
  return (
    <div className="flex flex-col items-center justify-center gap-4 py-12">
      <div className="relative">
        {/* Outer ring pulse */}
        <div className="absolute inset-0 rounded-full bg-teal-400/20 animate-ping" />
        <LoadingSpinner size="xl" color="teal" />
      </div>
      <p className="text-slate-600 font-medium text-lg animate-pulse">{message}</p>
    </div>
  );
}
