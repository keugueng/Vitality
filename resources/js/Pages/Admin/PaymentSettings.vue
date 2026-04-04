<template>
  <AdminLayout>

    <!-- Top header -->
    <div class="flex items-center justify-between px-7 py-3.5 bg-white border-b border-gray-100 sticky top-0 z-10">
      <div>
        <h2 class="text-gray-800 font-semibold text-sm">Modes de Paiement</h2>
        <p class="text-gray-400 text-xs">Admin › Finance › Configuration Paiements</p>
      </div>
      <div class="flex items-center gap-2">
        <button @click="save"
          class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-80"
          style="background-color: #2E1545;">
          <span>💾</span> Sauvegarder
        </button>
      </div>
    </div>

    <div class="px-7 py-5">

      <!-- Title -->
      <div class="flex items-start justify-between mb-5">
        <div>
          <h1 class="text-2xl font-bold text-gray-800">
            Configuration des
            <em class="font-bold" style="font-family: 'Cormorant Garamond', Georgia, serif; font-style: italic; color: #db2777;">Paiements</em>
          </h1>
          <p class="text-gray-400 text-xs mt-1">Stripe · PayPal · Modes de paiement acceptés</p>
        </div>
      </div>

      <div class="grid grid-cols-2 gap-5">

        <!-- ═══ STRIPE ═══ -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
          <div class="flex items-center justify-between mb-5">
            <h3 class="font-semibold text-gray-800 text-sm flex items-center gap-2">
              <span>💳</span> Stripe
            </h3>
            <button type="button" @click="form.stripe_enabled = !form.stripe_enabled"
              class="w-11 h-6 rounded-full transition-colors flex-shrink-0 relative"
              :style="form.stripe_enabled ? 'background-color: #10b981;' : 'background-color: #d1d5db;'">
              <span class="absolute top-0.5 w-5 h-5 bg-white rounded-full shadow transition-all"
                :style="form.stripe_enabled ? 'left: 1.375rem;' : 'left: 0.125rem;'"></span>
            </button>
          </div>

          <div class="space-y-4">
            <div>
              <label class="block text-xs text-gray-500 font-medium mb-1.5">Mode</label>
              <select v-model="form.stripe_mode"
                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-purple-300 bg-white transition-colors">
                <option value="test">Test (Sandbox)</option>
                <option value="live">Production (Live)</option>
              </select>
            </div>
            <div>
              <label class="block text-xs text-gray-500 font-medium mb-1.5">Email du compte Stripe</label>
              <input v-model="form.stripe_account_email"
                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-purple-300 transition-colors"
                placeholder="email@example.com" />
            </div>
            <div>
              <label class="block text-xs text-gray-500 font-medium mb-1.5">Account ID</label>
              <input v-model="form.stripe_account_id"
                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-purple-300 transition-colors font-mono text-xs"
                placeholder="acct_xxxxxxxxxxxx" />
            </div>

            <!-- Live keys -->
            <div class="pt-3 border-t border-gray-100">
              <p class="text-xs font-semibold text-gray-600 mb-3 flex items-center gap-1">
                <span class="w-2 h-2 rounded-full bg-green-400 inline-block"></span> Clés Production
              </p>
              <div class="space-y-3">
                <div>
                  <label class="block text-xs text-gray-500 font-medium mb-1.5">Publishable Key (Live)</label>
                  <input v-model="form.stripe_pk_live"
                    class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-purple-300 transition-colors font-mono text-xs"
                    placeholder="pk_live_..." />
                </div>
                <div>
                  <label class="block text-xs text-gray-500 font-medium mb-1.5">Secret Key (Live)</label>
                  <input v-model="form.stripe_sk_live" type="password"
                    class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-purple-300 transition-colors font-mono text-xs"
                    placeholder="sk_live_..." />
                </div>
              </div>
            </div>

            <!-- Test keys -->
            <div class="pt-3 border-t border-gray-100">
              <p class="text-xs font-semibold text-gray-600 mb-3 flex items-center gap-1">
                <span class="w-2 h-2 rounded-full bg-yellow-400 inline-block"></span> Clés Test
              </p>
              <div class="space-y-3">
                <div>
                  <label class="block text-xs text-gray-500 font-medium mb-1.5">Publishable Key (Test)</label>
                  <input v-model="form.stripe_pk_test"
                    class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-purple-300 transition-colors font-mono text-xs"
                    placeholder="pk_test_..." />
                </div>
                <div>
                  <label class="block text-xs text-gray-500 font-medium mb-1.5">Secret Key (Test)</label>
                  <input v-model="form.stripe_sk_test" type="password"
                    class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-purple-300 transition-colors font-mono text-xs"
                    placeholder="sk_test_..." />
                </div>
              </div>
            </div>

            <div>
              <label class="block text-xs text-gray-500 font-medium mb-1.5">Webhook Secret</label>
              <input v-model="form.stripe_webhook_secret" type="password"
                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-purple-300 transition-colors font-mono text-xs"
                placeholder="whsec_..." />
            </div>
          </div>

          <!-- Info box -->
          <div class="mt-5 p-3 bg-blue-50 border border-blue-100 rounded-xl">
            <p class="text-xs text-blue-600 font-medium mb-1">Configuration actuelle</p>
            <p class="text-xs text-blue-500">
              Email: <strong>{{ form.stripe_account_email || '—' }}</strong><br>
              Account ID: <strong class="font-mono">{{ form.stripe_account_id || '—' }}</strong><br>
              Mode: <strong>{{ form.stripe_mode === 'live' ? 'Production' : 'Test' }}</strong>
            </p>
          </div>
        </div>

        <!-- ═══ PAYPAL ═══ -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
          <div class="flex items-center justify-between mb-5">
            <h3 class="font-semibold text-gray-800 text-sm flex items-center gap-2">
              <span>🅿️</span> PayPal
            </h3>
            <button type="button" @click="form.paypal_enabled = !form.paypal_enabled"
              class="w-11 h-6 rounded-full transition-colors flex-shrink-0 relative"
              :style="form.paypal_enabled ? 'background-color: #10b981;' : 'background-color: #d1d5db;'">
              <span class="absolute top-0.5 w-5 h-5 bg-white rounded-full shadow transition-all"
                :style="form.paypal_enabled ? 'left: 1.375rem;' : 'left: 0.125rem;'"></span>
            </button>
          </div>

          <div class="space-y-4">
            <div>
              <label class="block text-xs text-gray-500 font-medium mb-1.5">Mode</label>
              <select v-model="form.paypal_mode"
                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-purple-300 bg-white transition-colors">
                <option value="sandbox">Sandbox (Test)</option>
                <option value="live">Production (Live)</option>
              </select>
            </div>
            <div>
              <label class="block text-xs text-gray-500 font-medium mb-1.5">Merchant ID</label>
              <input v-model="form.paypal_merchant_id"
                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-purple-300 transition-colors font-mono text-xs"
                placeholder="HMPY7JPJC4XNW" />
            </div>
            <div>
              <label class="block text-xs text-gray-500 font-medium mb-1.5">Email PayPal</label>
              <input v-model="form.paypal_email" type="email"
                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-purple-300 transition-colors"
                placeholder="contact@example.com" />
            </div>

            <!-- Live keys -->
            <div class="pt-3 border-t border-gray-100">
              <p class="text-xs font-semibold text-gray-600 mb-3 flex items-center gap-1">
                <span class="w-2 h-2 rounded-full bg-green-400 inline-block"></span> Clés Production
              </p>
              <div class="space-y-3">
                <div>
                  <label class="block text-xs text-gray-500 font-medium mb-1.5">Client ID (Live)</label>
                  <input v-model="form.paypal_client_id"
                    class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-purple-300 transition-colors font-mono text-xs"
                    placeholder="BAAoz71_ARDYjnnOQUQrj..." />
                </div>
                <div>
                  <label class="block text-xs text-gray-500 font-medium mb-1.5">Client Secret (Live)</label>
                  <input v-model="form.paypal_client_secret" type="password"
                    class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-purple-300 transition-colors font-mono text-xs"
                    placeholder="Secret..." />
                </div>
              </div>
            </div>

            <!-- Sandbox keys -->
            <div class="pt-3 border-t border-gray-100">
              <p class="text-xs font-semibold text-gray-600 mb-3 flex items-center gap-1">
                <span class="w-2 h-2 rounded-full bg-yellow-400 inline-block"></span> Clés Sandbox
              </p>
              <div class="space-y-3">
                <div>
                  <label class="block text-xs text-gray-500 font-medium mb-1.5">Client ID (Sandbox)</label>
                  <input v-model="form.paypal_client_id_sandbox"
                    class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-purple-300 transition-colors font-mono text-xs"
                    placeholder="Sandbox Client ID..." />
                </div>
                <div>
                  <label class="block text-xs text-gray-500 font-medium mb-1.5">Client Secret (Sandbox)</label>
                  <input v-model="form.paypal_client_secret_sandbox" type="password"
                    class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-purple-300 transition-colors font-mono text-xs"
                    placeholder="Sandbox Secret..." />
                </div>
              </div>
            </div>
          </div>

          <!-- Info box -->
          <div class="mt-5 p-3 bg-yellow-50 border border-yellow-100 rounded-xl">
            <p class="text-xs text-yellow-700 font-medium mb-1">Configuration actuelle</p>
            <p class="text-xs text-yellow-600">
              Merchant ID: <strong class="font-mono">{{ form.paypal_merchant_id || '—' }}</strong><br>
              Email: <strong>{{ form.paypal_email || '—' }}</strong><br>
              Mode: <strong>{{ form.paypal_mode === 'live' ? 'Production' : 'Sandbox' }}</strong>
            </p>
          </div>
        </div>

      </div>

      <!-- Bottom info -->
      <div class="mt-5 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-semibold text-gray-800 text-sm flex items-center gap-2 mb-4">
          <span>🔒</span> Sécurité des Paiements
        </h3>
        <div class="grid grid-cols-3 gap-4">
          <div class="p-3 bg-gray-50 rounded-xl">
            <p class="text-xs font-semibold text-gray-700 mb-1">PCI-DSS Compliant</p>
            <p class="text-xs text-gray-400">Les données de carte ne transitent jamais par nos serveurs</p>
          </div>
          <div class="p-3 bg-gray-50 rounded-xl">
            <p class="text-xs font-semibold text-gray-700 mb-1">SSL / TLS</p>
            <p class="text-xs text-gray-400">Toutes les communications sont chiffrées en transit</p>
          </div>
          <div class="p-3 bg-gray-50 rounded-xl">
            <p class="text-xs font-semibold text-gray-700 mb-1">Conformité RGPD</p>
            <p class="text-xs text-gray-400">Données stockées en Europe, supprimées sur demande</p>
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
const bool = (key, def = '0') => (s[key] ?? def) === '1'

