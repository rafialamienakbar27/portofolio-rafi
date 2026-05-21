// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: "2025-01-01",
  devtools: { enabled: true },

  // Nuxt 4 future compatibility — pakai struktur app/ baru
  future: {
    compatibilityVersion: 4,
  },

  modules: ["@nuxtjs/tailwindcss", "@pinia/nuxt", "@vueuse/nuxt"],

  css: ["~/assets/css/main.css"],

  app: {
    head: {
      title: "Rafi Alamien Akbar — Full Stack Developer",
      htmlAttrs: { lang: "en" },
      meta: [
        { charset: "utf-8" },
        { name: "viewport", content: "width=device-width, initial-scale=1" },
        {
          name: "description",
          content:
            "Rafi Alamien Akbar — Full Stack Developer building secure, scalable government information systems in West Java, Indonesia.",
        },
        { property: "og:title", content: "Rafi Alamien Akbar — Portfolio" },
        { property: "og:type", content: "website" },
        { name: "theme-color", content: "#0A0A0F" },
      ],
      link: [
        { rel: "icon", type: "image/svg+xml", href: "/favicon.svg" },
        { rel: "preconnect", href: "https://fonts.googleapis.com" },
        {
          rel: "preconnect",
          href: "https://fonts.gstatic.com",
          crossorigin: "",
        },
        {
          rel: "stylesheet",
          href: "https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght,SOFT,WONK@9..144,300..900,0..100,0..1&family=Inter+Tight:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap",
        },
      ],
    },
    pageTransition: { name: "page", mode: "out-in" },
  },

  runtimeConfig: {
    public: {
      apiBase:
        process.env.NUXT_PUBLIC_API_BASE ||
        "https://portofolio-rafi-production.up.railway.app",
    },
  },

  nitro: {
    compressPublicAssets: true,
  },

  experimental: {
    viewTransition: true,
    payloadExtraction: false,
  },
});
