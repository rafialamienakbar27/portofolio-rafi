<script setup lang="ts">
const profile = useState<any>('profile')
const { $gsap, $lenis } = useNuxtApp() as any

const heroRoot = ref<HTMLElement | null>(null)

const scrollToProjects = () => {
  if ($lenis) $lenis.scrollTo('#projects', { offset: -80, duration: 1.5 })
}

onMounted(() => {
  if (!$gsap || !heroRoot.value) return
  const ctx = $gsap.context(() => {
    const tl = $gsap.timeline({ defaults: { ease: 'expo.out' } })

    tl.from('[data-hero-eyebrow]', {
      yPercent: 100, opacity: 0, duration: 1, delay: 0.2,
    })
      .from('[data-hero-line]', {
        yPercent: 110, opacity: 0, duration: 1.2, stagger: 0.08,
      }, '-=0.6')
      .from('[data-hero-tagline]', {
        y: 30, opacity: 0, duration: 1,
      }, '-=0.7')
      .from('[data-hero-cta] > *', {
        y: 20, opacity: 0, duration: 0.8, stagger: 0.1,
      }, '-=0.6')
      .from('[data-hero-meta] > *', {
        opacity: 0, y: 10, duration: 0.6, stagger: 0.05,
      }, '-=0.4')
  }, heroRoot.value)

  onBeforeUnmount(() => ctx.revert())
})
</script>

<template>
  <section
    ref="heroRoot"
    id="home"
    class="relative min-h-screen flex items-center pt-32 pb-20 overflow-hidden"
  >
    <!-- Background grid -->
    <div class="absolute inset-0 opacity-[0.03] pointer-events-none"
         style="background-image: linear-gradient(rgb(242 241 234) 1px, transparent 1px), linear-gradient(90deg, rgb(242 241 234) 1px, transparent 1px); background-size: 80px 80px;"/>

    <!-- Glow orb -->
    <div class="absolute -top-32 -right-32 w-[600px] h-[600px] rounded-full bg-ember/10 blur-[120px] pointer-events-none animate-pulse-slow"/>

    <div class="relative max-w-7xl mx-auto px-6 w-full">
      <div class="grid lg:grid-cols-12 gap-8 items-end">
        <div class="lg:col-span-9">
          <!-- Eyebrow -->
          <div class="overflow-hidden mb-6">
            <p data-hero-eyebrow class="font-mono text-sm text-ember tracking-wider">
              ◉ Hi, I'm
            </p>
          </div>

          <!-- Big display name -->
          <h1 class="font-display font-light text-mega text-bone-100 leading-[0.92] tracking-tightest">
            <span class="reveal-line block"><span data-hero-line class="inline-block">Rafi</span></span>
            <span class="reveal-line block"><span data-hero-line class="inline-block font-display-italic text-ember">Alamien</span></span>
            <span class="reveal-line block"><span data-hero-line class="inline-block">Akbar.</span></span>
          </h1>

          <!-- Tagline -->
          <p
            data-hero-tagline
            class="mt-8 max-w-2xl text-lg md:text-xl text-bone-300 text-balance leading-relaxed"
          >
            {{ profile?.hero_tagline || 'Full Stack Developer building secure, scalable, and human-centered systems.' }}
          </p>

          <!-- CTAs -->
          <div data-hero-cta class="mt-10 flex flex-wrap items-center gap-4">
            <a
              :href="profile?.cv_url || '#'"
              target="_blank"
              rel="noopener"
              class="group inline-flex items-center gap-3 px-6 py-3.5 rounded-full
                     bg-ember text-ink-900 font-medium
                     hover:bg-ember-400 transition-all
                     hover:shadow-[0_0_40px_-5px_rgba(255,106,61,0.5)]"
            >
              <span>Download CV</span>
              <span class="w-8 h-8 rounded-full bg-ink-900/20 flex items-center justify-center
                           transition-transform group-hover:translate-x-0.5">
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                  <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
              </span>
            </a>

            <button
              @click="scrollToProjects"
              class="group inline-flex items-center gap-2 px-6 py-3.5 rounded-full
                     border border-ink-600 text-bone-100
                     hover:border-ember hover:text-ember transition"
            >
              <span>See my work</span>
              <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-y-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M5 12l7 7 7-7"/>
              </svg>
            </button>
          </div>

          <!-- Quick socials -->
          <div data-hero-meta class="mt-12 flex items-center gap-6 font-mono text-xs uppercase tracking-wider text-bone-400">
            <span class="hidden sm:inline">/ socials</span>
            <a v-if="profile?.github_url" :href="profile.github_url" target="_blank" rel="noopener" class="hover:text-ember transition">github</a>
            <a v-if="profile?.linkedin_url" :href="profile.linkedin_url" target="_blank" rel="noopener" class="hover:text-ember transition">linkedin</a>
            <a v-if="profile?.instagram_url" :href="profile.instagram_url" target="_blank" rel="noopener" class="hover:text-ember transition">instagram</a>
          </div>
        </div>

        <!-- Avatar / portrait -->
        <div class="lg:col-span-3 hidden lg:block">
          <div data-hero-portrait class="relative">
            <div class="aspect-[3/4] rounded-2xl overflow-hidden border border-ink-600 bg-ink-800 relative">
              <img
                v-if="profile?.avatar_url"
                :src="profile.avatar_url"
                alt="Rafi Alamien Akbar"
                class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-700"
              />
              <div v-else class="w-full h-full bg-gradient-to-br from-ink-700 to-ink-900 flex items-center justify-center font-display text-6xl text-bone-400/30">
                RA
              </div>
              <!-- Overlay tag -->
              <div class="absolute bottom-3 left-3 right-3 bg-ink-900/80 backdrop-blur rounded-lg px-3 py-2 font-mono text-xs">
                <div class="text-ember">{{ profile?.location || 'Bandung, ID' }}</div>
                <div class="text-bone-400">Available · {{ new Date().getFullYear() }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Scroll indicator -->
      <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-bone-400">
        <span class="font-mono text-[10px] uppercase tracking-widest">scroll</span>
        <div class="w-px h-12 bg-gradient-to-b from-ember to-transparent"/>
      </div>
    </div>
  </section>
</template>
