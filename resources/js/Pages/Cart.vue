<template>
  <AppLayout>
    <section class="cart-section">
      <div class="cart-inner">
        <h1 class="cart-title">{{ t('cart.title') }} <em>{{ t('cart.title_em') }}</em></h1>

        <!-- Empty state -->
        <div v-if="items.length === 0" class="cart-empty">
          <div class="cart-empty-icon">🛒</div>
          <p class="cart-empty-text">{{ t('cart.empty') }}</p>
          <Link :href="route('shop')" class="cart-btn-primary">{{ t('cart.explore') }}</Link>
        </div>

        <div v-else class="cart-layout">
          <!-- LEFT: items + payment -->
          <div class="cart-left">

            <!-- Items list -->
            <div class="cart-list">
              <div v-for="item in items" :key="item.key" class="cart-item">
                <div class="cart-item-icon">
                  <template v-if="item.type === 'consultation'">🩺</template>
                  <template v-else-if="item.type === 'subscription'">🔄</template>
                  <template v-else>{{ item.program?.emoji || '✨' }}</template>
                </div>
                <div class="cart-item-info">
                  <h3 class="cart-item-title">
                    <template v-if="item.type === 'consultation'">{{ item.consult.name }}</template>
                    <template v-else-if="item.type === 'subscription'">{{ item.sub.name }}</template>
                    <template v-else>{{ item.program?.title }}</template>
                  </h3>
                  <p class="cart-item-sub">
                    <template v-if="item.type === 'consultation'">
                      {{ item.consult.sessions }} {{ item.consult.sessions > 1 ? t('cart.sessions') : t('cart.session') }} · {{ t('cart.protocol_8h') }}
                    </template>
                    <template v-else-if="item.type === 'subscription'">
                      {{ t('cart.unlimited_access') }} · {{ item.sub.period === 'month' ? t('cart.monthly') : t('cart.annual') }}
                    </template>
                    <template v-else>
                      {{ item.program?.session_duration ? item.program.session_duration + ' ' + t('cart.min_per_session') : '' }}
                      {{ item.program?.cure_duration ? '· ' + item.program.cure_duration + ' ' + t('cart.days_cure') : '' }}
                    </template>
                  </p>
                </div>
                <div class="cart-item-right">
                  <span class="cart-item-price">
                    €{{ item.type === 'consultation' ? item.consult.price : (item.type === 'subscription' ? item.sub.price : item.program?.price) }}
                  </span>
                  <Link :href="route('cart.remove')" method="post" as="button"
                    :data="{ cart_key: item.key }" class="cart-remove">✕</Link>
                </div>
              </div>
            </div>

            <!-- Contact info -->
            <div class="pay-box">
              <h3 class="pay-box-title">{{ t('checkout.your_info') }}</h3>
              <div class="info-row">
                <div class="info-field">
                  <label>{{ t('checkout.full_name') }}</label>
                  <input v-model="form.name" type="text" required :placeholder="t('checkout.name_placeholder')" />
                  <p v-if="form.errors.name" class="field-err">{{ form.errors.name }}</p>
                </div>
                <div class="info-field">
                  <label>{{ t('checkout.email') }}</label>
                  <input v-model="form.email" type="email" required :placeholder="t('checkout.email_placeholder')" />
                  <p v-if="form.errors.email" class="field-err">{{ form.errors.email }}</p>
                </div>
              </div>
              <!-- Symptoms for consultations -->
              <div v-if="hasConsultation" class="info-field" style="margin-top:12px">
                <label>{{ t('checkout.symptoms_label') }}</label>
                <textarea v-model="form.symptoms" rows="3" required :placeholder="t('checkout.symptoms_placeholder')"></textarea>
                <p v-if="form.errors.symptoms" class="field-err">{{ form.errors.symptoms }}</p>
              </div>
            </div>

            <!-- Payment method -->
            <div class="pay-box">
              <h3 class="pay-box-title">{{ t('checkout.payment_method') }}</h3>
              <div class="pay-options">
                <label v-if="paymentConfig?.stripe_enabled"
                  class="pay-option" :class="{ active: form.payment_method === 'stripe' }">
                  <input type="radio" v-model="form.payment_method" value="stripe" class="hidden" />
                  <div class="pay-icon pay-s">S</div>
                  <div><p>Stripe — Carte bancaire</p><span>Visa, Mastercard, Amex</span></div>
                  <div class="pay-check" :class="{ active: form.payment_method === 'stripe' }"></div>
                </label>
                <label v-if="paymentConfig?.paypal_enabled"
                  class="pay-option" :class="{ active: form.payment_method === 'paypal' }">
                  <input type="radio" v-model="form.payment_method" value="paypal" class="hidden" />
                  <div class="pay-icon pay-pp">PP</div>
                  <div><p>PayPal</p><span>Paiement sécurisé PayPal</span></div>
                  <div class="pay-check" :class="{ active: form.payment_method === 'paypal' }"></div>
                </label>
                <p v-if="!paymentConfig?.stripe_enabled && !paymentConfig?.paypal_enabled" class="pay-warn">
                  ⚠️ {{ t('checkout.no_payment') }}
                </p>
              </div>

              <!-- Stripe card element (v-show keeps DOM alive for mounting) -->
              <div v-show="form.payment_method === 'stripe'" class="card-fields">
                <label class="card-label">{{ t('checkout.card_number') }}</label>
                <div id="cart-stripe-card-element" class="card-input" style="min-height:44px;padding-top:12px"></div>
                <p v-if="stripeNotConfigured" class="card-error">⚠️ Stripe non configuré. Ajoutez vos clés dans l'admin.</p>
                <p v-if="stripeError" class="card-error">{{ stripeError }}</p>
                <p class="card-secure">🔒 {{ t('checkout.ssl_note') }}</p>
              </div>

              <!-- PayPal buttons (v-show keeps DOM alive) -->
              <div v-show="form.payment_method === 'paypal'" class="card-fields">
                <div id="cart-paypal-button-container" style="min-height:48px"></div>
                <p v-if="paypalError" class="card-error">{{ paypalError }}</p>
              </div>
            </div>

            <!-- Submit (only for Stripe) -->
            <button v-if="form.payment_method !== 'paypal'"
              class="cart-btn-primary" @click="submitPayment"
              :disabled="isSubmitting || stripeLoading || stripeNotConfigured">
              <span v-if="isSubmitting || stripeLoading">
                ⌛ {{ stripeLoading ? 'Chargement Stripe…' : t('checkout.processing') }}
              </span>
              <span v-else>🔒 {{ t('checkout.pay_btn') }} — €{{ total }}</span>
            </button>
            <p v-if="form.errors.payment" class="card-error" style="text-align:center;margin-top:8px">{{ form.errors.payment }}</p>

            <Link :href="route('shop')" class="cart-btn-outline" style="margin-top:8px">{{ t('cart.continue') }}</Link>
          </div>

          <!-- RIGHT: order summary -->
          <div class="cart-summary">
            <h3 class="summary-title">{{ t('checkout.order_summary') }}</h3>
            <div v-for="item in items" :key="'s-' + item.key" class="sum-row">
              <span>{{ item.type === 'consultation' ? item.consult.name : (item.type === 'subscription' ? item.sub.name : item.program?.title) }}</span>
              <span>€{{ item.type === 'consultation' ? item.consult.price : (item.type === 'subscription' ? item.sub.price : item.program?.price) }}</span>
            </div>
            <div class="sum-divider"></div>
            <div class="sum-row sum-total">
              <span>{{ t('checkout.total_due') }}</span>
              <span class="sum-total-val">€{{ total }}</span>
            </div>
            <div class="sum-perks">
              <div>✓ {{ t('checkout.delivery_instant') }}</div>
              <div>✓ {{ t('checkout.guarantee') }}</div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </AppLayout>
