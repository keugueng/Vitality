<template>
  <div class="auth-wrap">
    <div class="auth-bg"></div>
    <div class="auth-container">
      <div class="auth-logo-wrap">
        <Link :href="route('home')" class="auth-logo">Vitality Inside</Link>
        <p class="auth-logo-sub">Bio-Energy Frequency Therapy</p>
      </div>
      <slot />
      <p class="auth-foot">© {{ year }} Vitality Inside · All rights reserved.</p>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
const year = new Date().getFullYear()
</script>

<style scoped>
.auth-wrap {
  min-height: 100vh;
  background: #0a1628;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 40px 20px;
  position: relative;
  overflow: hidden;
}
.auth-bg {
  position: fixed;
  inset: 0;
  background:
    radial-gradient(ellipse 60% 50% at 50% 20%, rgba(13,115,119,.14) 0%, transparent 65%),
    radial-gradient(ellipse 40% 40% at 80% 80%, rgba(200,169,110,.06) 0%, transparent 60%);
  pointer-events: none;
}
.auth-container {
  position: relative;
  z-index: 10;
  width: 100%;
  max-width: 440px;
}
.auth-logo-wrap { text-align: center; margin-bottom: 32px; }
.auth-logo {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.8rem;
  font-weight: 600;
  letter-spacing: .08em;
  color: #c8a96e;
  text-decoration: none;
  display: block;
  margin-bottom: 4px;
  transition: opacity .2s;
}
.auth-logo:hover { opacity: .8; }
.auth-logo-sub {
  font-size: .7rem;
  letter-spacing: .16em;
  text-transform: uppercase;
  color: rgba(200,220,255,.3);
}
.auth-foot {
  text-align: center;
  font-size: .72rem;
  color: rgba(200,220,255,.2);
  margin-top: 24px;
}
</style>
