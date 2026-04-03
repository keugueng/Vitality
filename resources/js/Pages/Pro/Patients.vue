<template>
  <ProLayout>
    <div class="max-w-5xl">

      <!-- Header page -->
      <div class="flex items-center justify-between mb-8">
        <div>
          <h1 class="font-serif text-3xl font-light text-white mb-1">My Patients</h1>
          <p class="text-sm" style="color: #9DAAC0;">{{ patients.length }} patient{{ patients.length !== 1 ? 's' : '' }} registered</p>
        </div>
        <button @click="showAddPatient = true"
          class="bg-[#11C7C9] hover:bg-[#0db5b7] text-[#03142A] font-bold text-sm tracking-wide uppercase px-5 py-2.5 rounded transition-all">
          + Add Patient
        </button>
      </div>

      <!-- Flash success -->
      <div v-if="$page.props.flash?.success"
        class="rounded-xl p-4 mb-6 text-sm"
        style="background: rgba(17,199,201,0.1); border: 1px solid rgba(17,199,201,0.3); color: #11C7C9;">
        {{ $page.props.flash.success }}
      </div>

      <!-- Patient list -->
      <div v-if="patients.length" class="space-y-3">
        <div v-for="patient in patients" :key="patient.id"
          class="rounded-xl p-5 flex items-center justify-between transition-all"
          style="background: rgba(10,39,69,0.5); border: 1px solid rgba(255,255,255,0.07);"
          @mouseover="$event.currentTarget.style.borderColor='rgba(255,255,255,0.15)'"
          @mouseout="$event.currentTarget.style.borderColor='rgba(255,255,255,0.07)'">

          <div class="flex items-center gap-4 flex-1">
            <!-- Avatar initiale -->
            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm flex-shrink-0"
              style="background: rgba(17,199,201,0.15); color: #11C7C9;">
              {{ patient.name.charAt(0).toUpperCase() }}
            </div>
            <div class="flex-1">
              <p class="text-white font-semibold text-sm">{{ patient.name }}</p>
              <p class="text-[11px] mt-0.5" style="color: #9DAAC0;">
                {{ patient.email || 'No email' }}
                <span v-if="patient.phone"> · {{ patient.phone }}</span>
              </p>
            </div>
          </div>

          <!-- Protocols badges -->
          <div class="flex items-center gap-2 mx-4">
            <span v-for="p in (patient.protocols || []).slice(0,3)" :key="p.id"
              class="text-lg" :title="p.program?.title">
              {{ p.program?.emoji || '✨' }}
            </span>
            <span v-if="(patient.protocols||[]).length > 3"
              class="text-[10px]" style="color: #9DAAC0;">
              +{{ patient.protocols.length - 3 }}
            </span>
          </div>

          <!-- Protocol count + status -->
          <div class="text-right mr-4 hidden md:block">
            <p class="text-white text-sm font-semibold">{{ (patient.protocols||[]).length }}</p>
            <p class="text-[10px] uppercase tracking-wide" style="color: #9DAAC0;">Protocol{{ (patient.protocols||[]).length !== 1 ? 's' : '' }}</p>
          </div>

          <!-- Status badge -->
          <span class="text-[10px] font-semibold tracking-wide uppercase px-2.5 py-1 rounded-full"
            :style="patient.status === 'active'
              ? 'background: rgba(17,199,201,0.1); color: #11C7C9; border: 1px solid rgba(17,199,201,0.3);'
              : 'background: rgba(157,170,192,0.1); color: #9DAAC0; border: 1px solid rgba(157,170,192,0.2);'">
            {{ patient.status || 'active' }}
          </span>

          <!-- Actions -->
          <div class="flex items-center gap-2 ml-4">
            <button @click="openAssign(patient)"
              class="text-[11px] font-semibold px-3 py-1.5 rounded transition-all"
              style="border: 1px solid rgba(213,182,122,0.4); color: #D5B67A;"
              onmouseover="this.style.background='rgba(213,182,122,0.08)'"
              onmouseout="this.style.background='transparent'">
              Assign Protocol
            </button>
            <Link :href="route('pro.patients.destroy', patient.id)" method="delete" as="button"
              class="text-[11px] font-semibold px-2.5 py-1.5 rounded transition-all"
              style="color: rgba(157,170,192,0.4);"
              onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='rgba(157,170,192,0.4)'"
              onclick="return confirm('Remove this patient?')">
              ✕
            </Link>
          </div>
        </div>
      </div>

      <!-- Empty state -->
      <div v-else
        class="rounded-2xl p-12 text-center"
        style="background: rgba(10,39,69,0.4); border: 1px solid rgba(255,255,255,0.07);">
        <div class="text-5xl mb-4">👥</div>
        <p class="text-white font-semibold mb-2">No patients yet</p>
        <p class="text-sm mb-6" style="color: #9DAAC0;">Start by adding your first patient and assigning a protocol.</p>
        <button @click="showAddPatient = true"
          class="bg-[#11C7C9] hover:bg-[#0db5b7] text-[#03142A] font-bold text-sm uppercase px-6 py-2.5 rounded transition-all">
          + Add First Patient
        </button>
      </div>
    </div>

    <!-- ═══ Add Patient Modal ═══ -->
    <div v-if="showAddPatient" class="fixed inset-0 z-50 flex items-center justify-center px-4"
      style="background: rgba(0,0,0,0.6); backdrop-filter: blur(6px);">
      <div class="rounded-3xl p-8 w-full max-w-md"
        style="background: rgba(4,27,51,0.98); border: 1px solid rgba(255,255,255,0.1);">
        <h3 class="font-serif text-xl text-white font-light mb-6">Add Patient</h3>
        <form @submit.prevent="addPatient" class="space-y-4">
          <input v-model="patientForm.name" type="text" required placeholder="Full name *"
            class="w-full rounded-xl px-4 py-3 text-white text-sm focus:outline-none"
            style="background: rgba(3,20,42,0.8); border: 1px solid rgba(255,255,255,0.1);"/>
          <input v-model="patientForm.email" type="email" placeholder="Email (optional)"
            class="w-full rounded-xl px-4 py-3 text-white text-sm focus:outline-none"
            style="background: rgba(3,20,42,0.8); border: 1px solid rgba(255,255,255,0.1);"/>
          <input v-model="patientForm.phone" type="tel" placeholder="Phone (optional)"
            class="w-full rounded-xl px-4 py-3 text-white text-sm focus:outline-none"
            style="background: rgba(3,20,42,0.8); border: 1px solid rgba(255,255,255,0.1);"/>
          <textarea v-model="patientForm.medical_history" rows="3" placeholder="Medical history / notes (optional)"
            class="w-full rounded-xl px-4 py-3 text-white text-sm focus:outline-none resize-none"
            style="background: rgba(3,20,42,0.8); border: 1px solid rgba(255,255,255,0.1);"></textarea>
          <div class="flex gap-3 pt-2">
            <button type="button" @click="showAddPatient = false"
              class="flex-1 text-sm font-semibold py-2.5 rounded transition-all"
              style="border: 1px solid rgba(255,255,255,0.15); color: #9DAAC0;">Cancel</button>
            <button type="submit" :disabled="patientForm.processing"
              class="flex-1 bg-[#11C7C9] hover:bg-[#0db5b7] text-[#03142A] font-bold text-sm py-2.5 rounded transition-all disabled:opacity-50">
              Add Patient
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- ═══ Assign Protocol Modal ═══ -->
    <div v-if="assignTarget" class="fixed inset-0 z-50 flex items-center justify-center px-4"
      style="background: rgba(0,0,0,0.6); backdrop-filter: blur(6px);">
      <div class="rounded-3xl p-8 w-full max-w-md"
        style="background: rgba(4,27,51,0.98); border: 1px solid rgba(255,255,255,0.1);">
        <h3 class="font-serif text-xl text-white font-light mb-1">Assign Protocol</h3>
        <p class="text-sm mb-6" style="color: #9DAAC0;">Patient: <span style="color: #D5B67A;">{{ assignTarget.name }}</span></p>
        <form @submit.prevent="assignProtocol" class="space-y-4">
          <select v-model="protocolForm.program_id"
            class="w-full rounded-xl px-4 py-3 text-white text-sm focus:outline-none"
            style="background: rgba(3,20,42,0.8); border: 1px solid rgba(255,255,255,0.1);">
            <option value="" disabled>Select program…</option>
            <option v-for="pg in programs" :key="pg.id" :value="pg.id">{{ pg.emoji }} {{ pg.title }}</option>
          </select>
          <textarea v-model="protocolForm.notes" rows="2" placeholder="Clinical notes (optional)"
            class="w-full rounded-xl px-4 py-3 text-white text-sm focus:outline-none resize-none"
            style="background: rgba(3,20,42,0.8); border: 1px solid rgba(255,255,255,0.1);"></textarea>
          <div class="flex gap-3 pt-2">
            <button type="button" @click="assignTarget = null"
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
import { Link, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

defineProps({ patients: Array, programs: Array, pro: Object })

const showAddPatient = ref(false)
const assignTarget   = ref(null)

const patientForm  = useForm({ name: '', email: '', phone: '', medical_history: '' })
const protocolForm = useForm({ patient_id: '', program_id: '', notes: '' })

const addPatient = () => {
  patientForm.post(route('pro.patients.store'), {
    onSuccess: () => { showAddPatient.value = false; patientForm.reset() }
  })
}

const openAssign = (patient) => {
  assignTarget.value = patient
  protocolForm.patient_id = patient.id
  protocolForm.program_id = ''
  protocolForm.notes = ''
}

const assignProtocol = () => {
  protocolForm.post(route('pro.protocols.assign'), {
    onSuccess: () => { assignTarget.value = null; protocolForm.reset() }
  })
}
</script>
