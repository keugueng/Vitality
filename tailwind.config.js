import forms from '@tailwindcss/forms'

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './resources/js/**/*.js',
    ],
    corePlugins: {
        preflight: true,
    },
    theme: {
        extend: {
            colors: {
                'vitality': {
                    'bg': '#03142A',
                    'bg2': '#041B33',
                    'bg3': '#071F3D',
                    'blue': '#0A2745',
                    'cyan': '#11C7C9',
                    'cyan2': '#1AB8B9',
                    'gold': '#D5B67A',
                    'white': '#F5F3EE',
                    'text': '#9DAAC0',
                    'border': 'rgba(255,255,255,0.05)',
                },
            },
            fontFamily: {
                'serif': ['Cormorant Garamond', 'Playfair Display', 'Georgia', 'serif'],
                'sans': ['Inter', 'DM Sans', 'Manrope', 'sans-serif'],
            },
            backgroundImage: {
                'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                'gradient-conic': 'conic-gradient(from 180deg at 50% 50%, var(--tw-gradient-stops))',
            },
            animation: {
                'float': 'float 6s ease-in-out infinite',
                'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                'spin-slow': 'spin 20s linear infinite',
                'fade-in': 'fadeIn 0.8s ease-in-out',
                'slide-up': 'slideUp 0.6s ease-out',
            },
            keyframes: {
                float: {
                    '0%, 100%': { transform: 'translateY(0px)' },
                    '50%': { transform: 'translateY(-20px)' },
                },
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideUp: {
                    '0%': { transform: 'translateY(20px)', opacity: '0' },
                    '100%': { transform: 'translateY(0)', opacity: '1' },
                },
            },
            backdropBlur: {
                xs: '2px',
            },
        },
    },
    plugins: [
        forms,
        function({ addUtilities, theme }) {
            const vitalityColors = theme('colors.vitality');
            const opacityUtilities = {};
            
            Object.keys(vitalityColors).forEach(color => {
                for (let i = 10; i <= 90; i += 10) {
                    const opacity = i / 100;
                    opacityUtilities[`.bg-vitality-${color}\\/${i}`] = {
                        backgroundColor: `${vitalityColors[color]}${Math.round(opacity * 255).toString(16).padStart(2, '0')}`,
                    };
                    opacityUtilities[`.text-vitality-${color}\\/${i}`] = {
                        color: `${vitalityColors[color]}${Math.round(opacity * 255).toString(16).padStart(2, '0')}`,
                    };
                    opacityUtilities[`.border-vitality-${color}\\/${i}`] = {
                        borderColor: `${vitalityColors[color]}${Math.round(opacity * 255).toString(16).padStart(2, '0')}`,
                    };
                }
            });
            
            addUtilities(opacityUtilities);
        },
    ],
}
