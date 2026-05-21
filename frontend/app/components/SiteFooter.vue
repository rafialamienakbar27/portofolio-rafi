<script setup lang="ts">
const profile = useState<any>('profile')
const year = new Date().getFullYear()
</script>

<template>
  <footer class="relative border-t border-ink-700 mt-32">
    <!-- Big marquee text -->
    <div class="overflow-hidden py-12 border-b border-ink-700">
      <div class="marquee-track">
        <span v-for="i in 6" :key="i"
          class="font-display text-mega font-light tracking-tightest text-ink-700 pr-12 leading-none">
          Let's build something
          <span class="font-display-italic text-ember">together</span> —
        </span>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-12 grid md:grid-cols-3 gap-8">
      <div>
        <h3 class="font-display text-2xl mb-2">Rafi Al Amien Akbar</h3>
        <p class="text-bone-400 text-sm">{{ profile?.headline || 'Full Stack Developer' }}</p>
        <p class="text-bone-400 text-sm mt-1">{{ profile?.location || 'Bandung, Indonesia' }}</p>
      </div>

      <div>
        <h4 class="font-mono text-xs uppercase tracking-wider text-ember mb-3">Reach me</h4>
        <ul class="space-y-2 text-sm">
          <li v-if="profile?.email">
            <a :href="`mailto:${profile.email}`" class="text-bone-100 hover:text-ember transition">
              {{ profile.email }}
            </a>
          </li>
          <li v-if="profile?.phone" class="text-bone-400">{{ profile.phone }}</li>
        </ul>
      </div>

      <div>
        <h4 class="font-mono text-xs uppercase tracking-wider text-ember mb-3">Elsewhere</h4>
        <ul class="space-y-2 text-sm">
          <li v-if="profile?.github_url">
            <a :href="profile.github_url" target="_blank" rel="noopener"
              class="text-bone-100 hover:text-ember transition">GitHub ↗</a>
          </li>
          <li v-if="profile?.linkedin_url">
            <a :href="profile.linkedin_url" target="_blank" rel="noopener"
              class="text-bone-100 hover:text-ember transition">LinkedIn ↗</a>
          </li>
          <li v-if="profile?.instagram_url">
            <a :href="profile.instagram_url" target="_blank" rel="noopener"
              class="text-bone-100 hover:text-ember transition">Instagram ↗</a>
          </li>
        </ul>
      </div>
    </div>

    <div class="border-t border-ink-700 py-6 text-center font-mono text-xs text-bone-400">
      © {{ year }} Rafi Al Amien Akbar — Built with Nuxt, Laravel, GSAP &amp; Lenis.
    </div>
  </footer>
</template>
