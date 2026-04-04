<template>
  <AdminLayout>

    <!-- Top header -->
    <div class="flex items-center justify-between px-7 py-3.5 bg-white border-b border-gray-100 sticky top-0 z-10">
      <div>
        <h2 class="text-gray-800 font-semibold text-sm">Stats Symptômes</h2>
        <p class="text-gray-400 text-xs">FiftyCare Admin › Stats Symptômes</p>
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
      <div class="flex items-start justify-between mb-5">
        <div>
          <h1 class="text-2xl font-bold text-gray-800">
            Stats
            <em class="font-bold" style="font-family: 'Cormorant Garamond', Georgia, serif; font-style: italic; color: #db2777;">Symptômes</em>
            &amp; Utilisatrices
          </h1>
          <p class="text-gray-400 text-xs mt-1">Analyse des symptômes déclarés et progression par protocole</p>
        </div>
        <button class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold text-white transition-opacity hover:opacity-80"
          style="background-color: #2E1545;">
          <span>📄</span> Export PDF
        </button>
      </div>

      <!-- 4 stat cards -->
      <div class="grid grid-cols-4 gap-4 mb-5">

        <!-- Symptôme #1 -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
          <p class="text-gray-500 text-xs font-medium mb-3">Symptôme #1 déclaré</p>
          <p class="text-3xl font-bold text-gray-800 mb-1 flex items-center gap-2">
            <span class="text-2xl">🌡</span> Bouffées
          </p>
          <p class="text-xs text-gray-400">82% des inscriptions</p>
        </div>

        <!-- Amélioration moy. J30 -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
          <p class="text-gray-500 text-xs font-medium mb-3">Amélioration moy. J30</p>
          <p class="text-3xl font-bold text-gray-800 mb-1">+38%</p>
          <p class="text-xs flex items-center gap-1" style="color: #10b981;">
            <span>↑</span> Sur bouffées de chaleur
          </p>
        </div>

        <!-- Protocoles complétés -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
          <p class="text-gray-500 text-xs font-medium mb-3">Protocoles complétés</p>
          <p class="text-3xl font-bold text-gray-800 mb-1">{{ formatNum(stats.completedProtocols) }}</p>
          <p class="text-xs flex items-center gap-1" style="color: #10b981;">
            <span>↑</span> +340 ce mois
          </p>
        </div>

        <!-- NPS score -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
          <p class="text-gray-500 text-xs font-medium mb-3">NPS score</p>
          <p class="text-3xl font-bold text-gray-800 mb-1">47</p>
          <p class="text-xs flex items-center gap-1" style="color: #10b981;">
            <span>↑</span> Excellent (&gt; 40)
          </p>
        </div>

      </div>

      <!-- Middle row: declared symptoms + improvement after protocol -->
      <div class="grid grid-cols-5 gap-5 mb-5">

        <!-- Symptômes les plus déclarés (3/5) -->
        <div class="col-span-3 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
          <div class="flex items-center justify-between mb-6">
            <h3 class="font-semibold text-gray-800 text-sm">Symptômes les plus déclarés</h3>
            <p class="text-xs text-gray-400">À l'inscription — base {{ formatNum(stats.totalUsers) }} utilisatrices</p>
          </div>

          <div class="space-y-4">
            <div v-for="s in declaredSymptoms" :key="s.label" class="flex items-center gap-4">
              <div class="flex items-center gap-2 w-44 flex-shrink-0">
                <span class="text-sm">{{ s.icon }}</span>
                <p class="text-xs text-gray-600 leading-tight">{{ s.label }}</p>
              </div>
              <div class="flex-1 h-3 rounded-full overflow-hidden" style="background-color: #fce7f3;">
                <div class="h-3 rounded-full transition-all duration-700"
                  :style="{ width: s.pct + '%', background: s.color }"></div>
              </div>
              <p class="text-xs font-semibold text-gray-600 w-8 text-right">{{ s.pct }}%</p>
            </div>
          </div>
        </div>

        <!-- Amélioration après protocole (2/5) -->
        <div class="col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
          <div class="flex items-center justify-between mb-6">
            <h3 class="font-semibold text-gray-800 text-sm">Amélioration après protocole</h3>
            <p class="text-xs text-gray-400">Moyenne à J+30 · auto-évaluation</p>
          </div>

          <div class="space-y-4 mb-6">
            <div v-for="s in improvements" :key="s.label" class="flex items-center gap-3">
              <div class="flex items-center gap-2 w-24 flex-shrink-0">
                <span class="text-sm">{{ s.icon }}</span>
                <p class="text-xs text-gray-600">{{ s.label }}</p>
              </div>
              <div class="flex-1 h-2.5 rounded-full overflow-hidden bg-gray-100">
                <div class="h-2.5 rounded-full transition-all duration-700"
                  :style="{ width: (s.pct / 100 * 100) + '%', 'background-color': '#10b981' }"></div>
              </div>
              <p class="text-xs font-semibold w-10 text-right" style="color: #10b981;">+{{ s.pct }}%</p>
            </div>
          </div>

          <!-- Global average card -->
          <div class="rounded-xl p-4" style="background: linear-gradient(135deg, #2E1545, #7c3aed);">
            <p class="text-xs uppercase tracking-widest font-semibold mb-2" style="color: rgba(255,255,255,0.55);">MOYENNE GLOBALE</p>
            <p class="text-3xl font-bold text-white">+55%</p>
            <p class="text-xs mt-1" style="color: rgba(255,255,255,0.65);">d'amélioration des symptômes à J+30</p>
          </div>
        </div>

      </div>

      <!-- Bottom: demographic profile -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-semibold text-gray-800 text-sm mb-5">Profil démographique des utilisatrices</h3>

        <div class="grid grid-cols-3 gap-10">

          <!-- Tranche d'âge -->
          <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Tranche d'âge</p>
            <div class="space-y-3">
              <div v-for="d in demographics.age" :key="d.label" class="flex items-center gap-3">
                <p class="text-xs text-gray-600 w-20 flex-shrink-0">{{ d.label }}</p>
                <div class="flex-1 h-2 rounded-full overflow-hidden" style="background-color: #fce7f3;">
                  <div class="h-2 rounded-full transition-all duration-700"
                    :style="{ width: d.pct + '%', background: 'linear-gradient(to right, #7c3aed, #db2777)' }"></div>
                </div>
                <p class="text-xs font-semibold text-gray-600 w-8 text-right">{{ d.pct }}%</p>
              </div>
            </div>
          </div>

          <!-- Source d'acquisition -->
          <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Source d'acquisition</p>
            <div class="space-y-3">
              <div v-for="d in demographics.source" :key="d.label" class="flex items-center gap-3">
                <p class="text-xs text-gray-600 w-28 flex-shrink-0">{{ d.label }}</p>
                <div class="flex-1 h-2 rounded-full overflow-hidden" style="background-color: #fce7f3;">
                  <div class="h-2 rounded-full transition-all duration-700"
                    :style="{ width: d.pct + '%', background: 'linear-gradient(to right, #7c3aed, #db2777)' }"></div>
                </div>
                <p class="text-xs font-semibold text-gray-600 w-8 text-right">{{ d.pct }}%</p>
              </div>
            </div>
          </div>

          <!-- Plateforme -->
          <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Plateforme</p>
            <div class="space-y-3">
              <div v-for="d in demographics.platform" :key="d.label" class="flex items-center gap-3">
                <p class="text-xs text-gray-600 w-20 flex-shrink-0">{{ d.label }}</p>
                <div class="flex-1 h-2 rounded-full overflow-hidden" style="background-color: #fce7f3;">
                  <div class="h-2 rounded-full transition-all duration-700"
                    :style="{ width: d.pct + '%', background: 'linear-gradient(to right, #7c3aed, #db2777)' }"></div>
                </div>
                <p class="text-xs font-semibold text-gray-600 w-8 text-right">{{ d.pct }}%</p>
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>

  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'

