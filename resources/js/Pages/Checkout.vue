<template>
  <AppLayout>
    <section class="pt-28 pb-24 px-4">
      <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
          <div class="inline-flex items-center gap-2 glass-card border-glow rounded-full px-4 py-2 mb-5 text-xs font-medium text-vitality-cyan tracking-widest uppercase">
            <span class="w-1.5 h-1.5 rounded-full bg-vitality-cyan animate-pulse"></span>
            {{ t('checkout.badge') }}
          </div>
          <h1 class="section-title text-white">{{ t('checkout.title') }} <em class="text-gradient-cyan not-italic">{{ t('checkout.title_em') }}</em></h1>
        </div>

        <!-- Progress bar -->
        <div class="flex items-center justify-center gap-3 mb-12">
          <div class="flex items-center gap-2">
            <div class="w-6 h-6 rounded-full bg-vitality-cyan flex items-center justify-center text-vitality-bg text-xs font-bold">1</div>
            <span class="text-vitality-cyan text-xs font-medium">{{ t('checkout.step_info') }}</span>
          </div>
          <div class="w-16 h-px bg-white/10"></div>
          <div class="flex items-center gap-2">
            <div class="w-6 h-6 rounded-full bg-white/10 flex items-center justify-center text-vitality-text text-xs">2</div>
            <span class="text-vitality-text text-xs">{{ t('checkout.step_payment') }}</span>
          </div>
          <div class="w-16 h-px bg-white/10"></div>
          <div class="flex items-center gap-2">
            <div class="w-6 h-6 rounded-full bg-white/10 flex items-center justify-center text-vitality-text text-xs">✓</div>
            <span class="text-vitality-text text-xs">{{ t('checkout.step_confirm') }}</span>
          </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
          <!-- Form (3/5) -->
          <div class="lg:col-span-3 space-y-5">
            <form @submit.prevent="submit">
              <!-- User info -->
              <div class="glass-card rounded-2xl p-6 space-y-4 mb-5">
                <h2 class="text-white font-semibold text-sm flex items-center gap-2">
                  <span class="w-5 h-5 rounded-full bg-vitality-cyan/20 flex items-center justify-center text-vitality-cyan text-xs">1</span>
                  {{ t('checkout.your_info') }}
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <div>
                    <label class="text-vitality-text text-xs mb-1.5 block">{{ t('checkout.full_name') }}</label>
                    <input v-model="form.name" type="text" required
                      class="w-full bg-[#071F3D] border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-vitality-cyan/50 placeholder-vitality-text/40"
                      :placeholder="t('checkout.name_placeholder')" />
                    <p v-if="form.errors.name" class="text-red-400 text-xs mt-1">{{ form.errors.name }}</p>
                  </div>
                  <div>
                    <label class="text-vitality-text text-xs mb-1.5 block">{{ t('checkout.email') }}</label>
                    <input v-model="form.email" type="email" required
                      class="w-full bg-[#071F3D] border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-vitality-cyan/50 placeholder-vitality-text/40"
                      :placeholder="t('checkout.email_placeholder')" />
                    <p v-if="form.errors.email" class="text-red-400 text-xs mt-1">{{ form.errors.email }}</p>
                  </div>
                </div>
                <div>
                  <label class="text-vitality-text text-xs mb-1.5 block">{{ t('checkout.phone') }}</label>
                  <input v-model="form.phone" type="tel"
                    class="w-full bg-[#071F3D] border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-vitality-cyan/50 placeholder-vitality-text/40"
                    :placeholder="t('checkout.phone_placeholder')" />
                </div>
              </div>

              <!-- Symptoms block — shown only when a consultation is in the cart -->
              <div v-if="hasConsultation" class="glass-card rounded-2xl p-6 space-y-4 mb-5 border border-vitality-cyan/20">
                <h2 class="text-white font-semibold text-sm flex items-center gap-2">
                  <span class="w-5 h-5 rounded-full bg-vitality-cyan/20 flex items-center justify-center text-vitality-cyan text-xs">🩺</span>
                  {{ t('checkout.symptoms_title') }}
                </h2>
                <div>
                  <label class="text-vitality-text text-xs mb-1.5 block">{{ t('checkout.symptoms_label') }}</label>
                  <textarea v-model="form.symptoms" rows="4" required
                    class="w-full bg-[#071F3D] border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-vitality-cyan/50 placeholder-vitality-text/40 resize-none"
                    :placeholder="t('checkout.symptoms_placeholder')"></textarea>
                  <p v-if="form.errors.symptoms" class="text-red-400 text-xs mt-1">{{ form.errors.symptoms }}</p>
                </div>
                <div>
                  <label class="text-vitality-text text-xs mb-1.5 block">{{ t('checkout.medical_history_label') }}</label>
                  <textarea v-model="form.medical_history" rows="2"
                    class="w-full bg-[#071F3D] border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-vitality-cyan/50 placeholder-vitality-text/40 resize-none"
                    :placeholder="t('checkout.medical_history_placeholder')"></textarea>
                </div>
              </div>

              <!-- Payment method -->
              <div class="glass-card rounded-2xl p-6 space-y-4 mb-5">
                <h2 class="text-white font-semibold text-sm flex items-center gap-2">
                  <span class="w-5 h-5 rounded-full bg-vitality-cyan/20 flex items-center justify-center text-vitality-cyan text-xs">2</span>
                  {{ t('checkout.payment_method') }}
                </h2>

                <!-- No payment methods warning -->
                <div v-if="!paymentConfig?.stripe_enabled && !paymentConfig?.paypal_enabled"
                  class="p-4 rounded-xl bg-yellow-500/10 border border-yellow-500/30 text-yellow-400 text-sm">
                  ⚠️ {{ t('checkout.no_payment') }}
                </div>

                <!-- Payment options -->
                <div class="space-y-3">
                  <label v-if="paymentConfig?.stripe_enabled"
                    class="flex items-center gap-3 p-4 rounded-xl border cursor-pointer transition-all"
                    :class="form.payment_method === 'stripe' ? 'border-vitality-cyan/50 bg-vitality-cyan/5' : 'border-white/10 hover:border-white/20'">
                    <input type="radio" v-model="form.payment_method" value="stripe" class="hidden" />
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-sm"
                      style="background: rgba(99,91,255,0.2); color: #635BFF;">S</div>
                    <div class="flex-1">
                      <p class="text-white text-sm font-medium">Stripe — Carte bancaire</p>
                      <p class="text-vitality-text text-xs">Visa, Mastercard, American Express</p>
                    </div>
                    <div v-if="form.payment_method === 'stripe'" class="w-4 h-4 rounded-full border-2 border-vitality-cyan flex items-center justify-center">
                      <div class="w-2 h-2 rounded-full bg-vitality-cyan"></div>
                    </div>
                  </label>

                  <label v-if="paymentConfig?.paypal_enabled"
                    class="flex items-center gap-3 p-4 rounded-xl border cursor-pointer transition-all"
                    :class="form.payment_method === 'paypal' ? 'border-vitality-cyan/50 bg-vitality-cyan/5' : 'border-white/10 hover:border-white/20'">
                    <input type="radio" v-model="form.payment_method" value="paypal" class="hidden" />
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-xs"
                      style="background: rgba(0,112,240,0.2); color: #0070F0;">PP</div>
                    <div class="flex-1">
                      <p class="text-white text-sm font-medium">PayPal</p>
                      <p class="text-vitality-text text-xs">Paiement via votre compte PayPal · {{ paymentConfig?.paypal_email }}</p>
                    </div>
                    <div v-if="form.payment_method === 'paypal'" class="w-4 h-4 rounded-full border-2 border-vitality-cyan flex items-center justify-center">
                      <div class="w-2 h-2 rounded-full bg-vitality-cyan"></div>
                    </div>
                  </label>
                </div>

                <!-- PayPal redirect notice -->
                <div v-if="form.payment_method === 'paypal' && paymentConfig?.paypal_enabled"
                  class="p-3 rounded-xl bg-blue-500/10 border border-blue-500/20 text-blue-300 text-xs flex items-center gap-2">
                  ℹ️ {{ t('checkout.paypal_notice') }}
                </div>

                <!-- Stripe Card Element (injected by Stripe.js) -->
                <div v-if="form.payment_method === 'stripe'" class="space-y-3 pt-2">
                  <div>
                    <label class="text-vitality-text text-xs mb-1.5 block">{{ t('checkout.card_number') }}</label>
                    <div id="stripe-card-element" class="w-full bg-[#071F3D] border border-white/10 rounded-xl px-4 py-3 text-white text-sm min-h-[46px]"></div>
                  </div>
                  <p v-if="stripeError" class="text-red-400 text-xs">{{ stripeError }}</p>
                </div>

              <!-- PayPal Button (injected by PayPal SDK) -->
                <div v-if="form.payment_method === 'paypal'" class="pt-2">
                  <div id="paypal-button-container" class="min-h-[48px]"></div>
                  <p v-if="paypalError" class="text-red-400 text-xs mt-2">{{ paypalError }}</p>
                </div>

                <p class="text-vitality-text/50 text-xs flex items-center gap-2">
                  <span>🔒</span> {{ t('checkout.ssl_note') }}
                </p>
              </div>

              <!-- Payment error -->
              <p v-if="form.errors.payment" class="text-red-400 text-xs -mt-2 mb-2">{{ form.errors.payment }}</p>

              <!-- Submit (Stripe only — PayPal uses its own button) -->
              <button v-if="form.payment_method !== 'paypal'" type="submit" :disabled="form.processing || stripeLoading"
                class="btn-cyan w-full text-base py-4 disabled:opacity-50 relative overflow-hidden">
                <span v-if="!form.processing && !stripeLoading" class="flex items-center justify-center gap-2">
                  🔒 {{ t('checkout.pay_btn') }} €{{ total }}
                </span>
                <span v-else class="flex items-center justify-center gap-2">
                  <svg class="animate-spin w-4 h-4" viewBox="0 0 24 24" fill="none">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                  </svg>
                  {{ stripeLoading ? 'Chargement Stripe…' : t('checkout.processing') }}
                </span>
              </button>
            </form>
          </div>

          <!-- Order summary (2/5) -->
          <div class="lg:col-span-2">
            <div class="glass-card rounded-2xl p-6 sticky top-24">
              <h2 class="text-white font-semibold text-sm mb-5 flex items-center gap-2">
                <span>📦</span> {{ t('checkout.order_summary') }}
              </h2>

              <!-- Items -->
              <div class="space-y-4 mb-5">
                <div v-for="(item, idx) in items" :key="idx"
                  class="flex items-start gap-3 pb-4 border-b border-white/5 last:border-0 last:pb-0">
                  <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl flex-shrink-0"
                    style="background: rgba(17,199,201,0.1);">
                    {{ item.type === 'consultation' ? '🩺' : (item.type === 'subscription' ? '🔄' : (item.program?.emoji || '✨')) }}
                  </div>
                  <div class="flex-1 min-w-0">
                    <p class="text-white text-sm font-medium leading-snug">
                      <template v-if="item.type === 'consultation'">{{ item.consult.name }}</template>
                      <template v-else-if="item.type === 'subscription'">{{ item.sub.name }}</template>
                      <template v-else>{{ item.program.title }}</template>
                    </p>
                    <p class="text-vitality-text text-xs mt-0.5">
                      <template v-if="item.type === 'consultation'">{{ item.consult.sessions }} {{ item.consult.sessions > 1 ? t('cart.sessions') : t('cart.session') }}</template>
                      <template v-else-if="item.type === 'subscription'">{{ t('cart.unlimited_access') }} · {{ item.sub.period === 'month' ? t('cart.monthly') : t('cart.annual') }}</template>
                      <template v-else>{{ item.program.session_duration }} · {{ item.program.cure_duration }}</template>
                    </p>
                  </div>
                  <span class="text-vitality-gold text-sm font-bold flex-shrink-0">
                    €{{ item.type === 'consultation' ? item.consult.price : (item.type === 'subscription' ? item.sub.price : item.program.price) }}
                  </span>
                </div>
              </div>

              <!-- Total -->
              <div class="border-t border-white/10 pt-4 space-y-2 mb-5">
                <div class="flex items-center justify-between text-sm">
                  <span class="text-vitality-text">{{ t('checkout.subtotal') }}</span>
                  <span class="text-white">€{{ total }}</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                  <span class="text-vitality-text">{{ t('checkout.free_delivery') }}</span>
                  <span class="text-vitality-cyan font-medium">✓</span>
                </div>
                <div class="flex items-center justify-between font-bold text-base pt-2 border-t border-white/10">
                  <span class="text-white">{{ t('checkout.total_due') }}</span>
                  <span class="text-vitality-gold text-xl">€{{ total }}</span>
                </div>
              </div>

              <!-- Guarantees -->
              <div class="space-y-2 text-xs text-vitality-text/70">
                <div class="flex items-center gap-2"><span class="text-vitality-cyan">✓</span> {{ t('checkout.delivery_instant') }}</div>
                <div class="flex items-center gap-2"><span class="text-vitality-cyan">✓</span> {{ t('checkout.lifetime_access') }}</div>
                <div class="flex items-center gap-2"><span class="text-vitality-cyan">✓</span> {{ t('checkout.guarantee') }}</div>
                <div class="flex items-center gap-2"><span class="text-vitality-cyan">✓</span> {{ t('checkout.support') }}</div>
              </div>

              <!-- Trust badges -->
              <div class="mt-5 pt-4 border-t border-white/5 flex items-center justify-center gap-4 text-vitality-text/40 text-xs">
                <span>🔒 SSL</span>
                <span>💳 Stripe</span>
                <span>🛡 RGPD</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm, usePage, router } from '@inertiajs/vue3'
