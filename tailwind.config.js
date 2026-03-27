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
            colors: {
                gold: {
                    50:  '#fdf8eb',
                    100: '#f9edcc',
                    200: '#f3d994',
                    300: '#ecc25c',
                    400: '#e5ab2e',
                    500: '#c8922a',
                    600: '#a87420',
                    700: '#85571c',
                    800: '#6d451e',
                    900: '#5c3a1e',
                    950: '#351d0e',
                },
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