const props = defineProps({
  stats: Object,
})

const formatNum = (n) => Number(n).toLocaleString('fr-FR')

const declaredSymptoms = [
  { icon: '🌡', label: 'Bouffées de chaleur',    pct: 82, color: 'linear-gradient(to right, #7c3aed, #db2777)' },
  { icon: '🌙', label: 'Troubles du sommeil',    pct: 74, color: '#1e3a8a' },
  { icon: '😰', label: 'Anxiété & Angoisses',    pct: 68, color: '#7c3aed' },
  { icon: '⚖️', label: 'Prise de poids',         pct: 61, color: '#f59e0b' },
  { icon: '😤', label: 'Irritabilité',           pct: 55, color: '#f97316' },
  { icon: '🦴', label: 'Douleurs articulaires',  pct: 48, color: '#10b981' },
  { icon: '🌿', label: 'Perte de cheveux',       pct: 39, color: 'linear-gradient(to right, #f9a8d4, #db2777)' },
]

const improvements = [
  { icon: '🌡', label: 'Bouffées', pct: 72 },
  { icon: '🌙', label: 'Sommeil',  pct: 65 },
  { icon: '🌱', label: 'Sérénité', pct: 58 },
  { icon: '⚖️', label: 'Poids',    pct: 42 },
  { icon: '✓',  label: 'Douleurs', pct: 38 },
]

const demographics = {
  age: [
    { label: '45–49 ans', pct: 24 },
    { label: '50–54 ans', pct: 38 },
    { label: '55–59 ans', pct: 28 },
    { label: '60+ ans',   pct: 10 },
  ],
  source: [
    { label: 'Organique / SEO',   pct: 42 },
    { label: 'Réseaux sociaux',   pct: 31 },
    { label: 'Bouche à oreille',  pct: 18 },
    { label: 'Partenaires',       pct:  9 },
  ],
  platform: [
    { label: 'iOS',      pct: 58 },
    { label: 'Android',  pct: 28 },
    { label: 'Web / PWA', pct: 14 },
  ],
}
</script>
