"use client";

import { Brain, TrendingUp, Users, Target } from "lucide-react";

const cards = [
  {
    icon: Brain,
    value: "527",
    label: "إجمالي النصوص المحلّلة",
    sub: "+24 هذا الأسبوع",
    color: "#6C63FF",
    bg: "rgba(108, 99, 255, 0.1)",
    trend: "+12%",
  },
  {
    icon: TrendingUp,
    value: "47%",
    label: "أكثر تصنيف: الاكتئاب",
    sub: "248 حالة من 527",
    color: "#4ECDC4",
    bg: "rgba(78, 205, 196, 0.1)",
    trend: "+5%",
  },
  {
    icon: Target,
    value: "92%",
    label: "متوسط دقة التحليل",
    sub: "بناءً على التحقق اليدوي",
    color: "#1E3A5F",
    bg: "rgba(30, 58, 95, 0.1)",
    trend: "+3%",
  },
  {
    icon: Users,
    value: "384",
    label: "مستخدم فريد",
    sub: "في آخر 30 يوماً",
    color: "#f59e0b",
    bg: "rgba(245, 158, 11, 0.1)",
    trend: "+18%",
  },
];

export default function StatsOverview() {
  return (
    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      {cards.map((card) => (
        <div
          key={card.label}
          className="rounded-2xl p-6 card-hover"
          style={{
            background: "var(--card)",
            border: "1px solid var(--border)",
            boxShadow: "var(--shadow-sm)",
          }}
        >
          <div className="flex items-center justify-between mb-4">
            <div
              className="w-11 h-11 rounded-xl flex items-center justify-center"
              style={{ background: card.bg }}
            >
              <card.icon className="w-5 h-5" style={{ color: card.color }} />
            </div>
            <span
              className="text-xs font-bold px-2 py-1 rounded-full"
              style={{ background: "rgba(16,185,129,0.1)", color: "#10b981" }}
            >
              {card.trend}
            </span>
          </div>
          <div className="text-3xl font-black mb-1" style={{ color: card.color }}>
            {card.value}
          </div>
          <div className="font-semibold text-sm mb-1" style={{ color: "var(--text)" }}>
            {card.label}
          </div>
          <div className="text-xs" style={{ color: "var(--text-muted)" }}>
            {card.sub}
          </div>
        </div>
      ))}
    </div>
  );
}
