<template>
  <AdminLayout>
    <div class="max-w-5xl">
      <h1 class="font-serif text-3xl font-light text-white mb-8">Users</h1>
      <div class="glass-card rounded-2xl overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="border-b border-white/5">
            <tr class="text-vitality-text text-xs">
              <th class="text-left p-4">User</th>
              <th class="text-left p-4">Role</th>
              <th class="text-left p-4">PRO</th>
              <th class="text-left p-4">Joined</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-white/5">
            <tr v-for="user in users.data" :key="user.id">
              <td class="p-4">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 rounded-full bg-vitality-cyan/20 flex items-center justify-center text-vitality-cyan font-bold text-xs flex-shrink-0">
                    {{ user.name?.[0]?.toUpperCase() }}
                  </div>
                  <div>
                    <p class="text-white font-medium">{{ user.name }}</p>
                    <p class="text-vitality-text text-xs">{{ user.email }}</p>
                  </div>
                </div>
              </td>
              <td class="p-4">
                <span v-for="role in user.roles" :key="role.id"
                  :class="['text-xs rounded-full px-2.5 py-1 mr-1', role.name === 'admin' ? 'bg-vitality-gold/10 text-vitality-gold' : 'bg-vitality-cyan/10 text-vitality-cyan']">
                  {{ role.name }}
                </span>
              </td>
              <td class="p-4">
                <span :class="['text-xs rounded-full px-2.5 py-1', user.is_pro ? 'bg-vitality-gold/10 text-vitality-gold' : 'bg-white/5 text-vitality-text']">
                  {{ user.is_pro ? 'PRO' : 'Standard' }}
                </span>
              </td>
              <td class="p-4 text-vitality-text text-xs">{{ formatDate(user.created_at) }}</td>
            </tr>
            <tr v-if="!users.data?.length">
              <td colspan="4" class="py-10 text-center text-vitality-text">No users found.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AdminLayout>
</template>
<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
defineProps({ users: Object })
const formatDate = (d) => d ? new Date(d).toLocaleDateString('fr-FR') : ''
</script>
