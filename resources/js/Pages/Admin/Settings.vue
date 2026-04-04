<template>
  <AdminLayout>

    <!-- Top header -->
    <div class="flex items-center justify-between px-7 py-3.5 bg-white border-b border-gray-100 sticky top-0 z-10">
      <div>
        <h2 class="text-gray-800 font-semibold text-sm">Paramètres</h2>
        <p class="text-gray-400 text-xs">FiftyCare Admin › Paramètres</p>
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

      <!-- Title + save -->
      <div class="flex items-start justify-between mb-5">
        <div>
          <h1 class="text-2xl font-bold text-gray-800">
            Paramètres de
            <em class="font-bold" style="font-family: 'Cormorant Garamond', Georgia, serif; font-style: italic; color: #db2777;">l'Application</em>
          </h1>
          <p class="text-gray-400 text-xs mt-1">Configuration générale · Fonctionnalités · Intégrations</p>
        </div>
        <button @click="save"
          class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-80"
          style="background-color: #2E1545;">
          <span>💾</span> Sauvegarder
        </button>
      </div>

      <div class="grid grid-cols-3 gap-5">

        <!-- Left 2/3 -->
        <div class="col-span-2 space-y-5">

          <!-- Général -->
          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-semibold text-gray-800 text-sm flex items-center gap-2 mb-5">
              <span>⚙️</span> Général
            </h3>
            <div class="space-y-4">
              <div>
                <label class="block text-xs text-gray-500 font-medium mb-1.5">Nom de l'application</label>
                <input v-model="form.app_name"
                  class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-purple-300 transition-colors" />
              </div>
              <div>
                <label class="block text-xs text-gray-500 font-medium mb-1.5">Email support</label>
                <input v-model="form.support_email" type="email"
                  class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-purple-300 transition-colors" />
              </div>
              <div>
                <label class="block text-xs text-gray-500 font-medium mb-1.5">Version app</label>
                <input v-model="form.app_version"
                  class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-purple-300 transition-colors" />
              </div>
              <div>
                <label class="block text-xs text-gray-500 font-medium mb-1.5">URL de l'app</label>
                <input v-model="form.app_url"
                  class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-purple-300 transition-colors" />
              </div>
              <div>
                <label class="block text-xs text-gray-500 font-medium mb-1.5">Langue par défaut</label>
                <select v-model="form.app_locale"
                  class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-purple-300 bg-white transition-colors">
                  <option value="fr">🇫🇷 Français</option>
                  <option value="en">🇬🇧 English</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Notifications -->
          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-semibold text-gray-800 text-sm flex items-center gap-2 mb-5">
              <span>🔔</span> Notifications
            </h3>
            <div class="space-y-5">
              <div v-for="row in notifRows" :key="row.key" class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-gray-700">{{ row.label }}</p>
                  <p class="text-xs text-gray-400 mt-0.5">{{ row.sub }}</p>
                </div>
                <button type="button" @click="form[row.key] = !form[row.key]"
                  class="w-11 h-6 rounded-full transition-colors flex-shrink-0 relative"
                  :style="form[row.key] ? 'background-color: #10b981;' : 'background-color: #d1d5db;'">
                  <span class="absolute top-0.5 w-5 h-5 bg-white rounded-full shadow transition-all"
                    :style="form[row.key] ? 'left: 1.375rem;' : 'left: 0.125rem;'"></span>
                </button>
              </div>
            </div>
          </div>

        </div>

        <!-- Right 1/3 -->
        <div class="space-y-5">

          <!-- Intégrations -->
          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-semibold text-gray-800 text-sm flex items-center gap-2 mb-5">
              <span>🔗</span> Intégrations
            </h3>
            <div class="space-y-5">
              <div v-for="row in integrations" :key="row.key" class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-gray-700">{{ row.label }}</p>
                  <p class="text-xs text-gray-400 mt-0.5">{{ row.sub }}</p>
                </div>
                <button type="button" @click="form[row.key] = !form[row.key]"
                  class="w-11 h-6 rounded-full transition-colors flex-shrink-0 relative"
                  :style="form[row.key] ? 'background-color: #10b981;' : 'background-color: #d1d5db;'">
                  <span class="absolute top-0.5 w-5 h-5 bg-white rounded-full shadow transition-all"
                    :style="form[row.key] ? 'left: 1.375rem;' : 'left: 0.125rem;'"></span>
                </button>
              </div>
            </div>
          </div>

          <!-- Sécurité & RGPD -->
          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-semibold text-gray-800 text-sm flex items-center gap-2 mb-5">
              <span>🔒</span> Sécurité &amp; RGPD
            </h3>
            <div class="space-y-5">
              <div v-for="row in security" :key="row.key" class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-gray-700">{{ row.label }}</p>
                  <p class="text-xs text-gray-400 mt-0.5">{{ row.sub }}</p>
                </div>
                <button type="button" @click="form[row.key] = !form[row.key]"
                  class="w-11 h-6 rounded-full transition-colors flex-shrink-0 relative"
                  :style="form[row.key] ? 'background-color: #10b981;' : 'background-color: #d1d5db;'">
                  <span class="absolute top-0.5 w-5 h-5 bg-white rounded-full shadow transition-all"
                    :style="form[row.key] ? 'left: 1.375rem;' : 'left: 0.125rem;'"></span>
                </button>
              </div>
            </div>
            <div class="mt-5 pt-5 border-t border-gray-50">
              <label class="block text-xs text-gray-500 font-medium mb-1.5">DPO Email</label>
              <input v-model="form.dpo_email" type="email"
                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-purple-300 transition-colors" />
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