</template>

<script setup>
import { ref, computed, watch, onMounted, nextTick } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, useForm, usePage } from '@inertiajs/vue3'
import { useI18n } from '@/composables/useI18n'

const props = defineProps({
  items: { type: Array, default: () => [] },
  total: { type: [Number, String], default: 0 },
  paymentConfig: { type: Object, default: () => ({ stripe_enabled: true, paypal_enabled: true }) },
})

const { t } = useI18n()
const page = usePage()
const auth = computed(() => page.props.auth)

const hasConsultation = computed(() => props.items.some(i => i.type === 'consultation'))

const form = useForm({
  name:              auth.value?.user?.name  || '',
  email:             auth.value?.user?.email || '',
  phone:             '',
  symptoms:          '',
  medical_history:   '',
  payment_method:    props.paymentConfig?.stripe_enabled ? 'stripe' : 'paypal',
  payment_intent_id: '',
  paypal_order_id:   '',
})

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

// ── Stripe ────────────────────────────────────────────────────────────
const stripeInstance     = ref(null)
const stripeCardEl       = ref(null)
const stripeError        = ref('')
const stripeLoading      = ref(false)
const stripeNotConfigured = ref(false)

async function initStripe() {
  if (!props.paymentConfig?.stripe_enabled) return
  stripeLoading.value = true
  try {
    await loadScript('https://js.stripe.com/v3/')
    const res = await fetch('/payment/stripe/public-key')
    const { public_key } = await res.json()
    if (!public_key) { stripeNotConfigured.value = true; stripeLoading.value = false; return }
    stripeInstance.value = window.Stripe(public_key)
    await nextTick()
    mountStripeCard()
  } catch (e) {
    stripeError.value = 'Stripe indisponible.'
  } finally {
    stripeLoading.value = false
  }
}