import { computed, ref, watch, onMounted, nextTick } from 'vue'
import { useI18n } from '@/composables/useI18n'

const props = defineProps({
  items: Array,
  total: [Number, String],
  paymentConfig: { type: Object, default: () => ({ stripe_enabled: true, paypal_enabled: false }) },
})
const { t } = useI18n()
const page = usePage()
const user = computed(() => page.props.auth?.user)
const hasConsultation = computed(() => props.items?.some(i => i.type === 'consultation'))

const defaultMethod = computed(() => {
  if (props.paymentConfig?.stripe_enabled) return 'stripe'
  if (props.paymentConfig?.paypal_enabled) return 'paypal'
  return 'stripe'
})

const form = useForm({
  name: user.value?.name || '',
  email: user.value?.email || '',
  phone: '',
  payment_method: defaultMethod.value,
  symptoms: '',
  medical_history: '',
  payment_intent_id: '',
  paypal_order_id: '',
})

// ── Stripe ──────────────────────────────────────────────────────────────
const stripeInstance = ref(null)
const stripeCardEl   = ref(null)
const stripeError    = ref('')
const stripeLoading  = ref(false)

function getCsrf() {
  return document.querySelector('meta[name="csrf-token"]')?.content || ''
}

async function loadScript(src) {
  return new Promise((resolve, reject) => {
    if (document.querySelector(`script[src="${src}"]`)) { resolve(); return }
    const s = document.createElement('script')
    s.src = src; s.onload = resolve; s.onerror = reject
    document.head.appendChild(s)
  })
}

