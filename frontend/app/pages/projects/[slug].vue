<script setup lang="ts">
const route = useRoute()
const config = useRuntimeConfig()
const slug = route.params.slug as string

const { data: project, error } = await useFetch<any>(
  `/public/projects/${slug}`,
  {
    baseURL: config.public.apiBase,
    key: `project-${slug}`,
  }
)

useHead({
  title: () => project.value?.title ? `${project.value.title} — Rafi Akbar` : 'Project',
})
</script>

<template>
  <div class="pt-32 pb-20">
    <article v-if="project" class="max-w-4xl mx-auto px-6">
      <NuxtLink to="/#projects" class="inline-flex items-center gap-2 font-mono text-xs uppercase tracking-wider text-bone-400 hover:text-ember mb-8 transition">
        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M19 12H5M12 19l-7-7 7-7"/>
        </svg>
        Back to all projects
      </NuxtLink>

      <div class="font-mono text-xs uppercase tracking-wider text-bone-400 mb-4">
        <span v-if="project.category">{{ project.category }}</span>
        <span v-if="project.year">· {{ project.year }}</span>
      </div>

      <h1 class="font-display text-5xl md:text-7xl text-bone-100 leading-[0.95] tracking-tightest">
        {{ project.title }}
      </h1>

      <p v-if="project.subtitle" class="mt-6 text-xl text-ember">{{ project.subtitle }}</p>

      <div v-if="project.cover_image" class="mt-12 rounded-2xl overflow-hidden border border-ink-700">
        <img :src="project.cover_image" :alt="project.title" class="w-full h-auto"/>
      </div>

      <div v-if="project.description" class="mt-12 prose prose-invert max-w-none">
        <p class="text-lg text-bone-300 leading-relaxed text-pretty">{{ project.description }}</p>
      </div>

      <div v-if="project.technologies?.length" class="mt-12 pt-12 border-t border-ink-700">
        <h3 class="font-mono text-xs uppercase tracking-wider text-ember mb-4">Technology stack</h3>
        <div class="flex flex-wrap gap-2">
          <span v-for="t in project.technologies" :key="t"
            class="px-3 py-1.5 rounded-full bg-ink-800 border border-ink-700 text-sm">
            {{ t }}
          </span>
        </div>
      </div>

      <div v-if="project.demo_url || project.repo_url" class="mt-8 flex gap-4">
        <a v-if="project.demo_url" :href="project.demo_url" target="_blank" rel="noopener"
          class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-ember text-ink-900 hover:bg-ember-400 transition">
          Visit demo ↗
        </a>
        <a v-if="project.repo_url" :href="project.repo_url" target="_blank" rel="noopener"
          class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full border border-ink-600 hover:border-ember hover:text-ember transition">
          View repo ↗
        </a>
      </div>
    </article>

    <div v-else-if="error" class="min-h-[50vh] flex items-center justify-center">
      <p class="text-bone-400">Project not found.</p>
    </div>
  </div>
</template>
