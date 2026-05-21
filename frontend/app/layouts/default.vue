<script setup lang="ts">
const cursorRef = ref<HTMLElement | null>(null)
const isHovering = ref(false)

onMounted(() => {
  // Magnetic cursor
  let raf = 0
  let tx = 0, ty = 0, cx = 0, cy = 0

  const onMove = (e: MouseEvent) => {
    tx = e.clientX
    ty = e.clientY
  }
  const loop = () => {
    cx += (tx - cx) * 0.18
    cy += (ty - cy) * 0.18
    if (cursorRef.value) {
      cursorRef.value.style.setProperty('--cursor-x', `${cx}px`)
      cursorRef.value.style.setProperty('--cursor-y', `${cy}px`)
    }
    raf = requestAnimationFrame(loop)
  }
  window.addEventListener('mousemove', onMove)
  loop()

  // Hover detection on interactive elements
  const handleEnter = () => (isHovering.value = true)
  const handleLeave = () => (isHovering.value = false)
  document.querySelectorAll('a, button, [data-cursor-hover]').forEach((el) => {
    el.addEventListener('mouseenter', handleEnter)
    el.addEventListener('mouseleave', handleLeave)
  })

  onBeforeUnmount(() => {
    cancelAnimationFrame(raf)
    window.removeEventListener('mousemove', onMove)
  })
})
</script>

<template>
  <div class="relative min-h-screen bg-ink-900 text-bone-100">
    <!-- Cursor blob (hidden on touch) -->
    <div
      ref="cursorRef"
      class="cursor-blob hidden md:block"
      :class="{ hover: isHovering }"
    />

    <!-- Grain overlay -->
    <div class="noise-overlay" aria-hidden="true" />

    <SiteNav />

    <main>
      <slot />
    </main>

    <SiteFooter />
  </div>
</template>
