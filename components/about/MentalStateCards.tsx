"use client";

import React from "react";
import { motion } from "framer-motion";
import { MENTAL_STATES } from "@/lib/constants";

export function MentalStateCards() {
  return (
    <section>
      <motion.div
        initial={{ opacity: 0, y: 20 }}
        whileInView={{ opacity: 1, y: 0 }}
        viewport={{ once: true }}
        transition={{ duration: 0.6 }}
        className="text-center mb-12"
      >
        <h2 className="text-3xl sm:text-4xl font-black mb-4">
          التصنيفات{" "}
          <span className="gradient-text">النفسية</span>
        </h2>
        <p className="text-muted-foreground text-lg max-w-2xl mx-auto">
          يُحلِّل نبضات النصوص ويُصنِّفها في إحدى هذه الحالات الثلاث
        </p>
      </motion.div>

      <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
        {Object.values(MENTAL_STATES).map((state, i) => {
          const colorMap: Record<string, { card: string; badge: string; icon: string }> = {
            depression: {
              card: "from-depression-light to-white dark:from-depression/10 dark:to-navy-800/30 border-depression-medium dark:border-depression/30",
              badge: "bg-depression text-white",
              icon: "🌧",
            },
            anxiety: {
              card: "from-anxiety-light to-white dark:from-anxiety/10 dark:to-navy-800/30 border-anxiety-medium dark:border-anxiety/30",
              badge: "bg-anxiety text-white",
              icon: "⚡",
            },
            stress: {
              card: "from-stress-light to-white dark:from-stress/10 dark:to-navy-800/30 border-stress-medium dark:border-stress/30",
              badge: "bg-stress text-white",
              icon: "🌿",
            },
          };
          const cfg = colorMap[state.id];
          return (
            <motion.div
              key={state.id}
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ delay: i * 0.1 }}
              className={`p-6 rounded-2xl bg-gradient-to-br border ${cfg.card} shadow-glass`}
            >
              <div className="flex items-center gap-3 mb-4">
                <span className="text-4xl">{cfg.icon}</span>
                <div>
                  <span className={`px-3 py-1 rounded-full text-sm font-bold ${cfg.badge}`}>
                    {state.label}
                  </span>
                  <p className="text-xs text-muted-foreground mt-1">{state.labelEn}</p>
                </div>
              </div>
              <p className="text-sm text-muted-foreground leading-relaxed mb-4">
                {state.description}
              </p>
              <div>
                <p className="text-xs font-semibold text-foreground/60 mb-2 uppercase tracking-wide">
                  الأعراض الشائعة
                </p>
                <div className="flex flex-wrap gap-1.5">
                  {state.symptoms.map((s) => (
                    <span
                      key={s}
                      className="px-2 py-0.5 rounded-md text-xs bg-white/60 dark:bg-white/5 border border-border text-muted-foreground"
                    >
                      {s}
                    </span>
                  ))}
                </div>
              </div>
            </motion.div>
          );
        })}
      </div>
    </section>
  );
}
