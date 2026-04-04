<template>
  <ProLayout>

    <!-- Page header -->
    <div class="p-page-head">
      <div>
        <h1 class="p-title">Mes patients</h1>
        <p class="p-sub">{{ patients.length }} patient{{ patients.length !== 1 ? 's' : '' }} enregistré{{ patients.length !== 1 ? 's' : '' }}</p>
      </div>
      <button @click="showAddPatient = true" class="p-btn-gold">+ Nouveau patient</button>
    </div>

    <!-- Flash -->
    <div v-if="$page.props.flash?.success" class="p-flash">✓ {{ $page.props.flash.success }}</div>

    <!-- Search -->
    <div class="p-search-wrap">
      <input v-model="search" type="text" placeholder="Rechercher un patient…" class="p-search" />
    </div>

    <!-- List -->
    <div v-if="filtered.length" class="p-list">
      <div v-for="patient in filtered" :key="patient.id" class="p-patient-row">

        <div class="p-patient-left">
          <div class="p-avatar-lg">{{ patient.name?.charAt(0).toUpperCase() }}</div>
          <div>
            <p class="p-patient-name">{{ patient.name }}</p>
            <p class="p-patient-meta">
              {{ patient.email || 'Pas d\'email' }}
              <span v-if="patient.phone"> · {{ patient.phone }}</span>
            </p>
          </div>
        </div>

        <div class="p-patient-protocols">
          <span v-for="pr in (patient.protocols || []).slice(0,3)" :key="pr.id"
            class="p-proto-emoji" :title="pr.program?.title">{{ pr.program?.emoji || '✨' }}</span>
          <span v-if="(patient.protocols||[]).length > 3" class="p-proto-more">
            +{{ patient.protocols.length - 3 }}
          </span>
          <span v-if="!(patient.protocols||[]).length" class="p-proto-none">Aucun protocole</span>
        </div>

        <span class="p-status-badge" :class="(patient.status || 'active') === 'active' ? 'teal' : 'muted'">
          {{ patient.status || 'actif' }}
        </span>

        <div class="p-patient-actions">
          <button @click="openAssign(patient)" class="p-btn-gold-sm">Assigner</button>
          <Link :href="route('pro.patients.destroy', patient.id)" method="delete" as="button"
            class="p-btn-del" @click.prevent="confirmDelete(patient)">✕</Link>
        </div>
      </div>
    </div>

    <!-- Empty -->
    <div v-else class="p-empty">
      <span class="p-empty-icon">👥</span>
      <p class="p-empty-title">Aucun patient{{ search ? ' trouvé' : ' pour l\'instant' }}</p>
      <p class="p-empty-sub">{{ search ? 'Modifiez votre recherche.' : 'Ajoutez votre premier patient pour commencer.' }}</p>
      <button v-if="!search" @click="showAddPatient = true" class="p-btn-gold">+ Ajouter un patient</button>
    </div>

    <!-- Add Patient Modal -->
    <div v-if="showAddPatient" class="p-modal-bg">
      <div class="p-modal">
        <div class="p-modal-head">
          <h3>Nouveau patient</h3>
          <button @click="showAddPatient = false" class="p-modal-x">×</button>
        </div>
        <form @submit.prevent="addPatient" class="p-modal-form">
          <div class="p-field"><label>Nom complet *</label><input v-model="patientForm.name" type="text" required placeholder="Jean Dupont" /></div>
          <div class="p-field"><label>Email</label><input v-model="patientForm.email" type="email" placeholder="jean@email.com" /></div>
          <div class="p-field"><label>Téléphone</label><input v-model="patientForm.phone" type="tel" placeholder="+33 6 …" /></div>
          <div class="p-field"><label>Notes médicales</label><textarea v-model="patientForm.medical_history" rows="2" placeholder="Antécédents…"></textarea></div>
          <div class="p-modal-actions">
            <button type="button" @click="showAddPatient = false" class="p-btn-ghost">Annuler</button>
            <button type="submit" :disabled="patientForm.processing" class="p-btn-gold">{{ patientForm.processing ? '…' : 'Créer' }}</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Assign Protocol Modal -->
    <div v-if="assignTarget" class="p-modal-bg">
      <div class="p-modal">
        <div class="p-modal-head">
          <h3>Assigner un protocole</h3>
          <button @click="assignTarget = null" class="p-modal-x">×</button>
        </div>
        <p class="p-modal-patient">Patient : <em>{{ assignTarget.name }}</em></p>
        <form @submit.prevent="assignProtocol" class="p-modal-form">
          <div class="p-field">
            <label>Programme *</label>
            <select v-model="protocolForm.program_id">
              <option value="" disabled>Sélectionner…</option>
              <option v-for="pg in programs" :key="pg.id" :value="pg.id">{{ pg.emoji }} {{ pg.title }}</option>
            </select>
          </div>
          <div class="p-field"><label>Notes cliniques</label><textarea v-model="protocolForm.notes" rows="2" placeholder="Instructions…"></textarea></div>
          <div class="p-modal-actions">
            <button type="button" @click="assignTarget = null" class="p-btn-ghost">Annuler</button>
            <button type="submit" :disabled="protocolForm.processing" class="p-btn-teal">{{ protocolForm.processing ? '…' : 'Assigner' }}</button>
          </div>
        </form>
      </div>
    </div>

  </ProLayout>
