import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        brand: {
          900: '#0f172a',  // Deep Navy - Sidebar
          800: '#1e293b',  // Hover states
          accent: '#f59e0b', // Amber/Gold - Buttons
        }
      }
    },
  },
  plugins: [],
}
