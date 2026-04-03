<template>
  <AppLayout>

    <!-- ═══ HERO ═══ -->
    <section class="relative min-h-screen flex flex-col items-center justify-center overflow-hidden text-center px-6 pt-16">
      <!-- Subtle radial glow in background -->
      <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse 80% 60% at 50% 40%, rgba(17,199,201,0.06) 0%, transparent 70%);"></div>

      <!-- Title block — TRÈS grand, exactement comme live -->
      <div class="relative z-10 max-w-4xl mx-auto w-full">
        <h1 class="font-serif font-light leading-[1.05] mb-8"
          style="font-size: clamp(3.2rem, 8vw, 6.5rem); color: #F5F3EE;">
          Your body speaks<br>
          <em style="color: #D5B67A; font-style: italic;">in frequencies.</em><br>
          We listen.
        </h1>

        <p class="text-[#9DAAC0] text-base md:text-lg max-w-2xl mx-auto leading-relaxed mb-10">
          Vibrational cell rebalancing through bio-resonance — a science-backed approach that turns your brain into a natural medicine box. Over 60 targeted programs, delivered to your device.
        </p>

        <!-- STATS — 3 cards puis 1 centré dessous (exactement comme live) -->
        <div class="flex flex-col items-center gap-4 mb-10">
          <div class="grid grid-cols-3 gap-4 w-full max-w-2xl">
            <div v-for="stat in statsTop" :key="stat.label"
              class="rounded-xl border border-white/10 py-6 px-4 text-center"
              style="background: rgba(10,39,69,0.7);">
              <p class="font-serif font-light mb-1" style="color: #D5B67A; font-size: 1.8rem;">{{ stat.value }}</p>
              <p class="text-[10px] font-semibold tracking-[0.15em] uppercase" style="color: #9DAAC0;">{{ stat.label }}</p>
            </div>
          </div>
          <div class="rounded-xl border border-white/10 py-6 px-12 text-center"
            style="background: rgba(10,39,69,0.7);">
            <p class="font-serif font-light mb-1" style="color: #D5B67A; font-size: 1.8rem;">&lt; 8h</p>
            <p class="text-[10px] font-semibold tracking-[0.15em] uppercase" style="color: #9DAAC0;">Protocol Delivery</p>
          </div>
        </div>

        <!-- CTAs -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
          <Link :href="route('shop')"
            class="bg-[#11C7C9] hover:bg-[#0db5b7] text-[#03142A] font-bold text-sm tracking-wide uppercase px-8 py-3.5 rounded transition-all">
            Explore Programs
          </Link>
          <Link :href="route('consultation')"
            class="border border-white/30 text-white hover:border-white/60 text-sm font-semibold px-8 py-3.5 rounded transition-all">
            Book a Consultation
          </Link>
        </div>

        <!-- Discover scroll indicator -->
        <div class="mt-16 flex flex-col items-center gap-2 text-white/30">
          <span class="text-[10px] tracking-[0.2em] uppercase">Discover</span>
          <svg class="w-4 h-4 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
          </svg>
        </div>
      </div>
    </section>

    <!-- ═══ 4 STEPS — exactement comme le live ═══ -->
    <section class="py-24 px-6">
      <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-16">
          <p class="text-[#11C7C9] text-[11px] font-semibold tracking-[0.2em] uppercase mb-4">Simple &amp; Accessible</p>
          <h2 class="font-serif font-light text-white" style="font-size: clamp(2rem, 4vw, 3rem);">
            Your protocol in <em style="color: #D5B67A; font-style: italic;">4 steps</em>
          </h2>
        </div>

        <!-- 4 cards avec badge numéro cercle teal -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
          <div v-for="(step, i) in steps" :key="i"
            class="rounded-2xl p-7 flex flex-col border border-white/8"
            style="background: rgba(10,39,69,0.5);">
            <!-- Cercle numéro teal -->
            <div class="w-11 h-11 rounded-full bg-[#11C7C9] flex items-center justify-center text-[#03142A] font-bold text-base mb-6">
              {{ i + 1 }}
            </div>
            <h3 class="font-serif text-white font-normal text-lg mb-3">{{ step.title }}</h3>
            <p class="text-[#9DAAC0] text-sm leading-relaxed flex-1">{{ step.desc }}</p>
            <!-- Badge bas de card -->
            <div class="mt-6">
              <span class="inline-flex items-center gap-1.5 text-[10px] font-semibold tracking-[0.12em] uppercase text-[#11C7C9] border border-[#11C7C9]/30 rounded-full px-3 py-1">
                <span class="text-xs">{{ step.icon }}</span>
                {{ step.badge }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══ AREAS OF ACTION — gauche texte + droite grille 3x2 ═══ -->
    <section class="py-24 px-6" style="background: rgba(4,27,51,0.4);">
      <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">

          <!-- Gauche: texte -->
          <div>
            <p class="text-[#11C7C9] text-[11px] font-semibold tracking-[0.2em] uppercase mb-5">Areas of Action</p>
            <h2 class="font-serif font-light text-white mb-3" style="font-size: clamp(2rem, 4vw, 3rem); line-height: 1.15;">
              Your body's<br>
              <em style="color: #D5B67A; font-style: italic;">complete system</em>
            </h2>
            <p class="text-[#9DAAC0] leading-relaxed mb-4">
              This method — turning your brain into a natural medicine box — addresses the full spectrum of frequently encountered health challenges, from structural to emotional to hormonal.
            </p>
            <p class="text-[#9DAAC0] leading-relaxed mb-8">
              Each program targets a specific bio-energetic disruption identified through decades of clinical practice by Dr. Éric Rosati.
            </p>
            <Link :href="route('shop')"
              class="inline-flex bg-[#11C7C9] hover:bg-[#0db5b7] text-[#03142A] font-bold text-sm tracking-wide uppercase px-7 py-3 rounded transition-all">
              Browse All 60+ Programs
            </Link>
          </div>

          <!-- Droite: grille 3x2 cards -->
          <div class="grid grid-cols-3 gap-3">
            <div v-for="area in areas" :key="area.name"
              class="rounded-xl p-4 border border-white/8 hover:border-white/20 transition-all cursor-pointer group"
              style="background: rgba(10,39,69,0.6);">
              <div class="text-2xl mb-2">{{ area.icon }}</div>
              <h4 class="font-semibold text-sm mb-1.5 group-hover:text-[#11C7C9] transition-colors" style="color: #D5B67A;">{{ area.name }}</h4>
              <p class="text-[#9DAAC0] text-[11px] leading-relaxed">{{ area.examples }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══ FEATURED PROGRAMS ═══ -->
    <section class="py-24 px-6">
      <div class="max-w-6xl mx-auto">
        <div class="flex items-end justify-between mb-12">
          <div>
            <p class="text-[#11C7C9] text-[11px] font-semibold tracking-[0.2em] uppercase mb-4">Most Popular</p>
            <h2 class="font-serif font-light text-white" style="font-size: clamp(1.8rem, 3.5vw, 2.6rem);">
              Featured <em style="color: #D5B67A; font-style: italic;">programs</em>
            </h2>
          </div>
          <Link :href="route('shop')" class="hidden md:inline-flex text-[#11C7C9] text-sm hover:underline items-center gap-1">
            View all 60+ programs →
          </Link>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
          <ProgramCard v-for="program in featuredPrograms" :key="program.id" :program="program" />
        </div>
      </div>
    </section>

    <!-- ═══ UNLIMITED ACCESS — card verte exactement comme live ═══ -->
    <section class="py-6 px-6 pb-24">
      <div class="max-w-6xl mx-auto">
        <div class="rounded-2xl p-10 md:p-14 flex flex-col md:flex-row items-center md:items-start justify-between gap-10"
          style="background: linear-gradient(135deg, #071F3D 0%, #0A2745 50%, #071F3D 100%); border: 1px solid rgba(213,182,122,0.15);">
          <div class="flex-1">
            <p class="text-[#11C7C9] text-[11px] font-semibold tracking-[0.2em] uppercase mb-4">Unlimited Access</p>
            <h2 class="font-serif font-light text-white mb-4" style="font-size: clamp(1.6rem, 3vw, 2.4rem); line-height: 1.2;">
              Access every program.<br>Every month. One price.
            </h2>
            <p class="text-[#9DAAC0] text-sm leading-relaxed max-w-md">
              Subscribe for unlimited access to the full Vitality Inside library — 60+ programs, new protocols monthly, and priority support. Cancel anytime.
            </p>
          </div>
          <div class="flex flex-col items-center md:items-end gap-5 flex-shrink-0">
            <div class="text-right">
              <p class="font-serif font-light" style="color: #D5B67A; font-size: 2.8rem; line-height: 1;">€29.90</p>
              <p class="text-[#9DAAC0] text-xs tracking-wide">per month · cancel anytime</p>
            </div>
            <Link :href="route('shop')"
              class="bg-[#11C7C9] hover:bg-[#0db5b7] text-[#03142A] font-bold text-sm tracking-wide uppercase px-7 py-3.5 rounded transition-all whitespace-nowrap">
              Start Unlimited Access
            </Link>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══ TESTIMONIALS — Infinite Marquee ═══ -->
    <section class="py-20 overflow-hidden" style="background: rgba(4,27,51,0.3);">
      <div class="text-center mb-12 px-6">
        <p class="text-[#11C7C9] text-[11px] font-semibold tracking-[0.2em] uppercase mb-4">Community</p>
        <h2 class="font-serif font-light text-white" style="font-size: clamp(1.8rem, 3.5vw, 2.6rem);">
          What our community <em style="color: #D5B67A; font-style: italic;">experiences</em>
        </h2>
      </div>
      <div class="relative">
        <div class="flex gap-5 animate-scroll-x" style="width: max-content;">
          <div v-for="(t, idx) in [...(testimonials||[]), ...(testimonials||[])]" :key="idx"
            class="rounded-xl p-6 flex flex-col gap-3 flex-shrink-0 border border-white/8"
            style="width: 290px; background: rgba(10,39,69,0.6);">
            <div style="color: #D5B67A; font-size: 0.8rem;">★★★★★</div>
            <p class="text-white/75 text-sm italic leading-relaxed flex-1">"{{ t.content }}"</p>
            <div>
              <p class="text-white font-semibold text-sm">{{ t.name }}</p>
              <p class="text-[11px]" style="color: #11C7C9;">· {{ t.program }}</p>
            </div>
          </div>
        </div>
        <div class="absolute inset-y-0 left-0 w-28 pointer-events-none" style="background: linear-gradient(to right, #03142A, transparent);"></div>
        <div class="absolute inset-y-0 right-0 w-28 pointer-events-none" style="background: linear-gradient(to left, #03142A, transparent);"></div>
      </div>
    </section>

    <!-- ═══ DR ROSATI ═══ -->
    <section class="py-24 px-6">
      <div class="max-w-4xl mx-auto text-center">
        <div class="rounded-3xl p-10 md:p-14 border border-white/8" style="background: rgba(10,39,69,0.5);">
          <div class="w-20 h-20 rounded-full mx-auto mb-6 flex items-center justify-center text-3xl animate-float"
            style="background: rgba(17,199,201,0.1);">👨‍⚕️</div>
          <h3 class="font-serif text-2xl font-light text-white mb-1">Dr. Éric Rosati</h3>
          <p class="text-[11px] font-semibold tracking-widest uppercase mb-6" style="color: #11C7C9;">
            Osteopath · Doctor of Quantum Medicine · Founder of Vitality Inside
          </p>
          <p class="text-[#9DAAC0] leading-relaxed max-w-2xl mx-auto mb-8">
            With over 25 years of clinical practice and more than a decade of research in frequency medicine, Dr. Rosati founded Vitality Inside around a single conviction: the body's deepest intelligence speaks in energetic frequencies.
          </p>
          <div class="flex items-center justify-center gap-10 mb-10">
            <div>
              <p class="font-serif font-light" style="color: #D5B67A; font-size: 2rem;">25+</p>
              <p class="text-[#9DAAC0] text-xs uppercase tracking-widest">Years of practice</p>
            </div>
            <div class="w-px h-10 bg-white/10"></div>
            <div>
              <p class="font-serif font-light" style="color: #D5B67A; font-size: 2rem;">60+</p>
              <p class="text-[#9DAAC0] text-xs uppercase tracking-widest">Protocols created</p>
            </div>
            <div class="w-px h-10 bg-white/10"></div>
            <div>
              <p class="font-serif font-light" style="color: #D5B67A; font-size: 2rem;">21k+</p>
              <p class="text-[#9DAAC0] text-xs uppercase tracking-widest">Users worldwide</p>
            </div>
          </div>
          <Link :href="route('consultation')"
            class="inline-flex border border-white/30 text-white hover:border-white/60 text-sm font-semibold px-8 py-3 rounded transition-all">
            Book a Consultation
          </Link>
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
  featuredPrograms: { type: Array, default: () => [] },
  categories:       { type: Array, default: () => [] },
  testimonials:     { type: Array, default: () => [] },
})

