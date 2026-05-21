<script setup lang="ts">
definePageMeta({ layout: 'admin', middleware: 'admin' })

const api = useApi()
const items = ref<any[]>([])
const loading = ref(true)

const load = async () => {
  loading.value = true
  items.value = await api('/admin/projects')
  loading.value = false
}

const del = async (id: number) => {
  if (!confirm('Hapus project ini?')) return
  await api(`/admin/projects/${id}`, { method: 'DELETE' })
  await load()
}

onMounted(load)
</script>

<template>
  <div>
    <div class="flex items-center justify-between mb-8">
      <h1 class="font-display text-3xl">Projects</h1>
      <NuxtLink to="/admin/projects/new" class="admin-btn">+ New project</NuxtLink>
    </div>

    <div v-if="loading" class="text-bone-400">Loading...</div>
    <div v-else-if="!items.length" class="bg-ink-900 border border-ink-700 rounded-xl p-12 text-center text-bone-400">
      No projects yet.
    </div>
    <div v-else class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
      <article
        v-for="p in items"
        :key="p.id"
        class="bg-ink-900 border border-ink-700 rounded-xl overflow-hidden hover:border-ember/30 transition flex flex-col"
      >
        <div class="aspect-[16/9] bg-ink-800 overflow-hidden">
          <img v-if="p.cover_image" :src="p.cover_image" :alt="p.title" class="w-full h-full object-cover"/>
        </div>
        <div class="p-4 flex-1 flex flex-col">
          <div class="flex items-center gap-2 mb-2">
            <span class="font-mono text-xs text-bone-400">#{{ p.order_column }}</span>
            <span v-if="p.is_featured" class="text-[10px] px-1.5 py-0.5 rounded bg-ember text-ink-900 font-mono uppercase">Featured</span>
            <span v-if="!p.is_published" class="text-[10px] px-1.5 py-0.5 rounded bg-bone-400/10 text-bone-400 font-mono uppercase">Hidden</span>
          </div>
          <h3 class="font-display text-lg leading-tight">{{ p.title }}</h3>
          <p class="text-xs text-bone-400 mt-1 mb-3 flex-1">{{ p.subtitle }}</p>

          <div class="flex gap-2 mt-auto pt-3 border-t border-ink-700">
            <NuxtLink :to="`/admin/projects/${p.id}`" class="admin-btn-ghost text-xs px-3 py-1.5 flex-1 justify-center">Edit</NuxtLink>
            <button @click="del(p.id)" class="text-red-400 hover:text-red-300 text-xs px-3 py-1.5">Delete</button>
          </div>
        </div>
      </article>
    </div>
  </div>
</template>
