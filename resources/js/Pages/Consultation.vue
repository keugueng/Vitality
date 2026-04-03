<template>
  <AppLayout>
    <!-- Hero -->
    <section class="pt-32 pb-16 px-4 relative text-center">
      <div class="absolute inset-0 halo-glow pointer-events-none"></div>
      <p class="text-vitality-cyan text-sm tracking-widest uppercase mb-3">Dr. Éric Rosati</p>
      <h1 class="section-title text-white mb-4">Personalized<br><em class="text-gradient-gold not-italic">Consultation</em></h1>
      <p class="text-vitality-text text-lg max-w-2xl mx-auto leading-relaxed">
        Submit your health history and symptoms — Dr. Rosati personally designs your custom bio-energy frequency protocol within 8 hours.
      </p>
    </section>

    <!-- Packages -->
    <section class="px-4 pb-16 max-w-4xl mx-auto">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div v-for="pkg in packages" :key="pkg.id"
          @click="form.package_type = pkg.id"
          :class="['glass-card rounded-2xl p-6 cursor-pointer transition-all border-2', form.package_type === pkg.id ? 'border-vitality-cyan glow-cyan' : 'border-transparent hover:border-white/10']">
          <div v-if="pkg.popular" class="inline-flex items-center gap-1 bg-vitality-cyan/10 text-vitality-cyan text-xs rounded-full px-3 py-1 mb-3">⭐ Most Popular</div>
          <h3 class="text-white font-semibold text-lg mb-1">{{ pkg.name }}</h3>
          <p class="text-vitality-gold font-bold text-3xl mb-2">€{{ pkg.price }}</p>
          <p class="text-vitality-text text-sm mb-4">{{ pkg.sessions }} session{{ pkg.sessions > 1 ? 's' : '' }} · {{ pkg.duration }}</p>
          <ul class="space-y-2">
            <li v-for="f in pkg.features" :key="f" class="flex items-start gap-2 text-vitality-text text-xs">
              <span class="text-vitality-cyan mt-0.5 flex-shrink-0">✓</span>{{ f }}
            </li>
          </ul>
        </div>
      </div>
    </section>

    <!-- How it works -->
    <section class="px-4 pb-16 max-w-4xl mx-auto">
      <div class="glass-card rounded-3xl p-8 md:p-12 border-glow">
        <h2 class="font-serif text-2xl text-white mb-8 text-center">How the consultation works</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
          <div v-for="(step, i) in consultSteps" :key="i" class="text-center">
            <div class="w-10 h-10 rounded-full bg-vitality-cyan/10 mx-auto mb-3 flex items-center justify-center text-lg">{{ step.icon }}</div>
            <h4 class="text-white font-semibold text-sm mb-1">{{ step.title }}</h4>
            <p class="text-vitality-text text-xs leading-relaxed">{{ step.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Form -->
    <section class="px-4 pb-24 max-w-2xl mx-auto">
      <div class="glass-card rounded-3xl p-8 md:p-10 border-glow">
        <h2 class="font-serif text-2xl text-white mb-8">Book your consultation</h2>

        <div v-if="$page.props.flash?.success" class="bg-vitality-cyan/10 border border-vitality-cyan/30 rounded-xl p-4 mb-6 text-vitality-cyan text-sm">
          {{ $page.props.flash.success }}
        </div>

        <form @submit.prevent="submit" class="space-y-5">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="text-vitality-text text-xs mb-1.5 block">Full Name *</label>
              <input v-model="form.name" type="text" required placeholder="Your name"
                class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-vitality-cyan/50 placeholder-vitality-text/40"/>
            </div>
            <div>
              <label class="text-vitality-text text-xs mb-1.5 block">Email *</label>
              <input v-model="form.email" type="email" required placeholder="your@email.com"
                class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-vitality-cyan/50 placeholder-vitality-text/40"/>
            </div>
          </div>
          <div>
            <label class="text-vitality-text text-xs mb-1.5 block">Phone</label>
            <input v-model="form.phone" type="tel" placeholder="+33 6 00 00 00 00"
              class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-vitality-cyan/50 placeholder-vitality-text/40"/>
          </div>
          <div>
            <label class="text-vitality-text text-xs mb-1.5 block">Your symptoms &amp; health goals *</label>
            <textarea v-model="form.symptoms" required rows="4" placeholder="Describe your main health concerns, symptoms, duration, and what you've already tried…"
              class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-vitality-cyan/50 placeholder-vitality-text/40 resize-none"></textarea>
          </div>
          <div>
            <label class="text-vitality-text text-xs mb-1.5 block">Medical history (optional)</label>
            <textarea v-model="form.medical_history" rows="3" placeholder="Relevant past diagnoses, medications, surgeries…"
              class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-vitality-cyan/50 placeholder-vitality-text/40 resize-none"></textarea>
          </div>

          <div class="glass-card rounded-xl p-4 flex items-center justify-between">
            <div>
              <p class="text-white text-sm font-semibold">{{ selectedPkg.name }}</p>
              <p class="text-vitality-text text-xs">{{ selectedPkg.sessions }} session{{ selectedPkg.sessions > 1 ? 's' : '' }} · Protocol delivered within 8 hours</p>
            </div>
            <span class="text-vitality-gold font-bold text-xl">€{{ selectedPkg.price }}</span>
          </div>

          <button type="submit" :disabled="form.processing" class="btn-cyan w-full text-base py-3.5 disabled:opacity-50">
            {{ form.processing ? 'Sending…' : `Book Consultation — €${selectedPkg.price}` }}
          </button>
          <p class="text-center text-vitality-text/50 text-xs">🔒 Your information is confidential. Protocol delivered within 8 hours.</p>
        </form>
      </div>
    </section>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm } from '@inertiajs/vue3'
import { computed } from 'vue'

const packages = [
  { id: 'single',    name: 'Single Session',    price: 58,  sessions: 1, duration: 'One protocol', popular: false,
    features: ['Complete health assessment', 'Custom frequency protocol', 'PDF protocol delivered < 8h', 'Email support'] },
  { id: 'progress',  name: 'Progress Pack',     price: 149, sessions: 3, duration: '3 months', popular: true,
    features: ['3 personalized consultations', 'Progressive protocol adjustment', 'Priority email support', 'Monthly progress review'] },
  { id: 'transform', name: 'Transform Program', price: 239, sessions: 5, duration: '5 months', popular: false,
    features: ['5 consultations over 5 months', 'Full health transformation plan', 'WhatsApp direct access', 'Unlimited email support', 'Access to all programs'] },
]

const consultSteps = [
  { icon: '📝', title: 'Fill the form', desc: 'Share your symptoms, history, and objectives in detail.' },
  { icon: '🔬', title: 'Dr. Rosati analyses', desc: 'Personal review of your case using 25+ years of clinical expertise.' },
  { icon: '📋', title: 'Protocol delivered', desc: 'Receive your custom frequency protocol by email within 8 hours.' },
  { icon: '🎧', title: 'Start your cure', desc: 'Follow your 21-30 day protocol with headphones and feel the difference.' },
]

const form = useForm({ name: '', email: '', phone: '', package_type: 'single', symptoms: '', medical_history: '' })
const selectedPkg = computed(() => packages.find(p => p.id === form.package_type) || packages[0])
const submit = () => form.post(route('consultation.store'))
</script>
