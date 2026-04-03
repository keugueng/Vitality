<template>
  <AppLayout>
    <!-- HERO -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden pt-20">
      <!-- Animated concentric rings -->
      <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
        <div class="absolute w-[300px] h-[300px] rounded-full border border-vitality-cyan/8 ring-animated"></div>
        <div class="absolute w-[500px] h-[500px] rounded-full border border-vitality-cyan/6 ring-animated-2"></div>
        <div class="absolute w-[700px] h-[700px] rounded-full border border-vitality-cyan/4 ring-animated-3"></div>
        <div v-for="i in 6" :key="i" class="absolute rounded-full border border-vitality-cyan/5"
          :style="`width:${i*140}px;height:${i*140}px`"></div>
      </div>
      <!-- Moving orbs -->
      <div class="absolute top-1/4 left-1/4 w-64 h-64 rounded-full bg-vitality-cyan/5 blur-3xl pointer-events-none animate-orb"></div>
      <div class="absolute bottom-1/4 right-1/4 w-48 h-48 rounded-full bg-vitality-gold/5 blur-3xl pointer-events-none animate-float-slow"></div>

      <div class="relative z-10 text-center max-w-5xl mx-auto px-4">
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 glass-card border-glow rounded-full px-4 py-2 mb-8 text-xs font-medium text-vitality-cyan tracking-widest uppercase reveal visible">
          <span class="w-1.5 h-1.5 rounded-full bg-vitality-cyan animate-pulse"></span>
          Bio-Energy Frequency Therapy
        </div>

        <!-- Main title -->
        <h1 class="font-serif text-5xl md:text-6xl lg:text-7xl xl:text-8xl font-light leading-[1.1] mb-6 text-white reveal visible delay-100">
          Your body speaks<br>
          <em class="text-gradient-gold not-italic">in frequencies.</em><br>
          We listen.
        </h1>

        <p class="text-vitality-text text-lg md:text-xl max-w-2xl mx-auto leading-relaxed mb-10 reveal visible delay-200">
          Vibrational cell rebalancing through bio-resonance — a science-backed approach that turns your brain into a natural medicine box. Over 60 targeted programs, delivered to your device.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 reveal visible delay-300">
          <Link :href="route('shop')" class="btn-cyan text-base px-8 py-3.5">Explore Programs</Link>
          <Link :href="route('consultation')" class="btn-outline text-base px-8 py-3.5">Book a Consultation</Link>
        </div>

        <p class="text-vitality-text/50 text-sm mt-6 reveal visible delay-400">Simple &amp; Accessible · 21,000+ users</p>
      </div>

      <!-- Scroll indicator -->
      <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-vitality-text/40 animate-scroll">
        <span class="text-xs tracking-widest uppercase">Scroll</span>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
        </svg>
      </div>
    </section>

    <!-- HOW IT WORKS — 4 Steps -->
    <section class="py-24 px-4">
      <div class="max-w-6xl mx-auto">
        <div class="text-center mb-16">
          <p class="text-vitality-cyan text-sm tracking-widest uppercase mb-3">Protocol</p>
          <h2 class="section-title text-white">Your protocol <em class="text-gradient-gold not-italic">in 4 steps</em></h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div v-for="(step, i) in steps" :key="i"
            class="glass-card rounded-2xl p-6 card-hover relative overflow-hidden group">
            <div class="text-5xl font-serif text-vitality-cyan/10 font-bold absolute top-4 right-5 group-hover:text-vitality-cyan/20 transition-colors">{{ i+1 }}</div>
            <div class="w-12 h-12 rounded-xl bg-vitality-cyan/10 flex items-center justify-center mb-4 text-2xl">{{ step.icon }}</div>
            <h3 class="font-semibold text-white mb-2">{{ step.title }}</h3>
            <p class="text-vitality-text text-sm leading-relaxed">{{ step.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- AREAS OF ACTION -->
    <section class="py-20 px-4 bg-gradient-to-b from-transparent via-[#041B33]/40 to-transparent">
      <div class="max-w-6xl mx-auto">
        <div class="text-center mb-16">
          <p class="text-vitality-cyan text-sm tracking-widest uppercase mb-3">Areas of Action</p>
          <h2 class="section-title text-white">Your body's<br><em class="text-gradient-gold not-italic">complete system</em></h2>
          <p class="text-vitality-text text-base mt-4 max-w-2xl mx-auto">
            This method addresses the full spectrum of frequently encountered health challenges, from structural to emotional to hormonal.
          </p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
          <div v-for="area in areas" :key="area.name"
            class="glass-card rounded-2xl p-5 text-center card-hover cursor-pointer group">
            <div class="text-3xl mb-3">{{ area.icon }}</div>
            <h4 class="text-white font-semibold text-sm mb-2 group-hover:text-vitality-cyan transition-colors">{{ area.name }}</h4>
            <p class="text-vitality-text text-xs leading-relaxed">{{ area.examples }}</p>
          </div>
        </div>
        <div class="text-center mt-10">
          <Link :href="route('shop')" class="btn-outline inline-flex">Browse All 60+ Programs</Link>
        </div>
      </div>
    </section>

    <!-- FEATURED PROGRAMS -->
    <section class="py-24 px-4">
      <div class="max-w-6xl mx-auto">
        <div class="flex items-end justify-between mb-12">
          <div>
            <p class="text-vitality-cyan text-sm tracking-widest uppercase mb-3">Most Popular</p>
            <h2 class="section-title text-white">Featured <em class="text-gradient-gold not-italic">programs</em></h2>
          </div>
          <Link :href="route('shop')" class="hidden md:flex text-vitality-cyan text-sm hover:underline items-center gap-1">
            View all 60+ programs →
          </Link>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <ProgramCard v-for="program in featuredPrograms" :key="program.id" :program="program" />
        </div>
        <div class="text-center mt-8 md:hidden">
          <Link :href="route('shop')" class="text-vitality-cyan text-sm hover:underline">View all 60+ programs →</Link>
        </div>
      </div>
    </section>

    <!-- SUBSCRIPTION CTA -->
    <section class="py-20 px-4">
      <div class="max-w-3xl mx-auto">
        <div class="glass-card rounded-3xl p-10 text-center border-glow relative overflow-hidden">
          <div class="absolute inset-0 bg-gradient-to-br from-vitality-cyan/5 to-transparent rounded-3xl"></div>
          <div class="relative z-10">
            <p class="text-vitality-cyan text-sm tracking-widest uppercase mb-4">Unlimited Access</p>
            <h2 class="font-serif text-3xl md:text-4xl font-light text-white mb-4 leading-tight">
              Access every program.<br><em class="text-gradient-gold not-italic">Every month. One price.</em>
            </h2>
            <p class="text-vitality-text mb-8 max-w-lg mx-auto">
              Subscribe for unlimited access to the full Vitality Inside library — 60+ programs, new protocols monthly, and priority support. Cancel anytime.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
              <Link :href="route('shop')" class="btn-cyan text-base px-8 py-3.5">Start Unlimited Access</Link>
            </div>
            <p class="text-vitality-text/50 text-sm mt-4">21,000+ users · Cancel anytime</p>
          </div>
        </div>
      </div>
    </section>

    <!-- TESTIMONIALS — Infinite Marquee -->
    <section class="py-24 bg-gradient-to-b from-transparent via-[#041B33]/30 to-transparent overflow-hidden">
      <div class="text-center mb-12 px-4">
        <p class="text-vitality-cyan text-sm tracking-widest uppercase mb-3">Community</p>
        <h2 class="section-title text-white">What our community <em class="text-gradient-gold not-italic">experiences</em></h2>
      </div>
      <!-- Scrolling row -->
      <div class="relative">
        <div class="flex gap-5 animate-scroll-x" style="width: max-content;">
          <div v-for="t in [...testimonials, ...testimonials]" :key="t.id + Math.random()"
            class="glass-card rounded-2xl p-6 flex flex-col gap-3 flex-shrink-0"
            style="width: 300px;">
            <div class="flex text-vitality-gold text-sm">★★★★★</div>
            <p class="text-white/80 text-sm italic leading-relaxed flex-1">"{{ t.content }}"</p>
            <div>
              <p class="text-white font-semibold text-sm">{{ t.name }}</p>
              <p class="text-vitality-cyan text-xs">· {{ t.program }}</p>
            </div>
          </div>
        </div>
        <!-- Fade edges -->
        <div class="absolute inset-y-0 left-0 w-24 pointer-events-none" style="background: linear-gradient(to right, #03142A, transparent);"></div>
        <div class="absolute inset-y-0 right-0 w-24 pointer-events-none" style="background: linear-gradient(to left, #03142A, transparent);"></div>
      </div>
    </section>

    <!-- DR ROSATI -->
    <section class="py-24 px-4">
      <div class="max-w-4xl mx-auto">
        <div class="glass-card rounded-3xl p-10 md:p-14 border-glow text-center relative overflow-hidden reveal">
          <div class="absolute inset-0 rounded-3xl" style="background: radial-gradient(ellipse at center, rgba(10,39,69,0.5) 0%, transparent 70%);"></div>
          <div class="relative z-10">
            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-vitality-cyan/20 to-vitality-blue mx-auto mb-6 flex items-center justify-center text-3xl animate-float">👨‍⚕️</div>
            <h3 class="font-serif text-2xl font-light text-white mb-1">Dr. Éric Rosati</h3>
            <p class="text-vitality-cyan text-sm mb-6">Osteopath · Doctor of Quantum Medicine · Founder of Vitality Inside</p>
            <p class="text-vitality-text leading-relaxed max-w-2xl mx-auto mb-8">
              With over 25 years of clinical practice and more than a decade of research in frequency medicine, Dr. Rosati founded Vitality Inside around a single conviction: the body's deepest intelligence speaks in energetic frequencies. Every protocol in the Vitality library is the product of his personal clinical experience and scientific rigor.
            </p>
            <div class="flex items-center justify-center gap-8 mb-8 text-center">
              <div>
                <p class="font-serif text-3xl font-light text-vitality-gold">25+</p>
                <p class="text-vitality-text text-xs">Years of practice</p>
              </div>
              <div class="w-px h-10 bg-white/10"></div>
              <div>
                <p class="font-serif text-3xl font-light text-vitality-gold">60+</p>
                <p class="text-vitality-text text-xs">Protocols created</p>
              </div>
              <div class="w-px h-10 bg-white/10"></div>
              <div>
                <p class="font-serif text-3xl font-light text-vitality-gold">21k+</p>
                <p class="text-vitality-text text-xs">Patients helped</p>
              </div>
            </div>
            <a :href="`mailto:rosati.eric@gmail.com?subject=Rejoindre+la+Communaute+Vitality+Inside`" class="btn-outline inline-flex">Join the Community</a>
          </div>
        </div>
      </div>
    </section>

    <!-- FINAL CTA -->
    <section class="py-24 px-4">
      <div class="max-w-3xl mx-auto text-center reveal">
        <h2 class="section-title text-white mb-4">A better life starts with<br><em class="text-gradient-cyan not-italic">one frequency.</em></h2>
        <p class="text-vitality-text text-lg mb-10">Browse our programs, subscribe for unlimited access, or book a personalized consultation with Dr. Éric Rosati.</p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
          <Link :href="route('shop')" class="btn-cyan text-base px-8 py-3.5">Explore All Programs</Link>
          <Link :href="route('consultation')" class="btn-gold text-base px-8 py-3.5">Book a Consultation — €58</Link>
        </div>
      </div>
    </section>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import ProgramCard from '@/Components/ProgramCard.vue'
import { Link } from '@inertiajs/vue3'
import { onMounted } from 'vue'

defineProps({
  featuredPrograms: Array,
  categories: Array,
  testimonials: { type: Array, default: () => [] },
})

onMounted(() => {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); } })
  }, { threshold: 0.12 })
  document.querySelectorAll('.reveal').forEach(el => observer.observe(el))
})

