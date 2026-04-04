<template>
  <AdminLayout>

    <!-- Top header -->
    <div class="flex items-center justify-between px-7 py-3.5 bg-white border-b border-gray-100 sticky top-0 z-10">
      <div>
        <h2 class="text-gray-800 font-semibold text-sm">Notifications</h2>
        <p class="text-gray-400 text-xs">FiftyCare Admin › Notifications</p>
      </div>
      <div class="flex items-center gap-2">
        <div class="flex items-center gap-2 rounded-xl px-3 py-2 border border-gray-200 bg-gray-50">
          <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
          <input type="text" placeholder="Rechercher..." class="bg-transparent text-xs text-gray-600 outline-none w-40 placeholder-gray-400" />
        </div>
        <button class="w-8 h-8 rounded-xl bg-gray-50 border border-gray-200 flex items-center justify-center hover:bg-gray-100 transition-colors text-sm">🔔</button>
        <button class="w-8 h-8 rounded-xl bg-gray-50 border border-gray-200 flex items-center justify-center hover:bg-gray-100 transition-colors text-sm">⬇️</button>
        <button class="w-8 h-8 rounded-xl bg-gray-50 border border-gray-200 flex items-center justify-center hover:bg-gray-100 transition-colors text-sm">⚙️</button>
      </div>
    </div>

    <div class="px-7 py-5">

      <!-- Title + action -->
      <div class="flex items-start justify-between mb-5">
        <div>
          <h1 class="text-2xl font-bold text-gray-800">
            Centre de
            <em class="font-bold" style="font-family: 'Cormorant Garamond', Georgia, serif; font-style: italic; color: #db2777;">Notifications</em>
          </h1>
          <p class="text-gray-400 text-xs mt-1">Campagnes email, push et SMS</p>
        </div>
        <button @click="showNew = true"
          class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-white text-sm font-medium hover:opacity-90 transition-opacity"
          style="background-color: #2E1545;">
          + Nouvelle campagne
        </button>
      </div>

      <!-- Actions urgentes -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-5">

        <div class="flex items-center gap-2 px-5 py-3.5 border-b border-gray-100">
          <span class="text-sm">🔴</span>
          <h3 class="font-semibold text-gray-800 text-sm">Actions urgentes ({{ alerts.length }})</h3>
        </div>

        <div class="divide-y divide-gray-50">
          <div v-for="alert in alerts" :key="alert.id"
            class="flex items-center gap-4 px-5 py-4"
            :style="alertBg(alert.color)">

            <!-- Icon -->
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 text-base"
              :style="alertIconBg(alert.color)">
              {{ alert.icon }}
            </div>

            <!-- Text -->
            <div class="flex-1 min-w-0">
              <p class="text-sm font-semibold" :style="alertTitleColor(alert.color)">{{ alert.title }}</p>
              <p class="text-xs text-gray-500 mt-0.5">{{ alert.desc }}</p>
            </div>

            <!-- Action -->
            <button
              class="px-4 py-2 rounded-xl text-sm font-medium flex-shrink-0 transition-opacity hover:opacity-90"
              :style="alert.primary
                ? 'background-color: #2E1545; color: white;'
                : 'background-color: white; color: #374151; border: 1px solid #e5e7eb;'">
              {{ alert.action }}
            </button>

          </div>
        </div>
      </div>

      <!-- Campagnes récentes -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-5 py-4 border-b border-gray-100">
          <h3 class="font-semibold text-gray-800 text-sm">Campagnes récentes</h3>
        </div>

        <table class="w-full">
          <thead>
            <tr class="border-b border-gray-100">
              <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Campagne</th>
              <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Type</th>
              <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Destinataires</th>
              <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Ouverture</th>
              <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Conversion</th>
              <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Date</th>
              <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Statut</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-50">
            <tr v-for="c in campaigns" :key="c.name"
              class="hover:bg-gray-50/50 transition-colors">
              <td class="px-5 py-3.5 text-sm font-medium text-gray-800">{{ c.name }}</td>
              <td class="px-5 py-3.5">
                <span class="flex items-center gap-1.5 text-sm text-gray-600">
                  <span class="text-xs">{{ c.type === 'Email' ? '📧' : '📱' }}</span>
                  {{ c.type }}
                </span>
              </td>
              <td class="px-5 py-3.5 text-sm text-gray-700">{{ formatNum(c.recipients) }}</td>
              <td class="px-5 py-3.5 text-sm" :class="c.open_rate ? 'text-gray-800 font-medium' : 'text-gray-300'">
                {{ c.open_rate ?? '—' }}
              </td>
              <td class="px-5 py-3.5 text-sm" :class="c.conv_rate ? 'text-gray-800 font-medium' : 'text-gray-300'">
                {{ c.conv_rate ?? '—' }}
              </td>
              <td class="px-5 py-3.5 text-sm text-gray-500">{{ c.date }}</td>
              <td class="px-5 py-3.5">
                <span class="px-2.5 py-1 rounded-lg text-xs font-medium"
                  :style="statusStyle(c.status)">
                  {{ c.status }}
                </span>
              </td>
            </tr>
          </tbody>
        </table>

      </div>
    </div>

    <!-- New campaign modal -->
    <div v-if="showNew" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4">
      <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
        <h3 class="font-semibold text-gray-800 text-base mb-4">Nouvelle campagne</h3>
        <div class="space-y-4">
          <div>
            <label class="text-xs font-medium text-gray-600 block mb-1.5">Nom de la campagne *</label>
            <input v-model="newForm.name" type="text" placeholder="Ex : Relance premium mai"
              class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 outline-none focus:border-purple-400 transition-colors" />
          </div>
          <div>
            <label class="text-xs font-medium text-gray-600 block mb-1.5">Type</label>
            <select v-model="newForm.type"
              class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 outline-none focus:border-purple-400 bg-white">
              <option value="Email">📧 Email</option>
              <option value="Push">📱 Push</option>
              <option value="SMS">💬 SMS</option>
            </select>
          </div>
          <div>
            <label class="text-xs font-medium text-gray-600 block mb-1.5">Destinataires</label>
            <select v-model="newForm.audience"
              class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 outline-none focus:border-purple-400 bg-white">
              <option value="all">Tous les utilisateurs</option>
              <option value="trial">Essais en cours</option>
              <option value="premium">Abonnées Premium</option>
              <option value="inactive">Inactifs 30j+</option>
            </select>
          </div>
          <div>
            <label class="text-xs font-medium text-gray-600 block mb-1.5">Message *</label>
            <textarea v-model="newForm.message" rows="3" placeholder="Corps du message…"
              class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 outline-none focus:border-purple-400 transition-colors resize-none"></textarea>
          </div>
          <div class="flex items-center gap-3 pt-1">
            <button @click="showNew = false"
              class="flex-1 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-600 hover:bg-gray-50 transition-colors">
              Annuler
            </button>
            <button @click="showNew = false"
              class="flex-1 py-2.5 rounded-xl text-white text-sm font-medium hover:opacity-90 transition-opacity"
              style="background-color: #2E1545;">
              Créer la campagne
            </button>
          </div>
        </div>
      </div>
    </div>

  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { ref } from 'vue'

