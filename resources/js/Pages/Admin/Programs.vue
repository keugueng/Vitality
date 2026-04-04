<template>
  <AdminLayout>

    <!-- Top header -->
    <div class="flex items-center justify-between px-7 py-3.5 bg-white border-b border-gray-100 sticky top-0 z-10">
      <div>
        <h2 class="text-gray-800 font-semibold text-sm">Protocoles</h2>
        <p class="text-gray-400 text-xs">FiftyCare Admin › Protocoles</p>
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

      <!-- Title + actions -->
      <div class="flex items-start justify-between mb-5">
        <div>
          <h1 class="text-2xl font-bold text-gray-800">
            Gestion des
            <em class="font-bold" style="font-family: 'Cormorant Garamond', Georgia, serif; font-style: italic; color: #db2777;">Protocoles</em>
          </h1>
          <p class="text-gray-400 text-xs mt-1">Modifier les titres, étapes, durées et calendriers de chaque protocole</p>
        </div>
        <div class="flex items-center gap-2 mt-0.5">
          <button @click="duplicateSelected"
            class="flex items-center gap-1.5 px-3.5 py-2 rounded-xl border border-gray-200 bg-white text-gray-700 text-xs font-medium hover:bg-gray-50 transition-colors"
            :disabled="!selected">
            📋 Dupliquer
          </button>
          <button @click="openNew"
            class="flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-white text-xs font-medium hover:opacity-90 transition-opacity"
            style="background-color: #1f2937;">
            + Nouveau protocole
          </button>
        </div>
      </div>

      <!-- Two-column layout -->
      <div class="flex gap-4 items-start">

        <!-- LEFT: protocol list -->
        <div class="flex-1 min-w-0">
          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- List header -->
            <div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2">
              <span class="text-base">📋</span>
              <h3 class="font-semibold text-gray-800 text-sm">
                Liste des protocoles
                <span class="text-gray-400 font-normal">({{ programs.length }})</span>
              </h3>
            </div>

            <!-- Items -->
            <div class="divide-y divide-gray-50">
              <div v-for="p in programs" :key="p.id"
                class="flex items-center gap-3 px-5 py-3.5 hover:bg-gray-50/60 transition-colors cursor-pointer"
                :style="selected?.id === p.id ? 'background-color: #f5f0ff; border-left: 3px solid #7c3aed;' : 'border-left: 3px solid transparent;'"
                @click="selectProgram(p)">

                <!-- Emoji icon -->
                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl flex-shrink-0"
                  :style="{ backgroundColor: iconBg(p) }">
                  {{ p.emoji || '✨' }}
                </div>

                <!-- Info -->
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-semibold text-gray-800">{{ p.title_fr || p.title }}</p>
                  <p class="text-xs text-gray-400 mt-0.5">
                    {{ p.session_duration || '3 séances' }} · {{ p.cure_duration || '10 jours' }}
                    · Priorité {{ p.priority || p.sort_order || '—' }}
                    · <span :class="p.price > 0 ? 'text-purple-600 font-medium' : 'text-gray-400'">
                        {{ p.price > 0 ? 'Premium' : 'Gratuit' }}
                      </span>
                  </p>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-1.5 flex-shrink-0">
                  <button @click.stop="selectProgram(p)"
                    class="flex items-center gap-1 px-2.5 py-1.5 rounded-lg border border-gray-200 text-xs font-medium text-gray-600 hover:bg-gray-100 transition-colors">
                    ✏️ Éditer
                  </button>
                  <button @click.stop="confirmDelete(p)"
                    class="w-7 h-7 rounded-lg flex items-center justify-center border border-red-100 text-red-400 hover:bg-red-50 transition-colors text-sm">
                    🗑
                  </button>
                </div>
              </div>

              <div v-if="!programs.length" class="py-12 text-center text-gray-400 text-sm">
                Aucun protocole pour l'instant.
              </div>
            </div>
          </div>
        </div>

        <!-- RIGHT: inline editor -->
        <div class="w-80 flex-shrink-0">
          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <!-- Editor header -->
            <div class="px-5 py-4 border-b border-gray-100 flex items-start justify-between">
              <div>
                <h3 class="font-semibold text-gray-800 text-sm flex items-center gap-1.5">
                  ✏️ {{ selected ? `Éditer : ${selected.title_fr || selected.title}` : 'Nouveau protocole' }}
                </h3>
                <p class="text-gray-400 text-xs mt-0.5">
                  {{ selected ? 'Sélectionnez un protocole pour l\'éditer' : 'Remplissez les champs ci-dessous' }}
                </p>
              </div>
              <button @click="submitForm" :disabled="form.processing"
                class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-white text-xs font-medium hover:opacity-90 disabled:opacity-50 flex-shrink-0"
                style="background-color: #1f2937;">
                {{ form.processing ? '…' : '💾 Sauvegarder' }}
              </button>
            </div>

            <!-- Form fields -->
            <div class="p-5 space-y-4">

              <!-- Emoji -->
              <div>
                <label class="text-xs font-medium text-gray-600 block mb-1.5">Emoji</label>
                <div class="flex items-center gap-2">
                  <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl border border-gray-200 bg-gray-50">
                    {{ form.emoji || '✨' }}
                  </div>
                  <input v-model="form.emoji" type="text" maxlength="4" placeholder="✨"
                    class="flex-1 border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-800 outline-none focus:border-purple-400 transition-colors" />
                </div>
              </div>

              <!-- Nom du protocole -->
              <div>
                <label class="text-xs font-medium text-gray-600 block mb-1.5">Nom du protocole</label>
                <input v-model="form.title_fr" type="text" placeholder="Ex : Sérénité"
                  class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-800 outline-none focus:border-purple-400 transition-colors" />
              </div>

              <!-- Nom EN -->
              <div>
                <label class="text-xs font-medium text-gray-600 block mb-1.5">Nom (EN)</label>
                <input v-model="form.title" type="text" placeholder="Ex : Serenity"
                  class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-800 outline-none focus:border-purple-400 transition-colors" />
              </div>

              <!-- Priorité + Prix -->
              <div class="grid grid-cols-2 gap-3">
                <div>
                  <label class="text-xs font-medium text-gray-600 block mb-1.5">Priorité</label>
                  <input v-model="form.sort_order" type="number" min="1" placeholder="1"
                    class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-800 outline-none focus:border-purple-400 transition-colors" />
                </div>
                <div>
                  <label class="text-xs font-medium text-gray-600 block mb-1.5">Prix (€)</label>
                  <input v-model="form.price" type="number" step="0.01" placeholder="0"
                    class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-800 outline-none focus:border-purple-400 transition-colors" />
                </div>
              </div>

              <!-- Durées -->
              <div class="grid grid-cols-2 gap-3">
                <div>
                  <label class="text-xs font-medium text-gray-600 block mb-1.5">Séances</label>
                  <input v-model="form.session_duration" type="text" placeholder="3 séances"
                    class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-800 outline-none focus:border-purple-400 transition-colors" />
                </div>
                <div>
                  <label class="text-xs font-medium text-gray-600 block mb-1.5">Durée</label>
                  <input v-model="form.cure_duration" type="text" placeholder="10 jours"
                    class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-800 outline-none focus:border-purple-400 transition-colors" />
                </div>
              </div>

              <!-- Étapes du protocole -->
              <div>
                <label class="text-xs font-medium text-gray-600 block mb-2">Étapes du protocole</label>
                <div class="space-y-2">
                  <div v-for="(step, i) in steps" :key="i"
                    class="flex items-center gap-2 p-2 rounded-xl border border-gray-100 bg-gray-50/50">
                    <div class="w-5 h-5 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0"
                      style="background-color: #7c3aed; font-size: 10px;">
                      {{ i + 1 }}
                    </div>
                    <input v-model="steps[i]" type="text"
                      class="flex-1 bg-transparent text-sm text-gray-700 outline-none placeholder-gray-400"
                      :placeholder="`Étape ${i + 1}`" />
                    <span class="text-gray-300 cursor-grab text-sm">⋮⋮</span>
                    <button @click="removeStep(i)"
                      class="w-5 h-5 rounded flex items-center justify-center text-red-400 hover:bg-red-50 transition-colors text-sm flex-shrink-0">
                      ✕
                    </button>
                  </div>
                </div>
                <button @click="addStep"
                  class="mt-2 text-xs font-medium flex items-center gap-1 hover:opacity-80 transition-opacity"
                  style="color: #7c3aed;">
                  + Ajouter une étape
                </button>
              </div>

              <!-- Description FR -->
              <div>
                <label class="text-xs font-medium text-gray-600 block mb-1.5">Description (FR)</label>
                <textarea v-model="form.short_desc_fr" rows="2" placeholder="Courte description…"
                  class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-800 outline-none focus:border-purple-400 transition-colors resize-none"></textarea>
              </div>

              <!-- Catégorie -->
              <div>
                <label class="text-xs font-medium text-gray-600 block mb-1.5">Catégorie</label>
                <select v-model="form.category_id"
                  class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-800 outline-none focus:border-purple-400 transition-colors bg-white">
                  <option value="">Sans catégorie</option>
                  <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.emoji }} {{ c.name }}</option>
                </select>
              </div>

              <!-- Calendrier header -->
              <div>
                <label class="text-xs font-medium text-gray-600 block mb-2">Calendrier (affiché dans l'app)</label>
                <div class="space-y-1.5">
                  <div v-for="(entry, i) in calendar" :key="i"
                    class="flex items-center gap-2 p-2 rounded-xl border border-gray-100 bg-gray-50/50">
                    <input v-model="calendar[i]" type="text"
                      class="flex-1 bg-transparent text-xs text-gray-700 outline-none placeholder-gray-400"
                      :placeholder="`Jour ${i + 1} — Étapes…`" />
                    <button @click="removeCalendarEntry(i)" class="text-red-300 hover:text-red-400 text-sm transition-colors">✕</button>
                  </div>
                </div>
                <button @click="addCalendarEntry"
                  class="mt-2 text-xs font-medium flex items-center gap-1 hover:opacity-80 transition-opacity"
                  style="color: #7c3aed;">
                  + Ajouter un jour
                </button>
              </div>

              <!-- Checkboxes -->
              <div class="flex items-center gap-4 pt-1">
                <label class="flex items-center gap-1.5 text-xs text-gray-600 cursor-pointer">
                  <input v-model="form.is_active" type="checkbox" class="rounded" /> Actif
                </label>
                <label class="flex items-center gap-1.5 text-xs text-gray-600 cursor-pointer">
                  <input v-model="form.is_bestseller" type="checkbox" class="rounded" /> Populaire
                </label>
                <label class="flex items-center gap-1.5 text-xs text-gray-600 cursor-pointer">
                  <input v-model="form.is_featured" type="checkbox" class="rounded" /> Mis en avant
                </label>
              </div>

              <!-- Cancel -->
              <button v-if="selected" @click="closeEditor"
                class="w-full py-2 rounded-xl border border-gray-200 text-xs text-gray-500 hover:bg-gray-50 transition-colors">
                Annuler
              </button>

            </div>
          </div>
        </div>

      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({ programs: Array, categories: Array })

const selected = ref(null)
const steps    = ref([''])
const calendar = ref([''])

// Palette for emoji backgrounds
const palettes = ['#fce7f3','#ede9fe','#dbeafe','#fef3c7','#d1fae5','#fee2e2','#e0e7ff','#fdf2f8']
const iconBg = (p) => palettes[((p.id || 1) - 1) % palettes.length]

const form = useForm({
  category_id: '', title: '', title_fr: '', emoji: '', short_desc: '', short_desc_fr: '',
  session_duration: '', cure_duration: '', price: 0, sort_order: 1,
  is_active: true, is_bestseller: false, is_featured: false,
})

const selectProgram = (p) => {
  selected.value = p
  Object.assign(form, {
    category_id:      p.category_id    ?? '',
    title:            p.title          ?? '',
    title_fr:         p.title_fr       ?? '',
    emoji:            p.emoji          ?? '',
    short_desc:       p.short_desc     ?? '',
    short_desc_fr:    p.short_desc_fr  ?? '',
    session_duration: p.session_duration ?? '',
    cure_duration:    p.cure_duration    ?? '',
    price:            p.price           ?? 0,
    sort_order:       p.sort_order      ?? 1,
    is_active:        p.is_active       ?? true,
    is_bestseller:    p.is_bestseller   ?? false,
    is_featured:      p.is_featured     ?? false,
  })
  // Parse steps from short_desc if JSON, else default
  try {
    const parsed = JSON.parse(p.steps || '[]')
    steps.value = parsed.length ? parsed : ['']
  } catch { steps.value = [''] }
  calendar.value = ['Jour 1 — Étapes 1 et 2', 'Jour 4 — Étape 3']
}

const openNew = () => {
  selected.value = null
  form.reset()
  steps.value = ['']
  calendar.value = ['']
}

const closeEditor = () => { selected.value = null; form.reset() }

const submitForm = () => {
  if (selected.value) {
    form.put(route('admin.programs.update', selected.value.id), { onSuccess: closeEditor })
  } else {
    form.post(route('admin.programs.store'), { onSuccess: closeEditor })
  }
}

const confirmDelete = (p) => {
  if (confirm(`Supprimer "${p.title_fr || p.title}" ?`)) {
    useForm().delete(route('admin.programs.destroy', p.id))
  }
}

const duplicateSelected = () => {
  if (!selected.value) return
  form.post(route('admin.programs.store'))
}

const addStep         = () => steps.value.push('')
const removeStep      = (i) => steps.value.splice(i, 1)
const addCalendarEntry    = () => calendar.value.push('')
const removeCalendarEntry = (i) => calendar.value.splice(i, 1)
</script>
