<template>
  <AppLayout>
    <!-- Hero -->
    <section class="pt-32 pb-16 px-4 relative text-center">
      <div class="absolute inset-0 halo-glow pointer-events-none"></div>
      <div class="inline-flex items-center gap-2 glass-card border border-vitality-gold/30 text-vitality-gold rounded-full px-4 py-2 text-xs font-semibold tracking-widest uppercase mb-8">
        ⭐ Espace Professionnel
      </div>
      <h1 class="section-title text-white mb-4">Prescribe bio-energy<br><em class="text-gradient-gold not-italic">with confidence</em></h1>
      <p class="text-vitality-text text-lg max-w-2xl mx-auto leading-relaxed mb-10">
        Access the full Vitality Inside library at a professional rate. Manage your patients, assign frequency protocols, and track their progress — all from one dashboard.
      </p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <Link v-if="$page.props.auth.user?.is_pro" :href="route('pro.dashboard')" class="btn-cyan text-base px-8 py-3.5">My PRO Dashboard →</Link>
        <a v-else href="mailto:rosati.eric@gmail.com?subject=Demande+Acces+PRO+Vitality+Inside" class="btn-gold text-base px-8 py-3.5">Request PRO Access</a>
        <Link :href="route('shop')" class="btn-outline text-base px-8 py-3.5">Explore Programs</Link>
      </div>
    </section>

    <!-- PRO Benefits -->
    <section class="px-4 pb-20 max-w-5xl mx-auto">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div v-for="b in benefits" :key="b.title" class="glass-card rounded-2xl p-6 card-hover">
          <div class="text-3xl mb-4">{{ b.icon }}</div>
          <h3 class="text-white font-semibold mb-2">{{ b.title }}</h3>
          <p class="text-vitality-text text-sm leading-relaxed">{{ b.desc }}</p>
        </div>
      </div>
    </section>

    <!-- Pricing for PRO -->
    <section class="px-4 pb-20 max-w-4xl mx-auto">
      <div class="glass-card rounded-3xl p-10 border border-vitality-gold/20 text-center">
        <h2 class="font-serif text-2xl text-white font-light mb-3">Professional Pricing</h2>
        <p class="text-vitality-text mb-8">Programs at 20% discount · Dedicated support · Commission on patient referrals</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
          <div v-for="p in proPlans" :key="p.name" class="glass-card rounded-2xl p-5 text-center">
            <p class="text-white font-semibold">{{ p.name }}</p>
            <p class="text-vitality-gold font-bold text-2xl my-2">{{ p.price }}</p>
            <p class="text-vitality-text text-xs">{{ p.desc }}</p>
          </div>
        </div>
        <a href="mailto:rosati.eric@gmail.com?subject=Demande+Acces+PRO" class="btn-gold inline-flex text-base px-8 py-3.5">Contact Us to Join</a>
      </div>
    </section>

    <!-- Who is it for -->
    <section class="px-4 pb-24 max-w-4xl mx-auto">
      <div class="text-center mb-10">
        <h2 class="section-title text-white">Who is the <em class="text-gradient-gold not-italic">PRO space</em> for?</h2>
      </div>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div v-for="prof in professions" :key="prof" class="glass-card rounded-xl p-4 text-center text-sm text-vitality-text">{{ prof }}</div>
      </div>
    </section>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'

const benefits = [
  { icon: '📋', title: 'Patient Management', desc: 'Create and manage patient files. Store health history, notes, and track progress across multiple protocols.' },
  { icon: '🎯', title: 'Protocol Assignment', desc: 'Assign any program from the Vitality library to any patient, with personalized notes and follow-up.' },
  { icon: '📊', title: 'Progress Tracking', desc: 'Monitor each patient\'s protocol progress in real-time. Get alerts for session completions.' },
  { icon: '💰', title: '20% Commission', desc: 'Earn 20% commission on every program your patients purchase through your professional link.' },
  { icon: '🔬', title: 'Clinical Resources', desc: 'Access exclusive PDF documentation, clinical case studies, and Dr. Rosati\'s protocol guidelines.' },
  { icon: '📞', title: 'Priority Support', desc: 'Direct line to Dr. Rosati for complex cases. WhatsApp group for all certified Vitality PRO practitioners.' },
]

const proPlans = [
  { name: 'Single Program',    price: '€23.92', desc: 'per program (20% off)' },
  { name: 'Monthly Bundle',   price: '€89/mo', desc: '5 programs/month + support' },
  { name: 'Full Access',      price: '€199/mo', desc: 'Unlimited programs + dashboard' },
]

const professions = [
  '🏥 Osteopaths', '💆 Naturopaths', '🧘 Wellness Coaches', '🩺 Holistic Therapists',
  '🌿 Nutritionists', '🧠 Psychologists', '💊 Integrative MDs', '🎯 Life Coaches',
]
</script>
