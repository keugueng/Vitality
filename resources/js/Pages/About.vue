<template>
  <AppLayout>

    <!-- ═══ HERO ═══ -->
    <section class="pt-32 pb-20 px-6 relative text-center overflow-hidden">
      <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse 80% 50% at 50% 0%, rgba(17,199,201,0.06) 0%, transparent 70%);"></div>
      <div class="relative z-10 max-w-3xl mx-auto">
        <p class="text-[11px] font-semibold tracking-[0.2em] uppercase mb-4" style="color: #11C7C9;">Our Story</p>
        <h1 class="font-serif font-light text-white mb-6" style="font-size: clamp(2.2rem, 5vw, 3.5rem); line-height: 1.1;">
          A science rooted in<br><em style="color: #D5B67A; font-style: italic;">25 years of healing</em>
        </h1>
        <p class="text-[#9DAAC0] text-lg max-w-2xl mx-auto leading-relaxed">
          Vitality Inside was born from decades of clinical research into the body's natural frequency intelligence — combining osteopathy, Chinese medicine and quantum biophysics.
        </p>
      </div>
    </section>

    <!-- ═══ DR. ERIC ROSATI ═══ -->
    <section class="px-6 pb-24 max-w-5xl mx-auto">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
        <!-- Carte portrait -->
        <div class="rounded-3xl p-12 flex flex-col items-center justify-center min-h-[380px] text-center sticky top-28"
          style="background: rgba(10,39,69,0.5); border: 1px solid rgba(255,255,255,0.07);">
          <div class="text-8xl mb-5">👨‍⚕️</div>
          <h2 class="font-serif text-2xl text-white font-light mb-2">Dr. Eric Rosati</h2>
          <p class="text-sm mb-4" style="color: #11C7C9;">Osteopath · Doctor of Quantum Medicine</p>
          <p class="text-xs uppercase tracking-[0.15em] mb-6" style="color: rgba(157,170,192,0.5);">Founder of Vitality Inside</p>
          <div class="flex items-center gap-6">
            <div class="text-center">
              <p class="font-serif font-light text-xl" style="color: #D5B67A;">25+</p>
              <p class="text-[10px] uppercase tracking-widest mt-0.5" style="color: #9DAAC0;">Years</p>
            </div>
            <div class="w-px h-8" style="background: rgba(255,255,255,0.1);"></div>
            <div class="text-center">
              <p class="font-serif font-light text-xl" style="color: #D5B67A;">60+</p>
              <p class="text-[10px] uppercase tracking-widest mt-0.5" style="color: #9DAAC0;">Protocols</p>
            </div>
            <div class="w-px h-8" style="background: rgba(255,255,255,0.1);"></div>
            <div class="text-center">
              <p class="font-serif font-light text-xl" style="color: #D5B67A;">21k+</p>
              <p class="text-[10px] uppercase tracking-widest mt-0.5" style="color: #9DAAC0;">Users</p>
            </div>
          </div>
        </div>

        <!-- Contenu texte -->
        <div class="space-y-8 pt-2">
          <div>
            <p class="text-[11px] font-semibold tracking-[0.2em] uppercase mb-4" style="color: #11C7C9;">The Founder</p>
            <h3 class="font-serif font-light text-white mb-4" style="font-size: clamp(1.6rem, 3vw, 2.2rem);">Dr. Eric Rosati</h3>
            <p class="text-[#9DAAC0] leading-relaxed mb-4">Eric Rosati graduated in osteopathy, Chinese medicine, energy medicine and is the founder of the Isoposturale method. With more than 25 years of professional experience, he spent over a decade searching for a way to provide his patients with more effective and lasting relief.</p>
            <p class="text-[#9DAAC0] leading-relaxed">Since then, his enthusiasm for this energy approach has grown and led him to train in other techniques such as homeopathy, herbal medicine, Chinese medicine and quantum biophysics. This vibratory vision of disease has allowed him to better understand the mechanisms of pathologies and especially to provide more effective and sustainable care.</p>
          </div>

          <!-- Our Mission -->
          <div class="rounded-2xl p-6" style="background: rgba(10,39,69,0.5); border: 1px solid rgba(255,255,255,0.07);">
            <p class="text-[11px] font-semibold tracking-[0.2em] uppercase mb-3" style="color: #11C7C9;">Our Mission</p>
            <p class="text-[#9DAAC0] leading-relaxed mb-4">Frequency therapy applications have been developed over decades of research by therapists and scientists. Numerous studies have demonstrated the effectiveness of frequency therapy in managing pain, improving well-being and treating various pathologies.</p>
            <p class="text-[#9DAAC0] leading-relaxed mb-4">At Vitality Inside, we have synthesized this research into over 37 precise protocols, each targeting specific physiological mechanisms through carefully calibrated bio-energetic frequencies.</p>
            <blockquote class="border-l-2 pl-4 italic text-sm" style="border-color: #D5B67A; color: #D5B67A;">
              "The human body is not just chemistry — it is electricity, vibration, and resonance. When we speak its language, healing becomes natural."
            </blockquote>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══ THE SCIENCE BEHIND THE METHOD — 3 pillars ═══ -->
    <section class="py-24 px-6" style="background: rgba(4,27,51,0.4);">
      <div class="max-w-5xl mx-auto">
        <div class="text-center mb-14">
          <p class="text-[11px] font-semibold tracking-[0.2em] uppercase mb-4" style="color: #11C7C9;">The Method</p>
          <h2 class="font-serif font-light text-white" style="font-size: clamp(1.8rem, 3.5vw, 2.6rem);">
            The science behind <em style="color: #D5B67A; font-style: italic;">the method</em>
          </h2>
          <p class="text-[#9DAAC0] mt-4 max-w-xl mx-auto">Three pillars of bio-energetic healing</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div v-for="pillar in pillars" :key="pillar.title"
            class="rounded-2xl p-8 flex flex-col"
            style="background: rgba(10,39,69,0.6); border: 1px solid rgba(255,255,255,0.07);">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mb-6 flex-shrink-0"
              style="background: rgba(17,199,201,0.1);">{{ pillar.icon }}</div>
            <h3 class="font-serif text-white text-lg font-light mb-3">{{ pillar.title }}</h3>
            <p class="text-[#9DAAC0] text-sm leading-relaxed flex-1">{{ pillar.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══ BEGIN YOUR HEALING JOURNEY — CTA ═══ -->
    <section class="py-24 px-6">
      <div class="max-w-3xl mx-auto text-center">
        <h2 class="font-serif font-light text-white mb-4" style="font-size: clamp(1.8rem, 3vw, 2.4rem);">
          Begin your <em style="color: #D5B67A; font-style: italic;">healing journey</em>
        </h2>
        <p class="text-[#9DAAC0] mb-8 max-w-lg mx-auto leading-relaxed">
          Choose a protocol. Listen with bone conduction headphones. Let your body recalibrate.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <Link :href="route('shop')"
            class="bg-[#11C7C9] hover:bg-[#0db5b7] text-[#03142A] font-bold text-sm tracking-wide uppercase px-8 py-3.5 rounded transition-all">
            Explore Programs
          </Link>
          <Link :href="route('consultation')"
            class="border border-white/30 text-white hover:border-white/60 text-sm font-semibold px-8 py-3.5 rounded transition-all">
            Book a Consultation
          </Link>
        </div>
      </div>
    </section>

  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'

const pillars = [
  {
    icon: '⚡',
    title: 'Bio-Electric Communication',
    desc: 'Every cell in your body maintains a precise electrical potential. Disease disrupts these bioelectric signals. Our frequencies restore cellular coherence at the most fundamental level.',
  },
  {
    icon: '🌀',
    title: 'Quantum Resonance',
    desc: 'Matter vibrates at specific frequencies. Through resonance, external frequencies can modulate biological systems, influencing everything from neural firing patterns to hormonal secretion.',
  },
  {
    icon: '🧠',
    title: 'Neuroplasticity Activation',
    desc: 'Specific frequency ranges (alpha, theta, delta, gamma) entrain brainwave states associated with healing, recovery and neuroplastic change — measurable on EEG.',
  },
]
</script>
