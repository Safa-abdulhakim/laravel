import type { Metadata } from "next";
import { TeamSection } from "@/components/about/TeamSection";
import { TechStack } from "@/components/about/TechStack";
import { Timeline } from "@/components/about/Timeline";
import { AboutHeader } from "@/components/about/AboutHeader";
import { HowItWorks } from "@/components/about/HowItWorks";
import { MentalStateCards } from "@/components/about/MentalStateCards";
import { DisclaimerSection } from "@/components/about/DisclaimerSection";

// ─── Metadata ─────────────────────────────────────────────────────────────────

export const metadata: Metadata = {
  title: "عن المشروع",
  description:
    "تعرّف على مشروع نبضات — المنصة الأولى لتحليل الصحة النفسية باللهجة اليمنية باستخدام الذكاء الاصطناعي ومعالجة اللغة الطبيعية.",
};

// ─── Page ─────────────────────────────────────────────────────────────────────

export default function AboutPage() {
  return (
    <div className="min-h-screen bg-gradient-to-br from-slate-50 via-white to-violet-50/20 dark:from-navy-950 dark:via-navy-900 dark:to-navy-800">
      {/* Background decoration */}
      <div className="fixed inset-0 overflow-hidden pointer-events-none -z-10">
        <div className="absolute top-0 left-1/4 w-96 h-96 bg-violet-500/5 dark:bg-violet-500/8 rounded-full blur-3xl" />
        <div className="absolute top-1/3 right-0 w-80 h-80 bg-depression/5 dark:bg-depression/8 rounded-full blur-3xl" />
        <div className="absolute bottom-1/4 left-0 w-72 h-72 bg-stress/5 dark:bg-stress/8 rounded-full blur-3xl" />
      </div>

      <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-24">
        {/* 1. Hero header */}
        <AboutHeader />

        {/* 2. How AI Works */}
        <HowItWorks />

        {/* 3. Mental state cards */}
        <MentalStateCards />

        {/* 4. Team */}
        <TeamSection />

        {/* 5. Tech Stack */}
        <TechStack />

        {/* 6. Timeline */}
        <Timeline />

        {/* 7. Disclaimer */}
        <DisclaimerSection />
      </div>
    </div>
  );
}
