<template>
  <div class="min-h-screen" style="background: #03142A;">

    <!-- AppHeader principal — même que le reste du site -->
    <AppHeader />

    <!-- Sous-nav dashboard -->
    <div class="fixed top-[68px] md:top-[76px] left-0 right-0 z-40"
      style="background: rgba(4,27,51,0.95); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255,255,255,0.06);">
      <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex items-center gap-1 h-12">
          <!-- Badge My Account -->
          <span class="text-[10px] font-bold tracking-[0.2em] uppercase px-2.5 py-1 rounded-full mr-4"
            style="background: rgba(17,199,201,0.08); color: #11C7C9; border: 1px solid rgba(17,199,201,0.2);">
            My Account
          </span>
          <!-- Tabs -->
          <Link v-for="item in dashNav" :key="item.route"
            :href="route(item.route)"
            class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[11px] font-semibold tracking-wide transition-all"
            :style="isActive(item.route)
              ? 'color: #11C7C9; background: rgba(17,199,201,0.08);'
              : 'color: rgba(157,170,192,0.7);'">
            <span>{{ item.icon }}</span>
            {{ item.label }}
          </Link>
          <!-- User initial + sign out (droite) -->
          <div class="ml-auto flex items-center gap-3">
            <div class="w-7 h-7 rounded-full flex items-center justify-center text-[11px] font-bold flex-shrink-0"
              style="background: rgba(17,199,201,0.15); color: #11C7C9;">
              {{ auth?.user?.name?.[0]?.toUpperCase() }}
            </div>
            <Link :href="route('logout')" method="post" as="button"
              class="text-[11px] font-semibold transition-colors"
              style="color: rgba(157,170,192,0.5);"
              onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='rgba(157,170,192,0.5)'">
              Sign out
            </Link>
          </div>
        </div>
      </div>
    </div>

    <!-- Contenu -->
    <main class="pt-[calc(68px+48px)] md:pt-[calc(76px+48px)] min-h-screen px-6 lg:px-8 py-10">
      <div class="max-w-5xl mx-auto">
        <slot />
      </div>
    </main>

  </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import AppHeader from '@/Components/AppHeader.vue'

const auth = computed(() => usePage().props.auth)

const dashNav = [
  { icon: '📊', label: 'Dashboard',   route: 'dashboard'         },
  { icon: '�', label: 'My Orders',   route: 'dashboard.orders'  },
  { icon: '👤', label: 'Profile',     route: 'dashboard.profile' },
  { icon: '🛒', label: 'Shop',        route: 'shop'              },
]

const isActive = (r) => { try { return route().current(r) } catch { return false } }
</script>
