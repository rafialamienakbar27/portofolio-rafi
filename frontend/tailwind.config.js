/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './app/**/*.{vue,js,ts}',
    './components/**/*.{vue,js,ts}',
    './layouts/**/*.vue',
    './pages/**/*.vue',
    './plugins/**/*.{js,ts}',
    './nuxt.config.{js,ts}',
  ],
  theme: {
    extend: {
      colors: {
        // Dark editorial palette
        ink: {
          950: '#06060A',
          900: '#0A0A0F',
          800: '#12121A',
          700: '#1A1A25',
          600: '#252533',
        },
        bone: {
          50: '#FAFAF7',
          100: '#F2F1EA',
          200: '#E5E3D8',
          300: '#C9C7B8',
          400: '#9B9A8C',
        },
        ember: {
          DEFAULT: '#FF6A3D',
          400: '#FF8865',
          500: '#FF6A3D',
          600: '#E54F22',
          700: '#B33D1A',
        },
        moss: '#8FA56C', // accent secondary
      },
      fontFamily: {
        display: ['"Fraunces"', 'ui-serif', 'Georgia', 'serif'],
        sans: ['"Inter Tight"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
        mono: ['"JetBrains Mono"', 'ui-monospace', 'monospace'],
      },
      fontSize: {
        'mega': ['clamp(3rem, 12vw, 11rem)', { lineHeight: '0.92', letterSpacing: '-0.04em' }],
        'huge': ['clamp(2.5rem, 8vw, 6rem)', { lineHeight: '0.95', letterSpacing: '-0.03em' }],
      },
      letterSpacing: {
        tightest: '-0.05em',
      },
      animation: {
        marquee: 'marquee 30s linear infinite',
        'fade-up': 'fadeUp 0.8s ease forwards',
        'pulse-slow': 'pulse 4s ease-in-out infinite',
      },
      keyframes: {
        marquee: {
          '0%': { transform: 'translateX(0)' },
          '100%': { transform: 'translateX(-50%)' },
        },
        fadeUp: {
          '0%': { opacity: '0', transform: 'translateY(24px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
      },
    },
  },
  plugins: [],
}
