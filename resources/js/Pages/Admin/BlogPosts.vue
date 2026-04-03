<template>
  <AdminLayout>
    <div class="max-w-6xl">
      <div class="flex items-center justify-between mb-8">
        <h1 class="font-serif text-3xl font-light text-white">Blog Posts</h1>
        <button @click="openForm()" class="btn-cyan text-sm py-2 px-5">+ New Post</button>
      </div>
      <div class="glass-card rounded-2xl overflow-hidden">
        <table class="w-full text-sm">
          <thead class="border-b border-white/5">
            <tr class="text-vitality-text text-xs">
              <th class="text-left p-4">Title</th>
              <th class="text-left p-4">Category</th>
              <th class="text-left p-4">Status</th>
              <th class="text-left p-4">Date</th>
              <th class="text-left p-4">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-white/5">
            <tr v-for="post in posts.data" :key="post.id">
              <td class="p-4">
                <p class="text-white font-medium">{{ post.title }}</p>
                <p class="text-vitality-text text-xs">{{ post.read_time }} min read</p>
              </td>
              <td class="p-4 text-vitality-text">{{ post.category || '—' }}</td>
              <td class="p-4">
                <span :class="['text-xs rounded-full px-2.5 py-1', post.is_published ? 'bg-vitality-cyan/10 text-vitality-cyan' : 'bg-yellow-500/10 text-yellow-400']">
                  {{ post.is_published ? 'Published' : 'Draft' }}
                </span>
              </td>
              <td class="p-4 text-vitality-text text-xs">{{ post.published_at ? formatDate(post.published_at) : '—' }}</td>
              <td class="p-4">
                <div class="flex items-center gap-2">
                  <button @click="openForm(post)" class="text-xs text-vitality-text hover:text-white border border-white/10 rounded-lg px-2.5 py-1 transition-all">Edit</button>
                  <button @click="deletePost(post)" class="text-xs text-red-400/60 hover:text-red-400 border border-red-400/10 rounded-lg px-2.5 py-1 transition-all">Delete</button>
                </div>
              </td>
            </tr>
            <tr v-if="!posts.data?.length">
              <td colspan="5" class="py-10 text-center text-vitality-text">No posts yet.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Form Modal -->
    <div v-if="showForm" class="fixed inset-0 z-50 flex items-center justify-center px-4 bg-black/70 backdrop-blur-sm overflow-y-auto">
      <div class="glass-card rounded-3xl p-8 w-full max-w-2xl my-8 border-glow">
        <h3 class="text-white font-semibold text-xl mb-5">{{ editing ? 'Edit Post' : 'New Post' }}</h3>
        <form @submit.prevent="submitForm" class="space-y-4">
          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="text-vitality-text text-xs mb-1.5 block">Title (EN) *</label>
              <input v-model="form.title" type="text" required class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-3 py-2.5 text-white text-sm focus:outline-none focus:border-vitality-cyan/50"/>
            </div>
            <div>
              <label class="text-vitality-text text-xs mb-1.5 block">Title (FR) *</label>
              <input v-model="form.title_fr" type="text" required class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-3 py-2.5 text-white text-sm focus:outline-none focus:border-vitality-cyan/50"/>
            </div>
          </div>
          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="text-vitality-text text-xs mb-1.5 block">Category</label>
              <input v-model="form.category" type="text" placeholder="Science, Wellness…" class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-3 py-2.5 text-white text-sm focus:outline-none focus:border-vitality-cyan/50"/>
            </div>
            <div>
              <label class="text-vitality-text text-xs mb-1.5 block">Read Time (min)</label>
              <input v-model="form.read_time" type="number" min="1" class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-3 py-2.5 text-white text-sm focus:outline-none focus:border-vitality-cyan/50"/>
            </div>
          </div>
          <div>
            <label class="text-vitality-text text-xs mb-1.5 block">Excerpt</label>
            <textarea v-model="form.excerpt" rows="2" class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-3 py-2 text-white text-sm focus:outline-none focus:border-vitality-cyan/50 resize-none"></textarea>
          </div>
          <div>
            <label class="text-vitality-text text-xs mb-1.5 block">Content (HTML) *</label>
            <textarea v-model="form.content" required rows="6" class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-3 py-2 text-white text-sm focus:outline-none focus:border-vitality-cyan/50 resize-none font-mono"></textarea>
          </div>
          <label class="flex items-center gap-2 text-vitality-text text-sm cursor-pointer">
            <input v-model="form.is_published" type="checkbox" class="rounded"/>Publish immediately
          </label>
          <div class="flex gap-3">
            <button type="button" @click="closeForm" class="btn-outline flex-1 text-sm py-2.5">Cancel</button>
            <button type="submit" :disabled="form.processing" class="btn-cyan flex-1 text-sm py-2.5 disabled:opacity-50">
              {{ form.processing ? 'Saving…' : (editing ? 'Update' : 'Publish') }}
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
defineProps({ posts: Object })
const showForm = ref(false)
const editing = ref(null)
const form = useForm({ title: '', title_fr: '', category: '', read_time: 5, excerpt: '', content: '', is_published: false })
const openForm = (post = null) => {
  editing.value = post
  if (post) Object.assign(form, { title: post.title, title_fr: post.title_fr, category: post.category || '', read_time: post.read_time, excerpt: post.excerpt || '', content: post.content, is_published: post.is_published })
  showForm.value = true
}
const closeForm = () => { showForm.value = false; editing.value = null; form.reset() }
const submitForm = () => {
  if (editing.value) form.put(route('admin.blog.update', editing.value.id), { onSuccess: closeForm })
  else form.post(route('admin.blog.store'), { onSuccess: closeForm })
}
const deletePost = (post) => { if (confirm('Delete this post?')) useForm().delete(route('admin.blog.destroy', post.id)) }
const formatDate = (d) => new Date(d).toLocaleDateString('fr-FR')
</script>
