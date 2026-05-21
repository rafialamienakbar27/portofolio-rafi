<script setup lang="ts">
const { isDark, toggle } = useTheme()
</script>

<template>
  <button
    @click="toggle"
    :aria-label="isDark ? 'Switch to light mode' : 'Switch to dark mode'"
    class="relative w-8 h-8 flex items-center justify-center rounded-full
           text-bone-400 hover:text-ember transition-colors duration-200
           focus:outline-none focus-visible:ring-2 focus-visible:ring-ember"
  >
    <!-- Sun (shown in dark mode → click to go light) -->
    <Transition name="theme-icon">
      <svg
        v-if="isDark"
        key="sun"
        class="w-[18px] h-[18px] absolute"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
      >
        <circle cx="12" cy="12" r="4" />
        <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41" />
      </svg>

      <!-- Moon (shown in light mode → click to go dark) -->
      <svg
        v-else
        key="moon"
        class="w-[18px] h-[18px] absolute"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
      >
        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" />
      </svg>
    </Transition>
  </button>
</template>

<style scoped>
.theme-icon-enter-active,
.theme-icon-leave-active {
  transition: opacity 0.2s ease, transform 0.2s ease;
}
.theme-icon-enter-from {
  opacity: 0;
  transform: rotate(-30deg) scale(0.7);
}
.theme-icon-leave-to {
  opacity: 0;
  transform: rotate(30deg) scale(0.7);
}
</style>
