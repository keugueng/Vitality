<template>
  <div class="min-h-screen bg-vitality-dark">
    <div class="fixed inset-0 grid-overlay pointer-events-none z-0"></div>
    <aside class="fixed left-0 top-0 bottom-0 w-64 z-40 border-r border-white/5 bg-[#041B33]/80 backdrop-blur-xl flex flex-col">
      <div class="p-6 border-b border-white/5">
        <Link :href="route('home')" class="flex items-center gap-2 mb-1">
          <div class="w-8 h-8 rounded-full bg-gradient-to-br from-vitality-gold to-yellow-400 flex items-center justify-center">
            <span class="text-vitality-bg font-bold text-xs">P</span>
          </div>
          <span class="font-serif text-lg font-semibold text-white">PRO Space</span>
        </Link>
        <p class="text-vitality-gold text-xs">Vitality Inside · Professional</p>
      </div>
      <nav class="flex-1 py-6 px-3 space-y-1">
        <Link v-for="item in navItems" :key="item.route"
          :href="route(item.route)"
          class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all"
          :class="route().current(item.route) ? 'bg-vitality-gold/10 text-vitality-gold' : 'text-vitality-text hover:text-white hover:bg-white/5'">
          <span class="text-lg">{{ item.icon }}</span>{{ item.label }}
        </Link>
      </nav>
      <div class="p-4 border-t border-white/5">
        <Link :href="route('logout')" method="post" as="button" class="w-full text-left text-xs text-vitality-text hover:text-red-400 transition-colors">Sign out →</Link>
      </div>
    </aside>
    <main class="ml-64 relative z-10 min-h-screen p-8"><slot /></main>
  </div>
</template>
<script setup>
import { Link } from '@inertiajs/vue3'
const navItems = [
  { icon: '📊', label: 'Dashboard',      route: 'pro.dashboard' },
  { icon: '👥', label: 'My Patients',    route: 'pro.dashboard' },
  { icon: '🎯', label: 'Protocols',      route: 'pro.dashboard' },
  { icon: '🛒', label: 'Shop',           route: 'shop' },
]
</script>
