<template>
  <AuthLayout>
    <div class="glass-card rounded-3xl p-8 border-glow">
      <h1 class="font-serif text-2xl font-light text-white text-center mb-2">Create account</h1>
      <p class="text-vitality-text text-sm text-center mb-8">Join 21,000+ Vitality Inside users</p>

      <form @submit.prevent="submit" class="space-y-4">
        <div>
          <label class="text-vitality-text text-xs mb-1.5 block">Full Name</label>
          <input v-model="form.name" type="text" required autofocus
            class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-vitality-cyan/50 placeholder-vitality-text/40"
            placeholder="Your full name" />
          <p v-if="form.errors.name" class="text-red-400 text-xs mt-1">{{ form.errors.name }}</p>
        </div>
        <div>
          <label class="text-vitality-text text-xs mb-1.5 block">Email</label>
          <input v-model="form.email" type="email" required
            class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-vitality-cyan/50 placeholder-vitality-text/40"
            placeholder="your@email.com" />
          <p v-if="form.errors.email" class="text-red-400 text-xs mt-1">{{ form.errors.email }}</p>
        </div>
        <div>
          <label class="text-vitality-text text-xs mb-1.5 block">Password</label>
          <input v-model="form.password" type="password" required
            class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-vitality-cyan/50 placeholder-vitality-text/40"
            placeholder="Min. 8 characters" />
          <p v-if="form.errors.password" class="text-red-400 text-xs mt-1">{{ form.errors.password }}</p>
        </div>
        <div>
          <label class="text-vitality-text text-xs mb-1.5 block">Confirm Password</label>
          <input v-model="form.password_confirmation" type="password" required
            class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-vitality-cyan/50 placeholder-vitality-text/40"
            placeholder="Repeat password" />
        </div>
        <button type="submit" :disabled="form.processing" class="btn-cyan w-full py-3 text-sm disabled:opacity-50">
          {{ form.processing ? 'Creating account…' : 'Create Account' }}
        </button>
      </form>

      <p class="text-center text-vitality-text text-xs mt-6">
        Already have an account? <Link :href="route('login')" class="text-vitality-cyan hover:underline">Sign in</Link>
      </p>
    </div>
  </AuthLayout>
</template>

<script setup>
import AuthLayout from '@/Layouts/AuthLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'
const form = useForm({ name: '', email: '', password: '', password_confirmation: '' })
const submit = () => form.post(route('register'))
</script>
