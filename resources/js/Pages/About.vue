<template>
  <AppLayout>
    <!-- Hero -->
    <section class="pt-32 pb-20 px-6 relative text-center">
      <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse 80% 50% at 50% 0%, rgba(17,199,201,0.05) 0%, transparent 70%);"></div>
      <p class="text-[11px] font-semibold tracking-[0.2em] uppercase mb-4" style="color: #11C7C9;">Our Story</p>
      <h1 class="font-serif font-light text-white mb-5" style="font-size: clamp(2.2rem, 5vw, 3.5rem); line-height: 1.1;">
        Science meets <em style="color: #D5B67A; font-style: italic;">energy healing</em>
      </h1>
      <p class="text-[#9DAAC0] text-lg max-w-2xl mx-auto leading-relaxed">
        Vitality Inside was born from 25 years of clinical practice, thousands of patient cases, and a single conviction: the body's deepest intelligence speaks in frequencies.
      </p>
    </section>

    <!-- Dr. Rosati -->
    <section class="px-6 pb-20 max-w-5xl mx-auto">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div class="rounded-3xl p-12 flex items-center justify-center min-h-[340px]"
          style="background: rgba(10,39,69,0.5); border: 1px solid rgba(255,255,255,0.07);">
          <div class="text-center">
            <div class="text-8xl mb-5">👨‍⚕️</div>
            <h3 class="font-serif text-2xl text-white font-light">Dr. Éric Rosati</h3>
            <p class="text-sm mt-2" style="color: #11C7C9;">Osteopath · Doctor of Quantum Medicine</p>
          </div>
        </div>
        <div class="space-y-6">
          <h2 class="font-serif font-light text-white" style="font-size: clamp(1.8rem, 3vw, 2.4rem);">The founder</h2>
          <p class="text-[#9DAAC0] leading-relaxed">Trained as an osteopath and later as a Doctor of Quantum Medicine, Dr. Rosati has spent three decades studying how the body communicates at a cellular and energetic level. His clinical work showed him, again and again, that many chronic conditions responded better to frequency-based approaches than to traditional protocols alone.</p>
          <p class="text-[#9DAAC0] leading-relaxed">In 2015, he began systematically encoding his most effective therapeutic frequencies into digital programs — making his life's clinical work available to anyone with a device and a pair of bone-conduction headphones.</p>
          <div class="grid grid-cols-2 gap-4">
            <div v-for="stat in stats" :key="stat.label"
              class="rounded-2xl p-4 text-center"
              style="background: rgba(10,39,69,0.5); border: 1px solid rgba(255,255,255,0.07);">
              <p class="font-serif font-light text-2xl" style="color: #D5B67A;">{{ stat.value }}</p>
              <p class="text-xs mt-1" style="color: #9DAAC0;">{{ stat.label }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- The Method -->
    <section class="px-6 pb-20 max-w-4xl mx-auto">
      <div class="text-center mb-12">
        <p class="text-[11px] font-semibold tracking-[0.2em] uppercase mb-4" style="color: #11C7C9;">The Method</p>
        <h2 class="font-serif font-light text-white" style="font-size: clamp(1.8rem, 3.5vw, 2.6rem);">
          How bio-energy <em style="color: #D5B67A; font-style: italic;">frequency works</em>
        </h2>
      </div>
      <div class="space-y-4">
        <div v-for="(item, i) in method" :key="i"
          class="rounded-2xl p-6 flex items-start gap-5"
          style="background: rgba(10,39,69,0.5); border: 1px solid rgba(255,255,255,0.07);">
          <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl flex-shrink-0"
            style="background: rgba(17,199,201,0.1);">{{ item.icon }}</div>
          <div>
            <h3 class="text-white font-semibold mb-2">{{ item.title }}</h3>
            <p class="text-[#9DAAC0] text-sm leading-relaxed">{{ item.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Certifications -->
    <section class="px-6 pb-20 max-w-4xl mx-auto">
      <div class="rounded-3xl p-10 text-center"
        style="background: rgba(10,39,69,0.5); border: 1px solid rgba(213,182,122,0.15);">
        <h2 class="font-serif text-2xl text-white font-light mb-6">Certifications &amp; Practice</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <div v-for="cert in certs" :key="cert"
            class="rounded-xl p-4 text-xs leading-tight"
            style="background: rgba(3,20,42,0.5); border: 1px solid rgba(255,255,255,0.07); color: #9DAAC0;">
            {{ cert }}
          </div>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="px-6 pb-24 max-w-3xl mx-auto text-center">
      <h2 class="font-serif font-light text-white mb-4" style="font-size: clamp(1.8rem, 3vw, 2.4rem);">
        Ready to experience it?
      </h2>
      <p class="text-[#9DAAC0] mb-8">Explore 60+ targeted programs or book a personalized consultation with Dr. Rosati.</p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <Link :href="route('shop')"
          class="bg-[#11C7C9] hover:bg-[#0db5b7] text-[#03142A] font-bold text-sm tracking-wide uppercase px-8 py-3.5 rounded transition-all">
          Explore Programs
        </Link>
        <Link :href="route('consultation')"
          class="border text-white hover:border-[#D5B67A] hover:text-[#D5B67A] text-sm font-semibold px-8 py-3.5 rounded transition-all"
          style="border-color: rgba(213,182,122,0.5); color: #D5B67A;">
          Book a Consultation
        </Link>
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
