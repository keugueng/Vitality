<template>
  <div class="pro-shell">

    <!-- ═══ SIDEBAR ═══ -->
    <aside class="pro-sidebar">
      <!-- Logo -->
      <Link :href="route('home')" class="pro-logo">
        <span class="pro-logo-icon">V</span>
        <span class="pro-logo-text">Vitality<em>PRO</em></span>
      </Link>

      <!-- Nav -->
      <nav class="pro-nav">
        <Link v-for="item in proNav" :key="item.route"
          :href="route(item.route)"
          class="pro-nav-item"
          :class="{ active: isProActive(item.route) }">
          <span class="pro-nav-icon">{{ item.icon }}</span>
          <span class="pro-nav-label">{{ item.label }}</span>
          <span v-if="isProActive(item.route)" class="pro-nav-pip"></span>
        </Link>
      </nav>

      <!-- Spacer -->
      <div class="pro-sidebar-spacer"></div>

      <!-- User info -->
      <div class="pro-user">
        <div class="pro-user-avatar">{{ userInitial }}</div>
        <div class="pro-user-info">
          <p class="pro-user-name">{{ userName }}</p>
          <p class="pro-user-role">Praticien PRO</p>
        </div>
      </div>

      <!-- Sign out -->
      <Link :href="route('logout')" method="post" as="button" class="pro-signout">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/>
        </svg>
        Déconnexion
      </Link>
    </aside>

    <!-- ═══ MAIN ═══ -->
    <div class="pro-main">
      <!-- Top bar -->
      <header class="pro-topbar">
        <div class="pro-topbar-left">
          <span class="pro-topbar-badge">PRO Space</span>
          <span class="pro-topbar-page">{{ currentPageTitle }}</span>
        </div>
        <div class="pro-topbar-right">
          <Link :href="route('shop')" class="pro-topbar-btn">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
              <path d="M1 1h4l2.68 13.39a2 2 0 001.97 1.61h9.72a2 2 0 001.97-1.61L23 6H6"/>
            </svg>
            Boutique
          </Link>
          <Link :href="route('home')" class="pro-topbar-btn pro-topbar-btn--outline">
            ← Site public
          </Link>
        </div>
      </header>

      <!-- Page content -->
      <main class="pro-content">
        <slot />
      </main>
    </div>

  </div>
</template>

