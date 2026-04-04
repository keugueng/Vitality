<template>
  <AppLayout>
    <section class="pt-28 pb-24 px-4">
      <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
          <div class="inline-flex items-center gap-2 glass-card border-glow rounded-full px-4 py-2 mb-5 text-xs font-medium text-vitality-cyan tracking-widest uppercase">
            <span class="w-1.5 h-1.5 rounded-full bg-vitality-cyan animate-pulse"></span>
            Commande sécurisée
          </div>
          <h1 class="section-title text-white">Checkout <em class="text-gradient-cyan not-italic">sécurisé</em></h1>
        </div>

        <!-- Progress bar -->
        <div class="flex items-center justify-center gap-3 mb-12">
          <div class="flex items-center gap-2">
            <div class="w-6 h-6 rounded-full bg-vitality-cyan flex items-center justify-center text-vitality-bg text-xs font-bold">1</div>
            <span class="text-vitality-cyan text-xs font-medium">Informations</span>
          </div>
          <div class="w-16 h-px bg-white/10"></div>
          <div class="flex items-center gap-2">
            <div class="w-6 h-6 rounded-full bg-white/10 flex items-center justify-center text-vitality-text text-xs">2</div>
            <span class="text-vitality-text text-xs">Paiement</span>
          </div>
          <div class="w-16 h-px bg-white/10"></div>
          <div class="flex items-center gap-2">
            <div class="w-6 h-6 rounded-full bg-white/10 flex items-center justify-center text-vitality-text text-xs">✓</div>
            <span class="text-vitality-text text-xs">Confirmation</span>
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
                  Vos informations
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <div>
                    <label class="text-vitality-text text-xs mb-1.5 block">Prénom et nom *</label>
                    <input v-model="form.name" type="text" required
                      class="w-full bg-[#071F3D] border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-vitality-cyan/50 placeholder-vitality-text/40"
                      placeholder="Votre nom complet" />
                    <p v-if="form.errors.name" class="text-red-400 text-xs mt-1">{{ form.errors.name }}</p>
                  </div>
                  <div>
                    <label class="text-vitality-text text-xs mb-1.5 block">Email *</label>
                    <input v-model="form.email" type="email" required
                      class="w-full bg-[#071F3D] border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-vitality-cyan/50 placeholder-vitality-text/40"
                      placeholder="votre@email.com" />
                    <p v-if="form.errors.email" class="text-red-400 text-xs mt-1">{{ form.errors.email }}</p>
                  </div>
                </div>
                <div>
                  <label class="text-vitality-text text-xs mb-1.5 block">Téléphone (optionnel)</label>
                  <input v-model="form.phone" type="tel"
                    class="w-full bg-[#071F3D] border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-vitality-cyan/50 placeholder-vitality-text/40"
                    placeholder="+33 6 00 00 00 00" />
                </div>
              </div>

              <!-- Payment method -->
              <div class="glass-card rounded-2xl p-6 space-y-4 mb-5">
                <h2 class="text-white font-semibold text-sm flex items-center gap-2">
                  <span class="w-5 h-5 rounded-full bg-vitality-cyan/20 flex items-center justify-center text-vitality-cyan text-xs">2</span>
                  Méthode de paiement
                </h2>

                <!-- No payment methods warning -->
                <div v-if="!paymentConfig?.stripe_enabled && !paymentConfig?.paypal_enabled"
                  class="p-4 rounded-xl bg-yellow-500/10 border border-yellow-500/30 text-yellow-400 text-sm">
                  ⚠️ Aucun mode de paiement configuré. Contactez l'administrateur.
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
                  ℹ️ Vous serez redirigé vers PayPal pour finaliser votre paiement de façon sécurisée.
                </div>

                <!-- Card fields (shown when Stripe selected) -->
                <div v-if="form.payment_method === 'stripe'" class="space-y-3 pt-2">
                  <div>
                    <label class="text-vitality-text text-xs mb-1.5 block">Numéro de carte</label>
                    <input v-model="form.card_number" type="text" maxlength="19"
                      @input="formatCard"
                      class="w-full bg-[#071F3D] border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-vitality-cyan/50 placeholder-vitality-text/40"
                      placeholder="1234 5678 9012 3456" />
                  </div>
                  <div class="grid grid-cols-2 gap-3">
                    <div>
                      <label class="text-vitality-text text-xs mb-1.5 block">Expiration</label>
                      <input v-model="form.card_expiry" type="text" maxlength="5"
                        class="w-full bg-[#071F3D] border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-vitality-cyan/50 placeholder-vitality-text/40"
                        placeholder="MM/AA" />
                    </div>
                    <div>
                      <label class="text-vitality-text text-xs mb-1.5 block">CVV</label>
                      <input v-model="form.card_cvv" type="text" maxlength="4"
                        class="w-full bg-[#071F3D] border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-vitality-cyan/50 placeholder-vitality-text/40"
                        placeholder="123" />
                    </div>
                  </div>
                </div>

                <p class="text-vitality-text/50 text-xs flex items-center gap-2">
                  <span>🔒</span> SSL 256-bit chiffré · Vos données ne sont jamais stockées sur nos serveurs.
                </p>
              </div>

              <!-- Submit -->
              <button type="submit" :disabled="form.processing"
                class="btn-cyan w-full text-base py-4 disabled:opacity-50 relative overflow-hidden">
                <span v-if="!form.processing" class="flex items-center justify-center gap-2">
                  🔒 Payer €{{ total }} en toute sécurité
                </span>
                <span v-else class="flex items-center justify-center gap-2">
                  <svg class="animate-spin w-4 h-4" viewBox="0 0 24 24" fill="none">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                  </svg>
                  Traitement en cours…
                </span>
              </button>
            </form>
          </div>

          <!-- Order summary (2/5) -->
          <div class="lg:col-span-2">
            <div class="glass-card rounded-2xl p-6 sticky top-24">
              <h2 class="text-white font-semibold text-sm mb-5 flex items-center gap-2">
                <span>📦</span> Récapitulatif de commande
              </h2>

              <!-- Items -->
              <div class="space-y-4 mb-5">
                <div v-for="item in items" :key="item.program.id"
                  class="flex items-start gap-3 pb-4 border-b border-white/5 last:border-0 last:pb-0">
                  <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl flex-shrink-0"
                    style="background: rgba(17,199,201,0.1);">{{ item.program.emoji || '✨' }}</div>
                  <div class="flex-1 min-w-0">
                    <p class="text-white text-sm font-medium leading-snug">{{ item.program.title }}</p>
                    <p class="text-vitality-text text-xs mt-0.5">{{ item.program.session_duration }} · {{ item.program.cure_duration }}</p>
                  </div>
                  <span class="text-vitality-gold text-sm font-bold flex-shrink-0">€{{ item.program.price }}</span>
                </div>
              </div>

              <!-- Total -->
              <div class="border-t border-white/10 pt-4 space-y-2 mb-5">
                <div class="flex items-center justify-between text-sm">
                  <span class="text-vitality-text">Sous-total</span>
                  <span class="text-white">€{{ total }}</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                  <span class="text-vitality-text">Livraison</span>
                  <span class="text-vitality-cyan font-medium">Gratuite</span>
                </div>
                <div class="flex items-center justify-between font-bold text-base pt-2 border-t border-white/10">
                  <span class="text-white">Total</span>
                  <span class="text-vitality-gold text-xl">€{{ total }}</span>
                </div>
              </div>

              <!-- Guarantees -->
              <div class="space-y-2 text-xs text-vitality-text/70">
                <div class="flex items-center gap-2"><span class="text-vitality-cyan">✓</span> Livraison instantanée par email</div>
                <div class="flex items-center gap-2"><span class="text-vitality-cyan">✓</span> Accès à vie à vos programmes</div>
                <div class="flex items-center gap-2"><span class="text-vitality-cyan">✓</span> Garantie 7 jours satisfait ou remboursé</div>
                <div class="flex items-center gap-2"><span class="text-vitality-cyan">✓</span> Support Dr. Rosati inclus</div>
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
import { useForm, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
  items: Array,
  total: [Number, String],
  paymentConfig: { type: Object, default: () => ({ stripe_enabled: true, paypal_enabled: false }) },
})
const page = usePage()
const user = computed(() => page.props.auth?.user)

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
  card_number: '',
  card_expiry: '',
  card_cvv: '',
})

const formatCard = (e) => {
  let val = e.target.value.replace(/\D/g, '').substring(0, 16)
  form.card_number = val.match(/.{1,4}/g)?.join(' ') || val
}

const submit = () => form.post(route('checkout.process'))
</script>
