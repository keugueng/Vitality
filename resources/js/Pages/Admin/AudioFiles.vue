<template>
  <AdminLayout>

    <!-- Top header -->
    <div class="flex items-center justify-between px-7 py-3.5 bg-white border-b border-gray-100 sticky top-0 z-10">
      <div>
        <h2 class="text-gray-800 font-semibold text-sm">Fichiers Audio</h2>
        <p class="text-gray-400 text-xs">FiftyCare Admin › Fichiers Audio</p>
      </div>
      <div class="flex items-center gap-2">
        <div class="flex items-center gap-2 rounded-xl px-3 py-2 border border-gray-200 bg-gray-50">
          <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
          <input type="text" placeholder="Rechercher..." class="bg-transparent text-xs text-gray-600 outline-none w-40 placeholder-gray-400" />
        </div>
        <button class="w-8 h-8 rounded-xl bg-gray-50 border border-gray-200 flex items-center justify-center hover:bg-gray-100 transition-colors text-sm">🔔</button>
        <button class="w-8 h-8 rounded-xl bg-gray-50 border border-gray-200 flex items-center justify-center hover:bg-gray-100 transition-colors text-sm">⬇️</button>
        <button class="w-8 h-8 rounded-xl bg-gray-50 border border-gray-200 flex items-center justify-center hover:bg-gray-100 transition-colors text-sm">⚙️</button>
      </div>
    </div>

    <div class="px-7 py-5">

      <!-- Title + action -->
      <div class="flex items-start justify-between mb-5">
        <div>
          <h1 class="text-2xl font-bold text-gray-800">
            Fichiers
            <em class="font-bold" style="font-family: 'Cormorant Garamond', Georgia, serif; font-style: italic; color: #db2777;">Audio</em>
          </h1>
          <p class="text-gray-400 text-xs mt-1">Gérer et uploader les séances audio pour chaque protocole</p>
        </div>
        <button @click="showUpload = true"
          class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-white text-sm font-medium hover:opacity-90 transition-opacity"
          style="background-color: #1f2937;">
          🎵 Uploader audio
        </button>
      </div>

      <!-- 3 stat cards -->
      <div class="grid grid-cols-3 gap-4 mb-5">

        <!-- Stockage -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
          <p class="text-gray-500 text-sm font-medium mb-4">Stockage audio</p>
          <p class="text-3xl font-bold text-gray-800 mb-1">{{ storageUsedFormatted }}</p>
          <p class="text-gray-400 text-xs mb-3">utilisés sur 50 GB</p>
          <div class="w-full h-2 rounded-full" style="background-color: #fce7f3;">
            <div class="h-2 rounded-full transition-all"
              :style="{ width: storagePercent + '%', background: 'linear-gradient(to right, #7c3aed, #db2777)' }">
            </div>
          </div>
        </div>

        <!-- Fichiers totaux -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
          <p class="text-gray-500 text-sm font-medium mb-4">Fichiers totaux</p>
          <p class="text-3xl font-bold text-gray-800 mb-1">{{ stats.total_files }}</p>
          <p class="text-gray-400 text-xs">séances audio · {{ avgDuration }} min moy.</p>
        </div>

        <!-- Écoutes ce mois -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
          <p class="text-gray-500 text-sm font-medium mb-4">Écoutes ce mois</p>
          <p class="text-3xl font-bold text-gray-800 mb-1">{{ formatNum(stats.total_plays) }}</p>
          <p class="text-sm flex items-center gap-1" style="color: #10b981;">
            <span>↑</span> +18% vs mois dernier
          </p>
        </div>

      </div>

      <!-- Library -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <!-- Library header -->
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
          <div class="flex items-center gap-3">
            <h3 class="font-semibold text-gray-800 text-sm">Bibliothèque audio</h3>
            <span class="text-gray-400 text-xs">Tous les fichiers</span>
          </div>
          <select v-model="filterProgram"
            class="border border-gray-200 rounded-xl px-3 py-1.5 text-xs text-gray-600 outline-none focus:border-purple-400 bg-white">
            <option value="">Tous les protocoles</option>
            <option v-for="p in programs" :key="p.id" :value="p.id">{{ p.emoji }} {{ p.title }}</option>
          </select>
        </div>

        <!-- File list -->
        <div class="divide-y divide-gray-50">
          <div v-for="file in filteredFiles" :key="file.id"
            class="flex items-center gap-4 px-5 py-3.5 hover:bg-gray-50/50 transition-colors">

            <!-- Icon -->
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
              style="background: linear-gradient(135deg, #7c3aed, #db2777);">
              <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 3v10.55A4 4 0 1 0 14 17V7h4V3h-6z"/>
              </svg>
            </div>

            <!-- Info -->
            <div class="flex-1 min-w-0">
              <p class="text-sm font-semibold text-gray-800 truncate">{{ file.title }}</p>
              <p class="text-xs text-gray-400 mt-0.5 flex items-center gap-1">
                <span v-if="file.program" class="flex items-center gap-1">
                  <span class="w-2 h-2 rounded-full inline-block" :style="{ backgroundColor: programColor(file.program_id) }"></span>
                  {{ file.program.emoji }} {{ file.program.title }}
                </span>
                <span v-else class="text-gray-300">Sans protocole</span>
                <span class="text-gray-300">·</span>
                {{ file.duration_formatted }}
                <span class="text-gray-300">·</span>
                {{ file.file_size_formatted }}
              </p>
            </div>

            <!-- Status -->
            <span class="px-2.5 py-1 rounded-lg text-xs font-medium flex-shrink-0"
              :style="file.is_active
                ? 'background-color: #f0fdf4; color: #15803d;'
                : 'background-color: #fef2f2; color: #dc2626;'">
              {{ file.is_active ? 'Actif' : 'Inactif' }}
            </span>

            <!-- Play -->
            <button class="w-8 h-8 rounded-lg flex items-center justify-center border border-gray-200 hover:bg-gray-100 transition-colors text-gray-500 flex-shrink-0">
              ▶
            </button>

            <!-- Delete -->
            <Link :href="route('admin.audio.destroy', file.id)" method="delete" as="button"
              class="w-8 h-8 rounded-lg flex items-center justify-center border border-red-100 hover:bg-red-50 transition-colors text-red-400 flex-shrink-0 text-sm"
              @click.prevent="confirmDelete(file)">
              🗑
            </Link>

          </div>

          <div v-if="!filteredFiles.length" class="py-8 text-center text-gray-400 text-sm">
            Aucun fichier audio.
          </div>
        </div>

        <!-- Drop zone -->
        <div class="mx-5 mb-5 mt-2 border-2 border-dashed border-gray-200 rounded-2xl py-8 flex flex-col items-center gap-2 cursor-pointer hover:border-purple-300 transition-colors"
          @click="showUpload = true"
          @dragover.prevent
          @drop.prevent="handleDrop">
          <svg class="w-10 h-10" style="color: #db2777; opacity: 0.5;" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 3v10.55A4 4 0 1 0 14 17V7h4V3h-6z"/>
          </svg>
          <p class="text-sm font-medium text-gray-500">Glisser-déposer un fichier audio</p>
          <p class="text-xs text-gray-400">MP3, WAV, M4A · Max 100MB</p>
        </div>

      </div>
    </div>

    <!-- Upload modal -->
    <div v-if="showUpload" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4">
      <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
        <h3 class="font-semibold text-gray-800 text-base mb-4">Uploader un fichier audio</h3>

        <form @submit.prevent="submitUpload" class="space-y-4">

          <div>
            <label class="text-xs font-medium text-gray-600 block mb-1.5">Titre *</label>
            <input v-model="uploadForm.title" type="text" required placeholder="Ex : Régulation des bouffées.mp3"
              class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 outline-none focus:border-purple-400 transition-colors" />
          </div>

          <div>
            <label class="text-xs font-medium text-gray-600 block mb-1.5">Protocole</label>
            <select v-model="uploadForm.program_id"
              class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 outline-none focus:border-purple-400 bg-white">
              <option value="">Sans protocole</option>
              <option v-for="p in programs" :key="p.id" :value="p.id">{{ p.emoji }} {{ p.title }}</option>
            </select>
          </div>

          <div>
            <label class="text-xs font-medium text-gray-600 block mb-1.5">Fichier audio * (MP3, WAV, M4A · max 100MB)</label>
            <div class="border-2 border-dashed border-gray-200 rounded-xl p-4 text-center cursor-pointer hover:border-purple-300 transition-colors"
              @click="$refs.fileInput.click()">
              <p v-if="!uploadForm.audio" class="text-sm text-gray-400">Cliquer pour sélectionner</p>
              <p v-else class="text-sm font-medium text-gray-700">{{ uploadForm.audio.name }}</p>
            </div>
            <input ref="fileInput" type="file" accept=".mp3,.wav,.m4a,.aac"
              class="hidden" @change="onFileChange" />
          </div>

          <div class="flex items-center gap-3 pt-1">
            <button type="button" @click="showUpload = false"
              class="flex-1 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-600 hover:bg-gray-50 transition-colors">
              Annuler
            </button>
            <button type="submit" :disabled="uploadForm.processing || !uploadForm.audio"
              class="flex-1 py-2.5 rounded-xl text-white text-sm font-medium hover:opacity-90 disabled:opacity-50 transition-opacity"
              style="background-color: #1f2937;">
              {{ uploadForm.processing ? 'Upload…' : 'Uploader' }}
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
import { ref, computed } from 'vue'

