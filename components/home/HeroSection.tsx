"use client";

import { useState, useEffect } from "react";
import Link from "next/link";
import { ArrowLeft, Brain, Sparkles, Shield, Zap } from "lucide-react";

const words = ["الاكتئاب", "القلق", "الضغوط النفسية"];

export default function HeroSection() {
  const [currentWord, setCurrentWord] = useState(0);
  const [visible, setVisible] = useState(true);

  useEffect(() => {
    const interval = setInterval(() => {
      setVisible(false);
      setTimeout(() => {
        setCurrentWord((prev) => (prev + 1) % words.length);
        setVisible(true);
      }, 400);
    }, 2500);
    return () => clearInterval(interval);
  }, []);

  const wordColors = ["#6C63FF", "#4ECDC4", "#f59e0b"];

  return (
    <section
      className="relative min-h-screen flex items-center justify-center overflow-hidden pt-24 pb-16"
      id="top"
    >
      {/* Background */}
      <div className="absolute inset-0">
        <div
          className="absolute inset-0"
          style={{
            background: "linear-gradient(135deg, #F5F7FA 0%, #e8ecf8 50%, #ede9fe 100%)",
          }}
        />
        <div className="dark:block hidden absolute inset-0" style={{
          background: "linear-gradient(135deg, #0a0f1e 0%, #0d1535 50%, #110d2e 100%)"
        }} />

        {/* Blobs */}
        <div
          className="absolute -top-20 -right-20 w-96 h-96 rounded-full opacity-20 animate-blob"
          style={{ background: "radial-gradient(circle, #6C63FF, transparent)" }}
        />
        <div
          className="absolute top-1/3 -left-32 w-80 h-80 rounded-full opacity-15 animate-blob"
          style={{
            background: "radial-gradient(circle, #4ECDC4, transparent)",
            animationDelay: "3s",
          }}
        />
        <div
          className="absolute bottom-10 right-1/3 w-64 h-64 rounded-full opacity-10 animate-blob"
          style={{
            background: "radial-gradient(circle, #1E3A5F, transparent)",
            animationDelay: "6s",
          }}
        />

        {/* Grid */}
        <div
          className="absolute inset-0 opacity-[0.03]"
          style={{
            backgroundImage: `linear-gradient(#1E3A5F 1px, transparent 1px), linear-gradient(90deg, #1E3A5F 1px, transparent 1px)`,
            backgroundSize: "60px 60px",
          }}
        />
      </div>

      <div className="relative max-w-7xl mx-auto px-4 sm:px-6 flex flex-col lg:flex-row items-center gap-16">
        {/* Content */}
        <div className="flex-1 text-center lg:text-right">
          <div
            className="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold mb-8"
            style={{
              background: "rgba(108, 99, 255, 0.1)",
              color: "#6C63FF",
              border: "1px solid rgba(108, 99, 255, 0.2)",
            }}
          >
            <Sparkles className="w-4 h-4" />
            مشروع تخرج 2025 — ذكاء اصطناعي
          </div>

          <h1 className="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight mb-6">
            <span className="block" style={{ color: "var(--text)" }}>
              الكلمات أحيانًا تكشف
            </span>
            <span className="block" style={{ color: "var(--text)" }}>
              ما يخفيه
            </span>
            <span className="block gradient-text">الإنسان</span>
          </h1>

          <p
            className="text-lg sm:text-xl mb-4 leading-relaxed max-w-xl mx-auto lg:mx-0"
            style={{ color: "var(--text-muted)" }}
          >
            منصة ذكاء اصطناعي متخصصة في تحليل النصوص المكتوبة باللهجة اليمنية
          </p>

          <div className="flex items-center justify-center lg:justify-end gap-3 mb-10">
            <span style={{ color: "var(--text-muted)" }}>لكشف:</span>
            <span
              className="text-xl font-bold transition-all duration-400"
              style={{
                color: wordColors[currentWord],
                opacity: visible ? 1 : 0,
                transform: visible ? "translateY(0)" : "translateY(8px)",
                transition: "opacity 0.4s ease, transform 0.4s ease",
              }}
            >
              {words[currentWord]}
            </span>
          </div>

          <div className="flex flex-col sm:flex-row items-center justify-center lg:justify-end gap-4">
            <Link href="/analysis" className="btn-primary flex items-center gap-2 text-base">
              <Sparkles className="w-5 h-5" />
              ابدأ التحليل الآن
              <ArrowLeft className="w-4 h-4" />
            </Link>
            <Link
              href="/about"
              className="px-6 py-3 rounded-full font-semibold text-base transition-all duration-300 hover:scale-105"
              style={{
                background: "var(--card)",
                color: "var(--text)",
                boxShadow: "var(--shadow-sm)",
                border: "1px solid var(--border)",
              }}
            >
              اعرف أكثر
            </Link>
          </div>

          {/* Stats mini */}
          <div className="flex items-center justify-center lg:justify-end gap-8 mt-12">
            {[
              { value: "+500", label: "نص محلّل" },
              { value: "3", label: "تصنيفات" },
              { value: "92%", label: "دقة التحليل" },
            ].map((stat) => (
              <div key={stat.label} className="text-center">
                <div className="text-2xl font-black gradient-text">{stat.value}</div>
                <div className="text-xs mt-1" style={{ color: "var(--text-muted)" }}>
                  {stat.label}
                </div>
              </div>
            ))}
          </div>
        </div>

        {/* Visual Card */}
        <div className="flex-1 w-full max-w-lg">
          <div className="relative">
            {/* Glow */}
            <div
              className="absolute inset-0 rounded-3xl blur-2xl opacity-30"
              style={{ background: "linear-gradient(135deg, #6C63FF, #4ECDC4)" }}
            />

            {/* Main card */}
            <div
              className="relative rounded-3xl p-6 shadow-2xl"
              style={{
                background: "var(--card)",
                border: "1px solid var(--border)",
              }}
            >
              <div className="flex items-center gap-3 mb-5">
                <div className="w-8 h-8 rounded-xl gradient-bg flex items-center justify-center">
                  <Brain className="w-4 h-4 text-white" />
                </div>
                <div>
                  <div className="font-bold text-sm" style={{ color: "var(--text)" }}>
                    نتيجة التحليل
                  </div>
                  <div className="text-xs" style={{ color: "var(--text-muted)" }}>
                    اللهجة اليمنية
                  </div>
                </div>
                <div className="mr-auto flex gap-1">
                  {["#ff5f57","#febc2e","#28c840"].map(c => (
                    <div key={c} className="w-3 h-3 rounded-full" style={{ background: c }} />
                  ))}
                </div>
              </div>

              {/* Sample text */}
              <div
                className="rounded-2xl p-4 mb-5 text-sm leading-relaxed"
                style={{ background: "var(--background)", color: "var(--text-muted)" }}
              >
                <span style={{ color: "var(--secondary)", fontWeight: "700" }}>تعبت</span>
                {" "}من كل شي، ما في شي يسعدني، حتى{" "}
                <span style={{ color: "#4ECDC4", fontWeight: "700" }}>النوم</span>
                {" "}ما عاد يجي...
              </div>

              {/* Result badges */}
              <div className="space-y-3">
                <div className="flex items-center justify-between">
                  <span className="text-sm font-semibold" style={{ color: "var(--text)" }}>الاكتئاب</span>
                  <div className="flex items-center gap-3">
                    <div className="w-32 h-2 rounded-full overflow-hidden" style={{ background: "var(--background)" }}>
                      <div className="h-full rounded-full" style={{ width: "78%", background: "#6C63FF" }} />
                    </div>
                    <span className="text-sm font-bold" style={{ color: "#6C63FF" }}>78%</span>
                  </div>
                </div>
                <div className="flex items-center justify-between">
                  <span className="text-sm font-semibold" style={{ color: "var(--text)" }}>القلق</span>
                  <div className="flex items-center gap-3">
                    <div className="w-32 h-2 rounded-full overflow-hidden" style={{ background: "var(--background)" }}>
                      <div className="h-full rounded-full" style={{ width: "15%", background: "#4ECDC4" }} />
                    </div>
                    <span className="text-sm font-bold" style={{ color: "#4ECDC4" }}>15%</span>
                  </div>
                </div>
                <div className="flex items-center justify-between">
                  <span className="text-sm font-semibold" style={{ color: "var(--text)" }}>ضغوط</span>
                  <div className="flex items-center gap-3">
                    <div className="w-32 h-2 rounded-full overflow-hidden" style={{ background: "var(--background)" }}>
                      <div className="h-full rounded-full" style={{ width: "7%", background: "#f59e0b" }} />
                    </div>
                    <span className="text-sm font-bold" style={{ color: "#f59e0b" }}>7%</span>
                  </div>
                </div>
              </div>

              {/* Tags */}
              <div className="flex flex-wrap gap-2 mt-5">
                {["فقدان الشهية", "الإرهاق", "اضطراب النوم"].map((tag) => (
                  <span
                    key={tag}
                    className="text-xs px-3 py-1 rounded-full font-medium"
                    style={{
                      background: "rgba(108, 99, 255, 0.1)",
                      color: "#6C63FF",
                      border: "1px solid rgba(108, 99, 255, 0.2)",
                    }}
                  >
                    {tag}
                  </span>
                ))}
              </div>

              {/* Confidence */}
              <div
                className="mt-4 p-3 rounded-xl flex items-center gap-3"
                style={{ background: "rgba(78, 205, 196, 0.1)" }}
              >
                <Shield className="w-4 h-4" style={{ color: "#4ECDC4" }} />
                <span className="text-sm font-semibold" style={{ color: "#4ECDC4" }}>
                  نسبة الثقة: 92.4%
                </span>
                <Zap className="w-4 h-4 mr-auto" style={{ color: "#f59e0b" }} />
              </div>
            </div>

            {/* Floating badges */}
            <div
              className="absolute -top-4 -left-4 px-4 py-2 rounded-2xl text-xs font-bold shadow-lg animate-float"
              style={{ background: "#6C63FF", color: "white", animationDelay: "0s" }}
            >
              🤖 AI-Powered
            </div>
            <div
              className="absolute -bottom-4 -right-4 px-4 py-2 rounded-2xl text-xs font-bold shadow-lg animate-float"
              style={{ background: "#1E3A5F", color: "white", animationDelay: "2s" }}
            >
              🇾🇪 لهجة يمنية
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
