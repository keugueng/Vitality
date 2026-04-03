<template>
  <header
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
    :class="scrolled ? 'bg-[#03142A]/90 backdrop-blur-md border-b border-white/5 shadow-xl shadow-black/20' : 'bg-transparent'"
  >
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16 md:h-20">

        <!-- Logo -->
        <Link :href="route('home')" class="flex items-center gap-2 group">
          <div class="w-8 h-8 rounded-full bg-gradient-to-br from-vitality-cyan to-vitality-cyan2 flex items-center justify-center group-hover:shadow-lg group-hover:shadow-vitality-cyan/40 transition-all">
            <span class="text-vitality-bg font-bold text-xs">V</span>
          </div>
          <span class="font-serif text-xl font-semibold tracking-wide text-white">Vitality Inside</span>
        </Link>

        <!-- Desktop Nav -->
        <nav class="hidden lg:flex items-center gap-6 xl:gap-8">
          <Link
            v-for="item in navItems" :key="item.route"
            :href="route(item.route)"
            class="text-sm font-medium transition-colors duration-200 hover:text-vitality-cyan"
            :class="isActive(item.route) ? 'text-vitality-cyan' : 'text-vitality-text'"
          >
            {{ item.label }}
          </Link>
        </nav>

        <!-- Right actions -->
        <div class="hidden lg:flex items-center gap-3">
          <!-- Language -->
          <button
            @click="toggleLocale"
            class="text-xs font-medium text-vitality-text hover:text-white border border-white/10 rounded-full px-3 py-1.5 transition-all hover:border-white/30"
          >
            {{ locale === 'fr' ? 'EN' : 'FR' }}
          </button>

          <!-- PRO -->
          <Link :href="route('pro')" class="btn-gold text-xs py-2 px-4">PRO</Link>

          <!-- Login / User -->
          <template v-if="auth.user">
            <Link :href="route('dashboard')" class="text-sm text-vitality-text hover:text-white transition-colors">
              {{ auth.user.name.split(' ')[0] }}
            </Link>
            <Link :href="route('logout')" method="post" as="button" class="text-xs text-vitality-text hover:text-white transition-colors">
              Logout
            </Link>
          </template>
          <template v-else>
            <Link :href="route('login')" class="text-sm text-vitality-text hover:text-white transition-colors">Login</Link>
          </template>

          <!-- Cart -->
          <Link :href="route('cart.index')" class="relative text-vitality-text hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
            </svg>
            <span v-if="cartCount > 0" class="absolute -top-2 -right-2 bg-vitality-cyan text-vitality-bg text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center">{{ cartCount }}</span>
          </Link>

          <!-- CTA -->
          <Link :href="route('shop')" class="btn-cyan text-sm py-2 px-5">Explore Programs</Link>
        </div>

        <!-- Mobile burger -->
        <button @click="mobileOpen = !mobileOpen" class="lg:hidden text-white p-2">
          <svg v-if="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
          </svg>
          <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>
    </div>

    <!-- Mobile Menu -->
    <transition name="slide-down">
      <div v-if="mobileOpen" class="lg:hidden bg-[#041B33]/98 backdrop-blur-xl border-t border-white/5">
        <div class="max-w-7xl mx-auto px-4 py-6 space-y-4">
          <Link
            v-for="item in navItems" :key="item.route"
            :href="route(item.route)"
            @click="mobileOpen = false"
            class="block py-2 text-base font-medium transition-colors"
            :class="isActive(item.route) ? 'text-vitality-cyan' : 'text-vitality-text'"
          >
            {{ item.label }}
          </Link>
          <div class="pt-4 border-t border-white/5 flex flex-col gap-3">
            <Link :href="route('pro')" @click="mobileOpen = false" class="btn-gold text-sm text-center">PRO</Link>
            <Link :href="route('shop')" @click="mobileOpen = false" class="btn-cyan text-sm text-center">Explore Programs</Link>
            <template v-if="!auth.user">
              <Link :href="route('login')" @click="mobileOpen = false" class="btn-outline text-sm text-center">Login</Link>
            </template>
          </div>
        </div>
      </div>
    </transition>
  </header>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'

const page   = usePage()
const auth   = computed(() => page.props.auth)
const cartCount = computed(() => page.props.cart_count || 0)
const locale    = computed(() => page.props.locale || 'fr')

const scrolled   = ref(false)
const mobileOpen = ref(false)

const navItems = [
  { label: 'Home',         route: 'home' },
  { label: 'Shop',         route: 'shop' },
  { label: 'Consultation', route: 'consultation' },
  { label: 'About',        route: 'about' },
  { label: 'Blog',         route: 'blog' },
]

const isActive = (r) => route().current(r)

const toggleLocale = () => {
  const newLocale = locale.value === 'fr' ? 'en' : 'fr'
  document.cookie = `locale=${newLocale};path=/`
  window.location.reload()
}

const onScroll = () => { scrolled.value = window.scrollY > 20 }
onMounted(() => window.addEventListener('scroll', onScroll))
onUnmounted(() => window.removeEventListener('scroll', onScroll))
</script>

<style scoped>
.slide-down-enter-active, .slide-down-leave-active { transition: all 0.3s ease; }
.slide-down-enter-from, .slide-down-leave-to { opacity: 0; transform: translateY(-10px); }
</style>