defineProps({
  alerts:    Array,
  campaigns: Array,
})

const showNew = ref(false)
const newForm = ref({ name: '', type: 'Email', audience: 'all', message: '' })

const formatNum = (n) => Number(n).toLocaleString('fr-FR')

const alertBg = (color) => {
  const map = {
    red:   'background-color: #fff5f5;',
    amber: 'background-color: #fffbeb;',
    blue:  'background-color: #f0f4ff;',
  }
  return map[color] ?? ''
}
const alertIconBg = (color) => {
  const map = {
    red:   'background-color: #fee2e2;',
    amber: 'background-color: #fef3c7;',
    blue:  'background-color: #e0e7ff;',
  }
  return map[color] ?? ''
}
const alertTitleColor = (color) => {
  const map = {
    red:   'color: #dc2626;',
    amber: 'color: #d97706;',
    blue:  'color: #4f46e5;',
  }
  return map[color] ?? 'color: #1f2937;'
}

const statusStyle = (status) => {
  const map = {
    'Envoyé':     'background-color: #f0fdf4; color: #15803d;',
    'Terminé':    'background-color: #f0fdf4; color: #15803d;',
    'En attente': 'background-color: #fff7ed; color: #c2410c;',
    'Brouillon':  'background-color: #f9fafb; color: #6b7280;',
  }
  return map[status] ?? 'background-color: #f9fafb; color: #6b7280;'
}
</script>
