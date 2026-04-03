<template>
  <AppLayout>
    <!-- Hero -->
    <section class="pt-32 pb-12 px-4 text-center relative">
      <div class="absolute inset-0 halo-glow pointer-events-none"></div>
      <p class="text-vitality-cyan text-sm tracking-widest uppercase mb-3">60+ Programs</p>
      <h1 class="section-title text-white mb-4">The full <em class="text-gradient-gold not-italic">Vitality library</em></h1>
      <p class="text-vitality-text text-base max-w-xl mx-auto">Bio-energy frequency protocols organized by health challenge. Each program is a 21–30 day cure, 25 min/session.</p>
    </section>

    <!-- Filters -->
    <section class="px-4 pb-8 max-w-6xl mx-auto">
      <div class="flex flex-wrap items-center gap-3">
        <!-- Search -->
        <div class="flex-1 min-w-[200px] max-w-xs">
          <input v-model="search" type="text" placeholder="Search programs…"
            class="w-full bg-vitality-blue/40 border border-white/10 rounded-full px-4 py-2.5 text-sm text-white placeholder-vitality-text/50 focus:outline-none focus:border-vitality-cyan/50 transition-colors"/>
        </div>
        <!-- Category filters -->
        <button @click="activeCategory = null"
          :class="['text-xs font-medium rounded-full px-4 py-2 border transition-all', !activeCategory ? 'bg-vitality-cyan text-vitality-bg border-vitality-cyan' : 'border-white/10 text-vitality-text hover:border-vitality-cyan/40']">
          All
        </button>
        <button v-for="cat in categories" :key="cat.id"
          @click="activeCategory = activeCategory === cat.slug ? null : cat.slug"
          :class="['text-xs font-medium rounded-full px-4 py-2 border transition-all', activeCategory === cat.slug ? 'bg-vitality-cyan text-vitality-bg border-vitality-cyan' : 'border-white/10 text-vitality-text hover:border-vitality-cyan/40']">
          {{ cat.emoji }} {{ cat.name }}
        </button>
      </div>
    </section>

    <!-- Programs grid -->
    <section class="px-4 pb-24 max-w-6xl mx-auto">
      <div v-if="filtered.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        <ProgramCard v-for="p in filtered" :key="p.id" :program="p" />
      </div>
      <div v-else class="text-center py-20 text-vitality-text">
        <p class="text-4xl mb-4">🔍</p>
        <p class="text-lg">No programs found for this search.</p>
        <button @click="search=''; activeCategory=null" class="mt-4 text-vitality-cyan hover:underline text-sm">Reset filters</button>
      </div>
    </section>

    <!-- Testimonials -->
    <section class="py-20 px-4 border-t border-white/5">
      <div class="max-w-4xl mx-auto text-center mb-12">
        <h2 class="section-title text-white">What our <em class="text-gradient-gold not-italic">community says</em></h2>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-5 max-w-5xl mx-auto">
        <div v-for="t in testimonials.slice(0,3)" :key="t.id" class="glass-card rounded-2xl p-6">
          <div class="text-vitality-gold text-sm mb-3">★★★★★</div>
          <p class="text-vitality-text text-sm italic leading-relaxed mb-4">"{{ t.content }}"</p>
          <p class="text-white font-semibold text-sm">{{ t.name }}</p>
          <p class="text-vitality-cyan text-xs">{{ t.program }}</p>
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
