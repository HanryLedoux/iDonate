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

    safelist: [
        'hover:border-orange-300',
        'dark:hover:border-orange-600',
        'group-hover:text-orange-600',
        'hover:border-green-300',
        'dark:hover:border-green-600',
        'group-hover:text-green-600',
        'hover:border-purple-300',
        'dark:hover:border-purple-600',
        'group-hover:text-purple-600',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
