import defaultTheme from 'tailwindcss/defaultTheme'
import forms from '@tailwindcss/forms'
import typography from '@tailwindcss/typography'

/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class',
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
    './resources/js/**/*.vue',
  ],

  theme: {
    container: { center: true, padding: '1rem' },
    extend: {
      colors: {
        brand: {
          50: '#FFF5EC',
          100: '#FFE7D1',
          200: '#FFD0A3',
          300: '#FFB170',
          400: '#FF8E3C',
          500: '#FF6A00', // principal
          600: '#E25C00',
          700: '#B94800',
          800: '#8F3900',
          900: '#6F2C00',
        },
      },
      fontFamily: {
        sans: ['Inter', ...defaultTheme.fontFamily.sans],
      },
      boxShadow: {
        soft: '0 1px 3px rgba(0,0,0,.06), 0 4px 12px rgba(0,0,0,.06)',
      },
    },
  },

  plugins: [
    forms,
    typography,
  ],
}
