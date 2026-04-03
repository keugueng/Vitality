<template>
  <div class="glass-card rounded-2xl p-5 card-hover flex flex-col gap-4 group relative overflow-hidden">
    <div v-if="program.is_bestseller" class="absolute top-3 right-3 bg-vitality-gold/20 border border-vitality-gold/30 text-vitality-gold text-[10px] font-semibold rounded-full px-2.5 py-1 uppercase tracking-wider">Bestseller</div>
    <!-- Emoji / category -->
    <div class="flex items-center gap-3">
      <div class="w-11 h-11 rounded-xl bg-vitality-cyan/10 flex items-center justify-center text-2xl flex-shrink-0">{{ program.emoji || '✨' }}</div>
      <div>
        <span class="text-vitality-cyan text-xs font-medium">{{ program.category?.name || '' }}</span>
        <h3 class="text-white font-semibold text-sm leading-snug mt-0.5 group-hover:text-vitality-cyan transition-colors">{{ program.title }}</h3>
      </div>
    </div>
    <!-- Desc -->
    <p class="text-vitality-text text-xs leading-relaxed flex-1">{{ program.short_desc }}</p>
    <!-- Meta -->
    <div class="flex items-center gap-3 text-xs text-vitality-text/60">
      <span class="flex items-center gap-1">⏱ {{ program.session_duration }}</span>
      <span class="flex items-center gap-1">📅 {{ program.cure_duration }}</span>
    </div>
    <!-- Price + Actions -->
    <div class="flex items-center justify-between mt-1">
      <span class="text-vitality-gold font-bold text-base">€{{ program.price }}</span>
      <div class="flex items-center gap-2">
        <Link :href="route('shop.show', program.slug)" class="text-xs text-vitality-text hover:text-white border border-white/10 rounded-full px-3 py-1.5 transition-all hover:border-white/30">
          Details
        </Link>
        <Link :href="route('cart.add')" method="post" as="button"
          :data="{ program_id: program.id }"
          class="btn-cyan text-xs py-1.5 px-3">
          + Panier
        </Link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
defineProps({ program: Object })
</script>