async function initStripe() {
  if (!props.paymentConfig?.stripe_enabled) return
  stripeLoading.value = true
  try {
    await loadScript('https://js.stripe.com/v3/')
    const res = await fetch('/payment/stripe/public-key')
    const { public_key } = await res.json()
    if (!public_key) { stripeLoading.value = false; return }
    stripeInstance.value = window.Stripe(public_key)
    await nextTick()
    mountStripeCard()
  } catch (e) {
    stripeError.value = 'Stripe indisponible. Veuillez réessayer.'
  } finally {
    stripeLoading.value = false
  }
}

function mountStripeCard() {
  if (!stripeInstance.value) return
  const el = document.getElementById('stripe-card-element')
  if (!el || stripeCardEl.value) return
  const elements = stripeInstance.value.elements()
  stripeCardEl.value = elements.create('card', {
    style: {
      base: { color: '#ffffff', fontSize: '14px', fontFamily: 'inherit', '::placeholder': { color: 'rgba(200,220,255,0.4)' } },
      invalid: { color: '#f87171' },
    },
  })
  stripeCardEl.value.mount('#stripe-card-element')
}

// ── PayPal ───────────────────────────────────────────────────────────────
const paypalError = ref('')
let paypalButtonsRendered = false

async function initPaypal() {
  if (!props.paymentConfig?.paypal_enabled) return
  const clientId = props.paymentConfig?.paypal_client_id
  if (!clientId) { paypalError.value = 'PayPal non configuré (clé manquante).'; return }
  try {
    await loadScript(`https://www.paypal.com/sdk/js?client-id=${clientId}&currency=EUR`)
    await nextTick()
    renderPaypalButtons()
  } catch (e) {
    paypalError.value = 'PayPal indisponible. Veuillez réessayer.'
  }
}