</template>

<script setup>
import ProLayout from '@/Layouts/ProLayout.vue'
import { Link, useForm, router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'

const props = defineProps({ patients: { type: Array, default: () => [] }, programs: { type: Array, default: () => [] }, pro: Object })

const showAddPatient = ref(false)
const assignTarget   = ref(null)
const search         = ref('')

const filtered = computed(() => {
  if (!search.value) return props.patients
  const q = search.value.toLowerCase()
  return props.patients.filter(p => p.name?.toLowerCase().includes(q) || p.email?.toLowerCase().includes(q))
})

const patientForm  = useForm({ name: '', email: '', phone: '', medical_history: '' })
const protocolForm = useForm({ patient_id: '', program_id: '', notes: '' })

const addPatient = () => patientForm.post(route('pro.patients.store'), {
  onSuccess: () => { showAddPatient.value = false; patientForm.reset() }
})

const openAssign = (patient) => {
  assignTarget.value = patient
  protocolForm.patient_id = patient.id
  protocolForm.program_id = ''
  protocolForm.notes = ''
}

const assignProtocol = () => protocolForm.post(route('pro.protocols.assign'), {
  onSuccess: () => { assignTarget.value = null; protocolForm.reset() }
})

const confirmDelete = (patient) => {
  if (confirm(`Supprimer ${patient.name} ?`)) router.delete(route('pro.patients.destroy', patient.id))
}
</script>

<style scoped>
.p-page-head { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:12px; }
.p-title { font-family:'Cormorant Garamond',serif; font-size:1.8rem; font-weight:300; color:#fff; }
.p-sub   { font-size:.8rem; color:rgba(200,220,255,.4); margin-top:3px; }
.p-flash { background:rgba(13,115,119,.12); border:1px solid rgba(13,115,119,.3); color:#14a8a0; padding:12px 16px; border-radius:10px; font-size:.82rem; margin-bottom:18px; }

.p-search-wrap { margin-bottom:20px; }
.p-search { width:100%; max-width:380px; background:rgba(255,255,255,.05); border:1px solid rgba(255,255,255,.08); border-radius:10px; padding:10px 14px; color:#fff; font-size:.83rem; outline:none; font-family:inherit; transition:border-color .2s; }
.p-search:focus { border-color:rgba(200,169,110,.35); }

.p-list { display:flex; flex-direction:column; gap:8px; }
.p-patient-row { background:rgba(13,31,58,.7); border:1px solid rgba(255,255,255,.06); border-radius:14px; padding:16px 20px; display:flex; align-items:center; gap:16px; flex-wrap:wrap; transition:border-color .2s; }
.p-patient-row:hover { border-color:rgba(200,169,110,.18); }

.p-patient-left { display:flex; align-items:center; gap:12px; flex:1; min-width:200px; }
.p-avatar-lg { width:38px; height:38px; border-radius:10px; background:linear-gradient(135deg,#0d7377,#14a8a0); display:flex; align-items:center; justify-content:center; font-size:.88rem; font-weight:700; color:#fff; flex-shrink:0; }
.p-patient-name { font-size:.9rem; font-weight:600; color:#fff; }
.p-patient-meta { font-size:.74rem; color:rgba(200,220,255,.38); margin-top:2px; }

.p-patient-protocols { display:flex; align-items:center; gap:4px; flex-shrink:0; }
.p-proto-emoji { font-size:1.1rem; }
.p-proto-more  { font-size:.68rem; color:rgba(200,220,255,.35); margin-left:2px; }
.p-proto-none  { font-size:.72rem; color:rgba(200,220,255,.22); }

.p-status-badge { font-size:.66rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; padding:3px 10px; border-radius:100px; flex-shrink:0; }
.p-status-badge.teal  { background:rgba(13,115,119,.15); border:1px solid rgba(13,115,119,.3); color:#14a8a0; }
.p-status-badge.muted { background:rgba(255,255,255,.05); border:1px solid rgba(255,255,255,.1); color:rgba(200,220,255,.4); }

.p-patient-actions { display:flex; align-items:center; gap:8px; flex-shrink:0; margin-left:auto; }

.p-empty { text-align:center; padding:64px 20px; }
.p-empty-icon  { font-size:3rem; display:block; margin-bottom:14px; }
.p-empty-title { font-size:1rem; font-weight:600; color:#fff; margin-bottom:6px; }
.p-empty-sub   { font-size:.82rem; color:rgba(200,220,255,.35); margin-bottom:20px; }

/* Buttons */
.p-btn-gold    { background:linear-gradient(135deg,#c8a96e,#e8d5a3); color:#0a1628; border:none; padding:10px 20px; border-radius:10px; font-size:.8rem; font-weight:700; cursor:pointer; }
.p-btn-gold-sm { background:rgba(200,169,110,.12); border:1px solid rgba(200,169,110,.3); color:#c8a96e; padding:5px 12px; border-radius:7px; font-size:.72rem; font-weight:600; cursor:pointer; transition:all .2s; }
.p-btn-gold-sm:hover { background:rgba(200,169,110,.22); }
.p-btn-teal    { background:linear-gradient(135deg,#0d7377,#14a8a0); color:#fff; border:none; padding:10px 20px; border-radius:10px; font-size:.8rem; font-weight:600; cursor:pointer; }
.p-btn-ghost   { background:rgba(255,255,255,.04); border:1px solid rgba(255,255,255,.08); color:rgba(200,220,255,.5); padding:10px 20px; border-radius:10px; font-size:.8rem; cursor:pointer; }
.p-btn-del     { background:none; border:none; color:rgba(200,220,255,.25); font-size:1.2rem; cursor:pointer; padding:4px 6px; transition:color .2s; line-height:1; }
.p-btn-del:hover { color:#ef4444; }

/* Modal */
.p-modal-bg      { position:fixed; inset:0; z-index:200; display:flex; align-items:center; justify-content:center; background:rgba(0,0,0,.65); backdrop-filter:blur(6px); padding:20px; }
.p-modal         { background:#0a1628; border:1px solid rgba(200,169,110,.2); border-radius:18px; width:100%; max-width:440px; overflow:hidden; }
.p-modal-head    { display:flex; align-items:center; justify-content:space-between; padding:18px 22px 0; }
.p-modal-head h3 { font-family:'Cormorant Garamond',serif; font-size:1.15rem; font-weight:600; color:#fff; }
.p-modal-x       { background:none; border:none; color:rgba(200,220,255,.35); font-size:1.4rem; cursor:pointer; line-height:1; }
.p-modal-patient { padding:4px 22px 0; font-size:.78rem; color:rgba(200,220,255,.45); }
.p-modal-patient em { color:#c8a96e; font-style:normal; }
.p-modal-form    { padding:16px 22px 22px; display:flex; flex-direction:column; gap:12px; }
.p-field         { display:flex; flex-direction:column; gap:4px; }
.p-field label   { font-size:.67rem; text-transform:uppercase; letter-spacing:.1em; color:rgba(200,220,255,.33); }
.p-field input, .p-field select, .p-field textarea { background:rgba(255,255,255,.05); border:1px solid rgba(255,255,255,.08); border-radius:8px; padding:10px 12px; color:#fff; font-size:.83rem; outline:none; font-family:inherit; }
.p-field input:focus, .p-field select:focus, .p-field textarea:focus { border-color:rgba(200,169,110,.4); }
.p-field select option { background:#0d1f3a; }
.p-field textarea { resize:none; }
.p-modal-actions { display:flex; gap:10px; }
.p-modal-actions > * { flex:1; }
</style>
