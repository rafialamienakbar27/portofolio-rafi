<script setup lang="ts">
const profile = useState<any>('profile')
const { $gsap, $ScrollTrigger } = useNuxtApp() as any
const root = ref<HTMLElement | null>(null)

onMounted(() => {
  if (!$gsap || !root.value) return
  const ctx = $gsap.context(() => {
    $gsap.from('[data-about-reveal]', {
      scrollTrigger: {
        trigger: root.value,
        start: 'top 75%',
      },
      y: 40, opacity: 0, duration: 1, stagger: 0.1, ease: 'expo.out',
    })

    // Big text scroll-driven
    $gsap.to('[data-about-bigword]', {
      scrollTrigger: {
        trigger: root.value,
        start: 'top bottom',
        end: 'bottom top',
        scrub: 1,
      },
      xPercent: -10,
      ease: 'none',
    })
  }, root.value)

  onBeforeUnmount(() => ctx.revert())
})
</script>

<template>
  <section ref="root" id="about" class="relative py-32 overflow-hidden">
    <!-- Giant decorative word -->
    <div class="absolute -top-12 left-0 right-0 pointer-events-none select-none whitespace-nowrap" aria-hidden="true">
      <span data-about-bigword class="font-display text-[18rem] font-light text-ink-700/40 leading-none tracking-tightest inline-block">
        about — about — about —
      </span>
    </div>

    <div class="relative max-w-7xl mx-auto px-6">
      <div class="grid lg:grid-cols-12 gap-12">
        <div class="lg:col-span-4">
          <p data-about-reveal class="font-mono text-sm text-ember mb-4">◇ 01 / about</p>
          <h2 data-about-reveal class="font-display text-5xl md:text-6xl text-bone-100 leading-[0.95] tracking-tight">
            The story
            <span class="font-display-italic text-ember block">behind</span>
            the code.
          </h2>
        </div>

        <div class="lg:col-span-7 lg:col-start-6 space-y-6">
          <p data-about-reveal class="text-lg text-bone-300 leading-relaxed text-pretty">
            {{ profile?.bio }}
          </p>

          <!-- Skills -->
          <div data-about-reveal class="pt-8 border-t border-ink-700 grid sm:grid-cols-2 gap-8">
            <div v-for="cat in (profile?.skills || [])" :key="cat.category">
              <h3 class="font-mono text-xs uppercase tracking-wider text-ember mb-3">
                {{ cat.category }}
              </h3>
              <ul class="space-y-1.5">
                <li
                  v-for="skill in cat.items"
                  :key="skill"
                  class="text-bone-100 text-sm flex items-center gap-2"
                >
                  <span class="text-ember">▸</span>{{ skill }}
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
