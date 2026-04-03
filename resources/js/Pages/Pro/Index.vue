<template>
  <AppLayout>
    <!-- Background -->
    <div class="fixed inset-0 pointer-events-none z-0">
      <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[500px] rounded-full opacity-10"
        style="background: radial-gradient(ellipse, #D5B67A 0%, transparent 70%);"></div>
    </div>

    <!-- Hero -->
    <section class="relative pt-32 pb-16 px-4 text-center z-10">
      <div class="inline-flex items-center gap-2 glass-card border border-vitality-gold/30 text-vitality-gold rounded-full px-5 py-2 text-xs font-semibold tracking-widest uppercase mb-8 reveal visible">
        ⭐ Espace Professionnel
      </div>
      <h1 class="section-title text-white mb-4 reveal visible" style="font-size:clamp(2.2rem,5vw,3.5rem)">
        Espace Professionnel<br><em class="text-gradient-gold not-italic">Portail exclusif</em>
      </h1>
      <p class="text-vitality-text text-lg max-w-2xl mx-auto leading-relaxed mb-10 reveal visible delay-200">
        Portail exclusif pour les professionnels de santé partenaires. Accédez à 37 protocoles Pro avec fiches cliniques et gérez vos patients.
      </p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center reveal visible delay-300">
        <Link v-if="$page.props.auth.user?.is_pro" :href="route('pro.dashboard')" class="btn-gold text-base px-8 py-3.5">
          Mon Dashboard PRO →
        </Link>
        <Link v-else-if="$page.props.auth.user" :href="route('pro.dashboard')" class="btn-gold text-base px-8 py-3.5">
          Accéder à l'espace PRO →
        </Link>
        <Link :href="route('shop')" class="btn-outline text-base px-8 py-3.5">Explorer les programmes</Link>
      </div>
    </section>

    <!-- Main content: Login + Protocols -->
    <section class="px-4 pb-20 max-w-6xl mx-auto z-10 relative">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

        <!-- Login card -->
        <div class="glass-card rounded-3xl p-8 border border-vitality-gold/20 reveal visible">
          <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-xl bg-vitality-gold/10 flex items-center justify-center text-xl">🔒</div>
            <div>
              <h2 class="text-white font-semibold">Connexion Pro</h2>
              <p class="text-vitality-text text-xs">Accès réservé aux professionnels partenaires</p>
            </div>
          </div>

          <!-- Demo credentials banner -->
          <div class="bg-vitality-gold/10 border border-vitality-gold/20 rounded-xl px-4 py-3 mb-6 text-xs text-vitality-gold">
            Demo : <strong>pro@vitalityinside.com</strong> / <strong>ProVitality2025!</strong>
          </div>

          <div v-if="$page.props.auth.user && $page.props.auth.user.is_pro"
            class="text-center py-6">
            <div class="text-4xl mb-3">✅</div>
            <p class="text-white font-semibold mb-4">Vous êtes connecté en tant que PRO</p>
            <Link :href="route('pro.dashboard')" class="btn-gold inline-flex px-6 py-3 text-sm">
              Accéder au Dashboard →
            </Link>
          </div>

          <div v-else-if="$page.props.auth.user"
            class="text-center py-6">
            <div class="text-4xl mb-3">👤</div>
            <p class="text-white font-semibold mb-2">{{ $page.props.auth.user.name }}</p>
            <p class="text-vitality-text text-sm mb-4">Votre compte n'a pas l'accès PRO. Contactez-nous pour l'activer.</p>
            <Link :href="route('pro.dashboard')" class="btn-gold inline-flex px-6 py-3 text-sm mr-3">
              Tester l'accès →
            </Link>
            <a href="mailto:rosati.eric@gmail.com?subject=Demande+Acces+PRO" class="btn-outline inline-flex px-6 py-3 text-sm">
              Contacter →
            </a>
          </div>

          <form v-else @submit.prevent="submitLogin" class="space-y-4">
            <div v-if="loginForm.errors.email" class="bg-red-500/10 border border-red-500/30 rounded-xl p-3 text-red-400 text-sm">
              {{ loginForm.errors.email }}
            </div>
            <div>
              <label class="text-vitality-text text-xs mb-1.5 block">Email professionnel</label>
              <input v-model="loginForm.email" type="email" required
                class="w-full bg-[#071F3D] border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-vitality-gold/50"
                placeholder="pro@cabinet.com" />
            </div>
            <div>
              <label class="text-vitality-text text-xs mb-1.5 block">Mot de passe</label>
              <input v-model="loginForm.password" type="password" required
                class="w-full bg-[#071F3D] border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-vitality-gold/50"
                placeholder="••••••••" />
            </div>
            <button type="submit" :disabled="loginForm.processing"
              class="btn-gold w-full py-3.5 text-sm disabled:opacity-50">
              {{ loginForm.processing ? 'Connexion...' : 'Se connecter à l\'espace PRO' }}
            </button>
            <p class="text-center text-vitality-text text-xs">
              Pas encore partenaire ?
              <a href="mailto:rosati.eric@gmail.com?subject=Demande+Acces+PRO+Vitality+Inside" class="text-vitality-gold hover:underline">Demander l'accès →</a>
            </p>
          </form>
        </div>

        <!-- Right side: Benefits -->
        <div class="space-y-4">
          <h2 class="font-serif text-2xl text-white font-light mb-6 reveal visible">
            37 Protocoles Pro<br><em class="text-gradient-gold not-italic">+ Gestion patients</em>
          </h2>
          <div v-for="(b, i) in benefits" :key="b.title"
            class="glass-card rounded-2xl p-5 card-hover flex items-start gap-4 reveal visible"
            :class="`delay-${(i+1)*100}`">
            <div class="w-10 h-10 rounded-xl bg-vitality-gold/10 flex items-center justify-center text-xl flex-shrink-0">{{ b.icon }}</div>
            <div>
              <h3 class="text-white font-semibold text-sm mb-1">{{ b.title }}</h3>
              <p class="text-vitality-text text-xs leading-relaxed">{{ b.desc }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Stats Band -->
    <section class="py-16 px-4 border-y border-white/5 bg-[#041B33]/40 z-10 relative">
      <div class="max-w-4xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
        <div v-for="stat in stats" :key="stat.label" class="reveal visible">
          <p class="font-serif text-3xl font-light text-vitality-gold mb-1">{{ stat.value }}</p>
          <p class="text-vitality-text text-xs">{{ stat.label }}</p>
        </div>
      </div>
    </section>

    <!-- Pricing -->
    <section class="py-20 px-4 max-w-4xl mx-auto z-10 relative">
      <div class="text-center mb-12">
        <h2 class="section-title text-white">Tarifs <em class="text-gradient-gold not-italic">professionnels</em></h2>
        <p class="text-vitality-text mt-3">Programmes à -20% · Support dédié · Commission sur recommandations patients</p>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div v-for="(p, i) in proPlans" :key="p.name"
          class="glass-card rounded-2xl p-6 text-center card-hover reveal visible border"
          :class="[`delay-${(i+1)*100}`, i === 1 ? 'border-vitality-gold/40' : 'border-transparent']">
          <div v-if="i===1" class="text-[10px] font-bold text-vitality-bg bg-vitality-gold rounded-full px-3 py-1 inline-block mb-3 uppercase tracking-wider">
            Recommandé
          </div>
          <p class="text-white font-semibold mb-2">{{ p.name }}</p>
          <p class="text-vitality-gold font-bold text-3xl my-3">{{ p.price }}</p>
          <p class="text-vitality-text text-xs mb-4">{{ p.desc }}</p>
          <a href="mailto:rosati.eric@gmail.com?subject=Demande+Acces+PRO" class="btn-gold text-xs px-5 py-2.5 inline-flex">Choisir</a>
        </div>
      </div>
    </section>

    <!-- Who is it for -->
    <section class="pb-24 px-4 max-w-5xl mx-auto z-10 relative">
      <div class="text-center mb-10">
        <h2 class="section-title text-white">Pour qui est<br><em class="text-gradient-gold not-italic">l'espace PRO ?</em></h2>
      </div>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div v-for="prof in professions" :key="prof"
          class="glass-card rounded-xl p-4 text-center text-sm text-vitality-text card-hover hover:text-white transition-colors">
          {{ prof }}
        </div>
      </div>
    </section>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'

const loginForm = useForm({ email: '', password: '', remember: false })
const submitLogin = () => loginForm.post(route('login'))

const benefits = [
  { icon: '📋', title: '37 Protocoles Pro', desc: 'Accès complet aux protocoles avec fiches cliniques et indications thérapeutiques détaillées.' },
  { icon: '�', title: 'Gestion Patients', desc: 'Suivez vos patients, assignez des protocoles personnalisés et monitorez leur progression.' },
  { icon: '💰', title: 'Commission 20%', desc: 'Générez des revenus passifs en recommandant les programmes à vos patients.' },
  { icon: '🔬', title: 'Ressources Cliniques', desc: 'Documentation PDF exclusive, cas cliniques et directives de protocoles du Dr. Rosati.' },
  { icon: '📞', title: 'Support Prioritaire', desc: 'Ligne directe avec le Dr. Rosati. Groupe WhatsApp pour les praticiens certifiés.' },
]

const proPlans = [
  { name: 'Programme Unique', price: '€23.92', desc: 'par programme (20% off)' },
  { name: 'Bundle Mensuel',   price: '€89/mo', desc: '5 programmes/mois + support' },
  { name: 'Accès Complet',    price: '€199/mo', desc: 'Programmes illimités + dashboard' },
]

const professions = [
  '🏥 Ostéopathes', '💆 Naturopathes', '🧘 Coachs Bien-être', '🩺 Thérapeutes',
  '🌿 Nutritionnistes', '🧠 Psychologues', '💊 Médecins Intégratifs', '🎯 Life Coaches',
]

const stats = [
  { value: '37', label: 'Protocoles Pro' },
  { value: '20%', label: 'Commission patient' },
  { value: '500+', label: 'Praticiens partenaires' },
  { value: '21k+', label: 'Utilisateurs actifs' },
]
</script>