function renderPaypalButtons() {
  if (!window.paypal || paypalButtonsRendered) return
  const container = document.getElementById('paypal-button-container')
  if (!container) return
  paypalButtonsRendered = true
  window.paypal.Buttons({
    style: { layout: 'vertical', color: 'blue', shape: 'rect', label: 'pay' },
    createOrder: async () => {
      paypalError.value = ''
      const res = await fetch('/payment/paypal/create-order', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': getCsrf(), 'Content-Type': 'application/json', Accept: 'application/json' },
      })
      const data = await res.json()
      if (!res.ok) { paypalError.value = data.error || 'Erreur PayPal'; throw new Error(data.error) }
      return data.order_id
    },
    onApprove: async (data) => {
      const res = await fetch('/payment/paypal/capture-order', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': getCsrf(), 'Content-Type': 'application/json', Accept: 'application/json' },
        body: JSON.stringify({ order_id: data.orderID }),
      })
      const result = await res.json()
      if (!res.ok) { paypalError.value = result.error || 'Capture PayPal échouée'; return }
      form.paypal_order_id = data.orderID
      form.payment_method  = 'paypal'
      form.post(route('checkout.process'))
    },
    onError: (err) => { paypalError.value = 'Erreur PayPal: ' + (err.message || err) },
  }).render('#paypal-button-container')
}

