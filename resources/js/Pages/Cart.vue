<template>
  <AppLayout>
    <section class="pt-28 pb-24 px-4">
      <div class="max-w-3xl mx-auto">
        <h1 class="section-title text-white mb-10">Your <em class="text-gradient-cyan not-italic">Cart</em></h1>

        <div v-if="items.length === 0" class="text-center py-20 glass-card rounded-3xl">
          <div class="text-6xl mb-4">🛒</div>
          <p class="text-vitality-text text-lg mb-6">Your cart is empty.</p>
          <Link :href="route('shop')" class="btn-cyan inline-flex">Browse Programs</Link>
        </div>

        <div v-else class="space-y-4">
          <div v-for="item in items" :key="item.program.id" class="glass-card rounded-2xl p-5 flex items-center gap-5">
            <div class="w-12 h-12 rounded-xl bg-vitality-cyan/10 flex items-center justify-center text-2xl flex-shrink-0">
              {{ item.program.emoji || '✨' }}
            </div>
            <div class="flex-1 min-w-0">
              <h3 class="text-white font-semibold text-sm truncate">{{ item.program.title }}</h3>
              <p class="text-vitality-text text-xs mt-0.5">{{ item.program.session_duration }} · {{ item.program.cure_duration }}</p>
            </div>
            <div class="flex items-center gap-3 flex-shrink-0">
              <span class="text-vitality-gold font-bold">€{{ item.program.price }}</span>
              <Link :href="route('cart.remove')" method="post" as="button"
                :data="{ program_id: item.program.id }"
                class="w-7 h-7 rounded-full border border-white/10 flex items-center justify-center text-vitality-text hover:text-red-400 hover:border-red-400/30 transition-all text-xs">
                ✕
              </Link>
            </div>
          </div>

          <!-- Summary -->
          <div class="glass-card rounded-2xl p-6 border-glow mt-6">
            <div class="flex items-center justify-between mb-4">
              <span class="text-vitality-text">Total</span>
              <span class="text-vitality-gold font-bold text-2xl">€{{ total }}</span>
            </div>
            <Link :href="route('checkout')" class="btn-cyan w-full text-center block text-base py-3.5">Proceed to Checkout</Link>
            <Link :href="route('shop')" class="btn-outline w-full text-center block text-sm py-2.5 mt-3">Continue Shopping</Link>
          </div>
        </div>
      </div>
    </section>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
defineProps({ items: Array, total: [Number, String] })
</script>
