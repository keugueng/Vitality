<template>
  <AdminLayout>
    <div class="max-w-5xl">
      <div class="flex items-center justify-between mb-8">
        <h1 class="font-serif text-3xl font-light text-white">Testimonials</h1>
        <button @click="showForm = true" class="btn-cyan text-sm py-2 px-5">+ Add Testimonial</button>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div v-for="t in testimonials" :key="t.id" class="glass-card rounded-2xl p-5">
          <div class="flex items-start justify-between mb-3">
            <div>
              <p class="text-white font-semibold">{{ t.name }}</p>
              <p class="text-vitality-cyan text-xs">{{ t.program }}</p>
            </div>
            <div class="flex items-center gap-2">
              <div class="text-vitality-gold text-sm">{{ '★'.repeat(t.rating) }}</div>
              <Link :href="route('admin.testimonials.destroy', t.id)" method="delete" as="button"
                class="text-red-400/60 hover:text-red-400 text-xs transition-colors"
                @click.prevent="deleteT(t)">✕</Link>
            </div>
          </div>
          <p class="text-vitality-text text-sm italic leading-relaxed">"{{ t.content }}"</p>
        </div>
      </div>
      <div v-if="!testimonials.length" class="glass-card rounded-2xl p-10 text-center text-vitality-text">No testimonials yet.</div>
    </div>

    <div v-if="showForm" class="fixed inset-0 z-50 flex items-center justify-center px-4 bg-black/70 backdrop-blur-sm">
      <div class="glass-card rounded-3xl p-8 w-full max-w-md border-glow">
        <h3 class="text-white font-semibold text-lg mb-5">Add Testimonial</h3>
        <form @submit.prevent="submit" class="space-y-4">
          <input v-model="form.name" type="text" required placeholder="Client name" class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-3 py-2.5 text-white text-sm focus:outline-none focus:border-vitality-cyan/50"/>
          <input v-model="form.program" type="text" required placeholder="Program used" class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-3 py-2.5 text-white text-sm focus:outline-none focus:border-vitality-cyan/50"/>
          <textarea v-model="form.content" required rows="3" placeholder="Testimonial text…" class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-3 py-2 text-white text-sm focus:outline-none focus:border-vitality-cyan/50 resize-none"></textarea>
          <div>
            <label class="text-vitality-text text-xs mb-1.5 block">Rating</label>
            <select v-model="form.rating" class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-3 py-2.5 text-white text-sm focus:outline-none focus:border-vitality-cyan/50">
              <option v-for="i in [5,4,3,2,1]" :key="i" :value="i">{{ '★'.repeat(i) }}</option>
            </select>
          </div>
          <div class="flex gap-3">
            <button type="button" @click="showForm = false" class="btn-outline flex-1 text-sm py-2.5">Cancel</button>
            <button type="submit" :disabled="form.processing" class="btn-cyan flex-1 text-sm py-2.5 disabled:opacity-50">Add</button>
          </div>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>
<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
defineProps({ testimonials: Array })
const showForm = ref(false)
const form = useForm({ name: '', program: '', content: '', rating: 5 })
const submit = () => form.post(route('admin.testimonials.store'), { onSuccess: () => { showForm.value = false; form.reset() } })
const deleteT = (t) => { if (confirm('Delete?')) useForm().delete(route('admin.testimonials.destroy', t.id)) }
</script>
