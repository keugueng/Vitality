<template>
  <nav class="fixed top-0 left-0 right-0 z-[300] flex items-center justify-between transition-all duration-300"
    style="padding: 18px 48px; backdrop-filter: blur(20px); border-bottom: 1px solid rgba(200,169,110,0.2);"
    :style="{ background: scrolled ? 'rgba(10,22,40,0.98)' : 'rgba(10,22,40,0.96)' }">

    <!-- Logo -->
    <Link :href="route('home')"
      style="font-family:'Cormorant Garamond',serif; font-size:1.35rem; font-weight:600; letter-spacing:.08em; color:#c8a96e; text-decoration:none;"
      class="hover:opacity-80 transition-opacity leading-none">
      Vitality Inside
    </Link>

    <!-- Desktop Nav -->
    <ul class="hidden lg:flex items-center list-none" style="gap:32px;">
      <li v-for="item in navItems" :key="item.route">
        <Link :href="route(item.route)"
          class="transition-colors duration-200"
          :style="isActive(item.route)
            ? 'color:#c8a96e; font-size:.8rem; letter-spacing:.07em; text-transform:uppercase; text-decoration:none;'
            : 'color:rgba(255,255,255,.7); font-size:.8rem; letter-spacing:.07em; text-transform:uppercase; text-decoration:none;'"
          @mouseenter="e => e.target.style.color='#c8a96e'"
          @mouseleave="e => { if (!isActive(item.route)) e.target.style.color='rgba(255,255,255,.7)' }">
          {{ item.label }}
        </Link>
      </li>
    </ul>

    <!-- Right Actions -->
    <div class="hidden lg:flex items-center" style="gap:16px;">

      <!-- Lang switcher -->
      <div class="relative" data-lang style="display:inline-flex; align-items:center;">
        <button @click.stop="langOpen = !langOpen"
          style="background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.25); color:#fff; padding:5px 11px; border-radius:20px; cursor:pointer; font-size:.75rem; letter-spacing:.06em; display:flex; align-items:center; gap:5px; transition:all .2s; font-family:inherit;"
          class="hover:border-white/50">
          {{ locale === 'fr' ? '�🇷 FR' : '�🇬🇧 EN' }} ▾
        </button>
        <div v-if="langOpen" data-lang
          style="position:absolute; top:calc(100% + 8px); right:0; background:rgba(13,32,64,.97); border:1px solid rgba(200,169,110,.25); border-radius:10px; min-width:140px; z-index:9999; padding:6px; box-shadow:0 8px 32px rgba(0,0,0,.5);">
          <a :href="route('locale.switch', 'en')" data-lang
            style="display:flex; align-items:center; gap:8px; padding:8px 12px; font-size:.8rem; border-radius:6px; width:100%; text-align:left; text-decoration:none; cursor:pointer;"
            :style="locale !== 'fr' ? 'color:#c8a96e; background:rgba(200,169,110,.15);' : 'color:rgba(255,255,255,.8);'"
            @click="langOpen=false">🇬🇧 English</a>
          <a :href="route('locale.switch', 'fr')" data-lang
            style="display:flex; align-items:center; gap:8px; padding:8px 12px; font-size:.8rem; border-radius:6px; width:100%; text-align:left; text-decoration:none; cursor:pointer;"
            :style="locale === 'fr' ? 'color:#c8a96e; background:rgba(200,169,110,.15);' : 'color:rgba(255,255,255,.8);'"
            @click="langOpen=false">🇫🇷 Français</a>
        </div>
      </div>

      <!-- PRO: gold gradient -->
      <Link :href="route('pro')"
        style="background:linear-gradient(135deg,#c8a96e,#e8d5a3); color:#0a1628; padding:5px 14px; border-radius:20px; font-size:.75rem; font-weight:700; letter-spacing:.1em; text-decoration:none; text-transform:uppercase; transition:all .2s;"
        class="hover:shadow-lg">
        PRO
      </Link>

      <!-- Login / User -->
      <template v-if="auth.user">
        <Link :href="route('dashboard')"
          style="color:rgba(255,255,255,.5); font-size:.78rem; letter-spacing:.06em; text-transform:uppercase; text-decoration:none; transition:color .2s;"
          class="hover:text-white">
          {{ auth.user.name.split(' ')[0] }}
        </Link>
        <Link :href="route('logout')" method="post" as="button"
          style="color:rgba(255,255,255,.4); font-size:.72rem; letter-spacing:.06em; text-transform:uppercase; transition:color .2s; cursor:pointer;"
          class="hover:text-white">
          Logout
        </Link>
      </template>
      <template v-else>
        <Link :href="route('login')"
          style="color:rgba(255,255,255,.5); font-size:.78rem; letter-spacing:.06em; text-transform:uppercase; text-decoration:none; transition:color .2s;"
          class="hover:text-white">
          Login
        </Link>
      </template>

      <!-- Cart -->
      <Link :href="route('cart.index')" class="relative" style="color:rgba(255,255,255,.5); transition:color .2s;" :class="'hover:text-white'">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px; height:18px; display:inline-block;">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
        </svg>
        <span v-if="cartCount > 0" class="absolute -top-1.5 -right-1.5 text-[9px] font-black rounded-full flex items-center justify-center"
          style="background:#14a8a0; color:#0a1628; width:14px; height:14px;">
          {{ cartCount }}
        </span>
      </Link>

      <!-- Explore Programs: teal gradient CTA -->
      <Link :href="route('shop')"
        style="background:linear-gradient(135deg,#0d7377,#14a8a0); color:#fff; border:none; padding:10px 24px; border-radius:5px; font-size:.78rem; letter-spacing:.08em; text-transform:uppercase; text-decoration:none; transition:all .2s; box-shadow:0 4px 16px rgba(13,115,119,.35);"
        class="hover:shadow-xl hover:-translate-y-px">
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
  </nav>

  <!-- Mobile Menu -->
  <transition name="slide-down">
    <div v-if="mobileOpen" class="lg:hidden fixed top-0 left-0 right-0 z-[299] pt-[72px]"
      style="background:rgba(10,22,40,0.98); backdrop-filter:blur(20px); border-bottom:1px solid rgba(200,169,110,0.2);">
      <div class="px-6 py-6 space-y-1">
        <Link v-for="item in navItems" :key="item.route"
          :href="route(item.route)"
          @click="mobileOpen = false"
          class="block py-3 border-b"
          style="font-size:.8rem; font-weight:600; letter-spacing:.1em; text-transform:uppercase; border-color:rgba(255,255,255,.06); text-decoration:none; transition:color .2s;"
          :style="isActive(item.route) ? 'color:#c8a96e;' : 'color:rgba(255,255,255,.5);'">
          {{ item.label }}
        </Link>
        <div class="pt-5 flex flex-col gap-3">
          <Link :href="route('pro')" @click="mobileOpen = false"
            class="rounded-full text-center py-2.5 text-xs font-bold tracking-widest uppercase"
            style="background:linear-gradient(135deg,#c8a96e,#e8d5a3); color:#0a1628; text-decoration:none;">PRO</Link>
          <Link :href="route('shop')" @click="mobileOpen = false"
            class="rounded text-center py-3 text-xs font-bold tracking-widest uppercase"
            style="background:linear-gradient(135deg,#0d7377,#14a8a0); color:#fff; text-decoration:none;">Explore Programs</Link>
          <template v-if="!auth.user">
            <Link :href="route('login')" @click="mobileOpen = false"
              class="text-center py-2 text-xs font-semibold uppercase tracking-widest"
              style="color:rgba(255,255,255,.5); text-decoration:none;">Login</Link>
          </template>
        </div>
      </div>
    </div>
  </transition>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'

