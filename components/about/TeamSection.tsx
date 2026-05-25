"use client";

import Image from "next/image";
import { motion } from "framer-motion";
import { TEAM_MEMBERS } from "@/lib/constants";

// ─── Card gradient pool (cycled) ─────────────────────────────────────────────

const GRADIENTS = [
  "from-violet-500/10 via-navy-50/60 to-depression/5 dark:from-violet-900/30 dark:via-navy-800 dark:to-depression/10",
  "from-depression/10 via-navy-50/60 to-violet-500/5 dark:from-depression/20 dark:via-navy-800 dark:to-violet-900/20",
  "from-stress/10 via-navy-50/60 to-violet-500/5 dark:from-stress/20 dark:via-navy-800 dark:to-violet-900/20",
  "from-anxiety/10 via-navy-50/60 to-stress/5 dark:from-anxiety/20 dark:via-navy-800 dark:to-stress/10",
];

const DEPT_COLORS: Record<string, string> = {
  "علم النفس والذكاء الاصطناعي":
    "bg-violet-100 text-violet-800 dark:bg-violet-900/40 dark:text-violet-300",
  "Machine Learning & NLP":
    "bg-depression-light text-depression-text dark:bg-depression/20 dark:text-depression",
  "Frontend Development":
    "bg-stress-light text-stress-text dark:bg-stress/20 dark:text-stress",
  "Clinical Psychology":
    "bg-anxiety-light text-anxiety-text dark:bg-anxiety/20 dark:text-anxiety",
};

// ─── Single Team Card ─────────────────────────────────────────────────────────

function TeamCard({
  member,
  index,
}: {
  member: (typeof TEAM_MEMBERS)[number];
  index: number;
}) {
  return (
    <motion.div
      initial={{ opacity: 0, y: 32 }}
      whileInView={{ opacity: 1, y: 0 }}
      viewport={{ once: true, margin: "-40px" }}
      transition={{ duration: 0.6, delay: index * 0.1, ease: [0.22, 1, 0.36, 1] }}
      whileHover={{ y: -6, transition: { duration: 0.25 } }}
      className="group relative"
    >
      {/* Glow on hover */}
      <div className="absolute inset-0 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur-2xl bg-violet-400/20 dark:bg-violet-500/15 pointer-events-none" />

      <div
        className={`relative bg-gradient-to-br ${GRADIENTS[index % GRADIENTS.length]} backdrop-blur-sm border border-white/70 dark:border-navy-700/50 rounded-2xl p-6 shadow-glass group-hover:shadow-glass-xl transition-all duration-300 overflow-hidden`}
      >
        {/* Top pattern */}
        <div className="absolute top-0 right-0 w-32 h-32 rounded-full blur-3xl opacity-20 bg-violet-400 pointer-events-none" />

        {/* Avatar */}
        <div className="relative flex justify-center mb-5">
          <div className="relative">
            <div className="w-20 h-20 rounded-full overflow-hidden ring-4 ring-white dark:ring-navy-700 shadow-navy">
              <Image
                src={member.avatar}
                alt={member.name}
                width={80}
                height={80}
                className="object-cover w-full h-full"
                unoptimized
              />
            </div>
            {/* Online indicator */}
            <span className="absolute bottom-0.5 left-0.5 w-4 h-4 bg-emerald-400 rounded-full ring-2 ring-white dark:ring-navy-800" />
          </div>
        </div>

        {/* Info */}
        <div className="text-center">
          <h3 className="text-base font-extrabold text-navy-900 dark:text-white mb-1">
            {member.name}
          </h3>
          <p className="text-sm font-medium text-navy-500 dark:text-navy-400 mb-3">
            {member.role}
          </p>

          {/* Department badge */}
          <span
            className={`inline-block text-xs font-semibold px-3 py-1 rounded-full mb-4 ${
              DEPT_COLORS[member.department] ??
              "bg-navy-100 text-navy-600 dark:bg-navy-700 dark:text-navy-300"
            }`}
          >
            {member.department}
          </span>

          {/* Bio */}
          <p className="text-xs text-navy-500 dark:text-navy-400 leading-relaxed line-clamp-3">
            {member.bio}
          </p>
        </div>

        {/* Bottom accent */}
        <div className="absolute bottom-0 inset-x-0 h-0.5 bg-gradient-to-l from-violet-500 via-depression to-transparent opacity-60 rounded-b-2xl" />
      </div>
    </motion.div>
  );
}

// ─── Section ──────────────────────────────────────────────────────────────────

export function TeamSection() {
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
        <span className="inline-block text-xs font-bold text-violet-600 dark:text-violet-400 bg-violet-100 dark:bg-violet-900/30 px-3 py-1 rounded-full mb-3">
          الفريق
        </span>
        <h2 className="text-3xl font-extrabold text-navy-900 dark:text-white mb-3">
          فريق العمل
        </h2>
        <p className="text-navy-500 dark:text-navy-400 max-w-xl mx-auto leading-relaxed text-sm">
          مجموعة من الباحثين والمطورين المتخصصين في الذكاء الاصطناعي وعلم النفس يعملون معاً
          لبناء أفضل أداة لتحليل الصحة النفسية باللهجة اليمنية.
        </p>
      </motion.div>

      {/* Grid */}
      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        {TEAM_MEMBERS.map((member, i) => (
          <TeamCard key={member.name} member={member} index={i} />
        ))}
      </div>
    </section>
  );
}