const form = reactive({
  stripe_enabled:          bool('stripe_enabled', '1'),
  stripe_mode:             s.stripe_mode             ?? 'live',
  stripe_account_email:    s.stripe_account_email    ?? 'rosati.eric@gmail.com',
  stripe_account_id:       s.stripe_account_id       ?? 'acct_1GP7bDCXXSFREYqg',
  stripe_pk_live:          s.stripe_pk_live           ?? '',
  stripe_sk_live:          s.stripe_sk_live           ?? '',
  stripe_pk_test:          s.stripe_pk_test           ?? '',
  stripe_sk_test:          s.stripe_sk_test           ?? '',
  stripe_webhook_secret:   s.stripe_webhook_secret    ?? '',
  paypal_enabled:          bool('paypal_enabled', '1'),
  paypal_mode:             s.paypal_mode              ?? 'live',
  paypal_merchant_id:      s.paypal_merchant_id       ?? 'HMPY7JPJC4XNW',
  paypal_email:            s.paypal_email             ?? 'contact.insidevitality@gmail.com',
  paypal_client_id:        s.paypal_client_id         ?? 'BAAoz71_ARDYjnnOQUQrj4E56AfQbLFXU9FfuR415TsDVxqiUQdggNwIdvGyyP9Q1jPzafhmspaCKzjD_U',
  paypal_client_secret:    s.paypal_client_secret     ?? '',
  paypal_client_id_sandbox:     s.paypal_client_id_sandbox     ?? '',
  paypal_client_secret_sandbox: s.paypal_client_secret_sandbox ?? '',
})

const save = () => {
  const payload = {}
  Object.entries(form).forEach(([k, v]) => {
    payload[k] = typeof v === 'boolean' ? (v ? '1' : '0') : v
  })
  router.post(route('admin.payment-settings.update'), { settings: payload }, { preserveState: true })
}
</script>
