<template>
  <div class="min-h-screen" style="background: #03142A;">

    <!-- AppHeader principal (même que le reste du site) -->
    <AppHeader />

    <!-- Sous-navigation PRO — barre sous le header -->
    <div class="fixed top-[68px] md:top-[76px] left-0 right-0 z-40"
      style="background: rgba(4,27,51,0.95); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255,255,255,0.06);">
      <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex items-center gap-1 h-12">
          <!-- Badge PRO -->
          <span class="text-[10px] font-bold tracking-[0.2em] uppercase px-2.5 py-1 rounded-full mr-4"
            style="background: rgba(213,182,122,0.12); color: #D5B67A; border: 1px solid rgba(213,182,122,0.3);">
            PRO Space
          </span>
          <!-- Tabs nav -->
          <Link v-for="item in proNav" :key="item.route"
            :href="route(item.route)"
            class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[11px] font-semibold tracking-wide transition-all"
            :style="isProActive(item.route)
              ? 'color: #D5B67A; background: rgba(213,182,122,0.08);'
              : 'color: rgba(157,170,192,0.7);'">
            <span>{{ item.icon }}</span>
            {{ item.label }}
          </Link>
          <!-- Sign out (droite) -->
          <Link :href="route('logout')" method="post" as="button"
            class="ml-auto text-[11px] font-semibold transition-colors"
            style="color: rgba(157,170,192,0.5);"
            onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='rgba(157,170,192,0.5)'">
            Sign out
          </Link>
        </div>
      </div>
    </div>

    <!-- Contenu principal — décalé pour header + sous-nav -->
    <main class="pt-[calc(68px+48px)] md:pt-[calc(76px+48px)] min-h-screen px-6 lg:px-8 py-10">
      <div class="max-w-7xl mx-auto">
        <slot />
      </div>
    </main>

  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import AppHeader from '@/Components/AppHeader.vue'

const proNav = [
  { icon: '📊', label: 'Dashboard',  route: 'pro.dashboard'  },
  { icon: '👥', label: 'Patients',   route: 'pro.patients'   },
  { icon: '🎯', label: 'Protocols',  route: 'pro.protocols'  },
  { icon: '🛒', label: 'Shop',       route: 'shop'           },
]

const isProActive = (r) => {
  try { return route().current(r) } catch { return false }
}
</script>
