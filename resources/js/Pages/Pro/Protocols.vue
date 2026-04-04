<template>
  <ProLayout>

    <!-- Page header -->
    <div class="pr-head">
      <div>
        <h1 class="pr-title">Protocoles assignés</h1>
        <p class="pr-sub">{{ protocols.length }} protocole{{ protocols.length !== 1 ? 's' : '' }}</p>
      </div>
      <button @click="showAssign = true" class="pr-btn-gold">+ Assigner un protocole</button>
    </div>

    <!-- Flash -->
    <div v-if="$page.props.flash?.success" class="pr-flash">✓ {{ $page.props.flash.success }}</div>

    <!-- Filter bar -->
    <div class="pr-filters">
      <button v-for="f in filters" :key="f.value"
        @click="activeFilter = f.value"
        class="pr-filter-btn" :class="{ active: activeFilter === f.value }">
        {{ f.label }}
        <span class="pr-filter-count">{{ countByStatus(f.value) }}</span>
      </button>
    </div>

    <!-- List -->
    <div v-if="filteredProtocols.length" class="pr-list">
      <div v-for="p in filteredProtocols" :key="p.id" class="pr-row">

        <!-- Program icon + info -->
        <div class="pr-prog-info">
          <div class="pr-prog-emoji">{{ p.program?.emoji || '✨' }}</div>
          <div>
            <p class="pr-prog-name">{{ p.program?.title || 'Programme' }}</p>
            <p class="pr-prog-patient">Patient : <em>{{ p.patient?.name }}</em></p>
          </div>
        </div>

        <!-- Notes -->
        <p v-if="p.notes" class="pr-notes">"{{ p.notes }}"</p>
        <div v-else class="pr-notes-empty"></div>

        <!-- Progress bar (in_progress only) -->
        <div class="pr-progress-wrap">
          <div v-if="p.status === 'in_progress'" class="pr-progress">
            <div class="pr-progress-bar">
              <div class="pr-progress-fill" :style="`width:${p.progress_percent || 0}%`"></div>
            </div>
            <span class="pr-progress-pct">{{ p.progress_percent || 0 }}%</span>
          </div>
        </div>

        <!-- Status selector -->
        <select :value="p.status" @change="updateStatus(p, $event.target.value)"
          class="pr-status-sel" :class="p.status">
          <option value="assigned">Assigné</option>
          <option value="in_progress">En cours</option>
          <option value="completed">Terminé</option>
        </select>

        <!-- Date -->
        <span class="pr-date">{{ formatDate(p.created_at) }}</span>
      </div>
    </div>

    <!-- Empty -->
    <div v-else class="pr-empty">
      <span class="pr-empty-icon">🎯</span>
      <p class="pr-empty-title">Aucun protocole{{ activeFilter !== 'all' ? ' dans cette catégorie' : '' }}</p>
      <p class="pr-empty-sub">Assignez un protocole à l'un de vos patients pour commencer.</p>
      <button @click="showAssign = true" class="pr-btn-gold">+ Assigner un protocole</button>
    </div>

    <!-- Assign modal -->
    <div v-if="showAssign" class="pr-modal-bg">
      <div class="pr-modal">
        <div class="pr-modal-head">
          <h3>Assigner un protocole</h3>
          <button @click="showAssign = false" class="pr-modal-x">×</button>
        </div>
        <form @submit.prevent="assignProtocol" class="pr-modal-form">
          <div class="pr-field">
            <label>Patient *</label>
            <select v-model="protocolForm.patient_id">
              <option value="" disabled>Sélectionner un patient…</option>
              <option v-for="pt in patients" :key="pt.id" :value="pt.id">{{ pt.name }}</option>
            </select>
          </div>
          <div class="pr-field">
            <label>Programme *</label>
            <select v-model="protocolForm.program_id">
              <option value="" disabled>Sélectionner un programme…</option>
              <option v-for="pg in programs" :key="pg.id" :value="pg.id">{{ pg.emoji }} {{ pg.title }}</option>
            </select>
          </div>
          <div class="pr-field">
            <label>Notes cliniques</label>
            <textarea v-model="protocolForm.notes" rows="3" placeholder="Instructions, observations…"></textarea>
          </div>
          <div class="pr-modal-actions">
            <button type="button" @click="showAssign = false" class="pr-btn-ghost">Annuler</button>
            <button type="submit" :disabled="protocolForm.processing" class="pr-btn-teal">
              {{ protocolForm.processing ? 'Envoi…' : 'Assigner' }}
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
import { ref, computed } from 'vue'

