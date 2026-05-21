/**
 * Wrapper $fetch yang menambahkan baseURL & Authorization header otomatis.
 * Token diambil dari useAuth() (Pinia store).
 */
export const useApi = () => {
  const config = useRuntimeConfig()
  const auth = useAuthStore()

  const api = $fetch.create({
    baseURL: config.public.apiBase,
    onRequest({ options }) {
      const headers = new Headers(options.headers)
      headers.set('Accept', 'application/json')
      if (auth.token) {
        headers.set('Authorization', `Bearer ${auth.token}`)
      }
      options.headers = headers
    },
    onResponseError({ response }) {
      if (response.status === 401) {
        auth.clear()
        if (import.meta.client) {
          navigateTo('/admin/login')
        }
      }
    },
  })

  return api
}
