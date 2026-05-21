<script setup lang="ts">
definePageMeta({ layout: false })

const auth = useAuthStore()
const api = useApi()
const email = ref('')
const password = ref('')
const loading = ref(false)
const errorMsg = ref('')

// Auto-redirect kalau sudah login
onMounted(() => {
  auth.hydrate()
  if (auth.isAuthenticated) navigateTo('/admin')
})

const submit = async () => {
  loading.value = true
  errorMsg.value = ''
  try {
    const res: any = await api('/auth/login', {
      method: 'POST',
      body: { email: email.value, password: password.value },
    })
    auth.setSession(res.token, res.user)
    await navigateTo('/admin')
  } catch (e: any) {
    errorMsg.value = e?.data?.message || 'Login failed. Periksa kredensial Anda.'
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div class="min-h-screen bg-ink-950 text-bone-100 font-sans flex items-center justify-center p-6">
    <div class="w-full max-w-md">
      <NuxtLink to="/" class="font-display text-3xl block mb-2">
        <span class="text-ember">Rafi</span>.cms
      </NuxtLink>
      <p class="text-bone-400 mb-8 font-mono text-xs uppercase tracking-wider">
        Admin panel — restricted area
      </p>

      <form @submit.prevent="submit" class="space-y-5 bg-ink-900 border border-ink-700 rounded-2xl p-8">
        <div>
          <label class="admin-label" for="email">Email</label>
          <input
            id="email" v-model="email" type="email" required autocomplete="email"
            class="admin-input" placeholder="you@example.com"
          />
        </div>
        <div>
          <label class="admin-label" for="password">Password</label>
          <input
            id="password" v-model="password" type="password" required autocomplete="current-password"
            class="admin-input" placeholder="••••••••"
          />
        </div>

        <div v-if="errorMsg" class="text-sm text-red-400 bg-red-500/10 border border-red-500/20 rounded-lg px-3 py-2">
          {{ errorMsg }}
        </div>

        <button type="submit" class="admin-btn w-full justify-center" :disabled="loading">
          <span v-if="loading">Signing in...</span>
          <span v-else>Sign in →</span>
        </button>
      </form>

      <NuxtLink to="/" class="block mt-6 text-center text-sm text-bone-400 hover:text-ember transition">
        ← Back to portfolio
      </NuxtLink>
    </div>
  </div>
</template>
