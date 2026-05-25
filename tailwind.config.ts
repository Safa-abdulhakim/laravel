import type { Config } from "tailwindcss";
import { fontFamily } from "tailwindcss/defaultTheme";

const config: Config = {
  darkMode: ["class"],
  content: [
    "./pages/**/*.{js,ts,jsx,tsx,mdx}",
    "./components/**/*.{js,ts,jsx,tsx,mdx}",
    "./app/**/*.{js,ts,jsx,tsx,mdx}",
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ["var(--font-cairo)", "Cairo", ...fontFamily.sans],
        arabic: ["Cairo", "Noto Sans Arabic", "sans-serif"],
      },
      colors: {
        // Base
        background: "hsl(var(--background))",
        foreground: "hsl(var(--foreground))",
        card: {
          DEFAULT: "hsl(var(--card))",
          foreground: "hsl(var(--card-foreground))",
        },
        popover: {
          DEFAULT: "hsl(var(--popover))",
          foreground: "hsl(var(--popover-foreground))",
        },
        primary: {
          DEFAULT: "hsl(var(--primary))",
          foreground: "hsl(var(--primary-foreground))",
        },
        secondary: {
          DEFAULT: "hsl(var(--secondary))",
          foreground: "hsl(var(--secondary-foreground))",
        },
        muted: {
          DEFAULT: "hsl(var(--muted))",
          foreground: "hsl(var(--muted-foreground))",
        },
        accent: {
          DEFAULT: "hsl(var(--accent))",
          foreground: "hsl(var(--accent-foreground))",
        },
        destructive: {
          DEFAULT: "hsl(var(--destructive))",
          foreground: "hsl(var(--destructive-foreground))",
        },
        border: "hsl(var(--border))",
        input: "hsl(var(--input))",
        ring: "hsl(var(--ring))",

        // Custom — Mental Health AI Palette
        navy: {
          50: "#EEF4FF",
          100: "#D8E8FF",
          200: "#B0CCFF",
          300: "#78AAFF",
          400: "#4080FF",
          500: "#2560D9",
          600: "#1E3A5F",
          700: "#163050",
          800: "#0E2040",
          900: "#070F20",
          950: "#030812",
        },
        violet: {
          50: "#F0EEFF",
          100: "#E2DEFF",
          200: "#C6BBFF",
          300: "#A99AFF",
          400: "#8D79FF",
          500: "#6C63FF",
          600: "#5040CC",
          700: "#382D99",
          800: "#201A66",
          900: "#0A0633",
        },
        // Mental Health State Colors
        depression: {
          DEFAULT: "#4A90D9",
          light: "#E8F4FF",
          medium: "#A8CFEE",
          dark: "#1E6BAF",
          text: "#0F4C7A",
        },
        anxiety: {
          DEFAULT: "#E8924A",
          light: "#FEF4EC",
          medium: "#F5C49A",
          dark: "#BF6520",
          text: "#8A4012",
        },
        stress: {
          DEFAULT: "#52B788",
          light: "#EAFAF3",
          medium: "#99D8BC",
          dark: "#2A8A5E",
          text: "#1A5C3A",
        },
        // Chart Colors
        chart: {
          1: "#6C63FF",
          2: "#4A90D9",
          3: "#52B788",
          4: "#E8924A",
          5: "#F472B6",
        },
      },
      borderRadius: {
        lg: "var(--radius)",
        md: "calc(var(--radius) - 2px)",
        sm: "calc(var(--radius) - 4px)",
        "2xl": "1rem",
        "3xl": "1.5rem",
        "4xl": "2rem",
      },
      keyframes: {
        "accordion-down": {
          from: { height: "0" },
          to: { height: "var(--radix-accordion-content-height)" },
        },
        "accordion-up": {
          from: { height: "var(--radix-accordion-content-height)" },
          to: { height: "0" },
        },
        float: {
          "0%, 100%": { transform: "translateY(0px)" },
          "50%": { transform: "translateY(-12px)" },
        },
        "float-slow": {
          "0%, 100%": { transform: "translateY(0px)" },
          "50%": { transform: "translateY(-8px)" },
        },
        shimmer: {
          "0%": { backgroundPosition: "-200% 0" },
          "100%": { backgroundPosition: "200% 0" },
        },
        "pulse-glow": {
          "0%, 100%": { opacity: "1", boxShadow: "0 0 20px rgba(108,99,255,0.3)" },
          "50%": { opacity: "0.8", boxShadow: "0 0 40px rgba(108,99,255,0.6)" },
        },
        "spin-slow": {
          from: { transform: "rotate(0deg)" },
          to: { transform: "rotate(360deg)" },
        },
        "fade-up": {
          from: { opacity: "0", transform: "translateY(20px)" },
          to: { opacity: "1", transform: "translateY(0)" },
        },
        "slide-right": {
          from: { opacity: "0", transform: "translateX(-20px)" },
          to: { opacity: "1", transform: "translateX(0)" },
        },
        blob: {
          "0%": { transform: "translate(0px, 0px) scale(1)" },
          "33%": { transform: "translate(30px, -50px) scale(1.1)" },
          "66%": { transform: "translate(-20px, 20px) scale(0.9)" },
          "100%": { transform: "translate(0px, 0px) scale(1)" },
        },
        "count-up": {
          from: { opacity: "0", transform: "translateY(10px)" },
          to: { opacity: "1", transform: "translateY(0)" },
        },
        wave: {
          "0%, 100%": { transform: "scaleY(0.5)" },
          "50%": { transform: "scaleY(1.5)" },
        },
      },
      animation: {
        "accordion-down": "accordion-down 0.2s ease-out",
        "accordion-up": "accordion-up 0.2s ease-out",
        float: "float 4s ease-in-out infinite",
        "float-slow": "float-slow 6s ease-in-out infinite",
        shimmer: "shimmer 2s linear infinite",
        "pulse-glow": "pulse-glow 2s ease-in-out infinite",
        "spin-slow": "spin-slow 8s linear infinite",
        "fade-up": "fade-up 0.6s ease-out",
        "slide-right": "slide-right 0.5s ease-out",
        blob: "blob 7s infinite",
        "count-up": "count-up 0.8s ease-out",
        wave: "wave 1.2s ease-in-out infinite",
      },
      backdropBlur: {
        xs: "2px",
      },
      backgroundImage: {
        "gradient-radial": "radial-gradient(var(--tw-gradient-stops))",
        "gradient-conic": "conic-gradient(from 180deg at 50% 50%, var(--tw-gradient-stops))",
        "hero-pattern": "radial-gradient(ellipse at 20% 50%, rgba(108,99,255,0.12) 0%, transparent 50%), radial-gradient(ellipse at 80% 20%, rgba(30,58,95,0.15) 0%, transparent 50%)",
      },
      boxShadow: {
        glass: "0 4px 24px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04)",
        "glass-lg": "0 8px 40px rgba(0,0,0,0.08), 0 2px 4px rgba(0,0,0,0.04)",
        "glass-xl": "0 16px 60px rgba(0,0,0,0.12), 0 4px 8px rgba(0,0,0,0.06)",
        glow: "0 0 20px rgba(108,99,255,0.25)",
        "glow-lg": "0 0 40px rgba(108,99,255,0.35)",
        navy: "0 4px 24px rgba(30,58,95,0.15)",
        "navy-lg": "0 8px 40px rgba(30,58,95,0.20)",
      },
    },
  },
  plugins: [require("tailwindcss-animate")],
};

export default config;
