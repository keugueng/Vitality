<template>
  <div class="rounded-2xl p-5 flex flex-col gap-3 group relative overflow-hidden transition-all duration-300 hover:border-white/20 cursor-pointer"
    style="background: rgba(10,39,69,0.6); border: 1px solid rgba(255,255,255,0.07);">

    <!-- Bestseller badge -->
    <div v-if="program.is_bestseller"
      class="absolute top-3 right-3 text-[10px] font-semibold rounded-full px-2.5 py-1 uppercase tracking-wider"
      style="background: rgba(213,182,122,0.15); color: #D5B67A; border: 1px solid rgba(213,182,122,0.3);">Bestseller</div>

    <!-- Header: emoji + catégorie -->
    <div class="flex items-center gap-3">
      <div class="w-10 h-10 rounded-lg flex items-center justify-center text-xl flex-shrink-0 text-2xl"
        style="background: rgba(17,199,201,0.1);">{{ program.emoji || '✨' }}</div>
      <span class="text-[11px] font-semibold tracking-wide uppercase" style="color: #11C7C9;">{{ program.category?.name || '' }}</span>
    </div>

    <!-- Titre -->
    <h3 class="font-serif text-white font-light text-base leading-snug group-hover:opacity-80 transition-opacity">{{ program.title }}</h3>

    <!-- Description -->
    <p class="text-[#9DAAC0] text-xs leading-relaxed flex-1">{{ program.short_desc }}</p>

    <!-- Meta durée -->
    <div class="flex items-center gap-3 text-[11px]" style="color: rgba(157,170,192,0.6);">
      <span>⏱ {{ program.session_duration }}</span>
      <span>·</span>
      <span>{{ program.cure_duration }}</span>
    </div>

    <!-- Prix + Actions — exactement comme live -->
    <div class="flex items-center justify-between pt-2 border-t" style="border-color: rgba(255,255,255,0.07);">
      <span class="font-serif font-light text-xl" style="color: #D5B67A;">€{{ program.price }}</span>
      <Link :href="route('cart.add')" method="post" as="button"
        :data="{ program_id: program.id }"
        class="flex items-center gap-1.5 text-[11px] font-semibold tracking-wide text-[#03142A] bg-[#11C7C9] hover:bg-[#0db5b7] rounded px-3.5 py-2 transition-all">
        + Panier
      </Link>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
defineProps({ program: Object })
</script>
