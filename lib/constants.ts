export const SITE_NAME = "نبضات - منصة تحليل الصحة النفسية";
export const SITE_DESCRIPTION =
  "منصة ذكاء اصطناعي متخصصة في تحليل النصوص المكتوبة باللهجة اليمنية للكشف المبكر عن الحالات النفسية";

export const NAV_LINKS = [
  { href: "/", label: "الرئيسية" },
  { href: "/analysis", label: "تحليل النص" },
  { href: "/statistics", label: "الإحصائيات" },
  { href: "/about", label: "عن المشروع" },
];

export const MENTAL_STATES = {
  depression: {
    id: "depression",
    label: "اكتئاب",
    labelEn: "Depression",
    color: "#4A90D9",
    lightBg: "bg-depression-light",
    textColor: "text-depression-text",
    borderColor: "border-depression-medium",
    gradientFrom: "#4A90D9",
    gradientTo: "#2A6FAE",
    description:
      "شعور مستمر بالحزن والفراغ وفقدان الاهتمام بالأنشطة اليومية.",
    icon: "🌧",
    symptoms: ["حزن", "فراغ", "إرهاق", "يأس", "عزلة", "بكاء", "تعب"],
  },
  anxiety: {
    id: "anxiety",
    label: "قلق",
    labelEn: "Anxiety",
    color: "#E8924A",
    lightBg: "bg-anxiety-light",
    textColor: "text-anxiety-text",
    borderColor: "border-anxiety-medium",
    gradientFrom: "#E8924A",
    gradientTo: "#BF6520",
    description:
      "شعور متكرر بالخوف والتوتر والقلق المفرط من أحداث المستقبل.",
    icon: "⚡",
    symptoms: ["خوف", "توتر", "قلق", "ارتعاش", "أرق", "تشتت", "ضيق"],
  },
  stress: {
    id: "stress",
    label: "ضغوط نفسية",
    labelEn: "Stress",
    color: "#52B788",
    lightBg: "bg-stress-light",
    textColor: "text-stress-text",
    borderColor: "border-stress-medium",
    gradientFrom: "#52B788",
    gradientTo: "#2A8A5E",
    description:
      "استجابة طبيعية للضغوط اليومية والمواقف الحياتية المرهقة.",
    icon: "🌿",
    symptoms: ["ضغط", "إرهاق", "متعب", "مشغول", "ضايق", "طفشان", "ملول"],
  },
} as const;

export type MentalStateKey = keyof typeof MENTAL_STATES;

export const FEATURES = [
  {
    icon: "Brain",
    title: "تحليل عميق بالذكاء الاصطناعي",
    description:
      "نماذج LLMs متقدمة مدربة خصيصاً على اللهجة اليمنية لتحليل دقيق للحالة النفسية",
    color: "text-violet-500",
    bg: "bg-violet-50 dark:bg-violet-900/20",
  },
  {
    icon: "Shield",
    title: "الخصوصية أولاً",
    description:
      "نصوصك لا تُحفظ — نحفظ النتائج الإحصائية فقط بشكل مجهول تام لضمان خصوصيتك",
    color: "text-navy-600 dark:text-navy-300",
    bg: "bg-navy-50 dark:bg-navy-900/30",
  },
  {
    icon: "Zap",
    title: "تحليل فوري",
    description:
      "نتائج دقيقة خلال ثوانٍ مع مؤشرات ثقة عالية ورؤى تفصيلية للأعراض المكتشفة",
    color: "text-stress",
    bg: "bg-stress-light dark:bg-stress/10",
  },
  {
    icon: "BarChart3",
    title: "لوحة إحصائيات متكاملة",
    description:
      "رؤى بيانية شاملة حول أنماط الحالات النفسية والكلمات الأكثر تكراراً",
    color: "text-anxiety",
    bg: "bg-anxiety-light dark:bg-anxiety/10",
  },
  {
    icon: "Globe",
    title: "متخصص باللهجة اليمنية",
    description:
      "النظام الأول من نوعه المتخصص في تحليل النصوص النفسية باللهجة العامية اليمنية",
    color: "text-depression",
    bg: "bg-depression-light dark:bg-depression/10",
  },
  {
    icon: "Layers",
    title: "تقنيات NLP متقدمة",
    description:
      "معالجة اللغة الطبيعية مع تحليل السياق والمشاعر وتمييز الكلمات المفتاحية",
    color: "text-violet-500",
    bg: "bg-violet-50 dark:bg-violet-900/20",
  },
];

