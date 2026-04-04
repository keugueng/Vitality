<template>
  <AdminLayout>

    <!-- Top header -->
    <div class="flex items-center justify-between px-7 py-3.5 bg-white border-b border-gray-100 sticky top-0 z-10">
      <div>
        <h2 class="text-gray-800 font-semibold text-sm">Tarification</h2>
        <p class="text-gray-400 text-xs">FiftyCare Admin › Tarification</p>
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
            Gestion de la
            <em class="font-bold" style="font-family: 'Cormorant Garamond', Georgia, serif; font-style: italic; color: #db2777;">Tarification</em>
          </h1>
          <p class="text-gray-400 text-xs mt-1">Modifier les prix des abonnements · Freemium de 15 jours</p>
        </div>
        <div class="flex items-center gap-2">
          <button @click="cancel"
            class="px-4 py-2 rounded-xl text-xs font-semibold border border-gray-200 text-gray-600 bg-white hover:bg-gray-50 transition-colors">
            ✕ Annuler
          </button>
          <button @click="publish"
            class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold text-white transition-opacity hover:opacity-80"
            style="background-color: #2E1545;">
            <span>✏️</span> Publier les tarifs
          </button>
        </div>
      </div>

      <!-- Warning banner -->
      <div class="flex items-start gap-3 px-5 py-4 rounded-2xl mb-5"
        style="background: linear-gradient(135deg, #2E1545, #7c3aed);">
        <span class="text-amber-400 text-lg flex-shrink-0">⚠️</span>
        <div>
          <p class="text-white text-sm font-semibold">Attention — Modification des prix</p>
          <p class="text-xs mt-0.5" style="color: rgba(255,255,255,0.65);">
            Toute modification s'applique immédiatement aux nouveaux abonnements. Les abonnées existantes conservent leur tarif actuel.
          </p>
        </div>
      </div>

      <!-- Freemium section -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-5">
        <h3 class="font-semibold text-gray-800 text-sm flex items-center gap-2 mb-5">
          <span>📋</span> Période Freemium
        </h3>

        <!-- Two inputs -->
        <div class="grid grid-cols-2 gap-5 mb-5">
          <div>
            <label class="block text-xs text-gray-500 font-medium mb-1.5">Durée de l'essai gratuit (jours)</label>
            <input v-model="form.freemium_days" type="number"
              class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-purple-300 transition-colors" />
          </div>
          <div>
            <label class="block text-xs text-gray-500 font-medium mb-1.5">Protocoles accessibles en gratuit</label>
            <input v-model="form.freemium_protocols"
              class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-purple-300 transition-colors" />
          </div>
        </div>

        <!-- Toggles -->
        <div class="border-t border-gray-50 pt-4 space-y-4">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-700">Activer le freemium</p>
              <p class="text-xs text-gray-400">Les nouvelles inscriptions bénéficient de l'essai gratuit</p>
            </div>
            <button @click="form.freemium_active = !form.freemium_active"
              class="w-11 h-6 rounded-full transition-colors flex-shrink-0 relative"
              :style="form.freemium_active ? 'background-color: #10b981;' : 'background-color: #d1d5db;'">
              <span class="absolute top-0.5 w-5 h-5 bg-white rounded-full shadow transition-all"
                :style="form.freemium_active ? 'left: 1.375rem;' : 'left: 0.125rem;'"></span>
            </button>
          </div>
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-700">Demander la CB à l'inscription</p>
              <p class="text-xs text-gray-400">Si désactivé, la CB est demandée uniquement à la conversion</p>
            </div>
            <button @click="form.require_card = !form.require_card"
              class="w-11 h-6 rounded-full transition-colors flex-shrink-0 relative"
              :style="form.require_card ? 'background-color: #db2777;' : 'background-color: #d1d5db;'">
              <span class="absolute top-0.5 w-5 h-5 bg-white rounded-full shadow transition-all"
                :style="form.require_card ? 'left: 1.375rem;' : 'left: 0.125rem;'"></span>
            </button>
          </div>
        </div>
      </div>

      <!-- 3 plan cards -->
      <div class="grid grid-cols-3 gap-5">

        <!-- Plan 1 mois -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
          <div class="flex items-start justify-between mb-5">
            <div>
              <p class="font-bold text-gray-800 text-sm">Plan 1 Mois</p>
              <p class="text-xs text-gray-400 mt-0.5">Sans engagement</p>
            </div>
            <span class="px-2.5 py-1 rounded-lg text-xs font-semibold" style="background-color: #f3f4f6; color: #6b7280;">Basique</span>
          </div>

          <div class="space-y-4">
            <div>
              <label class="block text-xs text-gray-500 font-medium mb-1.5">Prix (€)</label>
              <input v-model="form.plan1_price"
                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-purple-300 transition-colors" />
            </div>
            <div>
              <label class="block text-xs text-gray-500 font-medium mb-1.5">Texte affiché</label>
              <input v-model="form.plan1_label"
                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-purple-300 transition-colors" />
            </div>
            <div>
              <label class="block text-xs text-gray-500 font-medium mb-1.5">Sous-titre</label>
              <input v-model="form.plan1_subtitle"
                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-purple-300 transition-colors" />
            </div>
            <div>
              <label class="block text-xs text-gray-500 font-medium mb-1.5">Tag économie</label>
              <input v-model="form.plan1_tag"
                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-purple-300 transition-colors" />
            </div>
            <div class="flex items-center justify-between pt-1">
              <p class="text-sm font-medium text-gray-700">Actif</p>
              <button @click="form.plan1_active = !form.plan1_active"
                class="w-11 h-6 rounded-full transition-colors relative"
                :style="form.plan1_active ? 'background-color: #10b981;' : 'background-color: #d1d5db;'">
                <span class="absolute top-0.5 w-5 h-5 bg-white rounded-full shadow transition-all"
                  :style="form.plan1_active ? 'left: 1.375rem;' : 'left: 0.125rem;'"></span>
              </button>
            </div>
          </div>
        </div>

        <!-- Plan 3 mois (featured) -->
        <div class="rounded-2xl shadow-sm border-2 p-6" style="border-color: #f9a8d4; background-color: #fff5f9;">
          <div class="flex items-start justify-between mb-1">
            <div>
              <p class="font-bold text-gray-800 text-sm">Plan 3 Mois ⭐</p>
              <p class="text-xs mt-0.5" style="color: #db2777;">Le plus populaire</p>
            </div>
            <span class="px-2.5 py-1 rounded-lg text-xs font-semibold" style="background-color: #fce7f3; color: #db2777;">Featured</span>
          </div>

          <div class="space-y-4 mt-5">
            <div>
              <label class="block text-xs text-gray-500 font-medium mb-1.5">Prix (€)</label>
              <input v-model="form.plan3_price"
                class="w-full border border-pink-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-pink-400 bg-white transition-colors" />
            </div>
            <div>
              <label class="block text-xs text-gray-500 font-medium mb-1.5">Prix mensuel affiché</label>
              <input v-model="form.plan3_monthly"
                class="w-full border border-pink-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-pink-400 bg-white transition-colors" />
            </div>
            <div>
              <label class="block text-xs text-gray-500 font-medium mb-1.5">Tag économie</label>
              <input v-model="form.plan3_tag"
                class="w-full border border-pink-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-pink-400 bg-white transition-colors" />
            </div>
            <div>
              <label class="block text-xs text-gray-500 font-medium mb-1.5">Sous-titre</label>
              <input v-model="form.plan3_subtitle"
                class="w-full border border-pink-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-pink-400 bg-white transition-colors" />
            </div>
            <div>
              <label class="block text-xs text-gray-500 font-medium mb-1.5">Badge "Populaire"</label>
              <input v-model="form.plan3_badge"
                class="w-full border border-pink-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-pink-400 bg-white transition-colors" />
            </div>
            <div class="flex items-center justify-between pt-1">
              <p class="text-sm font-medium text-gray-700">Affiché comme Featured</p>
              <button @click="form.plan3_featured = !form.plan3_featured"
                class="w-11 h-6 rounded-full transition-colors relative"
                :style="form.plan3_featured ? 'background-color: #10b981;' : 'background-color: #d1d5db;'">
                <span class="absolute top-0.5 w-5 h-5 bg-white rounded-full shadow transition-all"
                  :style="form.plan3_featured ? 'left: 1.375rem;' : 'left: 0.125rem;'"></span>
              </button>
            </div>
            <div class="flex items-center justify-between">
              <p class="text-sm font-medium text-gray-700">Actif</p>
              <button @click="form.plan3_active = !form.plan3_active"
                class="w-11 h-6 rounded-full transition-colors relative"
                :style="form.plan3_active ? 'background-color: #10b981;' : 'background-color: #d1d5db;'">
                <span class="absolute top-0.5 w-5 h-5 bg-white rounded-full shadow transition-all"
                  :style="form.plan3_active ? 'left: 1.375rem;' : 'left: 0.125rem;'"></span>
              </button>
            </div>
          </div>
        </div>

        <!-- Plan 6 mois -->
        <div class="rounded-2xl shadow-sm border border-amber-200 p-6" style="background-color: #fffbf0;">
          <div class="flex items-start justify-between mb-1">
            <div>
              <p class="font-bold text-gray-800 text-sm">Plan 6 Mois 💎</p>
              <p class="text-xs text-gray-400 mt-0.5">Cure profonde</p>
            </div>
            <span class="px-2.5 py-1 rounded-lg text-xs font-semibold" style="background-color: #fef3c7; color: #b45309;">Premium+</span>
          </div>

          <div class="space-y-4 mt-5">
            <div>
              <label class="block text-xs text-gray-500 font-medium mb-1.5">Prix (€)</label>
              <input v-model="form.plan6_price"
                class="w-full border border-amber-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-amber-400 bg-white transition-colors" />
            </div>
            <div>
              <label class="block text-xs text-gray-500 font-medium mb-1.5">Prix mensuel affiché</label>
              <input v-model="form.plan6_monthly"
                class="w-full border border-amber-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-amber-400 bg-white transition-colors" />
            </div>
            <div>
              <label class="block text-xs text-gray-500 font-medium mb-1.5">Tag économie</label>
              <input v-model="form.plan6_tag"
                class="w-full border border-amber-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-amber-400 bg-white transition-colors" />
            </div>
            <div>
              <label class="block text-xs text-gray-500 font-medium mb-1.5">Avantage exclusif</label>
              <input v-model="form.plan6_bonus"
                class="w-full border border-amber-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-amber-400 bg-white transition-colors" />
            </div>
            <div>
              <label class="block text-xs text-gray-500 font-medium mb-1.5">Sous-titre</label>
              <input v-model="form.plan6_subtitle"
                class="w-full border border-amber-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-amber-400 bg-white transition-colors" />
            </div>
            <div class="flex items-center justify-between pt-1">
              <p class="text-sm font-medium text-gray-700">Actif</p>
              <button @click="form.plan6_active = !form.plan6_active"
                class="w-11 h-6 rounded-full transition-colors relative"
                :style="form.plan6_active ? 'background-color: #10b981;' : 'background-color: #d1d5db;'">
                <span class="absolute top-0.5 w-5 h-5 bg-white rounded-full shadow transition-all"
                  :style="form.plan6_active ? 'left: 1.375rem;' : 'left: 0.125rem;'"></span>
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
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  settings: Object,
})

