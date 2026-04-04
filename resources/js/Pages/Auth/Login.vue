<template>
  <AuthLayout>
    <div class="auth-card">
      <h1 class="auth-title">{{ t('auth.login_title') }}</h1>
      <p class="auth-sub">{{ t('auth.login_sub') }}</p>

      <div v-if="errors.email" class="auth-error">{{ errors.email }}</div>

      <form @submit.prevent="submit" class="auth-form">
        <div class="field">
          <label class="field-label">{{ t('auth.email') }}</label>
          <input v-model="form.email" type="email" required autofocus
            class="field-input" placeholder="your@email.com" />
        </div>
        <div class="field">
          <label class="field-label">{{ t('auth.password') }}</label>
          <input v-model="form.password" type="password" required
            class="field-input" placeholder="••••••••" />
        </div>
        <div class="field-row">
          <label class="remember">
            <input v-model="form.remember" type="checkbox" />
            {{ t('auth.remember') }}
          </label>
          <Link :href="route('password.request')" class="forgot-link">{{ t('auth.forgot') }}</Link>
        </div>
        <button type="submit" :disabled="form.processing" class="auth-btn">
          {{ form.processing ? t('auth.login_btn_loading') : t('auth.login_btn') }}
        </button>
      </form>

      <p class="auth-alt">
        {{ t('auth.no_account') }} <Link :href="route('register')" class="auth-link">{{ t('auth.register_link') }}</Link>
      </p>
    </div>
  </AuthLayout>
</template>

<script setup>
import AuthLayout from '@/Layouts/AuthLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'
import { useI18n } from '@/composables/useI18n'
const { t } = useI18n()
defineProps({ errors: Object })
const form = useForm({ email: '', password: '', remember: false })
const submit = () => form.post(route('login'))
</script>

<style scoped>
.auth-card {
  background: rgba(13,31,58,.7);
  border: 1px solid rgba(200,169,110,.2);
  border-radius: 16px;
  padding: 40px 36px;
  backdrop-filter: blur(12px);
}
.auth-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.8rem;
  font-weight: 300;
  color: #fff;
  text-align: center;
  margin-bottom: 6px;
}
.auth-sub { font-size: .83rem; color: rgba(200,220,255,.45); text-align: center; margin-bottom: 28px; }
.auth-error { background: rgba(239,68,68,.1); border: 1px solid rgba(239,68,68,.3); border-radius: 8px; padding: 10px 14px; margin-bottom: 20px; font-size: .83rem; color: #f87171; }
.auth-form { display: flex; flex-direction: column; gap: 16px; }
.field { display: flex; flex-direction: column; gap: 6px; }
.field-label { font-size: .72rem; letter-spacing: .1em; text-transform: uppercase; color: rgba(200,220,255,.45); }
.field-input {
  background: rgba(255,255,255,.06);
  border: 1px solid rgba(255,255,255,.1);
  border-radius: 8px;
  padding: 12px 14px;
  color: #fff;
  font-size: .88rem;
  width: 100%;
  outline: none;
  transition: border-color .2s;
  font-family: inherit;
}
.field-input::placeholder { color: rgba(200,220,255,.2); }
.field-input:focus { border-color: rgba(13,115,119,.5); }
.field-row { display: flex; align-items: center; justify-content: space-between; font-size: .78rem; }
.remember { display: flex; align-items: center; gap: 7px; color: rgba(200,220,255,.45); cursor: pointer; }
.remember input { accent-color: #0d7377; }
.forgot-link { color: #14a8a0; text-decoration: none; font-size: .78rem; }
.forgot-link:hover { color: #c8a96e; }
.auth-btn {
  background: linear-gradient(135deg, #0d7377, #14a8a0);
  color: #fff;
  border: none;
  border-radius: 8px;
  padding: 13px;
  font-size: .88rem;
  font-weight: 500;
  letter-spacing: .04em;
  cursor: pointer;
  transition: opacity .2s, transform .2s;
  font-family: inherit;
  margin-top: 4px;
}
.auth-btn:hover:not(:disabled) { opacity: .9; transform: translateY(-1px); }
.auth-btn:disabled { opacity: .5; cursor: not-allowed; }
.auth-alt { text-align: center; font-size: .78rem; color: rgba(200,220,255,.35); margin-top: 20px; }
.auth-link { color: #14a8a0; text-decoration: none; }
.auth-link:hover { color: #c8a96e; }
</style>
