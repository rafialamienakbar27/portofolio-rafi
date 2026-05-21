<script setup lang="ts">
const projects = useState<any[]>('projects')
const { $gsap } = useNuxtApp() as any
const root = ref<HTMLElement | null>(null)

// Magnetic spotlight on cards
const onCardMove = (e: MouseEvent) => {
  const card = e.currentTarget as HTMLElement
  const rect = card.getBoundingClientRect()
  card.style.setProperty('--mx', `${e.clientX - rect.left}px`)
  card.style.setProperty('--my', `${e.clientY - rect.top}px`)
}

onMounted(() => {
  if (!$gsap || !root.value) return
  const ctx = $gsap.context(() => {
    $gsap.from('[data-project-card]', {
      scrollTrigger: {
        trigger: root.value,
        start: 'top 80%',
      },
      y: 60, opacity: 0, duration: 0.9,
      stagger: { each: 0.08, from: 'start' },
      ease: 'expo.out',
    })
  }, root.value)
  onBeforeUnmount(() => ctx.revert())
})
</script>

<template>
  <section ref="root" id="projects" class="py-32 relative">
    <div class="max-w-7xl mx-auto px-6">
      <div class="mb-16 flex items-end justify-between gap-8 flex-wrap">
        <div class="max-w-3xl">
          <p class="font-mono text-sm text-ember mb-4">◇ 03 / projects</p>
          <h2 class="font-display text-5xl md:text-6xl text-bone-100 leading-[0.95]">
            Selected
            <span class="font-display-italic text-ember">work</span>.
          </h2>
        </div>
        <p class="font-mono text-xs text-bone-400 uppercase tracking-wider">
          {{ projects?.length || 0 }} projects · public sector
        </p>
      </div>

      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        <article
          v-for="(p, i) in projects"
          :key="p.id"
          data-project-card
          class="project-card group relative bg-ink-800 border border-ink-700
                 rounded-2xl overflow-hidden hover:border-ember/40
                 transition-colors flex flex-col"
          @mousemove="onCardMove"
        >
          <NuxtLink :to="`/projects/${p.slug}`" class="flex flex-col flex-1">
            <!-- Cover -->
            <div class="aspect-[16/10] bg-ink-700 overflow-hidden relative shrink-0">
              <img
                v-if="p.cover_image"
                :src="p.cover_image"
                :alt="p.title"
                loading="lazy"
                :class="p.badge_label === 'Development'
                  ? 'w-full h-full object-cover opacity-60'
                  : 'w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700 group-hover:scale-105'"
              />
              <div v-else class="w-full h-full flex items-center justify-center text-ink-600 font-display text-7xl">
                {{ String(i + 1).padStart(2, '0') }}
              </div>

              <!-- Number badge -->
              <div class="absolute top-3 left-3 px-2 py-1 rounded-md bg-ink-900/80 backdrop-blur font-mono text-xs text-ember">
                / {{ String(i + 1).padStart(2, '0') }}
              </div>

              <!-- Dynamic status badge -->
              <div
                v-if="p.badge_label"
                class="absolute top-3 right-3 px-2 py-1 rounded-md font-mono text-[10px] uppercase tracking-wider border"
                :class="{
                  'bg-moss/15 text-moss border-moss/30': p.badge_label === 'Released & Improvement',
                  'bg-blue-500/15 text-blue-400 border-blue-500/30': p.badge_label === 'Development',
                }"
              >
                {{ p.badge_label }}
              </div>
            </div>

            <!-- Body -->
            <div class="p-6 flex flex-col flex-1">
              <div class="flex items-center gap-2 font-mono text-[10px] uppercase tracking-wider text-bone-400 mb-3">
                <span v-if="p.category">{{ p.category }}</span>
                <span v-if="p.year">· {{ p.year }}</span>
              </div>
              <h3 class="font-display text-xl text-bone-100 group-hover:text-ember transition-colors leading-tight">
                {{ p.title }}
              </h3>
              <p v-if="p.subtitle" class="mt-2 text-sm text-bone-400 line-clamp-2">
                {{ p.subtitle }}
              </p>

              <!-- Footer pushed to bottom -->
              <div class="mt-auto pt-4 space-y-3">
                <div v-if="p.technologies?.length" class="flex flex-wrap gap-1.5">
                  <span
                    v-for="t in (p.technologies || []).slice(0, 4)"
                    :key="t"
                    class="text-[10px] font-mono px-2 py-0.5 rounded bg-ink-700 text-bone-300"
                  >
                    {{ t }}
                  </span>
                </div>

                <!-- Read more arrow -->
                <div class="inline-flex items-center gap-2 font-mono text-xs text-bone-100 group-hover:text-ember transition">
                  <span>Read case study</span>
                  <svg class="w-3 h-3 transition-transform group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                  </svg>
                </div>
              </div>
            </div>
          </NuxtLink>
        </article>
      </div>
    </div>
  </section>
</template>
