<template>
  <AppLayout>
    <!-- Hero -->
    <section class="pt-32 pb-12 px-6 text-center relative overflow-hidden">
      <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse 80% 50% at 50% 0%, rgba(17,199,201,0.06) 0%, transparent 70%);"></div>
      <p class="text-[11px] font-semibold tracking-[0.2em] uppercase mb-4" style="color: #11C7C9;">60+ Programmes</p>
      <h1 class="font-serif font-light text-white mb-5" style="font-size: clamp(2.2rem, 5vw, 3.5rem); line-height: 1.1;">
        La bibliothèque <em style="color: #D5B67A; font-style: italic;">Vitality complète</em>
      </h1>
      <p class="text-[#9DAAC0] text-base max-w-xl mx-auto mb-10">Protocoles de fréquences bio-énergétiques organisés par problématique de santé. Chaque programme est une cure de 21–30 jours, 25 min/session.</p>
      <!-- Stats inline -->
      <div class="flex items-center justify-center gap-10 text-center">
        <div>
          <p class="font-serif font-light text-2xl" style="color: #11C7C9;">60+</p>
          <p class="text-[10px] font-semibold uppercase tracking-widest mt-0.5" style="color: #9DAAC0;">Programmes</p>
        </div>
        <div class="w-px h-8" style="background: rgba(255,255,255,0.1);"></div>
        <div>
          <p class="font-serif font-light text-2xl" style="color: #11C7C9;">21k+</p>
          <p class="text-[10px] font-semibold uppercase tracking-widest mt-0.5" style="color: #9DAAC0;">Utilisateurs</p>
        </div>
        <div class="w-px h-8" style="background: rgba(255,255,255,0.1);"></div>
        <div>
          <p class="font-serif font-light text-2xl" style="color: #11C7C9;">25 min</p>
          <p class="text-[10px] font-semibold uppercase tracking-widest mt-0.5" style="color: #9DAAC0;">Par session</p>
        </div>
      </div>
    </section>

    <!-- Filters -->
    <section class="px-6 pb-8 max-w-6xl mx-auto">
      <div class="flex flex-wrap items-center gap-3">
        <div class="flex-1 min-w-[200px] max-w-xs">
          <input v-model="search" type="text" placeholder="Rechercher un programme…"
            class="w-full rounded-full px-4 py-2.5 text-sm text-white focus:outline-none transition-colors"
            style="background: rgba(10,39,69,0.6); border: 1px solid rgba(255,255,255,0.1); color: white;"
            />
        </div>
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
    </section>

    <!-- Programs grid -->
    <section class="px-6 pb-24 max-w-6xl mx-auto">
      <div v-if="filtered.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        <ProgramCard v-for="p in filtered" :key="p.id" :program="p" />
      </div>
      <div v-else class="text-center py-20" style="color: #9DAAC0;">
        <p class="text-4xl mb-4">🔍</p>
        <p class="text-lg">Aucun programme trouvé.</p>
        <button @click="search=''; activeCategory=null" class="mt-4 hover:underline text-sm" style="color: #11C7C9;">Réinitialiser les filtres</button>
      </div>
    </section>

    <!-- Testimonials -->
    <section class="py-20 px-6" style="border-top: 1px solid rgba(255,255,255,0.06);">
      <div class="max-w-4xl mx-auto text-center mb-12">
        <p class="text-[11px] font-semibold tracking-[0.2em] uppercase mb-4" style="color: #11C7C9;">Community</p>
        <h2 class="font-serif font-light text-white" style="font-size: clamp(1.8rem, 3.5vw, 2.6rem);">
          Ce que dit notre <em style="color: #D5B67A; font-style: italic;">communauté</em>
        </h2>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-5 max-w-5xl mx-auto">
        <div v-for="t in (testimonials||[]).slice(0,3)" :key="t.id"
          class="rounded-2xl p-6 border border-white/8"
          style="background: rgba(10,39,69,0.6);">
          <div class="text-sm mb-3" style="color: #D5B67A;">★★★★★</div>
          <p class="text-sm italic leading-relaxed mb-4" style="color: rgba(157,170,192,0.9);">&quot;{{ t.content }}&quot;</p>
          <p class="text-white font-semibold text-sm">{{ t.name }}</p>
          <p class="text-xs" style="color: #11C7C9;">{{ t.program }}</p>
        </div>
      </div>
    </section>
  </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import ProgramCard from '@/Components/ProgramCard.vue'

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
</script>
