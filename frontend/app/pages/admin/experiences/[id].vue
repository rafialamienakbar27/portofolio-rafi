<script setup lang="ts">
definePageMeta({ layout: 'admin', middleware: 'admin' })

const route = useRoute()
const api = useApi()
const isNew = computed(() => route.params.id === 'new')

const form = ref<any>({
  company: '', role: '', location: '',
  start_date: '', end_date: '',
  description: '', technologies: [], company_url: '',
  order_column: 0, is_published: true,
})
const techText = ref('')
const saving = ref(false)
const errorMsg = ref('')

const load = async () => {
  if (isNew.value) return
  const data: any = await api(`/admin/experiences/${route.params.id}`)
  form.value = {
    ...data,
    start_date: data.start_date?.split('T')[0] || '',
    end_date: data.end_date?.split('T')[0] || '',
  }
  techText.value = (data.technologies || []).join(', ')
}
onMounted(load)

const submit = async () => {
  saving.value = true
  errorMsg.value = ''
  try {
    form.value.technologies = techText.value.split(',').map((s) => s.trim()).filter(Boolean)
    form.value.end_date = form.value.end_date || null

    if (isNew.value) {
      await api('/admin/experiences', { method: 'POST', body: form.value })
    } else {
      await api(`/admin/experiences/${route.params.id}`, { method: 'PUT', body: form.value })
    }
    await navigateTo('/admin/experiences')
  } catch (e: any) {
    errorMsg.value = e?.data?.message || 'Save failed'
  } finally {
    saving.value = false
  }
}
</script>

<template>
  <div>
    <NuxtLink to="/admin/experiences" class="text-sm text-bone-400 hover:text-ember">← Back</NuxtLink>
    <h1 class="font-display text-3xl mt-2 mb-8">{{ isNew ? 'New experience' : 'Edit experience' }}</h1>

    <form @submit.prevent="submit" class="space-y-5 bg-ink-900 border border-ink-700 rounded-xl p-6">
      <div class="grid sm:grid-cols-2 gap-4">
        <div><label class="admin-label">Company *</label><input v-model="form.company" required class="admin-input"/></div>
        <div><label class="admin-label">Role *</label><input v-model="form.role" required class="admin-input"/></div>
      </div>
      <div class="grid sm:grid-cols-2 gap-4">
        <div><label class="admin-label">Location</label><input v-model="form.location" class="admin-input"/></div>
        <div><label class="admin-label">Company URL</label><input v-model="form.company_url" type="url" class="admin-input"/></div>
      </div>
      <div class="grid sm:grid-cols-2 gap-4">
        <div><label class="admin-label">Start date *</label><input v-model="form.start_date" type="date" required class="admin-input"/></div>
        <div><label class="admin-label">End date (kosong = sekarang)</label><input v-model="form.end_date" type="date" class="admin-input"/></div>
      </div>
      <div><label class="admin-label">Description</label><textarea v-model="form.description" rows="5" class="admin-input"/></div>
      <div>
        <label class="admin-label">Technologies (comma-separated)</label>
        <input v-model="techText" class="admin-input" placeholder="Laravel, Vue.js, PostgreSQL"/>
      </div>
      <div class="grid sm:grid-cols-2 gap-4">
        <div><label class="admin-label">Order</label><input v-model.number="form.order_column" type="number" min="0" class="admin-input"/></div>
        <div class="flex items-end">
          <label class="flex items-center gap-2 cursor-pointer">
            <input v-model="form.is_published" type="checkbox" class="w-4 h-4 accent-ember"/>
            <span class="text-sm">Published</span>
          </label>
        </div>
      </div>

      <div v-if="errorMsg" class="text-red-400 text-sm">{{ errorMsg }}</div>

      <div class="flex justify-end gap-3 pt-4 border-t border-ink-700">
        <NuxtLink to="/admin/experiences" class="admin-btn-ghost">Cancel</NuxtLink>
        <button type="submit" class="admin-btn" :disabled="saving">
          {{ saving ? 'Saving...' : (isNew ? 'Create' : 'Update') }}
        </button>
      </div>
    </form>
  </div>
</template>
