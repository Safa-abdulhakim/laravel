import HeroSection from "@/components/home/HeroSection";
import HowItWorks from "@/components/home/HowItWorks";
import Features from "@/components/home/Features";
import StatsSection from "@/components/home/StatsSection";
import AboutPreview from "@/components/home/AboutPreview";

export default function HomePage() {
  return (
    <>
      <HeroSection />
      <HowItWorks />
      <Features />
      <StatsSection />
      <AboutPreview />
    </>
  );
}
