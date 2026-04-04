<template>
  <AdminLayout>

    <!-- Top header -->
    <div class="flex items-center justify-between px-7 py-3.5 bg-white border-b border-gray-100 sticky top-0 z-10">
      <div>
        <h2 class="text-gray-800 font-semibold text-sm">Dashboard</h2>
        <p class="text-gray-400 text-xs">FiftyCare Admin › Vue d'ensemble</p>
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
            Tableau de bord
            <em class="font-bold" style="font-family: 'Cormorant Garamond', Georgia, serif; font-style: italic; color: #db2777;">FiftyCare</em>
          </h1>
          <p class="text-gray-400 text-xs mt-1">Dernière mise à jour : aujourd'hui à 9:41 · {{ currentDate }}</p>
        </div>
        <div class="flex items-center gap-2 mt-0.5">
          <button class="flex items-center gap-1.5 px-3.5 py-2 rounded-xl border border-gray-200 bg-white text-gray-700 text-xs font-medium hover:bg-gray-50 transition-colors">
            ⬇️ Exporter
          </button>
          <button class="flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-white text-xs font-medium hover:opacity-90 transition-opacity"
            style="background-color: #1f2937;">
            + Nouvelle utilisatrice
          </button>
        </div>
      </div>

      <!-- 6 stat cards in one row -->
      <div class="grid grid-cols-6 gap-3 mb-5">

        <StatCard
          label="Utilisatrices totales"
          :value="formatNum(stats?.users ?? 8247)"
          trend="+342 ce mois"
          icon="👥"
        />
        <StatCard
          label="Abonnées Premium"
          :value="formatNum(stats?.premium ?? 1043)"
          trend="+89 ce mois · 12,7%"
          icon="💎"
        />
        <StatCard
          label="MRR (revenus mensuel)"
          :value="formatNum(stats?.revenue ?? 13040) + '€'"
          trend="+18% vs mois dernier"
          icon="💰"
        />
        <StatCard
          label="Séances complétées"
          :value="formatNum(stats?.sessions ?? 42180)"
          trend="+6 240 cette semaine"
          icon="▶️"
        />
        <StatCard
          label="Taux de rétention D30"
          value="47%"
          trend="+3% vs objectif"
          icon="🔄"
        />
        <StatCard
          label="Essai → Premium"
          value="12,7%"
          trend="Objectif 8% dépassé"
          icon="📊"
        />

      </div>

      <!-- Charts row -->
      <div class="grid gap-4 mb-4" style="grid-template-columns: 1fr 340px;">

        <!-- Revenue bar chart -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
          <div class="flex items-center justify-between mb-4">
            <div>
              <h3 class="font-semibold text-gray-800 text-sm">Évolution des revenus</h3>
              <p class="text-gray-400 text-xs mt-0.5">12 derniers mois · MRR</p>
            </div>
            <a href="#" class="text-xs font-medium hover:opacity-80 transition-opacity" style="color: #db2777;">Voir détails →</a>
          </div>
          <!-- Bars -->
          <div class="flex items-end gap-2" style="height: 160px;">
            <div v-for="(bar, i) in chartData" :key="i" class="flex-1 flex flex-col items-center gap-1">
              <div class="w-full rounded-t-lg transition-all"
                :style="{
                  height: (bar.h / 100 * 140) + 'px',
                  background: 'linear-gradient(to top, #7c3aed, #db2777)',
                  opacity: bar.h < 60 ? '0.55' : '1'
                }">
              </div>
              <span class="text-gray-400" style="font-size: 10px;">{{ bar.m }}</span>
            </div>
          </div>
          <!-- Legend -->
          <div class="flex items-center gap-4 mt-3">
            <div class="flex items-center gap-1.5">
              <div class="w-2.5 h-2.5 rounded-full" style="background-color: #db2777;"></div>
              <span class="text-xs text-gray-500">MRR</span>
            </div>
            <div class="flex items-center gap-1.5">
              <div class="w-2.5 h-2.5 rounded-full border-2" style="border-color: #db2777;"></div>
              <span class="text-xs text-gray-500">Essais</span>
            </div>
          </div>
        </div>

        <!-- Popular protocols -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
          <div class="flex items-start justify-between mb-4">
            <h3 class="font-semibold text-gray-800 text-sm">Protocoles populaires</h3>
            <p class="text-gray-400 text-xs text-right leading-snug">Séances lancées<br>ce mois</p>
          </div>
          <div class="space-y-3">
            <div v-for="proto in popularProtocols" :key="proto.name" class="flex items-center gap-2">
              <span class="text-sm flex-shrink-0">{{ proto.emoji }}</span>
              <span class="text-xs text-gray-700 w-28 flex-shrink-0 truncate">{{ proto.name }}</span>
              <div class="flex-1 rounded-full h-2" style="background-color: #fce7f3;">
                <div class="h-2 rounded-full" :style="{ width: proto.pct + '%', backgroundColor: proto.color }"></div>
              </div>
              <span class="text-xs text-gray-500 w-8 text-right flex-shrink-0">{{ proto.pct }}%</span>
            </div>
          </div>
        </div>

      </div>

      <!-- Bottom row -->
      <div class="grid gap-4" style="grid-template-columns: 1fr 340px;">

        <!-- New users table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
          <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800 text-sm">Nouvelles utilisatrices</h3>
            <span class="text-gray-400 text-xs">Inscriptions récentes</span>
            <a href="#" class="text-xs font-medium hover:opacity-80" style="color: #db2777;">Voir tout →</a>
          </div>
          <table class="w-full">
            <thead>
              <tr style="background-color: #fdf2f4;">
                <th class="text-left px-5 py-2.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Utilisatrice</th>
                <th class="text-left px-3 py-2.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Plan</th>
                <th class="text-left px-3 py-2.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Inscription</th>
                <th class="text-left px-3 py-2.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Statut</th>
                <th class="px-3 py-2.5"></th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
              <tr v-for="u in newUsers" :key="u.name" class="hover:bg-gray-50/50 transition-colors">
                <td class="px-5 py-3">
                  <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0"
                      :style="{ backgroundColor: u.color }">
                      {{ u.initial }}
                    </div>
                    <div>
                      <p class="text-sm font-medium text-gray-800">{{ u.name }}</p>
                      <p class="text-xs text-gray-400">{{ u.email }}</p>
                    </div>
                  </div>
                </td>
                <td class="px-3 py-3">
                  <span class="px-2 py-0.5 rounded-full text-xs font-medium"
                    :style="{ backgroundColor: u.planBg, color: u.planColor }">
                    {{ u.plan }}
                  </span>
                </td>
                <td class="px-3 py-3 text-xs text-gray-600">{{ u.date }}</td>
                <td class="px-3 py-3">
                  <span class="px-2 py-0.5 rounded-full text-xs font-medium"
                    :style="{ backgroundColor: u.statusBg, color: u.statusColor }">
                    {{ u.status }}
                  </span>
                </td>
                <td class="px-3 py-3">
                  <button class="w-7 h-7 rounded-lg flex items-center justify-center hover:bg-gray-100 transition-colors" style="color: #9ca3af;">
                    👁
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Alerts & Notifications -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
          <h3 class="font-semibold text-gray-800 text-sm mb-4">Alertes &amp; Notifications</h3>
          <div class="space-y-3">

            <!-- Alert 1 - danger -->
            <div class="rounded-xl p-3.5" style="background-color: #fff1f2; border: 1px solid #fecdd3;">
              <p class="text-xs font-semibold mb-0.5" style="color: #be123c;">⚠ 47 essais expirent dans 48h</p>
              <p class="text-xs mb-3" style="color: #9f1239;">Campagne email de relance recommandée.</p>
              <button class="px-3 py-1.5 rounded-lg text-white text-xs font-semibold hover:opacity-90 transition-opacity"
                style="background-color: #e11d48;">
                Envoyer relance
              </button>
            </div>

            <!-- Alert 2 - success -->
            <div class="rounded-xl p-3.5" style="background-color: #f0fdf4; border: 1px solid #bbf7d0;">
              <p class="text-xs font-semibold mb-0.5" style="color: #15803d;">✓ Objectif MRR atteint</p>
              <p class="text-xs" style="color: #166534;">13 040€ / objectif 12 000€ · +8,7%</p>
            </div>

            <!-- Alert 3 - info -->
            <div class="rounded-xl p-3.5" style="background-color: #fffbeb; border: 1px solid #fed7aa;">
              <p class="text-xs font-semibold mb-0.5" style="color: #92400e;">📊 Nouveau rapport hebdo dispo</p>
              <p class="text-xs mb-3" style="color: #78350f;">Semaine du 17–23 mars 2026</p>
              <button class="px-3 py-1.5 rounded-lg text-white text-xs font-semibold hover:opacity-90 transition-opacity"
                style="background-color: #d97706;">
                Voir le rapport
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
import { defineComponent, h } from 'vue'

