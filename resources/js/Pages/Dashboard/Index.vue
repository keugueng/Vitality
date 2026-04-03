<template>
  <DashboardLayout>
    <div class="max-w-5xl">
      <h1 class="font-serif text-3xl font-light text-white mb-2">My Dashboard</h1>
      <p class="text-vitality-text mb-8">Welcome back, {{ $page.props.auth.user?.name }}.</p>

      <!-- Stats -->
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-10">
        <div class="glass-card rounded-2xl p-5">
          <p class="text-vitality-text text-xs mb-1">My Programs</p>
          <p class="text-vitality-gold font-bold text-3xl">{{ programs.length }}</p>
        </div>
        <div class="glass-card rounded-2xl p-5">
          <p class="text-vitality-text text-xs mb-1">Total Orders</p>
          <p class="text-vitality-gold font-bold text-3xl">{{ orders.length }}</p>
        </div>
        <div class="glass-card rounded-2xl p-5">
          <p class="text-vitality-text text-xs mb-1">Subscription</p>
          <p class="font-bold text-lg" :class="subscription ? 'text-vitality-cyan' : 'text-vitality-text'">
            {{ subscription ? 'Active' : 'None' }}
          </p>
        </div>
      </div>

      <!-- My Programs -->
      <section class="mb-10">
        <h2 class="text-white font-semibold text-lg mb-4">My Programs</h2>
        <div v-if="programs.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
          <div v-for="up in programs" :key="up.id" class="glass-card rounded-2xl p-5 card-hover">
            <div class="flex items-center gap-3 mb-3">
              <span class="text-2xl">{{ up.program?.emoji || '✨' }}</span>
              <div>
                <h3 class="text-white font-semibold text-sm">{{ up.program?.title }}</h3>
                <p class="text-vitality-cyan text-xs">{{ up.program?.category?.name }}</p>
              </div>
            </div>
            <div class="text-xs text-vitality-text space-y-1">
              <p>⏱ {{ up.program?.session_duration }}</p>
              <p>📅 {{ up.program?.cure_duration }}</p>
              <p v-if="up.listen_count">🎧 Listened {{ up.listen_count }} times</p>
            </div>
            <button class="btn-cyan w-full text-xs py-2 mt-4">🎧 Listen Now</button>
          </div>
        </div>
        <div v-else class="glass-card rounded-2xl p-8 text-center text-vitality-text">
          <p class="text-3xl mb-3">🎧</p>
          <p class="mb-4">No programs yet. Browse our catalog to get started.</p>
          <Link :href="route('shop')" class="btn-cyan text-sm inline-flex">Browse Programs</Link>
        </div>
      </section>

      <!-- Recent Orders -->
      <section>
        <h2 class="text-white font-semibold text-lg mb-4">Recent Orders</h2>
        <div v-if="orders.length" class="space-y-3">
          <div v-for="order in orders" :key="order.id" class="glass-card rounded-xl p-4 flex items-center gap-4">
            <div class="flex-1">
              <p class="text-white text-sm font-medium">{{ order.order_number }}</p>
              <p class="text-vitality-text text-xs">{{ order.items?.length }} program(s)</p>
            </div>
            <span :class="['text-xs font-medium rounded-full px-3 py-1', order.status === 'completed' ? 'bg-vitality-cyan/10 text-vitality-cyan' : 'bg-yellow-500/10 text-yellow-400']">
              {{ order.status }}
            </span>
            <span class="text-vitality-gold font-bold">€{{ order.total }}</span>
          </div>
        </div>
        <div v-else class="glass-card rounded-2xl p-6 text-center text-vitality-text text-sm">No orders yet.</div>
      </section>
    </div>
  </DashboardLayout>
</template>

<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import { Link } from '@inertiajs/vue3'
defineProps({ programs: Array, orders: Array, subscription: Object })
</script>
