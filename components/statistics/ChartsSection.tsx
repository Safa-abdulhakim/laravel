"use client";

import { useRef } from "react";
import { motion, useInView } from "framer-motion";
import {
  PieChart,
  Pie,
  Cell,
  BarChart,
  Bar,
  AreaChart,
  Area,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  Legend,
  ResponsiveContainer,
  TooltipProps,
} from "recharts";
import type { DailyActivity, Statistics } from "@/lib/mock-data";

// ─── Colors ───────────────────────────────────────────────────────────────────

const COLORS = {
  depression: "#4A90D9",
  anxiety: "#E8924A",
  stress: "#52B788",
  violet: "#6C63FF",
};

const LABELS = {
  depression: "اكتئاب",
  anxiety: "قلق",
  stress: "ضغوط",
};

// ─── Animated Section Wrapper ─────────────────────────────────────────────────

function ChartCard({
  title,
  subtitle,
  children,
  delay = 0,
  className = "",
}: {
  title: string;
  subtitle?: string;
  children: React.ReactNode;
  delay?: number;
  className?: string;
}) {
  const ref = useRef<HTMLDivElement>(null);
  const inView = useInView(ref, { once: true, margin: "-60px" });

  return (
    <motion.div
      ref={ref}
      initial={{ opacity: 0, y: 24 }}
      animate={inView ? { opacity: 1, y: 0 } : {}}
      transition={{ duration: 0.6, delay, ease: [0.22, 1, 0.36, 1] }}
      className={`bg-white/70 dark:bg-navy-800/60 backdrop-blur-sm border border-white/60 dark:border-navy-700/60 rounded-2xl p-6 shadow-glass ${className}`}
    >
      <div className="mb-5">
        <h3 className="text-base font-bold text-navy-800 dark:text-white">{title}</h3>
        {subtitle && (
          <p className="text-xs text-navy-400 dark:text-navy-400 mt-0.5">{subtitle}</p>
        )}
      </div>
      {children}
    </motion.div>
  );
}

// ─── Custom Tooltip ───────────────────────────────────────────────────────────

function ArabicTooltip({ active, payload, label }: TooltipProps<number, string>) {
  if (!active || !payload?.length) return null;
  return (
    <div className="bg-white dark:bg-navy-900 border border-navy-100 dark:border-navy-700 rounded-xl p-3 shadow-glass-lg text-right">
      {label && <p className="text-xs font-bold text-navy-600 dark:text-navy-300 mb-2">{label}</p>}
      {payload.map((entry) => (
        <div key={entry.name} className="flex items-center gap-2 text-xs text-navy-700 dark:text-navy-200 mb-0.5">
          <span
            className="w-2.5 h-2.5 rounded-full flex-shrink-0"
            style={{ backgroundColor: entry.color }}
          />
          <span>{(LABELS as Record<string, string>)[entry.name as string] ?? entry.name}:</span>
          <span className="font-bold">{entry.value}</span>
        </div>
      ))}
    </div>
  );
}

// ─── Custom Pie Label (center total) ──────────────────────────────────────────

function PieCenterLabel({ cx, cy, total }: { cx: number; cy: number; total: number }) {
  return (
    <g>
      <text x={cx} y={cy - 8} textAnchor="middle" className="fill-navy-800 dark:fill-white" fontSize={26} fontWeight="800">
        {total.toLocaleString("ar-EG")}
      </text>
      <text x={cx} y={cy + 14} textAnchor="middle" className="fill-navy-400" fontSize={11}>
        إجمالي التحليلات
      </text>
    </g>
  );
}

// ─── 1. Distribution Pie Chart ────────────────────────────────────────────────

