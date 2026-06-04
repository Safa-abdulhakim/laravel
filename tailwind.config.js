import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Cairo', 'Figtree', ...defaultTheme.fontFamily.sans],
                cairo: ['Cairo', 'sans-serif'],
            },
            colors: {
                primary: {
                    DEFAULT: '#1E3A5F',
                    50:  '#EEF2F8',
                    100: '#D5E0EE',
                    200: '#ABC1DD',
                    300: '#81A2CC',
                    400: '#5783BB',
                    500: '#1E3A5F',
                    600: '#183050',
                    700: '#122640',
                    800: '#0C1C30',
                    900: '#060E18',
                },
                secondary: {
                    DEFAULT: '#6C63FF',
                    50:  '#F0EFFF',
                    100: '#D9D7FF',
                    200: '#B3B0FF',
                    300: '#8D89FF',
                    400: '#6C63FF',
                    500: '#4B41FF',
                    600: '#2A1FFF',
                    700: '#0900FC',
                    800: '#0700C9',
                    900: '#050096',
                },
            },
            animation: {
                'float': 'float 6s ease-in-out infinite',
                'float-delay': 'float 6s ease-in-out 2s infinite',
                'float-delay2': 'float 6s ease-in-out 4s infinite',
                'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                'gradient': 'gradientShift 8s ease infinite',
                'fade-in-up': 'fadeInUp 0.6s ease-out forwards',
                'fade-in': 'fadeIn 0.5s ease-out forwards',
                'slide-in-right': 'slideInRight 0.5s ease-out forwards',
                'spin-slow': 'spin 8s linear infinite',
                'bounce-slow': 'bounce 3s infinite',
                'shimmer': 'shimmer 2s linear infinite',
            },
            keyframes: {
                float: {
                    '0%, 100%': { transform: 'translateY(0px)' },
                    '50%':       { transform: 'translateY(-20px)' },
                },
                gradientShift: {
                    '0%, 100%': { backgroundPosition: '0% 50%' },
                    '50%':      { backgroundPosition: '100% 50%' },
                },
                fadeInUp: {
                    from: { opacity: '0', transform: 'translateY(30px)' },
                    to:   { opacity: '1', transform: 'translateY(0)' },
                },
                fadeIn: {
                    from: { opacity: '0' },
                    to:   { opacity: '1' },
                },
                slideInRight: {
                    from: { opacity: '0', transform: 'translateX(30px)' },
                    to:   { opacity: '1', transform: 'translateX(0)' },
                },
                shimmer: {
                    '0%':   { backgroundPosition: '-200% 0' },
                    '100%': { backgroundPosition: '200% 0' },
                },
            },
            backdropBlur: {
                xs: '2px',
            },
            boxShadow: {
                'glass':     '0 8px 32px rgba(31, 38, 135, 0.15)',
                'glass-lg':  '0 16px 48px rgba(31, 38, 135, 0.2)',
                'glow':      '0 0 20px rgba(108, 99, 255, 0.3)',
                'glow-lg':   '0 0 40px rgba(108, 99, 255, 0.4)',
                'card':      '0 4px 20px rgba(0, 0, 0, 0.08)',
                'card-hover':'0 8px 40px rgba(0, 0, 0, 0.12)',
            },
        },
    },

    plugins: [forms],
};
