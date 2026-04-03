<template>
  <AdminLayout>
    <div class="max-w-6xl">
      <div class="flex items-center justify-between mb-8">
        <h1 class="font-serif text-3xl font-light text-white">Programs</h1>
        <button @click="showForm = true" class="btn-cyan text-sm py-2 px-5">+ New Program</button>
      </div>

      <!-- Table -->
      <div class="glass-card rounded-2xl overflow-hidden">
        <table class="w-full text-sm">
          <thead class="border-b border-white/5">
            <tr class="text-vitality-text text-xs">
              <th class="text-left p-4">Program</th>
              <th class="text-left p-4">Category</th>
              <th class="text-left p-4">Price</th>
              <th class="text-left p-4">Status</th>
              <th class="text-left p-4">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-white/5">
            <tr v-for="p in programs" :key="p.id" class="hover:bg-white/2 transition-colors">
              <td class="p-4">
                <div class="flex items-center gap-3">
                  <span class="text-2xl">{{ p.emoji || '✨' }}</span>
                  <div>
                    <p class="text-white font-medium">{{ p.title }}</p>
                    <p class="text-vitality-text text-xs">{{ p.session_duration }}</p>
                  </div>
                </div>
              </td>
              <td class="p-4 text-vitality-text">{{ p.category?.name }}</td>
              <td class="p-4 text-vitality-gold font-semibold">€{{ p.price }}</td>
              <td class="p-4">
                <span :class="['text-xs rounded-full px-2.5 py-1', p.is_active ? 'bg-vitality-cyan/10 text-vitality-cyan' : 'bg-red-500/10 text-red-400']">
                  {{ p.is_active ? 'Active' : 'Inactive' }}
                </span>
                <span v-if="p.is_bestseller" class="ml-1 text-xs rounded-full px-2 py-0.5 bg-vitality-gold/10 text-vitality-gold">⭐</span>
              </td>
              <td class="p-4">
                <div class="flex items-center gap-2">
                  <button @click="editProgram(p)" class="text-xs text-vitality-text hover:text-white border border-white/10 rounded-lg px-2.5 py-1 transition-all">Edit</button>
                  <Link :href="route('admin.programs.destroy', p.id)" method="delete" as="button"
                    class="text-xs text-red-400/60 hover:text-red-400 border border-red-400/10 rounded-lg px-2.5 py-1 transition-all"
                    @click.prevent="confirmDelete(p)">Delete</Link>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
        <div v-if="!programs.length" class="py-12 text-center text-vitality-text">No programs yet.</div>
      </div>
    </div>

    <!-- Modal -->
    <div v-if="showForm" class="fixed inset-0 z-50 flex items-center justify-center px-4 bg-black/70 backdrop-blur-sm overflow-y-auto">
      <div class="glass-card rounded-3xl p-8 w-full max-w-2xl my-8 border-glow">
        <h3 class="text-white font-semibold text-xl mb-6">{{ editing ? 'Edit Program' : 'New Program' }}</h3>
        <form @submit.prevent="submitForm" class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="md:col-span-2">
            <label class="text-vitality-text text-xs mb-1.5 block">Category *</label>
            <select v-model="form.category_id" required class="w-full text-white text-sm rounded-xl px-3 py-2.5 focus:outline-none" style="background-color: rgba(30, 58, 138, 0.3); border: 1px solid rgba(255, 255, 255, 0.1);">
              <option value="" disabled>Select…</option>
              <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.emoji }} {{ c.name }}</option>
            </select>
          </div>
          <div>
            <label class="text-vitality-text text-xs mb-1.5 block">Title (EN) *</label>
            <input v-model="form.title" type="text" required class="input-field"/>
          </div>
          <div>
            <label class="text-vitality-text text-xs mb-1.5 block">Title (FR) *</label>
            <input v-model="form.title_fr" type="text" required class="input-field"/>
          </div>
          <div>
            <label class="text-vitality-text text-xs mb-1.5 block">Emoji</label>
            <input v-model="form.emoji" type="text" maxlength="4" placeholder="🎯" class="input-field"/>
          </div>
          <div>
            <label class="text-vitality-text text-xs mb-1.5 block">Price (€) *</label>
            <input v-model="form.price" type="number" step="0.01" required class="input-field"/>
          </div>
          <div>
            <label class="text-vitality-text text-xs mb-1.5 block">Session Duration</label>
            <input v-model="form.session_duration" type="text" placeholder="25 min" class="input-field"/>
          </div>
          <div>
            <label class="text-vitality-text text-xs mb-1.5 block">Cure Duration</label>
            <input v-model="form.cure_duration" type="text" placeholder="21-30 days" class="input-field"/>
          </div>
          <div class="md:col-span-2">
            <label class="text-vitality-text text-xs mb-1.5 block">Short Description (EN) *</label>
            <textarea v-model="form.short_desc" required rows="2" class="w-full text-white text-sm rounded-xl px-3 py-2 focus:outline-none resize-none" style="background-color: rgba(30, 58, 138, 0.3); border: 1px solid rgba(255, 255, 255, 0.1);"></textarea>
          </div>
          <div class="md:col-span-2">
            <label class="text-vitality-text text-xs mb-1.5 block">Short Description (FR) *</label>
            <textarea v-model="form.short_desc_fr" required rows="2" class="w-full text-white text-sm rounded-xl px-3 py-2 focus:outline-none resize-none" style="background-color: rgba(30, 58, 138, 0.3); border: 1px solid rgba(255, 255, 255, 0.1);"></textarea>
          </div>
          <div class="flex gap-4 items-center">
            <label class="flex items-center gap-2 text-vitality-text text-sm cursor-pointer">
              <input v-model="form.is_active" type="checkbox" class="rounded"/>Active
            </label>
            <label class="flex items-center gap-2 text-vitality-text text-sm cursor-pointer">
              <input v-model="form.is_bestseller" type="checkbox" class="rounded"/>Bestseller
            </label>
            <label class="flex items-center gap-2 text-vitality-text text-sm cursor-pointer">
              <input v-model="form.is_featured" type="checkbox" class="rounded"/>Featured
            </label>
          </div>
          <div class="md:col-span-2 flex gap-3 mt-2">
            <button type="button" @click="closeForm" class="btn-outline flex-1 text-sm py-2.5">Cancel</button>
            <button type="submit" :disabled="form.processing" class="btn-cyan flex-1 text-sm py-2.5 disabled:opacity-50">
              {{ form.processing ? 'Saving…' : (editing ? 'Update' : 'Create') }}
            </button>
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

