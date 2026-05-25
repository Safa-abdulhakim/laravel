"use client";

import { motion } from "framer-motion";
import { TECH_STACK } from "@/lib/constants";

// ─── Category metadata ────────────────────────────────────────────────────────

const CATEGORY_META: Record<
  string,
  { label: string; icon: string; order: number; accentColor: string }
> = {
  "AI/ML": {
    label: "الذكاء الاصطناعي وتعلّم الآلة",
    icon: "🧠",
    order: 1,
    accentColor: "#6C63FF",
  },
  Backend: {
    label: "الخادم والـ API",
    icon: "⚙️",
    order: 2,
    accentColor: "#52B788",
  },
  Frontend: {
    label: "الواجهة الأمامية",
    icon: "🎨",
    order: 3,
    accentColor: "#4A90D9",
  },
  Database: {
    label: "قواعد البيانات",
    icon: "🗄️",
    order: 4,
    accentColor: "#E8924A",
  },
  DevOps: {
    label: "النشر والبنية التحتية",
    icon: "🚀",
    order: 5,
    accentColor: "#8A9BB5",
  },
  Hosting: {
    label: "الاستضافة",
    icon: "☁️",
    order: 6,
    accentColor: "#8A9BB5",
  },
};

// ─── Group tech by category ───────────────────────────────────────────────────

function groupByCategory(
  stack: typeof TECH_STACK
): Record<string, typeof TECH_STACK> {
  return stack.reduce(
    (acc, tech) => {
      if (!acc[tech.category]) acc[tech.category] = [];
      acc[tech.category].push(tech);
      return acc;
    },
    {} as Record<string, typeof TECH_STACK>
  );
}

// ─── Tech Badge ───────────────────────────────────────────────────────────────

function TechBadge({
  tech,
  delay,
}: {
  tech: (typeof TECH_STACK)[number];
  delay: number;
}) {
  return (
    <motion.span
      initial={{ opacity: 0, scale: 0.8 }}
      whileInView={{ opacity: 1, scale: 1 }}
      viewport={{ once: true }}
      transition={{ duration: 0.35, delay, ease: "easeOut" }}
      whileHover={{ scale: 1.08, y: -2, transition: { duration: 0.15 } }}
      className={`inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-sm font-semibold cursor-default select-none shadow-sm ${tech.color}`}
    >
      {tech.name}
    </motion.span>
  );
}

// ─── Category Group ───────────────────────────────────────────────────────────

function CategoryGroup({
  category,
  techs,
  index,
}: {
  category: string;
  techs: typeof TECH_STACK;
  index: number;
}) {
  const meta = CATEGORY_META[category] ?? {
    label: category,
    icon: "🔧",
    order: 99,
    accentColor: "#8A9BB5",
  };

  return (
    <motion.div
      initial={{ opacity: 0, y: 20 }}
      whileInView={{ opacity: 1, y: 0 }}
      viewport={{ once: true }}
      transition={{ duration: 0.5, delay: index * 0.08 }}
      className="bg-white/60 dark:bg-navy-800/50 backdrop-blur-sm border border-white/60 dark:border-navy-700/50 rounded-2xl p-5 shadow-glass"
    >
      {/* Category header */}
      <div className="flex items-center gap-2 mb-4">
        <span
          className="w-8 h-8 rounded-xl flex items-center justify-center text-base shadow-sm flex-shrink-0"
          style={{ backgroundColor: `${meta.accentColor}22`, border: `1.5px solid ${meta.accentColor}40` }}
        >
          {meta.icon}
        </span>
        <div>
          <p className="text-xs text-navy-400 dark:text-navy-500">{category}</p>
          <h4 className="text-sm font-bold text-navy-800 dark:text-white leading-tight">
            {meta.label}
          </h4>
        </div>
        <span
          className="mr-auto text-xs font-bold px-2 py-0.5 rounded-full"
          style={{
            backgroundColor: `${meta.accentColor}18`,
            color: meta.accentColor,
          }}
        >
          {techs.length}
        </span>
      </div>

      {/* Badges */}
      <div className="flex flex-wrap gap-2">
        {techs.map((tech, i) => (
          <TechBadge key={tech.name} tech={tech} delay={0.05 * i} />
        ))}
      </div>
    </motion.div>
  );
}

// ─── Section ──────────────────────────────────────────────────────────────────

export function TechStack() {
  const grouped = groupByCategory(TECH_STACK);
  const sortedCategories = Object.keys(grouped).sort(
    (a, b) => (CATEGORY_META[a]?.order ?? 99) - (CATEGORY_META[b]?.order ?? 99)
  );

  return (
    <section>
      {/* Header */}
      <motion.div
        initial={{ opacity: 0, y: 20 }}
        whileInView={{ opacity: 1, y: 0 }}
        viewport={{ once: true }}
        transition={{ duration: 0.5 }}
        className="text-center mb-10"
      >
        <span className="inline-block text-xs font-bold text-depression-text dark:text-depression bg-depression-light dark:bg-depression/20 px-3 py-1 rounded-full mb-3">
          التقنيات
        </span>
        <h2 className="text-3xl font-extrabold text-navy-900 dark:text-white mb-3">
          التقنيات المستخدمة
        </h2>
        <p className="text-navy-500 dark:text-navy-400 max-w-xl mx-auto leading-relaxed text-sm">
          مزيج من أحدث التقنيات في مجالات الذكاء الاصطناعي، معالجة اللغة الطبيعية، وتطوير الويب
          لبناء منصة احترافية وموثوقة.
        </p>
      </motion.div>

      {/* Category grid */}
      <div className="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
        {sortedCategories.map((cat, i) => (
          <CategoryGroup
            key={cat}
            category={cat}
            techs={grouped[cat]}
            index={i}
          />
        ))}
      </div>

      {/* Total count */}
      <motion.p
        initial={{ opacity: 0 }}
        whileInView={{ opacity: 1 }}
        viewport={{ once: true }}
        transition={{ delay: 0.5 }}
        className="text-center text-xs text-navy-400 dark:text-navy-500 mt-6"
      >
        {TECH_STACK.length} تقنية موزّعة على {sortedCategories.length} مجالات
      </motion.p>
    </section>
  );
}
