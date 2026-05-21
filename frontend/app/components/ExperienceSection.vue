<script setup lang="ts">
const experiences = useState<any[]>('experiences')
const { $gsap } = useNuxtApp() as any
const root = ref<HTMLElement | null>(null)

const fmtDate = (d: string | null) => {
  if (!d) return 'Present'
  const dt = new Date(d)
  return dt.toLocaleDateString('en', { month: 'short', year: 'numeric' })
}

onMounted(() => {
  if (!$gsap || !root.value) return
  const ctx = $gsap.context(() => {
    $gsap.from('[data-exp-item]', {
      scrollTrigger: {
        trigger: root.value,
        start: 'top 75%',
      },
      x: -40, opacity: 0, duration: 0.9, stagger: 0.15, ease: 'expo.out',
    })
  }, root.value)
  onBeforeUnmount(() => ctx.revert())
})
</script>

<template>
  <section ref="root" id="experience" class="py-32 relative">
    <div class="max-w-7xl mx-auto px-6">
      <div class="mb-16 max-w-3xl">
        <p class="font-mono text-sm text-ember mb-4">◇ 02 / experience</p>
        <h2 class="font-display text-5xl md:text-6xl text-bone-100 leading-[0.95]">
          Where I've
          <span class="font-display-italic text-ember">built things</span>.
        </h2>
      </div>

      <div class="relative">
        <!-- Vertical line -->
        <div class="absolute left-0 md:left-1/3 top-0 bottom-0 w-px bg-gradient-to-b from-ember/0 via-ember/30 to-ember/0"/>

        <div class="space-y-12">
          <article
            v-for="exp in experiences"
            :key="exp.id"
            data-exp-item
            class="grid md:grid-cols-3 gap-6 md:gap-12 relative pl-6 md:pl-0"
          >
            <!-- Dot -->
            <div class="absolute left-0 md:left-1/3 top-2 -translate-x-1/2 w-3 h-3 rounded-full bg-ember ring-4 ring-ink-900"/>

            <!-- Date column -->
            <div class="md:text-right md:pr-12">
              <time class="font-mono text-xs uppercase tracking-wider text-bone-400">
                {{ fmtDate(exp.start_date) }} — {{ fmtDate(exp.end_date) }}
              </time>
              <div v-if="exp.location" class="mt-1 text-xs text-bone-400/70">{{ exp.location }}</div>
            </div>

            <!-- Content -->
            <div class="md:col-span-2 md:pl-12">
              <h3 class="font-display text-2xl text-bone-100">{{ exp.role }}</h3>
              <a
                v-if="exp.company_url"
                :href="exp.company_url"
                target="_blank"
                rel="noopener"
                class="text-ember hover:underline inline-flex items-center gap-1"
              >
                {{ exp.company }} <span class="text-xs">↗</span>
              </a>
              <div v-else class="text-ember">{{ exp.company }}</div>

              <p v-if="exp.description" class="mt-3 text-bone-300 leading-relaxed text-pretty">
                {{ exp.description }}
              </p>

              <div v-if="exp.technologies?.length" class="mt-4 flex flex-wrap gap-2">
                <span
                  v-for="t in exp.technologies"
                  :key="t"
                  class="px-2.5 py-1 text-xs font-mono rounded-full bg-ember/10 text-ember border border-ember/20"
                >
                  {{ t }}
                </span>
              </div>
            </div>
          </article>
        </div>
      </div>
    </div>
  </section>
</template>
