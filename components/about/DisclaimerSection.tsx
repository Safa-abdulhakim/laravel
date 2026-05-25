"use client";

import React from "react";
import { motion } from "framer-motion";
import { AlertTriangle, Heart, Phone } from "lucide-react";

export function DisclaimerSection() {
  return (
    <motion.section
      initial={{ opacity: 0, y: 20 }}
      whileInView={{ opacity: 1, y: 0 }}
      viewport={{ once: true }}
      transition={{ duration: 0.6 }}
      className="pb-20"
    >
      <div className="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/10 border border-amber-200 dark:border-amber-700/40 rounded-3xl p-8">
        <div className="flex items-start gap-4">
          <div className="w-12 h-12 rounded-2xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center shrink-0">
            <AlertTriangle className="w-6 h-6 text-amber-600 dark:text-amber-400" />
          </div>
          <div className="flex-1">
            <h3 className="text-xl font-bold text-amber-800 dark:text-amber-300 mb-3">
              تنبيه مهم — إخلاء المسؤولية
            </h3>
            <div className="space-y-3 text-sm text-amber-900/80 dark:text-amber-200/80 leading-relaxed">
              <p>
                منصة <strong>نبضات</strong> هي أداة بحثية تعليمية تهدف إلى تعزيز
                الوعي بالصحة النفسية، ولا تُعدّ بأي حال من الأحوال بديلاً عن
                التشخيص الطبي أو الاستشارة النفسية المتخصصة.
              </p>
              <p>
                نتائج التحليل التي يُقدمها النظام هي مؤشرات احتمالية مبنية على
                أنماط لغوية، وليست تشخيصاً سريرياً معتمداً.
              </p>
            </div>
          </div>
        </div>
      </div>

      <div className="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div className="flex items-center gap-3 p-4 rounded-xl bg-rose-50 dark:bg-rose-900/15 border border-rose-200 dark:border-rose-700/30">
          <Heart className="w-5 h-5 text-rose-500 shrink-0" />
          <p className="text-sm text-muted-foreground">
            إذا كنت تعاني من أعراض نفسية، تحدث مع شخص تثق به أو متخصص صحي نفسي
          </p>
        </div>
        <div className="flex items-center gap-3 p-4 rounded-xl bg-blue-50 dark:bg-blue-900/15 border border-blue-200 dark:border-blue-700/30">
          <Phone className="w-5 h-5 text-blue-500 shrink-0" />
          <p className="text-sm text-muted-foreground">
            للطوارئ النفسية، تواصل مع أقرب مركز صحي أو مستشفى في منطقتك
          </p>
        </div>
      </div>
    </motion.section>
  );
}
