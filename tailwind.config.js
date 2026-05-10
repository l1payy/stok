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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#0C447C',
                accent: '#2AAFE4',
                success: '#2ECC71',
                warning: '#F59E0B',
                danger: '#EF4444',
                pagebg: '#F4F6F9',
            },
        },
    },

    plugins: [forms],
};
