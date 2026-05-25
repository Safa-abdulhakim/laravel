"use client";

import { Brain, TrendingUp, Users, Target } from "lucide-react";
import type { StatsData } from "@/lib/mockData";

interface Props { stats: StatsData }

export default function StatsOverview({ stats }: Props) {
  const total = stats.total_analyses;
  const { depression, anxiety, stress } = stats.classifications;

  const topLabel = depression >= anxiety && depression >= stress
    ? { name: "الاكتئاب", count: depression, color: "#6C63FF" }
    : anxiety >= stress
      ? { name: "القلق", count: anxiety, color: "#4ECDC4" }
      : { name: "الضغوط", count: stress, color: "#f59e0b" };

  const lastAcc = stats.accuracy_history.at(-1)?.accuracy ?? 0;

  const cards = [
    {
      icon: Brain,
      value: total.toLocaleString("ar"),
      label: "إجمالي النصوص المحلّلة",
      sub: "منذ بدء التشغيل",
      color: "#6C63FF",
      bg: "rgba(108,99,255,0.1)",
    },
    {
      icon: TrendingUp,
      value: topLabel.name,
      label: "أكثر تصنيف شيوعاً",
      sub: `${topLabel.count} حالة من ${total}`,
      color: topLabel.color,
      bg: `${topLabel.color}1A`,
    },
    {
      icon: Target,
      value: `${lastAcc}%`,
      label: "دقة النموذج الحالية",
      sub: "بناءً على آخر تقييم",
      color: "#1E3A5F",
      bg: "rgba(30,58,95,0.08)",
    },
    {
      icon: Users,
      value: `${depression}·${anxiety}·${stress}`,
      label: "اكتئاب · قلق · ضغوط",
      sub: "توزيع التصنيفات",
      color: "#f59e0b",
      bg: "rgba(245,158,11,0.1)",
    },
  ];

  return (
    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      {cards.map((card) => (
        <div key={card.label} className="rounded-2xl p-6 card-hover"
          style={{ background: "var(--card)", border: "1px solid var(--border)", boxShadow: "var(--shadow-sm)" }}>
          <div className="flex items-center justify-between mb-4">
            <div className="w-11 h-11 rounded-xl flex items-center justify-center" style={{ background: card.bg }}>
              <card.icon className="w-5 h-5" style={{ color: card.color }} />
            </div>
          </div>
          <div className="text-2xl font-black mb-1" style={{ color: card.color }}>{card.value}</div>
          <div className="font-semibold text-sm mb-1" style={{ color: "var(--text)" }}>{card.label}</div>
          <div className="text-xs" style={{ color: "var(--text-muted)" }}>{card.sub}</div>
        </div>
      ))}
    </div>
  );
}
