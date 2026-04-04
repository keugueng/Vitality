<template>
  <div class="notif-wrap" data-notif>
    <button @click.stop="toggle" class="notif-btn" :class="{ active: open }" data-notif>
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
        <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
        <path d="M13.73 21a2 2 0 01-3.46 0"/>
      </svg>
      <span v-if="unread > 0" class="notif-badge">{{ unread > 9 ? '9+' : unread }}</span>
    </button>

    <transition name="notif-drop">
      <div v-if="open" class="notif-panel" data-notif>
        <div class="notif-head">
          <span class="notif-head-title">Notifications</span>
          <button v-if="unread > 0" @click="markAll" class="notif-mark-all">Tout lire</button>
        </div>

        <div v-if="loading" class="notif-empty">
          <div class="notif-spin"></div>
        </div>

        <div v-else-if="!items.length" class="notif-empty">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" style="opacity:.3; margin-bottom:8px;">
            <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/>
          </svg>
          <p>Aucune notification</p>
        </div>

        <div v-else class="notif-list">
          <div v-for="n in items" :key="n.id"
            class="notif-item" :class="{ unread: !n.read, [n.type]: true }"
            @click="handleClick(n)">
            <div class="notif-icon">
              <span>{{ typeIcon(n.type) }}</span>
            </div>
            <div class="notif-body">
              <p class="notif-title">{{ n.title }}</p>
              <p class="notif-text">{{ n.body }}</p>
              <span class="notif-time">{{ n.created_at }}</span>
            </div>
            <div v-if="!n.read" class="notif-dot"></div>
          </div>
        </div>

        <div v-if="items.length" class="notif-footer">
          <a href="/notifications" class="notif-view-all">Voir tout →</a>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { usePage } from '@inertiajs/vue3'
import axios from 'axios'

const page   = usePage()
const open   = ref(false)
const items  = ref([])
const loading = ref(false)

const unread = computed(() => page.props.notif_count || 0)

const typeIcon = (type) => {
  const map = { info: '💬', success: '✅', warning: '⚠️', promo: '🎁' }
  return map[type] || '🔔'
}

const fetchNotifications = async () => {
  if (!page.props.auth?.user) return
  loading.value = true
  try {
    const { data } = await axios.get('/notifications')
    items.value = data
  } finally {
    loading.value = false
  }
}

const toggle = () => {
  open.value = !open.value
  if (open.value && !items.value.length) fetchNotifications()
}

const handleClick = async (n) => {
  if (!n.read) {
    await axios.post(`/notifications/${n.id}/read`)
    n.read = true
  }
  if (n.action_url) window.location.href = n.action_url
}

const markAll = async () => {
  await axios.post('/notifications/read-all')
  items.value.forEach(n => { n.read = true })
}

const onClickOut = (e) => {
  if (open.value && !e.target.closest('[data-notif]')) open.value = false
}

onMounted(() => document.addEventListener('click', onClickOut))
onUnmounted(() => document.removeEventListener('click', onClickOut))
</script>

<style scoped>
.notif-wrap { position: relative; display: inline-flex; align-items: center; }

.notif-btn {
  width: 36px; height: 36px;
  background: rgba(255,255,255,.07);
  border: 1px solid rgba(255,255,255,.12);
  border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  color: rgba(255,255,255,.6);
  cursor: pointer;
  transition: all .2s;
  position: relative;
}
.notif-btn:hover, .notif-btn.active {
  background: rgba(13,115,119,.2);
  border-color: rgba(13,115,119,.4);
  color: #14a8a0;
}
.notif-badge {
  position: absolute;
  top: -5px; right: -5px;
  min-width: 16px; height: 16px;
  background: #e53e3e;
  color: #fff;
  font-size: 9px;
  font-weight: 700;
  border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  padding: 0 3px;
  line-height: 1;
}

.notif-panel {
  position: absolute;
  top: calc(100% + 10px);
  right: 0;
  width: 340px;
  background: rgba(10,22,40,.98);
  border: 1px solid rgba(200,169,110,.2);
  border-radius: 14px;
  z-index: 9999;
  overflow: hidden;
  box-shadow: 0 20px 60px rgba(0,0,0,.6);
  backdrop-filter: blur(20px);
}

.notif-head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 14px 18px;
  border-bottom: 1px solid rgba(255,255,255,.06);
}
.notif-head-title {
  font-size: .78rem;
  font-weight: 700;
  letter-spacing: .1em;
  text-transform: uppercase;
  color: rgba(200,220,255,.7);
}
.notif-mark-all {
  font-size: .72rem;
  color: #14a8a0;
  background: none;
  border: none;
  cursor: pointer;
  transition: color .2s;
}
.notif-mark-all:hover { color: #c8a96e; }

.notif-list { max-height: 360px; overflow-y: auto; }
.notif-list::-webkit-scrollbar { width: 4px; }
.notif-list::-webkit-scrollbar-track { background: transparent; }
.notif-list::-webkit-scrollbar-thumb { background: rgba(255,255,255,.1); border-radius: 2px; }

.notif-item {
  display: flex;
  gap: 12px;
  padding: 14px 18px;
  border-bottom: 1px solid rgba(255,255,255,.04);
  cursor: pointer;
  transition: background .15s;
  position: relative;
}
.notif-item:hover { background: rgba(255,255,255,.03); }
.notif-item.unread { background: rgba(13,115,119,.06); }
.notif-item:last-child { border-bottom: none; }

.notif-icon {
  width: 34px; height: 34px;
  border-radius: 8px;
  background: rgba(13,115,119,.15);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
  font-size: 15px;
}
.notif-item.promo .notif-icon { background: rgba(200,169,110,.12); }
.notif-item.warning .notif-icon { background: rgba(234,179,8,.12); }
.notif-item.success .notif-icon { background: rgba(22,163,74,.12); }

.notif-body { flex: 1; min-width: 0; }
.notif-title { font-size: .82rem; font-weight: 600; color: #fff; margin-bottom: 3px; line-height: 1.3; }
.notif-text  { font-size: .76rem; color: rgba(200,220,255,.5); line-height: 1.4; }
.notif-time  { font-size: .69rem; color: rgba(200,220,255,.3); margin-top: 4px; display: block; }

.notif-dot {
  width: 7px; height: 7px;
  border-radius: 50%;
  background: #14a8a0;
  flex-shrink: 0;
  align-self: flex-start;
  margin-top: 5px;
}

.notif-empty {
  padding: 32px;
  text-align: center;
  color: rgba(200,220,255,.3);
  font-size: .8rem;
  display: flex; flex-direction: column; align-items: center;
}
.notif-spin {
  width: 20px; height: 20px;
  border: 2px solid rgba(13,115,119,.3);
  border-top-color: #14a8a0;
  border-radius: 50%;
  animation: spin .7s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

.notif-footer {
  padding: 10px 18px;
  border-top: 1px solid rgba(255,255,255,.06);
  text-align: center;
}
.notif-view-all {
  font-size: .75rem;
  color: #14a8a0;
  text-decoration: none;
  transition: color .2s;
}
.notif-view-all:hover { color: #c8a96e; }

.notif-drop-enter-active, .notif-drop-leave-active { transition: all .2s ease; }
.notif-drop-enter-from, .notif-drop-leave-to { opacity: 0; transform: translateY(-6px) scale(.97); }
</style>
