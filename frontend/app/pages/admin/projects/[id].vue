<script setup lang="ts">
definePageMeta({ layout: 'admin', middleware: 'admin' })

const route = useRoute()
const api = useApi()
const isNew = computed(() => route.params.id === 'new')

const form = ref<any>({
  title: '', slug: '', subtitle: '', description: '',
  cover_image: '', technologies: [], demo_url: '', repo_url: '',
  category: '', year: new Date().getFullYear(),
  order_column: 0, is_featured: false, is_published: true,
})
const techText = ref('')
const saving = ref(false)
const errorMsg = ref('')

const load = async () => {
  if (isNew.value) return
  const data: any = await api(`/admin/projects/${route.params.id}`)
  form.value = { ...data }
  techText.value = (data.technologies || []).join(', ')
}
onMounted(load)

const submit = async () => {
  saving.value = true
  errorMsg.value = ''
  try {
    form.value.technologies = techText.value.split(',').map((s) => s.trim()).filter(Boolean)
    if (!form.value.slug) delete form.value.slug

    if (isNew.value) {
      await api('/admin/projects', { method: 'POST', body: form.value })
    } else {
      await api(`/admin/projects/${route.params.id}`, { method: 'PUT', body: form.value })
    }
    await navigateTo('/admin/projects')
  } catch (e: any) {
    errorMsg.value = e?.data?.message || 'Save failed'
  } finally {
    saving.value = false
  }
}
</script>

<template>
  <div>
    <NuxtLink to="/admin/projects" class="text-sm text-bone-400 hover:text-ember">← Back</NuxtLink>
    <h1 class="font-display text-3xl mt-2 mb-8">{{ isNew ? 'New project' : 'Edit project' }}</h1>

    <form @submit.prevent="submit" class="space-y-5 bg-ink-900 border border-ink-700 rounded-xl p-6">
      <div><label class="admin-label">Title *</label><input v-model="form.title" required class="admin-input"/></div>
      <div>
        <label class="admin-label">Slug (kosongkan untuk auto-generate)</label>
        <input v-model="form.slug" class="admin-input" placeholder="auto-from-title"/>
      </div>
      <div><label class="admin-label">Subtitle</label><input v-model="form.subtitle" class="admin-input"/></div>
      <div><label class="admin-label">Description</label><textarea v-model="form.description" rows="6" class="admin-input"/></div>
      <div><label class="admin-label">Cover image URL</label><input v-model="form.cover_image" type="url" class="admin-input"/></div>

      <div class="grid sm:grid-cols-2 gap-4">
        <div><label class="admin-label">Demo URL</label><input v-model="form.demo_url" type="url" class="admin-input"/></div>
        <div><label class="admin-label">Repo URL</label><input v-model="form.repo_url" type="url" class="admin-input"/></div>
      </div>

      <div>
        <label class="admin-label">Technologies (comma-separated)</label>
        <input v-model="techText" class="admin-input" placeholder="Laravel, Nuxt, PostgreSQL"/>
      </div>

      <div class="grid sm:grid-cols-3 gap-4">
        <div><label class="admin-label">Category</label><input v-model="form.category" class="admin-input" placeholder="Government"/></div>
        <div><label class="admin-label">Year</label><input v-model.number="form.year" type="number" class="admin-input"/></div>
        <div><label class="admin-label">Order</label><input v-model.number="form.order_column" type="number" min="0" class="admin-input"/></div>
      </div>

      <div class="flex gap-6">
        <label class="flex items-center gap-2 cursor-pointer">
          <input v-model="form.is_featured" type="checkbox" class="w-4 h-4 accent-ember"/>
          <span class="text-sm">Featured</span>
        </label>
        <label class="flex items-center gap-2 cursor-pointer">
          <input v-model="form.is_published" type="checkbox" class="w-4 h-4 accent-ember"/>
          <span class="text-sm">Published</span>
        </label>
      </div>

      <div v-if="errorMsg" class="text-red-400 text-sm">{{ errorMsg }}</div>

      <div class="flex justify-end gap-3 pt-4 border-t border-ink-700">
        <NuxtLink to="/admin/projects" class="admin-btn-ghost">Cancel</NuxtLink>
        <button type="submit" class="admin-btn" :disabled="saving">
          {{ saving ? 'Saving...' : (isNew ? 'Create' : 'Update') }}
        </button>
      </div>
    </form>
  </div>
</template>
