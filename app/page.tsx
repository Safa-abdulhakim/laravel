import type { Metadata } from "next";
import HeroSection from "@/components/home/HeroSection";
import HowItWorksSection from "@/components/home/HowItWorksSection";
import FeaturesSection from "@/components/home/FeaturesSection";
import StatsSection from "@/components/home/StatsSection";
import { LivePreviewSection } from "@/components/home/LivePreviewSection";

export const metadata: Metadata = {
  title: "نبضات — منصة تحليل الصحة النفسية باللهجة اليمنية",
  description:
    "منصة ذكاء اصطناعي متقدمة لتحليل النصوص المكتوبة باللهجة اليمنية، تكشف الحالة النفسية الأقرب من خلال تقنيات NLP وLLMs المتخصصة.",
};

export default function HomePage() {
  return (
    <>
      <HeroSection />
      <HowItWorksSection />
      <FeaturesSection />
      <StatsSection />
      <LivePreviewSection />
    </>
  );
}
