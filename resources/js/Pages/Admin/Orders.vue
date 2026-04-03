<template>
  <AdminLayout>
    <div class="max-w-6xl">
      <h1 class="font-serif text-3xl font-light text-white mb-8">Orders</h1>
      <div class="glass-card rounded-2xl overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="border-b border-white/5">
            <tr class="text-vitality-text text-xs">
              <th class="text-left p-4">Order #</th>
              <th class="text-left p-4">Customer</th>
              <th class="text-left p-4">Items</th>
              <th class="text-left p-4">Total</th>
              <th class="text-left p-4">Status</th>
              <th class="text-left p-4">Date</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-white/5">
            <tr v-for="order in orders.data" :key="order.id" class="hover:bg-white/2 transition-colors">
              <td class="p-4 text-vitality-cyan font-medium">{{ order.order_number }}</td>
              <td class="p-4">
                <p class="text-white">{{ order.customer_name }}</p>
                <p class="text-vitality-text text-xs">{{ order.customer_email }}</p>
              </td>
              <td class="p-4 text-vitality-text">
                <div class="flex gap-1">
                  <span v-for="item in order.items?.slice(0,3)" :key="item.id" :title="item.program_title">{{ item.program?.emoji || '📦' }}</span>
                </div>
              </td>
              <td class="p-4 text-vitality-gold font-semibold">€{{ order.total }}</td>
              <td class="p-4">
                <span :class="['text-xs rounded-full px-2.5 py-1', order.status === 'completed' ? 'bg-vitality-cyan/10 text-vitality-cyan' : 'bg-yellow-500/10 text-yellow-400']">
                  {{ order.status }}
                </span>
              </td>
              <td class="p-4 text-vitality-text text-xs">{{ formatDate(order.created_at) }}</td>
            </tr>
            <tr v-if="!orders.data?.length">
              <td colspan="6" class="py-10 text-center text-vitality-text">No orders yet.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AdminLayout>
</template>
<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
defineProps({ orders: Object })
const formatDate = (d) => d ? new Date(d).toLocaleDateString('fr-FR') : ''
</script>
