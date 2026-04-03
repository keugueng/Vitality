<template>
  <DashboardLayout>
    <div class="max-w-4xl">
      <h1 class="font-serif text-3xl font-light text-white mb-8">My Orders</h1>
      <div v-if="orders.data?.length" class="space-y-4">
        <div v-for="order in orders.data" :key="order.id" class="glass-card rounded-2xl p-6">
          <div class="flex items-center justify-between mb-4">
            <div>
              <p class="text-white font-semibold">{{ order.order_number }}</p>
              <p class="text-vitality-text text-xs mt-0.5">{{ formatDate(order.created_at) }}</p>
            </div>
            <div class="flex items-center gap-3">
              <span :class="['text-xs rounded-full px-3 py-1', order.status === 'completed' ? 'bg-vitality-cyan/10 text-vitality-cyan' : 'bg-yellow-500/10 text-yellow-400']">
                {{ order.status }}
              </span>
              <span class="text-vitality-gold font-bold">€{{ order.total }}</span>
            </div>
          </div>
          <div class="space-y-2">
            <div v-for="item in order.items" :key="item.id" class="flex items-center gap-3 text-sm">
              <span class="text-lg">{{ item.program?.emoji || '✨' }}</span>
              <span class="text-vitality-text flex-1">{{ item.program_title }}</span>
              <span class="text-vitality-gold">€{{ item.price }}</span>
            </div>
          </div>
        </div>
      </div>
      <div v-else class="glass-card rounded-2xl p-10 text-center text-vitality-text">
        <p class="text-3xl mb-3">📦</p>
        <p class="mb-4">No orders yet.</p>
        <Link :href="route('shop')" class="btn-cyan text-sm inline-flex">Browse Programs</Link>
      </div>
    </div>
  </DashboardLayout>
</template>
<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import { Link } from '@inertiajs/vue3'
defineProps({ orders: Object })
const formatDate = (d) => d ? new Date(d).toLocaleDateString('fr-FR') : ''
</script>
