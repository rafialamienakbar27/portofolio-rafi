<script setup lang="ts">
definePageMeta({ layout: 'admin', middleware: 'admin' })

const api = useApi()
const form = ref<any>({
  name: '', headline: '', bio: '', email: '', phone: '', location: '',
  avatar_url: '', cv_url: '', github_url: '', linkedin_url: '', instagram_url: '',
  hero_tagline: '', skills: [],
})
const saving = ref(false)
const saveMsg = ref('')

const load = async () => {
  const data: any = await api('/admin/profile')
  form.value = { ...data, skills: data.skills || [] }
}
onMounted(load)

const addSkillCategory = () => {
  form.value.skills.push({ category: '', items: [] })
}
const removeSkillCategory = (i: number) => {
  form.value.skills.splice(i, 1)
}
const skillItemsText = (cat: any) => (cat.items || []).join(', ')
const setSkillItems = (cat: any, text: string) => {
  cat.items = text.split(',').map((s) => s.trim()).filter(Boolean)
}

const save = async () => {
  saving.value = true
  saveMsg.value = ''
  try {
    await api('/admin/profile', { method: 'PUT', body: form.value })
    saveMsg.value = '✓ Saved successfully'
  } catch (e: any) {
    saveMsg.value = '✗ ' + (e?.data?.message || 'Save failed')
  } finally {
    saving.value = false
    setTimeout(() => (saveMsg.value = ''), 3000)
  }
}
</script>

<template>
  <div>
    <div class="flex items-center justify-between mb-8">
      <h1 class="font-display text-3xl">Profile</h1>
      <span v-if="saveMsg" class="text-sm font-mono" :class="saveMsg.startsWith('✓') ? 'text-moss' : 'text-red-400'">
        {{ saveMsg }}
      </span>
    </div>

    <form @submit.prevent="save" class="space-y-6">
      <!-- Identity -->
      <fieldset class="bg-ink-900 border border-ink-700 rounded-xl p-6 space-y-4">
        <legend class="font-mono text-xs uppercase tracking-wider text-ember px-2">Identity</legend>
        <div class="grid sm:grid-cols-2 gap-4">
          <div><label class="admin-label">Name</label><input v-model="form.name" class="admin-input"/></div>
          <div><label class="admin-label">Headline</label><input v-model="form.headline" class="admin-input"/></div>
        </div>
        <div><label class="admin-label">Hero tagline</label><textarea v-model="form.hero_tagline" rows="2" class="admin-input"/></div>
        <div><label class="admin-label">Bio</label><textarea v-model="form.bio" rows="5" class="admin-input"/></div>
      </fieldset>

      <!-- Contact -->
      <fieldset class="bg-ink-900 border border-ink-700 rounded-xl p-6 space-y-4">
        <legend class="font-mono text-xs uppercase tracking-wider text-ember px-2">Contact</legend>
        <div class="grid sm:grid-cols-3 gap-4">
          <div><label class="admin-label">Email</label><input v-model="form.email" type="email" class="admin-input"/></div>
          <div><label class="admin-label">Phone</label><input v-model="form.phone" class="admin-input"/></div>
          <div><label class="admin-label">Location</label><input v-model="form.location" class="admin-input"/></div>
        </div>
      </fieldset>

      <!-- URLs -->
      <fieldset class="bg-ink-900 border border-ink-700 rounded-xl p-6 space-y-4">
        <legend class="font-mono text-xs uppercase tracking-wider text-ember px-2">Links</legend>
        <div><label class="admin-label">Avatar URL</label><input v-model="form.avatar_url" type="url" class="admin-input"/></div>
        <div>
          <label class="admin-label">CV URL (Google Drive)</label>
          <input v-model="form.cv_url" type="url" class="admin-input" placeholder="https://drive.google.com/file/d/..."/>
          <p class="text-xs text-bone-400 mt-1">Tombol "Download CV" di hero akan otomatis mengikuti URL ini.</p>
        </div>
        <div class="grid sm:grid-cols-3 gap-4">
          <div><label class="admin-label">GitHub</label><input v-model="form.github_url" type="url" class="admin-input"/></div>
          <div><label class="admin-label">LinkedIn</label><input v-model="form.linkedin_url" type="url" class="admin-input"/></div>
          <div><label class="admin-label">Instagram</label><input v-model="form.instagram_url" type="url" class="admin-input"/></div>
        </div>
      </fieldset>

      <!-- Skills -->
      <fieldset class="bg-ink-900 border border-ink-700 rounded-xl p-6 space-y-4">
        <div class="flex items-center justify-between">
          <legend class="font-mono text-xs uppercase tracking-wider text-ember px-2">Skills</legend>
          <button type="button" @click="addSkillCategory" class="admin-btn-ghost text-xs px-3 py-1.5">+ Add category</button>
        </div>

        <div
          v-for="(cat, i) in form.skills"
          :key="i"
          class="grid sm:grid-cols-[1fr_2fr_auto] gap-3 items-end pb-4 border-b border-ink-700 last:border-0"
        >
          <div>
            <label class="admin-label">Category</label>
            <input v-model="cat.category" class="admin-input" placeholder="Frontend"/>
          </div>
          <div>
            <label class="admin-label">Items (comma-separated)</label>
            <input
              :value="skillItemsText(cat)"
              @input="(e: any) => setSkillItems(cat, e.target.value)"
              class="admin-input"
              placeholder="Vue.js, Nuxt, TailwindCSS"
            />
          </div>
          <button type="button" @click="removeSkillCategory(i)" class="text-red-400 px-3 py-2 text-sm">Remove</button>
        </div>
      </fieldset>

      <div class="flex justify-end gap-3">
        <button type="submit" class="admin-btn" :disabled="saving">
          {{ saving ? 'Saving...' : 'Save changes' }}
        </button>
      </div>
    </form>
  </div>
</template>
