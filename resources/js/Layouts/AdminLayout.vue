<template>
  <div class="min-h-screen flex" style="background-color: #fdf2f4;">

    <!-- Sidebar -->
    <aside class="fixed left-0 top-0 bottom-0 z-40 flex flex-col" style="width: 220px; background-color: #2E1545;">

      <!-- Logo -->
      <div class="px-4 py-4" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
        <div class="flex items-center gap-2.5">
          <div class="w-9 h-9 rounded-xl flex items-center justify-center text-lg flex-shrink-0"
            style="background: rgba(255,255,255,0.15); backdrop-filter: blur(4px);">
            🌸
          </div>
          <div>
            <div class="font-bold text-sm leading-tight">
              <span style="color: #f9a8d4;">Fifty</span><span style="color: white;">Care</span>
            </div>
            <div class="tracking-widest uppercase" style="color: rgba(255,255,255,0.45); font-size: 9px;">ADMIN V2.0</div>
          </div>
        </div>
      </div>

      <!-- Nav -->
      <nav class="flex-1 py-3 px-2 overflow-y-auto space-y-0.5">

        <!-- VUE D'ENSEMBLE -->
        <SectionLabel label="Vue d'ensemble" />
        <NavItem :href="route('admin.dashboard')" :active="route().current('admin.dashboard')" icon="📊" label="Dashboard" />
        <NavItem :href="route('admin.analytics')" :active="route().current('admin.analytics')" icon="📈" label="Analytiques" />

        <!-- CONTENU -->
        <SectionLabel label="Contenu" />
        <NavItem :href="route('admin.programs')" :active="route().current('admin.programs')" icon="🎧" label="Protocoles" />
        <NavItem :href="route('admin.audio')" :active="route().current('admin.audio')" icon="🎵" label="Fichiers Audio" />
        <NavItem :href="route('admin.blog')" :active="route().current('admin.blog')" icon="✏️" label="Textes & Contenu" />
        <div class="relative">
          <NavItem :href="route('admin.notifications')" :active="route().current('admin.notifications')" icon="🔔" label="Notifications" />
          <span class="absolute right-2 top-1.5 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-bold"
            style="background-color: #ec4899; font-size: 9px;">3</span>
        </div>

        <!-- UTILISATEURS -->
        <SectionLabel label="Utilisateurs" />
        <NavItem :href="route('admin.users')" :active="route().current('admin.users')" icon="👥" label="Gestion Clients" />
        <NavItem :href="route('admin.subscriptions')" :active="route().current('admin.subscriptions')" icon="💎" label="Abonnements" />
        <NavItem :href="route('admin.symptom-stats')" :active="route().current('admin.symptom-stats')" icon="📊" label="Stats Symptômes" />

        <!-- FINANCE -->
        <SectionLabel label="Finance" />
        <NavItem :href="route('admin.orders')" :active="route().current('admin.orders')" icon="💰" label="Revenus" />
        <NavItem :href="route('admin.pricing')" :active="route().current('admin.pricing')" icon="🏷️" label="Tarification" />

        <!-- PARAMÈTRES -->
        <SectionLabel label="Paramètres" />
        <NavItem :href="route('admin.settings')" :active="route().current('admin.settings')" icon="⚙️" label="Paramètres App" />
        <NavItem :href="route('admin.admins')" :active="route().current('admin.admins')" icon="🔒" label="Administrateurs" />

      </nav>

      <!-- User profile -->
      <div class="px-3 py-3 border-t border-white/5 flex items-center gap-2">
        <div class="w-8 h-8 rounded-full flex items-center justify-center text-white font-bold text-xs flex-shrink-0"
          style="background-color: #7c3aed;">
          {{ userInitials }}
        </div>
        <div class="flex-1 min-w-0">
          <p class="text-white text-xs font-medium truncate">{{ userName }}</p>
          <p class="text-xs truncate" style="color: rgba(255,255,255,0.45); font-size: 10px;">{{ userEmail || 'Super Admin' }}</p>
        </div>
        <Link :href="route('home')" class="transition-colors text-xs flex-shrink-0" style="color: rgba(255,255,255,0.35);" title="Voir le site">◀</Link>
      </div>

    </aside>

    <!-- Main area -->
    <main class="flex-1 min-h-screen flex flex-col" style="margin-left: 220px;">
      <div v-if="$page.props.flash?.success" class="mx-8 mt-4 bg-green-50 border border-green-200 rounded-xl px-4 py-3 text-green-700 text-sm">
        ✓ {{ $page.props.flash.success }}
      </div>
      <div v-if="$page.props.flash?.error" class="mx-8 mt-4 bg-red-50 border border-red-200 rounded-xl px-4 py-3 text-red-600 text-sm">
        ✕ {{ $page.props.flash.error }}
      </div>
      <slot />
    </main>

  </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { computed, defineComponent, h } from 'vue'

const page = usePage()
const userName  = computed(() => page.props.auth?.user?.name || 'Éric Durand')
const userEmail = computed(() => page.props.auth?.user?.email || '')

// Skip honorific prefixes (Dr., Mr., Mme., etc.) when building initials
const userInitials = computed(() => {
  const honorifics = ['dr', 'mr', 'mrs', 'ms', 'mme', 'pr', 'prof']
  const parts = userName.value.trim().split(/\s+/).filter(
    w => !honorifics.includes(w.replace(/\./g, '').toLowerCase())
  )
  return parts.slice(0, 2).map(w => w[0].toUpperCase()).join('')
})

// Sub-components defined inline
const NavItem = defineComponent({
  props: { href: String, active: Boolean, icon: String, label: String },
  setup(props) {
    return () => h(
      props.href?.startsWith('http') || props.href === '#' ? 'a' : Link,
      {
        href: props.href,
        class: [
          'flex items-center gap-2 px-2.5 py-2 rounded-lg text-xs transition-all font-medium w-full',
          props.active ? 'text-white' : 'hover:bg-white/5',
        ],
        style: props.active
          ? 'background-color: rgba(255,255,255,0.15); color: white;'
          : 'color: rgba(255,255,255,0.65);',
      },
      [
        h('span', { class: 'text-sm w-4 text-center flex-shrink-0' }, props.icon),
        h('span', { class: 'truncate' }, props.label),
      ]
    )
  },
})

const SectionLabel = defineComponent({
  props: { label: String },
  setup(props) {
    return () => h('p', {
      class: 'text-xs uppercase tracking-widest px-2.5 pt-3 pb-1 font-semibold',
      style: 'color: rgba(255,255,255,0.38); font-size: 9px;',
    }, props.label)
  },
})
</script>
