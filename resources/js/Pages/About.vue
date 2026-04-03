<template>
  <AppLayout>
    <!-- Hero -->
    <section class="pt-32 pb-20 px-4 relative text-center">
      <div class="absolute inset-0 halo-glow pointer-events-none"></div>
      <p class="text-vitality-cyan text-sm tracking-widest uppercase mb-3">Our Story</p>
      <h1 class="section-title text-white mb-4">Science meets <em class="text-gradient-gold not-italic">energy healing</em></h1>
      <p class="text-vitality-text text-lg max-w-2xl mx-auto leading-relaxed">
        Vitality Inside was born from 25 years of clinical practice, thousands of patient cases, and a single conviction: the body's deepest intelligence speaks in frequencies.
      </p>
    </section>

    <!-- Dr. Rosati -->
    <section class="px-4 pb-20 max-w-5xl mx-auto">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div class="glass-card rounded-3xl p-12 flex items-center justify-center min-h-[340px]">
          <div class="text-center">
            <div class="text-8xl mb-5">👨‍⚕️</div>
            <h3 class="font-serif text-2xl text-white font-light">Dr. Éric Rosati</h3>
            <p class="text-vitality-cyan text-sm mt-2">Osteopath · Doctor of Quantum Medicine</p>
          </div>
        </div>
        <div class="space-y-6">
          <div>
            <h2 class="font-serif text-3xl text-white font-light mb-4">The founder</h2>
            <p class="text-vitality-text leading-relaxed mb-4">Trained as an osteopath and later as a Doctor of Quantum Medicine, Dr. Rosati has spent three decades studying how the body communicates at a cellular and energetic level. His clinical work showed him, again and again, that many chronic conditions responded better to frequency-based approaches than to traditional protocols alone.</p>
            <p class="text-vitality-text leading-relaxed">In 2015, he began systematically encoding his most effective therapeutic frequencies into digital programs — making his life's clinical work available to anyone with a device and a pair of bone-conduction headphones.</p>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div v-for="stat in stats" :key="stat.label" class="glass-card rounded-2xl p-4 text-center">
              <p class="text-vitality-gold font-bold text-2xl">{{ stat.value }}</p>
              <p class="text-vitality-text text-xs mt-1">{{ stat.label }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- The Method -->
    <section class="px-4 pb-20 max-w-4xl mx-auto">
      <div class="text-center mb-12">
        <p class="text-vitality-cyan text-sm tracking-widest uppercase mb-3">The Method</p>
        <h2 class="section-title text-white">How bio-energy <em class="text-gradient-gold not-italic">frequency works</em></h2>
      </div>
      <div class="space-y-4">
        <div v-for="(item, i) in method" :key="i" class="glass-card rounded-2xl p-6 flex items-start gap-5">
          <div class="w-10 h-10 rounded-xl bg-vitality-cyan/10 flex items-center justify-center text-xl flex-shrink-0">{{ item.icon }}</div>
          <div>
            <h3 class="text-white font-semibold mb-2">{{ item.title }}</h3>
            <p class="text-vitality-text text-sm leading-relaxed">{{ item.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Certifications -->
    <section class="px-4 pb-20 max-w-4xl mx-auto">
      <div class="glass-card rounded-3xl p-10 border-glow text-center">
        <h2 class="font-serif text-2xl text-white font-light mb-6">Certifications &amp; Practice</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <div v-for="cert in certs" :key="cert" class="glass-card rounded-xl p-4 text-xs text-vitality-text leading-tight">{{ cert }}</div>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="px-4 pb-24 max-w-3xl mx-auto text-center">
      <h2 class="font-serif text-3xl text-white font-light mb-4">Ready to experience it?</h2>
      <p class="text-vitality-text mb-8">Explore 60+ targeted programs or book a personalized consultation with Dr. Rosati.</p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <Link :href="route('shop')" class="btn-cyan text-base px-8 py-3.5">Explore Programs</Link>
        <Link :href="route('consultation')" class="btn-gold text-base px-8 py-3.5">Book a Consultation</Link>
      </div>
    </section>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'

const stats = [
  { value: '25+', label: 'Years clinical practice' },
  { value: '60+', label: 'Programs developed' },
  { value: '21K+', label: 'Users worldwide' },
  { value: '8h', label: 'Protocol delivery' },
]
const method = [
  { icon: '🌊', title: 'Bio-Resonance Foundation', desc: 'Every organ, tissue, and cellular system in the body emits and responds to specific electromagnetic frequencies. This is well-documented in the fields of quantum biology and biophysics.' },
  { icon: '🎵', title: 'Therapeutic Frequency Encoding', desc: 'Dr. Rosati encodes therapeutic frequencies — tested and refined over 25 years of practice — into audio formats that can be delivered via bone-conduction headphones directly to the body\'s cellular network.' },
  { icon: '🔄', title: 'Vibrational Cell Rebalancing', desc: 'When the body receives the correct frequency stimulus, it triggers a cascade of cellular responses: reduced inflammation, hormonal rebalancing, nervous system regulation, and immune strengthening.' },
  { icon: '📊', title: 'Cumulative Protocol Effect', desc: 'The 21–30 day cure protocol is designed to create lasting cellular changes. Sessions are short (18–35 minutes) and the effect compounds over the course of the cure.' },
]
const certs = [
  'D.O. Osteopathy · France', 'Doctor of Quantum Medicine', 'Bio-Resonance Therapy Certification', 'Quantum Neurology Practitioner', 'Member: European Osteopathic Federation', 'Author: Clinical Frequency Protocols · 2019', '25 Years Private Practice · Monaco', 'Vitality Inside Research Lab · 2015–2025',
]
</script>
