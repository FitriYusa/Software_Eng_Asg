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
                text: {
                    DEFAULT: '#000000', // central text color (black)
                },
                background: {
                    DEFAULT: '#ffffff', // central background color (white)
                },
                card: {
                    DEFAULT: '#003db8ff', // light grey for containers
                },
            },
        },
    },

    plugins: [forms],
};