function mountStripeCard() {
  if (!stripeInstance.value) return
  if (stripeCardEl.value) return
  const el = document.getElementById('cart-stripe-card-element')
  if (!el) return
  const elements = stripeInstance.value.elements()
  stripeCardEl.value = elements.create('card', {
    style: {
      base: { color: '#ffffff', fontSize: '14px', fontFamily: 'inherit', '::placeholder': { color: 'rgba(200,220,255,0.4)' } },
      invalid: { color: '#f87171' },
    },
  })
  stripeCardEl.value.mount('#cart-stripe-card-element')
}

// ── PayPal ────────────────────────────────────────────────────────────
const paypalError = ref('')
let paypalButtonsRendered = false

async function initPaypal() {
  if (!props.paymentConfig?.paypal_enabled) return
  const clientId = props.paymentConfig?.paypal_client_id
  if (!clientId) { paypalError.value = 'PayPal non configuré (clé manquante dans l\'admin).'; return }
  try {
    await loadScript(`https://www.paypal.com/sdk/js?client-id=${clientId}&currency=EUR`)
    await nextTick()
    renderPaypalButtons()
  } catch (e) {
    paypalError.value = 'PayPal indisponible.'
  }
}

function renderPaypalButtons() {
  if (!window.paypal || paypalButtonsRendered) return
  const container = document.getElementById('cart-paypal-button-container')
  if (!container) return
  paypalButtonsRendered = true
  window.paypal.Buttons({
    style: { layout: 'vertical', color: 'blue', shape: 'rect', label: 'pay' },
    createOrder: async () => {
      paypalError.value = ''
      const res = await fetch('/payment/paypal/create-order', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': getCsrf(), 'Content-Type': 'application/json', Accept: 'application/json' },
        body: JSON.stringify({}),
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
      form.payment_method = 'paypal'
      form.post(route('checkout.process'))
    },
    onError: (err) => { paypalError.value = 'Erreur PayPal: ' + (err.message || err) },
  }).render('#cart-paypal-button-container')
}

// ── Watchers ──────────────────────────────────────────────────────────
watch(() => form.payment_method, async (method) => {
  if (method === 'stripe' && !stripeInstance.value) await initStripe()
  else if (method === 'stripe' && stripeInstance.value) { await nextTick(); mountStripeCard() }
  else if (method === 'paypal') { paypalButtonsRendered = false; await nextTick(); await initPaypal() }
})

onMounted(async () => {
  if (form.payment_method === 'stripe') await initStripe()
  else if (form.payment_method === 'paypal') await initPaypal()
})

// ── Submit ────────────────────────────────────────────────────────────
const isSubmitting = ref(false)

async function submitPayment() {
  stripeError.value = ''
  if (form.payment_method === 'stripe') {
    if (!stripeInstance.value || !stripeCardEl.value) {
      stripeError.value = 'Stripe non initialisé. Rechargez la page.'
      return
    }
    isSubmitting.value = true
    const intentRes = await fetch('/payment/stripe/intent', {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': getCsrf(), 'Content-Type': 'application/json', Accept: 'application/json' },
      body: JSON.stringify({}),
    })
    const intentData = await intentRes.json()
    if (!intentRes.ok) { stripeError.value = intentData.error || 'Erreur Stripe'; isSubmitting.value = false; return }
    const { error, paymentIntent } = await stripeInstance.value.confirmCardPayment(
      intentData.client_secret,
      { payment_method: { card: stripeCardEl.value } }
    )
    if (error) { stripeError.value = error.message; isSubmitting.value = false; return }
    form.payment_intent_id = paymentIntent.id
    form.post(route('checkout.process'), { onFinish: () => { isSubmitting.value = false } })
  }
}
</script>

<style scoped>
.cart-section { padding: 120px 24px 80px; min-height: 100vh; }
.cart-inner { max-width: 1100px; margin: 0 auto; }
.cart-title { font-family: 'Cormorant Garamond', serif; font-size: 2.5rem; font-weight: 300; color: #fff; margin-bottom: 40px; }
.cart-title em { color: #c8a96e; font-style: italic; }
.cart-empty { text-align: center; padding: 60px 24px; background: rgba(13,31,58,.6); border: 1px solid rgba(200,169,110,.15); border-radius: 20px; }
.cart-empty-icon { font-size: 3rem; margin-bottom: 16px; }
.cart-empty-text { color: rgba(200,220,255,.5); font-size: .95rem; margin-bottom: 24px; }

.cart-layout { display: grid; grid-template-columns: 1fr 320px; gap: 32px; align-items: start; }
@media (max-width: 768px) { .cart-layout { grid-template-columns: 1fr; } }

.cart-left { display: flex; flex-direction: column; gap: 16px; }
.cart-list { display: flex; flex-direction: column; gap: 10px; }
.cart-item { display: flex; align-items: center; gap: 16px; background: rgba(13,31,58,.6); border: 1px solid rgba(200,169,110,.15); border-radius: 14px; padding: 16px 18px; }
.cart-item-icon { width: 42px; height: 42px; border-radius: 10px; background: rgba(13,115,119,.15); border: 1px solid rgba(13,115,119,.2); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0; }
.cart-item-info { flex: 1; min-width: 0; }
.cart-item-title { color: #fff; font-size: .88rem; font-weight: 600; margin-bottom: 3px; }
.cart-item-sub { color: rgba(200,220,255,.4); font-size: .73rem; }
.cart-item-right { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
.cart-item-price { color: #c8a96e; font-size: 1rem; font-weight: 600; }
.cart-remove { width: 26px; height: 26px; border-radius: 50%; border: 1px solid rgba(255,255,255,.1); background: transparent; color: rgba(200,220,255,.4); cursor: pointer; font-size: .7rem; display: flex; align-items: center; justify-content: center; transition: all .2s; }
.cart-remove:hover { border-color: rgba(248,113,113,.4); color: #f87171; }

.pay-box { background: rgba(13,31,58,.7); border: 1px solid rgba(200,169,110,.15); border-radius: 16px; padding: 22px 24px; }
.pay-box-title { color: #fff; font-size: .9rem; font-weight: 600; margin-bottom: 16px; }
.info-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
@media (max-width: 480px) { .info-row { grid-template-columns: 1fr; } }
.info-field { display: flex; flex-direction: column; gap: 6px; }
.info-field label { color: rgba(200,220,255,.6); font-size: .75rem; }
.info-field input, .info-field textarea { background: rgba(7,31,61,.8); border: 1px solid rgba(255,255,255,.1); border-radius: 8px; padding: 10px 12px; color: #fff; font-size: .85rem; outline: none; resize: vertical; }
.info-field input:focus, .info-field textarea:focus { border-color: rgba(13,115,119,.5); }
.field-err { color: #f87171; font-size: .72rem; }

.pay-options { display: flex; flex-direction: column; gap: 10px; margin-bottom: 16px; }
.pay-option { display: flex; align-items: center; gap: 12px; padding: 14px 16px; border: 1px solid rgba(255,255,255,.1); border-radius: 12px; cursor: pointer; transition: all .2s; }
.pay-option.active { border-color: rgba(13,115,119,.5); background: rgba(13,115,119,.07); }
.pay-option p { color: #fff; font-size: .85rem; font-weight: 500; margin: 0 0 2px; }
.pay-option span { color: rgba(200,220,255,.4); font-size: .72rem; }
.pay-option > div:nth-child(2) { flex: 1; }
.pay-icon { width: 34px; height: 34px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: .8rem; font-weight: 700; flex-shrink: 0; }
.pay-s { background: rgba(99,91,255,.15); color: #635bff; }
.pay-pp { background: rgba(0,112,192,.15); color: #0070c0; }
.pay-check { width: 16px; height: 16px; border-radius: 50%; border: 2px solid rgba(255,255,255,.2); flex-shrink: 0; transition: all .2s; }
.pay-check.active { border-color: #14a8a0; background: #14a8a0; }
.pay-warn { color: #fbbf24; font-size: .8rem; }

.card-fields { display: flex; flex-direction: column; gap: 8px; }
.card-label { color: rgba(200,220,255,.6); font-size: .75rem; }
.card-input { background: rgba(7,31,61,.8); border: 1px solid rgba(255,255,255,.1); border-radius: 8px; padding: 10px 12px; color: #fff; }
.card-error { color: #f87171; font-size: .78rem; }
.card-secure { color: rgba(200,220,255,.35); font-size: .72rem; }

.cart-btn-primary { display: block; text-align: center; background: linear-gradient(135deg,#0d7377,#14a8a0); color: #fff; border: none; padding: 14px; border-radius: 10px; font-size: .9rem; font-weight: 600; text-decoration: none; cursor: pointer; transition: all .2s; }
.cart-btn-primary:hover:not(:disabled) { box-shadow: 0 8px 24px rgba(13,115,119,.4); transform: translateY(-1px); }
.cart-btn-primary:disabled { opacity: .6; cursor: not-allowed; }
.cart-btn-outline { display: block; text-align: center; background: transparent; color: rgba(200,220,255,.6); border: 1px solid rgba(255,255,255,.1); padding: 12px; border-radius: 10px; font-size: .85rem; text-decoration: none; transition: all .2s; }

.cart-summary { background: rgba(13,31,58,.8); border: 1px solid rgba(200,169,110,.2); border-radius: 16px; padding: 24px; position: sticky; top: 100px; }
.summary-title { color: #fff; font-size: .9rem; font-weight: 600; margin-bottom: 16px; }
.sum-row { display: flex; justify-content: space-between; color: rgba(200,220,255,.5); font-size: .82rem; margin-bottom: 8px; }
.sum-divider { height: 1px; background: rgba(255,255,255,.06); margin: 12px 0; }
.sum-total { font-weight: 600; color: rgba(200,220,255,.8); }
.sum-total-val { color: #c8a96e; font-family: 'Cormorant Garamond', serif; font-size: 1.6rem; font-weight: 300; }
.sum-perks { margin-top: 16px; display: flex; flex-direction: column; gap: 6px; color: rgba(200,220,255,.4); font-size: .73rem; }
</style>
