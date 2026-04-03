<template>
  <ProLayout>
    <div class="max-w-5xl">
      <h1 class="font-serif text-3xl font-light text-white mb-2">PRO Dashboard</h1>
      <p class="text-vitality-text mb-8">Dr. Rosati Vitality Inside · Professional Space</p>

      <!-- Stats -->
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-10">
        <div class="glass-card rounded-2xl p-5">
          <p class="text-vitality-text text-xs mb-1">Patients</p>
          <p class="text-vitality-gold font-bold text-3xl">{{ stats.patients_count }}</p>
        </div>
        <div class="glass-card rounded-2xl p-5">
          <p class="text-vitality-text text-xs mb-1">Active Protocols</p>
          <p class="text-vitality-cyan font-bold text-3xl">{{ stats.protocols_active }}</p>
        </div>
        <div class="glass-card rounded-2xl p-5">
          <p class="text-vitality-text text-xs mb-1">Commission Rate</p>
          <p class="text-vitality-gold font-bold text-3xl">{{ stats.commission_rate }}%</p>
        </div>
        <div class="glass-card rounded-2xl p-5">
          <p class="text-vitality-text text-xs mb-1">Total Commissions</p>
          <p class="text-vitality-gold font-bold text-2xl">€{{ stats.commission_total }}</p>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Patients list -->
        <div class="lg:col-span-2">
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-white font-semibold text-lg">My Patients</h2>
            <button @click="showAddPatient = true" class="btn-cyan text-xs py-2 px-4">+ Add Patient</button>
          </div>
          <div class="space-y-3">
            <div v-for="patient in patients" :key="patient.id"
              class="glass-card rounded-xl p-4 cursor-pointer hover:border-vitality-cyan/20 transition-all border border-transparent"
              @click="selectedPatient = patient">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-white font-medium text-sm">{{ patient.name }}</p>
                  <p class="text-vitality-text text-xs mt-0.5">{{ patient.protocols?.length || 0 }} protocol(s) · {{ patient.status }}</p>
                </div>
                <div class="flex items-center gap-2">
                  <span v-for="p in patient.protocols?.slice(0,2)" :key="p.id" class="text-lg" :title="p.program?.title">{{ p.program?.emoji || '✨' }}</span>
                </div>
              </div>
            </div>
            <div v-if="!patients.length" class="glass-card rounded-xl p-6 text-center text-vitality-text text-sm">
              No patients yet. Add your first patient above.
            </div>
          </div>
        </div>

        <!-- Assign protocol / patient detail -->
        <div>
          <h2 class="text-white font-semibold text-lg mb-4">Quick Assign Protocol</h2>
          <div class="glass-card rounded-2xl p-5 border-glow">
            <form @submit.prevent="assignProtocol" class="space-y-4">
              <div>
                <label class="text-vitality-text text-xs mb-1.5 block">Patient</label>
                <select v-model="protocolForm.patient_id"
                  class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-3 py-2.5 text-white text-sm focus:outline-none focus:border-vitality-cyan/50">
                  <option value="" disabled>Select patient…</option>
                  <option v-for="p in patients" :key="p.id" :value="p.id">{{ p.name }}</option>
                </select>
              </div>
              <div>
                <label class="text-vitality-text text-xs mb-1.5 block">Program</label>
                <select v-model="protocolForm.program_id"
                  class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-3 py-2.5 text-white text-sm focus:outline-none focus:border-vitality-cyan/50">
                  <option value="" disabled>Select program…</option>
                  <option v-for="pg in programs" :key="pg.id" :value="pg.id">{{ pg.emoji }} {{ pg.title }}</option>
                </select>
              </div>
              <div>
                <label class="text-vitality-text text-xs mb-1.5 block">Notes</label>
                <textarea v-model="protocolForm.notes" rows="2"
                  class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-3 py-2 text-white text-sm focus:outline-none focus:border-vitality-cyan/50 resize-none"
                  placeholder="Clinical notes…"></textarea>
              </div>
              <button type="submit" :disabled="protocolForm.processing" class="btn-cyan w-full text-xs py-2.5 disabled:opacity-50">
                Assign Protocol
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Add Patient Modal -->
    <div v-if="showAddPatient" class="fixed inset-0 z-50 flex items-center justify-center px-4 bg-black/60 backdrop-blur-sm">
      <div class="glass-card rounded-3xl p-8 w-full max-w-md border-glow">
        <h3 class="text-white font-semibold text-lg mb-5">Add Patient</h3>
        <form @submit.prevent="addPatient" class="space-y-4">
          <input v-model="patientForm.name" type="text" required placeholder="Full name"
            class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-vitality-cyan/50"/>
          <input v-model="patientForm.email" type="email" placeholder="Email (optional)"
            class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-vitality-cyan/50"/>
          <input v-model="patientForm.phone" type="tel" placeholder="Phone (optional)"
            class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-vitality-cyan/50"/>
          <div class="flex gap-3">
            <button type="button" @click="showAddPatient = false" class="btn-outline flex-1 text-sm py-2.5">Cancel</button>
            <button type="submit" :disabled="patientForm.processing" class="btn-cyan flex-1 text-sm py-2.5 disabled:opacity-50">Add Patient</button>
          </div>
        </form>
      </div>
    </div>
  </ProLayout>
</template>

<script setup>
import ProLayout from '@/Layouts/ProLayout.vue'
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

defineProps({ patients: Array, programs: Array, stats: Object, pro: Object })

const showAddPatient = ref(false)
const selectedPatient = ref(null)

const patientForm = useForm({ name: '', email: '', phone: '' })
const protocolForm = useForm({ patient_id: '', program_id: '', notes: '' })

const addPatient = () => {
  patientForm.post(route('pro.patients.store'), { onSuccess: () => { showAddPatient.value = false; patientForm.reset() } })
}
const assignProtocol = () => {
  protocolForm.post(route('pro.protocols.assign'), { onSuccess: () => protocolForm.reset() })
}
</script>