const props = defineProps({ settings: Object })

const s = props.settings ?? {}
const bool = (key, def = '1') => (s[key] ?? def) === '1'

const form = reactive({
  app_name:             s.app_name             ?? 'FiftyCare',
  support_email:        s.support_email        ?? 'support@fiftycare.fr',
  app_version:          s.app_version          ?? '2.0.1',
  app_url:              s.app_url              ?? 'https://app.fiftycare.fr',
  app_locale:           s.app_locale           ?? 'fr',
  push_enabled:         bool('push_enabled'),
  transactional_emails: bool('transactional_emails'),
  session_reminders:    bool('session_reminders'),
  freemium_emails:      bool('freemium_emails'),
  stripe_live:          bool('stripe_live'),
  revenuecat_enabled:   bool('revenuecat_enabled'),
  supabase_enabled:     bool('supabase_enabled'),
  mixpanel_enabled:     bool('mixpanel_enabled'),
  cloudfront_enabled:   bool('cloudfront_enabled'),
  aes256_enabled:       bool('aes256_enabled'),
  hds_enabled:          bool('hds_enabled'),
  consent_banner:       bool('consent_banner'),
  dpo_email:            s.dpo_email ?? 'dpo@fiftycare.fr',
})

const notifRows = [
  { key: 'push_enabled',         label: 'Notifications push activées', sub: 'Via OneSignal' },
  { key: 'transactional_emails', label: 'Emails transactionnels',       sub: 'Bienvenue, relance, confirmation' },
  { key: 'session_reminders',    label: 'Rappels de séance',            sub: 'Push 30 min avant la séance planifiée' },
  { key: 'freemium_emails',      label: 'Emails de relance freemium',   sub: 'Automatique à J-1 de fin d\'essai' },
]

const integrations = [
  { key: 'stripe_live',         label: 'Stripe (paiements)',          sub: 'Mode production actif' },
  { key: 'revenuecat_enabled',  label: 'RevenueCat (In-App)',          sub: 'iOS & Android' },
  { key: 'supabase_enabled',    label: 'Supabase (base de données)',   sub: 'EU Frankfurt · RGPD' },
  { key: 'mixpanel_enabled',    label: 'Mixpanel (analytics)',         sub: 'Tracking événements utilisateur' },
  { key: 'cloudfront_enabled',  label: 'Cloudfront CDN (audio)',       sub: 'Streaming HLS · 99,9% uptime' },
]

const security = [
  { key: 'aes256_enabled', label: 'Chiffrement AES-256',           sub: 'Données de santé au repos' },
  { key: 'hds_enabled',    label: 'HDS (Hébergeur Données Santé)', sub: 'Certification OVHcloud France' },
  { key: 'consent_banner', label: 'Bannière de consentement',      sub: 'RGPD · Cookies non essentiels' },
]

const save = () => {
  const payload = {}
  Object.entries(form).forEach(([k, v]) => {
    payload[k] = typeof v === 'boolean' ? (v ? '1' : '0') : v
  })
  router.post(route('admin.settings.update'), { settings: payload }, { preserveState: true })
}
</script>
