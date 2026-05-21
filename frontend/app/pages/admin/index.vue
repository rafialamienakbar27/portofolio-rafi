<script setup lang="ts">
definePageMeta({ layout: 'admin', middleware: 'admin' })

const api = useApi()
const stats = ref({ projects: 0, experiences: 0 })

onMounted(async () => {
  try {
    const [projects, experiences]: any = await Promise.all([
      api('/admin/projects'),
      api('/admin/experiences'),
    ])
    stats.value.projects = projects.length
    stats.value.experiences = experiences.length
  } catch {}
})

const auth = useAuthStore()
</script>

<template>
  <div>
    <h1 class="font-display text-4xl mb-2">
      Welcome back, <span class="text-ember">{{ auth.user?.name?.split(' ')[0] }}</span>.
    </h1>
    <p class="text-bone-400 mb-10">Manage your portfolio content from this panel.</p>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
      <NuxtLink
        to="/admin/profile"
        class="block bg-ink-900 border border-ink-700 rounded-xl p-6 hover:border-ember/40 transition group"
      >
        <div class="font-mono text-xs text-bone-400 mb-2">/ profile</div>
        <div class="font-display text-2xl mb-1">Edit Profile</div>
        <div class="text-sm text-bone-400">Name, bio, CV link, socials</div>
        <div class="mt-4 text-ember text-sm font-mono opacity-0 group-hover:opacity-100 transition">→</div>
      </NuxtLink>

      <NuxtLink
        to="/admin/experiences"
        class="block bg-ink-900 border border-ink-700 rounded-xl p-6 hover:border-ember/40 transition group"
      >
        <div class="font-mono text-xs text-bone-400 mb-2">/ experiences</div>
        <div class="font-display text-2xl mb-1">{{ stats.experiences }} entries</div>
        <div class="text-sm text-bone-400">Manage work history</div>
        <div class="mt-4 text-ember text-sm font-mono opacity-0 group-hover:opacity-100 transition">→</div>
      </NuxtLink>

      <NuxtLink
        to="/admin/projects"
        class="block bg-ink-900 border border-ink-700 rounded-xl p-6 hover:border-ember/40 transition group"
      >
        <div class="font-mono text-xs text-bone-400 mb-2">/ projects</div>
        <div class="font-display text-2xl mb-1">{{ stats.projects }} projects</div>
        <div class="text-sm text-bone-400">CRUD all portfolio items</div>
        <div class="mt-4 text-ember text-sm font-mono opacity-0 group-hover:opacity-100 transition">→</div>
      </NuxtLink>
    </div>

    <div class="mt-12 p-6 bg-ember/5 border border-ember/20 rounded-xl">
      <h3 class="font-display text-lg mb-2">Quick tips</h3>
      <ul class="text-sm text-bone-300 space-y-1 list-disc list-inside">
        <li>Drag-friendly: gunakan field <code class="text-ember font-mono">order_column</code> untuk mengurutkan.</li>
        <li>Set <code class="text-ember font-mono">is_published = false</code> untuk menyembunyikan dari publik tanpa menghapus.</li>
        <li>URL CV bisa diupdate kapan saja dari halaman Profile — frontend mengambil dari database.</li>
      </ul>
    </div>
  </div>
</template>