const page      = usePage()
const auth      = computed(() => page.props.auth)
const cartCount = computed(() => page.props.cart_count || 0)
const locale    = computed(() => page.props.locale || 'en')

const scrolled   = ref(false)
const mobileOpen = ref(false)
const langOpen   = ref(false)

const navItems = [
  { label: 'Home',         route: 'home' },
  { label: 'Shop',         route: 'shop' },
  { label: 'Consultation', route: 'consultation' },
  { label: 'About',        route: 'about' },
  { label: 'Blog',         route: 'blog' },
]

const isActive = (r) => { try { return route().current(r) } catch { return false } }

const onScroll = () => { scrolled.value = window.scrollY > 30 }
const onClickOut = (e) => { if (langOpen.value && !e.target.closest('[data-lang]')) langOpen.value = false }

onMounted(() => {
  window.addEventListener('scroll', onScroll)
  document.addEventListener('click', onClickOut)
})
onUnmounted(() => {
  window.removeEventListener('scroll', onScroll)
  document.removeEventListener('click', onClickOut)
})
</script>

<style scoped>
.slide-down-enter-active, .slide-down-leave-active { transition: all 0.3s ease; }
.slide-down-enter-from, .slide-down-leave-to { opacity: 0; transform: translateY(-8px); }
</style>
