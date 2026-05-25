"use client";

import { motion } from "framer-motion";
import { HeartPulse, Sparkles, Globe } from "lucide-react";

export function AboutHeader() {
  return (
    <section className="text-center pt-4">
      {/* Floating badge */}
      <motion.div
        initial={{ opacity: 0, y: -12 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ duration: 0.5 }}
        className="inline-flex items-center gap-2 bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300 rounded-full px-4 py-1.5 text-xs font-bold mb-6 shadow-sm"
      >
        <Sparkles className="w-3.5 h-3.5" />
        مشروع بحثي – الذكاء الاصطناعي والصحة النفسية
      </motion.div>

      {/* Main title */}
      <motion.h1
        initial={{ opacity: 0, y: 20 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ duration: 0.6, delay: 0.1 }}
        className="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-navy-900 dark:text-white tracking-tight mb-6"
      >
        عن مشروع{" "}
        <span className="bg-gradient-to-l from-violet-600 via-depression to-violet-500 bg-clip-text text-transparent">
          نبضات
        </span>
      </motion.h1>

      {/* Description paragraphs */}
      <motion.div
        initial={{ opacity: 0, y: 20 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ duration: 0.6, delay: 0.2 }}
        className="max-w-3xl mx-auto space-y-4 text-navy-600 dark:text-navy-300 text-base leading-relaxed"
      >
        <p>
          <strong className="text-navy-800 dark:text-white">نبضات</strong> هي منصة ذكاء اصطناعي
          متخصصة في تحليل النصوص المكتوبة باللهجة اليمنية للكشف المبكر عن الحالات النفسية — اكتئاب،
          قلق، وضغوط نفسية. تأتي هذه المنصة في سياق البحث عن حلول تقنية فعّالة لمعالجة الفجوة
          الكبيرة في خدمات الصحة النفسية في اليمن والمنطقة العربية.
        </p>
        <p>
          يعتمد المشروع على نماذج معالجة اللغة الطبيعية (NLP) ونماذج اللغة الكبيرة (LLMs) المدرَّبة
          خصيصاً على بيانات يمنية محلية تجاوزت{" "}
          <strong className="text-navy-800 dark:text-white">10,000 نص مصنَّف يدوياً</strong> بإشراف
          متخصصين في علم النفس الإكلينيكي. الهدف تقديم أداة دعم مجانية تساعد الأفراد على فهم حالتهم
          النفسية والحصول على توجيه مبكر.
        </p>
        <p>
          يُحدّث النموذج باستمرار بناءً على بيانات مجهولة الهوية ونتائج التحليلات المتراكمة،
          مما يجعل المنصة تتطور وتتحسن مع الزمن لتكون أكثر دقة وشمولاً في خدمة المجتمع اليمني
          والعربي.
        </p>
      </motion.div>

      {/* Stats pills */}
      <motion.div
        initial={{ opacity: 0, y: 16 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ duration: 0.5, delay: 0.35 }}
        className="flex flex-wrap justify-center gap-4 mt-8"
      >
        {[
          { icon: <HeartPulse className="w-4 h-4" />, label: "+10,000 نص تدريبي", color: "text-depression" },
          { icon: <Globe className="w-4 h-4" />, label: "متخصص باللهجة اليمنية", color: "text-violet-600 dark:text-violet-400" },
          { icon: <Sparkles className="w-4 h-4" />, label: "84% دقة متوسطة", color: "text-stress" },
        ].map((item) => (
          <div
            key={item.label}
            className="flex items-center gap-2 bg-white/70 dark:bg-navy-800/50 border border-navy-100/60 dark:border-navy-700/40 rounded-xl px-4 py-2 text-sm shadow-glass"
          >
            <span className={item.color}>{item.icon}</span>
            <span className="font-semibold text-navy-700 dark:text-navy-200">{item.label}</span>
          </div>
        ))}
      </motion.div>
    </section>
  );
}