const props = defineProps({ stats: Object, recentOrders: Array })

const formatNum = (n) => Number(n).toLocaleString('fr-FR')

const currentDate = new Intl.DateTimeFormat('fr-FR', {
  weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'
}).format(new Date())

const chartData = [
  { m: 'A', h: 28 }, { m: 'M', h: 36 }, { m: 'J', h: 42 }, { m: 'J', h: 48 },
  { m: 'A', h: 54 }, { m: 'S', h: 60 }, { m: 'O', h: 65 }, { m: 'N', h: 70 },
  { m: 'D', h: 75 }, { m: 'J', h: 80 }, { m: 'F', h: 85 }, { m: 'M', h: 95 },
]

const popularProtocols = [
  { name: 'Bouffées de chaleur', pct: 82, color: '#be123c', emoji: '🌡' },
  { name: 'Sérénité',            pct: 64, color: '#7c3aed', emoji: '🌿' },
  { name: 'Sommeil',             pct: 58, color: '#2563eb', emoji: '🌙' },
  { name: 'Perte de poids',      pct: 41, color: '#f59e0b', emoji: '⚖️' },
  { name: 'Douleurs artic.',     pct: 33, color: '#16a34a', emoji: '✨' },
  { name: 'Angoisse',            pct: 28, color: '#ea580c', emoji: '🧘' },
]

