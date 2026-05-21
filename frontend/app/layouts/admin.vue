<script setup lang="ts">
const auth = useAuthStore()
const api = useApi()

const logout = async () => {
  try { await api('/auth/logout', { method: 'POST' }) } catch {}
  auth.clear()
  await navigateTo('/admin/login')
}

const route = useRoute()
const navItems = [
  { to: '/admin', label: 'Dashboard', icon: '◉' },
  { to: '/admin/profile', label: 'Profile', icon: '◐' },
  { to: '/admin/experiences', label: 'Experiences', icon: '◇' },
  { to: '/admin/projects', label: 'Projects', icon: '◆' },
]
</script>

<template>
  <div class="min-h-screen bg-ink-950 text-bone-100 font-sans">
    <!-- Top bar -->
    <header class="border-b border-ink-700 bg-ink-900/80 backdrop-blur sticky top-0 z-20">
      <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <NuxtLink to="/admin" class="font-display text-xl tracking-tight">
          <span class="text-ember">Rafi</span>.cms
        </NuxtLink>
        <div class="flex items-center gap-4">
          <NuxtLink
            to="/"
            target="_blank"
            class="text-sm text-bone-400 hover:text-bone-100 transition"
          >
            View site ↗
          </NuxtLink>
          <span class="text-bone-400 text-sm hidden sm:inline">
            {{ auth.user?.name }}
          </span>
          <button @click="logout" class="admin-btn-ghost text-sm px-3 py-1.5">
            Logout
          </button>
        </div>
      </div>
    </header>

    <div class="max-w-7xl mx-auto px-6 py-8 grid grid-cols-12 gap-8">
      <!-- Sidebar -->
      <aside class="col-span-12 md:col-span-3 lg:col-span-2">
        <nav class="space-y-1">
          <NuxtLink
            v-for="item in navItems"
            :key="item.to"
            :to="item.to"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition text-sm"
            :class="route.path === item.to || (item.to !== '/admin' && route.path.startsWith(item.to))
              ? 'bg-ember/10 text-ember border border-ember/30'
              : 'text-bone-400 hover:text-bone-100 hover:bg-ink-800 border border-transparent'"
          >
            <span>{{ item.icon }}</span>
            <span>{{ item.label }}</span>
          </NuxtLink>
        </nav>
      </aside>

      <!-- Main content -->
      <main class="col-span-12 md:col-span-9 lg:col-span-10">
        <slot />
      </main>
    </div>
  </div>
</template>