function DistributionPieChart({ stats }: { stats: Statistics }) {
  const data = [
    { name: "depression", value: stats.depressionCount, label: "اكتئاب" },
    { name: "anxiety", value: stats.anxietyCount, label: "قلق" },
    { name: "stress", value: stats.stressCount, label: "ضغوط" },
  ];

  const total = stats.depressionCount + stats.anxietyCount + stats.stressCount;

  return (
    <ChartCard
      title="توزيع الحالات النفسية"
      subtitle="نسبة كل حالة من إجمالي التحليلات"
      delay={0}
    >
      <ResponsiveContainer width="100%" height={260}>
        <PieChart>
          <defs>
            {Object.entries(COLORS).slice(0, 3).map(([key, color]) => (
              <radialGradient key={key} id={`pie-grad-${key}`} cx="50%" cy="50%" r="50%">
                <stop offset="0%" stopColor={color} stopOpacity={0.9} />
                <stop offset="100%" stopColor={color} stopOpacity={0.6} />
              </radialGradient>
            ))}
          </defs>
          <Pie
            data={data}
            cx="50%"
            cy="50%"
            innerRadius={72}
            outerRadius={108}
            paddingAngle={3}
            dataKey="value"
            animationBegin={300}
            animationDuration={900}
          >
            {data.map((entry) => (
              <Cell
                key={entry.name}
                fill={COLORS[entry.name as keyof typeof COLORS]}
                stroke="none"
              />
            ))}
          </Pie>
          <Tooltip
            content={({ active, payload }) => {
              if (!active || !payload?.length) return null;
              const item = payload[0];
              const pct = ((Number(item.value) / total) * 100).toFixed(1);
              return (
                <div className="bg-white dark:bg-navy-900 border border-navy-100 dark:border-navy-700 rounded-xl p-3 shadow-glass-lg text-right">
                  <p className="text-xs font-bold mb-1" style={{ color: item.payload.fill }}>
                    {item.payload.label}
                  </p>
                  <p className="text-sm font-extrabold text-navy-800 dark:text-white">
                    {Number(item.value).toLocaleString("ar-EG")}
                  </p>
                  <p className="text-xs text-navy-400">{pct}%</p>
                </div>
              );
            }}
          />
        </PieChart>
      </ResponsiveContainer>

      {/* Legend */}
      <div className="grid grid-cols-3 gap-3 mt-2">
        {data.map((entry) => {
          const pct = ((entry.value / total) * 100).toFixed(1);
          return (
            <div key={entry.name} className="text-center">
              <div
                className="w-8 h-1.5 rounded-full mx-auto mb-1.5"
                style={{ backgroundColor: COLORS[entry.name as keyof typeof COLORS] }}
              />
              <p className="text-xs font-bold text-navy-700 dark:text-navy-200">{entry.label}</p>
              <p className="text-sm font-extrabold" style={{ color: COLORS[entry.name as keyof typeof COLORS] }}>
                {pct}%
              </p>
              <p className="text-xs text-navy-400">{entry.value.toLocaleString("ar-EG")}</p>
            </div>
          );
        })}
      </div>

      {/* Center total overlay (positioned) */}
      <style suppressHydrationWarning>{`
        .recharts-layer.recharts-pie text { font-family: 'Cairo', sans-serif; }
      `}</style>
    </ChartCard>
  );
}

// ─── 2. Weekly Stacked Bar Chart ──────────────────────────────────────────────

function WeeklyBarChart({ dailyActivity }: { dailyActivity: DailyActivity[] }) {
  return (
    <ChartCard
      title="النشاط الأسبوعي"
      subtitle="توزيع التحليلات خلال آخر 7 أيام"
      delay={0.1}
    >
      <ResponsiveContainer width="100%" height={260}>
        <BarChart data={dailyActivity} barSize={24} margin={{ top: 5, right: 5, left: -20, bottom: 5 }}>
          <defs>
            {Object.entries(COLORS).slice(0, 3).map(([key, color]) => (
              <linearGradient key={key} id={`bar-grad-${key}`} x1="0" y1="0" x2="0" y2="1">
                <stop offset="0%" stopColor={color} stopOpacity={0.95} />
                <stop offset="100%" stopColor={color} stopOpacity={0.55} />
              </linearGradient>
            ))}
          </defs>
          <CartesianGrid strokeDasharray="3 3" stroke="rgba(108,99,255,0.08)" vertical={false} />
          <XAxis
            dataKey="date"
            tick={{ fontSize: 11, fill: "#8A9BB5", fontFamily: "Cairo" }}
            axisLine={false}
            tickLine={false}
          />
          <YAxis
            tick={{ fontSize: 10, fill: "#8A9BB5", fontFamily: "Cairo" }}
            axisLine={false}
            tickLine={false}
          />
          <Tooltip content={<ArabicTooltip />} cursor={{ fill: "rgba(108,99,255,0.05)" }} />
          <Legend
            formatter={(value) => (
              <span style={{ fontSize: 11, fontFamily: "Cairo", color: "#8A9BB5" }}>
                {(LABELS as Record<string, string>)[value] ?? value}
              </span>
            )}
          />
          <Bar dataKey="depression" stackId="a" fill={`url(#bar-grad-depression)`} radius={[0, 0, 0, 0]} />
          <Bar dataKey="anxiety" stackId="a" fill={`url(#bar-grad-anxiety)`} />
          <Bar dataKey="stress" stackId="a" fill={`url(#bar-grad-stress)`} radius={[4, 4, 0, 0]} />
        </BarChart>
      </ResponsiveContainer>
    </ChartCard>
  );
}

// ─── 3. Monthly Area Chart ────────────────────────────────────────────────────

