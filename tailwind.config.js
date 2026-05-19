import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                arabic: ['Cairo', 'Tajawal', 'sans-serif'],
            },
            colors: {
                brand: {
                    black:  '#050810',
                    navy:   '#0a0f1e',
                    dark:   '#0d1426',
                    blue:   '#1d4ed8',
                    electric: '#2563eb',
                    glow:   '#3b82f6',
                    silver: '#94a3b8',
                    light:  '#cbd5e1',
                },
            },
            backgroundImage: {
                'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                'gradient-brand': 'linear-gradient(135deg, #050810 0%, #0a0f1e 50%, #0d1426 100%)',
                'gradient-electric': 'linear-gradient(135deg, #2563eb, #3b82f6)',
            },
            boxShadow: {
                'glow-sm':  '0 0 10px rgba(37,99,235,0.3)',
                'glow':     '0 0 20px rgba(37,99,235,0.4)',
                'glow-lg':  '0 0 40px rgba(37,99,235,0.5)',
                'glow-xl':  '0 0 60px rgba(37,99,235,0.6)',
                'inner-glow': 'inset 0 0 20px rgba(37,99,235,0.1)',
            },
            animation: {
                'float':        'float 6s ease-in-out infinite',
                'pulse-glow':   'pulseGlow 2s ease-in-out infinite',
                'slide-up':     'slideUp 0.8s ease forwards',
                'fade-in':      'fadeIn 1s ease forwards',
                'border-spin':  'borderSpin 4s linear infinite',
                'gradient-x':   'gradientX 6s ease infinite',
            },
            keyframes: {
                float: {
                    '0%,100%': { transform: 'translateY(0px)' },
                    '50%':     { transform: 'translateY(-20px)' },
                },
                pulseGlow: {
                    '0%,100%': { boxShadow: '0 0 20px rgba(37,99,235,0.4)' },
                    '50%':     { boxShadow: '0 0 50px rgba(37,99,235,0.8)' },
                },
                slideUp: {
                    from: { opacity: '0', transform: 'translateY(60px)' },
                    to:   { opacity: '1', transform: 'translateY(0)' },
                },
                fadeIn: {
                    from: { opacity: '0' },
                    to:   { opacity: '1' },
                },
                borderSpin: {
                    '0%':   { backgroundPosition: '0% 50%' },
                    '50%':  { backgroundPosition: '100% 50%' },
                    '100%': { backgroundPosition: '0% 50%' },
                },
                gradientX: {
                    '0%,100%': { backgroundPosition: '0% 50%' },
                    '50%':     { backgroundPosition: '100% 50%' },
                },
            },
        },
    },

    plugins: [forms],
};
