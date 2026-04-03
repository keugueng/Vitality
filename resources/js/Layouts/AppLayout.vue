<template>
  <div class="min-h-screen bg-vitality-dark">
    <!-- Background effects -->
    <div class="fixed inset-0 grid-overlay pointer-events-none z-0"></div>
    <div class="fixed inset-0 halo-glow pointer-events-none z-0"></div>

    <AppHeader />
    <main class="relative z-10">
      <slot />
    </main>
    <AppFooter />

    <!-- Flash messages -->
    <transition name="fade">
      <div v-if="flash.success" class="fixed bottom-6 right-6 z-50 glass-card border-glow rounded-xl px-5 py-4 text-sm text-vitality-cyan flex items-center gap-3 shadow-xl">
        <span class="text-xl">✓</span> {{ flash.success }}
      </div>
    </transition>
    <transition name="fade">
      <div v-if="flash.error" class="fixed bottom-6 right-6 z-50 glass-card border border-red-500/30 rounded-xl px-5 py-4 text-sm text-red-400 flex items-center gap-3 shadow-xl">
        <span class="text-xl">✕</span> {{ flash.error }}
      </div>
    </transition>
  </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import AppHeader from '@/Components/AppHeader.vue'
import AppFooter from '@/Components/AppFooter.vue'

const flash = computed(() => usePage().props.flash)
</script>
