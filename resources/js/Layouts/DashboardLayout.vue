<template>
  <div class="min-h-screen bg-vitality-dark">
    <div class="fixed inset-0 grid-overlay pointer-events-none z-0"></div>

    <!-- Sidebar -->
    <aside class="fixed left-0 top-0 bottom-0 w-64 z-40 border-r border-white/5 bg-[#041B33]/80 backdrop-blur-xl flex flex-col">
      <!-- Logo -->
      <div class="p-6 border-b border-white/5">
        <Link :href="route('home')" class="flex items-center gap-2">
          <div class="w-8 h-8 rounded-full bg-gradient-to-br from-vitality-cyan to-vitality-cyan2 flex items-center justify-center">
            <span class="text-vitality-bg font-bold text-xs">V</span>
          </div>
          <span class="font-serif text-lg font-semibold text-white">Vitality Inside</span>
        </Link>
      </div>

      <!-- Nav -->
      <nav class="flex-1 py-6 px-3 space-y-1">
        <Link v-for="item in navItems" :key="item.route"
          :href="route(item.route)"
          class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all"
          :class="isActive(item.route) ? 'bg-vitality-cyan/10 text-vitality-cyan' : 'text-vitality-text hover:text-white hover:bg-white/5'">
          <span class="text-lg">{{ item.icon }}</span>
          {{ item.label }}
        </Link>
      </nav>

      <!-- User info -->
      <div class="p-4 border-t border-white/5">
        <div class="flex items-center gap-3 mb-3">
          <div class="w-9 h-9 rounded-full bg-vitality-cyan/20 flex items-center justify-center text-vitality-cyan font-bold text-sm">
            {{ auth?.user?.name?.[0]?.toUpperCase() }}
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-white text-sm font-medium truncate">{{ auth?.user?.name }}</p>
            <p class="text-vitality-text text-xs truncate">{{ auth?.user?.email }}</p>
          </div>
        </div>
        <Link :href="route('logout')" method="post" as="button"
          class="w-full text-left text-xs text-vitality-text hover:text-red-400 transition-colors py-1">
          Sign out →
        </Link>
      </div>
    </aside>

    <!-- Main content -->
    <main class="ml-64 relative z-10 min-h-screen p-8">
      <slot />
    </main>
  </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const auth = computed(() => usePage().props.auth)

const navItems = [
  { icon: '🏠', label: 'Dashboard',    route: 'dashboard' },
  { icon: '🎧', label: 'My Programs',  route: 'dashboard' },
  { icon: '📦', label: 'My Orders',    route: 'dashboard.orders' },
  { icon: '👤', label: 'Profile',      route: 'dashboard.profile' },
  { icon: '🛒', label: 'Shop',         route: 'shop' },
]

const isActive = (r) => route().current(r)
</script>
