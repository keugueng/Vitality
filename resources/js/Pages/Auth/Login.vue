<template>
  <AuthLayout>
    <div class="glass-card rounded-3xl p-8 border-glow">
      <h1 class="font-serif text-2xl font-light text-white text-center mb-2">Welcome back</h1>
      <p class="text-vitality-text text-sm text-center mb-8">Sign in to your Vitality Inside account</p>

      <div v-if="errors.email" class="bg-red-500/10 border border-red-500/30 rounded-xl p-3 mb-5 text-red-400 text-sm">
        {{ errors.email }}
      </div>

      <form @submit.prevent="submit" class="space-y-4">
        <div>
          <label class="text-vitality-text text-xs mb-1.5 block">Email</label>
          <input v-model="form.email" type="email" required autofocus
            class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-vitality-cyan/50 placeholder-vitality-text/40"
            placeholder="your@email.com" />
        </div>
        <div>
          <label class="text-vitality-text text-xs mb-1.5 block">Password</label>
          <input v-model="form.password" type="password" required
            class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-vitality-cyan/50 placeholder-vitality-text/40"
            placeholder="••••••••" />
        </div>
        <div class="flex items-center justify-between text-xs">
          <label class="flex items-center gap-2 text-vitality-text cursor-pointer">
            <input v-model="form.remember" type="checkbox" class="rounded"/>
            Remember me
          </label>
          <Link :href="route('password.request')" class="text-vitality-cyan hover:underline">Forgot password?</Link>
        </div>
        <button type="submit" :disabled="form.processing" class="btn-cyan w-full py-3 text-sm disabled:opacity-50">
          {{ form.processing ? 'Signing in…' : 'Sign In' }}
        </button>
      </form>

      <p class="text-center text-vitality-text text-xs mt-6">
        No account? <Link :href="route('register')" class="text-vitality-cyan hover:underline">Create one free</Link>
      </p>
    </div>
  </AuthLayout>
</template>

<script setup>
import AuthLayout from '@/Layouts/AuthLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'
defineProps({ errors: Object })
const form = useForm({ email: '', password: '', remember: false })
const submit = () => form.post(route('login'))
</script>