const props = defineProps({
  audioFiles: Array,
  programs:   Array,
  stats:      Object,
})

const showUpload   = ref(false)
const filterProgram = ref('')

const filteredFiles = computed(() =>
  filterProgram.value
    ? props.audioFiles.filter(f => f.program_id == filterProgram.value)
    : props.audioFiles
)

// Storage stats
const storageUsedFormatted = computed(() => {
  const gb = props.stats.total_size / (1024 * 1024 * 1024)
  return gb < 0.1
    ? (props.stats.total_size / (1024 * 1024)).toFixed(1) + ' MB'
    : gb.toFixed(1) + ' GB'
})
const storagePercent = computed(() =>
  Math.min(100, (props.stats.total_size / (50 * 1024 * 1024 * 1024)) * 100)
)
const avgDuration = computed(() => {
  if (!props.audioFiles.length) return 0
  const avg = props.audioFiles.reduce((s, f) => s + f.duration, 0) / props.audioFiles.length
  return Math.round(avg / 60)
})

const formatNum = (n) => Number(n).toLocaleString('fr-FR')

const palettes = ['#db2777','#7c3aed','#2563eb','#f59e0b','#16a34a','#ea580c','#0891b2','#9333ea']
const programColor = (id) => palettes[(id - 1) % palettes.length]

// Upload form
const uploadForm = useForm({ title: '', program_id: '', audio: null })
const onFileChange = (e) => { uploadForm.audio = e.target.files[0] }
const handleDrop   = (e) => {
  const file = e.dataTransfer.files[0]
  if (file) { uploadForm.audio = file; showUpload.value = true }
}

const submitUpload = () => {
  uploadForm.post(route('admin.audio.store'), {
    forceFormData: true,
    onSuccess: () => { showUpload.value = false; uploadForm.reset() },
  })
}

const confirmDelete = (file) => {
  if (confirm(`Supprimer "${file.title}" ?`)) {
    useForm().delete(route('admin.audio.destroy', file.id))
  }
}
</script>