<script setup>
import { computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'

const page = usePage()
const auth = computed(() => page.props.auth?.user)
const userName    = computed(() => auth.value?.name || 'Praticien')
const userInitial = computed(() => userName.value.charAt(0).toUpperCase())

const proNav = [
  { icon: '📊', label: 'Dashboard', route: 'pro.dashboard' },
  { icon: '🛒', label: 'Mon Panier', route: 'cart.index' },
  { icon: '📦', label: 'Mes Commandes', route: 'dashboard.orders' },
  { icon: '👤', label: 'Mon Profil', route: 'dashboard.profile' },
  { icon: '�', label: 'Patients',  route: 'pro.patients'  },
  { icon: '🎯', label: 'Protocoles',route: 'pro.protocols' },
]

const isProActive = (r) => { try { return route().current(r) } catch { return false } }

const pageTitles = {
  'pro.dashboard': 'Dashboard',
  'pro.patients':  'Patients',
  'pro.protocols': 'Protocoles',
}
const currentPageTitle = computed(() => {
  for (const [r, title] of Object.entries(pageTitles)) {
    try { if (route().current(r)) return title } catch {}
  }
  return 'PRO'
})
</script>

<style scoped>
.pro-shell {
  display: flex;
  min-height: 100vh;
  background: #060f1e;
}

/* ─── Sidebar ─── */
.pro-sidebar {
  width: 230px;
  flex-shrink: 0;
  background: rgba(10,22,40,.95);
  border-right: 1px solid rgba(200,169,110,.12);
  display: flex;
  flex-direction: column;
  padding: 0;
  position: fixed;
  top: 0; left: 0; bottom: 0;
  z-index: 100;
  backdrop-filter: blur(20px);
}

.pro-logo {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 22px 20px 20px;
  border-bottom: 1px solid rgba(200,169,110,.08);
  text-decoration: none;
  margin-bottom: 8px;
}
.pro-logo-icon {
  width: 32px; height: 32px;
  background: linear-gradient(135deg, #c8a96e, #e8d5a3);
  border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  font-family: 'Cormorant Garamond', serif;
  font-size: 1rem; font-weight: 700;
  color: #0a1628;
}
.pro-logo-text {
  font-family: 'Cormorant Garamond', serif;
  font-size: .95rem; font-weight: 600;
  letter-spacing: .04em;
  color: #fff;
}
.pro-logo-text em { color: #c8a96e; font-style: normal; margin-left: 2px; }

.pro-nav {
  display: flex;
  flex-direction: column;
  gap: 2px;
  padding: 0 10px;
}
.pro-nav-item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 9px 12px;
  border-radius: 10px;
  font-size: .82rem;
  font-weight: 500;
  color: rgba(200,220,255,.5);
  text-decoration: none;
  transition: all .18s;
  position: relative;
}
.pro-nav-item:hover {
  background: rgba(200,169,110,.06);
  color: rgba(200,220,255,.85);
}
.pro-nav-item.active {
  background: rgba(200,169,110,.1);
  color: #c8a96e;
}
.pro-nav-icon { font-size: 1rem; width: 20px; text-align: center; }
.pro-nav-pip {
  width: 4px; height: 4px;
  border-radius: 50%;
  background: #c8a96e;
  margin-left: auto;
}

.pro-sidebar-spacer { flex: 1; }

.pro-user {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 14px 20px;
  border-top: 1px solid rgba(255,255,255,.05);
}
.pro-user-avatar {
  width: 32px; height: 32px;
  border-radius: 8px;
  background: linear-gradient(135deg, #0d7377, #14a8a0);
  display: flex; align-items: center; justify-content: center;
  font-size: .85rem; font-weight: 700; color: #fff;
  flex-shrink: 0;
}
.pro-user-name { font-size: .8rem; font-weight: 600; color: #fff; line-height: 1.2; }
.pro-user-role { font-size: .68rem; color: rgba(200,220,255,.35); margin-top: 1px; }

.pro-signout {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 10px 20px 14px;
  font-size: .75rem;
  color: rgba(200,220,255,.28);
  background: none;
  border: none;
  cursor: pointer;
  text-decoration: none;
  transition: color .2s;
  width: 100%;
}
.pro-signout:hover { color: #ef4444; }

/* ─── Main ─── */
.pro-main {
  flex: 1;
  margin-left: 230px;
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.pro-topbar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 14px 32px;
  background: rgba(10,22,40,.6);
  border-bottom: 1px solid rgba(255,255,255,.05);
  backdrop-filter: blur(10px);
  position: sticky;
  top: 0;
  z-index: 50;
}
.pro-topbar-left {
  display: flex;
  align-items: center;
  gap: 12px;
}
.pro-topbar-badge {
  font-size: .65rem;
  font-weight: 700;
  letter-spacing: .18em;
  text-transform: uppercase;
  padding: 3px 10px;
  border-radius: 100px;
  background: rgba(200,169,110,.12);
  border: 1px solid rgba(200,169,110,.25);
  color: #c8a96e;
}
.pro-topbar-page {
  font-size: .82rem;
  color: rgba(200,220,255,.5);
}

.pro-topbar-right { display: flex; gap: 8px; }
.pro-topbar-btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 6px 14px;
  border-radius: 8px;
  font-size: .75rem;
  font-weight: 500;
  background: rgba(13,115,119,.15);
  border: 1px solid rgba(13,115,119,.3);
  color: #14a8a0;
  text-decoration: none;
  transition: all .2s;
}
.pro-topbar-btn:hover { background: rgba(13,115,119,.3); }
.pro-topbar-btn--outline {
  background: rgba(255,255,255,.04);
  border-color: rgba(255,255,255,.1);
  color: rgba(200,220,255,.5);
}
.pro-topbar-btn--outline:hover { color: #fff; background: rgba(255,255,255,.08); }

.pro-content {
  flex: 1;
  padding: 32px;
  max-width: 1200px;
  width: 100%;
  margin: 0 auto;
}

@media (max-width: 768px) {
  .pro-sidebar { display: none; }
  .pro-main { margin-left: 0; }
}
</style>
