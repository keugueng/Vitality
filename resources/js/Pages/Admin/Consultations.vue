<template>
  <AdminLayout>
    <div class="max-w-6xl">
      <h1 class="font-serif text-3xl font-light text-white mb-8">Consultations</h1>
      <div class="glass-card rounded-2xl overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="border-b border-white/5">
            <tr class="text-vitality-text text-xs">
              <th class="text-left p-4">Client</th>
              <th class="text-left p-4">Package</th>
              <th class="text-left p-4">Amount</th>
              <th class="text-left p-4">Status</th>
              <th class="text-left p-4">Date</th>
              <th class="text-left p-4">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-white/5">
            <tr v-for="c in consultations.data" :key="c.id">
              <td class="p-4">
                <p class="text-white font-medium">{{ c.name }}</p>
                <p class="text-vitality-text text-xs">{{ c.email }}</p>
              </td>
              <td class="p-4 text-vitality-text capitalize">{{ c.package_type }} ({{ c.sessions_count }} session{{ c.sessions_count > 1 ? 's' : '' }})</td>
              <td class="p-4 text-vitality-gold font-semibold">€{{ c.amount }}</td>
              <td class="p-4">
                <span :class="statusClass(c.status)">{{ c.status }}</span>
              </td>
              <td class="p-4 text-vitality-text text-xs">{{ formatDate(c.created_at) }}</td>
              <td class="p-4">
                <button @click="manage(c)" class="text-xs text-vitality-cyan hover:underline">Manage</button>
              </td>
            </tr>
            <tr v-if="!consultations.data?.length">
              <td colspan="6" class="py-10 text-center text-vitality-text">No consultations yet.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Manage Modal -->
    <div v-if="selected" class="fixed inset-0 z-50 flex items-center justify-center px-4 bg-black/70 backdrop-blur-sm">
      <div class="glass-card rounded-3xl p-8 w-full max-w-lg border-glow">
        <h3 class="text-white font-semibold text-lg mb-1">Consultation — {{ selected.name }}</h3>
        <p class="text-vitality-text text-xs mb-5">{{ selected.email }} · {{ selected.package_type }} · €{{ selected.amount }}</p>

        <div class="glass-card rounded-xl p-4 mb-5 text-sm text-vitality-text">
          <p class="font-semibold text-white mb-2">Symptoms:</p>
          <p>{{ selected.symptoms }}</p>
        </div>

        <form @submit.prevent="submitManage" class="space-y-4">
          <div>
            <label class="text-vitality-text text-xs mb-1.5 block">Status</label>
            <select v-model="manageForm.status" class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-3 py-2.5 text-white text-sm focus:outline-none focus:border-vitality-cyan/50">
              <option value="pending">Pending</option>
              <option value="in_progress">In Progress</option>
              <option value="completed">Completed</option>
              <option value="cancelled">Cancelled</option>
            </select>
          </div>
          <div>
            <label class="text-vitality-text text-xs mb-1.5 block">Protocol Notes</label>
            <textarea v-model="manageForm.protocol_notes" rows="3" class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-3 py-2 text-white text-sm focus:outline-none focus:border-vitality-cyan/50 resize-none"></textarea>
          </div>
          <div>
            <label class="text-vitality-text text-xs mb-1.5 block">Protocol URL (PDF)</label>
            <input v-model="manageForm.protocol_url" type="url" placeholder="https://…" class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-3 py-2.5 text-white text-sm focus:outline-none focus:border-vitality-cyan/50"/>
          </div>
          <div class="flex gap-3">
            <button type="button" @click="selected = null" class="btn-outline flex-1 text-sm py-2.5">Close</button>
            <button type="submit" :disabled="manageForm.processing" class="btn-cyan flex-1 text-sm py-2.5 disabled:opacity-50">Save</button>
          </div>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>
<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
defineProps({ consultations: Object })
const selected = ref(null)
const manageForm = useForm({ status: '', protocol_notes: '', protocol_url: '' })
const manage = (c) => { selected.value = c; Object.assign(manageForm, { status: c.status, protocol_notes: c.protocol_notes || '', protocol_url: c.protocol_url || '' }) }
const submitManage = () => manageForm.put(route('admin.consultations.update', selected.value.id), { onSuccess: () => { selected.value = null } })
const statusClass = (s) => ({ 'text-xs rounded-full px-2.5 py-1': true, 'bg-yellow-500/10 text-yellow-400': s === 'pending', 'bg-vitality-cyan/10 text-vitality-cyan': s === 'in_progress', 'bg-green-500/10 text-green-400': s === 'completed', 'bg-red-500/10 text-red-400': s === 'cancelled' })
const formatDate = (d) => d ? new Date(d).toLocaleDateString('fr-FR') : ''
</script>
