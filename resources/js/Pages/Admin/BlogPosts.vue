<template>
  <AdminLayout>

    <!-- Top header -->
    <div class="flex items-center justify-between px-7 py-3.5 bg-white border-b border-gray-100 sticky top-0 z-10">
      <div>
        <h2 class="text-gray-800 font-semibold text-sm">Textes &amp; Contenu</h2>
        <p class="text-gray-400 text-xs">FiftyCare Admin › Textes &amp; Contenu</p>
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
            Textes &amp;
            <em class="font-bold" style="font-family: 'Cormorant Garamond', Georgia, serif; font-style: italic; color: #db2777;">Contenu</em>
          </h1>
          <p class="text-gray-400 text-xs mt-1">Modifier tous les textes, messages et contenus de l'application</p>
        </div>
        <div class="flex items-center gap-2">
          <button @click="resetAll"
            class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors">
            ✕ Annuler
          </button>
          <button @click="saveAll" :disabled="saving"
            class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-white text-sm font-medium hover:opacity-90 disabled:opacity-50 transition-opacity"
            style="background-color: #2E1545;">
            {{ saving ? 'Sauvegarde…' : '💾 Sauvegarder tout' }}
          </button>
        </div>
      </div>

      <!-- Tabs -->
      <div class="flex items-center gap-0 mb-6 border-b border-gray-200">
        <button v-for="tab in tabs" :key="tab.key"
          @click="activeTab = tab.key"
          class="px-5 py-3 text-sm font-medium transition-colors relative"
          :style="activeTab === tab.key
            ? 'color: #7c3aed;'
            : 'color: #9ca3af;'">
          {{ tab.label }}
          <span v-if="activeTab === tab.key"
            class="absolute bottom-0 left-0 right-0 h-0.5 rounded-full"
            style="background-color: #7c3aed;"></span>
        </button>
      </div>

      <!-- ONBOARDING TAB -->
      <div v-if="activeTab === 'onboarding'" class="space-y-5">

        <!-- Slide 1 -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
          <div class="flex items-center gap-3 mb-5">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center text-base flex-shrink-0"
              style="background: linear-gradient(135deg, #fce7f3, #ede9fe);">
              {{ form.ob_slide_1_emoji }}
            </div>
            <h3 class="font-semibold text-gray-800 text-sm">
              Slide 1 —
              <em style="font-family: 'Cormorant Garamond', Georgia, serif; font-style: italic; color: #db2777;">La transition</em>
            </h3>
          </div>

          <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
              <label class="text-xs font-medium text-gray-500 block mb-1.5">Numéro</label>
              <input v-model="form.ob_slide_1_number" type="text"
                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 outline-none focus:border-purple-400 transition-colors" />
            </div>
            <div>
              <label class="text-xs font-medium text-gray-500 block mb-1.5">Langue</label>
              <select class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 outline-none focus:border-purple-400 bg-white">
                <option>🇫🇷 Français</option>
                <option>🇬🇧 English</option>
              </select>
            </div>
          </div>

          <div class="mb-4">
            <label class="text-xs font-medium text-gray-500 block mb-1.5">Titre <span class="text-gray-400 font-normal">(HTML autorisé pour &lt;em&gt;)</span></label>
            <input v-model="form.ob_slide_1_title" type="text"
              class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 outline-none focus:border-purple-400 transition-colors" />
          </div>

          <div class="mb-4">
            <label class="text-xs font-medium text-gray-500 block mb-1.5">Corps du texte</label>
            <textarea v-model="form.ob_slide_1_body" rows="3"
              class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 outline-none focus:border-purple-400 transition-colors resize-none"></textarea>
          </div>

          <div class="mb-5">
            <label class="text-xs font-medium text-gray-500 block mb-1.5">Emoji / Illustration</label>
            <input v-model="form.ob_slide_1_emoji" type="text"
              class="w-24 border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 outline-none focus:border-purple-400 transition-colors text-center text-lg" />
          </div>

          <button @click="saveSection(['ob_slide_1_number','ob_slide_1_title','ob_slide_1_body','ob_slide_1_emoji'])"
            class="px-4 py-2.5 rounded-xl text-white text-sm font-medium hover:opacity-90 transition-opacity"
            style="background-color: #1f2937;">
            💾 Sauvegarder
          </button>
        </div>

        <!-- Slide 2 -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
          <div class="flex items-center gap-3 mb-5">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center text-base flex-shrink-0"
              style="background: linear-gradient(135deg, #fce7f3, #ede9fe);">
              {{ form.ob_slide_2_emoji }}
            </div>
            <h3 class="font-semibold text-gray-800 text-sm">
              Slide 2 —
              <em style="font-family: 'Cormorant Garamond', Georgia, serif; font-style: italic; color: #db2777;">La science</em>
            </h3>
          </div>

          <div class="mb-4">
            <label class="text-xs font-medium text-gray-500 block mb-1.5">Titre <span class="text-gray-400 font-normal">(HTML autorisé pour &lt;em&gt;)</span></label>
            <input v-model="form.ob_slide_2_title" type="text"
              class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 outline-none focus:border-purple-400 transition-colors" />
          </div>

          <div class="mb-4">
            <label class="text-xs font-medium text-gray-500 block mb-1.5">Corps du texte</label>
            <textarea v-model="form.ob_slide_2_body" rows="3"
              class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 outline-none focus:border-purple-400 transition-colors resize-none"></textarea>
          </div>

          <div class="mb-5">
            <label class="text-xs font-medium text-gray-500 block mb-1.5">Emoji / Illustration</label>
            <input v-model="form.ob_slide_2_emoji" type="text"
              class="w-24 border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 outline-none focus:border-purple-400 transition-colors text-center text-lg" />
          </div>

          <button @click="saveSection(['ob_slide_2_title','ob_slide_2_body','ob_slide_2_emoji'])"
            class="px-4 py-2.5 rounded-xl text-white text-sm font-medium hover:opacity-90 transition-opacity"
            style="background-color: #1f2937;">
            💾 Sauvegarder
          </button>
        </div>

        <!-- Slide 3 -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
          <div class="flex items-center gap-3 mb-5">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center text-base flex-shrink-0"
              style="background: linear-gradient(135deg, #fce7f3, #ede9fe);">
              {{ form.ob_slide_3_emoji }}
            </div>
            <h3 class="font-semibold text-gray-800 text-sm">
              Slide 3 —
              <em style="font-family: 'Cormorant Garamond', Georgia, serif; font-style: italic; color: #db2777;">Les résultats</em>
            </h3>
          </div>

          <div class="mb-4">
            <label class="text-xs font-medium text-gray-500 block mb-1.5">Titre <span class="text-gray-400 font-normal">(HTML autorisé pour &lt;em&gt;)</span></label>
            <input v-model="form.ob_slide_3_title" type="text"
              class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 outline-none focus:border-purple-400 transition-colors" />
          </div>

          <div class="mb-4">
            <label class="text-xs font-medium text-gray-500 block mb-1.5">Corps du texte</label>
            <textarea v-model="form.ob_slide_3_body" rows="3"
              class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 outline-none focus:border-purple-400 transition-colors resize-none"></textarea>
          </div>

          <div class="grid grid-cols-2 gap-4 mb-5">
            <div>
              <label class="text-xs font-medium text-gray-500 block mb-1.5">Chiffre clé <span class="text-gray-400 font-normal">(affiché en grand)</span></label>
              <input v-model="form.ob_slide_3_stat" type="text"
                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 outline-none focus:border-purple-400 transition-colors" />
            </div>
            <div>
              <label class="text-xs font-medium text-gray-500 block mb-1.5">Emoji / Illustration</label>
              <input v-model="form.ob_slide_3_emoji" type="text"
                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 outline-none focus:border-purple-400 transition-colors text-center text-lg" />
            </div>
          </div>

          <button @click="saveSection(['ob_slide_3_title','ob_slide_3_body','ob_slide_3_stat','ob_slide_3_emoji'])"
            class="px-4 py-2.5 rounded-xl text-white text-sm font-medium hover:opacity-90 transition-opacity"
            style="background-color: #1f2937;">
            💾 Sauvegarder
          </button>
        </div>

        <!-- Textes de l'inscription -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
          <div class="flex items-center gap-3 mb-5">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center text-base flex-shrink-0"
              style="background: linear-gradient(135deg, #fce7f3, #ede9fe);">
              💎
            </div>
            <h3 class="font-semibold text-gray-800 text-sm">
              <em style="font-family: 'Cormorant Garamond', Georgia, serif; font-style: italic; color: #db2777;">Textes de l'inscription</em>
            </h3>
          </div>

          <div class="mb-4">
            <label class="text-xs font-medium text-gray-500 block mb-1.5">Titre page inscription <span class="text-gray-400 font-normal">(HTML autorisé pour &lt;em&gt;)</span></label>
            <input v-model="form.reg_title" type="text"
              class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 outline-none focus:border-purple-400 transition-colors" />
          </div>

          <div class="mb-4">
            <label class="text-xs font-medium text-gray-500 block mb-1.5">Sous-titre</label>
            <input v-model="form.reg_subtitle" type="text"
              class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 outline-none focus:border-purple-400 transition-colors" />
          </div>

          <div class="mb-4">
            <label class="text-xs font-medium text-gray-500 block mb-1.5">Message bienvenue freemium</label>
            <textarea v-model="form.reg_welcome" rows="2"
              class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 outline-none focus:border-purple-400 transition-colors resize-none"></textarea>
          </div>

          <div class="mb-4">
            <label class="text-xs font-medium text-gray-500 block mb-1.5">Témoignage page bienvenue</label>
            <textarea v-model="form.reg_testimonial" rows="3"
              class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 outline-none focus:border-purple-400 transition-colors resize-none"></textarea>
          </div>

          <div class="mb-5">
            <label class="text-xs font-medium text-gray-500 block mb-1.5">Auteur témoignage</label>
            <input v-model="form.reg_testimonial_author" type="text"
              class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 outline-none focus:border-purple-400 transition-colors" />
          </div>

          <button @click="saveSection(['reg_title','reg_subtitle','reg_welcome','reg_testimonial','reg_testimonial_author'])"
            class="px-4 py-2.5 rounded-xl text-white text-sm font-medium hover:opacity-90 transition-opacity"
            style="background-color: #1f2937;">
            💾 Sauvegarder
          </button>
        </div>

      </div>

      <!-- OTHER TABS PLACEHOLDER -->
      <div v-else class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
        <p class="text-4xl mb-3">🚧</p>
        <p class="text-gray-500 text-sm font-medium">Section en cours de développement</p>
        <p class="text-gray-400 text-xs mt-1">Disponible prochainement</p>
      </div>

    </div>

  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { router } from '@inertiajs/vue3'
import { reactive, ref } from 'vue'

const props = defineProps({ settings: Object })

const activeTab = ref('onboarding')
const saving = ref(false)

const tabs = [
  { key: 'onboarding', label: 'Onboarding' },
  { key: 'protocoles', label: 'Protocoles' },
  { key: 'emails',     label: 'Emails & Push' },
  { key: 'notice',     label: 'Notice' },
]

const form = reactive({ ...props.settings })

const saveSection = (keys) => {
  const payload = {}
  keys.forEach(k => { payload[k] = form[k] })
  saving.value = true
  router.post(route('admin.settings.update'), { settings: payload }, {
    preserveState: true,
    onFinish: () => { saving.value = false },
  })
}

const saveAll = () => {
  saving.value = true
  router.post(route('admin.settings.update'), { settings: { ...form } }, {
    preserveState: true,
    onFinish: () => { saving.value = false },
  })
}

const resetAll = () => {
  Object.assign(form, props.settings)
}
</script>
