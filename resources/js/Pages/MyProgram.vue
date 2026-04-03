<template>
  <AppLayout>
    <section class="pt-32 pb-24 px-4 text-center">
      <div class="max-w-2xl mx-auto">
        <div class="text-6xl mb-6">🎧</div>
        <h1 class="section-title text-white mb-4">Access your <em class="text-gradient-gold not-italic">program</em></h1>
        <p class="text-vitality-text mb-10">Enter the access code from your confirmation email to listen to your bio-energy protocol.</p>
        <div class="glass-card rounded-2xl p-8 border-glow">
          <input type="text" placeholder="Enter your access code…"
            class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm text-center focus:outline-none focus:border-vitality-cyan/50 mb-4 placeholder-vitality-text/40"/>
          <button class="btn-cyan w-full py-3">Access My Program</button>
          <p class="text-vitality-text/50 text-xs mt-4">
            No code? <Link :href="route('login')" class="text-vitality-cyan hover:underline">Log in</Link> to your account to find your programs.
          </p>
        </div>
        <p class="text-vitality-text/50 text-sm mt-8">
          Haven't ordered yet? <Link :href="route('shop')" class="text-vitality-cyan hover:underline">Browse our programs →</Link>
        </p>
      </div>
    </section>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
</script>
