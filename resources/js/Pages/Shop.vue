<template>
  <AppLayout>

    <!-- ═══ HERO bilingue ═══ -->
    <section class="pt-32 pb-16 px-6 text-center relative overflow-hidden">
      <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse 80% 50% at 50% 0%, rgba(17,199,201,0.07) 0%, transparent 70%);"></div>
      <div class="relative z-10 max-w-4xl mx-auto">
        <p class="text-[11px] font-semibold tracking-[0.2em] uppercase mb-5" style="color: #11C7C9;">60+ Programmes</p>
        <h1 class="font-serif font-light text-white mb-2" style="font-size: clamp(2rem, 5vw, 3.5rem); line-height: 1.15;">
          Guérissez de l'intérieur.<br>
          <em style="color: #D5B67A; font-style: italic;">Heal from within.</em>
        </h1>
        <p class="font-serif font-light mb-8" style="font-size: clamp(1.1rem, 2.5vw, 1.6rem); color: rgba(157,170,192,0.6);">
          Son après son. <em style="font-style: italic;">Sound by sound.</em>
        </p>
        <p class="text-[#9DAAC0] text-base max-w-2xl mx-auto mb-8 leading-relaxed">
          Sélectionnez votre programme, écoutez avec des écouteurs, et laissez votre corps se recalibrer.<br class="hidden md:block">
          <span class="text-white/40">Select your program, listen with headphones, and let your body recalibrate.</span><br>
          Over 21,000 people use our frequency protocols to restore balance — naturally.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-10">
          <a href="#programs"
            class="bg-[#11C7C9] hover:bg-[#0db5b7] text-[#03142A] font-bold text-sm tracking-wide uppercase px-8 py-3.5 rounded transition-all">
            Explorer les programmes
          </a>
          <a href="#plans"
            class="border border-white/30 text-white hover:border-white/60 text-sm font-semibold px-8 py-3.5 rounded transition-all">
            Accès Illimité →
          </a>
        </div>
        <!-- Stats inline -->
        <div class="flex items-center justify-center gap-10">
          <div class="text-center">
            <p class="font-serif font-light text-2xl" style="color: #11C7C9;">60+</p>
            <p class="text-[10px] font-semibold uppercase tracking-widest mt-0.5" style="color: #9DAAC0;">Programmes</p>
          </div>
          <div class="w-px h-8" style="background: rgba(255,255,255,0.1);"></div>
          <div class="text-center">
            <p class="font-serif font-light text-2xl" style="color: #11C7C9;">21k+</p>
            <p class="text-[10px] font-semibold uppercase tracking-widest mt-0.5" style="color: #9DAAC0;">Utilisateurs</p>
          </div>
          <div class="w-px h-8" style="background: rgba(255,255,255,0.1);"></div>
          <div class="text-center">
            <p class="font-serif font-light text-2xl" style="color: #11C7C9;">25 min</p>
            <p class="text-[10px] font-semibold uppercase tracking-widest mt-0.5" style="color: #9DAAC0;">Par session</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══ PLANS D'ACCÈS ═══ -->
    <section id="plans" class="py-20 px-6" style="background: rgba(4,27,51,0.4);">
      <div class="max-w-5xl mx-auto">
        <div class="text-center mb-12">
          <p class="text-[11px] font-semibold tracking-[0.2em] uppercase mb-4" style="color: #11C7C9;">Plans d'accès</p>
          <h2 class="font-serif font-light text-white" style="font-size: clamp(1.8rem, 3.5vw, 2.6rem);">
            Choisissez votre<br><em style="color: #D5B67A; font-style: italic;">expérience d'écoute</em>
          </h2>
          <p class="text-[#9DAAC0] mt-3 text-sm">D'un protocole ciblé à un accès illimité — trouvez la formule qui vous convient.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div v-for="plan in accessPlans" :key="plan.id"
            class="rounded-2xl p-7 flex flex-col relative"
            :style="plan.featured
              ? 'background: rgba(10,39,69,0.9); border: 2px solid #11C7C9; box-shadow: 0 0 40px rgba(17,199,201,0.1);'
              : 'background: rgba(10,39,69,0.5); border: 1px solid rgba(255,255,255,0.08);'">
            <div v-if="plan.badge" class="absolute -top-3 left-1/2 -translate-x-1/2">
              <span class="text-[10px] font-bold tracking-widest uppercase px-3 py-1 rounded-full" style="background: #11C7C9; color: #03142A;">{{ plan.badge }}</span>
            </div>
            <h3 class="font-serif text-white text-lg font-light mb-1 mt-2">{{ plan.name }}</h3>
            <p class="text-xs mb-5" style="color: #9DAAC0;">{{ plan.tagline }}</p>
            <ul class="space-y-2 mb-6 flex-1">
              <li v-for="f in plan.features" :key="f" class="flex items-start gap-2 text-xs" style="color: #9DAAC0;">
                <span class="flex-shrink-0" style="color: #D5B67A;">✦</span>{{ f }}
              </li>
            </ul>
            <div class="mb-4">
              <p class="font-serif font-light" style="color: #D5B67A; font-size: 1.6rem; line-height: 1;">{{ plan.price }}</p>
            </div>
            <Link :href="route('shop')"
              class="w-full text-center font-bold text-sm tracking-wide uppercase py-3 rounded transition-all block"
              :style="plan.featured ? 'background: #11C7C9; color: #03142A;' : 'border: 1px solid rgba(255,255,255,0.2); color: white;'">
              {{ plan.cta }}
            </Link>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══ TROUVEZ VOTRE PROTOCOLE ═══ -->
    <section id="programs" class="py-16 px-6">
      <div class="max-w-6xl mx-auto">
        <div class="flex items-end justify-between mb-8">
          <div>
            <p class="text-[11px] font-semibold tracking-[0.2em] uppercase mb-3" style="color: #11C7C9;">Bibliothèque de Programmes</p>
            <h2 class="font-serif font-light text-white" style="font-size: clamp(1.8rem, 3.5vw, 2.6rem);">
              Trouvez votre <em style="color: #D5B67A; font-style: italic;">protocole</em>
            </h2>
            <p class="text-[#9DAAC0] mt-2 text-sm">Chaque programme est une séquence de fréquences calibrée. Cliquez sur une carte pour les détails complets.</p>
          </div>
        </div>

        <!-- Filters -->
        <div class="flex flex-wrap items-center gap-3 mb-8">
          <input v-model="search" type="text" placeholder="Rechercher un programme…"
            class="rounded-full px-4 py-2.5 text-sm focus:outline-none transition-colors min-w-[200px]"
            style="background: rgba(10,39,69,0.6); border: 1px solid rgba(255,255,255,0.1); color: white;"/>
          <button @click="activeCategory = null"
            class="text-[11px] font-semibold rounded-full px-4 py-2 border transition-all"
            :style="!activeCategory ? 'background:#11C7C9; color:#03142A; border-color:#11C7C9;' : 'border-color:rgba(255,255,255,0.15); color:#9DAAC0;'">
            Tous
          </button>
          <button v-for="cat in categories" :key="cat.id"
            @click="activeCategory = activeCategory === cat.slug ? null : cat.slug"
            class="text-[11px] font-semibold rounded-full px-4 py-2 border transition-all"
            :style="activeCategory === cat.slug ? 'background:#11C7C9; color:#03142A; border-color:#11C7C9;' : 'border-color:rgba(255,255,255,0.15); color:#9DAAC0;'">
            {{ cat.emoji }} {{ cat.name }}
          </button>
        </div>

        <!-- Grid -->
        <div v-if="filtered.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
          <ProgramCard v-for="p in filtered" :key="p.id" :program="p" />
        </div>
        <div v-else class="text-center py-20" style="color: #9DAAC0;">
          <p class="text-4xl mb-4">🔍</p>
          <p class="text-lg">Aucun programme trouvé.</p>
          <button @click="search=''; activeCategory=null" class="mt-4 hover:underline text-sm" style="color: #11C7C9;">Réinitialiser les filtres</button>
        </div>
      </div>
    </section>

    <!-- ═══ COMMENT ÇA FONCTIONNE ═══ -->
    <section class="py-20 px-6" style="background: rgba(4,27,51,0.4);">
      <div class="max-w-5xl mx-auto">
        <div class="text-center mb-12">
          <p class="text-[11px] font-semibold tracking-[0.2em] uppercase mb-4" style="color: #11C7C9;">Le Processus</p>
          <h2 class="font-serif font-light text-white" style="font-size: clamp(1.8rem, 3.5vw, 2.6rem);">
            Comment ça <em style="color: #D5B67A; font-style: italic;">fonctionne</em>
          </h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
          <div v-for="(step, i) in howSteps" :key="i"
            class="rounded-2xl p-6 text-center"
            style="background: rgba(10,39,69,0.6); border: 1px solid rgba(255,255,255,0.07);">
            <div class="w-11 h-11 rounded-full mx-auto mb-4 flex items-center justify-center font-bold"
              style="background: #11C7C9; color: #03142A;">{{ i + 1 }}</div>
            <h4 class="text-white font-semibold text-sm mb-2">{{ step.title }}</h4>
            <p class="text-xs leading-relaxed" style="color: #9DAAC0;">{{ step.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══ TESTIMONIALS ═══ -->
    <section class="py-20 px-6">
      <div class="max-w-5xl mx-auto">
        <div class="text-center mb-12">
          <p class="text-[11px] font-semibold tracking-[0.2em] uppercase mb-4" style="color: #11C7C9;">Community</p>
          <h2 class="font-serif font-light text-white" style="font-size: clamp(1.8rem, 3.5vw, 2.6rem);">
            Ce que dit notre <em style="color: #D5B67A; font-style: italic;">communauté</em>
          </h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
          <div v-for="t in displayTestimonials" :key="t.id || t.name"
            class="rounded-2xl p-6 border border-white/8"
            style="background: rgba(10,39,69,0.6);">
            <div class="text-sm mb-3" style="color: #D5B67A;">★★★★★</div>
            <p class="text-sm italic leading-relaxed mb-4" style="color: rgba(157,170,192,0.9);">"{{ t.content }}"</p>
            <p class="text-white font-semibold text-sm">{{ t.name }}</p>
            <p class="text-xs" style="color: #11C7C9;">{{ t.program }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══ CTA FINALE ═══ -->
    <section class="py-20 px-6" style="background: linear-gradient(135deg, #041B33 0%, #051A2E 100%);">
      <div class="max-w-2xl mx-auto text-center">
        <h2 class="font-serif font-light text-white mb-4" style="font-size: clamp(1.8rem, 3vw, 2.4rem);">
          Votre fréquence de guérison<br><em style="color: #D5B67A; font-style: italic;">vous attend</em>
        </h2>
        <p class="text-[#9DAAC0] mb-8 leading-relaxed">
          Browse our programs, subscribe for unlimited access, or book a personalized consultation with Dr. Éric Rosati.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <a href="#programs"
            class="bg-[#11C7C9] hover:bg-[#0db5b7] text-[#03142A] font-bold text-sm tracking-wide uppercase px-8 py-3.5 rounded transition-all">
            Explorer Tous les Programmes
          </a>
          <Link :href="route('consultation')"
            class="border border-white/30 text-white hover:border-white/60 text-sm font-semibold px-8 py-3.5 rounded transition-all">
            Book a Consultation — €58
          </Link>
        </div>
      </div>
    </section>

  </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import ProgramCard from '@/Components/ProgramCard.vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({ programs: Array, categories: Array, testimonials: Array })

const search = ref('')
const activeCategory = ref(null)

const filtered = computed(() => {
  let list = props.programs || []
  if (activeCategory.value) list = list.filter(p => p.category?.slug === activeCategory.value)
  if (search.value.trim()) {
    const q = search.value.toLowerCase()
    list = list.filter(p =>
      p.title.toLowerCase().includes(q) ||
      p.short_desc?.toLowerCase().includes(q)
    )
  }
  return list
})

const fallbackTestimonials = [
  { name: 'Fabienne', program: 'Anti-Stress', content: 'An all-in-one solution — and without medication. I can\'t believe how effective this is.' },
  { name: 'Caroline', program: 'Allergy', content: 'No more allergy after 1 month of frequencies. So happy with the results.' },
  { name: 'Karine', program: 'Sleep + Menopause', content: 'My insomnia and hot flashes are completely gone. I can\'t live without Vitality Inside.' },
]
const displayTestimonials = computed(() => {
  const list = props.testimonials || []
  return list.length >= 3 ? list.slice(0, 3) : fallbackTestimonials
})

const accessPlans = [
  {
    id: 'single', name: 'Programme Unique', tagline: 'Un protocole ciblé, à vous pour toujours',
    price: 'À partir de €29', cta: 'Parcourir', featured: false, badge: null,
    features: ['1 programme de fréquences au choix', 'Accès permanent via lien sécurisé', 'Disponible sur tous les appareils', 'Livré par email sous 24h'],
  },
  {
    id: 'monthly', name: 'Mensuel Illimité', tagline: 'Accès complet, renouvelé chaque mois',
    price: 'À partir de €29.90 / mois', cta: 'Accès Mensuel', featured: true, badge: 'Populaire',
    features: ['Accès à toute la bibliothèque', 'Nouveaux protocoles chaque mois', 'Combinez et alternez librement', 'Support email prioritaire', 'Annulez à tout moment'],
  },
  {
    id: 'annual', name: 'Annuel Illimité', tagline: 'Meilleure valeur — 2 mois gratuits',
    price: 'Économisez €109 / an', cta: 'Accès Annuel', featured: false, badge: null,
    features: ['Tout du mensuel inclus', 'Économisez €109 vs mensuel', '1 consultation personnalisée incluse', 'Accès anticipé aux nouveaux programmes', 'Support email VIP'],
  },
]

const howSteps = [
  { title: 'Décrivez vos symptômes', desc: 'Partagez votre situation de santé et les problèmes que vous souhaitez traiter.' },
  { title: 'Analyse experte', desc: 'Examiné par le Dr Éric Rosati, Docteur en Médecine Quantique & Ostéopathe.' },
  { title: 'Recevez votre programme', desc: 'Votre protocole de fréquences personnalisé arrive par email sous 24h.' },
  { title: 'Suivez vos progrès', desc: 'Un suivi régulier assure l\'évolution de votre programme.' },
]
</script>
