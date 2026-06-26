<script setup lang="ts">
const config = useRuntimeConfig()

// Fetch agregat sekali — server-side untuk SEO
const { data, error } = await useFetch<any>('/public/bootstrap', {
  baseURL: config.public.apiBase,
  key: 'bootstrap',
  default: () => ({ profile: null, experiences: [], projects: [] }),
})

// Bagi ke useState supaya semua child component bisa akses
useState('profile', () => data.value?.profile || null)
useState('experiences', () => data.value?.experiences || [])
useState('projects', () => data.value?.projects || [])

useHead({
  title: () => {
    const p = data.value?.profile
    return p ? `${p.name} — ${p.headline}` : 'Portfolio'
  },
})
</script>

<template>
  <div>
    <!-- Error fallback -->
    <div v-if="error" class="min-h-screen flex items-center justify-center">
      <div class="text-center p-8">
        <p class="font-mono text-ember mb-2">◉ Connection error</p>
        <p class="text-bone-400">Unable to reach API at <code>{{ config.public.apiBase }}</code></p>
        <p class="text-bone-400 text-sm mt-2">Make sure the Laravel backend is running.</p>
      </div>
    </div>

    <template v-else>
      <HeroSection />
      <AboutSection />
      <ExperienceSection />
      <ProjectsSection />
      <ContactSection />
    </template>
  </div>
</template>
