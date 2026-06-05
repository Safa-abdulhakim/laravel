'use client';

import Link from 'next/link';

const objectives = [
  {
    icon: '🎯',
    title: 'الكشف المبكر',
    description: 'تحديد الحالات النفسية في مراحلها الأولى للتدخل المبكر وتقديم الدعم اللازم.',
    color: 'from-rose-400 to-pink-500',
    bg: 'bg-rose-50',
  },
  {
    icon: '🧠',
    title: 'دعم الصحة النفسية',
    description: 'توعية المجتمع بأهمية الصحة النفسية ورفع مستوى الوعي في المجتمع اليمني.',
    color: 'from-violet-400 to-purple-500',
    bg: 'bg-violet-50',
  },
  {
    icon: '📈',
    title: 'دقة عالية',
    description: 'يعتمد النظام على نماذج تعلم آلة مدربة تحقق نسبة دقة مرتفعة في التصنيف.',
    color: 'from-blue-400 to-cyan-500',
    bg: 'bg-blue-50',
  },
  {
    icon: '🌍',
    title: 'خدمة المجتمع',
    description: 'أول نظام متخصص في تحليل اللهجة اليمنية للصحة النفسية، يخدم المجتمع اليمني.',
    color: 'from-teal-400 to-emerald-500',
    bg: 'bg-teal-50',
  },
];

const steps = [
  { num: '01', icon: '✏️', title: 'أدخل النص', desc: 'اكتب أو الصق النص المراد تحليله باللهجة اليمنية' },
  { num: '02', icon: '🔬', title: 'معالجة اللغة', desc: 'يتم تنظيف النص ومعالجته باستخدام تقنيات NLP المتقدمة' },
  { num: '03', icon: '🤖', title: 'التحليل بالذكاء الاصطناعي', desc: 'يحلل النموذج المدرب النص ويستخرج الأنماط اللغوية' },
  { num: '04', icon: '📊', title: 'استقبل النتيجة', desc: 'تظهر نتيجة التصنيف مع نسبة الثقة بشكل فوري' },
];

const teamMembers = [
  { initials: 'سع', name: 'سفاء عبدالحكيم', role: 'قائد الفريق', gradient: 'from-teal-500 to-brand-800' },
  { initials: 'عف', name: 'عضو الفريق 2', role: 'مطور واجهات', gradient: 'from-violet-500 to-purple-700' },
  { initials: 'عث', name: 'عضو الفريق 3', role: 'مهندس بيانات', gradient: 'from-rose-500 to-pink-700' },
];