const newUsers = [
  { name: 'Marie Dupont',   email: 'marie@gmail.com',   initial: 'M', color: '#7c3aed', plan: '3 mois',  planBg: '#fef3c7', planColor: '#92400e', date: '24 mars', status: '✓ Active',   statusBg: '#f0fdf4', statusColor: '#15803d' },
  { name: 'Sophie Martin',  email: 'sophie@gmail.com',  initial: 'S', color: '#db2777', plan: 'Essai 15j', planBg: '#fdf2f8', planColor: '#9d174d', date: '24 mars', status: '✓ Active',   statusBg: '#f0fdf4', statusColor: '#15803d' },
  { name: 'Claire Bernard', email: 'claire@free.fr',    initial: 'C', color: '#2563eb', plan: '6 mois',  planBg: '#ede9fe', planColor: '#5b21b6', date: '23 mars', status: '✓ Active',   statusBg: '#f0fdf4', statusColor: '#15803d' },
  { name: 'Anne Leroy',     email: 'anne@orange.fr',    initial: 'A', color: '#f59e0b', plan: '1 mois',  planBg: '#fdf2f8', planColor: '#9d174d', date: '22 mars', status: '⚠ Paiement', statusBg: '#fffbeb', statusColor: '#92400e' },
  { name: 'Nathalie Petit', email: 'nath@sfr.fr',       initial: 'N', color: '#16a34a', plan: 'Essai 15j', planBg: '#fdf2f8', planColor: '#9d174d', date: '22 mars', status: '↻ Essai',    statusBg: '#eff6ff', statusColor: '#1d4ed8' },
]

// Inline stat card component
const StatCard = defineComponent({
  props: { label: String, value: String, trend: String, icon: String },
  setup(props) {
    return () => h('div', {
      class: 'bg-white rounded-2xl p-4 shadow-sm border border-gray-100',
    }, [
      h('div', { class: 'flex items-start justify-between mb-2' }, [
        h('p', { class: 'text-gray-500 text-xs font-medium leading-tight', style: 'max-width: 80%;' }, props.label),
        h('span', { class: 'text-lg opacity-60 flex-shrink-0' }, props.icon),
      ]),
      h('p', { class: 'text-2xl font-bold text-gray-800 mb-1.5' }, props.value),
      h('p', {
        class: 'text-xs flex items-center gap-1',
        style: 'color: #10b981;',
      }, ['↑ ' + props.trend]),
    ])
  },
})
</script>