// ── Watch payment method changes ─────────────────────────────────────────
watch(() => form.payment_method, async (method) => {
  if (method === 'stripe' && !stripeInstance.value) {
    await initStripe()
  } else if (method === 'stripe' && stripeInstance.value) {
    await nextTick()
    mountStripeCard()
  } else if (method === 'paypal') {
    paypalButtonsRendered = false
    await nextTick()
    await initPaypal()
  }
})

onMounted(async () => {
  if (form.payment_method === 'stripe') await initStripe()
  else if (form.payment_method === 'paypal') await initPaypal()
})

// ── Submit ────────────────────────────────────────────────────────────────
const submit = async () => {
  stripeError.value = ''
  if (form.payment_method === 'stripe') {
    if (!stripeInstance.value || !stripeCardEl.value) {
      stripeError.value = 'Stripe non initialisé. Rechargez la page.'
      return
    }
    form.processing = true
    // Create PaymentIntent
    const intentRes = await fetch('/payment/stripe/intent', {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': getCsrf(), 'Content-Type': 'application/json', Accept: 'application/json' },
    })
    const intentData = await intentRes.json()
    if (!intentRes.ok) { stripeError.value = intentData.error || 'Erreur Stripe'; form.processing = false; return }

    const { error, paymentIntent } = await stripeInstance.value.confirmCardPayment(
      intentData.client_secret,
      { payment_method: { card: stripeCardEl.value } }
    )
    if (error) { stripeError.value = error.message; form.processing = false; return }
    form.payment_intent_id = paymentIntent.id
    form.post(route('checkout.process'))
  }
  // PayPal is handled by PayPal button callback above
}
</script>