const props = defineProps({
  patients:  { type: Array, default: () => [] },
  programs:  { type: Array, default: () => [] },
  protocols: { type: Array, default: () => [] },
  pro: Object,
})

const showAssign   = ref(false)
const activeFilter = ref('all')

const filters = [
  { label: 'Tous',      value: 'all'         },
  { label: 'Assignés',  value: 'assigned'    },
  { label: 'En cours',  value: 'in_progress' },
  { label: 'Terminés',  value: 'completed'   },
]

const filteredProtocols = computed(() =>
  activeFilter.value === 'all'
    ? props.protocols
    : props.protocols.filter(p => p.status === activeFilter.value)
)

const countByStatus = (status) =>
  status === 'all' ? props.protocols.length : props.protocols.filter(p => p.status === status).length

const protocolForm = useForm({ patient_id: '', program_id: '', notes: '' })

const assignProtocol = () => protocolForm.post(route('pro.protocols.assign'), {
  onSuccess: () => { showAssign.value = false; protocolForm.reset() }
})

const updateStatus = (protocol, status) =>
  router.put(route('pro.protocols.update', { protocol: protocol.id }), { status }, { preserveScroll: true })

const formatDate = (d) =>
  d ? new Date(d).toLocaleDateString('fr-FR', { day: '2-digit', month: 'short', year: 'numeric' }) : ''
</script>

