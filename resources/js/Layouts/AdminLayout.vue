<template>
  <div class="min-h-screen bg-vitality-dark flex">
    <div class="fixed inset-0 grid-overlay pointer-events-none z-0"></div>

    <!-- Sidebar -->
    <aside class="fixed left-0 top-0 bottom-0 w-64 z-40 border-r border-white/5 bg-[#020F1F]/90 backdrop-blur-xl flex flex-col">
      <div class="p-6 border-b border-white/5">
        <div class="flex items-center gap-2 mb-1">
          <div class="w-8 h-8 rounded-full bg-gradient-to-br from-vitality-cyan to-vitality-cyan2 flex items-center justify-center">
            <span class="text-vitality-bg font-bold text-xs">A</span>
          </div>
          <span class="font-serif text-lg font-semibold text-white">Admin Panel</span>
        </div>
        <p class="text-vitality-text text-xs">Vitality Inside</p>
      </div>

      <nav class="flex-1 py-4 px-3 overflow-y-auto">
        <div class="mb-3">
          <p class="text-vitality-text/50 text-[10px] uppercase tracking-widest px-3 mb-2">Overview</p>
          <Link v-for="item in navGroups[0]" :key="item.route"
            :href="route(item.route)"
            class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm transition-all mb-0.5"
            :class="route().current(item.route) ? 'bg-vitality-cyan/10 text-vitality-cyan' : 'text-vitality-text hover:text-white hover:bg-white/5'">
            <span>{{ item.icon }}</span>{{ item.label }}
          </Link>
        </div>
        <div class="mb-3">
          <p class="text-vitality-text/50 text-[10px] uppercase tracking-widest px-3 mb-2">Catalog</p>
          <Link v-for="item in navGroups[1]" :key="item.route"
            :href="route(item.route)"
            class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm transition-all mb-0.5"
            :class="route().current(item.route) ? 'bg-vitality-cyan/10 text-vitality-cyan' : 'text-vitality-text hover:text-white hover:bg-white/5'">
            <span>{{ item.icon }}</span>{{ item.label }}
          </Link>
        </div>
        <div class="mb-3">
          <p class="text-vitality-text/50 text-[10px] uppercase tracking-widest px-3 mb-2">Business</p>
          <Link v-for="item in navGroups[2]" :key="item.route"
            :href="route(item.route)"
            class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm transition-all mb-0.5"
            :class="route().current(item.route) ? 'bg-vitality-cyan/10 text-vitality-cyan' : 'text-vitality-text hover:text-white hover:bg-white/5'">
            <span>{{ item.icon }}</span>{{ item.label }}
          </Link>
        </div>
        <div>
          <p class="text-vitality-text/50 text-[10px] uppercase tracking-widest px-3 mb-2">System</p>
          <Link v-for="item in navGroups[3]" :key="item.route"
            :href="route(item.route)"
            class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm transition-all mb-0.5"
            :class="route().current(item.route) ? 'bg-vitality-cyan/10 text-vitality-cyan' : 'text-vitality-text hover:text-white hover:bg-white/5'">
            <span>{{ item.icon }}</span>{{ item.label }}
          </Link>
        </div>
      </nav>

      <div class="p-4 border-t border-white/5">
        <Link :href="route('home')" class="flex items-center gap-2 text-xs text-vitality-text hover:text-white mb-2 transition-colors">🌐 View Site</Link>
        <Link :href="route('logout')" method="post" as="button" class="w-full text-left text-xs text-vitality-text hover:text-red-400 transition-colors">Sign out →</Link>
      </div>
    </aside>

    <!-- Main -->
    <main class="ml-64 flex-1 relative z-10 min-h-screen p-8">
      <!-- Flash messages -->
      <div v-if="$page.props.flash?.success" class="mb-6 bg-vitality-cyan/10 border border-vitality-cyan/30 rounded-xl px-4 py-3 text-vitality-cyan text-sm">
        ✓ {{ $page.props.flash.success }}
      </div>
      <div v-if="$page.props.flash?.error" class="mb-6 bg-red-500/10 border border-red-500/30 rounded-xl px-4 py-3 text-red-400 text-sm">
        ✕ {{ $page.props.flash.error }}
      </div>
      <slot />
    </main>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

const navGroups = [
  [{ icon: '📊', label: 'Dashboard',     route: 'admin.dashboard' }],
  [
    { icon: '🎯', label: 'Programs',     route: 'admin.programs' },
    { icon: '📂', label: 'Categories',   route: 'admin.categories' },
    { icon: '💬', label: 'Testimonials', route: 'admin.testimonials' },
    { icon: '✍️', label: 'Blog Posts',   route: 'admin.blog' },
  ],
  [
    { icon: '📦', label: 'Orders',        route: 'admin.orders' },
    { icon: '🩺', label: 'Consultations', route: 'admin.consultations' },
    { icon: '👥', label: 'Users',         route: 'admin.users' },
  ],
  [{ icon: '⚙️', label: 'Settings',      route: 'admin.settings' }],
]
</script>