const steps = [
  { icon: '🎯', title: 'Choose your program', desc: 'Browse 60+ protocols organized by health category. Each card shows full description, protocol details, and client reviews.' },
  { icon: '📧', title: 'Receive your link', desc: 'After checkout, your secure program link arrives by email. Accessible immediately on any connected device.' },
  { icon: '🎧', title: 'Put on your headphones', desc: 'Bone-conduction headphones required. Schedule a quiet 18–35 minute session daily. The Vitality wave works below perception.' },
  { icon: '📈', title: 'Track your progress', desc: 'Follow your 21–30 day protocol and observe the cumulative effect. Book a consultation for a fully personalized approach.' },
]

const areas = [
  { icon: '🦴', name: 'Locomotor',   examples: 'Lumbago · Osteoarthritis · Tendinitis · Joint pain' },
  { icon: '🫁', name: 'Digestive',   examples: 'Constipation · Gastric acidity · Liver drainage' },
  { icon: '💚', name: 'Emotional',   examples: 'Anxiety · Burn-out · Self-confidence · Depression' },
  { icon: '👂', name: 'ENT & Immunity', examples: 'Sleep apnea · Immune defence · Allergy · Tinnitus' },
  { icon: '⚡', name: 'Hormonal',    examples: 'Menstrual cycles · Menopause · Libido · Weight' },
  { icon: '🧠', name: 'Neurological', examples: 'Memory · Concentration · Migraine · Sleep' },
]
</script>