defineProps({ programs: Array, categories: Array })

const showForm = ref(false)
const editing  = ref(null)

const form = useForm({
  category_id: '', title: '', title_fr: '', emoji: '', short_desc: '', short_desc_fr: '',
  session_duration: '25 min', cure_duration: '21-30 days', price: '',
  is_active: true, is_bestseller: false, is_featured: false,
})

const editProgram = (p) => {
  editing.value = p
  Object.assign(form, { category_id: p.category_id, title: p.title, title_fr: p.title_fr, emoji: p.emoji || '',
    short_desc: p.short_desc, short_desc_fr: p.short_desc_fr, session_duration: p.session_duration,
    cure_duration: p.cure_duration, price: p.price, is_active: p.is_active, is_bestseller: p.is_bestseller, is_featured: p.is_featured })
  showForm.value = true
}

const closeForm = () => { showForm.value = false; editing.value = null; form.reset() }

const submitForm = () => {
  if (editing.value) {
    form.put(route('admin.programs.update', editing.value.id), { onSuccess: closeForm })
  } else {
    form.post(route('admin.programs.store'), { onSuccess: closeForm })
  }
}

const confirmDelete = (p) => {
  if (confirm(`Delete "${p.title}"?`)) {
    useForm().delete(route('admin.programs.destroy', p.id))
  }
}
</script>

<style scoped>
.input-field {
  background-color: rgba(30, 58, 138, 0.3);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 0.75rem;
  padding: 0.625rem 0.75rem;
  color: white;
  font-size: 0.875rem;
  outline: none;
  width: 100%;
}
.input-field:focus {
  border-color: rgba(34, 211, 238, 0.5);
}
</style>
