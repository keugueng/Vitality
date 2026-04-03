<template>
  <AppLayout>
    <section class="pt-28 pb-24 px-4">
      <div class="max-w-4xl mx-auto">
        <h1 class="section-title text-white mb-10">Secure <em class="text-gradient-cyan not-italic">Checkout</em></h1>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
          <!-- Form -->
          <div>
            <form @submit.prevent="submit" class="space-y-5">
              <div class="glass-card rounded-2xl p-6 space-y-4">
                <h2 class="text-white font-semibold text-sm mb-2">Your information</h2>
                <div>
                  <label class="text-vitality-text text-xs mb-1.5 block">Full Name *</label>
                  <input v-model="form.name" type="text" required
                    class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-vitality-cyan/50 placeholder-vitality-text/40"
                    placeholder="Your name" />
                </div>
                <div>
                  <label class="text-vitality-text text-xs mb-1.5 block">Email *</label>
                  <input v-model="form.email" type="email" required
                    class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-vitality-cyan/50 placeholder-vitality-text/40"
                    placeholder="your@email.com" />
                </div>
              </div>

              <div class="glass-card rounded-2xl p-6 space-y-4">
                <h2 class="text-white font-semibold text-sm mb-2">Payment</h2>
                <div class="border border-white/10 rounded-xl p-4 flex items-center gap-3">
                  <div class="w-8 h-8 rounded-lg bg-[#635BFF]/20 flex items-center justify-center text-[#635BFF] font-bold text-xs">S</div>
                  <span class="text-vitality-text text-sm">Stripe — Secure card payment</span>
                </div>
                <p class="text-vitality-text/50 text-xs">🔒 SSL encrypted · Your data is never stored on our servers.</p>
              </div>

              <button type="submit" :disabled="form.processing"
                class="btn-cyan w-full text-base py-3.5 disabled:opacity-50">
                {{ form.processing ? 'Processing…' : `Pay €${total} Securely` }}
              </button>
            </form>
          </div>

          <!-- Order summary -->
          <div>
            <div class="glass-card rounded-2xl p-6">
              <h2 class="text-white font-semibold text-sm mb-4">Order Summary</h2>
              <div class="space-y-3 mb-5">
                <div v-for="item in items" :key="item.program.id" class="flex items-center gap-3">
                  <span class="text-xl">{{ item.program.emoji || '✨' }}</span>
                  <div class="flex-1 min-w-0">
                    <p class="text-white text-sm truncate">{{ item.program.title }}</p>
                    <p class="text-vitality-text text-xs">{{ item.program.session_duration }}</p>
                  </div>
                  <span class="text-vitality-gold text-sm font-semibold flex-shrink-0">€{{ item.program.price }}</span>
                </div>
              </div>
              <div class="border-t border-white/5 pt-4 flex items-center justify-between">
                <span class="text-vitality-text">Total</span>
                <span class="text-vitality-gold font-bold text-2xl">€{{ total }}</span>
              </div>
              <div class="mt-4 space-y-2 text-xs text-vitality-text/60">
                <p>✅ Instant delivery by email</p>
                <p>✅ Lifetime access to your programs</p>
                <p>✅ 7-day satisfaction guarantee</p>
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
import { useForm } from '@inertiajs/vue3'

const props = defineProps({ items: Array, total: [Number, String] })
const form = useForm({ name: '', email: '' })
const submit = () => form.post(route('checkout.process'))
</script>
