<template>
  <AdminLayout>

    <!-- Page header -->
    <div class="flex items-center justify-between px-7 py-4 bg-white border-b border-gray-100 sticky top-0 z-10">
      <div>
        <h2 class="text-gray-800 font-semibold text-sm">Centre de notifications</h2>
        <p class="text-gray-400 text-xs">Vitality Inside Admin › Notifications</p>
      </div>
      <button @click="showForm = true"
        class="flex items-center gap-2 px-4 py-2 rounded-xl text-white text-xs font-semibold hover:opacity-90 transition-opacity"
        style="background: linear-gradient(135deg,#0d7377,#14a8a0);">
        <span class="text-base leading-none">+</span> Nouvelle notification
      </button>
    </div>

    <div class="px-7 py-5 space-y-6">

      <!-- Flash -->
      <div v-if="$page.props.flash?.success"
        class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm text-green-700"
        style="background:#f0fdf4; border:1px solid #bbf7d0;">
        ✓ {{ $page.props.flash.success }}
      </div>

      <!-- Stats -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div v-for="s in statCards" :key="s.label"
          class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
          <p class="text-2xl font-bold" :style="`color:${s.color}`">{{ s.value }}</p>
          <p class="text-xs text-gray-400 mt-1">{{ s.label }}</p>
        </div>
      </div>

      <!-- Notifications list -->
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
          <h3 class="font-semibold text-gray-800 text-sm">Notifications envoyées</h3>
          <span class="text-xs text-gray-400">{{ notifications.total }} au total</span>
        </div>

        <div v-if="!notifications.data.length" class="px-5 py-12 text-center text-gray-400 text-sm">
          Aucune notification envoyée pour l'instant.
        </div>

        <table v-else class="w-full">
          <thead>
            <tr class="border-b border-gray-100">
              <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Titre</th>
              <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Type</th>
              <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Cible</th>
              <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Statut</th>
              <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Date</th>
              <th class="px-5 py-3"></th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-50">
            <tr v-for="n in notifications.data" :key="n.id" class="hover:bg-gray-50/40 transition-colors">
              <td class="px-5 py-3.5">
                <p class="text-sm font-medium text-gray-800">{{ n.title }}</p>
                <p class="text-xs text-gray-400 mt-0.5 truncate max-w-xs">{{ n.body }}</p>
              </td>
              <td class="px-5 py-3.5">
                <span class="px-2.5 py-1 rounded-lg text-xs font-medium" :style="typeStyle(n.type)">
                  {{ typeLabel(n.type) }}
                </span>
              </td>
              <td class="px-5 py-3.5 text-sm text-gray-600">
                {{ n.broadcast ? '🌐 Tous' : (n.user ? `👤 ${n.user.name}` : '—') }}
              </td>
              <td class="px-5 py-3.5">
                <span class="px-2.5 py-1 rounded-lg text-xs font-medium"
                  :style="n.read_at ? 'background:#f0fdf4;color:#15803d;' : 'background:#fff7ed;color:#c2410c;'">
                  {{ n.read_at ? 'Lu' : 'Non lu' }}
                </span>
              </td>
              <td class="px-5 py-3.5 text-xs text-gray-400">{{ fmtDate(n.created_at) }}</td>
              <td class="px-5 py-3.5">
                <button @click="deleteNotif(n.id)"
                  class="text-gray-300 hover:text-red-400 transition-colors text-lg leading-none">×</button>
              </td>
            </tr>
          </tbody>
        </table>

        <!-- Pagination -->
        <div v-if="notifications.last_page > 1" class="px-5 py-3 border-t border-gray-100 flex items-center gap-2">
          <Link v-for="link in notifications.links" :key="link.label"
            :href="link.url || '#'"
            :class="['px-3 py-1 rounded-lg text-xs', link.active ? 'bg-teal-500 text-white' : 'text-gray-500 hover:bg-gray-100']"
            v-html="link.label" />
        </div>
      </div>

    </div>

    <!-- Send notification modal -->
    <div v-if="showForm" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4">
      <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6">
        <div class="flex items-center justify-between mb-5">
          <h3 class="font-semibold text-gray-800 text-base">Nouvelle notification</h3>
          <button @click="showForm = false" class="text-gray-400 hover:text-gray-600 text-xl leading-none">×</button>
        </div>
        <form @submit.prevent="sendNotif" class="space-y-4">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="text-xs font-medium text-gray-600 block mb-1.5">Type *</label>
              <select v-model="form.type"
                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 outline-none focus:border-teal-400 bg-white">
                <option value="info">💬 Info</option>
                <option value="success">✅ Succès</option>
                <option value="warning">⚠️ Avertissement</option>
                <option value="promo">🎁 Promo</option>
              </select>
            </div>
            <div>
              <label class="text-xs font-medium text-gray-600 block mb-1.5">Cible *</label>
              <select v-model="form.target"
                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 outline-none focus:border-teal-400 bg-white">
                <option value="all">🌐 Tous les utilisateurs</option>
                <option value="user">� Utilisateur spécifique</option>
              </select>
            </div>
          </div>
          <div v-if="form.target === 'user'">
            <label class="text-xs font-medium text-gray-600 block mb-1.5">ID utilisateur *</label>
            <input v-model="form.user_id" type="number" placeholder="ex: 42"
              class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 outline-none focus:border-teal-400" />
          </div>
          <div>
            <label class="text-xs font-medium text-gray-600 block mb-1.5">Titre *</label>
            <input v-model="form.title" type="text" required placeholder="Titre de la notification"
              class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 outline-none focus:border-teal-400" />
          </div>
          <div>
            <label class="text-xs font-medium text-gray-600 block mb-1.5">Message *</label>
            <textarea v-model="form.body" rows="3" required placeholder="Corps du message…"
              class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 outline-none focus:border-teal-400 resize-none"></textarea>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="text-xs font-medium text-gray-600 block mb-1.5">URL action (optionnel)</label>
              <input v-model="form.action_url" type="text" placeholder="/shop"
                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 outline-none focus:border-teal-400" />
            </div>
            <div>
              <label class="text-xs font-medium text-gray-600 block mb-1.5">Label bouton (optionnel)</label>
              <input v-model="form.action_label" type="text" placeholder="Voir maintenant"
                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 outline-none focus:border-teal-400" />
            </div>
          </div>
          <div class="flex gap-3 pt-2">
            <button type="button" @click="showForm = false"
              class="flex-1 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-600 hover:bg-gray-50">
              Annuler
            </button>
            <button type="submit" :disabled="sendForm.processing"
              class="flex-1 py-2.5 rounded-xl text-white text-sm font-semibold hover:opacity-90 disabled:opacity-50"
              style="background: linear-gradient(135deg,#0d7377,#14a8a0);">
              {{ sendForm.processing ? 'Envoi…' : 'Envoyer' }}
            </button>
          </div>
        </form>
      </div>
    </div>

  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, useForm, router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'

