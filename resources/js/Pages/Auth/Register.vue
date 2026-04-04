<template>
  <AuthLayout>
    <div class="auth-card">
      <h1 class="auth-title">Create account</h1>
      <p class="auth-sub">Join 21,000+ Vitality Inside users</p>

      <form @submit.prevent="submit" class="auth-form">
        <div class="field">
          <label class="field-label">Full Name</label>
          <input v-model="form.name" type="text" required autofocus class="field-input" placeholder="Your full name" />
          <p v-if="form.errors.name" class="field-error">{{ form.errors.name }}</p>
        </div>
        <div class="field">
          <label class="field-label">Email</label>
          <input v-model="form.email" type="email" required class="field-input" placeholder="your@email.com" />
          <p v-if="form.errors.email" class="field-error">{{ form.errors.email }}</p>
        </div>
        <div class="field">
          <label class="field-label">Password</label>
          <input v-model="form.password" type="password" required class="field-input" placeholder="Min. 8 characters" />
          <p v-if="form.errors.password" class="field-error">{{ form.errors.password }}</p>
        </div>
        <div class="field">
          <label class="field-label">Confirm Password</label>
          <input v-model="form.password_confirmation" type="password" required class="field-input" placeholder="Repeat password" />
        </div>
        <button type="submit" :disabled="form.processing" class="auth-btn">
          {{ form.processing ? 'Creating account…' : 'Create Account' }}
        </button>
      </form>

      <p class="auth-alt">
        Already have an account? <Link :href="route('login')" class="auth-link">Sign in</Link>
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

<style scoped>
.auth-card { background: rgba(13,31,58,.7); border: 1px solid rgba(200,169,110,.2); border-radius: 16px; padding: 40px 36px; backdrop-filter: blur(12px); }
.auth-title { font-family: 'Cormorant Garamond', serif; font-size: 1.8rem; font-weight: 300; color: #fff; text-align: center; margin-bottom: 6px; }
.auth-sub { font-size: .83rem; color: rgba(200,220,255,.45); text-align: center; margin-bottom: 28px; }
.auth-form { display: flex; flex-direction: column; gap: 14px; }
.field { display: flex; flex-direction: column; gap: 6px; }
.field-label { font-size: .72rem; letter-spacing: .1em; text-transform: uppercase; color: rgba(200,220,255,.45); }
.field-input { background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.1); border-radius: 8px; padding: 12px 14px; color: #fff; font-size: .88rem; width: 100%; outline: none; transition: border-color .2s; font-family: inherit; }
.field-input::placeholder { color: rgba(200,220,255,.2); }
.field-input:focus { border-color: rgba(13,115,119,.5); }
.field-error { font-size: .75rem; color: #f87171; margin-top: 2px; }
.auth-btn { background: linear-gradient(135deg, #0d7377, #14a8a0); color: #fff; border: none; border-radius: 8px; padding: 13px; font-size: .88rem; font-weight: 500; letter-spacing: .04em; cursor: pointer; transition: opacity .2s, transform .2s; font-family: inherit; margin-top: 4px; }
.auth-btn:hover:not(:disabled) { opacity: .9; transform: translateY(-1px); }
.auth-btn:disabled { opacity: .5; cursor: not-allowed; }
.auth-alt { text-align: center; font-size: .78rem; color: rgba(200,220,255,.35); margin-top: 20px; }
.auth-link { color: #14a8a0; text-decoration: none; }
.auth-link:hover { color: #c8a96e; }
</style>
