<template>
  <AppLayout>
    <article class="pt-28 pb-24 px-4">
      <div class="max-w-3xl mx-auto">
        <nav class="flex items-center gap-2 text-xs text-vitality-text mb-8">
          <Link :href="route('blog')" class="hover:text-vitality-cyan transition-colors">Blog</Link>
          <span>/</span>
          <span class="text-vitality-cyan truncate">{{ post.title }}</span>
        </nav>

        <header class="mb-10">
          <div class="flex items-center gap-3 mb-4">
            <span v-if="post.category" class="text-vitality-cyan text-xs border border-vitality-cyan/20 rounded-full px-3 py-1">{{ post.category }}</span>
            <span class="text-vitality-text text-xs">{{ post.read_time }} min read</span>
            <span class="text-vitality-text text-xs">{{ formatDate(post.published_at) }}</span>
          </div>
          <h1 class="font-serif text-3xl md:text-4xl font-light text-white leading-tight mb-4">{{ post.title }}</h1>
          <p v-if="post.excerpt" class="text-vitality-text text-lg leading-relaxed">{{ post.excerpt }}</p>
        </header>

        <div class="glass-card rounded-3xl p-8 md:p-12">
          <div class="prose prose-lg prose-invert max-w-none
            prose-headings:font-serif prose-headings:font-light prose-headings:text-white
            prose-p:text-vitality-text prose-p:leading-relaxed
            prose-strong:text-white prose-a:text-vitality-cyan"
            v-html="post.content">
          </div>
        </div>

        <div class="mt-10 flex flex-wrap gap-2">
          <span v-for="tag in post.tags" :key="tag" class="glass-card text-xs text-vitality-text rounded-full px-3 py-1.5">#{{ tag }}</span>
        </div>

        <div class="mt-12 pt-8 border-t border-white/5 flex items-center justify-between">
          <div>
            <p class="text-vitality-text text-xs">Written by</p>
            <p class="text-white font-semibold text-sm">{{ post.author?.name || 'Dr. Éric Rosati' }}</p>
          </div>
          <Link :href="route('blog')" class="btn-outline text-sm">← Back to Blog</Link>
        </div>
      </div>
    </article>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
defineProps({ post: Object })
const formatDate = (d) => d ? new Date(d).toLocaleDateString('fr-FR', { year:'numeric', month:'long', day:'numeric' }) : ''
</script>
