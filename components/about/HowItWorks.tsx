"use client";

import React from "react";
import { motion } from "framer-motion";
import { Database, Cpu, BarChart3, BrainCircuit } from "lucide-react";

const steps = [
  {
    icon: Database,
    title: "جمع البيانات",
    description:
      "تم جمع آلاف النصوص اليمنية العامية وتصنيفها يدوياً بمساعدة متخصصين في علم النفس الإكلينيكي.",
    color: "text-depression",
    bg: "bg-depression-light dark:bg-depression/10",
    border: "border-depression-medium dark:border-depression/30",
  },
  {
    icon: BrainCircuit,
    title: "تدريب النموذج",
    description:
      "تم تدريب نموذج لغوي كبير (LLM) مبني على Transformer Architecture مع ضبط دقيق على البيانات اليمنية.",
    color: "text-violet-600 dark:text-violet-400",
    bg: "bg-violet-50 dark:bg-violet-900/20",
    border: "border-violet-200 dark:border-violet-700/40",
  },
  {
    icon: Cpu,
    title: "معالجة اللغة الطبيعية",
    description:
      "يستخدم النظام تقنيات NLP متقدمة لفهم السياق والتعبيرات العامية والمصطلحات النفسية اليمنية.",
    color: "text-anxiety",
    bg: "bg-anxiety-light dark:bg-anxiety/10",
    border: "border-anxiety-medium dark:border-anxiety/30",
  },
  {
    icon: BarChart3,
    title: "التصنيف والتقرير",
    description:
      "يُصنِّف النظام النص إلى أحد التصنيفات الثلاثة مع نسب ثقة تفصيلية وكلمات مفتاحية مكتشفة.",
    color: "text-stress",
    bg: "bg-stress-light dark:bg-stress/10",
    border: "border-stress-medium dark:border-stress/30",
  },
];

export function HowItWorks() {
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
          كيف يعمل{" "}
          <span className="gradient-text">الذكاء الاصطناعي؟</span>
        </h2>
        <p className="text-muted-foreground text-lg max-w-2xl mx-auto">
          شرح مبسط لآلية عمل نماذج LLMs ومعالجة اللغة الطبيعية في منصة نبضات
        </p>
      </motion.div>

      <div className="grid grid-cols-1 sm:grid-cols-2 gap-5">
        {steps.map((step, i) => {
          const Icon = step.icon;
          return (
            <motion.div
              key={step.title}
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ delay: i * 0.1, duration: 0.5 }}
              className={`p-6 rounded-2xl border ${step.bg} ${step.border}`}
            >
              <div className={`w-10 h-10 rounded-xl ${step.bg} border ${step.border} flex items-center justify-center mb-4`}>
                <Icon className={`w-5 h-5 ${step.color}`} />
              </div>
              <h3 className="text-lg font-bold mb-2">{step.title}</h3>
              <p className="text-muted-foreground text-sm leading-relaxed">
                {step.description}
              </p>
            </motion.div>
          );
        })}
      </div>

      {/* AI explanation box */}
      <motion.div
        initial={{ opacity: 0, y: 20 }}
        whileInView={{ opacity: 1, y: 0 }}
        viewport={{ once: true }}
        transition={{ delay: 0.4 }}
        className="mt-8 p-6 rounded-2xl bg-gradient-to-br from-navy-50 to-violet-50 dark:from-navy-900/40 dark:to-violet-900/20 border border-navy-200 dark:border-navy-700/40"
      >
        <h3 className="text-lg font-bold mb-3 gradient-text">
          ما هي نماذج LLMs وNLP؟
        </h3>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-muted-foreground leading-relaxed">
          <div>
            <strong className="text-foreground">نماذج اللغة الكبيرة (LLMs):</strong> هي نماذج ذكاء اصطناعي مدربة على كميات ضخمة من النصوص لفهم وتوليد اللغة البشرية بشكل طبيعي. تستخدم بنية Transformer لفهم السياق والعلاقات بين الكلمات.
          </div>
          <div>
            <strong className="text-foreground">معالجة اللغة الطبيعية (NLP):</strong> فرع من الذكاء الاصطناعي يتعامل مع تحليل النصوص البشرية. يشمل تحليل المشاعر، استخراج الكيانات، وتصنيف النصوص — كل هذا يستخدمه نبضات لتحليل الحالة النفسية.
          </div>
        </div>
      </motion.div>
    </section>
  );
}
