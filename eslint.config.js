import js from '@eslint/js';
import prettier from 'eslint-plugin-prettier/recommended';

export default [
    js.configs.recommended,
    prettier,
    {
        files: ['resources/js/**/*.js'],
        languageOptions: {
            ecmaVersion: 2022,
            sourceType: 'module',
        },
        rules: {
            // Puedes añadir reglas personalizadas aquí
        }
    }
];