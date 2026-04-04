<template>
  <ProLayout>

    <!-- Welcome banner -->
    <div class="pro-welcome">
      <div>
        <h1 class="pro-welcome-title">Bonjour, <em>{{ pro?.name ?? 'Praticien' }}</em> 👋</h1>
        <p class="pro-welcome-sub">Voici un aperçu de votre activité.</p>
      </div>
      <button @click="showAddPatient = true" class="pro-btn-gold">+ Nouveau patient</button>
    </div>

    <!-- Stats row -->
    <div class="pro-stats-grid">
      <div v-for="s in statCards" :key="s.label" class="pro-stat-card">
        <p class="pro-stat-value" :style="`color:${s.color}`">{{ s.value }}</p>
        <p class="pro-stat-label">{{ s.label }}</p>
        <div class="pro-stat-bar" :style="`background:${s.color}22`">
          <div class="pro-stat-fill" :style="`width:${s.pct}%; background:${s.color}`"></div>
        </div>
      </div>
    </div>

    <!-- Grid: patients + assign -->
    <div class="pro-grid">

      <!-- Patients table -->
      <div class="pro-card lg-col-2">
        <div class="pro-card-head">
          <h3 class="pro-card-title">Mes patients</h3>
          <span class="pro-card-count">{{ patients.length }}</span>
        </div>

        <div v-if="!patients.length" class="pro-empty">Aucun patient pour l'instant.</div>

        <table v-else class="pro-table">
          <thead>
            <tr>
              <th>Patient</th><th>Email</th><th>Programme actif</th><th>Séances</th><th></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="p in patients" :key="p.id">
              <td>
                <div class="pro-patient-row">
                  <div class="pro-avatar">{{ p.name?.charAt(0) }}</div>
                  <span>{{ p.name }}</span>
                </div>
              </td>
              <td class="muted">{{ p.email }}</td>
              <td class="muted">{{ p.current_protocol ?? '—' }}</td>
              <td class="muted">{{ p.sessions_count ?? 0 }}</td>
              <td>
                <button @click="selectPatient(p)" class="pro-btn-teal-sm">Assigner</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Quick assign form -->
      <div class="pro-card">
        <div class="pro-card-head">
          <h3 class="pro-card-title">Assigner un protocole</h3>
        </div>
        <form @submit.prevent="assign" class="pro-form">
          <div class="pro-field">
            <label>Patient</label>
            <select v-model="assignForm.patient_id">
              <option value="">Sélectionner…</option>
              <option v-for="p in patients" :key="p.id" :value="p.id">{{ p.name }}</option>
            </select>
          </div>
          <div class="pro-field">
            <label>Programme</label>
            <select v-model="assignForm.program_id">
              <option value="">Sélectionner…</option>
              <option v-for="prog in programs" :key="prog.id" :value="prog.id">
                {{ prog.emoji }} {{ prog.title }}
              </option>
            </select>
          </div>
          <div class="pro-field">
            <label>Note (optionnel)</label>
            <textarea v-model="assignForm.note" rows="2" placeholder="Instructions…"></textarea>
          </div>
          <button type="submit" :disabled="assignForm.processing" class="pro-btn-teal">
            {{ assignForm.processing ? 'Envoi…' : 'Assigner le protocole' }}
          </button>
        </form>
      </div>
    </div>

    <!-- Add patient modal -->
    <div v-if="showAddPatient" class="pro-modal-overlay">
      <div class="pro-modal">
        <div class="pro-modal-head">
          <h3>Nouveau patient</h3>
          <button @click="showAddPatient = false" class="pro-modal-close">×</button>
        </div>
        <form @submit.prevent="addPatient" class="pro-form">
          <div class="pro-field">
            <label>Nom complet *</label>
            <input v-model="patientForm.name" type="text" required placeholder="Jean Dupont" />
          </div>
          <div class="pro-field">
            <label>Email *</label>
            <input v-model="patientForm.email" type="email" required placeholder="jean@email.com" />
          </div>
          <div class="pro-field">
            <label>Téléphone</label>
            <input v-model="patientForm.phone" type="tel" placeholder="+33 6 …" />
          </div>
          <div class="pro-modal-actions">
            <button type="button" @click="showAddPatient = false" class="pro-btn-ghost">Annuler</button>
            <button type="submit" :disabled="patientForm.processing" class="pro-btn-gold">
              {{ patientForm.processing ? '…' : 'Créer' }}
            </button>
          </div>
        </form>
      </div>
    </div>

  </ProLayout>