<style scoped>
.pr-head { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:12px; }
.pr-title { font-family:'Cormorant Garamond',serif; font-size:1.8rem; font-weight:300; color:#fff; }
.pr-sub   { font-size:.8rem; color:rgba(200,220,255,.4); margin-top:3px; }
.pr-flash { background:rgba(13,115,119,.12); border:1px solid rgba(13,115,119,.3); color:#14a8a0; padding:12px 16px; border-radius:10px; font-size:.82rem; margin-bottom:18px; }

/* Filters */
.pr-filters { display:flex; gap:6px; margin-bottom:20px; flex-wrap:wrap; }
.pr-filter-btn { display:inline-flex; align-items:center; gap:7px; padding:6px 14px; border-radius:100px; font-size:.75rem; font-weight:500; background:rgba(255,255,255,.04); border:1px solid rgba(255,255,255,.07); color:rgba(200,220,255,.45); cursor:pointer; transition:all .18s; }
.pr-filter-btn:hover, .pr-filter-btn.active { background:rgba(200,169,110,.1); border-color:rgba(200,169,110,.25); color:#c8a96e; }
.pr-filter-count { font-size:.68rem; background:rgba(255,255,255,.08); padding:1px 7px; border-radius:100px; }

/* List */
.pr-list { display:flex; flex-direction:column; gap:8px; }
.pr-row { background:rgba(13,31,58,.7); border:1px solid rgba(255,255,255,.06); border-radius:14px; padding:16px 20px; display:grid; grid-template-columns:1fr auto auto auto auto; gap:16px; align-items:center; transition:border-color .2s; }
.pr-row:hover { border-color:rgba(200,169,110,.15); }

.pr-prog-info { display:flex; align-items:center; gap:12px; }
.pr-prog-emoji { width:38px; height:38px; border-radius:10px; background:rgba(13,115,119,.15); display:flex; align-items:center; justify-content:center; font-size:1.1rem; flex-shrink:0; }
.pr-prog-name    { font-size:.88rem; font-weight:600; color:#fff; }
.pr-prog-patient { font-size:.73rem; color:rgba(200,220,255,.38); margin-top:2px; }
.pr-prog-patient em { color:#c8a96e; font-style:normal; }

.pr-notes { font-size:.73rem; font-style:italic; color:rgba(200,220,255,.35); max-width:180px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
.pr-notes-empty { width:180px; }

.pr-progress-wrap { min-width:100px; }
.pr-progress { display:flex; align-items:center; gap:8px; }
.pr-progress-bar  { flex:1; height:4px; border-radius:2px; background:rgba(255,255,255,.08); overflow:hidden; }
.pr-progress-fill { height:100%; border-radius:2px; background:linear-gradient(90deg,#0d7377,#14a8a0); transition:width .4s; }
.pr-progress-pct  { font-size:.68rem; color:#14a8a0; flex-shrink:0; }

.pr-status-sel { background:rgba(255,255,255,.05); border-radius:100px; padding:5px 12px; font-size:.72rem; font-weight:600; outline:none; cursor:pointer; transition:all .2s; border:1px solid rgba(255,255,255,.1); color:rgba(200,220,255,.7); font-family:inherit; }
.pr-status-sel.assigned    { background:rgba(13,115,119,.12); border-color:rgba(13,115,119,.3); color:#14a8a0; }
.pr-status-sel.in_progress { background:rgba(200,169,110,.1); border-color:rgba(200,169,110,.3); color:#c8a96e; }
.pr-status-sel.completed   { background:rgba(22,163,74,.1); border-color:rgba(22,163,74,.3); color:#4ade80; }
.pr-status-sel option { background:#0d1f3a; }

.pr-date { font-size:.7rem; color:rgba(200,220,255,.25); flex-shrink:0; white-space:nowrap; }

/* Empty */
.pr-empty { text-align:center; padding:64px 20px; }
.pr-empty-icon  { font-size:3rem; display:block; margin-bottom:14px; }
.pr-empty-title { font-size:1rem; font-weight:600; color:#fff; margin-bottom:6px; }
.pr-empty-sub   { font-size:.82rem; color:rgba(200,220,255,.35); margin-bottom:20px; }

/* Buttons */
.pr-btn-gold  { background:linear-gradient(135deg,#c8a96e,#e8d5a3); color:#0a1628; border:none; padding:10px 20px; border-radius:10px; font-size:.8rem; font-weight:700; cursor:pointer; }
.pr-btn-teal  { background:linear-gradient(135deg,#0d7377,#14a8a0); color:#fff; border:none; padding:10px 20px; border-radius:10px; font-size:.8rem; font-weight:600; cursor:pointer; }
.pr-btn-ghost { background:rgba(255,255,255,.04); border:1px solid rgba(255,255,255,.08); color:rgba(200,220,255,.5); padding:10px 20px; border-radius:10px; font-size:.8rem; cursor:pointer; }

/* Modal */
.pr-modal-bg      { position:fixed; inset:0; z-index:200; display:flex; align-items:center; justify-content:center; background:rgba(0,0,0,.65); backdrop-filter:blur(6px); padding:20px; }
.pr-modal         { background:#0a1628; border:1px solid rgba(200,169,110,.2); border-radius:18px; width:100%; max-width:440px; overflow:hidden; }
.pr-modal-head    { display:flex; align-items:center; justify-content:space-between; padding:18px 22px 0; }
.pr-modal-head h3 { font-family:'Cormorant Garamond',serif; font-size:1.15rem; font-weight:600; color:#fff; }
.pr-modal-x       { background:none; border:none; color:rgba(200,220,255,.35); font-size:1.4rem; cursor:pointer; line-height:1; }
.pr-modal-form    { padding:16px 22px 22px; display:flex; flex-direction:column; gap:12px; }
.pr-field         { display:flex; flex-direction:column; gap:4px; }
.pr-field label   { font-size:.67rem; text-transform:uppercase; letter-spacing:.1em; color:rgba(200,220,255,.33); }
.pr-field input, .pr-field select, .pr-field textarea { background:rgba(255,255,255,.05); border:1px solid rgba(255,255,255,.08); border-radius:8px; padding:10px 12px; color:#fff; font-size:.83rem; outline:none; font-family:inherit; }
.pr-field input:focus, .pr-field select:focus, .pr-field textarea:focus { border-color:rgba(200,169,110,.4); }
.pr-field select option { background:#0d1f3a; }
.pr-field textarea { resize:none; }
.pr-modal-actions { display:flex; gap:10px; }
.pr-modal-actions > * { flex:1; }
</style>
