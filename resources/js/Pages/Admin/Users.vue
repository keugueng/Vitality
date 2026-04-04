<template>
  <AdminLayout>

    <!-- Top header -->
    <div class="flex items-center justify-between px-7 py-3.5 bg-white border-b border-gray-100 sticky top-0 z-10">
      <div>
        <h2 class="text-gray-800 font-semibold text-sm">Gestion Clients</h2>
        <p class="text-gray-400 text-xs">FiftyCare Admin › Gestion Clients</p>
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

      <!-- Title + actions -->
      <div class="flex items-start justify-between mb-5">
        <div>
          <h1 class="text-2xl font-bold text-gray-800">
            Gestion des
            <em class="font-bold" style="font-family: 'Cormorant Garamond', Georgia, serif; font-style: italic; color: #db2777;">Clients</em>
          </h1>
          <p class="text-gray-500 text-xs mt-1">
            {{ formatNum(stats.total) }} utilisatrices · {{ formatNum(stats.premium) }} abonnées Premium
          </p>
        </div>
        <div class="flex items-center gap-2">
          <select v-model="filterPlan"
            class="border border-gray-200 rounded-xl px-3 py-2.5 text-xs text-gray-600 outline-none focus:border-purple-400 bg-white">
            <option value="">Tous les plans</option>
            <option value="active">Premium actif</option>
            <option value="trial">Essai / Gratuit</option>
            <option value="payment">Paiement échoué</option>
          </select>
          <button
            class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors">
            📤 Exporter
          </button>
          <button @click="showAdd = true"
            class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-white text-sm font-medium hover:opacity-90 transition-opacity"
            style="background-color: #2E1545;">
            + Ajouter
          </button>
        </div>
      </div>

      <!-- Table card -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <!-- Search + pills -->
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 gap-4">
          <div class="flex items-center gap-2 rounded-xl px-3 py-2.5 border border-gray-200 bg-gray-50 w-72">
            <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input v-model="search" type="text" placeholder="Rechercher par nom, email..."
              class="bg-transparent text-xs text-gray-600 outline-none flex-1 placeholder-gray-400" />
          </div>
          <div class="flex items-center gap-2">
            <span class="px-3 py-1.5 rounded-lg text-xs font-semibold" style="background-color: #ede9fe; color: #6d28d9;">
              {{ formatNum(stats.total) }} total
            </span>
            <span class="px-3 py-1.5 rounded-lg text-xs font-semibold" style="background-color: #fce7f3; color: #be185d;">
              {{ formatNum(stats.premium) }} Premium
            </span>
            <span class="px-3 py-1.5 rounded-lg text-xs font-semibold" style="background-color: #f3f4f6; color: #6b7280;">
              {{ formatNum(stats.trial) }} Essai/Gratuit
            </span>
          </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="border-b border-gray-100">
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Utilisatrice</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Plan</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Protocole actif</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Séances</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Inscription</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Statut</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
              <tr v-for="(user, i) in filteredUsers" :key="user.id"
                class="hover:bg-gray-50/50 transition-colors">

                <!-- Utilisatrice -->
                <td class="px-5 py-3.5">
                  <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-white font-bold text-xs flex-shrink-0"
                      :style="{ backgroundColor: avatarColor(i) }">
                      {{ initials(user.name) }}
                    </div>
                    <div>
                      <p class="text-sm font-semibold text-gray-800">{{ user.name }}</p>
                      <p class="text-xs text-gray-400 mt-0.5">{{ user.email }}</p>
                    </div>
                  </div>
                </td>

                <!-- Plan -->
                <td class="px-5 py-3.5">
                  <span class="px-2.5 py-1 rounded-lg text-xs font-semibold"
                    :style="planStyle(user.plan)">
                    {{ user.plan }}
                  </span>
                </td>

                <!-- Protocole -->
                <td class="px-5 py-3.5">
                  <span v-if="user.protocol" class="flex items-center gap-1.5 text-sm text-gray-700">
                    <span>{{ user.protocol.emoji }}</span>
                    {{ user.protocol.title }}
                  </span>
                  <span v-else class="text-gray-300 text-xs">—</span>
                </td>

                <!-- Séances -->
                <td class="px-5 py-3.5 text-sm font-semibold text-gray-800">{{ user.sessions }}</td>

                <!-- Inscription -->
                <td class="px-5 py-3.5 text-sm text-gray-500">{{ user.created_at }}</td>

                <!-- Statut -->
                <td class="px-5 py-3.5">
                  <span class="flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold w-fit"
                    :style="statusStyle(user.status)">
                    {{ statusLabel(user.status) }}
                  </span>
                </td>

                <!-- Actions -->
                <td class="px-5 py-3.5">
                  <div class="flex items-center gap-1.5">
                    <button title="Voir le profil"
                      class="w-7 h-7 rounded-lg flex items-center justify-center border border-gray-200 hover:bg-gray-100 transition-colors">
                      <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                      </svg>
                    </button>
                    <button title="Modifier" @click="openEdit(user)"
                      class="w-7 h-7 rounded-lg flex items-center justify-center border hover:opacity-80 transition-opacity"
                      style="border-color: #bfdbfe; background-color: #eff6ff;">
                      <svg class="w-3.5 h-3.5" style="color: #3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                      </svg>
                    </button>
                    <button title="Supprimer" @click="confirmDelete(user)"
                      class="w-7 h-7 rounded-lg flex items-center justify-center border hover:opacity-80 transition-opacity"
                      style="border-color: #fecaca; background-color: #fef2f2;">
                      <svg class="w-3.5 h-3.5" style="color: #ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"/>
                        <circle cx="12" cy="12" r="9" stroke-width="2"/>
                      </svg>
                    </button>
                  </div>
                </td>

              </tr>

              <tr v-if="!filteredUsers.length">
                <td colspan="7" class="py-10 text-center text-gray-400 text-sm">Aucun utilisateur trouvé.</td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div v-if="users.last_page > 1" class="flex items-center justify-between px-5 py-3.5 border-t border-gray-100">
          <p class="text-xs text-gray-400">
            {{ users.from }}–{{ users.to }} sur {{ formatNum(users.total) }} utilisatrices
          </p>
          <div class="flex items-center gap-1">
            <Link v-for="link in users.links" :key="link.label"
              :href="link.url ?? '#'"
              v-html="link.label"
              class="px-3 py-1.5 rounded-lg text-xs transition-colors"
              :class="link.active
                ? 'text-white font-semibold'
                : 'text-gray-500 border border-gray-200 hover:bg-gray-50'"
              :style="link.active ? 'background-color: #7c3aed;' : ''"
              preserve-scroll />
          </div>
        </div>

      </div>
    </div>

    <!-- Edit modal -->
    <div v-if="editUser" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4">
      <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6">
        <h3 class="font-semibold text-gray-800 text-base mb-4">Modifier l'utilisatrice</h3>
        <div class="space-y-4">
          <div>
            <label class="text-xs font-medium text-gray-600 block mb-1.5">Nom</label>
            <input v-model="editForm.name" type="text"
              class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 outline-none focus:border-purple-400 transition-colors" />
          </div>
          <div>
            <label class="text-xs font-medium text-gray-600 block mb-1.5">Email</label>
            <input v-model="editForm.email" type="email"
              class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 outline-none focus:border-purple-400 transition-colors" />
          </div>
          <div class="flex items-center gap-3 pt-1">
            <button @click="editUser = null"
              class="flex-1 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-600 hover:bg-gray-50 transition-colors">
              Annuler
            </button>
            <button @click="editUser = null"
              class="flex-1 py-2.5 rounded-xl text-white text-sm font-medium hover:opacity-90 transition-opacity"
              style="background-color: #2E1545;">
              Sauvegarder
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Add modal -->
    <div v-if="showAdd" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4">
      <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6">
        <h3 class="font-semibold text-gray-800 text-base mb-4">Ajouter une utilisatrice</h3>
        <div class="space-y-4">
          <div>
            <label class="text-xs font-medium text-gray-600 block mb-1.5">Nom complet *</label>
            <input v-model="addForm.name" type="text" placeholder="Marie Dupont"
              class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 outline-none focus:border-purple-400 transition-colors" />
          </div>
          <div>
            <label class="text-xs font-medium text-gray-600 block mb-1.5">Email *</label>
            <input v-model="addForm.email" type="email" placeholder="marie@example.com"
              class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 outline-none focus:border-purple-400 transition-colors" />
          </div>
          <div>
            <label class="text-xs font-medium text-gray-600 block mb-1.5">Mot de passe provisoire *</label>
            <input v-model="addForm.password" type="password"
              class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 outline-none focus:border-purple-400 transition-colors" />
          </div>
          <div class="flex items-center gap-3 pt-1">
            <button @click="showAdd = false"
              class="flex-1 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-600 hover:bg-gray-50 transition-colors">
              Annuler
            </button>
            <button @click="showAdd = false"
              class="flex-1 py-2.5 rounded-xl text-white text-sm font-medium hover:opacity-90 transition-opacity"
              style="background-color: #2E1545;">
              Créer le compte
            </button>
          </div>
        </div>
      </div>
    </div>

  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'

