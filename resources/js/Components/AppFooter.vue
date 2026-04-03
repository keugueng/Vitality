<template>
  <footer class="relative z-10 mt-16" style="border-top: 1px solid rgba(255,255,255,0.06);">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-16">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-14">

        <!-- Brand -->
        <div class="lg:col-span-1">
          <Link :href="route('home')"
            class="font-serif italic text-[#D5B67A] text-2xl tracking-wide hover:opacity-80 transition-opacity inline-block mb-5">
            Vitality Inside
          </Link>
          <p class="text-[#9DAAC0] text-sm leading-relaxed mb-6">
            Bio-energy frequency therapy for a better life. Developed over 25 years of clinical practice by Dr. Éric Rosati.
          </p>
          <div class="flex items-center gap-3">
            <a href="#"
              class="w-8 h-8 rounded-full flex items-center justify-center text-[#9DAAC0] hover:text-[#11C7C9] transition-colors text-sm font-bold"
              style="border: 1px solid rgba(255,255,255,0.1);">f</a>
            <a href="https://www.instagram.com/health_vitalityinside/" target="_blank"
              class="w-8 h-8 rounded-full flex items-center justify-center text-[#9DAAC0] hover:text-[#11C7C9] transition-colors text-[10px] font-bold"
              style="border: 1px solid rgba(255,255,255,0.1);">ig</a>
            <a href="#"
              class="w-8 h-8 rounded-full flex items-center justify-center text-[#9DAAC0] hover:text-[#11C7C9] transition-colors text-[10px] font-bold"
              style="border: 1px solid rgba(255,255,255,0.1);">in</a>
          </div>
        </div>

        <!-- Programs -->
        <div>
          <h4 class="text-[11px] font-semibold tracking-[0.15em] uppercase mb-5" style="color: #11C7C9;">Programs</h4>
          <ul class="space-y-3">
            <li v-for="p in programLinks" :key="p.label">
              <Link :href="route('shop')"
                class="text-[#9DAAC0] text-sm hover:text-white transition-colors">{{ p.label }}</Link>
            </li>
          </ul>
        </div>

        <!-- Company -->
        <div>
          <h4 class="text-[11px] font-semibold tracking-[0.15em] uppercase mb-5" style="color: #11C7C9;">Company</h4>
          <ul class="space-y-3">
            <li><Link :href="route('about')" class="text-[#9DAAC0] text-sm hover:text-white transition-colors">About</Link></li>
            <li><Link :href="route('consultation')" class="text-[#9DAAC0] text-sm hover:text-white transition-colors">Consultation</Link></li>
            <li><Link :href="route('my-program')" class="text-[#9DAAC0] text-sm hover:text-white transition-colors">My Program</Link></li>
            <li><Link :href="route('blog')" class="text-[#9DAAC0] text-sm hover:text-white transition-colors">Blog</Link></li>
          </ul>
        </div>

        <!-- Account -->
        <div>
          <h4 class="text-[11px] font-semibold tracking-[0.15em] uppercase mb-5" style="color: #11C7C9;">Account</h4>
          <ul class="space-y-3">
            <li><Link :href="route('login')" class="text-[#9DAAC0] text-sm hover:text-white transition-colors">Login</Link></li>
            <li><Link :href="route('shop')" class="text-[#9DAAC0] text-sm hover:text-white transition-colors">Subscribe</Link></li>
            <li><Link :href="route('legal-notice')" class="text-[#9DAAC0] text-sm hover:text-white transition-colors">Legal Notice</Link></li>
          </ul>
        </div>
      </div>

      <!-- Bottom bar -->
      <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-3" style="border-top: 1px solid rgba(255,255,255,0.06);">
        <p class="text-[#9DAAC0] text-xs">© {{ year }} Vitality Inside. All rights reserved.</p>
        <p class="text-[#9DAAC0] text-xs">Bio-Energy Frequency Therapy · Dr. Éric Rosati</p>
      </div>
    </div>
  </footer>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

const year = new Date().getFullYear()
const programLinks = [
  { label: 'All Programs' },
  { label: 'Anti-Stress' },
  { label: 'Sleeping Troubles' },
  { label: 'Burn-Out' },
  { label: 'Allergy' },
]
</script>
