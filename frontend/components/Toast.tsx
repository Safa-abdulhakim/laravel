"use client";

import React, {
  createContext,
  useCallback,
  useContext,
  useEffect,
  useRef,
  useState,
} from "react";

/* ────────────────────────────────────────────────────────────
   Types
   ──────────────────────────────────────────────────────────── */
export type ToastVariant = "success" | "error" | "info" | "warning";

export interface ToastMessage {
  id: string;
  message: string;
  variant: ToastVariant;
  duration: number;
  exiting: boolean;
}

interface ToastContextValue {
  showToast: (message: string, variant?: ToastVariant, duration?: number) => void;
  dismissToast: (id: string) => void;
}

/* ────────────────────────────────────────────────────────────
   Context
   ──────────────────────────────────────────────────────────── */
const ToastContext = createContext<ToastContextValue | undefined>(undefined);

/* ────────────────────────────────────────────────────────────
   Hook
   ──────────────────────────────────────────────────────────── */
export function useToast(): ToastContextValue {
  const ctx = useContext(ToastContext);
  if (!ctx) throw new Error("useToast must be used inside <ToastProvider>");
  return ctx;
}

/* ────────────────────────────────────────────────────────────
   Variant config
   ──────────────────────────────────────────────────────────── */
const variantConfig: Record<
  ToastVariant,
  {
    bg: string;
    border: string;
    iconBg: string;
    icon: string;
    textColor: string;
  }
> = {
  success: {
    bg: "bg-emerald-50",
    border: "border-emerald-300",
    iconBg: "bg-emerald-500",
    icon: "✓",
    textColor: "text-emerald-800",
  },
  error: {
    bg: "bg-rose-50",
    border: "border-rose-300",
    iconBg: "bg-rose-500",
    icon: "✕",
    textColor: "text-rose-800",
  },
  info: {
    bg: "bg-sky-50",
    border: "border-sky-300",
    iconBg: "bg-sky-500",
    icon: "ℹ",
    textColor: "text-sky-800",
  },
  warning: {
    bg: "bg-amber-50",
    border: "border-amber-300",
    iconBg: "bg-amber-500",
    icon: "⚠",
    textColor: "text-amber-800",
  },
};

/* ────────────────────────────────────────────────────────────
   Single Toast Item Component
   ──────────────────────────────────────────────────────────── */
function SingleToast({
  toast,
  onDismiss,
}: {
  toast: ToastMessage;
  onDismiss: (id: string) => void;
}) {
  const config = variantConfig[toast.variant];
  const timerRef = useRef<ReturnType<typeof setTimeout> | null>(null);

  const dismiss = useCallback(() => {
    onDismiss(toast.id);
  }, [onDismiss, toast.id]);

  useEffect(() => {
    timerRef.current = setTimeout(dismiss, toast.duration);
    return () => {
      if (timerRef.current) clearTimeout(timerRef.current);
    };
  }, [dismiss, toast.duration]);

  return (
    <div
      role="alert"
      aria-live="assertive"
      onClick={dismiss}
      className={`
        flex items-start gap-3 w-full max-w-sm
        px-4 py-3.5 rounded-2xl shadow-xl border
        ${config.bg} ${config.border}
        cursor-pointer select-none
        ${toast.exiting ? "toast-exit" : "toast-enter"}
        transition-all
      `}
    >
      {/* Icon bubble */}
      <span
        className={`
          flex-shrink-0 w-7 h-7 rounded-full
          ${config.iconBg} text-white
          flex items-center justify-center
          text-sm font-bold mt-0.5
        `}
      >
        {config.icon}
      </span>

      {/* Message */}
      <p className={`flex-1 text-sm font-semibold leading-relaxed ${config.textColor}`}>
        {toast.message}
      </p>

      {/* Close button */}
      <button
        onClick={(e) => {
          e.stopPropagation();
          dismiss();
        }}
        aria-label="إغلاق التنبيه"
        className={`
          flex-shrink-0 w-5 h-5 rounded-full
          flex items-center justify-center
          text-xs opacity-50 hover:opacity-100
          transition-opacity mt-0.5 ${config.textColor}
        `}
      >
        ✕
      </button>
    </div>
  );
}

/* ────────────────────────────────────────────────────────────
   Provider
   ──────────────────────────────────────────────────────────── */
export function ToastProvider({ children }: { children: React.ReactNode }) {
  const [toasts, setToasts] = useState<ToastMessage[]>([]);
  const counterRef = useRef(0);

  const showToast = useCallback(
    (message: string, variant: ToastVariant = "info", duration = 4000) => {
      const id = `toast-${++counterRef.current}-${Date.now()}`;
      setToasts((prev) => [
        ...prev,
        { id, message, variant, duration, exiting: false },
      ]);
    },
    []
  );

  const dismissToast = useCallback((id: string) => {
    // Mark as exiting for animation
    setToasts((prev) =>
      prev.map((t) => (t.id === id ? { ...t, exiting: true } : t))
    );
    // Remove after animation
    setTimeout(() => {
      setToasts((prev) => prev.filter((t) => t.id !== id));
    }, 350);
  }, []);

  return (
    <ToastContext.Provider value={{ showToast, dismissToast }}>
      {children}

      {/* Toast container - fixed bottom-left (RTL-friendly) */}
      {toasts.length > 0 && (
        <div
          aria-label="منطقة التنبيهات"
          className="
            fixed bottom-6 left-6 z-[9999]
            flex flex-col gap-2.5
            pointer-events-none
          "
        >
          {toasts.map((t) => (
            <div key={t.id} className="pointer-events-auto">
              <SingleToast toast={t} onDismiss={dismissToast} />
            </div>
          ))}
        </div>
      )}
    </ToastContext.Provider>
  );
}
