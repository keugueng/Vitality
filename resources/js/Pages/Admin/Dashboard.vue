<template>
  <AdminLayout>
    <div class="max-w-6xl">
      <h1 class="font-serif text-3xl font-light text-white mb-2">Admin Dashboard</h1>
      <p class="text-vitality-text mb-8">Vitality Inside — Back Office</p>

      <!-- Stats -->
      <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-10">
        <div v-for="s in statCards" :key="s.label" class="glass-card rounded-2xl p-5">
          <p class="text-vitality-text text-xs mb-1">{{ s.label }}</p>
          <p class="font-bold text-2xl" :class="s.color">{{ s.value }}</p>
        </div>
      </div>

      <!-- Recent Orders -->
      <div class="glass-card rounded-2xl p-6">
        <h2 class="text-white font-semibold text-lg mb-4">Recent Orders</h2>
        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead>
              <tr class="text-vitality-text text-xs border-b border-white/5">
                <th class="text-left pb-3">Order #</th>
                <th class="text-left pb-3">Customer</th>
                <th class="text-left pb-3">Items</th>
                <th class="text-left pb-3">Total</th>
                <th class="text-left pb-3">Status</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
              <tr v-for="order in recentOrders" :key="order.id" class="py-3">
                <td class="py-3 text-vitality-cyan font-medium">{{ order.order_number }}</td>
                <td class="py-3 text-vitality-text">{{ order.customer_name }}</td>
                <td class="py-3 text-vitality-text">{{ order.items?.length }}</td>
                <td class="py-3 text-vitality-gold font-semibold">€{{ order.total }}</td>
                <td class="py-3">
                  <span :class="['text-xs rounded-full px-2.5 py-1', order.status === 'completed' ? 'bg-vitality-cyan/10 text-vitality-cyan' : 'bg-yellow-500/10 text-yellow-400']">{{ order.status }}</span>
                </td>
              </tr>
              <tr v-if="!recentOrders?.length">
                <td colspan="5" class="py-8 text-center text-vitality-text text-sm">No orders yet.</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Quick links -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8">
        <Link v-for="ql in quickLinks" :key="ql.route" :href="route(ql.route)"
          class="glass-card rounded-xl p-4 text-center card-hover">
          <div class="text-2xl mb-2">{{ ql.icon }}</div>
          <p class="text-white text-xs font-medium">{{ ql.label }}</p>
        </Link>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({ stats: Object, recentOrders: Array })

const statCards = [
  { label: 'Users',         value: props.stats?.users         || 0, color: 'text-white' },
  { label: 'Programs',      value: props.stats?.programs      || 0, color: 'text-vitality-cyan' },
  { label: 'Orders',        value: props.stats?.orders        || 0, color: 'text-vitality-gold' },
  { label: 'Revenue',       value: `€${props.stats?.revenue  || 0}`, color: 'text-vitality-gold' },
  { label: 'Consultations', value: props.stats?.consultations || 0, color: 'text-white' },
]

const quickLinks = [
  { icon: '🎯', label: 'Programs',     route: 'admin.programs' },
  { icon: '📦', label: 'Orders',       route: 'admin.orders' },
  { icon: '🩺', label: 'Consults',     route: 'admin.consultations' },
  { icon: '⚙️', label: 'Settings',    route: 'admin.settings' },
]
</script>
