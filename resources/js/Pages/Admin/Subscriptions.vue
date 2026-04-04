<template>
  <AdminLayout>

    <!-- Top header -->
    <div class="flex items-center justify-between px-7 py-3.5 bg-white border-b border-gray-100 sticky top-0 z-10">
      <div>
        <h2 class="text-gray-800 font-semibold text-sm">Abonnements</h2>
        <p class="text-gray-400 text-xs">FiftyCare Admin › Abonnements</p>
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

      <!-- Title -->
      <div class="mb-5">
        <h1 class="text-2xl font-bold text-gray-800">
          Gestion des
          <em class="font-bold" style="font-family: 'Cormorant Garamond', Georgia, serif; font-style: italic; color: #db2777;">Abonnements</em>
        </h1>
        <p class="text-gray-400 text-xs mt-1">Suivi des plans Premium · 1 mois · 3 mois · 6 mois</p>
      </div>

      <!-- 4 stat cards -->
      <div class="grid grid-cols-4 gap-4 mb-5">

        <!-- 1 mois -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
          <div class="flex items-start justify-between mb-3">
            <p class="text-gray-500 text-xs font-medium">Abonnements 1 mois</p>
            <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm" style="background-color: #fce7f3;">📋</div>
          </div>
          <p class="text-3xl font-bold text-gray-800 mb-1">{{ formatNum(stats.one) }}</p>
          <p class="text-xs flex items-center gap-1" style="color: #10b981;">
            <span>↑</span> {{ pct(stats.one) }}% du total
          </p>
        </div>

        <!-- 3 mois -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
          <div class="flex items-start justify-between mb-3">
            <p class="text-gray-500 text-xs font-medium">Abonnements 3 mois</p>
            <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm" style="background-color: #fef3c7;">⭐</div>
          </div>
          <p class="text-3xl font-bold text-gray-800 mb-1">{{ formatNum(stats.three) }}</p>
          <p class="text-xs flex items-center gap-1" style="color: #10b981;">
            <span>↑</span> {{ pct(stats.three) }}% · le plus populaire
          </p>
        </div>

        <!-- 6 mois -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
          <div class="flex items-start justify-between mb-3">
            <p class="text-gray-500 text-xs font-medium">Abonnements 6 mois</p>
            <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm" style="background-color: #ede9fe;">💎</div>
          </div>
          <p class="text-3xl font-bold text-gray-800 mb-1">{{ formatNum(stats.six) }}</p>
          <p class="text-xs flex items-center gap-1 text-gray-500">
            <span>=</span> {{ pct(stats.six) }}% · haute LTV
          </p>
        </div>

        <!-- Taux renouvellement -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
          <div class="flex items-start justify-between mb-3">
            <p class="text-gray-500 text-xs font-medium">Taux de renouvellement</p>
            <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm" style="background-color: #e0f2fe;">🔄</div>
          </div>
          <p class="text-3xl font-bold text-gray-800 mb-1">{{ stats.renew_rate }}%</p>
          <p class="text-xs flex items-center gap-1" style="color: #10b981;">
            <span>↑</span> Très bon signe
          </p>
        </div>

      </div>

      <!-- Bottom row: chart + expirations -->
      <div class="grid grid-cols-3 gap-5">

        <!-- Répartition des plans (2/3) -->
        <div class="col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
          <h3 class="font-semibold text-gray-800 text-sm mb-6">Répartition des plans</h3>

          <!-- Bars -->
          <div class="space-y-4 mb-8">

            <!-- 3 mois -->
            <div class="flex items-center gap-4">
              <p class="text-xs text-gray-600 w-36 flex-shrink-0">3 mois (37,90€)</p>
              <div class="flex-1 h-3 rounded-full overflow-hidden" style="background-color: #fce7f3;">
                <div class="h-3 rounded-full transition-all duration-700"
                  :style="{ width: pct(stats.three) + '%', background: 'linear-gradient(to right, #7c3aed, #db2777)' }"></div>
              </div>
              <p class="text-xs font-semibold text-gray-600 w-8 text-right">{{ pct(stats.three) }}%</p>
            </div>

            <!-- 1 mois -->
            <div class="flex items-center gap-4">
              <p class="text-xs text-gray-600 w-36 flex-shrink-0">1 mois (14,90€)</p>
              <div class="flex-1 h-3 rounded-full overflow-hidden" style="background-color: #fce7f3;">
                <div class="h-3 rounded-full transition-all duration-700"
                  :style="{ width: pct(stats.one) + '%', background: '#db2777' }"></div>
              </div>
              <p class="text-xs font-semibold text-gray-600 w-8 text-right">{{ pct(stats.one) }}%</p>
            </div>

            <!-- 6 mois -->
            <div class="flex items-center gap-4">
              <p class="text-xs text-gray-600 w-36 flex-shrink-0">6 mois (67,90€)</p>
              <div class="flex-1 h-3 rounded-full overflow-hidden" style="background-color: #fef3c7;">
                <div class="h-3 rounded-full transition-all duration-700"
                  :style="{ width: pct(stats.six) + '%', background: 'linear-gradient(to right, #f59e0b, #ef4444)' }"></div>
              </div>
              <p class="text-xs font-semibold text-gray-600 w-8 text-right">{{ pct(stats.six) }}%</p>
            </div>

          </div>

          <!-- ARPU + LTV -->
          <div class="grid grid-cols-2 gap-4 border-t border-gray-100 pt-6">
            <div class="text-center">
              <p class="text-2xl font-bold text-gray-800">12,50€</p>
              <p class="text-xs text-gray-400 mt-1">ARPU mensuel moyen</p>
            </div>
            <div class="text-center">
              <p class="text-2xl font-bold" style="color: #10b981;">43 mois</p>
              <p class="text-xs text-gray-400 mt-1">LTV estimée</p>
            </div>
          </div>
        </div>

        <!-- Expirations à venir (1/3) -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
          <h3 class="font-semibold text-gray-800 text-sm mb-5">Expirations à venir</h3>

          <!-- Column headers -->
          <div class="grid grid-cols-4 gap-2 mb-3">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider col-span-1">Utilisatrice</p>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Plan</p>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Expiration</p>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Action</p>
          </div>

          <div class="space-y-3.5">
            <div v-for="e in expiring" :key="e.name"
              class="grid grid-cols-4 gap-2 items-center py-2 border-b border-gray-50 last:border-0">

              <p class="text-sm font-medium text-gray-700 col-span-1 truncate">{{ e.name }}</p>

              <span class="px-2 py-0.5 rounded-lg text-xs font-semibold w-fit"
                :style="planStyle(e.plan)">
                {{ e.plan }}
              </span>

              <p class="text-xs font-medium"
                :style="e.urgent ? 'color: #ef4444;' : 'color: #6b7280;'">
                {{ e.expires_at }}
              </p>

              <button class="px-2.5 py-1 rounded-lg text-xs font-semibold flex items-center gap-1 transition-opacity hover:opacity-80"
                :style="actionStyle(e.plan)">
                {{ actionLabel(e.plan) }}
              </button>
            </div>
          </div>
        </div>

      </div>
    </div>

  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { computed } from 'vue'

const props = defineProps({
  stats:    Object,
  expiring: Array,
})

const formatNum = (n) => Number(n).toLocaleString('fr-FR')

const totalPlans = computed(() => (props.stats.one + props.stats.three + props.stats.six) || 1)

const pct = (n) => Math.round((n / totalPlans.value) * 100)

const planStyle = (plan) => {
  const map = {
    '3 mois':  'background-color: #fff7ed; color: #c2410c;',
    '6 mois':  'background-color: #ede9fe; color: #6d28d9;',
    '12 mois': 'background-color: #f0fdf4; color: #15803d;',
    '1 mois':  'background-color: #fce7f3; color: #be185d;',
    'Essai':   'background-color: #f5f3ff; color: #6d28d9;',
  }
  return map[plan] ?? 'background-color: #f3f4f6; color: #6b7280;'
}

const actionStyle = (plan) => {
  if (plan === 'Essai') return 'background-color: #eff6ff; color: #3b82f6;'
  if (plan === '6 mois') return 'background-color: #f5f3ff; color: #7c3aed;'
  return 'background-color: #f0fdf4; color: #15803d;'
}

const actionLabel = (plan) => {
  if (plan === '6 mois') return '⏱ Programmer'
  return '↩ Relancer'
}
</script>
