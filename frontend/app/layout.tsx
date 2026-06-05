import type { Metadata } from "next";
import { Tajawal } from "next/font/google";
import "./globals.css";
import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import { ToastProvider } from "@/components/Toast";

const tajawal = Tajawal({
  subsets: ["arabic", "latin"],
  weight: ["200", "300", "400", "500", "700", "800", "900"],
  variable: "--font-tajawal",
  display: "swap",
  preload: true,
});

export const metadata: Metadata = {
  title: "محلل اللهجة اليمنية | تحليل الصحة النفسية",
  description:
    "نظام ذكاء اصطناعي متقدم لتحليل النصوص المكتوبة باللهجة اليمنية والكشف عن الحالات النفسية. مشروع تخرج أكاديمي.",
  keywords: [
    "اللهجة اليمنية",
    "تحليل النصوص",
    "الذكاء الاصطناعي",
    "الصحة النفسية",
    "معالجة اللغة الطبيعية",
    "NLP",
  ],
  authors: [{ name: "فريق مشروع التخرج" }],
  openGraph: {
    title: "محلل اللهجة اليمنية",
    description:
      "نظام ذكاء اصطناعي لتحليل النصوص اليمنية والكشف عن الحالات النفسية",
    locale: "ar_YE",
    type: "website",
  },
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html
      lang="ar"
      dir="rtl"
      className={`${tajawal.variable} scroll-smooth`}
    >
      <head>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link
          rel="preconnect"
          href="https://fonts.gstatic.com"
          crossOrigin="anonymous"
        />
      </head>
      <body
        className={`
          ${tajawal.className}
          min-h-screen
          flex
          flex-col
          bg-slate-50
          text-slate-800
          antialiased
        `}
      >
        <ToastProvider>
          {/* Navbar */}
          <Navbar />

          {/* Main Content */}
          <main className="flex-1">{children}</main>

          {/* Footer */}
          <Footer />
        </ToastProvider>
      </body>
    </html>
  );
}
