import { defineStore } from 'pinia'

interface AdminUser {
  id: number
  name: string
  email: string
}

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null as AdminUser | null,
    token: '' as string,
  }),
  getters: {
    isAuthenticated: (s) => !!s.token,
  },
  actions: {
    hydrate() {
      if (import.meta.client) {
        this.token = localStorage.getItem('admin_token') || ''
        const u = localStorage.getItem('admin_user')
        this.user = u ? JSON.parse(u) : null
      }
    },
    setSession(token: string, user: AdminUser) {
      this.token = token
      this.user = user
      if (import.meta.client) {
        localStorage.setItem('admin_token', token)
        localStorage.setItem('admin_user', JSON.stringify(user))
      }
    },
    clear() {
      this.token = ''
      this.user = null
      if (import.meta.client) {
        localStorage.removeItem('admin_token')
        localStorage.removeItem('admin_user')
      }
    },
  },
})