export default function HomePage() {
  return (
    <div className="min-h-screen">
      {/* ═══════════════════ HERO ═══════════════════ */}
      <section className="hero-bg min-h-[90vh] flex items-center relative overflow-hidden">
        {/* Floating shapes */}
        <div className="floating-shape w-64 h-64 top-10 right-[-5%]" style={{ animationDelay: '0s' }} />
        <div className="floating-shape w-40 h-40 bottom-20 left-[5%]" style={{ animationDelay: '2s' }} />
        <div className="floating-shape w-20 h-20 top-1/2 left-1/3" style={{ animationDelay: '4s' }} />

        <div className="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 py-20 text-center text-white">
          {/* Badge */}
          <div className="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-5 py-2 mb-8 text-sm font-medium">
            <span className="w-2 h-2 bg-teal-400 rounded-full animate-pulse" />
            نظام ذكاء اصطناعي – مشروع تخرج أكاديمي
          </div>

          <h1 className="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-black leading-tight mb-6">
            <span className="gradient-text">محلل اللهجة</span>
            <br />
            <span className="text-white">اليمنية</span>
          </h1>

          <p className="text-white/80 text-lg sm:text-xl max-w-2xl mx-auto leading-relaxed mb-10">
            نظام ذكاء اصطناعي متقدم يحلل النصوص المكتوبة باللهجة اليمنية
            ويصنّف الحالة النفسية تلقائياً باستخدام تقنيات معالجة اللغة الطبيعية.
          </p>

          <div className="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <Link
              href="/analyze"
              className="btn-gradient px-8 py-4 rounded-2xl font-bold text-lg w-full sm:w-auto text-center shadow-teal hover:shadow-brand-lg transition-all duration-300"
            >
              🚀 ابدأ التحليل الآن
            </Link>
            <a
              href="#about"
              className="btn-outline-white px-8 py-4 rounded-2xl font-semibold text-lg w-full sm:w-auto text-center"
            >
              تعرف أكثر ↓
            </a>
          </div>

          {/* Stats row */}
          <div className="mt-16 grid grid-cols-3 gap-4 max-w-lg mx-auto">
            {[
              { num: '4', label: 'تصنيفات نفسية' },
              { num: 'NLP', label: 'معالجة اللغة' },
              { num: 'AI', label: 'ذكاء اصطناعي' },
            ].map(({ num, label }) => (
              <div key={label} className="glass-card p-4 text-center">
                <p className="text-2xl font-black text-white">{num}</p>
                <p className="text-white/60 text-xs mt-1">{label}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* ═══════════════════ ABOUT ═══════════════════ */}
      <section id="about" className="py-20 bg-gradient-to-b from-slate-50 to-white">
        <div className="max-w-5xl mx-auto px-4 sm:px-6">
          <div className="text-center mb-12">
            <h2 className="text-3xl sm:text-4xl font-black text-brand-900 section-title inline-block">
              عن المشروع
            </h2>
            <p className="mt-6 text-slate-600 text-lg max-w-2xl mx-auto leading-relaxed">
              مشروع تخرج أكاديمي يهدف إلى تطوير نظام ذكي لتحليل النصوص العربية
              باللهجة اليمنية وتصنيف الحالة النفسية.
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            {[
              {
                icon: '🎓',
                title: 'مشروع أكاديمي',
                description:
                  'يُعدّ هذا العمل مشروع تخرج تقني يجمع بين علوم الحاسوب ومعالجة اللغة الطبيعية وعلم النفس لخدمة المجتمع اليمني.',
              },
              {
                icon: '🧬',
                title: 'تقنية متقدمة',
                description:
                  'يستخدم النظام نماذج تعلم آلة مدربة على بيانات حقيقية مع معالجة خاصة لخصائص اللهجة اليمنية.',
              },
              {
                icon: '💡',
                title: 'فكرة النظام',
                description:
                  'يُدخل المستخدم نصاً باللهجة اليمنية، فيعالجه النظام ويصنّفه إلى: اكتئاب، قلق، ضغوط نفسية، أو طبيعي.',
              },
              {
                icon: '🌐',
                title: 'واجهة حديثة',
                description:
                  'تم بناء الواجهة بتقنيات Next.js وTailwind CSS مع دعم كامل للغة العربية واتجاه RTL.',
              },
            ].map(({ icon, title, description }) => (
              <div
                key={title}
                className="glass-card-light p-6 card-hover border border-slate-100"
              >
                <div className="flex items-start gap-4">
                  <div className="w-12 h-12 rounded-xl bg-gradient-to-br from-brand-900 to-teal-700 flex items-center justify-center flex-shrink-0 shadow-md">
                    <span className="text-2xl">{icon}</span>
                  </div>
                  <div>
                    <h3 className="font-bold text-brand-900 text-lg mb-2">{title}</h3>
                    <p className="text-slate-600 text-sm leading-relaxed">{description}</p>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* ═══════════════════ HOW IT WORKS ═══════════════════ */}
      <section className="py-20 bg-gradient-to-b from-white to-slate-50">
        <div className="max-w-5xl mx-auto px-4 sm:px-6">
          <div className="text-center mb-12">
            <h2 className="text-3xl sm:text-4xl font-black text-brand-900 section-title inline-block">
              كيف يعمل النظام؟
            </h2>
            <p className="mt-6 text-slate-600 text-lg max-w-xl mx-auto">
              أربع خطوات بسيطة من إدخال النص إلى استقبال النتيجة.
            </p>
          </div>

          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {steps.map(({ num, icon, title, desc }, idx) => (
              <div key={num} className="relative text-center group">
                {/* Connector line (hidden on last item) */}
                {idx < steps.length - 1 && (
                  <div className="hidden lg:block absolute top-10 left-[-20%] w-[40%] h-0.5 bg-gradient-to-r from-teal-300 to-brand-300 z-0" />
                )}
                <div className="relative z-10 glass-card-light p-6 card-hover border border-slate-100">
                  <div className="step-badge mx-auto mb-4">{num}</div>
                  <div className="text-4xl mb-3">{icon}</div>
                  <h3 className="font-bold text-brand-900 mb-2">{title}</h3>
                  <p className="text-slate-500 text-sm leading-relaxed">{desc}</p>
                </div>
              </div>
            ))}
          </div>

          <div className="text-center mt-10">
            <Link
              href="/analyze"
              className="inline-flex items-center gap-2 btn-gradient px-8 py-4 rounded-2xl font-bold text-lg text-white"
            >
              <span>جرّب الآن</span>
              <span className="text-2xl">⚡</span>
            </Link>
          </div>
        </div>
      </section>

      {/* ═══════════════════ OBJECTIVES ═══════════════════ */}
      <section className="py-20 hero-bg relative overflow-hidden">
        <div className="floating-shape w-80 h-80 top-[-10%] left-[-5%]" style={{ animationDelay: '1s' }} />
        <div className="floating-shape w-48 h-48 bottom-[-5%] right-[10%]" style={{ animationDelay: '3s' }} />

        <div className="relative z-10 max-w-5xl mx-auto px-4 sm:px-6">
          <div className="text-center mb-12">
            <h2 className="text-3xl sm:text-4xl font-black text-white section-title inline-block">
              أهداف المشروع
            </h2>
            <p className="mt-6 text-white/70 text-lg max-w-xl mx-auto">
              نسعى من خلال هذا النظام إلى تحقيق أهداف بحثية ومجتمعية.
            </p>
          </div>

          <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
            {objectives.map(({ icon, title, description, bg }) => (
              <div
                key={title}
                className={`glass-card p-6 card-hover`}
              >
                <div className="flex items-start gap-4">
                  <div className={`w-12 h-12 rounded-xl ${bg} flex items-center justify-center flex-shrink-0 shadow-sm`}>
                    <span className="text-2xl">{icon}</span>
                  </div>
                  <div>
                    <h3 className="font-bold text-white text-lg mb-2">{title}</h3>
                    <p className="text-white/70 text-sm leading-relaxed">{description}</p>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* ═══════════════════ TEAM ═══════════════════ */}
      <section id="team" className="py-20 bg-gradient-to-b from-slate-50 to-white">
        <div className="max-w-4xl mx-auto px-4 sm:px-6">
          <div className="text-center mb-12">
            <h2 className="text-3xl sm:text-4xl font-black text-brand-900 section-title inline-block">
              فريق العمل
            </h2>
            <p className="mt-6 text-slate-600 text-lg max-w-xl mx-auto">
              طلاب متخصصون في علوم الحاسوب والذكاء الاصطناعي.
            </p>
          </div>

          <div className="grid grid-cols-1 sm:grid-cols-3 gap-6">
            {teamMembers.map(({ initials, name, role, gradient }) => (
              <div
                key={name}
                className="glass-card-light p-8 card-hover border border-slate-100 text-center"
              >
                <div
                  className={`w-20 h-20 rounded-full bg-gradient-to-br ${gradient} flex items-center justify-center mx-auto mb-4 shadow-lg text-white font-black text-2xl`}
                >
                  {initials}
                </div>
                <h3 className="font-bold text-brand-900 text-lg">{name}</h3>
                <p className="text-teal-600 text-sm font-medium mt-1">{role}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* ═══════════════════ CTA ═══════════════════ */}
      <section className="py-16 bg-gradient-to-r from-brand-900 to-teal-800">
        <div className="max-w-3xl mx-auto px-4 sm:px-6 text-center">
          <h2 className="text-3xl sm:text-4xl font-black text-white mb-4">
            جاهز للتحليل؟
          </h2>
          <p className="text-white/70 text-lg mb-8">
            أدخل نصك الآن واحصل على نتيجة التحليل النفسي فوراً.
          </p>
          <Link
            href="/analyze"
            className="inline-flex items-center gap-3 bg-white text-brand-900 px-10 py-4 rounded-2xl font-black text-lg shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1"
          >
            <span>🚀</span>
            ابدأ التحليل الآن
          </Link>
        </div>
      </section>
    </div>
  );
}
