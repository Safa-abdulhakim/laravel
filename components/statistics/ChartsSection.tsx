"use client";

import {
  PieChart,
  Pie,
  Cell,
  BarChart,
  Bar,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  ResponsiveContainer,
  LineChart,
  Line,
  Legend,
  Area,
  AreaChart,
} from "recharts";

const pieData = [
  { name: "الاكتئاب", value: 47, color: "#6C63FF" },
  { name: "القلق", value: 31, color: "#4ECDC4" },
  { name: "الضغوط النفسية", value: 22, color: "#f59e0b" },
];

const barData = [
  { month: "يناير", اكتئاب: 32, قلق: 18, ضغوط: 12 },
  { month: "فبراير", اكتئاب: 40, قلق: 22, ضغوط: 15 },
  { month: "مارس", اكتئاب: 35, قلق: 28, ضغوط: 19 },
  { month: "أبريل", اكتئاب: 50, قلق: 32, ضغوط: 22 },
  { month: "مايو", اكتئاب: 45, قلق: 38, ضغوط: 28 },
  { month: "يونيو", اكتئاب: 60, قلق: 35, ضغوط: 25 },
];

const lineData = [
  { week: "أ1", دقة: 88 },
  { week: "أ2", دقة: 89 },
  { week: "أ3", دقة: 90 },
  { week: "أ4", دقة: 88 },
  { week: "م1", دقة: 91 },
  { week: "م2", دقة: 92 },
  { week: "م3", دقة: 93 },
  { week: "م4", دقة: 92 },
];

const CustomTooltip = ({ active, payload, label }: any) => {
  if (active && payload && payload.length) {
    return (
      <div
        className="rounded-xl p-3 shadow-xl text-sm"
        style={{
          background: "var(--card)",
          border: "1px solid var(--border)",
          direction: "rtl",
        }}
      >
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
const renderCustomLabel = ({ cx, cy, midAngle, innerRadius, outerRadius, percent, name }: any) => {
  const radius = innerRadius + (outerRadius - innerRadius) * 0.5;
  const x = cx + radius * Math.cos(-midAngle * RADIAN);
  const y = cy + radius * Math.sin(-midAngle * RADIAN);
  return (
    <text x={x} y={y} fill="white" textAnchor="middle" dominantBaseline="central" fontSize={13} fontWeight="bold">
      {`${(percent * 100).toFixed(0)}%`}
    </text>
  );
};

export default function ChartsSection() {
  return (
    <div className="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
      {/* Pie Chart */}
      <div
        className="rounded-2xl p-6"
        style={{ background: "var(--card)", border: "1px solid var(--border)", boxShadow: "var(--shadow-sm)" }}
      >
        <h3 className="font-bold text-lg mb-6" style={{ color: "var(--text)" }}>
          توزيع التصنيفات
        </h3>
        <div className="flex flex-col sm:flex-row items-center gap-6">
          <ResponsiveContainer width={200} height={200}>
            <PieChart>
              <Pie
                data={pieData}
                cx="50%"
                cy="50%"
                outerRadius={90}
                innerRadius={50}
                dataKey="value"
                labelLine={false}
                label={renderCustomLabel}
              >
                {pieData.map((entry, index) => (
                  <Cell key={index} fill={entry.color} />
                ))}
              </Pie>
              <Tooltip content={<CustomTooltip />} />
            </PieChart>
          </ResponsiveContainer>
          <div className="space-y-3 flex-1">
            {pieData.map((item) => (
              <div key={item.name} className="flex items-center justify-between">
                <div className="flex items-center gap-2">
                  <div className="w-3 h-3 rounded-full" style={{ background: item.color }} />
                  <span className="text-sm font-medium" style={{ color: "var(--text)" }}>
                    {item.name}
                  </span>
                </div>
                <span className="text-sm font-bold" style={{ color: item.color }}>
                  {item.value}%
                </span>
              </div>
            ))}
          </div>
        </div>
      </div>

      {/* Accuracy Line Chart */}
      <div
        className="rounded-2xl p-6"
        style={{ background: "var(--card)", border: "1px solid var(--border)", boxShadow: "var(--shadow-sm)" }}
      >
        <h3 className="font-bold text-lg mb-6" style={{ color: "var(--text)" }}>
          دقة النموذج عبر الزمن
        </h3>
        <ResponsiveContainer width="100%" height={220}>
          <AreaChart data={lineData}>
            <defs>
              <linearGradient id="accuracyGrad" x1="0" y1="0" x2="0" y2="1">
                <stop offset="5%" stopColor="#6C63FF" stopOpacity={0.3} />
                <stop offset="95%" stopColor="#6C63FF" stopOpacity={0} />
              </linearGradient>
            </defs>
            <CartesianGrid strokeDasharray="3 3" stroke="var(--border)" />
            <XAxis dataKey="week" tick={{ fontSize: 12, fill: "var(--text-muted)" }} />
            <YAxis
              domain={[85, 95]}
              tick={{ fontSize: 12, fill: "var(--text-muted)" }}
              tickFormatter={(v) => `${v}%`}
            />
            <Tooltip content={<CustomTooltip />} />
            <Area
              type="monotone"
              dataKey="دقة"
              stroke="#6C63FF"
              strokeWidth={2.5}
              fill="url(#accuracyGrad)"
              dot={{ fill: "#6C63FF", r: 4 }}
              activeDot={{ r: 6, fill: "#6C63FF" }}
            />
          </AreaChart>
        </ResponsiveContainer>
      </div>

      {/* Bar Chart - Full Width */}
      <div
        className="rounded-2xl p-6 lg:col-span-2"
        style={{ background: "var(--card)", border: "1px solid var(--border)", boxShadow: "var(--shadow-sm)" }}
      >
        <h3 className="font-bold text-lg mb-6" style={{ color: "var(--text)" }}>
          التحليلات الشهرية حسب التصنيف
        </h3>
        <ResponsiveContainer width="100%" height={260}>
          <BarChart data={barData} barGap={4}>
            <CartesianGrid strokeDasharray="3 3" stroke="var(--border)" />
            <XAxis dataKey="month" tick={{ fontSize: 12, fill: "var(--text-muted)" }} />
            <YAxis tick={{ fontSize: 12, fill: "var(--text-muted)" }} />
            <Tooltip content={<CustomTooltip />} />
            <Legend
              wrapperStyle={{ fontSize: "13px", paddingTop: "12px", direction: "rtl" }}
            />
            <Bar dataKey="اكتئاب" fill="#6C63FF" radius={[4, 4, 0, 0]} />
            <Bar dataKey="قلق" fill="#4ECDC4" radius={[4, 4, 0, 0]} />
            <Bar dataKey="ضغوط" fill="#f59e0b" radius={[4, 4, 0, 0]} />
          </BarChart>
        </ResponsiveContainer>
      </div>
    </div>
  );
}
