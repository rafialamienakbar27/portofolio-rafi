export const useTheme = () => {
  const isDark = useState('theme-is-dark', () => true)

  const apply = (dark: boolean) => {
    document.documentElement.classList.toggle('light', !dark)
    localStorage.setItem('theme', dark ? 'dark' : 'light')
  }

  const toggle = () => {
    isDark.value = !isDark.value
    apply(isDark.value)
  }

  const init = () => {
    const saved = localStorage.getItem('theme')
    const prefersDark = !window.matchMedia('(prefers-color-scheme: light)').matches
    isDark.value = saved ? saved !== 'light' : prefersDark
    apply(isDark.value)
  }

  return { isDark, toggle, init }
}
