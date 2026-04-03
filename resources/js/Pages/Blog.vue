<template>
  <AppLayout>
    <section class="pt-32 pb-16 px-4 text-center relative">
      <div class="absolute inset-0 halo-glow pointer-events-none"></div>
      <p class="text-vitality-cyan text-sm tracking-widest uppercase mb-3">Knowledge</p>
      <h1 class="section-title text-white mb-4">Vitality Inside <em class="text-gradient-gold not-italic">Blog</em></h1>
      <p class="text-vitality-text text-base max-w-xl mx-auto">Insights on frequency medicine, clinical research, wellbeing protocols, and the science of bio-energy therapy.</p>
    </section>

    <section class="px-4 pb-24 max-w-5xl mx-auto">
      <div v-if="posts.data?.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <Link v-for="post in posts.data" :key="post.id" :href="route('blog.show', post.slug)"
          class="glass-card rounded-2xl overflow-hidden card-hover group block">
          <div class="h-44 bg-gradient-to-br from-vitality-blue to-vitality-bg2 flex items-center justify-center text-4xl relative">
            <div class="absolute inset-0 bg-gradient-to-t from-vitality-bg2/80 to-transparent"></div>
            <span class="relative z-10 opacity-50">📖</span>
          </div>
          <div class="p-5">
            <div class="flex items-center gap-2 mb-3">
              <span v-if="post.category" class="text-vitality-cyan text-xs font-medium border border-vitality-cyan/20 rounded-full px-2.5 py-0.5">{{ post.category }}</span>
              <span class="text-vitality-text text-xs">{{ post.read_time }} min read</span>
            </div>
            <h2 class="text-white font-semibold text-sm leading-snug mb-2 group-hover:text-vitality-cyan transition-colors">{{ post.title }}</h2>
            <p class="text-vitality-text text-xs leading-relaxed line-clamp-2">{{ post.excerpt }}</p>
            <p class="text-vitality-text/50 text-xs mt-3">{{ formatDate(post.published_at) }}</p>
          </div>
        </Link>
      </div>
      <div v-else class="text-center py-20 text-vitality-text">
        <p class="text-4xl mb-4">📝</p>
        <p>No articles published yet. Check back soon!</p>
      </div>
    </section>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
defineProps({ posts: Object })
const formatDate = (d) => d ? new Date(d).toLocaleDateString('fr-FR', { year:'numeric', month:'long', day:'numeric' }) : ''
</script>
