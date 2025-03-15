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
            fontSize: {
                'xxs': ['0.625rem', '0.75rem'], // font-size: 0.625rem; line-height: 0.75rem
            },
            colors: {
                'cerulean': {
                    '50': '#f0faff',
                    '100': '#e0f5fe',
                    '200': '#b9ecfe',
                    '300': '#7cdffd',
                    '400': '#36d0fa',
                    '500': '#0cbaeb',
                    '600': '#009dd1',
                    '700': '#0178a3',
                    '800': '#066586',
                    '900': '#0b536f',
                    '950': '#07354a',
                },
                'tour': {
                    '50': '#ffffea',
                    '100': '#fffcc5',
                    '200': '#fff985',
                    '300': '#fff046',
                    '400': '#ffe21b',
                    '500': '#f4ba00',
                    '600': '#e29600',
                    '700': '#bb6b02',
                    '800': '#985208',
                    '900': '#7c430b',
                    '950': '#482300',
                },
                'giro': {
                    '50': '#fef1f8',
                    '100': '#fee5f3',
                    '200': '#ffcbea',
                    '300': '#ffa1d6',
                    '400': '#ff7ac1',
                    '500': '#fa3a9b',
                    '600': '#ea1877',
                    '700': '#cc0a5d',
                    '800': '#a80c4d',
                    '900': '#8c0f42',
                    '950': '#560124',
                                },
                'vuelta': {
                    '50': '#fff0f0',
                    '100': '#ffdddd',
                    '200': '#ffc0c0',
                    '300': '#ff9494',
                    '400': '#ff5757',
                    '500': '#ff2323',
                    '600': '#ff0000',
                    '700': '#d70000',
                    '800': '#b10303',
                    '900': '#920a0a',
                    '950': '#500000',
                },
            }
        },
    },

    plugins: [forms],
};
