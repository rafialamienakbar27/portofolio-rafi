<script setup lang="ts">
const profile = useState<any>('profile')
const { $gsap } = useNuxtApp() as any
const root = ref<HTMLElement | null>(null)

onMounted(() => {
  if (!$gsap || !root.value) return
  const ctx = $gsap.context(() => {
    $gsap.from('[data-contact-line]', {
      scrollTrigger: { trigger: root.value, start: 'top 70%' },
      yPercent: 100, opacity: 0, duration: 1.2, stagger: 0.1, ease: 'expo.out',
    })
  }, root.value)
  onBeforeUnmount(() => ctx.revert())
})
</script>

<template>
  <section ref="root" id="contact" class="py-32 relative overflow-hidden">
    <!-- Background big text -->
    <div class="absolute inset-0 flex items-center pointer-events-none opacity-[0.04]">
      <span class="font-display text-[32rem] text-bone-100 leading-none tracking-tightest">@</span>
    </div>

    <div class="relative max-w-7xl mx-auto px-6 text-center">
      <p class="font-mono text-sm text-ember mb-6">◇ 04 / contact</p>

      <h2 class="font-display text-huge text-bone-100 leading-[0.95] tracking-tightest mx-auto max-w-5xl">
        <span class="reveal-line block"><span data-contact-line class="inline-block">Have a project</span></span>
        <span class="reveal-line block"><span data-contact-line class="inline-block font-display-italic text-ember">in mind?</span></span>
        <span class="reveal-line block"><span data-contact-line class="inline-block">Let's talk.</span></span>
      </h2>

      <div class="mt-12 flex flex-col items-center gap-6">
        <a
          v-if="profile?.email"
          :href="`mailto:${profile.email}`"
          class="group inline-flex items-center gap-3 text-xl md:text-2xl text-bone-100 hover:text-ember transition border-b border-ink-600 hover:border-ember pb-1"
        >
          {{ profile.email }}
          <svg class="w-5 h-5 transition-transform group-hover:translate-x-1 group-hover:-translate-y-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M7 17L17 7M7 7h10v10"/>
          </svg>
        </a>

        <div class="flex items-center gap-4 mt-6 font-mono text-xs uppercase tracking-wider">
          <a v-if="profile?.github_url" :href="profile.github_url" target="_blank" rel="noopener"
             class="px-4 py-2 rounded-full border border-ink-600 hover:border-ember hover:text-ember transition">
            GitHub
          </a>
          <a v-if="profile?.linkedin_url" :href="profile.linkedin_url" target="_blank" rel="noopener"
             class="px-4 py-2 rounded-full border border-ink-600 hover:border-ember hover:text-ember transition">
            LinkedIn
          </a>
          <a v-if="profile?.instagram_url" :href="profile.instagram_url" target="_blank" rel="noopener"
             class="px-4 py-2 rounded-full border border-ink-600 hover:border-ember hover:text-ember transition">
            Instagram
          </a>
        </div>

        <a
          v-if="profile?.cv_url"
          :href="profile.cv_url"
          target="_blank"
          rel="noopener"
          class="mt-6 inline-flex items-center gap-2 font-mono text-xs uppercase tracking-wider text-bone-400 hover:text-ember transition"
        >
          or download my CV ↗
        </a>
      </div>
    </div>
  </section>
</template>