</template>

<script setup>
import ProLayout from '@/Layouts/ProLayout.vue'
import { useForm } from '@inertiajs/vue3'
import { ref, computed } from 'vue'

const props = defineProps({
  patients: { type: Array, default: () => [] },
  programs: { type: Array, default: () => [] },
  stats:    { type: Object, default: () => ({}) },
  pro:      { type: Object, default: () => ({}) },
})

const showAddPatient = ref(false)

const statCards = computed(() => [
  { label: 'Patients actifs',   value: props.stats.patients_count ?? 0,  color: '#14a8a0', pct: Math.min((props.stats.patients_count ?? 0) * 5, 100) },
  { label: 'Protocoles actifs', value: props.stats.protocols_active ?? 0, color: '#c8a96e', pct: Math.min((props.stats.protocols_active ?? 0) * 8, 100) },
  { label: 'Commission',        value: (props.stats.commission_rate ?? 20) + '%', color: '#7dd3fc', pct: props.stats.commission_rate ?? 20 },
  { label: 'Total commissions', value: '€' + (props.stats.commission_total ?? 0), color: '#86efac', pct: 60 },
])

const assignForm = useForm({ patient_id: '', program_id: '', note: '' })
const patientForm = useForm({ name: '', email: '', phone: '' })

const selectPatient = (p) => { assignForm.patient_id = p.id }
const assign = () => assignForm.post(route('pro.assign-protocol'), { onSuccess: () => assignForm.reset() })
const addPatient = () => patientForm.post(route('pro.add-patient'), {
  onSuccess: () => { showAddPatient.value = false; patientForm.reset() },
})
</script>

