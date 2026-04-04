<template>
  <AppLayout>
    <section class="sub-hero">
      <div class="sub-hero-inner">
        <p class="sub-label">Accès Illimité</p>
        <h1 class="sub-title">Choisissez votre <em class="gold-em">abonnement</em></h1>
        <p class="sub-sub">Accédez à 37+ protocoles audio conçus par le Dr. Éric Rosati. Sans engagement mensuel.</p>
      </div>
    </section>

    <!-- Active subscription notice -->
    <div v-if="activeSubscription" class="sub-active-notice">
      <div class="sub-active-inner">
        <div class="sub-active-icon">✓</div>
        <div>
          <p class="sub-active-title">Abonnement {{ activeSubscription.type === 'monthly' ? 'Mensuel' : 'Annuel' }} actif</p>
          <p class="sub-active-sub">
            Expire le {{ formatDate(activeSubscription.ends_at) }} ·
            <Link :href="route('pro')" class="sub-active-link">Accéder à mon espace →</Link>
          </p>
        </div>
        <form @submit.prevent="cancelForm.post(route('subscribe.cancel'))">
          <button type="submit" class="sub-cancel-btn" :disabled="cancelForm.processing">
            {{ cancelForm.processing ? 'Annulation…' : 'Annuler l\'abonnement' }}
          </button>
        </form>
      </div>
    </div>

    <!-- Plans grid -->
    <section v-if="!activeSubscription" class="sub-plans">
      <div class="sub-plans-inner">
        <div class="plans-grid">
          <div v-for="plan in plans" :key="plan.id"
            class="plan-card" :class="{ 'plan-card--highlight': plan.highlight, 'plan-card--selected': selectedPlan === plan.id }"
            @click="selectedPlan = plan.id">
            <div v-if="plan.highlight" class="plan-badge">⭐ Meilleur choix</div>
            <div class="plan-header">
              <h3 class="plan-name">{{ plan.label }}</h3>
              <div class="plan-price-row">
                <span class="plan-price">€{{ plan.price }}</span>
                <span class="plan-period">{{ plan.period }}</span>
              </div>
              <p class="plan-desc">{{ plan.description }}</p>
            </div>
            <ul class="plan-features">
              <li v-for="feat in plan.features" :key="feat">
                <span class="feat-check">✓</span> {{ feat }}
              </li>
            </ul>
            <div class="plan-select-indicator">
              <div class="plan-radio" :class="{ active: selectedPlan === plan.id }">
                <div v-if="selectedPlan === plan.id" class="plan-radio-dot"></div>
              </div>
              <span>{{ selectedPlan === plan.id ? 'Sélectionné' : 'Choisir ce plan' }}</span>
            </div>
          </div>
        </div>

        <!-- Payment method -->
        <div class="sub-payment-box">
          <h3 class="sub-payment-title">Méthode de paiement</h3>
          <div class="payment-options">
            <label v-if="paymentConfig?.stripe_enabled"
              class="payment-option" :class="{ active: form.payment_method === 'stripe' }">
              <input type="radio" v-model="form.payment_method" value="stripe" class="hidden" />
              <div class="pay-icon pay-icon--stripe">S</div>
              <div>
                <p>Stripe — Carte bancaire</p>
                <span>Visa, Mastercard, Amex</span>
              </div>
              <div class="pay-check" :class="{ active: form.payment_method === 'stripe' }"></div>
            </label>
            <label v-if="paymentConfig?.paypal_enabled"
              class="payment-option" :class="{ active: form.payment_method === 'paypal' }">
              <input type="radio" v-model="form.payment_method" value="paypal" class="hidden" />
              <div class="pay-icon pay-icon--paypal">PP</div>
              <div>
                <p>PayPal</p>
                <span>Paiement sécurisé PayPal</span>
              </div>
              <div class="pay-check" :class="{ active: form.payment_method === 'paypal' }"></div>
            </label>
            <div v-if="!paymentConfig?.stripe_enabled && !paymentConfig?.paypal_enabled"
              class="payment-warning">
              ⚠️ Aucun mode de paiement disponible. Contactez l'administrateur.
            </div>
          </div>
        </div>

        <!-- CTA -->
        <div class="sub-cta">
          <template v-if="!auth?.user">
            <Link :href="route('login')" class="sub-btn-primary">
              Se connecter pour s'abonner
            </Link>
            <p class="sub-cta-note">Pas encore de compte ? <Link :href="route('register')" class="cta-link">Créer un compte gratuit</Link></p>
          </template>
          <template v-else>
            <button class="sub-btn-primary" @click="subscribe" :disabled="form.processing || !selectedPlan">
              <span v-if="form.processing">⌛ Activation en cours…</span>
              <span v-else>🔒 S'abonner — €{{ selectedPlanData?.price }}/{{ selectedPlan === 'monthly' ? 'mois' : 'an' }}</span>
            </button>
            <p class="sub-cta-note">Sans engagement · Annulation en un clic · Accès immédiat</p>
          </template>
        </div>

        <!-- Trust section -->
        <div class="sub-trust">
          <div class="trust-item"><span>🔒</span><p>Paiement 100% sécurisé</p></div>
          <div class="trust-item"><span>↩</span><p>Satisfait ou remboursé 7 jours</p></div>
          <div class="trust-item"><span>⚡</span><p>Accès immédiat après paiement</p></div>
          <div class="trust-item"><span>🎧</span><p>37+ protocoles audio inclus</p></div>
        </div>
      </div>
    </section>
  </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, useForm, usePage } from '@inertiajs/vue3'

