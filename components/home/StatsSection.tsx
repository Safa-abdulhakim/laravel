"use client";

import { useEffect, useRef, useState } from "react";
import { Users, Brain, TrendingUp, Star } from "lucide-react";

const stats = [
  { icon: Users, value: 500, suffix: "+", label: "نص محلّل", color: "#6C63FF" },
  { icon: Brain, value: 92, suffix: "%", label: "دقة التحليل", color: "#4ECDC4" },
  { icon: TrendingUp, value: 3, suffix: "", label: "تصنيفات نفسية", color: "#1E3A5F" },
  { icon: Star, value: 98, suffix: "%", label: "رضا المستخدمين", color: "#f59e0b" },
];

function CountUp({ target, suffix }: { target: number; suffix: string }) {
  const [count, setCount] = useState(0);
  const ref = useRef<HTMLSpanElement>(null);
  const started = useRef(false);

  useEffect(() => {
    const observer = new IntersectionObserver(
      ([entry]) => {
        if (entry.isIntersecting && !started.current) {
          started.current = true;
          const duration = 2000;
          const steps = 60;
          const step = target / steps;
          let current = 0;
          const timer = setInterval(() => {
            current += step;
            if (current >= target) {
              setCount(target);
              clearInterval(timer);
            } else {
              setCount(Math.floor(current));
            }
          }, duration / steps);
        }
      },
      { threshold: 0.5 }
    );
    if (ref.current) observer.observe(ref.current);
    return () => observer.disconnect();
  }, [target]);

  return (
    <span ref={ref}>
      {count}
      {suffix}
    </span>
  );
}

export default function StatsSection() {
  return (
    <section
      className="py-20 relative overflow-hidden"
      style={{
        background: "linear-gradient(135deg, #1E3A5F 0%, #6C63FF 100%)",
      }}
    >
      <div className="absolute inset-0 opacity-10">
        <div className="absolute top-0 right-0 w-64 h-64 rounded-full blur-3xl"
          style={{ background: "white" }} />
        <div className="absolute bottom-0 left-0 w-48 h-48 rounded-full blur-3xl"
          style={{ background: "white" }} />
      </div>

      <div className="relative max-w-7xl mx-auto px-4 sm:px-6">
        <div className="text-center mb-12">
          <h2 className="text-3xl sm:text-4xl font-black text-white mb-3">
            أرقام تتحدث عن نفسها
          </h2>
          <p className="text-white/70 text-lg">
            منصة وجدان في أرقام
          </p>
        </div>

        <div className="grid grid-cols-2 lg:grid-cols-4 gap-6">
          {stats.map((stat) => (
            <div
              key={stat.label}
              className="text-center p-6 rounded-2xl"
              style={{
                background: "rgba(255, 255, 255, 0.1)",
                backdropFilter: "blur(10px)",
                border: "1px solid rgba(255, 255, 255, 0.15)",
              }}
            >
              <div
                className="w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-4"
                style={{ background: "rgba(255,255,255,0.15)" }}
              >
                <stat.icon className="w-6 h-6 text-white" />
              </div>
              <div className="text-4xl font-black text-white mb-2">
                <CountUp target={stat.value} suffix={stat.suffix} />
              </div>
              <div className="text-white/70 text-sm font-medium">{stat.label}</div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