<style scoped>
/* Welcome */
.pro-welcome { display:flex; align-items:center; justify-content:space-between; margin-bottom:28px; flex-wrap:wrap; gap:12px; }
.pro-welcome-title { font-family:'Cormorant Garamond',serif; font-size:1.7rem; font-weight:300; color:#fff; }
.pro-welcome-title em { color:#c8a96e; font-style:italic; }
.pro-welcome-sub { font-size:.82rem; color:rgba(200,220,255,.4); margin-top:4px; }

/* Stats */
.pro-stats-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:28px; }
@media (max-width:900px) { .pro-stats-grid { grid-template-columns:repeat(2,1fr); } }
.pro-stat-card { background:rgba(13,31,58,.7); border:1px solid rgba(255,255,255,.06); border-radius:14px; padding:20px; }
.pro-stat-value { font-size:1.7rem; font-weight:700; line-height:1; margin-bottom:6px; }
.pro-stat-label { font-size:.72rem; letter-spacing:.1em; text-transform:uppercase; color:rgba(200,220,255,.35); margin-bottom:12px; }
.pro-stat-bar { height:3px; border-radius:2px; overflow:hidden; }
.pro-stat-fill { height:100%; border-radius:2px; transition:width .5s ease; }

/* Grid */
.pro-grid { display:grid; grid-template-columns:1fr 340px; gap:20px; align-items:start; }
@media (max-width:900px) { .pro-grid { grid-template-columns:1fr; } }

/* Cards */
.pro-card { background:rgba(13,31,58,.7); border:1px solid rgba(255,255,255,.06); border-radius:16px; overflow:hidden; }
.pro-card-head { display:flex; align-items:center; justify-content:space-between; padding:16px 20px; border-bottom:1px solid rgba(255,255,255,.05); }
.pro-card-title { font-family:'Cormorant Garamond',serif; font-size:1.05rem; font-weight:600; color:#fff; }
.pro-card-count { font-size:.75rem; padding:3px 10px; border-radius:100px; background:rgba(13,115,119,.15); color:#14a8a0; border:1px solid rgba(13,115,119,.25); }

/* Table */
.pro-table { width:100%; border-collapse:collapse; }
.pro-table thead tr th { padding:10px 20px; font-size:.68rem; font-weight:700; text-transform:uppercase; letter-spacing:.1em; color:rgba(200,220,255,.3); text-align:left; border-bottom:1px solid rgba(255,255,255,.04); }
.pro-table tbody tr { border-bottom:1px solid rgba(255,255,255,.03); transition:background .15s; }
.pro-table tbody tr:hover { background:rgba(255,255,255,.02); }
.pro-table tbody tr td { padding:12px 20px; font-size:.82rem; color:rgba(200,220,255,.8); }
.pro-table tbody tr td.muted { color:rgba(200,220,255,.35); }

.pro-patient-row { display:flex; align-items:center; gap:10px; }
.pro-avatar { width:28px; height:28px; border-radius:6px; background:linear-gradient(135deg,#0d7377,#14a8a0); display:flex; align-items:center; justify-content:center; font-size:.75rem; font-weight:700; color:#fff; flex-shrink:0; }
.pro-empty { padding:48px 20px; text-align:center; font-size:.83rem; color:rgba(200,220,255,.25); }

/* Form */
.pro-form { padding:20px; display:flex; flex-direction:column; gap:14px; }
.pro-field { display:flex; flex-direction:column; gap:5px; }
.pro-field label { font-size:.68rem; text-transform:uppercase; letter-spacing:.1em; color:rgba(200,220,255,.35); }
.pro-field input, .pro-field select, .pro-field textarea { background:rgba(255,255,255,.05); border:1px solid rgba(255,255,255,.08); border-radius:8px; padding:10px 12px; color:#fff; font-size:.83rem; outline:none; font-family:inherit; transition:border-color .2s; }
.pro-field input:focus, .pro-field select:focus, .pro-field textarea:focus { border-color:rgba(200,169,110,.4); }
.pro-field select option { background:#0d1f3a; }
.pro-field textarea { resize:none; }

/* Buttons */
.pro-btn-gold { background:linear-gradient(135deg,#c8a96e,#e8d5a3); color:#0a1628; border:none; padding:10px 20px; border-radius:10px; font-size:.8rem; font-weight:700; cursor:pointer; transition:opacity .2s; }
.pro-btn-gold:hover { opacity:.88; }
.pro-btn-teal { background:linear-gradient(135deg,#0d7377,#14a8a0); color:#fff; border:none; padding:11px; border-radius:10px; font-size:.82rem; font-weight:600; cursor:pointer; transition:opacity .2s; width:100%; }
.pro-btn-teal:hover { opacity:.88; }
.pro-btn-teal:disabled { opacity:.5; cursor:not-allowed; }
.pro-btn-teal-sm { background:rgba(13,115,119,.15); border:1px solid rgba(13,115,119,.3); color:#14a8a0; padding:5px 12px; border-radius:7px; font-size:.72rem; font-weight:600; cursor:pointer; transition:all .2s; white-space:nowrap; }
.pro-btn-teal-sm:hover { background:rgba(13,115,119,.3); }
.pro-btn-ghost { background:rgba(255,255,255,.04); border:1px solid rgba(255,255,255,.08); color:rgba(200,220,255,.5); padding:10px 20px; border-radius:10px; font-size:.8rem; cursor:pointer; }

/* Modal */
.pro-modal-overlay { position:fixed; inset:0; z-index:200; display:flex; align-items:center; justify-content:center; background:rgba(0,0,0,.65); backdrop-filter:blur(6px); padding:20px; }
.pro-modal { background:#0a1628; border:1px solid rgba(200,169,110,.2); border-radius:18px; width:100%; max-width:420px; overflow:hidden; }
.pro-modal-head { display:flex; align-items:center; justify-content:space-between; padding:18px 22px 16px; border-bottom:1px solid rgba(255,255,255,.06); }
.pro-modal-head h3 { font-family:'Cormorant Garamond',serif; font-size:1.15rem; font-weight:600; color:#fff; }
.pro-modal-close { background:none; border:none; color:rgba(200,220,255,.4); font-size:1.4rem; cursor:pointer; line-height:1; }
.pro-modal-close:hover { color:#fff; }
.pro-modal-actions { display:flex; gap:10px; }
.pro-modal-actions > * { flex:1; }
</style>
