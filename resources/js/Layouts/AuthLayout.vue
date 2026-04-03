<template>
  <div class="min-h-screen bg-vitality-dark flex items-center justify-center px-4 relative">
    <div class="fixed inset-0 grid-overlay pointer-events-none"></div>
    <div class="fixed inset-0 halo-glow pointer-events-none"></div>
    <div class="relative z-10 w-full max-w-md">
      <div class="text-center mb-8">
        <Link :href="route('home')" class="inline-flex items-center gap-2 group">
          <div class="w-9 h-9 rounded-full bg-gradient-to-br from-vitality-cyan to-vitality-cyan2 flex items-center justify-center">
            <span class="text-vitality-bg font-bold text-sm">V</span>
          </div>
          <span class="font-serif text-2xl font-semibold text-white">Vitality Inside</span>
        </Link>
      </div>
      <slot />
      <p class="text-center text-vitality-text/40 text-xs mt-6">© {{ year }} Vitality Inside</p>
    </div>
  </div>
</template>
<script setup>
import { Link } from '@inertiajs/vue3'
const year = new Date().getFullYear()
</script>
