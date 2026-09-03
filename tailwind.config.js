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
            },
            colors: {
                primary: '#22577A',
                secondary: '#38A3A5',
                success: '#57CC99',
                accent: '#80ED99',
                appbg: '#F7F9FB',
                surface: '#FFFFFF',
                bordercolor: '#E2E8F0',
                textprimary: '#0F172A',
                textsecondary: '#64748B',
            }
        },
    },

    plugins: [forms],
};