function MonthlyAreaChart({ monthlyTrend }: { monthlyTrend: { month: string; count: number }[] }) {
  return (
    <ChartCard
      title="الاتجاه الشهري"
      subtitle="تطور حجم التحليلات على مدار 12 شهراً"
      delay={0.15}
      className="col-span-full"
    >
      <ResponsiveContainer width="100%" height={220}>
        <AreaChart data={monthlyTrend} margin={{ top: 5, right: 10, left: -20, bottom: 5 }}>
          <defs>
            <linearGradient id="area-fill" x1="0" y1="0" x2="0" y2="1">
              <stop offset="5%" stopColor="#6C63FF" stopOpacity={0.35} />
              <stop offset="95%" stopColor="#6C63FF" stopOpacity={0.0} />
            </linearGradient>
          </defs>
          <CartesianGrid strokeDasharray="3 3" stroke="rgba(108,99,255,0.08)" vertical={false} />
          <XAxis
            dataKey="month"
            tick={{ fontSize: 10, fill: "#8A9BB5", fontFamily: "Cairo" }}
            axisLine={false}
            tickLine={false}
          />
          <YAxis
            tick={{ fontSize: 10, fill: "#8A9BB5", fontFamily: "Cairo" }}
            axisLine={false}
            tickLine={false}
          />
          <Tooltip
            content={({ active, payload, label }) => {
              if (!active || !payload?.length) return null;
              return (
                <div className="bg-white dark:bg-navy-900 border border-navy-100 dark:border-navy-700 rounded-xl p-3 shadow-glass-lg text-right">
                  <p className="text-xs font-bold text-navy-600 dark:text-navy-300 mb-1">{label}</p>
                  <p className="text-lg font-extrabold text-violet-600 dark:text-violet-400">
                    {payload[0].value?.toLocaleString("ar-EG")}
                  </p>
                  <p className="text-xs text-navy-400">تحليل</p>
                </div>
              );
            }}
            cursor={{ stroke: "#6C63FF", strokeWidth: 1, strokeDasharray: "4 4" }}
          />
          <Area
            type="monotone"
            dataKey="count"
            stroke="#6C63FF"
            strokeWidth={2.5}
            fill="url(#area-fill)"
            dot={{ r: 3, fill: "#6C63FF", strokeWidth: 0 }}
            activeDot={{ r: 5, fill: "#6C63FF", stroke: "#fff", strokeWidth: 2 }}
            animationDuration={1200}
          />
        </AreaChart>
      </ResponsiveContainer>
    </ChartCard>
  );
}

// ─── 4. Confidence Distribution Horizontal Bar Chart ─────────────────────────

function ConfidenceChart({
  confidenceDistribution,
}: {
  confidenceDistribution: { range: string; count: number }[];
}) {
  const maxCount = Math.max(...confidenceDistribution.map((d) => d.count));

  return (
    <ChartCard
      title="توزيع مستوى الثقة"
      subtitle="عدد التحليلات لكل نطاق من نطاقات الدقة"
      delay={0.2}
    >
      <div className="space-y-3 mt-2">
        {confidenceDistribution.map((item, i) => {
          const pct = (item.count / maxCount) * 100;
          const colors = ["#6C63FF", "#4A90D9", "#52B788", "#E8924A", "#8A9BB5"];
          return (
            <div key={item.range} className="flex items-center gap-3">
              <span className="text-xs font-bold text-navy-600 dark:text-navy-300 w-20 text-right flex-shrink-0">
                {item.range}
              </span>
              <div className="flex-1 h-7 bg-navy-50 dark:bg-navy-900/50 rounded-lg overflow-hidden">
                <motion.div
                  initial={{ width: 0 }}
                  whileInView={{ width: `${pct}%` }}
                  viewport={{ once: true }}
                  transition={{ duration: 0.8, delay: i * 0.1, ease: "easeOut" }}
                  className="h-full rounded-lg flex items-center justify-end px-2.5"
                  style={{
                    background: `linear-gradient(90deg, ${colors[i]}CC, ${colors[i]})`,
                  }}
                >
                  <span className="text-xs font-bold text-white">
                    {item.count.toLocaleString("ar-EG")}
                  </span>
                </motion.div>
              </div>
            </div>
          );
        })}
      </div>
    </ChartCard>
  );
}

// ─── Main Export ──────────────────────────────────────────────────────────────

export function ChartsSection({ stats }: { stats: Statistics }) {
  return (
    <div className="space-y-6">
      {/* Row 1: Pie + Weekly Bar */}
      <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <DistributionPieChart stats={stats} />
        <WeeklyBarChart dailyActivity={stats.dailyActivity} />
      </div>

      {/* Row 2: Monthly Area (full width) */}
      <MonthlyAreaChart monthlyTrend={stats.monthlyTrend} />

      {/* Row 3: Confidence Distribution */}
      <ConfidenceChart confidenceDistribution={stats.confidenceDistribution} />
    </div>
  );
}
