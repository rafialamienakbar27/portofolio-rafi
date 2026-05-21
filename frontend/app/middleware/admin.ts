export default defineNuxtRouteMiddleware((to) => {
  const auth = useAuthStore()

  // Skip kalau di halaman login itu sendiri
  if (to.path === '/admin/login') return

  if (!auth.isAuthenticated) {
    return navigateTo('/admin/login')
  }
})
