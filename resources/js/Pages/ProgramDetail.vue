<template>
  <AppLayout>
    <section class="pt-28 pb-20 px-4">
      <div class="max-w-5xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-xs text-vitality-text mb-8">
          <Link :href="route('shop')" class="hover:text-vitality-cyan transition-colors">Shop</Link>
          <span>/</span>
          <span class="text-vitality-cyan">{{ program.title }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
          <!-- Left: Image / Emoji display -->
          <div class="glass-card rounded-3xl p-10 flex items-center justify-center min-h-[320px] relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-radial from-vitality-cyan/5 to-transparent"></div>
            <div class="relative text-center z-10">
              <div class="text-8xl mb-6">{{ program.emoji || '✨' }}</div>
              <span class="glass-card border-glow text-vitality-cyan text-xs font-medium rounded-full px-4 py-2">{{ program.category?.name }}</span>
            </div>
          </div>

          <!-- Right: Info -->
          <div class="flex flex-col gap-6">
            <div>
              <div v-if="program.is_bestseller" class="inline-flex items-center gap-1.5 bg-vitality-gold/15 border border-vitality-gold/30 text-vitality-gold text-xs rounded-full px-3 py-1 mb-3">
                ⭐ Bestseller
              </div>
              <h1 class="font-serif text-3xl md:text-4xl font-light text-white leading-tight mb-3">{{ program.title }}</h1>
              <p class="text-vitality-text leading-relaxed">{{ program.short_desc }}</p>
            </div>

            <!-- Meta tags -->
            <div class="flex flex-wrap gap-2">
              <span class="glass-card rounded-full px-3 py-1.5 text-xs text-vitality-text flex items-center gap-1.5">⏱ {{ program.session_duration }}/session</span>
              <span class="glass-card rounded-full px-3 py-1.5 text-xs text-vitality-text flex items-center gap-1.5">📅 {{ program.cure_duration }}</span>
              <span class="glass-card rounded-full px-3 py-1.5 text-xs text-vitality-text flex items-center gap-1.5">🎧 Headphones required</span>
            </div>

            <!-- Benefits -->
            <div v-if="program.benefits?.length" class="glass-card rounded-2xl p-5">
              <h3 class="text-white font-semibold text-sm mb-3">What you'll experience</h3>
              <ul class="space-y-2">
                <li v-for="b in program.benefits" :key="b" class="flex items-start gap-2 text-vitality-text text-sm">
                  <span class="text-vitality-cyan mt-0.5 flex-shrink-0">✓</span>{{ b }}
                </li>
              </ul>
            </div>

            <!-- Price & CTA -->
            <div class="glass-card rounded-2xl p-5 border-glow">
              <div class="flex items-center justify-between mb-4">
                <div>
                  <span class="text-vitality-gold font-bold text-3xl">€{{ program.price }}</span>
                  <span class="text-vitality-text text-sm ml-2">one-time</span>
                </div>
                <span class="text-vitality-text text-xs">Lifetime access</span>
              </div>
              <Link :href="route('cart.add')" method="post" as="button"
                :data="{ program_id: program.id }"
                class="btn-cyan w-full text-center block text-base py-3.5">
                Add to Cart — €{{ program.price }}
              </Link>
              <p class="text-vitality-text/50 text-xs text-center mt-3">Secure payment · Instant delivery</p>
            </div>
          </div>
        </div>

        <!-- Long description -->
        <div v-if="program.long_desc" class="mt-16 glass-card rounded-2xl p-8">
          <h2 class="font-serif text-2xl font-light text-white mb-6">About this program</h2>
          <div class="text-vitality-text leading-relaxed prose prose-invert max-w-none" v-html="program.long_desc"></div>
        </div>

        <!-- Tags -->
        <div v-if="program.tags?.length" class="mt-8 flex flex-wrap gap-2">
          <span v-for="tag in program.tags" :key="tag" class="glass-card text-xs text-vitality-text rounded-full px-3 py-1.5">#{{ tag }}</span>
        </div>

        <!-- Related programs -->
        <div v-if="related?.length" class="mt-20">
          <h2 class="font-serif text-2xl font-light text-white mb-8">Related programs</h2>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <ProgramCard v-for="p in related" :key="p.id" :program="p" />
          </div>
        </div>
      </div>
    </section>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import ProgramCard from '@/Components/ProgramCard.vue'
import { Link } from '@inertiajs/vue3'
defineProps({ program: Object, related: Array })
</script>