export const TEAM_MEMBERS = [
  {
    name: "أ. صفاء عبدالحكيم",
    role: "قائد المشروع وباحث رئيسي",
    department: "علم النفس والذكاء الاصطناعي",
    avatar: "https://api.dicebear.com/9.x/avataaars/svg?seed=Safa&backgroundColor=b6e3f4",
    bio: "متخصص في بناء نماذج تحليل المشاعر والصحة النفسية باستخدام الذكاء الاصطناعي",
  },
  {
    name: "م. محمد الأمين",
    role: "مهندس تعلم الآلة",
    department: "Machine Learning & NLP",
    avatar: "https://api.dicebear.com/9.x/avataaars/svg?seed=Mohammed&backgroundColor=d1d4f9",
    bio: "خبير في نماذج اللغة الكبيرة (LLMs) ومعالجة اللغة العربية الطبيعية",
  },
  {
    name: "أ. ريم الحداد",
    role: "مطورة الواجهات",
    department: "Frontend Development",
    avatar: "https://api.dicebear.com/9.x/avataaars/svg?seed=Reem&backgroundColor=ffd5dc",
    bio: "متخصصة في تصميم وتطوير واجهات مستخدم احترافية لمنصات الذكاء الاصطناعي",
  },
  {
    name: "د. عبدالله المقرمي",
    role: "مستشار علم النفس",
    department: "Clinical Psychology",
    avatar: "https://api.dicebear.com/9.x/avataaars/svg?seed=Abdullah&backgroundColor=c0aede",
    bio: "دكتوراه في علم النفس الإكلينيكي، متخصص في الاضطرابات النفسية اليمنية",
  },
];

export const HOW_IT_WORKS_STEPS = [
  {
    step: "01",
    title: "اكتب ما تشعر به",
    description:
      "أدخل نصاً بأي طول باللهجة اليمنية يعبّر عما تحس به أو مررت به",
    icon: "PenLine",
    color: "from-violet-500 to-navy-600",
  },
  {
    step: "02",
    title: "معالجة بالذكاء الاصطناعي",
    description:
      "يقوم النظام بتحليل النص باستخدام نماذج NLP + LLMs متخصصة باللغة العربية",
    icon: "Cpu",
    color: "from-navy-500 to-depression",
  },
  {
    step: "03",
    title: "استعرض التحليل",
    description:
      "احصل على نتائج تفصيلية تشمل التصنيف ودرجة الثقة والأعراض المكتشفة",
    icon: "ChartBar",
    color: "from-stress to-navy-600",
  },
];

export const PROJECT_TIMELINE = [
  {
    year: "2024 - أوائل",
    title: "فكرة المشروع",
    description: "بدأت الفكرة من ملاحظة غياب أدوات تحليل الصحة النفسية باللهجة اليمنية",
    icon: "Lightbulb",
  },
  {
    year: "2024 - منتصف",
    title: "جمع البيانات",
    description: "جمع وتوصيف أكثر من 10,000 نص يمني وتصنيفها يدوياً مع متخصصين نفسيين",
    icon: "Database",
  },
  {
    year: "2024 - نهاية",
    title: "تدريب النموذج",
    description: "تدريب نموذج LLM متخصص على البيانات اليمنية مع ضبط دقيق للتصنيفات النفسية",
    icon: "Brain",
  },
  {
    year: "2025 - حالياً",
    title: "إطلاق المنصة",
    description: "بناء المنصة الكاملة وإطلاقها للجمهور مع لوحة إحصائيات شاملة",
    icon: "Rocket",
  },
];

export const TECH_STACK = [
  { name: "Python", category: "AI/ML", color: "bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300" },
  { name: "PyTorch", category: "AI/ML", color: "bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300" },
  { name: "Hugging Face", category: "AI/ML", color: "bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300" },
  { name: "FastAPI", category: "Backend", color: "bg-teal-100 text-teal-800 dark:bg-teal-900/30 dark:text-teal-300" },
  { name: "PostgreSQL", category: "Database", color: "bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300" },
  { name: "Next.js", category: "Frontend", color: "bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300" },
  { name: "React", category: "Frontend", color: "bg-cyan-100 text-cyan-800 dark:bg-cyan-900/30 dark:text-cyan-300" },
  { name: "TypeScript", category: "Frontend", color: "bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300" },
  { name: "Tailwind CSS", category: "Frontend", color: "bg-sky-100 text-sky-800 dark:bg-sky-900/30 dark:text-sky-300" },
  { name: "Framer Motion", category: "Frontend", color: "bg-pink-100 text-pink-800 dark:bg-pink-900/30 dark:text-pink-300" },
  { name: "Docker", category: "DevOps", color: "bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300" },
  { name: "Vercel", category: "Hosting", color: "bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300" },
];