const props = defineProps({
  plans: Array,
  activeSubscription: Object,
  paymentConfig: { type: Object, default: () => ({ stripe_enabled: true, paypal_enabled: false }) },
})

const page = usePage()
const auth = computed(() => page.props.auth)

const selectedPlan = ref(props.plans?.find(p => p.highlight)?.id || props.plans?.[0]?.id || 'annual')
const selectedPlanData = computed(() => props.plans?.find(p => p.id === selectedPlan.value))

const form = useForm({
  plan: selectedPlan,
  payment_method: props.paymentConfig?.stripe_enabled ? 'stripe' : 'paypal',
})

const cancelForm = useForm({})

function subscribe() {
  form.plan = selectedPlan.value
  form.post(route('subscribe.store'))
}

function formatDate(date) {
  if (!date) return ''
  return new Date(date).toLocaleDateString('fr-FR', { day: '2-digit', month: 'long', year: 'numeric' })
}
</script>

<style scoped>
.sub-hero {
  padding: 120px 24px 60px;
  text-align: center;
}
.sub-hero-inner { max-width: 600px; margin: 0 auto; }
.sub-label { font-size: .72rem; letter-spacing: .18em; text-transform: uppercase; color: #14a8a0; margin-bottom: 14px; }
.sub-title {
  font-family: 'Cormorant Garamond', serif; font-size: clamp(2.2rem, 4vw, 3.2rem);
  font-weight: 300; color: #fff; line-height: 1.15; margin-bottom: 16px;
}
.gold-em { color: #c8a96e; font-style: italic; }
.sub-sub { color: rgba(255,255,255,.55); font-size: 1rem; line-height: 1.6; }

/* Active subscription */
.sub-active-notice {
  max-width: 900px; margin: 0 auto 40px; padding: 0 24px;
}
.sub-active-inner {
  display: flex; align-items: center; gap: 16px; padding: 20px 24px;
  background: rgba(13,115,119,.12); border: 1px solid rgba(13,115,119,.3);
  border-radius: 16px;
}
.sub-active-icon { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg,#0d7377,#14a8a0); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; flex-shrink: 0; }
.sub-active-title { color: #fff; font-weight: 600; font-size: .95rem; margin-bottom: 4px; }
.sub-active-sub { color: rgba(255,255,255,.5); font-size: .8rem; }
.sub-active-link { color: #14a8a0; text-decoration: none; }
.sub-active-link:hover { text-decoration: underline; }
.sub-cancel-btn {
  margin-left: auto; padding: 8px 16px; border-radius: 8px; font-size: .78rem;
  border: 1px solid rgba(239,68,68,.3); color: rgba(239,68,68,.7); background: rgba(239,68,68,.08);
  cursor: pointer; transition: all .2s; white-space: nowrap;
}
.sub-cancel-btn:hover { background: rgba(239,68,68,.15); color: #ef4444; }

/* Plans */
.sub-plans { padding: 0 24px 80px; }
.sub-plans-inner { max-width: 900px; margin: 0 auto; }
.plans-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; margin-bottom: 40px; }

.plan-card {
  position: relative; padding: 32px 28px;
  background: rgba(13,32,64,.6); border: 1px solid rgba(200,220,255,.08);
  border-radius: 20px; cursor: pointer; transition: all .25s;
}
.plan-card:hover { border-color: rgba(20,168,160,.3); transform: translateY(-2px); }
.plan-card--selected { border-color: #14a8a0; background: rgba(13,115,119,.1); box-shadow: 0 0 0 1px rgba(20,168,160,.3); }
.plan-card--highlight { border-color: rgba(200,169,110,.25); }
.plan-badge {
  position: absolute; top: -12px; left: 50%; transform: translateX(-50%);
  background: linear-gradient(135deg,#c8a96e,#e8d5a3); color: #0a1628;
  font-size: .7rem; font-weight: 700; letter-spacing: .08em; padding: 4px 16px; border-radius: 100px;
}
.plan-header { margin-bottom: 24px; }
.plan-name { font-size: 1.15rem; font-weight: 600; color: #fff; margin-bottom: 12px; }
.plan-price-row { display: flex; align-items: baseline; gap: 6px; margin-bottom: 10px; }
.plan-price { font-family: 'Cormorant Garamond', serif; font-size: 3rem; font-weight: 300; color: #c8a96e; line-height: 1; }
.plan-period { font-size: .85rem; color: rgba(255,255,255,.4); }
.plan-desc { font-size: .82rem; color: rgba(255,255,255,.5); line-height: 1.5; }
.plan-features { list-style: none; padding: 0; margin: 0 0 24px; display: flex; flex-direction: column; gap: 10px; }
.plan-features li { display: flex; align-items: center; gap: 10px; font-size: .85rem; color: rgba(255,255,255,.75); }
.feat-check { color: #14a8a0; font-weight: 700; flex-shrink: 0; }
.plan-select-indicator { display: flex; align-items: center; gap: 10px; font-size: .82rem; color: rgba(255,255,255,.5); }
.plan-radio { width: 20px; height: 20px; border-radius: 50%; border: 2px solid rgba(255,255,255,.2); display: flex; align-items: center; justify-content: center; transition: all .2s; }
.plan-radio.active { border-color: #14a8a0; }
.plan-radio-dot { width: 10px; height: 10px; border-radius: 50%; background: #14a8a0; }

/* Payment */
.sub-payment-box { background: rgba(13,32,64,.4); border: 1px solid rgba(200,220,255,.08); border-radius: 16px; padding: 28px; margin-bottom: 32px; }
.sub-payment-title { font-size: .9rem; font-weight: 600; color: #fff; margin-bottom: 16px; }
.payment-options { display: flex; flex-direction: column; gap: 12px; }
.payment-option {
  display: flex; align-items: center; gap: 14px; padding: 16px;
  border: 1px solid rgba(255,255,255,.08); border-radius: 12px; cursor: pointer; transition: all .2s;
}
.payment-option:hover { border-color: rgba(20,168,160,.3); }
.payment-option.active { border-color: rgba(20,168,160,.5); background: rgba(13,115,119,.1); }
.payment-option p { color: #fff; font-size: .875rem; font-weight: 500; margin-bottom: 2px; }
.payment-option span { color: rgba(255,255,255,.4); font-size: .75rem; }
.payment-option .flex-1 { flex: 1; }
.pay-icon { width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: .8rem; flex-shrink: 0; }
.pay-icon--stripe { background: rgba(99,91,255,.2); color: #635BFF; }
.pay-icon--paypal { background: rgba(0,112,240,.2); color: #0070F0; }
.pay-check { width: 18px; height: 18px; border-radius: 50%; border: 2px solid rgba(255,255,255,.2); margin-left: auto; flex-shrink:0; transition: all .2s; }
.pay-check.active { border-color: #14a8a0; background: #14a8a0; }
.payment-warning { padding: 14px; background: rgba(234,179,8,.1); border: 1px solid rgba(234,179,8,.2); border-radius: 10px; color: rgba(234,179,8,.9); font-size: .85rem; }

/* CTA */
.sub-cta { text-align: center; margin-bottom: 40px; }
.sub-btn-primary {
  display: inline-block; padding: 16px 48px; border-radius: 8px; font-size: .95rem; font-weight: 600;
  letter-spacing: .06em; cursor: pointer; transition: all .2s; border: none; text-decoration: none;
  background: linear-gradient(135deg,#0d7377,#14a8a0); color: #fff;
  box-shadow: 0 4px 24px rgba(13,115,119,.4);
}
.sub-btn-primary:hover:not(:disabled) { transform: translateY(-1px); box-shadow: 0 8px 32px rgba(13,115,119,.5); }
.sub-btn-primary:disabled { opacity: .5; cursor: not-allowed; }
.sub-cta-note { margin-top: 12px; font-size: .8rem; color: rgba(255,255,255,.35); }
.cta-link { color: #14a8a0; text-decoration: none; }
.cta-link:hover { text-decoration: underline; }

/* Trust */
.sub-trust { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,.05); }
.trust-item { text-align: center; }
.trust-item span { font-size: 1.4rem; display: block; margin-bottom: 6px; }
.trust-item p { font-size: .75rem; color: rgba(255,255,255,.35); }
@media (max-width: 640px) {
  .sub-trust { grid-template-columns: repeat(2, 1fr); }
  .sub-active-inner { flex-wrap: wrap; }
}
</style>
