<template>
  <AppLayout>
    <section class="pt-32 pb-24 px-4 text-center">
      <div class="max-w-2xl mx-auto">
        <div class="glass-card rounded-3xl p-12 border-glow relative overflow-hidden">
          <div class="absolute inset-0 bg-gradient-radial from-vitality-cyan/5 to-transparent rounded-3xl"></div>
          <div class="relative z-10">
            <div class="w-20 h-20 rounded-full bg-vitality-cyan/10 glow-cyan mx-auto mb-6 flex items-center justify-center text-4xl">✓</div>
            <h1 class="font-serif text-3xl font-light text-white mb-3">Order confirmed!</h1>
            <p class="text-vitality-text mb-2">Order <span class="text-vitality-cyan font-medium">{{ order.order_number }}</span></p>
            <p class="text-vitality-text text-sm mb-8">Your programs have been sent to <strong class="text-white">{{ order.customer_email }}</strong>. Check your inbox.</p>

            <div class="space-y-3 text-left mb-8">
              <div v-for="item in order.items" :key="item.id" class="flex items-center gap-3 glass-card rounded-xl p-3">
                <span class="text-2xl">{{ item.program?.emoji || '✨' }}</span>
                <div class="flex-1">
                  <p class="text-white text-sm font-medium">{{ item.program_title }}</p>
                  <p class="text-vitality-text text-xs">Access link sent by email</p>
                </div>
                <span class="text-vitality-gold text-sm">€{{ item.price }}</span>
              </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 justify-center">
              <Link :href="route('dashboard')" class="btn-cyan">Go to My Dashboard</Link>
              <Link :href="route('shop')" class="btn-outline">Continue Shopping</Link>
            </div>
          </div>
        </div>
      </div>
    </section>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
defineProps({ order: Object })
</script>
