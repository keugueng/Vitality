<template>
  <AuthLayout>
    <div class="glass-card rounded-3xl p-8 border-glow">
      <h1 class="font-serif text-2xl font-light text-white text-center mb-2">Reset Password</h1>
      <p class="text-vitality-text text-sm text-center mb-8">Enter your email to receive a reset link.</p>
      <form class="space-y-4">
        <div>
          <label class="text-vitality-text text-xs mb-1.5 block">Email</label>
          <input type="email" required
            class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-vitality-cyan/50 placeholder-vitality-text/40"
            placeholder="your@email.com" />
        </div>
        <button type="submit" class="btn-cyan w-full py-3 text-sm">Send Reset Link</button>
      </form>
      <p class="text-center text-vitality-text text-xs mt-6">
        <Link :href="route('login')" class="text-vitality-cyan hover:underline">← Back to login</Link>
      </p>
    </div>
  </AuthLayout>
</template>
<script setup>
import AuthLayout from '@/Layouts/AuthLayout.vue'
import { Link } from '@inertiajs/vue3'
</script>
