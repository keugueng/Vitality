<template>
  <header
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-500"
    :class="scrolled ? 'bg-[#03142A]/95 backdrop-blur-md shadow-md shadow-black/30' : 'bg-transparent'"
  >
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
      <div class="flex items-center justify-between h-[68px] md:h-[76px]">

        <!-- Logo: serif italic or, exactement comme le live -->
        <Link :href="route('home')" class="font-serif italic text-[#D5B67A] text-2xl md:text-[26px] tracking-wide hover:opacity-80 transition-opacity leading-none">
          Vitality Inside
        </Link>

        <!-- Desktop Nav: liens uppercase petits -->
        <nav class="hidden lg:flex items-center gap-7 xl:gap-9">
          <Link
            v-for="item in navItems" :key="item.route"
            :href="route(item.route)"
            class="text-[11px] font-semibold tracking-[0.12em] uppercase transition-colors duration-200 hover:text-white"
            :style="isActive(item.route) ? 'color: #D5B67A;' : ''"
            :class="isActive(item.route) ? '' : 'text-white/60'"
          >{{ item.label }}</Link>
        </nav>

        <!-- Right actions -->
        <div class="hidden lg:flex items-center gap-3.5">

          <!-- Langue: "GB EN ▾" pill exactement comme live -->
          <button class="flex items-center gap-1 border rounded-full px-3 py-1.5 text-[11px] font-semibold hover:text-white hover:border-white/40 transition-all"
            style="border-color: rgba(255,255,255,0.25); color: rgba(255,255,255,0.7); letter-spacing: 0.05em;">
            <span class="font-bold text-[10px] tracking-widest">GB</span>
            <span>EN</span>
            <svg class="w-2 h-2 opacity-50 ml-0.5" viewBox="0 0 10 6" fill="currentColor">
              <path d="M0 0l5 6 5-6z"/>
            </svg>
          </button>

          <!-- PRO: oval gold outlined -->
          <Link :href="route('pro')"
            class="border border-[#D5B67A]/70 text-[#D5B67A] rounded-full px-5 py-1.5 text-[11px] font-bold tracking-[0.15em] uppercase hover:bg-[#D5B67A]/10 transition-all">
            PRO
          </Link>

          <!-- Login / User -->
          <template v-if="auth.user">
            <Link :href="route('dashboard')"
              class="text-[11px] font-semibold text-white/60 hover:text-white uppercase tracking-[0.1em] transition-colors">
              {{ auth.user.name.split(' ')[0] }}
            </Link>
            <Link :href="route('logout')" method="post" as="button"
              class="text-[11px] font-semibold text-white/40 hover:text-white uppercase tracking-[0.1em] transition-colors">
              Logout
            </Link>
          </template>
          <template v-else>
            <Link :href="route('login')"
              class="text-[11px] font-semibold text-white/60 hover:text-white uppercase tracking-[0.12em] transition-colors">
              Login
            </Link>
          </template>

          <!-- Cart badge (discret) -->
          <Link :href="route('cart.index')" class="relative text-white/50 hover:text-white transition-colors">
            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
            </svg>
            <span v-if="cartCount > 0"
              class="absolute -top-1.5 -right-1.5 bg-[#11C7C9] text-[#03142A] text-[9px] font-black rounded-full w-3.5 h-3.5 flex items-center justify-center">
              {{ cartCount }}
            </span>
          </Link>

          <!-- EXPLORE PROGRAMS: bouton teal principal -->
          <Link :href="route('shop')"
            class="bg-[#11C7C9] hover:bg-[#0db5b7] text-[#03142A] font-bold text-[11px] tracking-[0.12em] uppercase px-5 py-2.5 rounded transition-all shadow-sm">
            Explore Programs
          </Link>
        </div>

        <!-- Mobile burger -->
        <button @click="mobileOpen = !mobileOpen" class="lg:hidden text-white p-1.5">
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
      <div v-if="mobileOpen" class="lg:hidden bg-[#03142A]/98 backdrop-blur-xl border-t border-white/5">
        <div class="max-w-7xl mx-auto px-6 py-6 space-y-1">
          <Link
            v-for="item in navItems" :key="item.route"
            :href="route(item.route)"
            @click="mobileOpen = false"
            class="block py-3 text-[11px] font-semibold tracking-[0.12em] uppercase transition-colors border-b border-white/5"
            :style="isActive(item.route) ? 'color: #D5B67A;' : ''"
            :class="isActive(item.route) ? '' : 'text-white/50'"
          >{{ item.label }}</Link>
          <div class="pt-5 flex flex-col gap-3">
            <Link :href="route('pro')" @click="mobileOpen = false"
              class="border border-[#D5B67A]/70 text-[#D5B67A] rounded-full px-5 py-2.5 text-xs font-bold uppercase tracking-widest text-center">PRO</Link>
            <Link :href="route('shop')" @click="mobileOpen = false"
              class="bg-[#11C7C9] text-[#03142A] font-bold text-xs tracking-widest uppercase py-3 rounded text-center">Explore Programs</Link>
            <template v-if="!auth.user">
              <Link :href="route('login')" @click="mobileOpen = false"
                class="text-white/60 text-xs font-semibold uppercase tracking-widest text-center py-2">Login</Link>
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

const page      = usePage()
const auth      = computed(() => page.props.auth)
const cartCount = computed(() => page.props.cart_count || 0)

const scrolled   = ref(false)
const mobileOpen = ref(false)

const navItems = [
  { label: 'Home',         route: 'home' },
  { label: 'Shop',         route: 'shop' },
  { label: 'Consultation', route: 'consultation' },
  { label: 'About',        route: 'about' },
  { label: 'Blog',         route: 'blog' },
]

const isActive = (r) => { try { return route().current(r) } catch { return false } }

const onScroll = () => { scrolled.value = window.scrollY > 30 }
onMounted(() => window.addEventListener('scroll', onScroll))
onUnmounted(() => window.removeEventListener('scroll', onScroll))
</script>

<style scoped>
.slide-down-enter-active, .slide-down-leave-active { transition: all 0.3s ease; }
.slide-down-enter-from, .slide-down-leave-to { opacity: 0; transform: translateY(-8px); }
</style>
