<template>
  <AuthLayout>
    <div class="auth-card">
      <h1 class="auth-title">Reset Password</h1>
      <p class="auth-sub">Enter your email to receive a reset link.</p>
      <form class="auth-form">
        <div class="field">
          <label class="field-label">Email</label>
          <input type="email" required class="field-input" placeholder="your@email.com" />
        </div>
        <button type="submit" class="auth-btn">Send Reset Link</button>
      </form>
      <p class="auth-alt">
        <Link :href="route('login')" class="auth-link">← Back to login</Link>
      </p>
    </div>
  </AuthLayout>
</template>

<script setup>
import AuthLayout from '@/Layouts/AuthLayout.vue'
import { Link } from '@inertiajs/vue3'
</script>

<style scoped>
.auth-card { background: rgba(13,31,58,.7); border: 1px solid rgba(200,169,110,.2); border-radius: 16px; padding: 40px 36px; backdrop-filter: blur(12px); }
.auth-title { font-family: 'Cormorant Garamond', serif; font-size: 1.8rem; font-weight: 300; color: #fff; text-align: center; margin-bottom: 6px; }
.auth-sub { font-size: .83rem; color: rgba(200,220,255,.45); text-align: center; margin-bottom: 28px; }
.auth-form { display: flex; flex-direction: column; gap: 16px; }
.field { display: flex; flex-direction: column; gap: 6px; }
.field-label { font-size: .72rem; letter-spacing: .1em; text-transform: uppercase; color: rgba(200,220,255,.45); }
.field-input { background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.1); border-radius: 8px; padding: 12px 14px; color: #fff; font-size: .88rem; width: 100%; outline: none; transition: border-color .2s; font-family: inherit; }
.field-input::placeholder { color: rgba(200,220,255,.2); }
.field-input:focus { border-color: rgba(13,115,119,.5); }
.auth-btn { background: linear-gradient(135deg, #0d7377, #14a8a0); color: #fff; border: none; border-radius: 8px; padding: 13px; font-size: .88rem; font-weight: 500; letter-spacing: .04em; cursor: pointer; transition: opacity .2s; font-family: inherit; }
.auth-btn:hover { opacity: .9; }
.auth-alt { text-align: center; font-size: .78rem; color: rgba(200,220,255,.35); margin-top: 20px; }
.auth-link { color: #14a8a0; text-decoration: none; }
.auth-link:hover { color: #c8a96e; }
</style>
