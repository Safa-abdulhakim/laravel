import type { Config } from "tailwindcss";

const config: Config = {
  content: [
    "./pages/**/*.{js,ts,jsx,tsx,mdx}",
    "./components/**/*.{js,ts,jsx,tsx,mdx}",
    "./app/**/*.{js,ts,jsx,tsx,mdx}",
  ],
  theme: {
    extend: {
      fontFamily: {
        tajawal: ["Tajawal", "sans-serif"],
        arabic: ["Tajawal", "Arabic", "sans-serif"],
      },
      colors: {
        brand: {
          50: "#e8f4f8",
          100: "#c5e3ef",
          200: "#9ecfe5",
          300: "#72badb",
          400: "#4aa8d4",
          500: "#1e97cd",
          600: "#1a85b8",
          700: "#146e9e",
          800: "#0e5784",
          900: "#1e3a5f",
          950: "#0f2540",
        },
        teal: {
          50: "#f0fdfa",
          100: "#ccfbf1",
          200: "#99f6e4",
          300: "#5eead4",
          400: "#2dd4bf",
          500: "#14b8a6",
          600: "#0d9488",
          700: "#0f766e",
          800: "#115e59",
          900: "#134e4a",
          950: "#042f2e",
        },
        glass: {
          white: "rgba(255, 255, 255, 0.1)",
          "white-md": "rgba(255, 255, 255, 0.15)",
          "white-lg": "rgba(255, 255, 255, 0.2)",
          dark: "rgba(0, 0, 0, 0.1)",
        },
      },
      backgroundImage: {
        "hero-gradient":
          "linear-gradient(135deg, #1e3a5f 0%, #0f766e 50%, #1e3a5f 100%)",
        "card-gradient":
          "linear-gradient(135deg, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0.05) 100%)",
        "button-gradient":
          "linear-gradient(135deg, #0f766e 0%, #1e3a5f 100%)",
        "button-gradient-hover":
          "linear-gradient(135deg, #115e59 0%, #162e4d 100%)",
        "section-gradient":
          "linear-gradient(180deg, #f0f9ff 0%, #e0f2fe 100%)",
        "result-depression":
          "linear-gradient(135deg, #fff1f2 0%, #ffe4e6 100%)",
        "result-anxiety":
          "linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%)",
        "result-stress":
          "linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%)",
        "result-normal":
          "linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%)",
      },
      animation: {
        "float-slow": "float 6s ease-in-out infinite",
        "float-medium": "float 4s ease-in-out infinite",
        "pulse-slow": "pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite",
        "slide-in-right": "slideInRight 0.3s ease-out",
        "slide-in-up": "slideInUp 0.4s ease-out",
        "fade-in": "fadeIn 0.5s ease-out",
        "scale-in": "scaleIn 0.3s ease-out",
        "spin-slow": "spin 3s linear infinite",
        "bounce-gentle": "bounceGentle 2s ease-in-out infinite",
        shimmer: "shimmer 2s infinite",
      },
      keyframes: {
        float: {
          "0%, 100%": { transform: "translateY(0px)" },
          "50%": { transform: "translateY(-20px)" },
        },
        slideInRight: {
          "0%": { transform: "translateX(100%)", opacity: "0" },
          "100%": { transform: "translateX(0)", opacity: "1" },
        },
        slideInUp: {
          "0%": { transform: "translateY(30px)", opacity: "0" },
          "100%": { transform: "translateY(0)", opacity: "1" },
        },
        fadeIn: {
          "0%": { opacity: "0" },
          "100%": { opacity: "1" },
        },
        scaleIn: {
          "0%": { transform: "scale(0.9)", opacity: "0" },
          "100%": { transform: "scale(1)", opacity: "1" },
        },
        bounceGentle: {
          "0%, 100%": { transform: "translateY(0)" },
          "50%": { transform: "translateY(-10px)" },
        },
        shimmer: {
          "0%": { backgroundPosition: "-200% 0" },
          "100%": { backgroundPosition: "200% 0" },
        },
      },
      boxShadow: {
        glass: "0 8px 32px 0 rgba(31, 38, 135, 0.37)",
        "glass-sm": "0 4px 16px 0 rgba(31, 38, 135, 0.2)",
        "glass-lg": "0 16px 48px 0 rgba(31, 38, 135, 0.5)",
        brand: "0 8px 25px -5px rgba(30, 58, 95, 0.4)",
        "brand-lg": "0 20px 50px -10px rgba(30, 58, 95, 0.5)",
        teal: "0 8px 25px -5px rgba(15, 118, 110, 0.4)",
        card: "0 4px 20px rgba(0, 0, 0, 0.08)",
        "card-hover": "0 12px 40px rgba(0, 0, 0, 0.15)",
      },
      backdropBlur: {
        xs: "2px",
      },
      borderRadius: {
        "4xl": "2rem",
        "5xl": "2.5rem",
      },
      spacing: {
        "18": "4.5rem",
        "22": "5.5rem",
        "88": "22rem",
        "100": "25rem",
        "112": "28rem",
        "128": "32rem",
      },
    },
  },
  plugins: [],
};

export default config;
