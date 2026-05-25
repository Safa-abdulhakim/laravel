"use client";

import {
  PieChart, Pie, Cell,
  BarChart, Bar, XAxis, YAxis, CartesianGrid, Tooltip,
  ResponsiveContainer, Legend, AreaChart, Area,
} from "recharts";
import type { StatsData } from "@/lib/mockData";

const PIE_COLORS = ["#6C63FF", "#4ECDC4", "#f59e0b"];

const CustomTooltip = ({ active, payload, label }: any) => {
  if (active && payload && payload.length) {
    return (
      <div className="rounded-xl p-3 shadow-xl text-sm"
        style={{ background: "var(--card)", border: "1px solid var(--border)", direction: "rtl" }}>
        <div className="font-bold mb-2" style={{ color: "var(--text)" }}>{label}</div>
        {payload.map((entry: any) => (
          <div key={entry.name} className="flex items-center gap-2">
            <div className="w-2 h-2 rounded-full" style={{ background: entry.color }} />
            <span style={{ color: "var(--text-muted)" }}>{entry.name}: </span>
            <span className="font-bold" style={{ color: entry.color }}>{entry.value}</span>
          </div>
        ))}
      </div>
    );
  }
  return null;
};

const RADIAN = Math.PI / 180;
const renderCustomLabel = ({ cx, cy, midAngle, innerRadius, outerRadius, percent }: any) => {
  const radius = innerRadius + (outerRadius - innerRadius) * 0.5;
  const x = cx + radius * Math.cos(-midAngle * RADIAN);
  const y = cy + radius * Math.sin(-midAngle * RADIAN);
  return (
    <text x={x} y={y} fill="white" textAnchor="middle" dominantBaseline="central" fontSize={13} fontWeight="bold">
      {`${(percent * 100).toFixed(0)}%`}
    </text>
  );
};

interface Props {
  stats: StatsData;
}

export default function ChartsSection({ stats }: Props) {
  const pieData = [
    { name: "الاكتئاب", value: stats.classifications.depression },
    { name: "القلق",    value: stats.classifications.anxiety    },
    { name: "الضغوط",  value: stats.classifications.stress     },
  ];

  return (
    <div className="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
      {/* Pie Chart */}
      <div className="rounded-2xl p-6"
        style={{ background: "var(--card)", border: "1px solid var(--border)", boxShadow: "var(--shadow-sm)" }}>
        <h3 className="font-bold text-lg mb-6" style={{ color: "var(--text)" }}>توزيع التصنيفات</h3>
        <div className="flex flex-col sm:flex-row items-center gap-6">
          <ResponsiveContainer width={200} height={200}>
            <PieChart>
              <Pie data={pieData} cx="50%" cy="50%" outerRadius={90} innerRadius={50}
                dataKey="value" labelLine={false} label={renderCustomLabel}>
                {pieData.map((_, i) => <Cell key={i} fill={PIE_COLORS[i]} />)}
              </Pie>
              <Tooltip content={<CustomTooltip />} />
            </PieChart>
          </ResponsiveContainer>
          <div className="space-y-3 flex-1">
            {pieData.map((item, i) => (
              <div key={item.name} className="flex items-center justify-between">
                <div className="flex items-center gap-2">
                  <div className="w-3 h-3 rounded-full" style={{ background: PIE_COLORS[i] }} />
                  <span className="text-sm font-medium" style={{ color: "var(--text)" }}>{item.name}</span>
                </div>
                <span className="text-sm font-bold" style={{ color: PIE_COLORS[i] }}>
                  {stats.total_analyses > 0
                    ? `${Math.round((item.value / stats.total_analyses) * 100)}%`
                    : "0%"}
                </span>
              </div>
            ))}
          </div>
        </div>
      </div>

      {/* Area Chart - دقة النموذج */}
      <div className="rounded-2xl p-6"
        style={{ background: "var(--card)", border: "1px solid var(--border)", boxShadow: "var(--shadow-sm)" }}>
        <h3 className="font-bold text-lg mb-6" style={{ color: "var(--text)" }}>دقة النموذج عبر الزمن</h3>
        <ResponsiveContainer width="100%" height={220}>
          <AreaChart data={stats.accuracy_history}>
            <defs>
              <linearGradient id="accuracyGrad" x1="0" y1="0" x2="0" y2="1">
                <stop offset="5%"  stopColor="#6C63FF" stopOpacity={0.3} />
                <stop offset="95%" stopColor="#6C63FF" stopOpacity={0}   />
              </linearGradient>
            </defs>
            <CartesianGrid strokeDasharray="3 3" stroke="var(--border)" />
            <XAxis dataKey="week" tick={{ fontSize: 12, fill: "var(--text-muted)" }} />
            <YAxis domain={[80, 100]} tick={{ fontSize: 12, fill: "var(--text-muted)" }}
              tickFormatter={(v) => `${v}%`} />
            <Tooltip content={<CustomTooltip />} />
            <Area type="monotone" dataKey="accuracy" stroke="#6C63FF" strokeWidth={2.5}
              fill="url(#accuracyGrad)" dot={{ fill: "#6C63FF", r: 4 }}
              activeDot={{ r: 6, fill: "#6C63FF" }} name="الدقة" />
          </AreaChart>
        </ResponsiveContainer>
      </div>

      {/* Bar Chart - عرض كامل */}
      <div className="rounded-2xl p-6 lg:col-span-2"
        style={{ background: "var(--card)", border: "1px solid var(--border)", boxShadow: "var(--shadow-sm)" }}>
        <h3 className="font-bold text-lg mb-6" style={{ color: "var(--text)" }}>
          التحليلات الشهرية حسب التصنيف
        </h3>
        <ResponsiveContainer width="100%" height={260}>
          <BarChart data={stats.monthly_data} barGap={4}>
            <CartesianGrid strokeDasharray="3 3" stroke="var(--border)" />
            <XAxis dataKey="month" tick={{ fontSize: 12, fill: "var(--text-muted)" }} />
            <YAxis tick={{ fontSize: 12, fill: "var(--text-muted)" }} />
            <Tooltip content={<CustomTooltip />} />
            <Legend wrapperStyle={{ fontSize: "13px", paddingTop: "12px", direction: "rtl" }} />
            <Bar dataKey="depression" name="اكتئاب" fill="#6C63FF" radius={[4,4,0,0]} />
            <Bar dataKey="anxiety"    name="قلق"    fill="#4ECDC4" radius={[4,4,0,0]} />
            <Bar dataKey="stress"     name="ضغوط"   fill="#f59e0b" radius={[4,4,0,0]} />
          </BarChart>
        </ResponsiveContainer>
      </div>
    </div>
  );
}
