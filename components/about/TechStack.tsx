"use client";

const techs = [
  { name: "Python", category: "Backend", icon: "🐍", color: "#3b82f6" },
  { name: "FastAPI", category: "API", icon: "⚡", color: "#10b981" },
  { name: "TensorFlow", category: "AI", icon: "🤖", color: "#ff6f00" },
  { name: "Hugging Face", category: "NLP", icon: "🤗", color: "#f59e0b" },
  { name: "Next.js", category: "Frontend", icon: "▲", color: "#000000" },
  { name: "React", category: "Frontend", icon: "⚛", color: "#61dafb" },
  { name: "Tailwind CSS", category: "Styling", icon: "🎨", color: "#06b6d4" },
  { name: "PostgreSQL", category: "Database", icon: "🐘", color: "#336791" },
  { name: "Arabic BERT", category: "NLP Model", icon: "📝", color: "#6C63FF" },
  { name: "Docker", category: "DevOps", icon: "🐳", color: "#0db7ed" },
];

export default function TechStack() {
  return (
    <section className="section-padding" style={{ background: "var(--background)" }}>
      <div className="max-w-7xl mx-auto px-4 sm:px-6">
        <div className="text-center mb-16">
          <div
            className="inline-block px-4 py-1.5 rounded-full text-sm font-semibold mb-4"
            style={{
              background: "rgba(30, 58, 95, 0.08)",
              color: "#1E3A5F",
              border: "1px solid rgba(30, 58, 95, 0.15)",
            }}
          >
            التقنيات المستخدمة
          </div>
          <h2 className="text-3xl sm:text-4xl font-black mb-4" style={{ color: "var(--text)" }}>
            بُني بأحدث <span className="gradient-text">التقنيات</span>
          </h2>
          <p className="text-lg max-w-xl mx-auto" style={{ color: "var(--text-muted)" }}>
            مجموعة متكاملة من الأدوات والتقنيات الحديثة
          </p>
        </div>

        <div className="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
          {techs.map((tech) => (
            <div
              key={tech.name}
              className="rounded-2xl p-5 text-center card-hover"
              style={{
                background: "var(--card)",
                border: "1px solid var(--border)",
                boxShadow: "var(--shadow-sm)",
              }}
            >
              <div className="text-3xl mb-3">{tech.icon}</div>
              <div className="font-bold text-sm mb-1" style={{ color: "var(--text)" }}>
                {tech.name}
              </div>
              <div
                className="text-xs px-2 py-0.5 rounded-full inline-block"
                style={{
                  background: `${tech.color}15`,
                  color: tech.color,
                }}
              >
                {tech.category}
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