const s = props.settings ?? {}

const form = reactive({
  freemium_days:      s.freemium_days      ?? '15',
  freemium_protocols: s.freemium_protocols ?? '1 (Priorité 1 uniquement)',
  freemium_active:    (s.freemium_active   ?? '1') === '1',
  require_card:       (s.require_card      ?? '0') === '1',

  plan1_price:    s.plan1_price    ?? '14.90',
  plan1_label:    s.plan1_label    ?? '14,90€ / mois',
  plan1_subtitle: s.plan1_subtitle ?? 'Sans engagement · 0,50€/jour',
  plan1_tag:      s.plan1_tag      ?? 'Flexibilité maximale',
  plan1_active:   (s.plan1_active  ?? '1') === '1',

  plan3_price:    s.plan3_price    ?? '37.90',
  plan3_monthly:  s.plan3_monthly  ?? 'soit 12,63€ / mois',
  plan3_tag:      s.plan3_tag      ?? 'Économie -15%',
  plan3_subtitle: s.plan3_subtitle ?? '1 cure complète · 0,42€/jour',
  plan3_badge:    s.plan3_badge    ?? '⭐ Le plus populaire',
  plan3_featured: (s.plan3_featured ?? '1') === '1',
  plan3_active:   (s.plan3_active  ?? '1') === '1',

  plan6_price:    s.plan6_price    ?? '67.90',
  plan6_monthly:  s.plan6_monthly  ?? 'soit 11,32€ / mois',
  plan6_tag:      s.plan6_tag      ?? 'Économie -24%',
  plan6_bonus:    s.plan6_bonus    ?? 'Protocole alimentaire PDF offert',
  plan6_subtitle: s.plan6_subtitle ?? 'Cure profonde · 0,37€/jour',
  plan6_active:   (s.plan6_active  ?? '1') === '1',
})