const props = defineProps({
  notifications: Object,
  stats: Object,
})

const showForm = ref(false)

const sendForm = useForm({
  type: 'info', target: 'all', user_id: null,
  title: '', body: '', action_url: '', action_label: '',
})
const form = sendForm

const statCards = computed(() => [
  { label: 'Total envoyées',   value: props.stats.total,     color: '#374151' },
  { label: 'Non lues',         value: props.stats.unread,    color: '#e53e3e' },
  { label: 'Broadcasts',       value: props.stats.broadcast, color: '#0d7377' },
  { label: 'Utilisateurs',     value: props.stats.users,     color: '#c8a96e' },
])

const sendNotif = () => {
  sendForm.post(route('admin.notifications.send'), {
    onSuccess: () => { showForm.value = false; sendForm.reset() },
  })
}

const deleteNotif = (id) => {
  if (confirm('Supprimer cette notification ?')) {
    router.delete(route('admin.notifications.destroy', id))
  }
}

const typeLabel = (t) => ({ info: 'Info', success: 'Succès', warning: 'Avert.', promo: 'Promo' })[t] || t
const typeStyle = (t) => {
  const map = {
    info:    'background:#eff6ff;color:#1d4ed8;',
    success: 'background:#f0fdf4;color:#15803d;',
    warning: 'background:#fff7ed;color:#c2410c;',
    promo:   'background:#fdf4ff;color:#7c3aed;',
  }
  return map[t] || 'background:#f9fafb;color:#6b7280;'
}

const fmtDate = (d) => d ? new Date(d).toLocaleDateString('fr-FR', { day:'2-digit', month:'short', hour:'2-digit', minute:'2-digit' }) : '—'
</script>
