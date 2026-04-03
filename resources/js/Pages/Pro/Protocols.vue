<template>
  <ProLayout>
    <div class="max-w-5xl">

      <!-- Header page -->
      <div class="flex items-center justify-between mb-8">
        <div>
          <h1 class="font-serif text-3xl font-light text-white mb-1">Protocols</h1>
          <p class="text-sm" style="color: #9DAAC0;">{{ protocols.length }} protocol{{ protocols.length !== 1 ? 's' : '' }} assigned</p>
        </div>
        <button @click="showAssign = true"
          class="bg-[#11C7C9] hover:bg-[#0db5b7] text-[#03142A] font-bold text-sm tracking-wide uppercase px-5 py-2.5 rounded transition-all">
          + Assign Protocol
        </button>
      </div>

      <!-- Flash success -->
      <div v-if="$page.props.flash?.success"
        class="rounded-xl p-4 mb-6 text-sm"
        style="background: rgba(17,199,201,0.1); border: 1px solid rgba(17,199,201,0.3); color: #11C7C9;">
        {{ $page.props.flash.success }}
      </div>

      <!-- Protocols list -->
      <div v-if="protocols.length" class="space-y-3">
        <div v-for="p in protocols" :key="p.id"
          class="rounded-xl p-5 transition-all"
          style="background: rgba(10,39,69,0.5); border: 1px solid rgba(255,255,255,0.07);">
          <div class="flex items-center justify-between flex-wrap gap-4">

            <!-- Program info -->
            <div class="flex items-center gap-3 flex-1">
              <div class="w-10 h-10 rounded-lg flex items-center justify-center text-xl flex-shrink-0"
                style="background: rgba(17,199,201,0.1);">
                {{ p.program?.emoji || '✨' }}
              </div>
              <div>
                <p class="text-white font-semibold text-sm">{{ p.program?.title || 'Program' }}</p>
                <p class="text-[11px] mt-0.5" style="color: #9DAAC0;">
                  Patient: <span style="color: #D5B67A;">{{ p.patient?.name }}</span>
                </p>
              </div>
            </div>

            <!-- Notes -->
            <p v-if="p.notes" class="text-[11px] italic hidden md:block" style="color: #9DAAC0; max-width: 200px;">
              "{{ p.notes }}"
            </p>

            <!-- Status selector -->
            <select :value="p.status"
              @change="updateStatus(p, $event.target.value)"
              class="text-[11px] font-semibold rounded-full px-3 py-1.5 focus:outline-none transition-all"
              :style="p.status === 'assigned' ? 'background: rgba(17,199,201,0.1); color: #11C7C9; border: 1px solid rgba(17,199,201,0.3);'
                : p.status === 'in_progress' ? 'background: rgba(213,182,122,0.1); color: #D5B67A; border: 1px solid rgba(213,182,122,0.3);'
                : 'background: rgba(34,197,94,0.1); color: #4ade80; border: 1px solid rgba(34,197,94,0.3);'">
              <option value="assigned">Assigned</option>
              <option value="in_progress">In Progress</option>
              <option value="completed">Completed</option>
            </select>

            <!-- Date -->
            <p class="text-[10px]" style="color: rgba(157,170,192,0.5);">
              {{ formatDate(p.created_at) }}
            </p>
          </div>

          <!-- Progress bar -->
          <div v-if="p.status === 'in_progress'" class="mt-4">
            <div class="flex items-center justify-between mb-1">
              <span class="text-[10px] uppercase tracking-wide" style="color: #9DAAC0;">Progress</span>
              <span class="text-[10px]" style="color: #11C7C9;">{{ p.progress_percent || 0 }}%</span>
            </div>
            <div class="h-1.5 rounded-full overflow-hidden" style="background: rgba(255,255,255,0.08);">
              <div class="h-full rounded-full transition-all"
                style="background: #11C7C9;"
                :style="`width: ${p.progress_percent || 0}%`"></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty state -->
      <div v-else
        class="rounded-2xl p-12 text-center"
        style="background: rgba(10,39,69,0.4); border: 1px solid rgba(255,255,255,0.07);">
        <div class="text-5xl mb-4">🎯</div>
        <p class="text-white font-semibold mb-2">No protocols yet</p>
        <p class="text-sm mb-6" style="color: #9DAAC0;">Assign a protocol to one of your patients to get started.</p>
        <button @click="showAssign = true"
          class="bg-[#11C7C9] hover:bg-[#0db5b7] text-[#03142A] font-bold text-sm uppercase px-6 py-2.5 rounded transition-all">
          + Assign First Protocol
        </button>
      </div>

    </div>

    <!-- ═══ Assign Protocol Modal ═══ -->
    <div v-if="showAssign" class="fixed inset-0 z-50 flex items-center justify-center px-4"
      style="background: rgba(0,0,0,0.6); backdrop-filter: blur(6px);">
      <div class="rounded-3xl p-8 w-full max-w-md"
        style="background: rgba(4,27,51,0.98); border: 1px solid rgba(255,255,255,0.1);">
        <h3 class="font-serif text-xl text-white font-light mb-6">Assign Protocol</h3>
        <form @submit.prevent="assignProtocol" class="space-y-4">
          <select v-model="protocolForm.patient_id"
            class="w-full rounded-xl px-4 py-3 text-white text-sm focus:outline-none"
            style="background: rgba(3,20,42,0.8); border: 1px solid rgba(255,255,255,0.1);">
            <option value="" disabled>Select patient…</option>
            <option v-for="pt in patients" :key="pt.id" :value="pt.id">{{ pt.name }}</option>
          </select>
          <select v-model="protocolForm.program_id"
            class="w-full rounded-xl px-4 py-3 text-white text-sm focus:outline-none"
            style="background: rgba(3,20,42,0.8); border: 1px solid rgba(255,255,255,0.1);">
            <option value="" disabled>Select program…</option>
            <option v-for="pg in programs" :key="pg.id" :value="pg.id">{{ pg.emoji }} {{ pg.title }}</option>
          </select>
          <textarea v-model="protocolForm.notes" rows="3" placeholder="Clinical notes (optional)"
            class="w-full rounded-xl px-4 py-3 text-white text-sm focus:outline-none resize-none"
            style="background: rgba(3,20,42,0.8); border: 1px solid rgba(255,255,255,0.1);"></textarea>
          <div class="flex gap-3 pt-2">
            <button type="button" @click="showAssign = false"
              class="flex-1 text-sm font-semibold py-2.5 rounded transition-all"
              style="border: 1px solid rgba(255,255,255,0.15); color: #9DAAC0;">Cancel</button>
            <button type="submit" :disabled="protocolForm.processing"
              class="flex-1 bg-[#11C7C9] hover:bg-[#0db5b7] text-[#03142A] font-bold text-sm py-2.5 rounded transition-all disabled:opacity-50">
              Assign Protocol
            </button>
          </div>
        </form>
      </div>
    </div>

  </ProLayout>
</template>

<script setup>
import ProLayout from '@/Layouts/ProLayout.vue'
import { useForm, router } from '@inertiajs/vue3'
import { ref } from 'vue'

defineProps({ patients: Array, programs: Array, protocols: Array, pro: Object })

const showAssign  = ref(false)
const protocolForm = useForm({ patient_id: '', program_id: '', notes: '' })

const assignProtocol = () => {
  protocolForm.post(route('pro.protocols.assign'), {
    onSuccess: () => { showAssign.value = false; protocolForm.reset() }
  })
}

const updateStatus = (protocol, status) => {
  router.put(route('pro.protocols.update', protocol.id), { status }, { preserveScroll: true })
}

const formatDate = (dateStr) => {
  if (!dateStr) return ''
  return new Date(dateStr).toLocaleDateString('fr-FR', { day: '2-digit', month: 'short', year: 'numeric' })
}
</script>
