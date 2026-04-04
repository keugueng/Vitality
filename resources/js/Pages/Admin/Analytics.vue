<template>
  <AdminLayout>

    <!-- Top header -->
    <div class="flex items-center justify-between px-7 py-3.5 bg-white border-b border-gray-100 sticky top-0 z-10">
      <div>
        <h2 class="text-gray-800 font-semibold text-sm">Analytiques</h2>
        <p class="text-gray-400 text-xs">FiftyCare Admin › Analytiques</p>
      </div>
      <div class="flex items-center gap-2">
        <div class="flex items-center gap-2 rounded-xl px-3 py-2 border border-gray-200 bg-gray-50">
          <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
          <input type="text" placeholder="Rechercher..." class="bg-transparent text-xs text-gray-600 outline-none w-40 placeholder-gray-400" />
        </div>
        <button class="w-8 h-8 rounded-xl bg-gray-50 border border-gray-200 flex items-center justify-center hover:bg-gray-100 transition-colors text-sm">🔔</button>
        <button class="w-8 h-8 rounded-xl bg-gray-50 border border-gray-200 flex items-center justify-center hover:bg-gray-100 transition-colors text-sm">👤</button>
        <button class="w-8 h-8 rounded-xl bg-gray-50 border border-gray-200 flex items-center justify-center hover:bg-gray-100 transition-colors text-sm">⚙️</button>
      </div>
    </div>

    <div class="px-7 py-5">

      <!-- Title + period selector -->
      <div class="flex items-start justify-between mb-6">
        <div>
          <h1 class="text-2xl font-bold text-gray-800">
            Analytiques
            <em class="font-bold" style="font-family: 'Cormorant Garamond', Georgia, serif; font-style: italic; color: #db2777;">avancées</em>
          </h1>
          <p class="text-gray-400 text-xs mt-1">Funnel de conversion · Engagement · Rétention</p>
        </div>
        <select v-model="period"
          class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-purple-300 bg-white transition-colors appearance-none pr-8 cursor-pointer"
          style="background-image: url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E\"); background-repeat: no-repeat; background-position: right 12px center;">
          <option value="7">7 derniers jours</option>
          <option value="30">30 derniers jours</option>
          <option value="90">90 derniers jours</option>
          <option value="365">12 derniers mois</option>
        </select>
      </div>

      <!-- Funnel de conversion -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-5">
        <div class="flex items-center justify-between mb-5">
          <h3 class="font-semibold text-gray-800 text-sm">Funnel de conversion</h3>
          <span class="text-xs text-gray-400">De l'inscription au paiement</span>
        </div>

        <div class="grid grid-cols-5 gap-3">
          <div v-for="(step, i) in funnel" :key="step.key"
            class="rounded-xl p-4 flex flex-col gap-1"
            :style="i === funnel.length - 1
              ? 'background: linear-gradient(135deg, #2E1545 0%, #7c3aed 100%); color: white;'
              : 'background-color: #fafafa; border: 1px solid #f3f4f6;'">
            <p class="text-xs font-semibold tracking-wider uppercase"
              :style="i === funnel.length - 1 ? 'color: rgba(255,255,255,0.6);' : 'color: #9ca3af;'">
              {{ step.label }}
            </p>
            <p class="text-2xl font-bold mt-1"
              :style="i === funnel.length - 1 ? 'color: white;' : 'color: #1f2937;'">
              {{ step.value.toLocaleString('fr-FR') }}
            </p>
            <p class="text-xs font-semibold"
              :style="i === 0
                ? (i === funnel.length - 1 ? 'color: rgba(255,255,255,0.7);' : 'color: #6b7280;')
                : (i === funnel.length - 1 ? 'color: rgba(255,255,255,0.85);' : 'color: #10b981;')">
              {{ step.pct }}
            </p>
          </div>
        </div>
      </div>

      <!-- Bottom row: 3 cards -->
      <div class="grid grid-cols-3 gap-5">

        <!-- Rétention hebdomadaire -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
          <h3 class="font-semibold text-gray-800 text-sm mb-5">Rétention hebdomadaire</h3>
          <div class="space-y-4">
            <div v-for="row in retention" :key="row.label" class="flex items-center gap-3">
              <span class="text-xs text-gray-500 w-28 flex-shrink-0">{{ row.label }}</span>
              <div class="flex-1 h-2 rounded-full overflow-hidden" style="background-color: #f3e8ff;">
                <div class="h-full rounded-full"
                  style="background: linear-gradient(90deg, #db2777, #7c3aed);"
                  :style="{ width: row.pct + '%' }"></div>
              </div>
              <span class="text-xs font-semibold text-gray-700 w-8 text-right flex-shrink-0">{{ row.pct }}%</span>
            </div>
          </div>
        </div>

        <!-- Durée moy. séance -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center text-center">
          <h3 class="font-semibold text-gray-800 text-sm mb-4 self-start">Durée moy. séance</h3>
          <p class="font-bold" style="font-size: 3rem; line-height: 1; color: #1f2937; letter-spacing: -1px;">16:42</p>
          <p class="text-xs text-gray-400 mt-2">minutes · sur 18:00 max</p>
          <p class="text-xs font-semibold mt-3" style="color: #10b981;">✓ Complétion à 93%</p>
        </div>

        <!-- Note App Store -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center text-center">
          <h3 class="font-semibold text-gray-800 text-sm mb-4 self-start">Note App Store</h3>
          <p class="font-bold" style="font-size: 3rem; line-height: 1; color: #1f2937; letter-spacing: -1px;">4.8</p>
          <div class="flex items-center gap-0.5 mt-3">
            <span v-for="n in 5" :key="n" class="text-lg" style="color: #f59e0b;">★</span>
          </div>
          <p class="text-xs text-gray-400 mt-2">8 240+ avis · iOS &amp; Android</p>
        </div>

      </div>
    </div>

  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { ref } from 'vue'

const period = ref('30')

const funnel = [
  { key: 'visites',      label: 'Visites',      value: 24800, pct: '100%'  },
  { key: 'inscriptions', label: 'Inscriptions', value: 8247,  pct: '33,3%' },
  { key: 'seance',       label: '1ère Séance',  value: 5361,  pct: '65%'   },
  { key: 'paywall',      label: 'Paywall Vu',   value: 3862,  pct: '72%'   },
  { key: 'converti',     label: 'Converti',     value: 1043,  pct: '12,7%' },
]

const retention = [
  { label: 'Semaine 1',    pct: 72 },
  { label: 'Semaine 2',    pct: 58 },
  { label: 'Semaine 3',    pct: 51 },
  { label: 'Semaine 4 (D30)', pct: 47 },
]
</script>
