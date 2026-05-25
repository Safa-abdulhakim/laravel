"use client";

import { GitFork, Link2, Mail } from "lucide-react";

const team = [
  {
    name: "أحمد محمد الرجحي",
    role: "قائد المشروع & مطور AI",
    description: "مسؤول عن تصميم نماذج التعلم الآلي وتطوير واجهة برمجة التطبيقات",
    avatar: "أ",
    gradient: "linear-gradient(135deg, #6C63FF, #8b85ff)",
    skills: ["Python", "NLP", "TensorFlow", "FastAPI"],
  },
  {
    name: "فاطمة علي الشرعبي",
    role: "مطورة Frontend",
    description: "مسؤولة عن تصميم وتطوير واجهة المستخدم وتجربة المستخدم",
    avatar: "ف",
    gradient: "linear-gradient(135deg, #4ECDC4, #7eddd8)",
    skills: ["React", "Next.js", "Tailwind", "Figma"],
  },
  {
    name: "عمر عبدالله الحداد",
    role: "مهندس البيانات",
    description: "مسؤول عن جمع البيانات وتنظيفها وإعداد مجموعات التدريب",
    avatar: "ع",
    gradient: "linear-gradient(135deg, #1E3A5F, #2a4f80)",
    skills: ["Data Science", "Pandas", "SQL", "Arabic NLP"],
  },
  {
    name: "سارة حسن المقطري",
    role: "باحثة نفسية",
    description: "المستشارة النفسية للمشروع، وضعت معايير التصنيف والتحقق من النتائج",
    avatar: "س",
    gradient: "linear-gradient(135deg, #f59e0b, #fbbf24)",
    skills: ["علم النفس", "التحقق السريري", "تحليل البيانات"],
  },
];

export default function TeamSection() {
  return (
    <section className="section-padding" style={{ background: "var(--background)" }}>
      <div className="max-w-7xl mx-auto px-4 sm:px-6">
        <div className="text-center mb-16">
          <div
            className="inline-block px-4 py-1.5 rounded-full text-sm font-semibold mb-4"
            style={{
              background: "rgba(108, 99, 255, 0.1)",
              color: "#6C63FF",
              border: "1px solid rgba(108, 99, 255, 0.2)",
            }}
          >
            فريق العمل
          </div>
          <h2 className="text-3xl sm:text-4xl font-black mb-4" style={{ color: "var(--text)" }}>
            العقول خلف <span className="gradient-text">وجدان</span>
          </h2>
          <p className="text-lg max-w-xl mx-auto" style={{ color: "var(--text-muted)" }}>
            فريق متكامل يجمع بين الخبرات التقنية والمعرفة النفسية
          </p>
        </div>

        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          {team.map((member) => (
            <div
              key={member.name}
              className="rounded-2xl p-6 text-center card-hover"
              style={{
                background: "var(--card)",
                border: "1px solid var(--border)",
                boxShadow: "var(--shadow-sm)",
              }}
            >
              {/* Avatar */}
              <div
                className="w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-4 text-3xl font-black text-white shadow-lg"
                style={{ background: member.gradient }}
              >
                {member.avatar}
              </div>

              <h3 className="font-black text-base mb-1" style={{ color: "var(--text)" }}>
                {member.name}
              </h3>
              <div
                className="text-xs font-semibold px-3 py-1 rounded-full inline-block mb-3"
                style={{
                  background: "rgba(108,99,255,0.1)",
                  color: "#6C63FF",
                }}
              >
                {member.role}
              </div>
              <p className="text-sm leading-relaxed mb-4" style={{ color: "var(--text-muted)" }}>
                {member.description}
              </p>

              {/* Skills */}
              <div className="flex flex-wrap justify-center gap-1.5 mb-5">
                {member.skills.map((skill) => (
                  <span
                    key={skill}
                    className="text-xs px-2.5 py-1 rounded-lg font-medium"
                    style={{
                      background: "var(--background)",
                      color: "var(--text-muted)",
                    }}
                  >
                    {skill}
                  </span>
                ))}
              </div>

              {/* Social */}
              <div className="flex justify-center gap-2">
                {[GitFork, Link2, Mail].map((Icon, i) => (
                  <button
                    key={i}
                    className="w-8 h-8 rounded-lg flex items-center justify-center transition-all hover:scale-110"
                    style={{
                      background: "var(--background)",
                      color: "var(--text-muted)",
                    }}
                  >
                    <Icon className="w-3.5 h-3.5" />
                  </button>
                ))}
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
