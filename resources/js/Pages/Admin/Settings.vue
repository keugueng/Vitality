<template>
  <AdminLayout>
    <div class="max-w-3xl">
      <h1 class="font-serif text-3xl font-light text-white mb-8">Settings</h1>
      <form @submit.prevent="submit" class="space-y-6">
        <div class="glass-card rounded-2xl p-6 space-y-4">
          <h2 class="text-white font-semibold text-sm mb-2">General</h2>
          <div v-for="key in generalKeys" :key="key.name">
            <label class="text-vitality-text text-xs mb-1.5 block">{{ key.label }}</label>
            <input v-model="form.settings[key.name]" :type="key.type || 'text'"
              class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-vitality-cyan/50"/>
          </div>
        </div>

        <div class="glass-card rounded-2xl p-6 space-y-4">
          <h2 class="text-white font-semibold text-sm mb-2">Stripe (Payments)</h2>
          <div>
            <label class="text-vitality-text text-xs mb-1.5 block">Stripe Publishable Key</label>
            <input v-model="form.settings['stripe_key']" type="text" placeholder="pk_live_…"
              class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-vitality-cyan/50 font-mono"/>
          </div>
        </div>

        <div class="glass-card rounded-2xl p-6 space-y-4">
          <h2 class="text-white font-semibold text-sm mb-2">Contact &amp; Social</h2>
          <div v-for="key in contactKeys" :key="key.name">
            <label class="text-vitality-text text-xs mb-1.5 block">{{ key.label }}</label>
            <input v-model="form.settings[key.name]" :type="key.type || 'text'"
              class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-vitality-cyan/50"/>
          </div>
        </div>

        <button type="submit" :disabled="form.processing" class="btn-cyan py-3 px-8 text-sm disabled:opacity-50">
          {{ form.processing ? 'Saving…' : 'Save Settings' }}
        </button>
      </form>
    </div>
  </AdminLayout>
</template>
<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps({ settings: Object })

const form = useForm({
  settings: {
    site_name: props.settings?.site_name?.value || 'Vitality Inside',
    contact_email: props.settings?.contact_email?.value || 'rosati.eric@gmail.com',
    stripe_key: props.settings?.stripe_key?.value || '',
    instagram_url: props.settings?.instagram_url?.value || 'https://www.instagram.com/health_vitalityinside/',
    facebook_url: props.settings?.facebook_url?.value || '',
    linkedin_url: props.settings?.linkedin_url?.value || '',
  }
})

const generalKeys = [
  { name: 'site_name',     label: 'Site Name' },
  { name: 'contact_email', label: 'Contact Email', type: 'email' },
]
const contactKeys = [
  { name: 'instagram_url', label: 'Instagram URL', type: 'url' },
  { name: 'facebook_url',  label: 'Facebook URL',  type: 'url' },
  { name: 'linkedin_url',  label: 'LinkedIn URL',  type: 'url' },
]

const submit = () => form.post(route('admin.settings.update'))
</script>
