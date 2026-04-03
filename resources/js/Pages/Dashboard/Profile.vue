<template>
  <DashboardLayout>
    <div class="max-w-2xl">
      <h1 class="font-serif text-3xl font-light text-white mb-8">My Profile</h1>
      <div class="glass-card rounded-2xl p-8 border-glow">
        <form @submit.prevent="submit" class="space-y-5">
          <div>
            <label class="text-vitality-text text-xs mb-1.5 block">Full Name</label>
            <input v-model="form.name" type="text" required
              class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-vitality-cyan/50"/>
          </div>
          <div>
            <label class="text-vitality-text text-xs mb-1.5 block">Email</label>
            <input :value="user.email" type="email" disabled
              class="w-full bg-vitality-blue/20 border border-white/5 rounded-xl px-4 py-3 text-vitality-text text-sm cursor-not-allowed"/>
          </div>
          <div>
            <label class="text-vitality-text text-xs mb-1.5 block">Phone</label>
            <input v-model="form.phone" type="tel"
              class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-vitality-cyan/50"
              placeholder="+33 6 00 00 00 00"/>
          </div>
          <button type="submit" :disabled="form.processing" class="btn-cyan py-3 text-sm disabled:opacity-50">
            {{ form.processing ? 'Saving…' : 'Save Changes' }}
          </button>
        </form>
      </div>
    </div>
  </DashboardLayout>
</template>
<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import { useForm } from '@inertiajs/vue3'
const props = defineProps({ user: Object })
const form = useForm({ name: props.user.name, phone: props.user.phone || '' })
const submit = () => form.put(route('dashboard.profile.update'))
</script>
