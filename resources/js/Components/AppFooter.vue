<template>
  <footer class="relative z-10 border-t border-white/5 mt-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">

        <!-- Brand -->
        <div class="lg:col-span-1">
          <Link :href="route('home')" class="flex items-center gap-2 mb-4">
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-vitality-cyan to-vitality-cyan2 flex items-center justify-center">
              <span class="text-vitality-bg font-bold text-xs">V</span>
            </div>
            <span class="font-serif text-xl font-semibold text-white">Vitality Inside</span>
          </Link>
          <p class="text-vitality-text text-sm leading-relaxed mb-6">
            Bio-energy frequency therapy for a better life. Developed over 25 years of clinical practice by Dr. Éric Rosati.
          </p>
          <!-- Socials -->
          <div class="flex items-center gap-4">
            <a href="#" class="w-9 h-9 rounded-full glass-card flex items-center justify-center text-vitality-text hover:text-vitality-cyan hover:border-vitality-cyan/30 transition-all text-sm font-bold">f</a>
            <a href="https://www.instagram.com/health_vitalityinside/" target="_blank" class="w-9 h-9 rounded-full glass-card flex items-center justify-center text-vitality-text hover:text-vitality-cyan hover:border-vitality-cyan/30 transition-all text-xs font-bold">ig</a>
            <a href="#" class="w-9 h-9 rounded-full glass-card flex items-center justify-center text-vitality-text hover:text-vitality-cyan hover:border-vitality-cyan/30 transition-all text-xs font-bold">in</a>
          </div>
        </div>

        <!-- Programs -->
        <div>
          <h4 class="text-white font-semibold text-sm mb-4 tracking-wider uppercase">Programs</h4>
          <ul class="space-y-2.5">
            <li v-for="p in programLinks" :key="p.label">
              <Link :href="route('shop')" class="text-vitality-text text-sm hover:text-vitality-cyan transition-colors">{{ p.label }}</Link>
            </li>
          </ul>
        </div>

        <!-- Company -->
        <div>
          <h4 class="text-white font-semibold text-sm mb-4 tracking-wider uppercase">Company</h4>
          <ul class="space-y-2.5">
            <li><Link :href="route('about')" class="text-vitality-text text-sm hover:text-vitality-cyan transition-colors">About</Link></li>
            <li><Link :href="route('consultation')" class="text-vitality-text text-sm hover:text-vitality-cyan transition-colors">Consultation</Link></li>
            <li><Link :href="route('my-program')" class="text-vitality-text text-sm hover:text-vitality-cyan transition-colors">My Program</Link></li>
            <li><Link :href="route('blog')" class="text-vitality-text text-sm hover:text-vitality-cyan transition-colors">Blog</Link></li>
          </ul>
        </div>

        <!-- Account -->
        <div>
          <h4 class="text-white font-semibold text-sm mb-4 tracking-wider uppercase">Account</h4>
          <ul class="space-y-2.5">
            <li><Link :href="route('login')" class="text-vitality-text text-sm hover:text-vitality-cyan transition-colors">Login</Link></li>
            <li><Link :href="route('shop')" class="text-vitality-text text-sm hover:text-vitality-cyan transition-colors">Subscribe</Link></li>
            <li><Link :href="route('legal-notice')" class="text-vitality-text text-sm hover:text-vitality-cyan transition-colors">Legal Notice</Link></li>
          </ul>
        </div>
      </div>

      <!-- Bottom bar -->
      <div class="mt-12 pt-8 border-t border-white/5 flex flex-col sm:flex-row items-center justify-between gap-4">
        <p class="text-vitality-text text-xs">© {{ year }} Vitality Inside. All rights reserved.</p>
        <p class="text-vitality-text text-xs">Bio-Energy Frequency Therapy · Dr. Éric Rosati</p>
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
