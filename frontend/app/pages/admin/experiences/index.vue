<script setup lang="ts">
definePageMeta({ layout: 'admin', middleware: 'admin' })

const api = useApi()
const items = ref<any[]>([])
const loading = ref(true)

const load = async () => {
  loading.value = true
  items.value = await api('/admin/experiences')
  loading.value = false
}

const del = async (id: number) => {
  if (!confirm('Hapus experience ini?')) return
  await api(`/admin/experiences/${id}`, { method: 'DELETE' })
  await load()
}

onMounted(load)

const fmtDate = (d: string | null) => d ? new Date(d).toLocaleDateString('en', { month: 'short', year: 'numeric' }) : 'Present'
</script>

<template>
  <div>
    <div class="flex items-center justify-between mb-8">
      <h1 class="font-display text-3xl">Experiences</h1>
      <NuxtLink to="/admin/experiences/new" class="admin-btn">+ New experience</NuxtLink>
    </div>

    <div v-if="loading" class="text-bone-400">Loading...</div>
    <div v-else-if="!items.length" class="bg-ink-900 border border-ink-700 rounded-xl p-12 text-center text-bone-400">
      No experiences yet. Create your first one.
    </div>
    <div v-else class="space-y-3">
      <article
        v-for="e in items"
        :key="e.id"
        class="bg-ink-900 border border-ink-700 rounded-xl p-5 flex items-center gap-4 hover:border-ember/30 transition"
      >
        <div class="flex-1 min-w-0">
          <div class="flex items-center gap-3 mb-1">
            <span class="font-mono text-xs text-bone-400">#{{ e.order_column }}</span>
            <span v-if="!e.is_published" class="text-[10px] px-2 py-0.5 rounded bg-bone-400/10 text-bone-400 font-mono uppercase">Hidden</span>
          </div>
          <h3 class="font-display text-xl truncate">{{ e.role }}</h3>
          <p class="text-ember text-sm">{{ e.company }}</p>
          <p class="text-xs text-bone-400">{{ fmtDate(e.start_date) }} — {{ fmtDate(e.end_date) }}</p>
        </div>
        <NuxtLink :to="`/admin/experiences/${e.id}`" class="admin-btn-ghost text-sm px-3 py-1.5">Edit</NuxtLink>
        <button @click="del(e.id)" class="text-red-400 hover:text-red-300 text-sm px-3 py-1.5">Delete</button>
      </article>
    </div>
  </div>
</template>
