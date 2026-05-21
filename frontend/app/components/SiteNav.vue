<script setup lang="ts">
const profile = useState<any>('profile')
const { $lenis } = useNuxtApp() as any

const scrollTo = (target: string) => {
  if ($lenis) {
    $lenis.scrollTo(target, { offset: -80, duration: 1.5 })
  }
}

const isScrolled = ref(false)
onMounted(() => {
  const onScroll = () => (isScrolled.value = window.scrollY > 30)
  window.addEventListener('scroll', onScroll, { passive: true })
  onBeforeUnmount(() => window.removeEventListener('scroll', onScroll))
})
</script>

<template>
  <header
    class="fixed top-0 left-0 right-0 z-40 transition-all duration-500"
    :class="isScrolled
      ? 'py-3 bg-ink-900/80 backdrop-blur-lg border-b border-ink-700/50'
      : 'py-6 bg-transparent'"
  >
    <div class="max-w-7xl mx-auto px-6 flex items-center justify-between">
      <NuxtLink to="/" class="group flex items-center gap-2">
        <span class="font-display text-2xl tracking-tight">
          <span class="text-ember">R</span><span class="text-bone-100">.A</span>
        </span>
        <span class="hidden sm:inline text-xs font-mono text-bone-400 group-hover:text-ember transition">
          /portfolio
        </span>
      </NuxtLink>

      <nav class="hidden md:flex items-center gap-1 font-mono text-sm">
        <button
          v-for="(item, i) in [
            { id: '#about', label: 'about' },
            { id: '#experience', label: 'experience' },
            { id: '#projects', label: 'projects' },
            { id: '#contact', label: 'contact' },
          ]"
          :key="item.id"
          @click="scrollTo(item.id)"
          class="px-3 py-1.5 text-bone-400 hover:text-ember transition relative"
        >
          <span class="text-ember/60 mr-1">0{{ i + 1 }}.</span>{{ item.label }}
        </button>
      </nav>

      <a
        v-if="profile?.cv_url"
        :href="profile.cv_url"
        target="_blank"
        rel="noopener"
        class="group inline-flex items-center gap-2 px-4 py-2 rounded-full
               border border-ember text-ember font-mono text-xs uppercase tracking-wider
               hover:bg-ember hover:text-ink-900 transition-all"
      >
        <span>Download CV</span>
        <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-y-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
          <polyline points="7 10 12 15 17 10"/>
          <line x1="12" y1="15" x2="12" y2="3"/>
        </svg>
      </a>
    </div>
  </header>
</template>