const props = defineProps({
  users: Object,
  stats: Object,
})

const search     = ref('')
const filterPlan = ref('')
const showAdd    = ref(false)
const editUser   = ref(null)
const addForm    = ref({ name: '', email: '', password: '' })
const editForm   = ref({ name: '', email: '' })

const filteredUsers = computed(() => {
  let list = props.users.data ?? []
  if (search.value) {
    const q = search.value.toLowerCase()
    list = list.filter(u => u.name.toLowerCase().includes(q) || u.email.toLowerCase().includes(q))
  }
  if (filterPlan.value) {
    list = list.filter(u => u.status === filterPlan.value)
  }
  return list
})

const openEdit = (user) => {
  editUser.value = user
  editForm.value = { name: user.name, email: user.email }
}

const confirmDelete = (user) => {
  if (confirm(`Supprimer "${user.name}" ?`)) {
    router.delete(route('admin.users.destroy', user.id))
  }
}

const formatNum = (n) => Number(n).toLocaleString('fr-FR')

const initials = (name) => {
  return name.split(' ').map(w => w[0]).slice(0, 2).join('').toUpperCase()
}

const avatarColors = ['#6d28d9','#0d9488','#0284c7','#7c3aed','#64748b','#1e293b','#0f766e','#c2410c']
const avatarColor  = (i) => avatarColors[i % avatarColors.length]

const planStyle = (plan) => {
  if (plan === 'Essai 15j') return 'background-color: #f5f3ff; color: #6d28d9;'
  if (plan === '6 mois')   return 'background-color: #f0fdf4; color: #15803d;'
  if (plan === '12 mois')  return 'background-color: #f0fdf4; color: #166534;'
  return 'background-color: #fff7ed; color: #c2410c;'   // 1 mois, 3 mois
}

const statusStyle = (s) => {
  const map = {
    active:  'background-color: #f0fdf4; color: #15803d;',
    trial:   'background-color: #f5f3ff; color: #6d28d9;',
    payment: 'background-color: #fffbeb; color: #d97706;',
  }
  return map[s] ?? 'background-color: #f9fafb; color: #6b7280;'
}

const statusLabel = (s) => {
  const map = { active: '✓ Active', trial: '↩ Essai', payment: '⚠ Paiement' }
  return map[s] ?? s
}
</script>