const toPayload = () => {
  const out = {}
  Object.entries(form).forEach(([k, v]) => {
    out[k] = typeof v === 'boolean' ? (v ? '1' : '0') : v
  })
  return out
}

const publish = () => {
  router.post(route('admin.settings.update'), { settings: toPayload() }, { preserveState: true })
}

const cancel = () => {
  const s2 = props.settings ?? {}
  Object.assign(form, {
    freemium_days:      s2.freemium_days      ?? '15',
    freemium_protocols: s2.freemium_protocols ?? '1 (Priorité 1 uniquement)',
    freemium_active:    (s2.freemium_active   ?? '1') === '1',
    require_card:       (s2.require_card      ?? '0') === '1',
    plan1_price:    s2.plan1_price    ?? '14.90',
    plan1_label:    s2.plan1_label    ?? '14,90€ / mois',
    plan1_subtitle: s2.plan1_subtitle ?? 'Sans engagement · 0,50€/jour',
    plan1_tag:      s2.plan1_tag      ?? 'Flexibilité maximale',
    plan1_active:   (s2.plan1_active  ?? '1') === '1',
    plan3_price:    s2.plan3_price    ?? '37.90',
    plan3_monthly:  s2.plan3_monthly  ?? 'soit 12,63€ / mois',
    plan3_tag:      s2.plan3_tag      ?? 'Économie -15%',
    plan3_subtitle: s2.plan3_subtitle ?? '1 cure complète · 0,42€/jour',
    plan3_badge:    s2.plan3_badge    ?? '⭐ Le plus populaire',
    plan3_featured: (s2.plan3_featured ?? '1') === '1',
    plan3_active:   (s2.plan3_active  ?? '1') === '1',
    plan6_price:    s2.plan6_price    ?? '67.90',
    plan6_monthly:  s2.plan6_monthly  ?? 'soit 11,32€ / mois',
    plan6_tag:      s2.plan6_tag      ?? 'Économie -24%',
    plan6_bonus:    s2.plan6_bonus    ?? 'Protocole alimentaire PDF offert',
    plan6_subtitle: s2.plan6_subtitle ?? 'Cure profonde · 0,37€/jour',
    plan6_active:   (s2.plan6_active  ?? '1') === '1',
  })
}
</script>
