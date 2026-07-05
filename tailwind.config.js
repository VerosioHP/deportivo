const deportivoTokens = require('./js/theme/deportivo-tokens.cjs');

/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: 'class',
    content: [
        './index.php',
        './views/**/*.php',
        './js/**/*.js',
        './css/**/*.css',
    ],
    theme: {
        extend: deportivoTokens,
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
};
