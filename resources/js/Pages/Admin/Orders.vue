<template>
  <AdminLayout>

    <!-- Top header -->
    <div class="flex items-center justify-between px-7 py-3.5 bg-white border-b border-gray-100 sticky top-0 z-10">
      <div>
        <h2 class="text-gray-800 font-semibold text-sm">Revenus</h2>
        <p class="text-gray-400 text-xs">FiftyCare Admin › Revenus</p>
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
            Revenus &amp;
            <em class="font-bold" style="font-family: 'Cormorant Garamond', Georgia, serif; font-style: italic; color: #db2777;">Finance</em>
          </h1>
          <p class="text-gray-400 text-xs mt-1">Suivi MRR, ARR et répartition par plan</p>
        </div>
        <button class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold text-white transition-opacity hover:opacity-80"
          style="background-color: #2E1545;">
          <span>📊</span> Export comptable
        </button>
      </div>

      <!-- 6 stat cards -->
      <div class="grid grid-cols-6 gap-4 mb-5">

        <!-- MRR -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
          <div class="flex items-start justify-between mb-2">
            <p class="text-gray-500 text-xs font-medium leading-tight">MRR (ce mois)</p>
            <span class="text-base">💰</span>
          </div>
          <p class="text-2xl font-bold text-gray-800 mb-1">{{ fmt(stats.mrr) }}€</p>
          <p class="text-xs flex items-center gap-1" style="color: #10b981;">
            <span>↑</span> +18% vs mars 2025
          </p>
        </div>

        <!-- ARR -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
          <div class="flex items-start justify-between mb-2">
            <p class="text-gray-500 text-xs font-medium leading-tight">ARR (annualisé)</p>
            <span class="text-base">📋</span>
          </div>
          <p class="text-2xl font-bold text-gray-800 mb-1">{{ fmt(stats.arr) }}€</p>
          <p class="text-xs flex items-center gap-1" style="color: #10b981;">
            <span>↑</span> Objectif 150K dépassé
          </p>
        </div>

        <!-- Revenu 3 mois -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
          <div class="flex items-start justify-between mb-2">
            <p class="text-gray-500 text-xs font-medium leading-tight">Revenu plan 3 mois</p>
            <span class="text-base">⭐</span>
          </div>
          <p class="text-2xl font-bold text-gray-800 mb-1">{{ fmt(stats.rev3) }}€</p>
          <p class="text-xs text-gray-400">= 56% du MRR total</p>
        </div>

        <!-- Revenu 1 mois -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
          <div class="flex items-start justify-between mb-2">
            <p class="text-gray-500 text-xs font-medium leading-tight">Revenu plan 1 mois</p>
            <span class="text-base">📋</span>
          </div>
          <p class="text-2xl font-bold text-gray-800 mb-1">{{ fmt(stats.rev1) }}€</p>
          <p class="text-xs text-gray-400">= 35,7% du MRR</p>
        </div>

        <!-- Revenu 6 mois -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
          <div class="flex items-start justify-between mb-2">
            <p class="text-gray-500 text-xs font-medium leading-tight">Revenu plan 6 mois</p>
            <span class="text-base">💎</span>
          </div>
          <p class="text-2xl font-bold text-gray-800 mb-1">{{ fmt(stats.rev6) }}€</p>
          <p class="text-xs text-gray-400">= 8,3% du MRR</p>
        </div>

        <!-- Churn -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
          <div class="flex items-start justify-between mb-2">
            <p class="text-gray-500 text-xs font-medium leading-tight">Churn mensuel</p>
            <span class="text-base">🔄</span>
          </div>
          <p class="text-2xl font-bold text-gray-800 mb-1">4,2%</p>
          <p class="text-xs flex items-center gap-1" style="color: #10b981;">
            <span>↑</span> Objectif &lt; 5% atteint
          </p>
        </div>

      </div>

      <!-- MRR Evolution chart -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-semibold text-gray-800 text-sm mb-6">Évolution MRR — 12 mois</h3>

        <!-- Bar chart (CSS only) -->
        <div class="flex items-end gap-3 h-52 px-2">
          <div
            v-for="(m, i) in mrrChart"
            :key="m.label"
            class="flex-1 flex flex-col items-center gap-2"
          >
            <div
              class="w-full rounded-t-lg transition-all duration-700"
              :style="{
                height: barHeight(m.value) + 'px',
                background: 'linear-gradient(to top, #2E1545, #db2777)',
                opacity: i === mrrChart.length - 1 ? '1' : (0.55 + (i / mrrChart.length) * 0.45).toFixed(2),
              }"
            ></div>
            <p class="text-xs text-gray-400">{{ m.label }}</p>
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
  stats: Object,
})

const fmt = (n) => Number(n).toLocaleString('fr-FR')

const mrrChart = [
  { label: 'Avr',  value: 6200  },
  { label: 'Mai',  value: 7100  },
  { label: 'Juin', value: 7800  },
  { label: 'Juil', value: 8400  },
  { label: 'Août', value: 9100  },
  { label: 'Sep',  value: 9600  },
  { label: 'Oct',  value: 10200 },
  { label: 'Nov',  value: 10700 },
  { label: 'Déc',  value: 11100 },
  { label: 'Jan',  value: 11600 },
  { label: 'Fév',  value: 12300 },
  { label: 'Mars', value: 13040 },
]

const maxVal = computed(() => Math.max(...mrrChart.map(m => m.value)))
const barHeight = (v) => Math.round((v / maxVal.value) * 168) // 168px = max bar height (container 52 * 4 - labels)
</script>
