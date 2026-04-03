<template>
  <AdminLayout>
    <div class="max-w-4xl">
      <div class="flex items-center justify-between mb-8">
        <h1 class="font-serif text-3xl font-light text-white">Categories</h1>
        <button @click="showForm = true" class="btn-cyan text-sm py-2 px-5">+ New Category</button>
      </div>
      <div class="glass-card rounded-2xl overflow-hidden">
        <table class="w-full text-sm">
          <thead class="border-b border-white/5">
            <tr class="text-vitality-text text-xs">
              <th class="text-left p-4">Category</th>
              <th class="text-left p-4">Programs</th>
              <th class="text-left p-4">Status</th>
              <th class="text-left p-4">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-white/5">
            <tr v-for="cat in categories" :key="cat.id">
              <td class="p-4">
                <div class="flex items-center gap-3">
                  <span class="text-2xl">{{ cat.emoji }}</span>
                  <div>
                    <p class="text-white font-medium">{{ cat.name }}</p>
                    <p class="text-vitality-text text-xs">{{ cat.name_fr }}</p>
                  </div>
                </div>
              </td>
              <td class="p-4 text-vitality-text">{{ cat.programs_count }}</td>
              <td class="p-4">
                <span :class="['text-xs rounded-full px-2.5 py-1', cat.is_active ? 'bg-vitality-cyan/10 text-vitality-cyan' : 'bg-red-500/10 text-red-400']">
                  {{ cat.is_active ? 'Active' : 'Inactive' }}
                </span>
              </td>
              <td class="p-4">
                <button @click="editCat(cat)" class="text-xs text-vitality-text hover:text-white border border-white/10 rounded-lg px-2.5 py-1 mr-2 transition-all">Edit</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div v-if="showForm" class="fixed inset-0 z-50 flex items-center justify-center px-4 bg-black/70 backdrop-blur-sm">
      <div class="glass-card rounded-3xl p-8 w-full max-w-md border-glow">
        <h3 class="text-white font-semibold text-lg mb-5">{{ editing ? 'Edit Category' : 'New Category' }}</h3>
        <form @submit.prevent="submitForm" class="space-y-4">
          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="text-vitality-text text-xs mb-1.5 block">Name (EN) *</label>
              <input v-model="form.name" type="text" required class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-3 py-2.5 text-white text-sm focus:outline-none focus:border-vitality-cyan/50"/>
            </div>
            <div>
              <label class="text-vitality-text text-xs mb-1.5 block">Name (FR) *</label>
              <input v-model="form.name_fr" type="text" required class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-3 py-2.5 text-white text-sm focus:outline-none focus:border-vitality-cyan/50"/>
            </div>
          </div>
          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="text-vitality-text text-xs mb-1.5 block">Emoji</label>
              <input v-model="form.emoji" type="text" maxlength="4" class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-3 py-2.5 text-white text-sm focus:outline-none focus:border-vitality-cyan/50"/>
            </div>
            <div>
              <label class="text-vitality-text text-xs mb-1.5 block">Sort Order</label>
              <input v-model="form.sort_order" type="number" class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-3 py-2.5 text-white text-sm focus:outline-none focus:border-vitality-cyan/50"/>
            </div>
          </div>
          <label class="flex items-center gap-2 text-vitality-text text-sm cursor-pointer">
            <input v-model="form.is_active" type="checkbox" class="rounded"/>Active
          </label>
          <div class="flex gap-3 mt-2">
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
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
defineProps({ categories: Array })
const showForm = ref(false)
const editing = ref(null)
const form = useForm({ name: '', name_fr: '', emoji: '', sort_order: 0, is_active: true })
const editCat = (c) => { editing.value = c; Object.assign(form, { name: c.name, name_fr: c.name_fr, emoji: c.emoji || '', sort_order: c.sort_order, is_active: c.is_active }); showForm.value = true }
const closeForm = () => { showForm.value = false; editing.value = null; form.reset() }
const submitForm = () => {
  if (editing.value) form.put(route('admin.categories.update', editing.value.id), { onSuccess: closeForm })
  else form.post(route('admin.categories.store'), { onSuccess: closeForm })
}
</script>
