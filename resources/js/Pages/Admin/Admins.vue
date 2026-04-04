<template>
  <AdminLayout>

    <!-- Top header -->
    <div class="flex items-center justify-between px-7 py-3.5 bg-white border-b border-gray-100 sticky top-0 z-10">
      <div>
        <h2 class="text-gray-800 font-semibold text-sm">Administrateurs</h2>
        <p class="text-gray-400 text-xs">FiftyCare Admin › Administrateurs</p>
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

      <!-- Title + invite -->
      <div class="flex items-start justify-between mb-6">
        <div>
          <h1 class="text-2xl font-bold text-gray-800">
            Gestion des
            <em class="font-bold" style="font-family: 'Cormorant Garamond', Georgia, serif; font-style: italic; color: #db2777;">Administrateurs</em>
          </h1>
          <p class="text-gray-400 text-xs mt-1">Accès et rôles de l'équipe back office</p>
        </div>
        <button @click="showInvite = true"
          class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-80"
          style="background-color: #2E1545;">
          + Inviter admin
        </button>
      </div>

      <!-- Table -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full">
          <thead>
            <tr class="border-b border-gray-100">
              <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-400 uppercase tracking-wider">Administrateur</th>
              <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-400 uppercase tracking-wider">Rôle</th>
              <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-400 uppercase tracking-wider">Accès</th>
              <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-400 uppercase tracking-wider">Dernière connexion</th>
              <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-50">
            <tr v-for="(admin, i) in admins" :key="admin.id ?? i"
              class="hover:bg-gray-50/50 transition-colors">

              <!-- Name + email -->
              <td class="px-6 py-4">
                <div class="flex items-center gap-3">
                  <div class="w-9 h-9 rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0"
                    :style="{ backgroundColor: avatarColor(admin.name) }">
                    {{ initial(admin.name) }}
                  </div>
                  <div>
                    <p class="text-sm font-semibold text-gray-800">{{ admin.name }}</p>
                    <p class="text-xs text-gray-400">{{ admin.email }}</p>
                  </div>
                </div>
              </td>

              <!-- Role badge -->
              <td class="px-6 py-4">
                <span class="px-3 py-1 rounded-lg text-xs font-semibold"
                  :style="roleStyle(admin.role)">
                  {{ admin.role }}
                </span>
              </td>

              <!-- Access -->
              <td class="px-6 py-4">
                <p class="text-sm text-gray-600">{{ admin.access }}</p>
              </td>

              <!-- Last login -->
              <td class="px-6 py-4">
                <p class="text-sm text-gray-500">{{ admin.last_login }}</p>
              </td>

              <!-- Actions -->
              <td class="px-6 py-4">
                <button @click="openEdit(admin)"
                  class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold border border-gray-200 text-gray-600 bg-white hover:bg-gray-50 transition-colors">
                  ✏️ Modifier
                </button>
              </td>

            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Invite modal -->
    <div v-if="showInvite" class="fixed inset-0 z-50 flex items-center justify-center">
      <div class="absolute inset-0 bg-black/30" @click="showInvite = false"></div>
      <div class="relative bg-white rounded-2xl shadow-xl p-6 w-full max-w-md mx-4">
        <h3 class="font-bold text-gray-800 text-base mb-1">Inviter un administrateur</h3>
        <p class="text-xs text-gray-400 mb-5">Un email d'invitation sera envoyé</p>
        <div class="space-y-4">
          <div>
            <label class="block text-xs text-gray-500 font-medium mb-1.5">Nom complet</label>
            <input v-model="inviteForm.name" placeholder="Marie Dupont"
              class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm outline-none focus:border-purple-300 transition-colors" />
          </div>
          <div>
            <label class="block text-xs text-gray-500 font-medium mb-1.5">Email</label>
            <input v-model="inviteForm.email" type="email" placeholder="marie@fiftycare.fr"
              class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm outline-none focus:border-purple-300 transition-colors" />
          </div>
          <div>
            <label class="block text-xs text-gray-500 font-medium mb-1.5">Rôle</label>
            <select v-model="inviteForm.role"
              class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm outline-none focus:border-purple-300 bg-white transition-colors">
              <option value="Super Admin">Super Admin</option>
              <option value="Contenu">Contenu</option>
              <option value="Partenariats">Partenariats</option>
              <option value="Finance">Finance</option>
            </select>
          </div>
        </div>
        <div class="flex gap-2 mt-6">
          <button @click="showInvite = false"
            class="flex-1 py-2.5 rounded-xl text-sm font-semibold border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors">
            Annuler
          </button>
          <button @click="showInvite = false"
            class="flex-1 py-2.5 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-80"
            style="background-color: #2E1545;">
            Envoyer l'invitation
          </button>
        </div>
      </div>
    </div>

    <!-- Edit modal -->
    <div v-if="editAdmin" class="fixed inset-0 z-50 flex items-center justify-center">
      <div class="absolute inset-0 bg-black/30" @click="editAdmin = null"></div>
      <div class="relative bg-white rounded-2xl shadow-xl p-6 w-full max-w-md mx-4">
        <h3 class="font-bold text-gray-800 text-base mb-1">Modifier l'accès</h3>
        <p class="text-xs text-gray-400 mb-5">{{ editAdmin.name }} · {{ editAdmin.email }}</p>
        <div class="space-y-4">
          <div>
            <label class="block text-xs text-gray-500 font-medium mb-1.5">Rôle</label>
            <select v-model="editAdmin.role"
              class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm outline-none focus:border-purple-300 bg-white transition-colors">
              <option value="Super Admin">Super Admin</option>
              <option value="Contenu">Contenu</option>
              <option value="Partenariats">Partenariats</option>
              <option value="Finance">Finance</option>
            </select>
          </div>
          <div>
            <label class="block text-xs text-gray-500 font-medium mb-1.5">Accès</label>
            <input v-model="editAdmin.access"
              class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm outline-none focus:border-purple-300 transition-colors" />
          </div>
        </div>
        <div class="flex gap-2 mt-6">
          <button @click="editAdmin = null"
            class="flex-1 py-2.5 rounded-xl text-sm font-semibold border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors">
            Annuler
          </button>
          <button @click="editAdmin = null"
            class="flex-1 py-2.5 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-80"
            style="background-color: #2E1545;">
            Enregistrer
          </button>
        </div>
      </div>
    </div>

  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { ref } from 'vue'

const props = defineProps({ admins: Array })

const showInvite = ref(false)
const editAdmin  = ref(null)
const inviteForm = ref({ name: '', email: '', role: 'Contenu' })

const openEdit = (admin) => { editAdmin.value = { ...admin } }

const initial = (name) => name?.charAt(0)?.toUpperCase() ?? '?'

const palette = ['#7c3aed', '#db2777', '#0d9488', '#0284c7', '#c2410c', '#1e293b']
const avatarColor = (name) => palette[(name?.charCodeAt(0) ?? 0) % palette.length]

const roleStyle = (role) => {
  const map = {
    'Super Admin':  'background-color: #f5f3ff; color: #6d28d9;',
    'Partenariats': 'background-color: #fff7ed; color: #c2410c;',
    'Contenu':      'background-color: #f0fdfa; color: #0f766e;',
    'Finance':      'background-color: #fef3c7; color: #b45309;',
  }
  return map[role] ?? 'background-color: #f3f4f6; color: #6b7280;'
}
</script>