onMounted(() => {
  const io = new IntersectionObserver(
    entries => entries.forEach(e => e.isIntersecting && e.target.classList.add('visible')),
    { threshold: 0.1 }
  )
  document.querySelectorAll('.reveal').forEach(el => io.observe(el))
})

const statsTop = [
  { value: '21,000+', label: 'Active Users' },
  { value: '60+',     label: 'Programs' },
  { value: '25 yrs',  label: 'Clinical Experience' },
]

const steps = [
  { icon: '🛒', badge: 'Instant Access',   title: 'Choose your program', desc: 'Browse 60+ protocols organized by health category. Each card shows full description, protocol details, and client reviews.' },
  { icon: '📧', badge: 'Within Minutes',   title: 'Receive your link',   desc: 'After checkout, your secure program link arrives by email. Accessible immediately on any connected device — mobile or desktop.' },
  { icon: '🎧', badge: '18-35 Min/Day',    title: 'Put on your headphones', desc: 'Bone-conduction headphones required. Schedule a quiet 18–35 minute session daily. The Vitality wave is not audible — it works below perception.' },
  { icon: '📈', badge: '21-30 Day Cure',   title: 'Track your progress', desc: 'Follow your 21–30 day protocol and observe the cumulative effect. Book a consultation for a fully personalized approach to complex conditions.' },
]

const areas = [
  { icon: '🦴', name: 'Locomotor',      examples: 'Lumbago · Osteoarthritis · Tendinitis · Joint pain' },
  { icon: '🌿', name: 'Digestive',      examples: 'Constipation · Gastric acidity · Liver drainage' },
  { icon: '�', name: 'Emotional',      examples: 'Anxiety · Burn-out · Self-confidence · Depression' },
  { icon: '�', name: 'ENT & Immunity', examples: 'Sleep apnea · Immune defence · Allergy · Tinnitus' },
  { icon: '🌸', name: 'Hormonal',       examples: 'Menstrual cycles · Menopause · Libido · Weight' },
  { icon: '🧠', name: 'Neurological',   examples: 'Memory · Concentration · Migraine · Sleep' },
]
</script>
